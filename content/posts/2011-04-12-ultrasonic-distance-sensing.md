---
title: 'Ultrasonic Distance Sensing'
date: 2011-04-12T18:09:29+00:00
slug: 'ultrasonic-distance-sensing'
featured_image: '/uploads/2011/04/ultrasonic.jpg'
aliases:
  - '/index.php/2011/04/12/ultrasonic-distance-sensing/'
---

I really should have a running list of these mini-projects I have been cranking out. This one: using a PING))) sensor from Parallax Inc to drive LEDs for a set of values. Sounds boring, but it is sort of cool. Oh cool.

Picture time:

![doing work at work, again](/uploads/2011/04/ultrasonic.jpg "ultrasonic")

Follow the bump for a vid / snippet
<!--more-->
Video time:

<iframe title="YouTube video player" width="570" height="458" src="https://www.youtube.com/embed/12JpMXZUJpM" frameborder="0" allowfullscreen></iframe>

Snippet time:

```c
//Ping LED Levels

// Joseph Swanson | 2011
// https://swantron.com

// Setup
// LEDs connected to pins 11, 2-6
// Ping))) sensor signal to pin 7
// Ping))) + to 5V, - to ground

// Pin assignment
const int ledPin1 =  11;
const int ledPin2 =  2;
const int ledPin3 =  3;
const int ledPin4 =  4;
const int ledPin5 =  5;
const int ledPin6 =  6;

const int pingPin = 7;

// Create variables to store LED states
int ledState1 = LOW;
int ledState2 = LOW;
int ledState3 = LOW;
int ledState4 = LOW;
int ledState5 = LOW;
int ledState6 = LOW;



void setup() {

// Start serial

  Serial.begin(9600);

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


// Reset LEDs levels to low to begin loop

 ledState1 = LOW;
 ledState2 = LOW;
 ledState3 = LOW;
 ledState4 = LOW;
 ledState5 = LOW;
 ledState6 = LOW;

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

// Converttime to a distance

  inches = microsecondsToInches(duration);
  cm = microsecondsToCentimeters(duration);

// Write to serial out
  Serial.print(inches);
  Serial.print("in, ");
  Serial.print(cm);
  Serial.print("cm");
  Serial.println();

// Configure this for fine tuning... 50 is noisy
  delay(75);

// March through cm values...output
  if (cm < 128) {

      ledState1 = HIGH;}


  if (cm < 64) {

      ledState2 = HIGH;}


  if (cm < 32) {

      ledState3 = HIGH;}


  if (cm < 16) {

      ledState4 = HIGH;}


  if (cm < 8) {


      ledState5 = HIGH; }


  if (cm < 4) {

      ledState6 = HIGH;}



// fire all LED values
    digitalWrite(ledPin1, ledState1);
    digitalWrite(ledPin2, ledState2);
    digitalWrite(ledPin3, ledState3);
    digitalWrite(ledPin4, ledState4);
    digitalWrite(ledPin5, ledState5);
    digitalWrite(ledPin6, ledState6);

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

Synopsis time:

The code fires the ultrasonic sensor via a digital pin, listens via the same pin, does a little math to transform times to distances using the speed of sound, takes the distances and writes to various LEDs depending upon the value returned.

Think of the backup collision sensors that ship with many new vehicles...same deal. Instead of firing a speaker, I have fired 6 lights instead...more accurate, FTW!

I sort of want to mount this bad boy on my Trail-90. Or my Yukon...that would be ghetto goddamn fabulous. For real.

Thanks for reading. Happy Tuesday.