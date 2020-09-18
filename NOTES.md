## Directory Structure

```
viral32111.local/
	archive/
	content/
		announcements/
		blog/
		guides/
		legal/
		about.md
		community.md
		contact.md
		donate.md
		index.md
		projects.md
	processor/
		gnupg/
		templates/
			base.php
			header.php
			footer.php
		main.php
		announcements.php
		error.php
		protect.php
		utility.php
		virtualhost.conf
	docroot/
		public-key.txt
		sitemap.php
	.gitignore
	NOTES.md
```

## Common User-Agents

* Firefox: Mozilla/5.0 (Windows NT 10.0; rv:78.0) Gecko/20100101 Firefox/78.0
* Firefox Nightly: Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0
* Google Chrome: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36
* Internet Explorer: Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko
* Microsoft Edge: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36 Edg/83.0.478.61
* cURL: curl/7.55.1
* wget: Wget/1.20.3 (linux-gnu)
* Googlebot: Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)
	* Googlebot News: Googlebot-News
	* Googlebot Images: Googlebot-Image/1.0
	* Googlebot Video: Googlebot-Video/1.0
	* Google Adsense: Mediapartners-Google
	* Google Mobile Adsense: (compatible; Mediapartners-Google/2.1; +http://www.google.com/bot.html)
	* Google Mobile: SAMSUNG-SGH-E250/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 UP.Browser/6.2.3.3.c.1.101 (GUI) MMP/2.0 (compatible; Googlebot-Mobile/2.1; +http://www.google.com/bot.html)
	* Google Smartphone: Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)
	* Google AdsBot: AdsBot-Google (+http://www.google.com/adsbot.html)
	* Google App Crawler: AdsBot-Google-Mobile-Apps
* Bingbot: Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)
* Slurp (Yahoo): Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)
* DuckDuckBot: DuckDuckBot/1.0; (+http://duckduckgo.com/duckduckbot.html)
	* Source IP: 72.94.249.34, 72.94.249.35, 72.94.249.36, 72.94.249.37, 72.94.249.38
* Baiduspider: Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)
	* Image Search: Baiduspider-image
	* Video Search: Baiduspider-video
	* News Search: Baiduspider-news
	* Baidu wishlists: Baiduspider-favo
	* Baidu Union: Baiduspider-cpro
	* Business Search: Baiduspider-ads
	* Other search pages: Baiduspider
* YandexBot: Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)
* Sogou Spider:
	* Sogou Pic Spider/3.0( http://www.sogou.com/docs/help/webmasters.htm#07)
	* Sogou head spider/3.0( http://www.sogou.com/docs/help/webmasters.htm#07)
	* Sogou web spider/4.0(+http://www.sogou.com/docs/help/webmasters.htm#07)
	* Sogou Orion spider/3.0( http://www.sogou.com/docs/help/webmasters.htm#07)
	* Sogou-Test-Spider/4.0 (compatible; MSIE 5.5; Windows 98)
* Exabot:
	* Mozilla/5.0 (compatible; Konqueror/3.5; Linux) KHTML/3.5.5 (like Gecko) (Exabot-Thumbnails)
	* Mozilla/5.0 (compatible; Exabot/3.0; +http://www.exabot.com/go/robot)
* Facebook External Hit:
	* facebot
	* facebookexternalhit/1.0 (+http://www.facebook.com/externalhit_uatext.php)
	* facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)
* Alexa Crawler: ia_archiver (+http://www.alexa.com/site/help/webmasters; crawler@alexa.com)
* Archive.org / Archive.is:
	* ia_archiver
	* archive.org_bot
	* ia_archiver-web.archive.org

## Quotes

* Break the rules. Find your freedom. Live your life.
* Freedom is the power to choose your own chains.
* Freedom is being you, without anyone's permission.
* Freedom is the oxygen of the soul
* It's time to remember what it's like to feel alive.
* Can you remember who you were before the world told you who you should be?
* Normal people have no idea how beautiful the darkness is.
* Stars hide your fires; Let not light see my black and deep desires.
* I love the sound of heavy rain and thunder on a dark night, I find it peaceful.
* Spoiler, we die in the end.
* A smooth sea never made a skilled sailor.
* Speak your mind, even if your voice shakes.
* Do the world a favour, don't hide your magic.
* Life is so infinitly finite.
* I always like tomorrows, I haven't made any mistakes yet in tomorrows.
* Life is an art of failing magnificently.
* I love places that make you realize how tiny you and your problems are.
* The reason most goals are not achieved is because we spend our time doing second things first.
* Have you come this far to only come this far?'

## Node.js content markdown parsing script

```js
// Import modules
const fs = require( "fs" )

// Path to the markdown file that needs parsing
const filePath = process.argv[ 2 ]

// Read the markdown file
let fileContents = fs.readFileSync( filePath, {
	encoding: "utf-8"
} ).trim()

// Setup regular expression patterns
const patterns = {
	lists: /^\*\s(.+)/gm,
	underline: /__(.+)__/g,
	warning: /^\$\s(.+)$/gm,
	links: /\[(.+)\]\((.+)\)/gm
}

// Lists
let match0;
while ( ( match0 = patterns.lists.exec( fileContents ) ) !== null ) {
	const html = "<li>" + match0[ 1 ] + "</li>"

	const before = fileContents.substring( 0, match0.index )
	const after = fileContents.substring( match0.index + match0[ 0 ].length )

	fileContents = before + html + after;
}

// Underline
let match1;
while ( ( match1 = patterns.underline.exec( fileContents ) ) !== null ) {
	const html = "<u>" + match1[ 1 ] + "</u>"

	const before = fileContents.substring( 0, match1.index )
	const after = fileContents.substring( match1.index + match1[ 0 ].length )

	fileContents = before + html + after;
}

// Warning
let match2;
while ( ( match2 = patterns.warning.exec( fileContents ) ) !== null ) {
	const html = "<span class=\"warning\">" + match2[ 1 ] + "</span>"

	const before = fileContents.substring( 0, match2.index )
	const after = fileContents.substring( match2.index + match2[ 0 ].length )

	fileContents = before + html + after;
}

// Links
let match3;
while ( ( match3 = patterns.links.exec( fileContents ) ) !== null ) {
	const html = "<a href=\"" + match3[ 2 ] + "\">" + match3[ 1 ] + "</a>"

	const before = fileContents.substring( 0, match3.index )
	const after = fileContents.substring( match3.index + match3[ 0 ].length )

	fileContents = before + html + after;
}

// Paragraphs
let final = ""
fileContents.split( "\n\n" ).forEach( ( value, index ) => {
	let html = "<p>" + value + "</p>\n\n"
	final += html
} )


// Print
console.log( final.trim() )
```

## RWBY shit

```
01-ruby_rose.mp4 : ef347272eecd435eedc80266b2d10402f75f7b55.mp4
02-the_shining_beacon.mp4 : 793119bbdc9c0a58cd4e996d07190776a5a51009.mp4
03-the_shining_beacon_part_2.mp4 : db5723095f643cec9f9cf966e42797958cab5476.mp4
04-the_first_step.mp4 : 788eb03b93aa005834dae142991d28173868ca6d.mp4
05-the_first_step_part_2.mp4 : 55defb638624d2ed897049b22e2cf03d19195525.mp4
06-the_emerald_forest.mp4 : 2361181de03d68cc1a952c588552de4bd1af709e.mp4
07-the_emerald_forest_part_2.mp4 : 1a90f6e16c431b6f6463fc22c6a3283ec445eb01.mp4
08-players_and_pieces.mp4 : 7bed9bcc5d5315b9142c1c6930ffc0866a87a68c.mp4
09-the_badge_and_the_burden.mp4 : 2f350e6f9c8e58da74e011c68fd714f50f18976e.mp4
10-the_badge_and_the_burden_part_2.mp4 : c20dc0381f50cb1aebc79d30ab4447f358abfa8d.mp4
11-jaunedice.mp4 : b7e2fcd81625b17d56112943bdd0dd033cadff3a.mp4
12-jaunedice_part_2.mp4 : a861c9ede1bd90f355799936ee9aae5ab380ee97.mp4
13-forever_fall.mp4 : ece9463954d9810104e5fd86abaca79451ffa794.mp4
14-forever_fall_part_2.mp4 : a138779ccd8455b1f783a0e268882b8187d9a5e8.mp4
```

```
dl/ef347272eecd435eedc80266b2d10402f75f7b55.mp4 = f6a61ba9c071
dl/793119bbdc9c0a58cd4e996d07190776a5a51009.mp4 = f376baa3caea
dl/db5723095f643cec9f9cf966e42797958cab5476.mp4 = 5acc2b9a3a2a
dl/788eb03b93aa005834dae142991d28173868ca6d.mp4 = 3e1eb00e209d
dl/55defb638624d2ed897049b22e2cf03d19195525.mp4 = b1c5e70edb01
dl/2361181de03d68cc1a952c588552de4bd1af709e.mp4 = 6bb07e401266
dl/1a90f6e16c431b6f6463fc22c6a3283ec445eb01.mp4 = c3362f6a6128
dl/7bed9bcc5d5315b9142c1c6930ffc0866a87a68c.mp4 = 204d55862cb1
dl/2f350e6f9c8e58da74e011c68fd714f50f18976e.mp4 = 3085ebd283dc
dl/c20dc0381f50cb1aebc79d30ab4447f358abfa8d.mp4 = ca0957a909a2
dl/b7e2fcd81625b17d56112943bdd0dd033cadff3a.mp4 = 72ad2de4f115
dl/a861c9ede1bd90f355799936ee9aae5ab380ee97.mp4 = 4885ef4479cb
dl/ece9463954d9810104e5fd86abaca79451ffa794.mp4 = 36471fe7c36c
dl/a138779ccd8455b1f783a0e268882b8187d9a5e8.mp4 = 28a6e3a62cfa
```

```bash
mv ef347272eecd435eedc80266b2d10402f75f7b55.mp4 f6a61ba9c071.mp4
mv 793119bbdc9c0a58cd4e996d07190776a5a51009.mp4 f376baa3caea.mp4
mv db5723095f643cec9f9cf966e42797958cab5476.mp4 5acc2b9a3a2a.mp4
mv 788eb03b93aa005834dae142991d28173868ca6d.mp4 3e1eb00e209d.mp4
mv 55defb638624d2ed897049b22e2cf03d19195525.mp4 b1c5e70edb01.mp4
mv 2361181de03d68cc1a952c588552de4bd1af709e.mp4 6bb07e401266.mp4
mv 1a90f6e16c431b6f6463fc22c6a3283ec445eb01.mp4 c3362f6a6128.mp4
mv 7bed9bcc5d5315b9142c1c6930ffc0866a87a68c.mp4 204d55862cb1.mp4
mv 2f350e6f9c8e58da74e011c68fd714f50f18976e.mp4 3085ebd283dc.mp4
mv c20dc0381f50cb1aebc79d30ab4447f358abfa8d.mp4 ca0957a909a2.mp4
mv b7e2fcd81625b17d56112943bdd0dd033cadff3a.mp4 72ad2de4f115.mp4
mv a861c9ede1bd90f355799936ee9aae5ab380ee97.mp4 4885ef4479cb.mp4
mv ece9463954d9810104e5fd86abaca79451ffa794.mp4 36471fe7c36c.mp4
mv a138779ccd8455b1f783a0e268882b8187d9a5e8.mp4 28a6e3a62cfa.mp4
```

```
2020-11-07 17:30:00 = 1604770200
2020-11-14 17:30:00 = 1605375000
2020-11-21 17:30:00 = 1605979800
2020-11-28 17:30:00 = 1606584600
2020-12-05 17:30:00 = 1607189400
2020-12-12 17:30:00 = 1607794200
2020-12-19 17:30:00 = 1608399000
2020-12-26 17:30:00 = 1609003800
2021-01-02 17:30:00 = 1609608600
2021-01-09 17:30:00 = 1610213400
2021-01-16 17:30:00 = 1610818200
2021-01-23 17:30:00 = 1611423000
2021-01-30 17:30:00 = 1612027800
2021-02-06 17:30:00 = 1612632600
```

```bash
NOW=$(date) && sudo date -s "2020-11-07 17:30:00 +0000" && touch f6a61ba9c071.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2020-11-14 17:30:00 +0000" && touch f376baa3caea.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2020-11-21 17:30:00 +0000" && touch 5acc2b9a3a2a.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2020-12-28 17:30:00 +0000" && touch 3e1eb00e209d.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2020-12-05 17:30:00 +0000" && touch b1c5e70edb01.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2020-12-12 17:30:00 +0000" && touch 6bb07e401266.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2020-12-19 17:30:00 +0000" && touch c3362f6a6128.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2020-12-26 17:30:00 +0000" && touch 204d55862cb1.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2021-01-02 17:30:00 +0000" && touch 3085ebd283dc.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2021-01-09 17:30:00 +0000" && touch ca0957a909a2.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2021-01-16 17:30:00 +0000" && touch 72ad2de4f115.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2021-01-23 17:30:00 +0000" && touch 4885ef4479cb.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2021-01-30 17:30:00 +0000" && touch 36471fe7c36c.mp4 && sudo date -s "$NOW"
NOW=$(date) && sudo date -s "2021-02-06 17:30:00 +0000" && touch 28a6e3a62cfa.mp4 && sudo date -s "$NOW"
```
