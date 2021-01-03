<?php

// Start the session
session_start();

// The title of this page
$pageTitle = $_SERVER[ 'REDIRECT_STATUS' ];

// HTTP status messages
$statusMessages = [
	307 => 'Temporary Redirect',
	308 => 'Permanent Redirect',
	403 => 'Forbidden',
	404 => 'Not Found',
	410 => 'Gone',
	500 => 'Internal Server Error'
];

?>
<!DOCTYPE html>
<html lang="en-gb">
	<head>
		<!-- Head -->
		<?php include( 'template/head.php' ); ?>
	</head>
	<body>
		<!-- Header -->
		<?php include( 'template/header.php' ); ?>

		<!-- Content -->
		<main>
			<p><strong><?= $_SERVER[ 'REDIRECT_STATUS' ] ?></strong> <?= $statusMessages[ $_SERVER[ 'REDIRECT_STATUS' ] ] ?></p>
		</main>

		<!-- Footer -->
		<?php include( 'template/footer.html' ); ?>
	</body>
</html>
