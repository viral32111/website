<?php

// Start the session
session_start();

// The title of this page
$pageTitle = 'Community';

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
			<p>This is the community page.</p>
		</main>

		<!-- Footer -->
		<?php include( 'template/footer.html' ); ?>
	</body>
</html>
