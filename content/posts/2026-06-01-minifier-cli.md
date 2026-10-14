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

A typical third-party agent image is built for maximum compatibility. Shells, package managers, debug utilities, man pages, and a pile of shared libraries for features nobody in your environment uses. Hundreds of megabytes, and every one of those binaries is something for the scanner to yell about.

Rebuild the image from scratch with only the files the container actually touches at runtime, and the agent still pongs.. but the shell is gone. So is the package manager. So is most of what the scanner was complaining about.

## So I Built Something

**[minifier-cli](https://github.com/swantron/minifier-cli)** is a Go tool that does exactly this.

**1. Trace.** Run your container through the tool and it watches which files the process opens and maps into memory, polling `/proc` inside the container every second.

```bash
minifier-cli trace start --image datadog/agent:latest --name dd-prod
# Let it run in a production-like environment
# Ctrl+C to stop tracing
```

**2. Repackage.** It walks every binary in the trace for the shared libraries it needs, adds the handful of files everything quietly relies on (passwd, hosts, resolv.conf), copies it all out, and builds a `FROM scratch` image with the original ENV, CMD, and ENTRYPOINT.

```bash
minifier-cli repackage --name dd-prod --output datadog-minimal:prod
```

nginx:alpine goes from 91.7MB to 14.1MB. A startup-only trace of `datadog/agent:latest` takes it from 1.17GB to 59MB. The vuln scanner suddenly has a lot less to say.

![minifier-cli terminal output: trace, repackage, and docker images before and after](/uploads/2026/06/minifier-cli-terminal.png)

## How It Ended Up

We eventually landed on a different solution for the actual hardening problem.. we are basically buying pre-hardened images that someone else has already performed surgery on. With vendor backing and security buy-off, we are somewhat less culpable.

Still, it's a handy way to find out what a black-box container actually needs at runtime.. for hardening, audits, or poking at a legacy app before you migrate it. Open-sourcing it on the theory that someone else has the same problem.

The catch: the image only has what got touched during the trace. Error paths, plugins, and config-flag-only drivers won't be there unless you exercised them. Run your integration tests while tracing, trigger your error states, test it in staging, and keep the original around. Don't ship it on the strength of a five-minute trace and a `curl localhost`.

Binaries on the [releases page](https://github.com/swantron/minifier-cli/releases). The tracer needs Linux; the repackager runs fine on a Mac.

Source: [github.com/swantron/minifier-cli](https://github.com/swantron/minifier-cli)
