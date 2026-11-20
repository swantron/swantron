---
title: 'Drivetron: A Driving Log the Whole Family Shares'
date: 2026-11-19T00:00:00+00:00
slug: 'drivetron'
description: "Montana wants 50 supervised hours, 10 of them at night, before a teen moves off the learner license. Two parents, one teen, three phones, and a paper log in the glovebox.. so I built a shared one, then made it work for every state."
featured_image: '/uploads/2026/11/drivetron-landing.png'
---

Montana wants 50 hours of supervised driving before a teen moves off the learner license. Ten of those have to be at night, the license has to be held six months and a day, and a parent signs off on all of it at the exam station.

The official tool for this is a paper log. It lives in the glovebox of whichever car didn't get driven that day.

Two parents, one teen, three phones. Somebody forgets to write the drive down, somebody else rounds up, and nobody actually knows how many of those minutes happened after sunset. When it's time to sign, you're adding up a smudged column on the hood of the car.

So I built **[Drivetron](https://drivetron.app)**.

![Drivetron.. the log the whole family shares](/uploads/2026/11/drivetron-landing.png)

## Start, Stop, Done

Tap Start when the kid pulls out of the driveway, tap Stop when they're back. Any phone in the family can start a drive and any other can stop it. Everyone sees the same log.

Night minutes get split out automatically using actual sunset and sunrise where you drove, not a guess. Montana doesn't define "night" anywhere I could find, so sunset to sunrise it is. Other states are pickier.. more on that below.

Drives the teen logs themselves get flagged until a parent confirms them. Anything typed in after the fact, or with times edited later, gets marked on the printout. If I'm signing a state form that says the hours happened, I want the log to be honest about which ones were timed live.

When the hours are done, it prints a log laid out like Montana's own practice log, ready to sign.

## Then Every Other State

Montana was supposed to be it. Then I looked at what the other states want, and every one of them does it a little differently.

- **California** counts night from 30 minutes after sunset ("darkness," per the Vehicle Code). **Maryland** goes the other way, 30 minutes *before* sunset.
- **Texas** only counts 2 hours a day toward its 30. **North Carolina** caps it at 10 hours a week.
- **Pennsylvania** wants 5 hours in bad weather. **Alaska** wants 10 hours "in challenging circumstances," night or weather.
- **New Hampshire** doesn't have a learner's permit at all.
- **Arkansas** and **Hawaii** don't require any hours. Plenty of sites say Hawaii wants 50.. I couldn't find it anywhere official.

Each state is a small rules file, and every number in it points back to a DMV page, a statute, or the form a parent actually signs. That turned into a page for every state, plus a [comparison of all 50 and D.C.](https://drivetron.app/driving-hours-by-state) that's probably the most useful thing on the site if you're just trying to figure out what your kid needs.

![Supervised driving hours by state](/uploads/2026/11/drivetron-hours-by-state.png)

If you'd rather stick with paper, there's a free [printable log for each state](https://drivetron.app/montana/printable-log) with that state's numbers on it. No account needed.

## The Details

It's a Next.js static site on Firebase, installable on iPhone or Android, and it works offline.. drives started in a dead zone sync when you get signal back. The first 10 hours are free. After that it's $9.99 once per teen, not a subscription. Families who signed up before launch stay free for good.

Live: [https://drivetron.app](https://drivetron.app)

Watch for deer.
