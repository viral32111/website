<?php
require( 'php/protect.php' );

$isBot = Protection\UserAgent\IsBot( $_SERVER[ 'HTTP_USER_AGENT' ] );

$emailLink = '';
$emailAddress = Protection\Encode('[email protected]');

if ( $isBot === FALSE ) {
	$emailLink = ' href="' . Protection\Encode('mailto:viral32111@pm.me') . '?subject=Contact"';
	$emailAddress = Protection\Encode('viral32111@pm.me');
}


/* Common User-Agents:
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
Baiduspider: Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)
	* Image Search: Baiduspider-image
	* Video Search: Baiduspider-video
	* News Search: Baiduspider-news
	* Baidu wishlists: Baiduspider-favo
	* Baidu Union: Baiduspider-cpro
	* Business Search: Baiduspider-ads
	* Other search pages: Baiduspider
YandexBot: Mozilla/5.0 (compatible; YandexBot/3.0; +http://yandex.com/bots)
Sogou Spider:
	* Sogou Pic Spider/3.0( http://www.sogou.com/docs/help/webmasters.htm#07)
	* Sogou head spider/3.0( http://www.sogou.com/docs/help/webmasters.htm#07)
	* Sogou web spider/4.0(+http://www.sogou.com/docs/help/webmasters.htm#07)
	* Sogou Orion spider/3.0( http://www.sogou.com/docs/help/webmasters.htm#07)
	* Sogou-Test-Spider/4.0 (compatible; MSIE 5.5; Windows 98)
Exabot:
	* Mozilla/5.0 (compatible; Konqueror/3.5; Linux) KHTML/3.5.5 (like Gecko) (Exabot-Thumbnails)
	* Mozilla/5.0 (compatible; Exabot/3.0; +http://www.exabot.com/go/robot)
Facebook External Hit:
	* facebot
	* facebookexternalhit/1.0 (+http://www.facebook.com/externalhit_uatext.php)
	* facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)
Alexa Crawler: ia_archiver (+http://www.alexa.com/site/help/webmasters; crawler@alexa.com)
Archive.org / Archive.is:
	* ia_archiver
	* archive.org_bot
	* ia_archiver-web.archive.org
*/

$dateFormatRegular = 'l jS F Y, H:i:s T';
$dateFormatPrecise = 'l jS F Y, H:i:s.v T';
$requestDate = DateTime::createFromFormat( 'U.u', $_SERVER[ 'REQUEST_TIME_FLOAT' ] );
$requestDate->setTimezone( new DateTimeZone( date_default_timezone_get() ) );
$requestReceived = $requestDate->format( $dateFormatPrecise );

$contentDirectory = '/home/ubuntu2004/github-repositories/viral32111/viral32111.local/content/';

$quotes = [
	'Break the rules. Find your freedom. Live your life.',
	'Freedom is the power to choose your own chains.',
	'Freedom is being you, without anyone\'s permission.',
	'Freedom is the oxygen of the soul',
	'It\'s time to remember what it\'s like to feel alive.',
	'Can you remember who you were before the world told you who you should be?',
	'Normal people have no idea how beautiful the darkness is.',
	'Stars hide your fires; Let not light see my black and deep desires.',
	'I love the sound of heavy rain and thunder on a dark night, I find it peaceful.',
	'Spoiler, we die in the end.',
	'A smooth sea never made a skilled sailor.',
	'Speak your mind, even if your voice shakes.',
	'Do the world a favour, don\'t hide your magic.',
	'Life is so infinitly finite.',
	'I always like tomorrows, I haven\'t made any mistakes yet in tomorrows.',
	'Life is an art of failing magnificently.',
	'I love places that make you realize how tiny you and your problems are.',
	'The reason most goals are not achieved is because we spend our time doing second things first.',
	'Have you come this far to only come this far?'
]

/* metadata for md files:
;title
	* for <title> head tag
	* default if not specified is "viral32111's website"

;summary
	* for meta & opengraph description tags
	* default if not specified is 'Hey, I'm viral32111, A programmer & Developer!'

;thumbnail
	* for opengraph image tag
	* default if not specified is avatar: /img/avatar.png
*/


?>
<!DOCTYPE html>
<html lang="en-GB">
	<head>
		<title>Hello World</title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">

		<?php if ( $_GET[ 'css' ] !== 'disabled' ) { ?>
		<link rel="stylesheet" href="/css/global.css" type="text/css">
		<link rel="stylesheet" href="/css/header.css" type="text/css">
		<link rel="stylesheet" href="/css/announcement.css" type="text/css">
		<link rel="stylesheet" href="/css/content.css" type="text/css">
		<link rel="stylesheet" href="/css/footer.css" type="text/css">
		<?php if ( $_GET[ 'theme' ] === 'dark' ) { ?>
		<link rel="stylesheet" href="/css/dark.css" type="text/css">
		<?php } ?>
		<?php } ?>

		<link rel="icon" href="/img/avatar.png" type="image/png">
	</head>
	<body>
		<!-- Header -->
		<header>
			<h1><img src="/img/avatar.png" height="31px">viral32111's website</h1>
			<nav>
				<a href="/" class="selected">[Home]</a>
				<a href="/about">[About]</a>
				<a href="/projects">[Projects]</a>
				<a href="/blog">[Blog]</a>
				<a href="/guides">[Guides]</a>
				<a href="/community">[Community]</a>
				<a href="/contact">[Contact]</a>
				<a href="/donate">[Donate]</a>
			</nav>
		</header>

		<hr>

		<!-- Announcements -->
		<div id="announcements">
			<div class="announcement">
				<h2>Important Title!</h2>
				<p>This is some important information, you must read it right away! What is love? Baby don't hurt me, don't hurt me, no more! Never gonna give you up, never gonna let you down, never gonna hurt you!</p>
				<footer>Friday 10th July 2020, 18:00:31 UTC.</footer>
			</div>
			<!--<div class="announcement">
				<h1>Important Title!</h1>
				<p>This is some important information, you must read it right away!</p>
				<footer>Friday 10th July 2020 at 18:00:31 UTC.</footer>
			</div>
			<div class="announcement">
				<h1>Important Title!</h1>
				<p>This is some important information, you must read it right away! What is love? Baby don't hurt me, don't hurt me, no more! Never gonna give you up, never gonna let you down, never gonna hurt you!</p>
				<footer>Friday 10th July 2020 at 18:00:31 UTC.</footer>
			</div>-->
		</div>

		<hr>

		<!-- Content -->
		<div id="content">
			<p>You're looking for <strong><?= $_GET[ 'page' ] ?></strong>?</p>

			<?php if ( file_exists( $contentDirectory . $_GET[ 'page' ] . '.md' ) === TRUE ) { ?>
			<p style="color:#008800;">It exists!</p>
		
			<pre><?php echo( file_get_contents( $contentDirectory . $_GET[ 'page' ] . '.md' ) ); ?></pre>
			<?php } else { ?>
			<p style="color:#ff0000;">It does not exist.</p>
			<?php } ?>

			<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rerum, fugiat atque cupiditate laborum dolorem quo? Voluptatibus cumque molestias tenetur dolorem sit? Iure, quo. Hic temporibus placeat tenetur quidem dolore odit.</p>
		</div>

		<hr>

		<!-- Footer -->
		<footer>
			<p>
				Your request took <?= round( ( microtime( true ) - $_SERVER[ 'REQUEST_TIME_FLOAT' ] ) * 1000, 2 ) ?>ms to process from being received on <?= $requestReceived ?>.<br>

				The content on this page was last modified on <?= date( $dateFormatRegular, filemtime( $contentDirectory . $_GET[ 'page' ] . '.md' ) ) ?>. <a href="?changelog">[Changelog]</a><br>

				The code for this website was last modified on <?= date( $dateFormatRegular, filemtime( __FILE__ ) ) ?>. <a href="?changelog">[Changelog]</a><br>

				This page has been viewed 0 times (0 via Tor, 0 via CLI), 0 of which were unique.
			</p>

			<!-- Buttons -->
			<p>
			<?php if ( $_GET[ 'css' ] === 'disabled' ) { ?>
			<a href="?css=enabled">[Enable CSS]</a>
			<?php } else { ?>
			<a href="?css=disabled">[Disable CSS]</a>

			<?php if ( $_GET[ 'theme' ] === 'dark' ) { ?>
			<a href="?theme=light">[Light Theme]</a>
			<?php } else { ?>
			<a href="?theme=dark">[Dark Theme]</a>
			<?php } ?>

			<?php } ?>
			</p>

			<!-- Legal -->
			<p>
				Copyright &copy; 2016 - <?= date( 'Y' ) ?> viral32111. All rights reserved unless stated otherwise.
				<br>
				<a href="/legal/tos.php">[Terms of Service]</a>
				<a href="/legal/privacy.php">[Privacy Policy]</a>
				<a href="/legal/cookies.php">[Cookie Policy]</a>
				<a href="/legal/thirdparty.php">[Thirdparty Notices]</a>
			</p>
		</footer>
	</body>
</html>
