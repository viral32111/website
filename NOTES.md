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
