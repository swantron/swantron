---
title: 'minifier-cli: Shrink Any Docker Image Without Touching Its Dockerfile'
date: 2026-06-01T00:00:00+00:00
slug: 'minifier-cli'
description: "A Go tool born out of product security vuln noise on third-party images we run but don't own — observes runtime file access, rebuilds from scratch with only what's needed."
featured_image: '/uploads/2026/06/minifier-cli-terminal.png'
---

We've been getting flagged a lot by our product security team. Vulns on images across our various namespaces, some of them looking pretty gnarly on paper. The kind of thing that shows up in a dashboard and generates tickets.

The catch: most of those images aren't ours. We're on DevX, which sits inside CloudOps alongside Platform Engineering, SRE, and Cloud Cost — and a big part of what that org does is run the infrastructure that makes the clusters work. Wiz, Datadog agents, observability tooling. Closed source, proprietary, not ours to rebuild. But they live in our namespaces, so we own the vuln count.

Another engineer and I started talking about what you'd actually do about this. You can't patch a binary you don't ship. You can't swap the base image. The vendor updates when they update. The realistic options are: accept the noise, get exceptions granted, or get creative.

Getting creative meant asking: what if we just... cut the parts that aren't running?

## The Idea

A typical third-party agent image is built for maximum compatibility. It's got shells, package managers, debug utilities, locale files, man pages, and a bunch of shared libraries for features nobody in your environment uses. All of that adds up to hundreds of megabytes, and from a security scanner's perspective, every one of those binaries is an attack surface.

So we asked the obvious question: what does the container actually touch at runtime?

If you can answer that, you can rebuild the image from scratch with only those files. The binary still runs. The agent still phones home. But the shell that would give an attacker a foothold is gone. So is the package manager. So is most of the attack surface the scanner was complaining about.

## What I Built

**[minifier-cli](https://github.com/swantron/minifier-cli)** is a Go tool that does exactly this. Three steps:

**1. Trace.** You run your container through the tool and it watches which files the process actually opens and maps into memory — polling `/proc/*/fd` and `/proc/*/maps` inside the container every second. Everything that gets touched ends up in a log.

```bash
minifier-cli trace start --image datadog/agent:latest --name dd-prod
# Let it run in a production-like environment
# Ctrl+C to stop tracing
```

**2. Analyze.** The trace log is a list of paths. Before rebuilding anything, the tool parses every ELF binary in that list using Go's `debug/elf` package — finding every shared library it imports, extracting the dynamic linker via PT_INTERP, and recursively resolving the full dependency tree. It also injects a small safelist of files everything needs (passwd, group, hosts, resolv.conf) that processes may not explicitly open but rely on being there.

```bash
# nothing to run manually — analysis happens automatically as part of repackage
```

**3. Repackage.**

```bash
minifier-cli repackage --name dd-prod --output datadog-minimal:prod
```

The tool extracts Docker metadata from the original image (ENV, CMD, ENTRYPOINT, EXPOSE, all of it), copies only the traced files via `docker export` tar streaming, generates a `FROM scratch` Dockerfile, and builds the result. No manual file selection, no guessing, no rebuilding from source.

nginx:alpine goes from 91.7MB to 14.1MB. In testing, Datadog's agent went from 1.2GB to around 150MB. The attack surface shrinks proportionally — and the vuln scanner suddenly has a lot less to say.

![minifier-cli terminal output: trace, repackage, and docker images before and after](/uploads/2026/06/minifier-cli-terminal.png)

## How It Ended Up

We eventually landed on a different solution for the actual hardening problem — something more off-the-shelf, lower overhead, and frankly easier to justify to the security team than a custom tool. Less culpable, as one of us put it.

But this approach holds up. The pattern is legitimate, the implementation works, and as a way to discover exactly what a black-box container actually needs at runtime, it's genuinely useful — for hardening, for compliance audits, for understanding legacy applications you're about to migrate, for cutting CI pull times.

It took a real problem to push me to actually build it. Open-sourcing it now on the theory that someone else has the same problem.

## The Catch

Your minified image contains exactly what was accessed during the trace — nothing more. That's the point, but it's also the risk.

Error-handling code that only fires under specific conditions won't get traced during a happy-path run. Plugins loaded by name at runtime won't show up unless that feature was exercised. A database driver that only activates for a certain config flag won't be there if you didn't trigger that path.

The playbook: run your full integration test suite while tracing. Hit every feature flag. Trigger error states. If the application has a warm-up or health-check mode, run those too. The more representative your trace workload, the more complete the image.

Then validate the minified image thoroughly in staging before it goes anywhere near production. Keep the original around as a fallback. Don't ship it on the strength of a five-minute trace and a `curl localhost`.

## Get It

```bash
git clone https://github.com/swantron/minifier-cli
cd minifier-cli
go build -o minifier-cli .
```

Pre-built binaries for Linux amd64/arm64 and macOS amd64/arm64 on the [releases page](https://github.com/swantron/minifier-cli/releases). The tracer requires Linux (it reads `/proc` inside the container), but the repackager runs fine on macOS against a remote Docker daemon.

Source: [github.com/swantron/minifier-cli](https://github.com/swantron/minifier-cli)
