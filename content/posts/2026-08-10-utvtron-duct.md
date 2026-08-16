---
title: 'utvtron: The Duct Was the Intake'
date: 2026-08-10T00:00:00+00:00
slug: 'utvtron-duct'
description: "Second ride on the 2017 RZR 4 900. Three ThermoPro tips, a share card that looked finished.. and a CSV that said I'd labeled the hot probe Ambient. The clutch exhaust dumps into the engine bay. Still not a belt reading."
featured_image: '/uploads/2026/08/utvtron-aug9-share.png'
---

[Last time](/2026/07/27/utvtron/) I said the next ride was the duct. Sunday afternoon I took it.. 2017 RZR 4 900, three ThermoPro tips. The app handed back a share card that looked finished.

![utvtron share card for Aug 9 · Afternoon: 96°F max, 90°F avg, 18 min, 9.0 miles, 3 impacts, three probe series](/uploads/2026/08/utvtron-aug9-share.png)

96° max, 90° avg, 18 minutes, 9.0 miles, 3 impacts. Green line flat. Blue line doing all the work. I almost posted that and called it done.

Then I opened the CSV.

## The Hose I Could See

Clutch housing is in the left-rear wheel well. Fat J-shaped hose clamps onto the round cover. That's the hose I could see, so that's where a tip went. One stayed in the cabin. One went in the engine bay, because that's the only place that got hot last time.

![CVT intake hose on the 2017 RZR 4 900, clamping onto the outer clutch cover](/uploads/2026/08/utvtron-cvt-intake.png)

Garage got the two-probe preset. Belt. Ambient. Jack 3 fell through to "Probe 3."

## What the CSV Said

708 rows, every ~1.5 seconds. BLE held. Wake lock held.. no timestamp pileup like the first ride.

Jack 1 ("Belt"): 88–96°, avg 90.5. Jack 3: 91–97°. They never really separate. Jack 2 ("Ambient"): 106° at the start, **163°** at minute 15, avg 142.

The card's 96 / 90 is jack 1 only. Max and avg follow the first probe. The heat was on the channel I'd named Ambient.

After staring at it: clutch and cabin stayed similar. The engine compartment got hot. Labels didn't match the plugs. The chart was honest. The headline wasn't.

## That Hose Is Intake

The J-tube is the **CVT intake**. A tip through the wall is sitting in incoming cooling air, so it should track cabin ambient. That's jacks 1 and 3. The clutches are inside the cover at the far end, inboard.. not behind the rubber.

On this generation there's no clutch-exhaust grill. Polaris pumps hot air **into the engine bay**.. open duct off the inner housing, over the trans, at the block and header. So the bay probe is mixed air: header soak plus whatever the clutch outlet was dumping. Same neighborhood as the 142° I read off the ThermoPro screen in July. Still not a belt reading.

![ThermoPro TP25 on the RZR floor, one cable routed through the floor toward the clutch](/uploads/2026/08/utvtron-thermopro-floor.png)

I said I wouldn't build GPS and Garage until the loop proved out. Then I built them anyway. Sunday they earned some of it.. three series on one card made the mislabel obvious, and the CSV let me argue with the headline. Labels aren't decoration.

## Still Not a Belt Temp

Intake air next to cabin air means I measured the hose, not the clutch. Next tip goes in the *outlet* duct, before it dumps into the bay. Plugs matching Belt / Ambient / Engine bay.

Live: [utvtron.vercel.app](https://utvtron.vercel.app).. Chrome on Android.

More once the tip is in the hose that actually leaves the clutch.

*Update, Aug 15: I got the tip in that hose. [Then the belt came apart.](/2026/08/15/utvtron-belt/)*
