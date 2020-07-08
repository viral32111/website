<?php
namespace Protection;

// Named references for characters used in email addresses
const REFERENCES = array(
	'@' => 'commat',
	':' => 'colon',
	'.' => 'period'
);

// Encode a string of text to HTML character sequences
function Encode( $text ) {

	// Placeholder for the final protected text
	$protected = '';

	// Loop through each character in the text
	foreach ( str_split( $text ) as $character ) {

		// Create an array to hold the encoded versions of this character
		$encodings = array(
			'#'.ord( $character ), // Denary
			'#x'.bin2hex( $character ) // Hexadecimal
		);

		// Try fetch the entity reference for this character
		$reference = $entityReferences[ $character ] ?? null;

		// If there is an entity reference, add it to the encodings array
		if ( is_string( $reference ) ) array_push( $encodings, $reference );

		// Randomly pick an encoding from the array
		$choice = $encodings[ array_rand( $encodings ) ];

		// Append it to the end of the protected text
		$protected .= '&'.$choice.';';
	}

	// Return the final protected text
	return $protected;

}

namespace Protection\UserAgent;

// These user-agents are normal web browsers (serve a HTML version)
const NORMAL = array(
	/* Firefox & Firefox Nightly
		- Mozilla/5.0 (Windows NT 10.0; rv:78.0) Gecko/20100101 Firefox/78.0
		- Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0 */
	'/^Mozilla\/5.0 \(.+\) Gecko\/\d+ Firefox\/[\d.]+/',
);

// These user-agents are command-line viewers (serve a plaintext/ascii version)
const CLI = array(

);

// These user-agents are known bots and web crawlers (remove certain information)
const BOTS = array(

);

// These user-agents are never allowed access to the website (403 forbidden)
const FORBIDDEN = array(

);

// Returns true/false if the specified user-agent is a bot/crawler
function IsBot( $userAgent ) {

	// Temp
	foreach ( NORMAL as $pattern ) {
		if ( preg_match( $pattern, $userAgent ) === 1 ) {
			return FALSE;
		}
	}

	return TRUE;

	// Is the user-agent in BOTS or CLI
}

// Returns true/false if the specified user-agent is a command-line viewer
function IsCLI( $userAgent ) {
	// Is the user-agent in CLI
}

// Returns true/false if the specified user-agent is forbidden
function IsForbidden( $userAgent ) {
	// Is the user-agent in FORBIDDEN
}

/*
Mozilla/5.0 (Windows NT 10.0; rv:78.0) Gecko/20100101 Firefox/78.0
Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:80.0) Gecko/20100101 Firefox/80.0
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36
Mozilla/5.0 (Windows NT 10.0; WOW64; Trident/7.0; rv:11.0) like Gecko
Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36 Edg/83.0.478.61
curl/7.55.1
Wget/1.20.3 (linux-gnu)
Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)
Googlebot-News
Googlebot-Image/1.0
Googlebot-Video/1.0
Mediapartners-Google
(compatible; Mediapartners-Google/2.1; +http://www.google.com/bot.html)
SAMSUNG-SGH-E250/1.0 Profile/MIDP-2.0 Configuration/CLDC-1.1 UP.Browser/6.2.3.3.c.1.101 (GUI) MMP/2.0 (compatible; Googlebot-Mobile/2.1; +http://www.google.com/bot.html)
Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.96 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)
AdsBot-Google (+http://www.google.com/adsbot.html)
AdsBot-Google-Mobile-Apps
Mozilla/5.0 (compatible; Bingbot/2.0; +http://www.bing.com/bingbot.htm)
Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)
DuckDuckBot/1.0; (+http://duckduckgo.com/duckduckbot.html)
Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)
Baiduspider-image
Baiduspider-video
Baiduspider-news
Baiduspider-favo
Baiduspider-cpro
Baiduspider-ads
Baiduspider
Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)
Sogou Pic Spider/3.0( http://www.sogou.com/docs/help/webmasters.htm#07)
Sogou head spider/3.0( http://www.sogou.com/docs/help/webmasters.htm#07)
Sogou web spider/4.0(+http://www.sogou.com/docs/help/webmasters.htm#07)
Sogou Orion spider/3.0( http://www.sogou.com/docs/help/webmasters.htm#07)
Sogou-Test-Spider/4.0 (compatible; MSIE 5.5; Windows 98)
Mozilla/5.0 (compatible; Konqueror/3.5; Linux) KHTML/3.5.5 (like Gecko) (Exabot-Thumbnails)
Mozilla/5.0 (compatible; Exabot/3.0; +http://www.exabot.com/go/robot)
facebot
facebookexternalhit/1.0 (+http://www.facebook.com/externalhit_uatext.php)
facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)
ia_archiver (+http://www.alexa.com/site/help/webmasters; crawler@alexa.com)
ia_archiver
archive.org_bot
ia_archiver-web.archive.org
*/
?>