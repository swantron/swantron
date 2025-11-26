---
title: 'Bluetooth Servo Control Redux'
date: 2011-11-19T17:11:24+00:00
id: 4109
slug: 'bluetooth-servo-control-redux'
featured_image: '/uploads/2011/11/no-cord-570x207.jpg'
description: '\n\t\t\t\t\n\t\t\t\t\t\t\t\t'
---

The project is wrapped. I have fully shown servo control via bluetooth, via Android, via IOIO. +3 via ![usb b gone](/uploads/2011/11/no-cord-570x207.jpg "no-cord") The easiest way to test this, by far, is to snag the app on the Android Market. [Here](https://market.android.com/details?id=swantron.project.servo&feature=search_result#?t=W251bGwsMSwxLDEsInN3YW50cm9uLnByb2plY3Quc2Vydm8iXQ.. "ioio servo controller"): ![servo bluetooth](/uploads/2011/11/servo-bluetooth-570x412.png "servo-bluetooth") This does require a newer version of the IOIO bootloader than is currently shipping from units at Sparkfun, but details can be tracked down at [this Google Groups area](https://groups.google.com/forum/#!forum/ioio-users) on how to update. It will work standardly, with a USB cable. From there, you can take a look at [my code on GitHub](https://github.com/swantron/IOIO-Servo-Controller). ![push to git hub](/uploads/2011/11/git-hub-push-570x394.png "git-hub-push") I haven't included the IOIO libraries, but that will be part of the Eclipse setup if you decide to start hammering out some code. I can provide some guidance if anyone is in need of any. Take a look. I bumped the SDK minimum again, in order to ensure that this function is intact. If this causes any hardship, I can relax the requirement. Anyhow, take a look at the app in action in [the previous post](https://swantron.com/bluetooth-servo-control/ "swantron kicks ass"). Cheers.