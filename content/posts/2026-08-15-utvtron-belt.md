---
title: 'utvtron: Then the Belt Came Apart'
date: 2026-08-15T00:00:00+00:00
slug: 'utvtron-belt'
aliases:
  - /2026/08/10/utvtron-duct/
description: "Third ride on the 2017 RZR 4 900. Tip in the clutch outlet this time. 58 minutes, 36.6 miles, clutch exhaust 164°F.. and a handful of belt. The first duct I found was the intake. This one wasn't."
featured_image: '/uploads/2026/08/utvtron-aug15-belt.png'
---

[Last time](/2026/07/27/utvtron/) I said the next ride was the duct. I took that ride. Then I took another one. This post replaces the in-between: I had written up a Sunday where I stuffed a tip in the wrong hose and the share card lied about which probe was hot. That's still true. It just isn't the end of the story.

Saturday I finally put a tip in the hose that *leaves* the clutch. 58 minutes later I was holding a piece of belt.

## The Hose I Could See, Twice

Clutch housing, left-rear wheel well, fat J-shaped hose on the round cover. That's the hose you can see from outside, so that's where the first "duct" tip went. On this chassis that tube is the **CVT intake**. Cooling air in. A probe through the wall sits in air that tracks cabin ambient. The clutches are inboard, at the far end of the cover. Hot air dumps the other way: into the engine bay, over the trans, at the block.

Sunday, Aug 9, I ran three tips anyway. Jack 1 I called Belt: 88–96°. Jack 3 similar. Jack 2 I called Ambient: **163°**. The card headlined 96°. The CSV said the bay was cooking. Labels were wrong. The intake hose was never going to tell me about the belt.

![ThermoPro TP25 in the RZR engine bay before the Saturday ride, three tips live, jack 4 empty](/uploads/2026/08/utvtron-aug15-thermopro.png)

Saturday morning the controller was still sitting on the bay plastic, 77 / 72 / 68. Jack 2 (blue) went into the machine. The tip sat above the slotted housing, next to the quilted heat shield.. clutch exhaust, not cabin air.

![ThermoPro tip at the clutch outlet, quilted heat shield on the left](/uploads/2026/08/utvtron-aug15-outlet.png)

Garage names for this one: Engine bay / Clutch / Ambient. Plugs matching the holes.

## What the Log Said

Aug 15 · Afternoon. Started 12:42pm. 2017 RZR 4 900.

![utvtron history: 58 min, 36.6 mi, Clutch 164°F peak, 54 impacts](/uploads/2026/08/utvtron-aug15-history.png)

58 minutes, 36.6 miles, 65 mph peak, 54 impacts (max 8.5g). Three series the whole time. Headline is **Clutch 164°F**, avg 127°. Engine bay max 102°. Ambient max 89°. Hottest channel every sample is jack 2. The card and the CSV agree this time.

Clutch sat in a 115–134° band for most of the hour. The last six minutes are the ride: 126° at minute 50, 140° at 52, 151° at 54, **164° at 55:56**, then it dumps to 133° by Stop. Bay and ambient bump in that same window. That's a pull, then you shut it down.

BLE dropped once, about four minutes of missing temp samples in the first five minutes of the ride. GPS and impacts kept going. The probe came back. That's a bug I already knew about, and a behavior I already shipped: losing the thermometer doesn't kill the session.

2,155 temp rows after that, every ~1.5 seconds. No screen-lock timestamp pileup like July.

## Then I Opened It

Stopped around 1:40. Tunnel panel off a minute later.

![RZR tunnel access between the seats: probe braid routed into a rodent nest](/uploads/2026/08/utvtron-aug15-nest.png)

The same braid I'd just been logging is going into a **rodent nest**. Fur and insulation packed around the heat shield, the fill cap, the probe cable.

A couple hours later, a chunk of belt in the cabin. Ribbed CVT fragment, torn ends. Floor panel open.

![Broken CVT belt fragment held over the RZR center console](/uploads/2026/08/utvtron-aug15-belt.png)

Home on the lawn, mud to the doors.

![2017 RZR 4 900 in the yard after the ride, dirt up the bodywork](/uploads/2026/08/utvtron-aug15-rzr.png)

## What I Think Happened

I'm measuring clutch **exhaust air**, not the belt carcass. 164° in that duct is not a claim that the rubber was 164°. The belt can run a lot hotter than the air leaving the cover. A nest in that tunnel can destroy a belt with or without a heat story.. debris in the clutch, insulation, chewed bits.

The honest read: the tip was finally in the right hose, the log showed a late runaway, and when I opened the machine I found nest plus shredded belt. Heat, debris, or both. The factory dash still only shows coolant. The $30 thermometer finally showed me *something* the dash can't. It didn't save the belt.

## The Tool, Briefly

utvtron is still a PWA. No backend. Chrome on Android. Since July it grew GPS, impacts, vehicles, a share card, and a headline that follows the hottest probe instead of jack 1. That last one is why this ride's card says 164° instead of 102°.

Still not a product. Still not an App Store listing. Still not a solved CVT monitor. It is, finally, a session from the outlet duct.. and a reason to pull the clutch cover.

Live: [utvtron.vercel.app](https://utvtron.vercel.app)
