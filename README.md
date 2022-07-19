# Website

This is the client-side and most of the dynamic server-side code of my personal website.

This does ***not*** include web server configuration files responsible for some server-side behaviour and redirect links, nor does it include the statically served plain-text files ([it used to, though](https://github.com/viral32111/website/tree/97112bc0af546a18bb101ea2c216911c30ef7e76)).

## History

This repository only contains the source for the *"minimal"* version of my website on the `viral32111.com` domain (so the current one).

Any previous websites I had, including older versions of my personal ones (`viralstudios.phy.sx`, `viral32111.phy.sx`, etc.) and all of my community ones (`conspiracyservers.gaming.bz`, `conspiracyservers.co.uk`, `conspiracyservers.com`, etc.), are not available.

## Structure

### Static

Static content is served by NGINX.

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
    steam-default-avatar.png
  download/ (do not include in Git)
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

Dynamically-generated content is served by Apache.

```
dynamic/
  include/
    template/
      header.php
      footer.php
    credentials.php
    handlers.php
  script/
    index.php
    error.php
  page/
    legal/
      terms-of-service.md
      privacy-policy.md
      thirdparty-notices.md
    home.md
    about.md
    projects.md
    guides.md
    blog.md
    community.md
    contact.md
    donate.md
```

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
