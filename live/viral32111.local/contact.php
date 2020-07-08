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

// Set timezone to UTC
date_default_timezone_set( 'UTC' );
?>
<!DOCTYPE html>
<html lang="en-GB">
	<head>
		<title>Contact</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<?php if ( isset( $_GET[ 'nocss' ] ) == FALSE ) { ?>
		<link rel="stylesheet" href="/css/global.css" type="text/css">
		<link rel="stylesheet" href="/css/responsive.css" type="text/css">
		<link rel="stylesheet" href="/css/markdown.css" type="text/css">
		<?php if ( isset( $_GET[ 'dark' ] ) ) { ?>
		<link rel="stylesheet" href="/css/dark.css" type="text/css">
		<?php } ?>
		<?php } ?>
	</head>
	<body>
		<!-- Header -->
		<header>
			<h1>viral32111's website</h1>
			<nav>
				<a href="/index.php">[Home]</a>
				<a href="/about.php">[About]</a>
				<a href="/projects.php">[Projects]</a>
				<a href="/blog/index.php">[Blog]</a>
				<a href="/guides/index.php">[Guides]</a>
				<a href="/community.php">[Community]</a>
				<a href="/contact.php" class="selected">[Contact]</a>
				<a href="/donate.php">[Donate]</a>
			</nav>
			<hr>
		</header>

		<!-- Content -->
		<p>The ideal way to get in contact with me is to send an email to <a class="noexternal"<?=$emailLink?> rel="noopener noreferrer" title="Open your default email application with a new draft with me as the recipient."><?=$emailAddress?></a>.<br>I check my inbox regularly throughout the week, so expect a reply within a few days.</p>

		<p>Do not bother contacting me on other platforms that I have an account on. If I wish to speak with you on a different platform, I will add that to my reply.</p>

		<p style="margin-bottom: 2px;">If you do not receive a reply, this could mean your email has been flagged by a spam filter and therefore has been rejected. If you do not want this to happen with your email, ensure that:
		<ul style="margin-top: 2px;">
			<li>You are <u>not</u> using suspicious links in your message.</li>
			<li>You are <u>not</u> sending from a throwaway email provider.</li>
			<li>Your email address is <u>not</u> in a known spam blacklist.</li>
			<li>The email server's IP address is <u>not</u> behind a proxy network.</li>
			<li>The email server's IP address is <u>not</u> in a known spam blacklist.</li>
		</ul>

		<p>Whenever possible, write your emails in plaintext instead of HTML mode. This makes it easier for me to read and mitigates security issues such as phishing links and downloading remote content.</p>

		<p>Try to reduce the number of emails you are sending. You should write everything you wish to say in a single email, even if you have multiple unrelated topics you wish to speak about.</p>

		<p>If you need to send files with your message, add them as attachments to the email instead of pasting them inline with the message or uploading them to online file sharing services. The same goes for using shortlink services to reduce the size of, or mask the original link. I do not care about the size of the link. Services like these could be malicious and modify files/links after you submit them, they also tend to serve advertisements and log visitor information.</u>

		<p>Everything mentioned above will also help to reduce the chance of your email being flagged as spam.</p>

		<p>If you care about privacy, consider encrypting your message using <a href="/public.txt" target="_blank" rel="noopener">my public key</a> so that only I can read your message. It would be wise for you to send your public key in your first email to me so that I too may encrypt my replies.</p>

		<p class="warning">Sending junk or any form of spam to my inbox will get you blacklisted until the end of time, so I strongly advise against doing that if you ever wish to speak with me in the future.</p>

		<!-- Footer -->
		<footer>
			<hr>
			<?php if ( $_SERVER[ 'HTTPS' ] == "on" ) { ?>
			<p>This connection is encrypted with <?=$_SERVER[ 'SSL_PROTOCOL' ]?> using <?=$_SERVER[ 'SSL_CIPHER_USEKEYSIZE' ]?>-bit keys (<code><?=$_SERVER[ 'SSL_CIPHER' ]?></code>).</p>
			<?php } else { ?>
			<p>This connection is <u>not</u> encrypted.</p>
			<?php } ?>

			<p>You are viewing a cached copy. Page content last modified at xxxxxxx. <a href="?history">[View history]</a></p>

			<p>This page has been viewed 12,634 times, 176 of those were unique.

			<p>Your request took <?=round( ( microtime( true ) - $_SERVER[ 'REQUEST_TIME_FLOAT' ] ) * 1000, 2 )?>ms to process. Received on <?=date( 'l dS F Y, H:i:s T', $_SERVER[ 'REQUEST_TIME_FLOAT' ] )?>.

			<br><br>

			<?php if ( isset( $_GET[ 'nocss' ] ) ) { ?>
			<a href="/contact.php">[Enable CSS]</a>
			<?php } else { ?>
			<a href="?nocss">[Disable CSS]</a>

			<?php if ( isset( $_GET[ 'dark' ] ) ) { ?>
			<a href="/contact.php">[Use Light Theme]</a>
			<?php } else { ?>
			<a href="?dark">[Use Dark Theme]</a>
			<?php } ?>

			<?php } ?>

			<br><br>

			<a href="/tos.php">[Terms of Service]</a> <a href="/privacy.php">[Privacy Policy]</a> <a href="/cookies.php">[Cookie Policy]</a>

			<br><br>

			<a href="http://viral32111.local">[Surface]</a> <a href="http://viralcra3zyjdrnx2mzve6vn7sdwodwbngrc266s5ybmln3dac3mvhad.onion">[Onion]</a>

			<br>

			<p>Icons provided by <a href="http://famfamfam.com/lab/icons/silk/">Mark James</a> under <a href="https://creativecommons.org/licenses/by/2.5/">CC-BY-2.5</a>.<br>
			Copyright (C) 2020 viral32111.</p>
		</footer>
	</body>
</html>