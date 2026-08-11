---
title: 'utvtron: The Duct Was the Intake'
date: 2026-08-10T00:00:00+00:00
slug: 'utvtron-duct'
description: "Second ride on the 2017 RZR 4 900. Three ThermoPro tips, GPS, a share card that looked finished.. and a CSV that said I'd labeled the hot probe Ambient. The clutch exhaust on this chassis dumps into the engine bay. Still not a belt reading."
featured_image: '/uploads/2026/08/utvtron-aug9-share.png'
---

[Last time](/2026/07/27/utvtron/) I said the next ride was the duct. Get the $30 ThermoPro somewhere the factory dash can't see, and find out if a PWA plus Web Bluetooth can tell me anything about the belt.

I took that ride. Sunday afternoon, 2017 RZR 4 900. Three tips this time. The app handed me back a share card that looked like a finished product.

![utvtron share card for Aug 9 · Afternoon: 96°F max, 90°F avg, 18 min, 9.0 miles, 3 impacts, three probe series](/uploads/2026/08/utvtron-aug9-share.png)

96° max, 90° avg, 18 minutes, 9.0 miles, 3 impacts. Green line flat. Blue line doing all the work. I almost posted that card and called the duct done.

Then I opened the CSV.

## What I Thought I'd Wired

The machine is a 2017 RZR 4 900. Clutch housing lives in the left-rear wheel well, behind a FOX coil. There's a fat J-shaped rubber hose clamping onto the round black cover. That's the hose I could see, so that's where a tip went.

![CVT intake hose on the 2017 RZR 4 900, clamping onto the outer clutch cover in the left-rear wheel well](/uploads/2026/08/utvtron-cvt-intake.png)

Second tip stayed in the cabin as ambient. Third one I dropped in the engine compartment, because last ride the bay was the only place that actually got hot and I wanted that number on the same timeline.

![ThermoPro TP25 on the RZR floor, two probes plugged, one cable routed through a floor hole toward the clutch](/uploads/2026/08/utvtron-thermopro-floor.png)

In Garage I used the two-probe preset. Belt. Ambient. Jack 3 fell through to "Probe 3."

## What the CSV Actually Said

708 rows, about one sample every 1.5 seconds. BLE held the whole way. Wake lock did its job.. no timestamp pileup like the first ride.

| Jack | App label | min | avg | max |
|---|---|---|---|---|
| 1 | Belt | 88.0 | 90.5 | 95.9 |
| 2 | Ambient | 106.2 | 141.9 | **163.4** |
| 3 | Probe 3 | 91.0 | 93.3 | 97.3 |

Jack 1 and jack 3 never really separate. Jack 2 is a different planet.. already 16° hotter at the start, 163° at about minute 15, always 16–73° above "Belt."

The share card's 96 / 90 is jack 1 only. That's what `summarize()` does: max and avg off `tempF`, the first probe. The interesting heat was on the channel I'd labeled Ambient.

Physical remap, after staring at it: clutch and cabin stayed similar. The engine compartment got hot. Labels were backwards relative to the plugs. The chart was honest. The headline wasn't.

## The Hose I Could See Is Intake

That J-tube is not the clutch. It's the **CVT intake**. Cool air in, across the belt, out the other side. A tip poked through the hose wall is sitting in incoming cooling air, so it should track cabin ambient.

That's exactly what jacks 1 and 3 did.

The clutches themselves are inside the round cover at the far end of that hose, inboard, toward the tunnel. Not behind the rubber.

And the outlet? On this generation there is no clutch-exhaust grill on the body. Polaris uses the spinning sheaves as a pump and **dumps the hot air into the engine bay**.. open duct off the upper-rear of the inner housing, arched over the trans, pointed at the block and header. That's why a 2017 900-4 floods the belt box if you submerge past the motor. It's also why my bay probe is a mixed number: header soak plus whatever the clutch outlet was exhaling, not belt surface, not pure CVT-out.

Last July I parked a probe in the bay at the end of a ride and read 142° off the ThermoPro's own screen. Sunday the same neighborhood hit 163° over 18 minutes. Consistent. Still not a belt reading.

![Wider shot of the intake hose, clutch cover, and FOX coil.. the outlet is inboard of this, not on a body vent](/uploads/2026/08/utvtron-cvt-intake-wide.png)

## The App Grew While I Was Avoiding the Duct

In the first post I said GPS, impacts, and multi-vehicle profiles weren't worth building until the core loop proved out. Then I built them anyway. Garage, labels, live chart during the ride, share image, GPX, the whole Peloton-session pitch.

Some of that earned its keep on Sunday. Wake lock held. Three colored series on one card made the mislabel obvious in a way a single live number never would have. Exporting CSV and GPX meant I could argue with the card instead of trusting it.

Some of it got ahead of the hardware. Share max/avg following jack 1 is fine when jack 1 is actually the belt. It's a lie when the hot tip is on jack 2 and you've named that Ambient. Labels in Garage aren't decoration. They're load-bearing, and a two-probe preset on a three-probe ride will happily invent a story.

The live in-ride chart is the one feature that finally matches the original pitch. A session, not a gauge. It shows up on the second reading and goes away when you stop. I should have had that before I had a compare view.

## What This Still Isn't

- **Not a belt temperature.** Intake air staying ~90° next to cabin air means the cooling path is doing its job, or at least that I measured the hose and not the clutch. I cannot tell you if the belt is fine.
- **Not a product.** Still a build log. Still no App Store link, no pricing, source still closed.
- **The next tip is obvious.** Inside the *outlet* duct, a few inches before it dumps into the bay. Leave one in the cabin. Leave one in the bay if I want the soak number separately. Use the Belt / Ambient / Engine bay preset and make the plugs match.
- **Don't trust the share headline until the labels match the jacks.** The chart already knew.

Live: [utvtron.vercel.app](https://utvtron.vercel.app).. Chrome on Android, same as before.

More once the tip is in the hose that actually leaves the clutch.
