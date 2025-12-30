---
title: 'Secure Base Images for Docker'
date: 2025-12-30T04:45:00+00:00
slug: 'secure-base-images'
description: 'A minimal, security-hardened Docker base image for Go binaries'
featured_image: '/uploads/2025/12/secure-base-ci-workflow.png'
---

I built a thing: [secure-base-images](https://github.com/swantron/secure-base-images). It's a minimal, security-hardened Docker base image for static Go binaries.

![CI workflow running tests and build](/uploads/2025/12/secure-base-ci-workflow.png)

## The Problem

Most Docker images are bloated. They include shells, package managers, and a ton of dependencies you don't need. This creates a huge attack surface and slows down deployments. For statically-compiled Go binaries, you literally just need the binary and some CA certificates.

## The Solution

A distroless base image that gives you:

- **Zero vulnerabilities** - Automated Trivy security scanning catches CRITICAL/HIGH issues
- **Minimal attack surface** - No shell, no package manager, just your binary
- **Non-root execution** - Runs as uid 65532 by default
- **Fast builds** - Multi-platform support (amd64/arm64) via GitHub Actions
- **Dead simple** - Three lines in your Dockerfile

## Usage

```dockerfile
FROM swantron/secure-base:latest
COPY myapp /app
ENTRYPOINT ["/app"]
```

That's it. Push a tag, GitHub Actions builds it, scans it with Trivy, and publishes to Docker Hub if it's clean.

![Clean Trivy scan - zero vulnerabilities](/uploads/2025/12/secure-base-trivy-scan.png)

## Under the Hood

The GitHub Actions workflow is doing the heavy lifting:

1. Runs integration tests (non-root user, no shell, CA certs present, etc.)
2. Builds the image
3. Scans with Trivy - build **fails** if vulnerabilities found
4. Multi-platform build (amd64/arm64)
5. Pushes to Docker Hub on release tags

It's opinionated but in a good way. Security by default.

![Published to Docker Hub with latest and version tags](/uploads/2025/12/secure-base-dockerhub.png)

## Get It

Source: [https://github.com/swantron/secure-base-images](https://github.com/swantron/secure-base-images)

Docker Hub: `swantron/secure-base:latest`

The [QUICKSTART.md](https://github.com/swantron/secure-base-images/blob/main/QUICKSTART.md) gets you from zero to published in about 10 minutes.
