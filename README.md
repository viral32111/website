# Website

This is the source code & web server configurations for my personal website.

## History

This repository only contains the source code for the *"minimal"* version of my website on the `viral32111.com` domain (so the current one).

Any previous websites I had, including older versions of my personal ones (`viralstudios.phy.sx`, `viral32111.phy.sx`, etc.) and all of my community ones (`conspiracyservers.gaming.bz`, `conspiracyservers.co.uk`, `conspiracyservers.com`, etc.), are not available in this repository.

## Structure Notes

### Static

Static content is served by NGINX in production.

```
static/
  stylesheet/
    global.css
    content.css
    header.css
    footer.css
    dark.css
  image/
    avatar/
      circle-128.webp
      circle-448.webp
  download/
    minecraft-1.16.5-world.tar.xz
    minecraft-1.18-snapshot-world.zip
    minecraft-1.18-world.zip
  robots.txt
  humans.txt
  public.txt
  security.txt
  btc.txt
  xmr.txt
  ads.txt
```

### Dynamic

Dynamically-generated content is served by Apache in production.

```
dynamic/
  include/
    credentials.php
    markdown.php
    error.php
  script/
    .htaccess
    index.php
    error.php
  page/
    legal/
      terms-of-service.md
      privacy-policy.md
      cookie-policy.md
      third-party-notices.md
    home.md
    about.md
    projects.md
    guides.md
    blog.md
    community.md
    contact.md
    donate.md
```

## Backwards Compatibility Notes

`steam-default-avatar.png` can just be got externally from `https://avatars.akamai.steamstatic.com/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg`

### Aliases

* `/stylesheets/` -> `/stylesheet/`
* `/images/avatars/` -> `/image/avatar`
* `/images/` -> `/image/`
* `/minecraft-1.16.5-world.tar.xz` -> `/downloads/minecraft-1.16.5-world.tar.xz`
* `/minecraft-1.18-snapshot-world.zip` -> `/downloads/minecraft-1.18-snapshot-world.zip`
* `/minecraft-1.18-world.zip` -> `/downloads/minecraft-1.18-world.zip`

### Deprecations

* `/report/csp`
* `/report/csp.php`
* `/report/hpkp`
* `/report/hpkp.php`
* `/report/transparency`
* `/report/transparency.php`
* `/report/xss`
* `/report/xss.php`

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
