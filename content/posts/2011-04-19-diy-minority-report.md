---
title: 'DIY Minority Report'
date: 2011-04-19T11:34:48+00:00
slug: 'diy-minority-report'
featured_image: '/uploads/2011/04/minority-report.jpg'
aliases:
  - '/index.php/2011/04/19/diy-minority-report/'
---

Spoiler1: This is awesome.
Spoiler2: I've never seen Minority Report.

I do know that there is some sort of hands free interface, and that is what I have put together.

![+1 dizzy](/uploads/2011/04/minority-report.jpg "minority-report")

Long story short, I have extended upon my PING))) project to include some sweet touchless home automation. I have the ultrasonic sensor interfacing with my garage door and a lamp, utilizing a servo and a PowerSwitch Tail, respectively.




*Video contains a rare thumbs up from the author*

<iframe title="YouTube video player" width="570" height="458" src="https://www.youtube.com/embed/sdRrRXs33wo" frameborder="0" allowfullscreen></iframe>

Snippet? Oh, INDEED...

```c
//DIY Minority Report

// Joseph Swanson | 2011
// https://swantron.com

// Setup
// LEDs connected to pins 11, 2-5
// Ping))) sensor signal to pin 7
// Servo signal to pin 10
// PowerSwitch Tail to pin 13
// Ping))) +, servo + to 5V
// Ground the shit out of everything

#include <Servo.h>

Servo myservo;

int pos = 0;

// Pin assignment
const int ledPin1 =  11;
const int ledPin2 =  2;
const int ledPin3 =  3;
const int ledPin4 =  4;
const int ledPin5 =  5;
const int pingPin =  7;
const int lampPin = 13;

// Create variables to store LED states / lamp state
int ledState1 = LOW;
int ledState2 = LOW;
int ledState3 = LOW;
int ledState4 = LOW;
int ledState5 = LOW;
int lampState = LOW;
void setup() {

// Servo pin definition
myservo.attach(10);

//Define pins 1-5, lamp pin as output
pinMode(ledPin1, OUTPUT);
pinMode(ledPin2, OUTPUT);
pinMode(ledPin3, OUTPUT);
pinMode(ledPin4, OUTPUT);
pinMode(ledPin5, OUTPUT);
pinMode(lampPin, OUTPUT);
}
void loop()
{
// Reset LEDs levels to low to begin loop
  ledState1 = LOW;
  ledState2 = LOW;
  ledState3 = LOW;
  ledState4 = LOW;
  ledState5 = LOW;
// Reset Servo position to initial location
  pos = 0;

// Set duration variable
  long duration, cm;

// Loop section for ping signal pin...start as output
  pinMode(pingPin, OUTPUT);
  digitalWrite(pingPin, LOW);
  delayMicroseconds(2);
  digitalWrite(pingPin, HIGH);
  delayMicroseconds(5);
  digitalWrite(pingPin, LOW);

// Listen with same pin
  pinMode(pingPin, INPUT);
  duration = pulseIn(pingPin, HIGH);

// Convert time to a distance
  cm = microsecondsToCentimeters(duration);

// Configure this for LED sensitivity
  delay(100);

// March through cm values...set levels where appropriate
  if (cm < 95) {
    ledState1 = HIGH;}

  if (cm < 60) {
    ledState2 = HIGH;}

  if (cm < 40) {
    ledState3 = HIGH;}

  if (cm < 25) {
    ledState4 = HIGH;}

  if (cm < 10) {
    ledState5 = HIGH;}

  if (cm < 40 && cm >= 30 ) {
    lampState = HIGH;}

  if (cm < 25 && cm >= 15 ) {
    lampState = LOW; }

  if (cm < 10) {
    pos =( pos + 14 ); }

// fire all LED values...fire servo...fire lamp
    digitalWrite(ledPin1, ledState1);
    digitalWrite(ledPin2, ledState2);
    digitalWrite(ledPin3, ledState3);
    digitalWrite(ledPin4, ledState4);
    digitalWrite(ledPin5, ledState5);
    digitalWrite(lampPin, lampState);
    myservo.write(pos);

  delay(100);

}
long microsecondsToCentimeters(long microseconds)
{
  // 340 meters per second...do some math
  return microseconds / 29 / 2;
}
```


As the code implies, I have set this thing up to look for pings in particular regions. The LEDs indicate where I am at, and the rest sort of plays out from there. The lamp is set up as a switch, with ON and OFF having separate regions. The servo/g-door opener is a simple ON when the region is occupied...similar to my previous setup.

Pretty flipping sweet. As usual, send any feedback my way. This is still in the proof-of-concept mode, and will likely get scrapped for parts soon. Not to mention, Katie will probably want to be able to use the garage door opener, which I disconnected to string that wire that I have running manually to the servo. Be prompt.