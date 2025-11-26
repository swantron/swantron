---
title: 'Binary Red/Green Snippet'
date: 2010-07-21T20:49:58+00:00
id: 2481
slug: 'binary-redgreen-snippet'
featured_image: '/uploads/2010/07/red-led.jpg'
description: '\n\t\t\t\t\n\t\t\t\t\t\t\t\t'
---

One step closer... Switch open yields a killer red LED... ![red](/uploads/2010/07/red-led.jpg "red-led") Switch closed yields an uber-sexy green LED... ![green](/uploads/2010/07/green-led.jpg "green-led") I even tossed in some 1K resistors to keep my LEDs healthy, in addition to my 100 ohm / 10000 ohm pull-down setup. **+4 resistor**I even managed to comment my code, for a bonus win:
> /\* \* binary red/green led setup \* by Joseph Swanson \* https://swantron.com \*/ int led1 = 11; // green LED (pin 11) int led2 = 12; // red LED (pin 12) int swit= 5; // switch (pin 5) int varr; // to read pin on/off (pin 5) void setup() { pinMode(led1, OUTPUT); // output green pinMode(led2, OUTPUT); // output red pinMode(swit, INPUT); // switch input } void loop(){ varr = digitalRead(swit); // store swit to varr if (varr == LOW) { // button = pressed digitalWrite(led1, HIGH); // trigger green digitalWrite(led2, LOW); // ground red } if (varr == HIGH) { // button != pressed digitalWrite(led1, LOW); // ground green digitalWrite(led2, HIGH); // trigger red } }
**+1 Snippet**I'm getting closer to having this thing behave the way I intend. Stay tuned for a while longer. I'll have a robot up and rolling in no time whatsoever. 