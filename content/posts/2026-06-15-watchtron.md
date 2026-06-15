---
title: 'Evolved deploy gates: leveraging OTel for deployment verification'
date: 2026-06-15T00:00:00+00:00
slug: 'watchtron'
description: "A fleet observability paved road — every deploy drives synthetic OpenTelemetry traffic at the live service and fails unless the new build proves it's serving real requests end-to-end. Plus what happened when I held it up against a 234-line uptime monitor."
featured_image: '/uploads/2026/06/watchtron-dashboard.png'
---

I run a little fleet of sites.. tronswan, chomptron, swantron, mt, wrenchtron, a self-hosted bluesky pds. Every one of them deploys from CI, and every one hands me a satisfying green checkmark when it's done.

The checkmark means the pipeline exited 0. It does not mean the site is up, serving the code I just shipped, to a real request. A `HEAD /` coming back 200 can be a CDN handing you a cached page while the origin behind it is face-down. The build can be green while the thing is broken.

I wanted a deploy to *prove* it worked before calling itself done.

## The Idea

OpenTelemetry (OTel), but pointed backwards. Instead of instrumenting for dashboards you read after something already broke, use it as a gate. Right after a deploy: fire synthetic traffic at the live URL, tag every request with a W3C trace id, and check that the telemetry for *that exact run* actually lands. If it lands, the request flowed all the way through to the real application — not an edge cache, not a stale instance. If it doesn't land within the latency and availability you expect.. fail the deploy.

A CI step can lie about an exit code. It can't fake a span showing up in a buffer.

## So I Built Something

**[watchtron](https://github.com/swantron/watchtron)** is the paved road for that. A few moving parts:

- A **prober** (undici) that drives golden-signal traffic at a service's critical routes, propagates trace context, and exports its client spans as OTLP/HTTP JSON.
- A tiny **control plane** on a free-tier GCE e2-micro — receives the spans, runs `/verify`, serves a dashboard and status badges, Caddy out front for auto-HTTPS. The whole thing runs at $0.
- A **reusable GitHub Actions workflow** any repo calls right after its deploy job. The deploy is gated on the verdict.

Onboarding a service is basically this:

```yaml
verify:
  needs: deploy
  uses: swantron/watchtron/.github/workflows/verify.yml@main
  with:
    service: tronswan
    version: ${{ github.sha }}
  secrets:
    otlp_endpoint: ${{ secrets.WATCHTRON_OTLP_ENDPOINT }}
    token: ${{ secrets.WATCHTRON_TOKEN }}
```

For the two services I own the runtime for (tronswan, chomptron) there's a drop-in `@swantron/otel-bootstrap` so the origin emits its *own* server span. That's the good part — it lets the control plane confirm the synthetic request actually reached the instrumented app and stitch the two halves of the trace together.

## What It Checks

For each run, the control plane scores:

- availability and p95 latency over the synthetic burst
- every critical route actually got probed
- (white-box) a server span correlated with the prober's trace — the request truly reached the origin, not a cache
- (white-box) **version assertion** — the origin reports the git SHA it's running, and verify checks it against the SHA being deployed. green now means *this build* is serving, not just *something*
- a latency **regression** check against a rolling baseline, to catch slow creep that's still technically under the limit

Anything fails, the deploy fails. The control plane is the authority, not the CI log.

## The Honest Part

Here's where it gets uncomfortable. I already had an uptime monitor.

234 lines. One file. A GitHub Actions cron that pings the fleet every 5 minutes and writes uptime % and incidents to a public gist. No VM, no terraform, no control plane. Runs at $0 and basically never breaks.

So is watchtron.. better?

For *uptime monitoring* — no. Not close. The little gist-pinger is cheaper, simpler, runs 6x more often, and actually keeps history. And if I'm honest, a chunk of what I'd been bolting onto watchtron — persistence, a dashboard, regression baselines — was quietly wandering into the exact territory that 234-line tool already owned, and losing.

But they're not the same job. The uptime monitor is the **heartbeat**: is it up, over time, and when did it break? watchtron is the **deploy gate**: did *this deploy* ship working, instrumented code, and should we even let it through? A cron pinger can't fail a deploy, and it can't prove the new version is the one answering. Different question entirely.

Once I stopped making them compete, the nice part showed up.

## The Picture

Both tools watch the same fleet, so I stopped duplicating and started overlaying. Take the uptime monitor's continuous up/down timeline, and drop watchtron's verified-deploy markers right on it. One strip per service: green up, red down, and little triangles where deploys landed — green if the deploy proved itself end-to-end, red if it didn't.

Now I can actually see whether a deploy lines up with a dip. The reliability timeline and the deploy provenance, on the same axis. Neither tool gives you that on its own.

It lives on watchtron's dashboard at [watch.swantron.com](https://watch.swantron.com), and in a cleaner public cut on [tronswan.com/status](https://tronswan.com/status).

![watchtron dashboard: per-service uptime strips with verified-deploy markers](/uploads/2026/06/watchtron-dashboard.png)

## The Catch

- It's a **gate, not an SLO**. The score comes off a small synthetic burst fired right after deploy. It tells you "the new build answered fast and correctly just now," not "we hit four nines this quarter." Calling it an SLO would be lying, so I don't.
- The control plane is a **single point of failure** for the whole pipeline. If the e2-micro is down, every deploy wants to block on it. So it fails *open* — an unreachable control plane is a watchtron outage, not a service failure, and it won't hold your deploy hostage unless you opt into strict mode.
- Green still only means "passed a synthetic check." It won't catch a bug that only shows up under real user behavior. Strong signal, not proof.
- And the one that got me: GitHub disables scheduled workflows after ~60 days of repo inactivity. The uptime monitor has a keepalive for exactly this. watchtron's cron.. did not. The new dashboard's staleness flag is what surfaced it — hoisted by my own petard.

## Get It

Source: [github.com/swantron/watchtron](https://github.com/swantron/watchtron)

The heartbeat half: [github.com/swantron/uptime-monitor](https://github.com/swantron/uptime-monitor)

Live: [watch.swantron.com](https://watch.swantron.com) · [tronswan.com/status](https://tronswan.com/status)

It runs at $0 on free tiers, onboarding a service is a few lines of yaml, and a green checkmark finally has to earn it.
