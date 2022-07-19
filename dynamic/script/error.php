<?php

$statusMessages = [
	403 => 'Forbidden',
	404 => 'Not Found',
	410 => 'Gone',
	500 => 'Internal Server Error',
	501 => 'Not Implemented'
];

/*$statusCode = $_SERVER[ "REDIRECT_STATUS" ];
$statusMessage = $statusMessages[ $statusCode ];

$userMessage = getenv( "ERROR_USER_MESSAGE" ) ?? $statusMessage;*/

$userMessage = $userMessage ?? $statusMessages[ $statusCode ];

$PAGE_DIRECTORY = getenv( "PAGE_DIRECTORY" );
$pageName = "error";
$pageTitle = ucfirst( $pageName );
$siteName = "viral32111's website";
$siteUrl = "https://viral32111.com";

$navigationPages = [
	'home',
	'about',
	'projects',
	'tools',
	'blog',
	'guides',
	'community',
	'contact',
	'donate'
];

?>
<!DOCTYPE html>
<html lang="en-gb">
	<head>

		<!-- The title in the tab -->
		<title><?= $pageTitle ?> - <?= $siteName ?></title>

		<!-- The character encoding for this page -->
		<meta charset="utf-8">

		<!-- Compatibility with mobile viewers -->
		<meta name="viewport" content="width=device-width,initial-scale=1">

		<!-- Generic data for browsers & search engines -->
		<meta name="language" content="en_gb">
		<meta name="author" content="viral32111 <contact@viral32111.com>">
		<meta name="owner" content="viral32111 <contact@viral32111.com>">
		<meta name="copyright" content="viral32111 <contact@viral32111.com>">

		<!-- Import the required stylesheets -->
		<link rel="stylesheet" href="stylesheet/global.css" type="text/css">
		<link rel="stylesheet" href="stylesheet/header.css" type="text/css">
		<link rel="stylesheet" href="stylesheet/footer.css" type="text/css">
		<link rel="stylesheet" href="stylesheet/content.css" type="text/css">

		<!-- The icon in the tab -->
		<link rel="icon" href="image/avatar/circle-128.webp" type="image/webp">

		<!-- Do not let search engines crawl and index this page -->
		<meta name="robots" content="noindex,nofollow,noarchive,noimageindex">

	</head>
	<body>

		<!-- Header above the content -->
		<header>

			<!-- Title -->
			<h1><img src="image/avatar/circle-448.webp" alt="viral32111's avatar" height="29px"><?= $siteName; ?></h1>

			<!-- Navigation -->
			<nav>
				<?php foreach ( $navigationPages as $navigationPageName ) {
					if ( is_file( $PAGE_DIRECTORY . "/" . $navigationPageName . ".md" ) ) {
						echo( '<a ' . ( $navigationPageName === $pageName ? ' class="current"' : '' ) . ' href="/' . $navigationPageName . '">' . ucfirst( $navigationPageName ) . '</a>' );
					} else {
						echo( '<a>' . ucfirst( $navigationPageName ) . '</a>' );
					}
				} ?>
			</nav>

		</header>

		<!-- Divider -->
		<hr>

		<!-- The content -->
		<main>

			<!-- Display the error message -->
			<p><?= $userMessage ?></p>

		</main>

		<!-- Divider -->
		<hr>

		<!-- Footer below the content -->
		<footer>

			<!-- Copyright notice -->
			<p>Copyright &copy; 2016 - <?= date( 'Y' ) ?> viral32111. All rights reserved unless stated otherwise.</p>

			<!-- Legal pages -->
			<p>
				<a>Terms of Service</a>
				<a>Privacy Policy</a>
				<a>Cookie Policy</a>
				<a>Third-Party Notices</a>
			</p>

		</footer>

	</body>
</html>
