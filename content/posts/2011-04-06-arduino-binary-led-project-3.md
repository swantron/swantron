---
title: 'Arduino Binary LED Project #3'
date: 2011-04-06T11:33:41+00:00
slug: 'arduino-binary-led-project-3'
featured_image: '/uploads/2011/04/binary-code.jpg'
aliases:
  - '/index.php/2011/04/06/arduino-binary-led-project-3/'
---

My LED work-in-progress has manifested itself as a binary counter, with 100 ms accuracy. Like so...

![217](/uploads/2011/04/binary-code.jpg "binary-code")




<iframe title="YouTube video player" width="570" height="458" src="https://www.youtube.com/embed/LMW7c_gKCuE" frameborder="0" allowfullscreen></iframe>

Video of a video, for the win.

So, basically I have put together a counter that will gauge time from 0 to 25.5 seconds...i.e. 100 ms to 25600 ms. Cite the snippet:

```c
//LED Sandbox v2

// Joseph Swanson | 2011
// https://swantron.com

// Setup... LEDs connected to digi 1-8, grounded

// Pin assignment
const int ledPin1 =  1;
const int ledPin2 =  2;
const int ledPin3 =  3;
const int ledPin4 =  4;
const int ledPin5 =  5;
const int ledPin6 =  6;
const int ledPin7 =  7;
const int ledPin8 =  8;

// Create variables to store LED states
int ledState1 = LOW;
int ledState2 = LOW;
int ledState3 = LOW;
int ledState4 = LOW;
int ledState5 = LOW;
int ledState6 = LOW;
int ledState7 = LOW;
int ledState8 = LOW;
// Create timestamp holder

long timeStore1 = 0;
long timeStore2 = 0;
long timeStore3 = 0;
long timeStore4 = 0;
long timeStore5 = 0;
long timeStore6 = 0;
long timeStore7 = 0;
long timeStore8 = 0;
// Configure interval for off/on
long interval1 = 100;
long interval2 = 200;
long interval3 = 400;
long interval4 = 800;
long interval5 = 1600;
long interval6 = 3200;
long interval7 = 6400;
long interval8 = 12800;

void setup() {

  //Define pins 1-6 as output
  pinMode(ledPin1, OUTPUT);
  pinMode(ledPin2, OUTPUT);
  pinMode(ledPin3, OUTPUT);
  pinMode(ledPin4, OUTPUT);
  pinMode(ledPin5, OUTPUT);
  pinMode(ledPin6, OUTPUT);
  pinMode(ledPin7, OUTPUT);
  pinMode(ledPin8, OUTPUT);
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

  if (millis() - timeStore7 > interval7) {
    // re-write timestore
    timeStore7 = millis();

    if (ledState7 == LOW)
      ledState7 = HIGH;
    else
      ledState7 = LOW; }

  if (millis() - timeStore8 > interval8) {
    // re-write timestore
    timeStore8 = millis();

    if (ledState8 == LOW)
      ledState8 = HIGH;
    else
      ledState8 = LOW; }

    // digi-write LED state
    digitalWrite(ledPin1, ledState1);
    digitalWrite(ledPin2, ledState2);
    digitalWrite(ledPin3, ledState3);
    digitalWrite(ledPin4, ledState4);
    digitalWrite(ledPin5, ledState5);
    digitalWrite(ledPin6, ledState6);
    digitalWrite(ledPin7, ledState7);
    digitalWrite(ledPin8, ledState8);
  }
```

Where to next with this effort? I'm thinking that I need to focus on doing this exact thing with fewer pins, and see if I can make that work. I have a few tactile switches around...perhaps some sort of dual-output. Could be cool...stay tuned.