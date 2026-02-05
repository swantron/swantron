---
title: 'Garage Door Hack'
date: 2011-04-13T21:19:53+00:00
slug: 'garage-door-hack'
featured_image: '/uploads/2011/04/ghetto-fabulus.jpg'
aliases:
  - '/index.php/2011/04/13/garage-door-hack/'
---

Introducing Open-er-o-matic 3000. OOM3K. My finest project to date. I have my Arduino poking around with a PING))) sensor, a servo, some LEDs, and best of all...my garage door opener. End result: some Star Trek-ass shit. ![hit the vid](/uploads/2011/04/ghetto-fabulus.jpg "ghetto-fabulus") Check this footage of the OOM3K in action. Here, I had it configured to open the door when the ultrasonic sensor echoes off of something within 8 cm...



<iframe title="YouTube video player" width="570" height="458" src="https://www.youtube.com/embed/vNHdoPARyLs" frameborder="0" allowfullscreen></iframe>

Not only is this thing awesome, but you can get all sorts of clear looks at my trusty Ronco Showtime rotisserie oven. Yard bird is a big hit at the old Swanson place.

There is not much to this code...I built it on top of the LED binary project code. Prepare for a bitchin' snippet.

```c
//Open-er-o-matic 3000

// Joseph Swanson | 2011
// https://swantron.com

// Setup
// LEDs connected to pins 11, 2-5
// Ping))) sensor signal to pin 7
// Servo signal to pin 10
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
const int pingPin = 7;

// Create variables to store LED states
int ledState1 = LOW;
int ledState2 = LOW;
int ledState3 = LOW;
int ledState4 = LOW;
int ledState5 = LOW;

void setup() {

myservo.attach(10);

//Define pins 1-5 as output
pinMode(ledPin1, OUTPUT);
pinMode(ledPin2, OUTPUT);
pinMode(ledPin3, OUTPUT);
pinMode(ledPin4, OUTPUT);
pinMode(ledPin5, OUTPUT);
}
void loop()
{
 // Reset LEDs levels to low to begin loop
  ledState1 = LOW;
  ledState2 = LOW;
  ledState3 = LOW;
  ledState4 = LOW;
  ledState5 = LOW;
  pos = 0;

// Set duration variable
  long duration, inches, cm;

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
  inches = microsecondsToInches(duration);
  cm = microsecondsToCentimeters(duration);

// Configure this for LED sensitivity
  delay(500);

// March through cm values...output LEDs an servo
  if (cm < 80) {
    ledState1 = HIGH;}

  if (cm < 64) {
    ledState2 = HIGH;}

  if (cm < 48) {
    ledState3 = HIGH;}

  if (cm < 32) {
    ledState4 = HIGH;}

  if (cm < 16) {
    ledState5 = HIGH; }

  if (cm < 16) {
    pos =( pos + 14 ); }

// fire all LED values...fire servo
    digitalWrite(ledPin1, ledState1);
    digitalWrite(ledPin2, ledState2);
    digitalWrite(ledPin3, ledState3);
    digitalWrite(ledPin4, ledState4);
    digitalWrite(ledPin5, ledState5);
    myservo.write(pos);

  delay(100);

}
long microsecondsToInches(long microseconds)
{
  // 1130 feet per second...transofrm inches
  return microseconds / 74 / 2;
}
long microsecondsToCentimeters(long microseconds)
{
  // 340 meters per second...transform cm
  return microseconds / 29 / 2;
}
```

I hope you enjoyed this one. I had a fun time with this piece of crap. Plus, it has given me some ideas of how to extend this setup into something more refined. Spoiler: more awesome.