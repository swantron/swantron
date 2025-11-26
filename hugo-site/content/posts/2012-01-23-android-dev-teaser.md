---
title: 'Android Dev Teaser'
date: 2012-01-23T17:15:32+00:00
id: 4308
slug: 'android-dev-teaser'
description: '\n\t\t\t\t\n\t\t\t\t\t\t\t\t'
---

Before the rugrat showed up, I managed to make some progress on my next project. I just realized that I hadn't put together a teaser post, hence this quickie. I started thinking about how to make a better UI to control my [remote control via Android project](https://swantron.com/remote-control-via-android/ "android remote control project"). Instead of going with a touch base, I figured I could implement control utilizing the on-board orientation sensors. This ultimately led to figuring out how to break said values out...a la this little app: ![xyz](/uploads/2012/01/xyz-570x320.png "xyz") I wrote a simple app that dumps the sensor values of each x, y, and z axes, for values between -90 and +90 degrees. The next step would to be to clean up the display, provide some visualizations, (graph-ish perhaps) and use the values to control something physical. No promises on the timeline, but if it gets to be too far out, I will dump this code on GitHub for general public perusal. Back to diapers...