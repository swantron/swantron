---
title: 'Open Drain Example IOIO Android'
date: 2011-08-10T09:16:17+00:00
id: 3735
slug: 'open-drain-example-ioio-android'
description: '\n\t\t\t\t\n\t\t\t\t\t\t\t\t'
---

Hi. This project never ends. I have been cutting my teeth on some electrical engineering 101, in an effort to push 5V through my IOIO. At this point, I am still not able to report a success. I do have the 'open drain' setup working, at a lower voltage than I am intending. My configuration is as follows: \[caption id="attachment\_3737" align="aligncenter" width="570" caption="pulling up to 5V"\][![pull up resistor](/uploads/2011/08/pull-up-resistor.jpg "pull-up-resistor")](/uploads/2011/08/pull-up-resistor.jpg)\[/caption\] The Java snippet that is doing the pin defining is this guy:
> DigitalOutput out = ioio.openDigitalOutput(25, DigitalOutput.Spec.Mode.OPEN\_DRAIN, true);

The only issue is with my setup...for some reason, my circuit isn't able to pull to 5V. See the DMM readout v \[caption id="attachment\_3736" align="aligncenter" width="570" caption="so close..."\][![almost there](/uploads/2011/08/almost-there.jpg "almost-there")](/uploads/2011/08/almost-there.jpg)\[/caption\] So, back to the drawing board. When the switch is open via my app, the pull up resister should settle Vout to 5V. The other half of the scenario is fully functional, as a closed switch grounds as intended. My next plan of attack involves a more permanent power source, and I have placed my order with SparkFun for a surface mount / wall wart combo that will do the trick. I am hoping that my issue is with the power, but time will (shortly) tell if this is the case. Stay tuned. Getting close on this one... 