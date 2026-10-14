---
title: 'Watchtron: Did the Deploy Actually Work?'
date: 2026-06-15T00:00:00+00:00
slug: 'watchtron'
description: "A green checkmark means the pipeline exited 0. watchtron fires synthetic traffic at the live site after a deploy and fails it unless the new build proves it's serving real requests."
featured_image: '/uploads/2026/06/watchtron-dashboard.png'
---

I sort of wound up with a formidable little fleet of sites.. tronswan, chomptron, swantron, mt, wrenchtron, jswan.dev. The DevX dawg in me naturally wanted to know if they were up.

So I wrote the dead simplest thing that could tell me. **[uptime-monitor](https://github.com/swantron/uptime-monitor)** is 234 lines in one file.. a GitHub Actions cron that pings every site every 5 minutes and writes uptime to a public gist. No VM, no terraform, $0. It only tips over when GitHub tips over. I'd build it the same way again.

But it can't tell me whether a *deploy* worked. Every deploy hands me a green checkmark, and the checkmark just means the pipeline exited 0. A `HEAD /` coming back 200 can be a CDN handing you a cached page while the app behind it is face-down. A pinger falls for that too.

## OTel, Backwards

Usually you instrument with OpenTelemetry so you can stare at dashboards after something breaks. I flipped it around. Right after a deploy, fire some synthetic traffic at the live URL, tag every request with a trace id, and check that the telemetry for *that exact run* shows up. If it does, the request made it all the way to the real app.. not a cache, not a stale instance. If it doesn't, or it's slow, the deploy fails.

**[watchtron](https://github.com/swantron/watchtron)** is a prober, a tiny control plane on a free-tier GCE e2-micro, and a reusable workflow any repo can call after its deploy job:

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

The fleet is all over the place.. DigitalOcean, Cloud Run, GitHub Pages, Firebase, a self-hosted PDS.. and one workflow covers all of it. For the two Express apps I own, the app emits its own span too, so watchtron can match it to the probe and check that the git SHA it reports is the one that just shipped. Green means *this build* is serving, not just *something*.

## Two Tools, One Strip

I started bolting history and dashboards onto watchtron and caught myself rebuilding the uptime monitor, worse. So I quit. The pinger is the heartbeat, watchtron is the deploy gate. Instead of competing, they share a chart: one strip per site, green up, red down, little triangles where deploys landed.

![watchtron dashboard: per-service uptime strips with verified-deploy markers](/uploads/2026/06/watchtron-dashboard.png)

It's up at [watch.swantron.com](https://watch.swantron.com), with a cleaner cut on [tronswan.com/status](https://tronswan.com/status).

The dashboard paid for itself right away. GitHub quietly disables scheduled workflows after ~60 days without a commit. The uptime monitor has a dirty keepalive for exactly this. watchtron's cron.. did not. The staleness flag caught it.

Source: [github.com/swantron/watchtron](https://github.com/swantron/watchtron)

Now the green checkmark actually means something.
