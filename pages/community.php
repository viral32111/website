<?php

// Set the error handlers
include_once( 'handlers.php' );

// Start the session if one hasn't been started already
if ( session_status() === PHP_SESSION_NONE ) session_start();

// The title of this page
$pageTitle = 'Community';

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
			<p>I own a small community that I founded in early 2016 with some friends. We have been going on for around 5 years now and have always kept our very chilled back & relaxed approach towards everything we do. Feel free to hop into <a href="/discord">my Discord server</a> if you wish to join us!</p>
			<p>The community was started up around a Garry's Mod server, but we have since closed that server down and now the community is not focused around anything, instead it is now more of just a casual place to chat and make new friends. Although, we have recently started up a Minecraft server if you enjoy playing that game. However, my Discord server still gets the most attention, with roughly a dozen always active members, around 150 current members and nearly 500 to have ever joined in total.</p>
			<p>I also have a Matrix chat room if you prefer messaging with better privacy and security, the address is <code>#viral32111:matrix.org</code>. Do note however, there are signifigantly less people in it compared to the Discord server.</p>
			<p>Finally, I do also have <a href="/steamgroup">a Steam group</a>. However, the chat is never used and I stopped posting announcements in it some time ago. It is very dead and only exists because it cannot be deleted, so do not bother joining it.</p>
		</main>

		<!-- Footer -->
		<?php include( 'templates/footer.php' ); ?>
	</body>
</html>
