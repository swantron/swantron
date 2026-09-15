---
title: 'The listing already has the VIN'
date: 2026-09-14T00:00:00+00:00
slug: 'curbspec-chrome'
description: "Laptop shopping is ten listing tabs and a 17-character string. I got tired of retyping it, so CurbSpec has a Chrome extension now."
featured_image: '/uploads/2026/09/curbspec-chrome-cta.png'
---

Laptop shopping is a different job than standing at the curb. Ten tabs of Cars.com and Autotrader, copying a 17-character string into another tab, hoping you didn't grab the similar-vehicle rail.

I got tired of that on my own truck research. So [CurbSpec](https://curbspec.com) has a Chrome extension now. Vehicle-detail pages only — not search results. It looks for that listing's VIN (JSON-LD or a labeled field first), and if it finds one it puts a paper button in the corner: **Check …74884 on CurbSpec**. Click opens the compile form with that VIN and the stated mileage. Nothing is sent until you click. Dismiss it and it's gone for that tab.

I'm submitting it to the Chrome Web Store. Until Google reviews it, load the unpacked `extension/` folder from the CurbSpec repo: Developer mode → Load unpacked. Safari / no-Chrome people get a bookmarklet in the same folder — same prefill, no store.

The phone-at-the-curb path is still paste. This is for the night before, when the listing is already on the screen.
