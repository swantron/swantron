---
id: 1010
title: 'Wrenchtron'
date: 2026-03-01T04:00:00+00:00
slug: 'wrenchtron'
description: 'Kendall Ford books out three months and the F-150 is under warranty. So I do the work myself, and now I keep the receipts.'
featured_image: '/uploads/2026/03/wrenchtron-f150.png'
---

Kendall Ford in Bozeman books out three months. I have a 2021 F-150 under powertrain warranty.

Those two facts are incompatible, so I've just started doing everything myself.

I was already servicing most of the fleet at home.. RZR, old wheeler, mower on its last leg, a snowblower. DIY is usually faster and cheaper, and to be honest fun. The warranty situation just made it urgent to actually document everything, and a glovebox full of Costco receipts wasn't going to cut it.

I'm running Kirkland 5W-30 and buying OEM filters at the parts counter.. best of both worlds for the warranty. But I need those receipts attached to a log entry to make any of it mean anything. Spreadsheets fall apart once you have a few vehicles on different schedules, and I'm not about to use a spreadsheet in the first place. OBD apps don't know what a snowblower is.

So I built **[Wrenchtron](https://wrenchtron.com)**.

![2017 F-150 Platinum.. service status and maintenance history](/uploads/2026/03/wrenchtron-f150.png)

Every entry gets photos and the receipt, so the Costco receipt lives next to the oil change it paid for. Intervals can be miles, time, seasonal, calendar month, or whichever comes first.. 5k miles *or* 6 months for the oil. One screen shows what's overdue and coming up across the whole fleet, and it pulls open NHTSA recalls by VIN. Works offline.

![Maintenance Hub.. cross-fleet schedule at a glance](/uploads/2026/03/wrenchtron-hub.png)

## Under the Hood

Next.js 15 static export, Tailwind CSS v4, Firebase for auth, Firestore, and Storage, with @serwist/next handling the PWA layer. No server, no API routes.. everything runs in the browser, security lives entirely in Firestore rules. GitHub Actions runs tests on push and deploys to Firebase Hosting. Pipeline is a few minutes start to finish.

![The garage](/uploads/2026/03/wrenchtron-vehicles.png)

Live: [https://wrenchtron.com](https://wrenchtron.com)

Demo (no login): [https://wrenchtron.com/demo](https://wrenchtron.com/demo)

Source: [https://github.com/swantron/wrenchtron](https://github.com/swantron/wrenchtron)
