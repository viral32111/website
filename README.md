# Website

[![CI](https://github.com/viral32111/website/actions/workflows/ci.yml/badge.svg)](https://github.com/viral32111/website/actions/workflows/ci.yml)
[![CodeQL](https://github.com/viral32111/website/actions/workflows/codeql.yml/badge.svg)](https://github.com/viral32111/website/actions/workflows/codeql.yml)
![GitHub tag (with filter)](https://img.shields.io/github/v/tag/viral32111/website?label=Latest)
![GitHub repository size](https://img.shields.io/github/repo-size/viral32111/website?label=Size)
![GitHub release downloads](https://img.shields.io/github/downloads/viral32111/website/total?label=Downloads)
![GitHub commit activity](https://img.shields.io/github/commit-activity/m/viral32111/website?label=Commits)

This is the [source code](/layouts/_default/), [pages](/content/), and [web-server configuration](/nginx.conf) behind [my personal website](https://viral32111.com).

**My website does not always match the state of this repository, sometimes updates are delayed.**

## 📡 Technologies

This website does not use any modern JavaScript-based web frameworks. It is a pure statically generated site from Markdown pages using [Hugo](https://gohugo.io/).

## 🚀 Scans

To ensure best practices and modern web standards are met, the website is continually scanned using the services below.

* [Mozilla Observatory](https://observatory.mozilla.org/analyze/viral32111.com)
* [Hardenize](https://www.hardenize.com/report/viral32111.com)
* [Nu HTML Checker](https://validator.w3.org/nu/?doc=https%3A%2F%2Fviral32111.com)
* [Qualys SSL Labs](https://www.ssllabs.com/ssltest/analyze.html?d=viral32111.com&hideResults=on)
* [PageSpeed Insights](https://pagespeed.web.dev/report?url=https://viral32111.com)
* [CSP Evaluator](https://csp-evaluator.withgoogle.com/)
* [HSTS Preload Check](https://hstspreload.org/?domain=viral32111.com)

## 📥 Usage

Deploy [the pre-made Docker image](https://github.com/viral32111/website/pkgs/container/website) via `docker run -p 80:80 ghcr.io/viral32111/website:hugo`.

## 📜 History

This repository only contains the source code for the *minimalist* design of my website.

Previous websites that I operated are not available in this repository. This includes older versions of my personal websites, and all of my community websites.

* `viralstudios.phy.sx`
* `viral32111.phy.sx`
* `conspiracyservers.gaming.bz`
* `conspiracyservers.co.uk`
* `conspiracyservers.com`

## ⚖️ License

Copyright (C) 2020-2023 [viral32111](https://viral32111.com).

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
