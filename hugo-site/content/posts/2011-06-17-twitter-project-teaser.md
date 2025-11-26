---
title: 'Twitter Project Teaser'
date: 2011-06-17T11:37:14+00:00
id: 3570
slug: 'twitter-project-teaser'
description: '\n\t\t\t\t\n\t\t\t\t\t\t\t\t'
---

A while back, I tossed a little concept video out to the nets regarding CLI interface with my site's comments and an LCD screen. I figured that I could do a similar thing with my Twitter account...spurred largely by [Adafruit's Make it Tweet](http://www.adafruit.com/blog/2011/06/01/adafruit-instructables-make-it-tweet-challenge-2/) challenge. Well, it turns out that Twitter has a few hurdles to jump, in regards to posting tweets to an account. My failed usage from the command line was utilising curl **&gt; curl -u swantron:pass -d status="command line test" http://twitter.com/statuses/update.xml**I was getting an error message, that basic authentication was not supported. For the loss. It turns out that you need a few keys in order to authenticate, which requires registering an app with Twitter... like this \[caption id="attachment\_3571" align="aligncenter" width="570" caption="dev-y"\][![twitter dev account](/uploads/2011/06/twitteroauth.jpg "twitteroauth")](/uploads/2011/06/twitteroauth.jpg)\[/caption\] There we go...keys in hand. Now, I need to figure out how to sew this together using curl or wget. If all else fails, I am pretty sure there is a py library that I can snag. Stay tuned...this one could be fun.