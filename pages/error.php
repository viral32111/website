<?php

// Start the session if one hasn't been started already
if ( session_status() === PHP_SESSION_NONE ) session_start();

// The title of this page
$pageTitle = $_SERVER[ 'REDIRECT_STATUS' ];

// HTTP status messages
$statusMessages = [
	403 => 'Forbidden',
	404 => 'Not Found',
	410 => 'Gone',
	500 => 'Internal Server Error',
	501 => 'Not Implemented'
];

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
			<p><strong><?= $_SERVER[ 'REDIRECT_STATUS' ] ?></strong> <?= $statusMessages[ $_SERVER[ 'REDIRECT_STATUS' ] ] ?></p>
		</main>

		<!-- Footer -->
		<?php include( 'templates/footer.php' ); ?>
	</body>
</html>
