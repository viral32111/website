<?php

// Set the timezone to UTC
date_default_timezone_set( 'UTC' );

// Don't cache this anywhere
header( 'Cache-Control: no-store' );

// Set the name of the session cookie
session_name( '__Secure-RWBYLoginID' );

// Set the options of the session cookie
session_set_cookie_params( [

	// Expire after the browser is closed
	'lifetime' => 0,

	// Only send to this path
	'path' => '/rwby',

	// Only send to this domain
	'domain' => $_SERVER[ 'SERVER_NAME' ],

	// Only send over secure connections
	'secure' => true,

	// Prevent JavaScript from accessing this cookie
	'httponly' => true,

	// Only send to the same site but not strictly
	'samesite' => 'Strict'

] );

// Start a secure session for the client or reuse an existing one
session_start();

// Fetch an array of all request headers
$requestHeaders = apache_request_headers();

// The path to the credentials file
$credentialsPath = '/home/viral32111/credentials.json';

// Are they not logged in and is an authorization header being sent (in response to us sending a www-authenticate request)?
if ( isset( $_SESSION[ 'username' ] ) === FALSE && empty( $requestHeaders[ 'Authorization' ] ) === FALSE ) {

	// Read the credentials file
	$content = file_get_contents( $credentialsPath );

	// Parse the content
	$credentials = json_decode( $content, TRUE );

	// Decode the attempted authorization credentials
	$attempt = base64_decode( substr( $requestHeaders[ 'Authorization' ], 6 ) );

	// Is the attempt invalid?
	if ( preg_match( '/^\w+:.+$/', $attempt ) === 0 ) {

		// Set the status code to bad request
		http_response_code( 400 );

		// Prevent further execution
		exit();

	}

	// Seperate their username and password attempt
	list( $username, $password ) = explode( ':', $attempt );

	// Get the hash of their attempted username
	$usernameHash = hash( 'sha3-512', $username );

	// Is the username not registered or is their password incorrect?
	if ( isset( $credentials[ $usernameHash ] ) === FALSE || password_verify( $password, $credentials[ $usernameHash ] ) === FALSE ) {

		// Set the status code to unauthorised
		http_response_code( 401 );

		// Ask the client to authenticate themselves
		header( 'WWW-Authenticate: Basic realm=RWBY' );

		// Prevent further execution
		exit();

	}

	// Set the session username
	$_SESSION[ 'username' ] = $username;

	// Is the cost of their password hash lower than 12? (they've got a legacy account)
	// REMOVE THIS ONCE NO LEGACY ACCOUNTS ARE LEFT, THIS IS JUST TO UPDATE THEIR PASSWORDS TO USE BETTER SECURITY
	if ( password_get_info( $credentials[ $usernameHash ] )[ 'options' ][ 'cost' ] < 12 ) {

		// Rehash their password and update the credentials
		$credentials[ $usernameHash ] = password_hash( $password, PASSWORD_BCRYPT, [ 'cost' => 12 ] );

		// Save the new credentials to the credentials file
		file_put_contents( $credentialsPath, json_encode( $credentials ) );

	}

// Are they just not logged in? (we haven't sent them a www-authenticate request yet)
} elseif ( isset( $_SESSION[ 'username' ] ) === FALSE ) {

	// Set the status code to unauthorised
	http_response_code( 401 );

	// Ask the client to authenticate themselves
	header( 'WWW-Authenticate: Basic realm=RWBY' );

	// Prevent further execution
	exit();

}

// Import the getID3 library for parsing MP4 metadata (github.com/JamesHeinrich/getID3)
require_once( 'php/getid3/getid3.php' );

// Create a new global instance of getID3
$getid3 = new getID3();

// All the chapters for this volume
$chapters = [
	[
		'title' => 'RWBY - Volume 8 - Chapter 1 - ',
		'path' => NULL,
		'date' => 1604770200
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 2 - ',
		'path' => NULL,
		'date' => 1605375000
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 3 - ',
		'path' => NULL,
		'date' => 1605979800
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 4 - ',
		'path' => NULL,
		'date' => 1606584600
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 5 - ',
		'path' => NULL,
		'date' => 1607189400
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 6 - ',
		'path' => NULL,
		'date' => 1607794200
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 7 - ',
		'path' => NULL,
		'date' => 1608399000
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 8 - ',
		'path' => NULL,
		'date' => 1609003800
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 9 - ',
		'path' => NULL,
		'date' => 1609608600
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 10 - ',
		'path' => NULL,
		'date' => 1610213400
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 11 - ',
		'path' => NULL,
		'date' => 1610818200
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 12 - ',
		'path' => NULL,
		'date' => 1611423000
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 13 - ',
		'path' => NULL,
		'date' => 1612027800
	],
	[
		'title' => 'RWBY - Volume 8 - Chapter 14 - ',
		'path' => NULL,
		'date' => 1612632600
	]
];

// Is a file attempting to be downloaded?
if ( empty( $_GET[ 'dl' ] ) === FALSE ) {

	// Get the index of the file they're trying to download
	$index = intval( $_GET[ 'dl' ] ) - 1;

	// Does this index exist?
	if ( isset( $chapters[ $index ] ) === TRUE ) {

		// Store the chapter
		$chapter = $chapters[ $index ];

		// Is this chapter released?
		if ( $chapter[ 'path' ] !== NULL ) {

			// Store the current unix timestamp
			$now = time();

			// Has this chapter not yet expired?
			if ( ( $chapter[ 'date' ] + 604800 ) > $now ) {

				// Set the length of the content in bytes
				header( 'Content-Length: ' . strval( filesize( $chapter[ 'path' ] ) ) );

				// Set the file content type to binary transfer
				header( 'Content-Type: application/octet-stream' );

				// Tell the browser to download the file
				header( 'Content-Disposition: attachment; filename="' . $chapter[ 'title' ] . '.mp4"' );

				// Flush the output buffer
				flush();

				// Read the file to the output buffer
				readfile( $path );
				
				// Prevent further execution
				exit();

			}

		}

	}

}

// One quick, simple and easy call to show all downloads
function showDownloads() {

	// Include some global variables into this scope
	global $getid3, $chapters;

	// Store the current unix timestamp
	$now = time();

	// Begin an unordered list
	echo( "<ul>\n" );

	// Loop through each file path
	foreach ( $chapters as $index => $chapter ) {

		// When the chapter was/is released
		$released = date( 'F jS Y', $chapter[ 'date' ] );

		// The title of this chapter
		$title = substr( $chapter[ 'title' ], 18 );

		// Is this chapter unreleased?
		if ( $chapter[ 'path' ] === NULL ) {

			// Add the chapter to the list as unreleased
			echo( '<li><a class="unreleased">' . $title . '<em>Releases on ' . $released . "</em></a></li>\n" );

			// Skip ahead to the next iteration
			continue;

		// Is this chapter older than 1 week?
		} elseif ( ( $chapter[ 'date' ]  + 604800 ) < $now ) {

			// Add the chapter to the list as expired
			echo( '<li><a class="expired" title="This download has expired, watch it on Rooster Teeth\'s website instead.&#10;&#10;Released: ' . $released . '">' . $title . "</a></li>\n" );

			// Skip ahead to the next iteration
			continue;

		}

		// Analyse the file
		$metadata = $getid3->analyze( $chapter[ 'path' ] );

		// The duration of this chapter
		$minutes = intval( date( 'i', $metadata[ 'playtime_seconds' ] ) );
		$duration = ( $minutes > 1 ? $minutes . ' minute(s) & ' : '' ) . intval( date( 's', $metadata[ 'playtime_seconds' ] ) ) . ' second(s)';

		// The size of the chapter in mebibytes, megabytes and bytes
		$size = round( $metadata[ 'filesize' ] / 1024 / 1024, 1 ) . ' MiB / ' . round( $metadata[ 'filesize' ] / 1000 / 1000, 1 ) . ' MB (' . number_format( $metadata[ 'filesize' ] ) . ' bytes)';

		// The frame width and frame height of the video stream
		$resolution = $metadata[ 'video' ][ 'resolution_y' ] . 'p (' . $metadata[ 'video' ][ 'resolution_x' ] . 'x' . $metadata[ 'video' ][ 'resolution_y' ] . ')';

		// The frame rate of the video stream
		$framerate = $metadata[ 'video' ][ 'frame_rate' ] . ' frames/second';

		// The sample rate of the audio stream
		$samplerate = number_format( $metadata[ 'audio' ][ 'sample_rate' ] ) . ' Hz';

		// The number of channels in the audio stream
		$channels = $metadata[ 'audio' ][ 'channels' ] . ' (' . ucfirst( $metadata[ 'audio' ][ 'channelmode' ] ) . ')';
	
		// Add the chapter to the list as available to download
		echo( '<li><a href="?dl=' . ( $index + 1 ) . '" title="Size: ' . $size . '&#10;Duration: ' . $duration . '&#10;Resolution: ' . $resolution . '&#10;Frame Rate: ' . $framerate . '&#10;Sample Rate: ' . $samplerate . '&#10;Channel: ' . $channels . '&#10;Released: ' . $released .'">' . $title . "</a></li>\n" );

	}

	// End the unordered list
	echo( "</ul>\n" );

}

?>
<!DOCTYPE html>
<html>
<head>
<title>RWBY</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<link rel="stylesheet" href="css/global.css" type="text/css">
<link rel="stylesheet" href="css/links.css" type="text/css">
<link rel="stylesheet" href="css/responsive.css" type="text/css">
<link rel="icon" href="img/petal.png" type="image/png">
</head>
<body>
<h1><img src="img/petal.png" height="29px">RWBY</h1>
<p>Hey <?= $_SESSION[ 'username']; ?>, here you can download the latest chapters of RWBY volume 8 exclusive to Rooster Teeth FIRST members early & for free without any fustration, slow loading, or advertisements.</p>
<p>New chapters are not added here the instant they are released as I myself have to download said chapter then upload it, so expect them to be added around 18:00 BST every Saturday.</p>
<p>If you have not done so already, I highly recommend watching the <a href="https://twitter.com/OfficialRWBY/status/1306292590900391937" rel="noreferrer">volume 8 trailer</a> before starting the first chapter.</p>
<p><em><strong>Pro-Tip:</strong> Hover over a link for more information about the file.</em></p>
<?php showDownloads(); ?>
<p>The links above are strictly download-only and will not stream the content. This is to avoid complaints regarding slow loading or buffering videos that occured because half a dozen people were trying to watch the latest chapter all at once. These downloads will expire after 1 week of being released as that is when they become available to all on <a href="https://roosterteeth.com" rel="noreferrer">Rooster Teeth's website</a>.</p>
<p>Do not ask for any lower resolution or alternate format downloads as I do not have the time, nor motivation to transcode every single chapter into a dozen different files. I will only share the highest quality as an MP4 file, it is up to you if for whatever reason you require it in a lower quality or alternate format. I also do not provide embedded subtitles for any language.</p>
<p>This is a temporary session that will end once you close your web browser, meaning you will be required to sign in when visiting again in the future. Your login credentials are stored securely on this server using <a href="https://en.wikipedia.org/wiki/Bcrypt" rel="noreferrer">bcrypt cryptographic hashes</a>. Contact me if you want to change your password.</p>
<p>I am offering this service solely based on my trust in everyone who has access to it, so please do not share your login credentials. If this were to happen, I would have no choice but to remove all the content here forever, therefore ruining it for everyone else. If there is somebody else who you know that would like access, speak to me about it and I shall consider granting them their own set of login credentials.</p>
<p>Thank you, have fun watching.</p>
<img src="img/selfie.png" height="120px">
</body>
</html>
