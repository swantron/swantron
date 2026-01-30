---
title: 'Self-Hosting a Bluesky PDS'
date: 2026-01-29T20:15:00+00:00
slug: 'self-hosting-bluesky-pds'
featured_image: '/uploads/2026/01/jswan-dev-atprotocol.png'
aliases:
  - '/index.php/2026/01/29/self-hosting-bluesky-pds/'
---

A few months ago I set up my own Bluesky Personal Data Server (PDS) on Digital Ocean. Been meaning to write about it. I put together a guide for others who want to do the same: [bluesky-pds-guide](https://github.com/swantron/bluesky-pds-guide).

## Why the AT Protocol?

The AT Protocol (Authenticated Transfer Protocol) was created by the Bluesky team. When you use Twitter or Facebook, your data lives on their servers. You're locked in. Platform changes policies, gets acquired, shuts down—you lose everything.

The AT Protocol flips this. Instead of one company owning everyone's data, you can run your own Personal Data Server (PDS). Your posts, follows, and media live on your server. You can move between PDS providers, or run your own, without losing your identity.

It's basically how email works. You can have Gmail or run your own mail server, but you can still email anyone. The AT Protocol brings that same interoperability to social media.

## My Setup: jswan.dev on Digital Ocean

I set up a PDS at `jswan.dev`. Running:

- Digital Ocean droplet ($6/month)
- Domain: jswan.dev (already owned)
- Docker containerized PDS + Caddy for automatic HTTPS
- SQLite database + local disk for media files

Setup was straightforward. The official Bluesky installer handles most of it—sets up Docker, configures Caddy for TLS certificates, gets everything running. Main work was configuring DNS records (A record for root domain, wildcard for subdomains) and running through installer prompts.

![](/uploads/2026/01/jswan-dev-atprotocol.png)

Once it was up, I created an account: `@swantron.jswan.dev`. Handle format is `@username.yourdomain.com`.

![](/uploads/2026/01/bsky-handle.png)

## The Guide

After going through the setup, I realized there wasn't a single guide that walked through everything start to finish. So I made one.

It covers:
- Prerequisites (domain, VPS, email service)
- Setting up a Digital Ocean droplet
- DNS configuration for multiple providers (Squarespace, Namecheap, Cloudflare, GoDaddy)
- Step-by-step installation
- Email/SMTP setup
- Maintenance and updates
- Troubleshooting common issues

Written for people who are technical but maybe haven't self-hosted much.

## The Reality: I Don't Really Use It

I have a Bluesky account at `@swantron.jswan.dev`, and I've set up this whole infrastructure, but I'm not really posting on social media these days. I'm just not that into it.

But that's fine. The point wasn't necessarily to become an active Bluesky user. The point was learning how federated protocols work, understanding how to set up and maintain a service, and having the infrastructure if I want it. If friends want accounts, I can give them invites. The data lives on my server.

Creating the guide was valuable—forced me to think through the process clearly and make it reproducible. Writing things down helps me remember how I did stuff.

## The Cost

Running your own PDS:
- Domain: $10-15/year (if you don't already have one)
- VPS: $6-12/month (Digital Ocean, Vultr, Linode)
- Email: Free tier available (Resend, SendGrid)

Total: around $100/year.

If you're interested in setting up your own PDS, check out the guide: [github.com/swantron/bluesky-pds-guide](https://github.com/swantron/bluesky-pds-guide). And if you want an account on my instance, hit me up—I've got invite codes to spare.
