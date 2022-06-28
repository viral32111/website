<?php

// Set the error handlers
include_once( 'handlers.php' );

// Start the session if one hasn't been started already
if ( session_status() === PHP_SESSION_NONE ) session_start();

// The title of this page
$pageTitle = 'Contact';

?>
<!DOCTYPE html>
<html lang="en-gb">
	<head>
		<!-- Head -->
		<?php include( 'templates/head.php' ); ?>
	</head>
	<body>
		<!-- Header -->
		<?php include( 'templates/header.php' ); ?>

		<!-- Content -->
		<main>
			<p>If you want to get in touch with me about my projects, contracting work, to ask questions or whatever else then I would prefer you contact me <a href="mailto:contact@viral32111.com">via email</a> because it is more organised and professional.
			<p>Please do not try to add me on Steam because I do not have Steam chat notifications enabled, or Discord because that is more of a personal platform for me. The only exception is if you wish to discuss anything related to my community, in that case you could join <a href="/discord">my Discord server</a>.</p>
			<p>If you are privacy-minded like me, then consider encrypting your messages with <a href="/public.txt">my PGP public key</a> before sending them for secure communication. Make sure to send your public key in the initial message else I will not be able to encrypt my replies!</p>
		</main>

		<!-- Footer -->
		<?php include( 'templates/footer.php' ); ?>
	</body>
</html>
