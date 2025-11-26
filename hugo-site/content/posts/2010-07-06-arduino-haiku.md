---
title: 'Arduino Haiku'
date: 2010-07-06T17:51:15+00:00
id: 2452
slug: 'arduino-haiku'
featured_image: '/uploads/2010/07/arduino-haiku.jpg "arduino-haiku"'
description: '\n\t\t\t\t\n\t\t\t\t\t\t\t\t'
---

I put together a little sketch while I was horsing around with the Arduino serial monitor... ![boo](/uploads/2010/07/arduino-haiku.jpg "arduino-haiku") ...pretty stupid, huh? Especially, since it repeats this horrible haiku every five seconds. Forever. This is, oddly enough, the first thing I have taken the required 10 seconds to add comments to my code, which ought to be worth at least a +1

> /\* \* Awful Haiku \* \* This useless thing prints an aweful haiku \* repeatedly, for no particular reason \* \* courtesy of your friends @ swantron.com \* https://swantron.com \*/ void setup() // reset { Serial.begin(9600); // set serial baud } void loop() // loop area { Serial.println("Haiku "); // start of haiku crap Serial.println("~~~~~"); Serial.println(" "); Serial.println("Arduinos are neat."); Serial.println("You can do a bunch of crap;"); Serial.println("Like print a haiku."); Serial.println(" "); Serial.println(" "); delay(5000); // 5 second delay }
+ 1 Haiku - 1 Awful Haiku + 1 Comments in Code - 1 Useless Program - 1 No LEDs \_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_\_ -1 Total. Sorry for wasting your time. 