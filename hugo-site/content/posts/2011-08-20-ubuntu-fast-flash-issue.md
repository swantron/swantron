---
title: 'Ubuntu Fast Flash Issue'
date: 2011-08-20T13:06:33+00:00

id: 3757
slug: 'ubuntu-fast-flash-issue'
description: '\n\t\t\t\t\n\t\t\t\t\t\t\t\t'
---

I was horsing around with the Google+ Hangout function last week. In installing the required Google / Flash plugins via Ubuntu Update Manager, I managed to cripple my system. I wiped Flash off of my machine, did a fresh install...the whole works. To no avail. The bug (and fix) were strange enough to warrant a write-up. First, the symptoms were strange. Any Flash video would run super fast...triple speed. While watching Cubs replays in fast forward was sort of amusing, I couldn't get audio to work either. All media was wonky, including streaming audio. I tried to play an MP3 from my hard drive...playback was nonfunctional. That sort of led me to the solution: \[caption id="attachment\_3758" align="aligncenter" width="570" caption="hmm"\][![ubuntu audio problem](/uploads/2011/08/ubuntu-audio-570x491.jpg "ubuntu-audio")](/uploads/2011/08/ubuntu-audio.jpg)\[/caption\] I disabled the HDMI audio function, restarted Firefox, and that was that. Why audio settings would spawn that sort of malfunction is beyond me. I am going to submit a bug report on this guy...too strange to let slip.