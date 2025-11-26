---
title: 'Arduino 120V AC Relay Example'
date: 2011-07-12T21:13:18+00:00
id: 3666
slug: 'arduino-120v-ac-relay-example'
description: '\n\t\t\t\t\n\t\t\t\t\t\t\t\t'
---

I got tired of poking around with LCD drivers with my Arduino. Time for a quick project to mix it up...staring at a surge protector always puts 120V on my mind. As it turns out, I tore apart an old humidifier a while ago on my 'workbench.' Monday night is Katie's reality TV night...time for something sweet. Investigating duty cycles on this plastic fan: \[caption id="attachment\_3669" align="aligncenter" width="570" caption="fan hack"\][![fan hack](/uploads/2011/07/fan-hack.jpg "fan-hack")](/uploads/2011/07/fan-hack.jpg)\[/caption\] I figured that I could horse around with my PowerSwitch Tail, and make it somewhat mimic a PWM 5V setup. I was curious how long I would have to 'pulse' the switch with juice to keep the fan constantly rolling. I started with it fully on, and kicked my 'active' duty cycles lower until I reached a nearly-continual state of motion. Pause for Arduino code snippet:
> /\* PowerSwitch Tail Template - 120V AC Driver w/ LED indicator - Joseph Swanson 2011 | https://swantron.com \*/ void setup() { // declare pins (13, 7) for writing pinMode(13, OUTPUT); pinMode(7, OUTPUT); } void loop() { // Fire relay / LED digitalWrite(13, HIGH); digitalWrite(7, HIGH); // Configure for "on" time delay (50); // Kill relay / LED digitalWrite(13, LOW); digitalWrite(7, LOW); // Configure for "off" time delay (950); }
Pause for a small small-video break: <iframe allowfullscreen="" frameborder="0" height="427" src="http://www.youtube.com/embed/aXMxPQckQ9Q" width="569"></iframe>As that code and vid indicate, 1/20th of a second is all it took to keep the fan rolling, with 19/20th of a second idle. Not bad. Not sure what the takeaway is, but that is something to mention. Put that knowledge somewhere safe, provided the question of humidifier fan duty cycles should spring up. 