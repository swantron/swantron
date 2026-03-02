---
title: 'Wrenchtron: DIY Vehicle Maintenance Tracker'
date: 2026-03-01T04:00:00+00:00
slug: 'wrenchtron'
description: 'A vehicle service tracker for the DIY crowd who would rather do the work themselves than wait three months for a dealership appointment'
featured_image: '/uploads/2026/03/wrenchtron-demo.png'
---

Getting into Kendall Ford in Bozeman is basically impossible. I'm not exaggerating—scheduling anything is a multi-month endeavor. My 2021 F-150 is still under powertrain warranty, which means I'm supposed to care about documented service intervals, but the dealership has made that inconvenient enough that I've just embraced doing it myself.

I service everything at home anyway—the F-150, some ATVs, a mower, a snowblower. Once you have the tools and some confidence, DIY is usually faster, cheaper, and less painful than the alternative. The problem is keeping track of all of it.

The real issue with the F-150 specifically is the warranty. If something goes sideways with the drivetrain, I need receipts. I need documented oil changes at the right intervals. I needed somewhere to log this stuff that wasn't a stack of folded-up receipts in the glovebox.

So I built **[Wrenchtron](https://wrenchtron.com)**.

![Wrenchtron garage view](/uploads/2026/03/wrenchtron-demo.png)

## The Problem

Nothing out there handles a mixed fleet well. Apps designed for "car guys" are overkill and assume you're running a shop. Generic spreadsheets are fine until you have five vehicles with different maintenance schedules. OBD-based apps only work while you're plugged in and don't help with the mower.

I also wanted receipt capture. If I do an oil change on the F-150 and buy the oil and filter at Murdoch's, I want that receipt attached to the log entry. That's the documentation that makes the warranty coverage real.

## The Solution

Wrenchtron tracks service history across your whole fleet—whatever that looks like. It handles photos, receipts, costs, and maintenance schedules, and it works offline. You can install it on your phone like a native app.

**Features that matter:**

* **Five interval types** — mileage, time (months), seasonal, calendar month, and composite (whichever comes first). An oil change might be 5,000 miles *or* 6 months; Wrenchtron tracks both and alerts on whichever triggers first
* **Maintenance Hub** — cross-fleet overview of what's overdue, what's due soon, and what's coming up. One screen to see if anything needs attention across all your vehicles
* **Projected mileage** — enter your annual mileage rate and it estimates when you'll hit the next service threshold, so you can plan ahead instead of react
* **NHTSA recall integration** — auto-fetches open safety recalls by VIN so you don't have to remember to check
* **Receipt photos** — attach images to any service log entry; Firebase Storage handles the uploads
* **Typed service records** — oil changes track oil weight, brand, and filter; tire services track position, size, and tread; brakes track pad type and whether rotors were replaced. Structured data, not freeform notes
* **PWA with offline support** — installs on iOS/Android, Firestore syncs via IndexedDB so the data is there even without a connection
* **Cost tracking** — every service log has an optional cost field; stored in cents internally so there's no floating point nonsense

![Maintenance Hub — cross-fleet schedule at a glance](/uploads/2026/03/wrenchtron-hub.png)

## The Stack

| Layer | Tech |
|---|---|
| Framework | Next.js 15 (fully static export) |
| Styling | Tailwind CSS v4 |
| Auth | Firebase Authentication (Google sign-in) |
| Database | Firestore (real-time subscriptions) |
| Storage | Firebase Cloud Storage |
| PWA | @serwist/next v9 |
| Validation | Zod v4 |
| Hosting | Firebase Hosting |

No server. No API routes. Everything runs in the browser; security is enforced entirely by Firestore and Storage rules.

## The Routing Problem

Next.js 15 with `output: 'export'` (fully static, no server) has a known bug with dynamic route segments. If you have a page at `/vehicles/[vehicleId]` and return an empty array from `generateStaticParams`, the build fails with a "missing generateStaticParams" error. This affects any dynamic route where the set of IDs isn't known at build time—which is all of them when the data lives in Firestore.

The fix is ugly but simple: ditch the dynamic segments entirely and use query parameters instead. `/vehicles/detail?id=xxx` instead of `/vehicles/xxx`. It works fine, the URLs are a little less pretty, and you move on. I filed it away and didn't look back.

## Firebase as the Backend

The whole app is user-scoped in Firestore under `users/{userId}/vehicles/{vehicleId}`, with maintenance logs as subcollections. Security rules check `request.auth.uid == userId` on every read and write—there's no server middleware to forget, and it's hard to get wrong.

Firebase Authentication uses Google sign-in only. One button, no password reset flows, no email verification. I don't want to manage credentials.

Cloud Storage handles vehicle photos and receipt images. Uploads go through `browser-image-compression` before hitting the API so nobody's syncing uncompressed phone photos into my storage bucket.

Firebase Hosting deploys the static export. GitHub Actions runs Vitest on push, and if tests pass, it builds and deploys to Firebase. The whole pipeline is a few minutes.

## The Maintenance Logic

The service interval engine lives in `src/utils/maintenance.ts`—pure TypeScript, no React, no Firebase. It takes a vehicle and its service history and calculates alert status for every maintenance item: overdue, due soon, or fine.

Keeping it framework-free was intentional. It's easy to test with Vitest, easy to reason about, and easy to swap out if the rest of the app changes around it. The projected mileage calculation is in there too—given an annual mileage rate and last known odometer, it estimates when the next mileage-based service will hit.

![The actual garage](/uploads/2026/03/wrenchtron-vehicles.png)

## Check it out

Live: [https://wrenchtron.com](https://wrenchtron.com)

Demo (no login): [https://wrenchtron.com/demo](https://wrenchtron.com/demo)

Source: [https://github.com/swantron/wrenchtron](https://github.com/swantron/wrenchtron)

If you're doing your own work and need somewhere to log it, give it a shot. If you're waiting three months to get into a dealership, maybe just do the oil change yourself and log it here.
