---
title: 'Wrenchtron: DIY Vehicle Maintenance Tracker'
date: 2026-03-01T04:00:00+00:00
slug: 'wrenchtron'
description: 'A vehicle service tracker for the DIY crowd who would rather do the work themselves than wait three months for a dealership appointment'
featured_image: '/uploads/2026/03/wrenchtron-f150.png'
---

Kendall Ford in Bozeman books out three months. I have a 2021 F-150 under powertrain warranty.

Those two facts are incompatible, so I've just started doing everything myself.

I was already servicing most of the fleet at home.. RZR, old wheeler, mower on its last leg, a snowblower. DIY is usually faster and cheaper, and to be honest fun. The warranty situation just made it urgent to actually document everything, and a glovebox full of Costco receipts wasn't going to cut it.

So I built **[Wrenchtron](https://wrenchtron.com)**.

![2017 F-150 Platinum.. service status and maintenance history](/uploads/2026/03/wrenchtron-f150.png)

## The Problem

Nothing out there handles a mixed fleet well. Apps for car guys assume you're running a shop. Spreadsheets fall apart once you have a few vehicles on different schedules, and I'm not about to use a spreadsheet in the first place. OBD apps don't know what a snowblower is. Etc etc..

I'm running Kirkland 5W-30 and buying OEM filters at the parts counter.. best of both worlds for the warranty. But I need those receipts attached to a log entry to make any of it mean anything.

## The Solution

Wrenchtron tracks service history across whatever fleet you've got. Photos, receipts, costs, schedules.. and it works offline. Installs on your phone like a native app.

**Features that matter:**

* **Five interval types**.. mileage, time, seasonal, calendar month, or composite. An oil change at 5k miles *or* 6 months triggers whichever comes first
* **Maintenance Hub**.. one screen showing overdue, due soon, and upcoming across every vehicle
* **Projected mileage**.. estimates when you'll hit the next threshold based on your annual mileage rate
* **NHTSA recall integration**.. pulls open safety recalls by VIN automatically
* **Receipt photos**.. attach images to any log entry
* **Typed service records**.. oil changes track weight, brand, and filter; tires track position and tread; brakes track pad type and rotors. Structured, not freeform
* **Cost tracking**.. per-entry cost fields, stored in cents to avoid floating point nonsense
* **PWA with offline support**.. Firestore syncs via IndexedDB so the data is there without a connection

![Maintenance Hub.. cross-fleet schedule at a glance](/uploads/2026/03/wrenchtron-hub.png)

## The Stack

Next.js 15 static export, Tailwind CSS v4, Firebase for auth, Firestore, and Storage, with @serwist/next handling the PWA layer. No server, no API routes.. everything runs in the browser, security lives entirely in Firestore rules. GitHub Actions runs tests on push and deploys to Firebase Hosting. Pipeline is a few minutes start to finish.

![The garage](/uploads/2026/03/wrenchtron-vehicles.png)

## Check it out

Live: [https://wrenchtron.com](https://wrenchtron.com)

Demo (no login): [https://wrenchtron.com/demo](https://wrenchtron.com/demo)

Source: [https://github.com/swantron/wrenchtron](https://github.com/swantron/wrenchtron)

Do your own work, document it properly, skip the three-month wait. Wrench cheers..
