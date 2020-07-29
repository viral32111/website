<?php

/****************************************************************
Setup the script
****************************************************************/

// Include other scripts
require( 'php/protect.php' );
require( 'php/parser.php' );
require( 'php/announcements.php' );
require( 'php/utility.php' );

/****************************************************************
Define variables for later use
****************************************************************/

/******** EMAIL PROTECTION ********/

// TODO: Rewrite me & php/protect.php
/*
$isBot = Protection\UserAgent\IsBot( $_SERVER[ 'HTTP_USER_AGENT' ] );
$emailLink = '';
$emailAddress = Protection\Encode('[email protected]');
if ( $isBot === FALSE ) {
	$emailLink = ' href="' . Protection\Encode('mailto:viral32111@pm.me') . '?subject=Contact"';
	$emailAddress = Protection\Encode('viral32111@pm.me');
}
*/

/******** REQUEST TIME ********/

// Parse the time the request was received into a datatime object
$requestReceived = DateTime::createFromFormat( 'U.u', $_SERVER[ 'REQUEST_TIME_FLOAT' ] );

// Convert that parsed request time to the default timezone - which should be UTC!
$requestReceived->setTimezone( new DateTimeZone( date_default_timezone_get() ) );

/******** PAGE CONTENT ********/

// Regular expressions for getting the internal format from a mime type
$mimeLookup = [
	'/^(?>text|\*)\/(?>html|\*)$/' => 'html',
	'/^(?>text|\*)\/(?>plain|\*)$/' => 'text'
];

// The default requested format
$requestedFormat = 'html';

// Is the format querystring valid?
if ( array_key_exists( $_GET[ 'format' ] ?? '', $formats ) === TRUE ) {

	// Set the requested format variable
	$requestedFormat = $_GET[ 'format' ];

// Is the highest Accept header value valid?
} elseif ( ( $accept = parseAcceptHeader() ) !== NULL ) {

	// Loop through every accept header value
	foreach ( $accept as $type => $weight ) {

		// Loop through all mime lookup patterns
		foreach ( $mimeLookup as $pattern => $format ) {

			// Does this accept value match this lookup pattern?
			if ( preg_match( $pattern, $type ) === 1 ) {

				// Set the requested format variable
				$requestedFormat = $format;

				// Break out of both loops
				break 2;

			}
	
		}

	}

}

// Fetch the page's content as HTML
$page = parseContent( $_SERVER[ 'CONFIG_CONTENT_DIRECTORY' ] . '/' . $_SERVER[ 'PAGE' ] . '.md', $requestedFormat );

// Fetch all of the announcements which are going to be displayed
$announcements = fetchAnnouncements( $_SERVER[ 'CONFIG_CONTENT_DIRECTORY' ] . '/announcements' );

/******** NAVIGATION BAR ********/

// The page definitions
$pages = [

	// Home
	'index' => [ '/', 'Home' ],

	// About
	'about' => [ '/about', 'About' ],

	// Projects
	'projects' => [ '/projects', 'Projects' ],

	// Blog
	'blog/' => [ '/blog', 'Blog' ],

	// Guides
	'guides/' => [ '/guides', 'Guides' ],

	// Community
	'community' => [ '/community', 'Community' ],

	// Contact
	'contact' => [ '/contact', 'Contact' ],

	// Donate
	'donate' => [ '/donate', 'Donate' ]

];

/******** PAGE STATISTICS ********/

// The total number of visitors
$pageViewsTotal = 324;

// The total number of visitors via Tor
$pageViewsTor = 5;

// The total number of visitors via CLI
$pageViewsCLI = 12;

// The total number of unique visitors
$pageViewsUnique = 32;

/******** HTML METADATA ********/

// The parsed metadata
$metadata = $page[ 'metadata' ];

// The tab title
$title = ( isset( $_SERVER[ 'REDIRECT_STATUS' ] ) === TRUE ? $_SERVER[ 'REDIRECT_STATUS' ] : $metadata[ 'title' ] );

// The opengraph URL
$url = $_SERVER[ 'SCRIPT_URI' ];

/****************************************************************
Output the content
****************************************************************/

/******** TEXT ********/
if ( $requestedFormat === 'text' ) {
	header( 'Content-Type: text/plain; charset=utf-8' );
	exit( $page[ 'content' ] );
}

/******** HTML ********/

?>
<!DOCTYPE html>
<html lang="en-GB">
	<head>
		<title><?= $title ?></title>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">

		<meta property="og:type" content="website">
		<meta property="og:site_name" content="viral32111's website">
		<meta property="og:url" content="<?= $url ?>">
		<meta property="og:title" content="<?= $metadata[ 'title' ] ?>">
		<meta property="og:description" content="<?= $metadata[ 'summary' ] ?>">
		<meta property="og:image" content="<?= $metadata[ 'thumbnail' ] ?>">

		<link rel="stylesheet" href="/css/global.css" type="text/css">
		<link rel="stylesheet" href="/css/header.css" type="text/css">
		<link rel="stylesheet" href="/css/announcement.css" type="text/css">
		<link rel="stylesheet" href="/css/content.css" type="text/css">
		<link rel="stylesheet" href="/css/footer.css" type="text/css">

		<link rel="icon" href="/img/avatar.png" type="image/png">
	</head>
	<body>
		<!-- Header -->
		<header>
			<h1><img src="/img/avatar.png" height="29px">viral32111's website</h1>
			<nav>
				<?php foreach ( $pages as $path => $link ) {
					if ( substr( $_SERVER[ 'PAGE' ], 0, strlen( $path ) ) === $path ) {
						echo( '<a href="' . $link[ 0 ] . '" class="selected">[' . $link[ 1 ] . ']</a>' . "\n" );
					} else {
						echo( '<a href="' . $link[ 0 ] . '">[' . $link[ 1 ] . ']</a>' . "\n" );
					}
				} ?>
			</nav>
		</header>

		<!-- Divider -->
		<hr>

		<!-- Announcements -->
		<?php if ( count( $announcements ) > 0 ) {
			echo( '<div id="announcements">' . "\n" );
			foreach ( $announcements as $index => $name ) {
				$announcement = parseContent( $announcementsPath . '/' . $name, 'html' );
				echo( '<div class="announcement">' . "\n" );
				echo( '<h2>' . $announcement[ 'metadata' ][ 'title' ] . '</h2>' . "\n" );
				echo( '<p>' . $announcement[ 'metadata' ][ 'summary' ] . ' <em><a href="/announcements/' . pathinfo( $name, PATHINFO_FILENAME ) . '">Continue reading...</a></em></p>' . "\n" );
				echo( '<footer>' . date( $_SERVER[ 'CONFIG_DATETIME_FORMAT_REGULAR' ], filemtime( $announcementsPath . '/' . $name ) ) . '</footer>' . "\n" );
				echo( '</div>' . "\n" );
			}
			echo( '</div>' . "\n" );
			echo( '<hr>' . "\n" );
		} ?>

		<!-- Bad signature warning -->
		<?php if ( $page[ 'signature' ] === FALSE ) { ?>
			<p id="signature"><strong>WARNING:</strong> The content on this page has a bad digital signature! This could mean somebody is trying to impersonate me, do <u>not</u> trust any of the content written below!
			</p>
			<hr>
		<?php } ?>

		<!-- Content -->
		<div id="content">
			<?php if ( isset( $_SERVER[ 'REDIRECT_STATUS' ] ) === TRUE ) {
				echo( 'this is an error page, ok?<br><pre>' );
				var_dump( $_SERVER );
				echo( '</pre>' );
			} else {
				echo( $page[ 'content' ] . "\n" );
			} ?>
		</div>

		<!-- Divider -->
		<hr>

		<!-- Footer -->
		<footer>
			<p>
				Your request took <?= round( ( microtime( true ) - $_SERVER[ 'REQUEST_TIME_FLOAT' ] ) * 1000, 2 ) ?>ms to process after being received on <?= $requestReceived->format( $_SERVER[ 'CONFIG_DATETIME_FORMAT_PRECISE' ] ) ?>.<br>

				<?php if ( isset( $_SERVER[ 'REDIRECT_STATUS' ] ) !== TRUE ) { ?>
					The content on this page was last modified on <?= date( $_SERVER[ 'CONFIG_DATETIME_FORMAT_REGULAR' ], filemtime( $_SERVER[ 'CONFIG_CONTENT_DIRECTORY' ] . '/' . $_SERVER[ 'PAGE' ] . '.md' ) ) ?>. <a href="/changelog?page=<?= base64URLEncode( $_SERVER[ 'PAGE' ] ); ?>">[Edit History]</a><br>
				<?php } ?>

				The code of this website was last modified on <?= date( $_SERVER[ 'CONFIG_DATETIME_FORMAT_REGULAR' ], filemtime( __FILE__ ) ) ?>. <a href="/changelog">[Changelog]</a><br>

				<?php if ( $page[ 'signature' ] === TRUE ) { ?>
					The content on this page has been digitally signed. <a href="?format=text">[Download Signature]</a> <a href="/public.txt">[Download Public Key]</a><br>
				<?php } ?>

				This page has been viewed <?= $pageViewsTotal === 1 ? $pageViewsTotal . ' time' : $pageViewsTotal . ' times' ?> (<?= $pageViewsTor ?> via Tor, <?= $pageViewsCLI ?> via CLI), <?= $pageViewsUnique === 1 ? $pageViewsUnique . ' of which was' : $pageViewsUnique. ' of which were' ?> unique.
			</p>

			<!-- Legal -->
			<p>
				Copyright &copy; 2016 - <?= date( 'Y' ) ?> viral32111. All rights reserved unless stated otherwise.
				<br>
				<a href="/legal/tos">[Terms of Service]</a>
				<a href="/legal/privacy">[Privacy Policy]</a>
				<a href="/legal/cookies">[Cookie Policy]</a>
				<a href="/legal/thirdparty">[Thirdparty Notices]</a>
				<a href="/sitemap">[Sitemap]</a>
			</p>
		</footer>
	</body>
</html>
