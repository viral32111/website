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

// Are they not logged in and is an authorization header being sent (in response to us sending a www-authenticate request)?
if ( isset( $_SESSION[ 'username' ] ) === FALSE && empty( $requestHeaders[ 'Authorization' ] ) === FALSE ) {

	// Read the credentials file
	$content = file_get_contents( 'credentials.json' );

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
		file_put_contents( 'credentials.json', json_encode( $credentials ) );

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

// Is a file attempting to be downloaded?
if ( empty( $_GET[ 'download' ] ) === FALSE ) {

	// Store the path to this file
	$path = 'dl/' . $_GET[ 'download' ] . '.mp4';

	// Does the file exist?
	if ( is_file( $path ) === TRUE ) {

		// Analyse the file
		$metadata = $getid3->analyze( $path );

		// Calculate the download file name of the file
		$name = $metadata[ 'tags' ][ 'quicktime' ][ 'title' ][ 0 ] ?? basename( $path );

		// Set the length of the content in bytes
		header( 'Content-Length: ' . strval( filesize( $path ) ) );

		// Set the file content type to binary transfer
		header( 'Content-Type: application/octet-stream' );

		// Tell the browser to download the file
		header( 'Content-Disposition: attachment; filename="' . $name . '.mp4"' );

		// Flush the output buffer
		flush();

		// Read the file to the output buffer
		readfile( $path );
		
		// Prevent further execution
		exit();

	}

}

// One quick, simple and easy call to show all downloads
function showDownloads() {

	// Include some global variables into this scope
	global $getid3;

	// Clear the file statistics cache
	clearstatcache();

	// Get the file paths of all MP4 files in the downloads directory
	$files = glob( 'dl/*.mp4' );

	// Create an array of each of the modification time of each file
	$times = array_map( 'filemtime', $files );

	// Sort the file names by oldest to newest modification time
	array_multisort( $times, SORT_ASC, SORT_NUMERIC, $files );

	// Create an empty array for the downloads
	$downloads = [];

	// Begin an unordered list
	echo( "<ul>\n" );

	// Loop through each file path
	foreach ( $files as $file ) {

		// Analyse the file
		$metadata = $getid3->analyze( $file );

		// Copy the file tags to comments
		//$getid3->CopyTagsToComments( $metadata );

		// Is the duration less than 1 minute?
		if ( $metadata[ 'playtime_seconds' ] < 60 ) {

			// Use seconds for the duration
			$duration = round( $metadata[ 'playtime_seconds' ], 0 ) . 's';

		// The duration is greater than 1 minute
		} else {

			// Use minutes for the duration
			$duration = round( $metadata[ 'playtime_seconds' ] / 60, 1 ) . 'm';

		}

		$title = substr( $metadata[ 'tags' ][ 'quicktime' ][ 'title' ][ 0 ], 18 ) ?? basename( $file, '.mp4' );
		$modified = date( 'F jS Y', filemtime( $file ) );

		// Create an associative array with the metadata we want
		/* $downloads[ $file ] = [
			'modified' => filemtime( $file ),
			'size' => round( $metadata[ 'filesize' ] / 1024 / 1024, 1 ) . 'MiB', // Mebibytes
			'title' => $metadata[ 'tags' ][ 'quicktime' ][ 'title' ][ 0 ] ?? basename( $file ),
			'duration' => $duration, // Seconds or minutes
			'resolution' => $metadata[ 'video' ][ 'resolution_y' ] . 'p', // Pixels
			'framerate' => round( $metadata[ 'video' ][ 'frame_rate' ], 2 ) . 'fps', // Frames per second
			'samplerate' => round( $metadata[ 'audio' ][ 'sample_rate' ] / 1000, 1 ) . 'kHz', // Kilohertz
			'channelmode' => ucfirst( $metadata[ 'audio' ][ 'channelmode' ] ) // Mono or Stereo, etc
		]; */

		// Add a list item
		echo( '<li><a href="?download=' . basename( $file, '.mp4' ) . '" title="Size: 0.0MiB&#10;Duration: 0m 0s&#10;Resolution: 1080p (1920x1080)&#10;Frame Rate: 24 frames/sec&#10;Sample Rate: 48khZ&#10;Channel: Stereo">' . $title . '</a> - ' . $modified . "</li>\n" );

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

		<meta property="og:type" content="website">
		<meta property="og:site_name" content="viral32111's website">
		<meta property="og:url" content="https://viral32111.local/rwby/">
		<meta property="og:title" content="RWBY">
		<meta property="og:description" content="Download the latest chapters of RWBY volume 8 exclusive to Rooster Teeth FIRST members.">
		<meta property="og:image" content="img/petal.png">

		<link rel="stylesheet" href="css/global.css" type="text/css">
		<link rel="stylesheet" href="css/responsive.css" type="text/css">

		<link rel="icon" href="img/petal.png" type="image/png">
	</head>
	<body>
		<h1><img src="img/petal.png" height="29px">RWBY</h1>
		<p>Welcome <?= $_SESSION[ 'username']; ?>, here you can download the latest chapters of RWBY volume 8 exclusive to Rooster Teeth FIRST members early & for free without any fustration, slow loading, or advertisements.</p>
		<p>New chapters are not added here the instant they are released as I myself have to download said chapter then upload it, so expect them to be added around 18:00 BST every Saturday.</p>
		<p>If you haven't done so already, I highly recommend watching the <a href="https://twitter.com/OfficialRWBY/status/1306292590900391937" rel="noreferrer">volume 8 trailer</a> before starting the first episode.</p>
		<p><em><strong>Pro-Tip:</strong> Hover over a link for more information about the file.</em></p>
		<?php showDownloads(); ?>
		<p>The links above are strictly download-only and will not stream the content. This is to avoid complaints regarding slow loading or buffering videos that occured because half a dozen people were trying to watch the latest chapter all at once. These downloads will expire after 1 week of being added as that is when they become available to all on <a href="https://roosterteeth.com" rel="noreferrer">Rooster Teeth's website</a>.</p>
		<p>Do not ask for any lower resolution or alternate format downloads as I do not have the time, nor motivation to transcode every single chapter into a dozen different files. I will only share the highest quality as an MP4 file, it is up to you if for whatever reason you require it in a lower quality or alternate format.</p>
		<p>This is a temporary session that will end once you close your web browser, meaning you will be required to sign in when visiting again in the future. Your login credentials are stored securely on this server using <a href="https://en.wikipedia.org/wiki/Bcrypt" rel="noreferrer">bcrypt cryptographic hashes</a>.</p>
		<p>I am offering this service solely based on my trust in everyone who has access to it, so please do not share your login credentials. If this were to happen, I would have no choice but to remove all the content here forever, therefore ruining it for everyone else. If there is somebody else who you know that would like access, speak to me about it and I shall consider granting them their own set of login credentials.</p>
		<p>Thank you, have fun watching.</p>
		<img src="img/selfie.png" height="120px">
	</body>
</html>
