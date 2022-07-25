# Website

This is the source code & web server configurations for my personal website.

## Scans

To ensure best practices and modern web standards have been met, the website is periodically scanned by the following services:

* [Mozilla Observatory](https://observatory.mozilla.org/analyze/viral32111.com)
* [Hardenize](https://www.hardenize.com/report/viral32111.com)
* [Nu HTML Checker](https://validator.w3.org/nu/?doc=https%3A%2F%2Fviral32111.com)
* [Qualys SSL Labs](https://www.ssllabs.com/ssltest/analyze.html?d=viral32111.com&hideResults=on)

## History

This repository only contains the source code for the *minimalist* design of my website.

Previous websites that I have operated are not available in this repository. This includes older versions of my personal ones and all of my community ones.

* `viralstudios.phy.sx`
* `viral32111.phy.sx`
* `conspiracyservers.gaming.bz`
* `conspiracyservers.co.uk`
* `conspiracyservers.com`

## To-Do List

* Donation history table on the donation page.
* History information (including forums) on the community page.
* PGP-signed page verification.
  * Clearsigned pages should be downloadable for manual verification by visitors.
* PGP public key fingerprint on the contact page.
* Styled directory listing for downloads.
* Stripe support on the donation page.
* Repository table on the projects page.
  * Use the existing one I made a while back with the Git HTTP API I made.
  * Add silkicons to third-party notices.
* Tools page.
* Blog system.
* Guides pages.
* Live statistics for Steam Workshop projects.
* Terms of service page.
  * Not applicable at the moment as no service is provided.
* Discord bot information for terms of service and privacy policy.
* User account system
  * Old community forum accounts?
    * View old forum posts, shoutbox messages, post comments.
  * Manage account links to Discord, Steam & Minecraft accounts.
  * Manage "personal data" for all services I've ever provided.
    * Garry's Mod servers
    * Minecraft servers
    * Discord?
    * Options for requesting & deleting the data.
  * For commenting on blog posts and guides.
  * OAuth support when accounts are linked
    * Steam
    * Discord
  * View previous community reports, ban appeals, staff applications, etc.
* Dark theme using CSS `prefers-color-scheme` media query
  * Button to toggle it too (e.g. for when fingerprinting resisting is in use), like on the original design
* Responsive mobile layout.
  * Spaced out navigation links
* Certificate transparency enforcement
  * `Expect-CT` header

## Backwards Compatibility Notes

`steam-default-avatar.png` is available externally from `https://avatars.akamai.steamstatic.com/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg`

## License

Copyright (C) 2020-2022 [viral32111](https://viral32111.com).

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU Affero General Public License as
published by the Free Software Foundation, either version 3 of the
License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU Affero General Public License for more details.

You should have received a copy of the GNU Affero General Public License
along with this program. If not, see https://www.gnu.org/licenses.
