---
title: 'Heartbeat, deploy, merge: three gates on one fleet'
date: 2026-07-08T00:00:00+00:00
slug: 'fleet-gates'
draft: true
description: "watchtron and difftron answer different lies at different points in the pipeline. Same instinct, real examples from the fleet, no repeats of either post."
featured_image: '/uploads/2026/06/watchtron-dashboard.png'
---

I've written up [watchtron](/2026/06/15/watchtron/) and [difftron](/2026/06/30/difftron/) separately. This is the comparison: same instinct, different moment in the pipeline, same fleet.

## The three questions

| When | Tool | Question | The lie it catches |
| --- | --- | --- | --- |
| Always (every 5 min) | [uptime-monitor](https://github.com/swantron/uptime-monitor) | Is it up? | "I haven't noticed it's down yet" |
| After deploy | [watchtron](https://github.com/swantron/watchtron) | Did *this* deploy work? | `HEAD / → 200` |
| On PR | [difftron](https://github.com/swantron/difftron) | Are *these* lines tested? | "The repo is 84% covered" |

They don't overlap. difftron never sees a production URL. watchtron never sees a diff. The heartbeat doesn't know either exists — it just pings. Run all three and each one is answering something the other two structurally can't.

## watchtron on the fleet

Every deployed site calls the same reusable workflow, but "the same workflow" verifies less the less you own. chomptron gets the full treatment — white-box via `@swantron/otel-bootstrap`, a version assertion (`version: ${{ github.sha }}`), Cloud Run's cold start absorbed with a throwaway warmup request in the registry. Green there means `versionMatch: true` — not just that something answered, that *this build* did.

tronswan is white-box too, minus the version check — not wired up yet, so it skips the assertion clean instead of failing on it. swantron, mt, and wrenchtron are black-box only: static sites and a runtime we don't control, so watchtron proves the edge answered and stops there. That's the ceiling on any deploy you don't own the process for. jswan.dev has no deploy pipeline to hook at all — self-hosted, upstream code, deliberately not forked — so it rides watchtron's cron instead.

```yaml
# chomptron — the fullest wiring
verify:
  needs: deploy
  uses: swantron/watchtron/.github/workflows/verify.yml@main
  with:
    service: chomptron
    version: ${{ github.sha }}
  secrets:
    otlp_endpoint: ${{ secrets.WATCHTRON_OTLP_ENDPOINT }}
    token: ${{ secrets.WATCHTRON_TOKEN }}
```

![watchtron dashboard: per-service uptime strips with verified-deploy markers](/uploads/2026/06/watchtron-dashboard.png)

## difftron on the fleet

Same yaml shape everywhere; only the coverage command changes. `go test -coverprofile` for the Go repos — difftron dogfoods itself this way. `vitest --coverage` for tronswan. `c8` wrapping `node --test` for chomptron, and for watchtron's own three-workspace monorepo gating its own PRs with the tool it ships. Four toolchains, one sticky comment:

![difftron sticky comment on a tronswan PR: 6.7% changed-line coverage, uncovered line numbers listed, test file skipped](/uploads/2026/06/difftron-comment.png)

Every repo above runs the version that skips docs-only files instead of failing them — [the difftron post](/2026/06/30/difftron/#dogfooding-the-fleet) has that bug in full.

## Side by side

| | watchtron | difftron |
| --- | --- | --- |
| **Runs** | After deploy (or cron) | On pull request |
| **Proves** | Live URL serves real traffic | Changed lines are covered |
| **Signal** | Synthetic HTTP + OTLP spans | git diff ∩ coverage report |
| **Authority** | Control plane `/verify` | Sticky PR comment + check |
| **Outage behavior** | Fail-open (unless `strict: true`) | N/A — runs on the runner |
| **Cost** | $0 (e2-micro + GitHub Actions) | $0 (GitHub Actions only) |

## When they compose

chomptron, start to finish: PR opens, difftron grades the diff and comments — report-only, not blocking yet. Merge, and CI builds, pushes, deploys to Cloud Run. A `verify` job fires synthetic traffic at the live URL and checks the served version matches the SHA that just shipped. uptime-monitor keeps pinging regardless, and [watch.swantron.com](https://watch.swantron.com) overlays the deploy markers on that same uptime strip.

difftron passing says nothing about whether the deploy landed. watchtron passing says nothing about whether the new function has a test. Three narrow questions, one fleet.

## The caveats, because there are always caveats

- Both are gates, not SLOs — a synthetic burst or one PR's lines, not a windowed guarantee about anything.
- Every repo above still runs difftron report-only (`fail-on-error: 'false'`) until its coverage catches up.
- They fail differently: difftron just doesn't run; watchtron's control plane fails *open*, so its own outage blocks nothing unless a service opts into `strict: true`.

## Try It

- [watchtron](https://github.com/swantron/watchtron) · [watch.swantron.com](https://watch.swantron.com)
- [difftron](https://github.com/swantron/difftron) · [Marketplace](https://github.com/marketplace/actions/difftron-delta-coverage-gate)
- [uptime-monitor](https://github.com/swantron/uptime-monitor)
