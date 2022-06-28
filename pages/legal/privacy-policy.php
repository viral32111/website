<?php

// Set the error handlers
include_once( 'handlers.php' );

// Start the session if one hasn't been started already
if ( session_status() === PHP_SESSION_NONE ) session_start();

// The title of this page
$pageTitle = 'Privacy Policy';

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
			<p>I value my privacy and security too, so you're probably fine.</p>
			<p>I'll more detailed information here at a later date.</p>
		</main>

		<!-- Footer -->
		<?php include( 'templates/footer.php' ); ?>
	</body>
</html>
