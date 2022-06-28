<?php

// Set the error handlers
include_once( 'handlers.php' );

// Start the session if one hasn't been started already
if ( session_status() === PHP_SESSION_NONE ) session_start();

// The title of this page
$pageTitle = 'Cookie Policy';

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
			<p>This website uses just one cookie, that's it. It's not even required, so feel free to block it if that helps you sleep at night.</p>
			<p>The cookie is named <code>__Secure-ID</code>, and is used to resume your browsing session data on this website.</p>
			<p>Technically, this cookie does allow me to uniquely identify you and thus track your visits. If you don't want me to be able to do this then use some sort of privacy protection mode that clears your cookies when the session is over, or just straight up disable cookies on this website.</p>
		</main>

		<!-- Footer -->
		<?php include( 'templates/footer.php' ); ?>
	</body>
</html>
