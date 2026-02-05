---
title: 'Easy LCD Arduino Display'
date: 2011-05-14T19:29:32+00:00
slug: 'easy-lcd-arduino-display'
featured_image: '/uploads/2011/05/Blue-LCD.jpg'
aliases:
  - '/index.php/2011/05/14/easy-lcd-arduino-display/'
---

I am tired of looking at wobbly windows full of Eclipse. The best and worst part of the IOIO board is the fact that the libraries are Java-centric...unfortunately, I am in the middle of a 'worst' phase. I am sort of stalemated. Unfortunately, my issue lies in something that should be trivial, namely naming. Once I can figure out how to orient the crap out of these object-ass pins, I will be good to go. Until then...I am going back to the basics. Processing looks so safe and warm. Coziness, for the win.

How about a 20 by 4 LCD project? Okay.

![+1 blue](/uploads/2011/05/Blue-LCD.jpg "Blue-LCD")

I have had this sitting on the workbench of bad lab for a while. Time to get after it.

The unit came assembled, minus the jumpers I needed to plug this into my breadboard for prototyping. Coincidentally, my soldering station needed to come out of retirement. Sixteen pins...sounds about perfect.




![those.](/uploads/2011/05/soldering-wire.jpg "soldering-wire")

I snagged the unit from hacktronics.com. Their [website](http://www.hacktronics.com/) has details on the pin-level for the LCD unit. Pretty straight forward...slam it together and feed it a string or four. Wiring as follows:

![+ several wires](/uploads/2011/05/Arduino-LCD.jpg "Arduino-LCD")

It has been a while since we have had a snippet. Fair enough; queue the snippet:

```c
// LCD sandbox
// https://swantron.com
// 2011

#include <LiquidCrystal.h>

// **Define pins**
// LCD RS - pin 12
// LCD R/W - pin 11
// LCD ENABLE - pin 10
// LCD BACK+ - pin 13
// LCD DATA4 - pin 5
// LCD DATA5 - pin 4
// LCD DATA6 - pin 3
// LCD DATA7 - pin 2
// LCD VSS, CONTRAST,  BACK- - ground

LiquidCrystal lcd(12, 11, 10, 5, 4, 3, 2);

int backLight = 13;    // Define pin for backlight

void setup()
{
  pinMode(backLight, OUTPUT);
  digitalWrite(backLight, HIGH); // Backlight level (LOW / HIGH)
  lcd.begin(20,4);               // (Columbs, Rows)
  lcd.clear();                   // Clear screen
  lcd.setCursor(0,0);            // Move cursor, print
  lcd.print("liquid      |   swan");
  lcd.setCursor(0,1);            // Move cursor, print
  lcd.print("crystal     |   tron");
  lcd.setCursor(0,2);            // Move cursor, print
  lcd.print("display     |    dot");
  lcd.setCursor(0,3);            // Move cursor, print
  lcd.print("(FTW)       |    com");
}

void loop()
{
}
```

That is that. Again, the potentials for this sucker are vast. I would like to to let this rip with my PING sensor, but need to throw some more effort towards the IOIO. Java schmava. Stay tuned for a bad assed project of some nature...even plan B is pretty awesome these days.