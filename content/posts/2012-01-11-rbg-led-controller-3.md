---
title: 'RBG LED Controller'
date: 2012-01-11T17:10:52+00:00
slug: 'rbg-led-controller-3'
featured_image: '/uploads/2012/01/Android-RBG-IOIO-570x311.jpg'
aliases:
  - '/index.php/2012/01/11/rbg-led-controller-3/'
---

My off-the-cuff remark about building an auxiliary bilirubin light manifested itself into a quick project.

In order to approximate the specific color of the bilirubin lamp, I figured that I would need to provide a means of setting PWM values for the three inputs. I had hard-coded values in Arduino code in the past, so thought about taking that route initially. I blew the dust off my Duemillova, fired up the Arduino IDE, and promptly decided to modify my Java servo PWM code to do the job.

Sort of growing attached to the IOIO...sorry Arduino.

So, the controller was born...IOIORBG.

![RBG ... RGB](/uploads/2012/01/Android-RBG-IOIO-570x311.jpg "Android-RBG-IOIO")

Hit the bump for a video and some more info...

<!--more-->

<iframe width="569" height="386" src="https://www.youtube.com/embed/cQiLr5uGrE4" frameborder="0" allowfullscreen></iframe>

As usual, I posted the [code on github](https://github.com/swantron/IOIORBG "github")...

![git](/uploads/2012/01/LED-RBG-570x348.png "LED-RBG")

For testing purposes, I also dumped the apk on the [Android Market](https://market.android.com/details?id=swantron.project.rbg#?t=W251bGwsMSwxLDIxMiwic3dhbnRyb24ucHJvamVjdC5yYmciXQ.. "Android Market")...

![market](/uploads/2012/01/IOIO-Android-App-570x447.png "IOIO-Android-App")

I have some work to do on my descriptions, but the gist of the setup is:

Red - Pin 10
Gnd - Gnd
Blu - Pin 11
Grn - Pin 12

Give it a try...I'll see about ramping up the output for the baby...