---
title: 'Shrinking third-party containers without touching a Dockerfile'
date: 2026-06-01T00:00:00+00:00
slug: 'minifier-cli'
description: "A Go tool born out of ProdSec vuln noise on third-party images we run on k8s but don't own.. observes runtime file access, rebuilds from scratch with only what's needed."
featured_image: '/uploads/2026/06/minifier-cli-terminal.png'
---

Our ProdSec team at work recently leaned hard into Wiz and Slack-ops. Vulnerabilities started piling up across our various namespaces, a lot of them flagged critical on paper.. typical enterprise scenario where dashboards are red and every alert demands a response.

The catch: most of those images aren't ours. We're DevX, which sits inside CloudOps alongside Platform Engineering, SRE, and Cloud Cost.. a big part of what our org does is run the infrastructure that makes the clusters work. Wiz, Datadog agents, observability tooling, a bunch of GitOps stuff. Closed source, proprietary, not ours to rebuild. But they live in our namespaces, so we own the vuln count.  Same for anything legacy or shared.. that comes as well.

Coworker bud and I started talking about what you'd actually do about this. You can't patch a binary you don't ship. You can't swap the base image. The vendor updates when they update. The realistic options are: accept the noise, get exceptions granted, or get creative.

Moment of clarity: what if we just... axe the parts that aren't running?

## Trace What's Actually Used

A typical third-party agent image is built for maximum compatibility. It's got shells, package managers, debug utilities, junk, man pages, and a bunch of shared libraries for features nobody in your environment uses. All of that adds up to hundreds of megabytes, and from a security scanner's perspective, every one of those binaries is an attack surface.

Rebuild the image from scratch with only the files the container actually touches at runtime, and the binary still runs, the agent still pongs.. but the shell that would give an attacker a foothold is gone. So is the package manager. So is most of the attack surface the scanner was complaining about.

## So I Built Something

**[minifier-cli](https://github.com/swantron/minifier-cli)** is a Go tool that does exactly this. Three steps:

**1. Trace.** You run your container through the tool and it watches which files the process actually opens and maps into memory.. polling `/proc/*/fd` and `/proc/*/maps` inside the container every second. Everything that gets touched ends up in a log. This isn't a real-time kernel stream, so a process that spawns, opens a file, and dies in under a second could theoretically be missed. In practice, that's rarely an issue for the long-running agent processes this tool is designed for.. and the ELF dependency pass in the next step catches the shared libs anyway.

```bash
minifier-cli trace start --image datadog/agent:latest --name dd-prod
# Let it run in a production-like environment
# Ctrl+C to stop tracing
```

**2. Analyze** *(internal phase.. no command to run).* Before rebuilding, the tool parses every ELF binary in the trace log using Go's `debug/elf` package.. finding every shared library it imports, extracting the dynamic linker via PT_INTERP, and recursively resolving the full dependency tree. It also injects a safelist of files everything needs (passwd, group, hosts, resolv.conf) that processes rely on without explicitly opening. This analysis runs automatically inside the repackage step.

**3. Repackage.**

```bash
minifier-cli repackage --name dd-prod --output datadog-minimal:prod
```

The tool extracts Docker metadata from the original image (ENV, CMD, ENTRYPOINT, EXPOSE), copies the traced files via `docker export` tar streaming, generates a `FROM scratch` Dockerfile, and builds the final image. No manual file selection, no guessing, no rebuilding from source.

nginx:alpine goes from 91.7MB to 14.1MB. A startup-only trace of `datadog/agent:latest` (1.17GB) produces a 59MB image.. and a longer, more thorough trace exercising all the agent features would land somewhere larger but still a fraction of the original. The attack surface shrinks proportionally.. and the vuln scanner suddenly has a lot less to say.

![minifier-cli terminal output: trace, repackage, and docker images before and after](/uploads/2026/06/minifier-cli-terminal.png)

## How It Ended Up

We eventually landed on a different solution for the actual hardening problem.. we are basically buying pre-hardened images that someone else has already performed surgery on. With vendor backing and security buy-off, we are somewhat less culpable.

But this approach holds up. The pattern is legitimate, the implementation works, and as a way to discover exactly what a black-box container actually needs at runtime, it's genuinely useful.. for hardening, for compliance audits, for understanding legacy applications you're about to migrate, for cutting CI pull times.

It took a real problem to push me to actually build it. Open-sourcing it now on the theory that someone else has the same problem.

## The Catch

Your minified image contains exactly what was accessed during the trace.. nothing more. That's the point, but it's also the risk.

Error-handling code that only fires under specific conditions won't get traced during a happy-path run. Plugins loaded by name at runtime won't show up unless that feature was exercised. A database driver that only activates for a certain config flag won't be there if you didn't trigger that path. And if your agent only calls out to a third-party webhook when a network timeout occurs, the lib handling that request won't be in your minified image unless you deliberately induced a timeout during the trace.

The playbook: run your full integration test suite while tracing. Write your integration test suite if you don't have one. Hit your feature flags. Trigger your error states. If the application has a warm-up or health-check mode, run those too. The more representative your trace workload, the more complete the image.

Then validate the minified image thoroughly in staging before it goes anywhere near production. Keep the original around as a fallback. Normal SRE stuff. Don't ship it on the strength of a five-minute trace and a `curl localhost`.

## Enjoy

```bash
git clone https://github.com/swantron/minifier-cli
cd minifier-cli
go build -o minifier-cli .
```

Pre-built binaries for Linux amd64/arm64 and macOS amd64/arm64 on the [releases page](https://github.com/swantron/minifier-cli/releases). The tracer requires Linux (it reads `/proc` inside the container), but the repackager runs fine on macOS against a remote Docker daemon.

Source: [github.com/swantron/minifier-cli](https://github.com/swantron/minifier-cli)
