<?php

// Set the name of the session cookie
session_name( '__Secure-ID' );

// Allow session responses to be privately cached in browsers
session_cache_limiter( 'private_no_expire' );

// Only cache session responses for 1 hour
session_cache_expire( 60 );

// Set the options of the session cookie
session_set_cookie_params( [

	// Last for 10 years
	'lifetime' => 315576000,

	// Send the cookie to every path
	'path' => '/',

	// Send the cookie to all of this server
	'domain' => '.' . $_SERVER[ 'SERVER_NAME' ],

	// Only send over secure connections
	'secure' => true,

	// Prevent JavaScript from accessing this cookie
	'httponly' => true,

	// Strictly only send to the same site
	'samesite' => 'Strict'

] );

// Start the session for the client
session_start();

?>
