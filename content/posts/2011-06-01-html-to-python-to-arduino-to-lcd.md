---
title: 'HTML to Python to Arduino to LCD'
date: 2011-06-01T21:42:07+00:00
slug: 'html-to-python-to-arduino-to-lcd'
featured_image: '/uploads/2011/06/outdoor-computer.jpg'
aliases:
  - '/index.php/2011/06/01/html-to-python-to-arduino-to-lcd/'
---

Last week found me standing tall upon my shell script soapbox, shouting command line praises to all who would listen.

*Thou ought direct thine output aftways, to-wards thine USB port of thee. And that is well and righteous.*

Well, that still is the case. My latest project has made it glaringly obvious that sometimes a little Python script will render a whole bunch of shell scripting moot. Namely, parsing HTML. Let's see a picture...

![bad lab mobile](/uploads/2011/06/outdoor-computer.jpg "outdoor-computer")

Lunch hour project: **parse the comments from swantron.com; feed said comments to an LCD screen.**

I was horsing around with wget from a CLI a few days ago. I found myself trying to smash through the resultant file via pure regular expressions...which is incredibly clumsy. Well, as luck would have it, my go-to after my main go-to is Python, and this type of thing has been issue enough to warrant a library. BeautifulSoup. It acts to parse the HTML info into items, that can be smashed around as I see(med) fit.

My setup was simple: py script to snag my comments and write serial, Arduino sketch to drive a LCD and read/write serial. And a source of shade. And a WiFi signal to snag.

![bad lab mobile-mobile](/uploads/2011/06/outdoor-hacking.jpg "outdoor-hacking")

Check, check, check, etc. Video time:

<iframe width="569" height="427" src="https://www.youtube.com/embed/4nyInt_5HHU" frameborder="0" allowfullscreen></iframe>

Pretty slick...hit the fold for the code, as promised, and a summary.

<!--more-->

Python parser / serial writer

```python
#!/usr/bin/python
# https://swantron.com
# htlm grab / parse...
# ...write to serial out
# 2011

admin = [ 'Joseph Swanson' ]
total = True

import urllib2, time, serial, sys
from BeautifulSoup import BeautifulSoup

# disregard spammers | disregard identical posts | create spam zone

spam = []

# initialize serial write to Arduino

ser = serial.Serial('/dev/ttyUSB0', 9600)

time.sleep(5)

# work section

while True:

  # snag html

  html = urllib2.urlopen("https://swantron.com/comments/feed").read()

  # parse

  soup = BeautifulSoup(html)

  # inspect parsed results

  for item in soup('item'):
      badGuy = item('guid')[0].string.split('comment-')[1]

      if badGuy not in spam:

              # spammer jail

              spam.append(badGuy)

              # time modification

              postTime = item('pubdate')[0].string
              parsedTime = time.strptime(postTime, "%a, %d %b %Y %H:%M:%S +0000")
              offsetTime = time.mktime(parsedTime) - time.timezone
              localPostTime = time.strftime("%m/%d/%y %H:%M", time.localtime(offsetTime))

              # identify me

              author = item('dc:creator')[0].string
              if author in admin:
                  print "(" + localPostTime + ") I, " + author + ", just posted a comment"
                  print "    " + item('guid')[0].string
                  print "    " + item('description')[0].string
                  ser.write(item('description')[0].string)
              time.sleep(1)
              elif total:
                  print "(" + localPostTime + ") background noise ~~ " + author
                  print "    " + item('guid')[0].string
                  print "    " + item('description')[0].string
                  ser.write(item('description')[0].string)


  time.sleep(10)
```

Arduino LCD driver

```c
// LCD Driver
// https://swantron.com
// basic serial in > LCD display
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
  lcd.begin(20,4);               // (Columns, Rows)
  Serial.begin(9600);
}

void loop()
{
  // when characters arrive over the serial port...
  if (Serial.available()) {
    // wait a bit for the entire message to arrive
    delay(100);
    // clear the screen
    lcd.clear();
    // read all the available characters
    while (Serial.available() > 0) {
      // display each character to the LCD
      lcd.write(Serial.read());
    }
  }
}
```

I'm excited about this project. Even though this deal is in gen 3, I still have some crazy take-off ideas. Create a secure page on swantron to hold a few values...hook up my old notebook as a base station...home automation on the cheap. Replace that LCD with a sketch to search for a particular string, i.e. "open garage door" and boom, there you go. This could be very cool. Introduce twitter to remove my server from the equation...awesome.

Hit the comments with any improvements or project ideas you can conjure. This one has me excited...feel free to challenge me with something cool. As always, thanks for reading, yadda yadda, stay tuned, etc.