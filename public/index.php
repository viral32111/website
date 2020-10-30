<?php

// Start the session
session_start();

?>
<!DOCTYPE html>
<html lang="en-gb">
	<head>
		<!-- Tab title -->
		<title>viral32111's website</title>
	
		<!-- Viewport for mobile viewers -->
		<meta name="viewport" content="width=device-width,initial-scale=1">

		<!-- Generic information -->
		<meta name="url" content="https://viral32111.local/">
		<meta name="description" content="Welcome to my website!">
		<meta name="subject" content="My personal website.">
		<meta name="keywords" content="viral32111,programmer,developer,programming,coding,developing,freelance,conspiracy servers,community">
		<meta name="language" content="en_gb">

		<!-- My information -->
		<meta name="author" content="viral32111,contact@viral32111.com">
		<meta name="owner" content="viral32111,contact@viral32111.com">
		<meta name="copyright" content="viral32111,contact@viral32111.com">

		<!-- Information for embeds -->
		<meta name="og:type" content="website">
		<meta name="og:url" content="https://viral32111.local">
		<meta name="og:site_name" content="viral32111's website">
		<meta name="og:title" content="Home">
		<meta name="og:description" content="Welcome to my website!">
		<meta name="og:image" content="/img/avatar-circle-448.webp">
		<meta name="og:image:type" content="image/webp">
		<meta name="og:image:alt" content="viral32111's avatar">
		<meta name="og:locale" content="en_gb">

		<!-- Required stylesheets -->
		<link rel="stylesheet" href="/css/global.css" type="text/css">
		<link rel="stylesheet" href="/css/header.css" type="text/css">
		<link rel="stylesheet" href="/css/content.css" type="text/css">
		<link rel="stylesheet" href="/css/footer.css" type="text/css">

		<!-- Tab icon -->
		<link rel="icon" href="/img/avatar-circle-128.webp" type="image/webp">

		<!-- Web crawlers/search engine indexers -->
		<meta name="robots" content="index,follow,noarchive,noimageindex">
	</head>
	<body>
		<!-- Header -->
		<header>
			<!-- Title -->
			<h1><img src="/img/avatar-circle-448.webp" alt="viral32111's avatar" height="29px">viral32111's website</h1>

			<!-- Navigation -->
			<nav>
				<a href="/" class="selected">[Home]</a><a href="/about">[About]</a><a href="/projects">[Projects]</a><a href="/blog">[Blog]</a><a href="/guides">[Guides]</a><a href="/community">[Community]</a><a href="/contact">[Contact]</a><a href="/donate">[Donate]</a>
			</nav>
		</header>

		<!-- Divider -->
		<hr>

		<!-- Content -->
		<main>
			<p>Welcome to my website!</p>
			
			<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam tempor et ante in commodo. Integer mauris felis, congue id metus fermentum, rhoncus malesuada metus. Nulla facilisi. Donec pretium arcu bibendum mi luctus, dignissim condimentum nulla tincidunt. Quisque tincidunt varius placerat. Donec posuere nibh in tempor sodales. Quisque tincidunt felis non enim finibus, vitae volutpat enim rutrum. Aenean accumsan aliquam orci, a consequat nunc imperdiet id. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nam sit amet vulputate odio. Sed pulvinar, risus quis varius venenatis, orci dolor sodales nisi, sit amet facilisis nulla ex quis lorem.</p>
				
			<p>Vivamus euismod tristique dolor, eu rhoncus diam. Aliquam placerat justo a orci consectetur tristique. In hac habitasse platea dictumst. Duis et augue eros. Aliquam erat volutpat.</p>
			
			<p>Quisque volutpat vel nisi ac blandit. Curabitur elementum eros nec leo aliquam lobortis. Duis vel ante arcu. Nullam nunc est, rutrum pulvinar elementum sit amet, auctor quis mauris. Nullam ac sollicitudin sem. Duis vitae velit sed justo interdum maximus. Praesent ac nisi massa. Proin euismod nunc non elementum fringilla. Duis ullamcorper augue hendrerit consequat cursus. Suspendisse in ornare lectus. Donec nibh turpis, porta et lorem quis, tristique vestibulum purus.</p>
		</main>

		<!-- Divider -->
		<hr>

		<!-- Footer -->
		<footer>
			<!-- Legal -->
			<p>Copyright &copy; 2016 - <?= date( 'Y' ) ?> viral32111. All rights reserved unless stated otherwise.</p>
			<!-- <a href="/legal/tos">[Terms of Service]</a> -->
			<!-- <a href="/legal/privacy">[Privacy Policy]</a> -->
			<!-- <a href="/legal/cookies">[Cookie Policy]</a> -->
			<!-- <a href="/legal/thirdparty">[Thirdparty Notices]</a> -->
		</footer>
	</body>
</html>
