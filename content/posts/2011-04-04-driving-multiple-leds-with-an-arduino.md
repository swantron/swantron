---
title: 'Driving Multiple LEDs with an Arduino'
date: 2011-04-04T19:05:19+00:00
slug: 'driving-multiple-leds-with-an-arduino'
featured_image: '/uploads/2011/04/6shooter.jpg'
aliases:
  - '/index.php/2011/04/04/driving-multiple-leds-with-an-arduino/'
---

I have had a bunch of white LEDs in my Amazon shopping cart for quite some time. I was tossing around the idea of doing a 5x5 cube a while ago, but ran out of steam on that project. I blame the PowerSwitch Tail...I had relays on the brain, big time. Still drafting out my big project on that front; stay tuned for some sweet garage door action. I rarely find my self with two projects in flight, that may actually turn into something, but I just might have stumbled back into the LED arena.

Long story short, I had my Arduino, Mini 9, some white LEDs, and exactly seven jumper wires in my backpack. I stepped upstairs at work for lunch, and decided to horse around with them...see what it takes to run multiple LEDs. Seems basic, and it is. Fortunately...

Here is he setup...

![not much to it](/uploads/2011/04/6shooter.jpg "6shooter")

I put together a little sketch. I managed to grab the time-stamp notion from [this sketch that is included with the IDE](http://www.arduino.cc/en/Tutorial/BlinkWithoutDelay), and run with the rest of it. There will be snippet, but snippet will follow A SWEET VIDEO FTW


<iframe title="YouTube video player" width="570" height="500" src="https://www.youtube.com/embed/4c4XXmJBck4" frameborder="0" allowfullscreen></iframe>

SNIPPET ALERT

```c
//LED Sandbox

// Joseph Swanson | 2011
// https://swantron.com

// Setup... LEDs connected to digi 1-6, grounded

// Pin assignment
const int ledPin1 =  1;
const int ledPin2 =  2;
const int ledPin3 =  3;
const int ledPin4 =  4;
const int ledPin5 =  5;
const int ledPin6 =  6;

// Create variables to store LED states
int ledState1 = LOW;
int ledState2 = LOW;
int ledState3 = LOW;
int ledState4 = LOW;
int ledState5 = LOW;
int ledState6 = LOW;

// Create timestamp holder

long timeStore1 = 0;
long timeStore2 = 0;
long timeStore3 = 0;
long timeStore4 = 0;
long timeStore5 = 0;
long timeStore6 = 0;

// Configure interval for off/on
long interval1 = 600;
long interval2 = 800;
long interval3 = 1000;
long interval4 = 600;
long interval5 = 800;
long interval6 = 1000;

void setup() {

  //Define pins 1-6 as output
  pinMode(ledPin1, OUTPUT);
  pinMode(ledPin2, OUTPUT);
  pinMode(ledPin3, OUTPUT);
  pinMode(ledPin4, OUTPUT);
  pinMode(ledPin5, OUTPUT);
  pinMode(ledPin6, OUTPUT);

}

void loop()
{
  // Loop area...compare config for time to current
  // time...write when config time is reached
  if (millis() - timeStore1 > interval1) {
    // re-write timestore
    timeStore1 = millis();

    // if the LED is off turn it on and vice-versa:
    if (ledState1 == LOW)
      ledState1 = HIGH;
    else
      ledState1 = LOW;}

  if (millis() - timeStore2 > interval2) {
    // re-write timestore
    timeStore2 = millis();

    if (ledState2 == LOW)
      ledState2 = HIGH;
    else
      ledState2 = LOW; }

  if (millis() - timeStore3 > interval3) {
    // re-write timestore
    timeStore3 = millis();

    if (ledState3 == LOW)
      ledState3 = HIGH;
    else
      ledState3 = LOW; }

  if (millis() - timeStore4 > interval4) {
    // re-write timestore
    timeStore4 = millis();

    if (ledState4 == LOW)
      ledState4 = HIGH;
    else
      ledState4 = LOW; }

  if (millis() - timeStore5 > interval5) {
    // re-write timestore
    timeStore5 = millis();

    if (ledState5 == LOW)
      ledState5 = HIGH;
    else
      ledState5 = LOW; }

  if (millis() - timeStore6 > interval6) {
    // re-write timestore
    timeStore6 = millis();

    if (ledState6 == LOW)
      ledState6 = HIGH;
    else
      ledState6 = LOW; }


    // digi-write LED state
    digitalWrite(ledPin1, ledState1);
    digitalWrite(ledPin2, ledState2);
    digitalWrite(ledPin3, ledState3);
    digitalWrite(ledPin4, ledState4);
    digitalWrite(ledPin5, ledState5);
    digitalWrite(ledPin6, ledState6);

  }
```

So, I configured the times to have bulbs one and four blast at 6/10ths of a second, two and five to go at 8/10ths, and three and six to blink every second. Pretty boring, huh. The next plan is to bump that number to 8 LEDs and put together a little binary timer. Then learn how to drive multiple LEDs from the same pin. After that...who knows. I can do whatever I feel like doing, really.