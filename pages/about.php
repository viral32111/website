<?php

// Set the error handlers
include_once( 'handlers.php' );

// Start the session if one hasn't been started already
if ( session_status() === PHP_SESSION_NONE ) session_start();

// The title of this page
$pageTitle = 'About';

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
			<p><em>(This content is copy-pasted from my previous website, I'll rewrite it and make it better at some point in the future.)</em></p>
			<p>I'm a programmer & developer. I primarily code using Python, Lua, C, C#, JavaScript and PHP. However, I'm able to code somewhat well in Java and C++ too.</p>
			<p>Here is a list of various links to my online profiles:</p>
			<ul>
				<li><a href="/twitter">Twitter</a></li>
				<li><a href="/steam">Steam</a></li>
				<li><a href="/reddit">Reddit</a></li>
				<li><a href="/deviantart">DeviantArt</a></li>
				<li><a href="/youtube">YouTube</a></li>
				<li><a href="/twitch">Twitch</a></li>
				<li><a href="/namemc">Minecraft</a></li>
				<li><a href="/myanimelist">MyAnimeList</a></li>
				<li><a href="/github">GitHub</a></li>
				<li><a href="/gmodstore">GmodStore</a></li>
			</ul>
		</main>

		<!-- Footer -->
		<?php include( 'templates/footer.php' ); ?>
	</body>
</html>
