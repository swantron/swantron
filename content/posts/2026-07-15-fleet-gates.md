---
title: 'Heartbeat, deploy, merge: three gates on one fleet'
date: 2026-07-15T00:00:00+00:00
slug: 'fleet-gates'
draft: true
description: "WIP — watchtron and difftron answer different lies at different points in the pipeline. Same yaml-shaped instinct, real examples from tronswan, chomptron, swantron, and the rest of the fleet."
# featured_image: '/uploads/2026/07/fleet-gates.png'
---

<!-- WIP stub. Companion to the watchtron and difftron posts — compares the deploy gate and the PR gate side by side, with screenshots and yaml pulled from the repos that actually run them. -->

I've written up [watchtron](/2026/06/15/watchtron/) and [difftron](/2026/06/30/difftron/) separately. This one is the comparison: same instinct, different moment in the pipeline, with examples from the sites that actually use both.

## The three questions

| When | Tool | Question | The lie it catches |
| --- | --- | --- | --- |
| Always (every 5 min) | [uptime-monitor](https://github.com/swantron/uptime-monitor) | Is it up? | "I haven't noticed it's down yet" |
| After deploy | [watchtron](https://github.com/swantron/watchtron) | Did *this* deploy work? | `HEAD / → 200` |
| On PR | [difftron](https://github.com/swantron/difftron) | Are *these* lines tested? | "The repo is 84% covered" |

TODO: tighten intro — one paragraph on why comparing them in one place is useful (you'll run both on the same repo, they don't overlap, neither replaces the heartbeat).

## watchtron on the fleet

Post-deploy, synthetic traffic, OTLP proof. Every site that deploys from CI calls the same reusable workflow.

**TODO: chomptron** — white-box + version assertion. Cloud Run cold start handled in the registry (`warmup`, extra requests). Show a green deploy marker on [watch.swantron.com](https://watch.swantron.com) next to a failed one. Screenshot of `/verify` JSON with `versionMatch: true`.

**TODO: tronswan** — white-box Express on DigitalOcean, no version wired yet (gate skips it cleanly). Playwright still runs pre-verify; watchtron is the lighter post-deploy proof. Link to [tronswan.com/status](https://tronswan.com/status).

**TODO: swantron / mt / wrenchtron** — black-box only (Hugo static, Firebase, no server spans). Same workflow, fewer assertions — availability, p95, route coverage. Note what you *don't* get without white-box.

**TODO: jswan.dev** — schedule-only (no deploy pipeline). Probed on watchtron's 30-minute cron instead of `verify.yml`.

```yaml
# chomptron — the fullest watchtron wiring
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

## difftron on the fleet

Pre-merge, changed-line coverage only. One Action shape; swap the coverage file your test runner already emits.

**TODO: difftron (Go)** — `go test -coverprofile=coverage.out`, dogfoods itself. Mention report-only mode while coverage catches up (`fail-on-error: 'false'`).

**TODO: tronswan (vitest)** — `yarn vitest run --coverage --coverage.reporter=lcov`. Screenshot of sticky PR comment with per-file breakdown.

**TODO: chomptron (node:test + c8)** — `npx c8 --reporter=lcovonly node test.js`. Same comment shape, different test runner.

**TODO: watchtron (node:test monorepo + c8)** — prober, control-plane, and registry packages in one repo. The meta case: the deploy gate repo gates its own PRs.

**TODO: minifier-cli / readme-lint (Go)** — same yaml, `go test -coverprofile`. Language-agnostic pitch with two more data points.

**TODO: docs-only PR bug** — cross-link the difftron post's README failure story; maybe show a skipped-files comment on a real docs PR.

```yaml
# tronswan — vitest -> lcov -> difftron
- uses: swantron/difftron@v1
  with:
    coverage: coverage/lcov.info
    threshold: '80'
    comment-pr: 'true'
    fail-on-error: 'false' # flip when ready
```

## Side by side

TODO: table or short prose block — trigger, signal, authority, fail mode, cost.

| | watchtron | difftron |
| --- | --- | --- |
| **Runs** | After deploy (or cron) | On pull request |
| **Proves** | Live URL serves real traffic | Changed lines are covered |
| **Signal** | Synthetic HTTP + OTLP spans | git diff ∩ coverage report |
| **Authority** | Control plane `/verify` | Sticky PR comment + check |
| **Outage behavior** | Fail-open (unless `strict: true`) | N/A — runs on the runner |
| **Cost** | $0 (e2-micro + GitHub Actions) | $0 (GitHub Actions only) |

## When they compose

TODO: walk one repo end-to-end — e.g. chomptron or tronswan.

1. PR opens → difftron grades the diff (report-only today, blocking soon).
2. Merge → deploy runs → watchtron fires synthetic traffic at the live URL.
3. uptime-monitor keeps pinging every 5 minutes regardless; dashboard overlays deploy markers on the uptime strip.

Neither tool replaces the other. difftron can't tell you the deploy landed. watchtron can't tell you the new function has a test. The heartbeat can't fail either gate.

## The caveats, because there are always caveats

TODO: don't repeat both posts verbatim — one bullet each on scope (gate vs SLO), and one on "report-only while rolling out" since both are in that phase on some repos.

## Try It

- [watchtron](https://github.com/swantron/watchtron) · [watch.swantron.com](https://watch.swantron.com)
- [difftron](https://github.com/swantron/difftron) · [Marketplace](https://github.com/marketplace/actions/difftron-delta-coverage-gate)
- [uptime-monitor](https://github.com/swantron/uptime-monitor)
