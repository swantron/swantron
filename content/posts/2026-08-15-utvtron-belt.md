---
title: 'utvtron: Then the Belt Came Apart'
date: 2026-08-15T00:00:00+00:00
slug: 'utvtron-belt'
description: "Third ride on the 2017 RZR 4 900. Tip in the clutch outlet this time. 58 minutes, 36.6 miles, clutch exhaust 164°F.. and a handful of belt. The first duct I found was the intake. This one wasn't."
featured_image: '/uploads/2026/08/utvtron-aug15-belt.png'
---

[Last time](/2026/08/10/utvtron-duct/) the hose I could see was the CVT intake. Share card said 96°. CSV said the bay hit 163° on a probe I'd named Ambient. Next tip was supposed to go in the hose that *leaves* the clutch.

Saturday I put it there. 58 minutes later I was holding a piece of belt.

## Outlet, Not Intake

Saturday morning the ThermoPro was still sitting on the bay plastic, 77 / 72 / 68. Jack 2 (blue) went into the machine. The tip sat above the slotted housing, next to the quilted heat shield.. clutch exhaust, not cabin air.

![ThermoPro TP25 in the RZR engine bay before the Saturday ride, three tips live, jack 4 empty](/uploads/2026/08/utvtron-aug15-thermopro.png)

![ThermoPro tip at the clutch outlet, quilted heat shield on the left](/uploads/2026/08/utvtron-aug15-outlet.png)

Garage names for this one: Engine bay / Clutch / Ambient. Plugs matching the holes.

## What the Log Said

Aug 15 · Afternoon. Started 12:42pm. 2017 RZR 4 900.

![utvtron history: 58 min, 36.6 mi, Clutch 164°F peak, 54 impacts](/uploads/2026/08/utvtron-aug15-history.png)

58 minutes, 36.6 miles, 65 mph peak, 54 impacts (max 8.5g). Three series the whole time. Headline is **Clutch 164°F**, avg 127°. Engine bay max 102°. Ambient max 89°. Hottest channel every sample is jack 2. The card and the CSV agree this time.

Clutch sat in a 115–134° band for most of the hour. The last six minutes are the hill: coming back toward Four Corners from the west, last climb before Cottonwood, **65+ mph**. 126° at minute 50, 140° at 52, 151° at 54, **164° at 55:56**. That's where it finally gave. Engine was fine. I could hear the belt shredding. Bay and ambient bump in the same window. The 65 max mph on the card is that pull.

BLE dropped once, about four minutes of missing temp samples in the first five minutes of the ride. GPS and impacts kept going. The probe came back. That's a bug I already knew about, and a behavior I already shipped: losing the thermometer doesn't kill the session.

2,155 temp rows after that, every ~1.5 seconds. No screen-lock timestamp pileup like July.

## What a Belt Is

A CVT belt isn't a fan belt. Cogs on both faces, a tensile core through the middle, fabric on the inner teeth. The core is what keeps it from stretching. When that lets go you get fiber, not a clean break.

The center core went. The outer-diameter cogs started peeling off. The fluff in the tunnel is that core, blown apart. Same stuff packed the **output duct**.. the hose the tip was sitting in.

![RZR tunnel access between the seats: shredded belt packed around the probe braid](/uploads/2026/08/utvtron-aug15-nest.png)

I pulled the fiber out of the outlet and drove it home. Still did 50. Not really limping. The belt was already cooked.

![Broken CVT belt fragment held over the RZR center console](/uploads/2026/08/utvtron-aug15-belt.png)

Home on the lawn, mud to the doors.

![2017 RZR 4 900 in the yard after the ride, dirt up the bodywork](/uploads/2026/08/utvtron-aug15-rzr.png)

## What I Think Happened

I'm measuring clutch **exhaust air**, not the carcass. 164° in that duct is not a claim that the rubber was 164°. I was loaded up a long hill at 65 and heard it shred. The core let go and dumped itself into the hose I was logging. The number moved because the belt was already failing, not because the air warned me in time to save it.

The factory dash still only shows coolant. The $30 thermometer finally showed me *something* the dash can't. It didn't get close enough to the belt to predict it.

## The Tool, Briefly

utvtron is still a PWA. No backend. Chrome on Android. Since July it grew GPS, impacts, vehicles, a share card, and a headline that follows the hottest probe instead of jack 1. That last one is why this ride's card says 164° instead of 102°.

Still not a product. Still not an App Store listing. Still not a solved CVT monitor. It is, finally, a session from the outlet duct.. with a belt in the hose.

Live: [utvtron.vercel.app](https://utvtron.vercel.app)
