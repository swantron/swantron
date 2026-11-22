---
id: 1004
title: 'Secure Base Images for Docker'
date: 2025-11-30T04:45:00+00:00
slug: 'secure-base-images'
description: 'A minimal, security-hardened Docker base image for Go binaries'
featured_image: '/uploads/2025/11/secure-base-ci-workflow.png'
aliases:
  - '/index.php/2025/11/30/secure-base-images/'
---

Do you hate insecure base images?  Sure, we all do..

I built a thing: [secure-base-images](https://github.com/swantron/secure-base-images). It's a minimal, security-hardened Docker base image for static Go binaries.

![CI workflow running tests and build](/uploads/2025/11/secure-base-ci-workflow.png)

Most Docker images are bloated. Shells, package managers, and a ton of dependencies you don't need. That's attack surface your security team loves to talk about, and it drives fast pipeline guys like me insane. For a static Go tool you literally just need the binary and some certs.

So this one is the binary and some certs. No shell, no package manager, runs as uid 65532, amd64 and arm64. Three lines in ya Dockerfile:

```dockerfile
FROM swantron/secure-base:latest
COPY myapp /app
ENTRYPOINT ["/app"]
```

Push a tag, GitHub Actions builds it, scans it with Trivy, and publishes to Docker Hub if it's clean (it is.)

![Clean Trivy scan - zero vulnerabilities](/uploads/2025/11/secure-base-trivy-scan.png)

## Under the Hood

The workflow does the heavy lifting:

1. Runs integration tests (non-root user, no shell, CA certs present, etc.)
2. Builds the image
3. Scans with Trivy - build **fails** on CRITICAL/HIGH
4. Multi-platform build (amd64/arm64)
5. Pushes to Docker Hub on release tags

![Published to Docker Hub with latest and version tags](/uploads/2025/11/secure-base-dockerhub.png)

Source: [https://github.com/swantron/secure-base-images](https://github.com/swantron/secure-base-images)

Docker Hub: `swantron/secure-base:latest`

The [QUICKSTART.md](https://github.com/swantron/secure-base-images/blob/main/QUICKSTART.md) gets you from zero to published in about 10 minutes.
