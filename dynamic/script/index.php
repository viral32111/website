<?php

// Import required scripts
require_once( 'handler.php' );
require_once( 'markdown.php' );

// Start a session if one does not exist
if ( session_status() === PHP_SESSION_NONE ) session_start();

// Get the error code (if one was provided)
if ( isset( $_GET[ "error" ] ) ) {
	$errorCode = $_GET[ "error" ];

	if ( empty( $errorCode ) ) showErrorPage( 400, "No error code provided." );

	$statusCodeMessages = [
		403 => 'Forbidden',
		404 => 'Not Found',
		410 => 'Gone',
		500 => 'Internal Server Error',
		501 => 'Not Implemented'
	];

	showErrorPage( $errorCode, $statusCodeMessages[ $errorCode ] );
}

// Get the name of the requested page
if ( !isset( $_GET[ "page"] ) || empty( $_GET[ "page" ] ) ) showErrorPage( 400, "No page requested." );
$pageName = $_GET[ "page" ];

// Check if the requested page exists
$pageFile = $pageName . ".md";
if ( !is_file( $_SERVER[ "PAGE_DIRECTORY" ] . "/" . $pageFile ) ) showErrorPage( 404, "The requested page does not exist." );

// Capitalise the name of the page to use as the title
$pageTitle = ucfirst( $pageName );

// Get the description of the page
// TODO: This needs to be fetched metadata within the Markdown file
$pageDescription = "This is a placeholder.";

// The pages to show in the navigation bar
$navigationPages = [ 'home', 'about', 'projects', 'tools', 'blog', 'guides', 'community', 'contact', 'donate' ];

// Get the Markdown content of the requested page
// NOTE: This will evaluate any PHP code within the Markdown file
ob_start();
require( $_SERVER[ "PAGE_DIRECTORY" ] . "/" . $pageFile );
$pageContent = ob_get_clean();

// Convert the Markdown content to HTML
$pageHTML = MarkdownToHTML::ConvertString( $pageContent );

?>
<!DOCTYPE html>
<html lang="en-GB">
	<head>

		<!-- The title in the tab -->
		<title><?= $pageTitle ?> - <?= $_SERVER[ "SITE_NAME" ] ?></title>

		<!-- The character encoding for this page -->
		<meta charset="utf-8">

		<!-- Compatibility with mobile viewers -->
		<meta name="viewport" content="width=device-width,initial-scale=1">

		<!-- Generic data for browsers & search engines -->
		<meta name="url" content="<?= $_SERVER[ "SERVER_NAME" ] ?>">
		<meta name="description" content="<?= $pageDescription ?>">
		<meta name="subject" content="<?= $pageDescription ?>">
		<meta name="keywords" content="viral32111,conspiracy servers,brother gaming,programmer,programming,developer,developing,coding,freelance,community">
		<meta name="language" content="en_gb">
		<meta name="author" content="viral32111 <contact@viral32111.com>">
		<meta name="owner" content="viral32111 <contact@viral32111.com>">
		<meta name="copyright" content="viral32111 <contact@viral32111.com>">

		<!-- Data for embeds on other websites -->
		<meta name="theme-color" content="#aea49a"> <!-- Majority color of my avatar -->
		<meta name="og:type" content="website">
		<meta name="og:url" content="<?= $_SERVER[ "SERVER_NAME" ] ?>">
		<meta name="og:site_name" content="<?= $_SERVER[ "SITE_NAME" ] ?>">
		<meta name="og:title" content="<?= $pageTitle ?>">
		<meta name="og:description" content="<?= $pageDescription ?>">
		<meta name="og:image" content="image/avatar/circle-448.webp">
		<meta name="og:image:type" content="image/webp">
		<meta name="og:image:alt" content="viral32111's avatar">
		<meta name="og:locale" content="en_gb">

		<!-- Import Highlight.js GitHub-themed stylesheet -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/styles/github.min.css" type="text/css">

		<!-- Import the required stylesheets -->
		<link rel="stylesheet" href="stylesheet/global.css" type="text/css">
		<link rel="stylesheet" href="stylesheet/header.css" type="text/css">
		<link rel="stylesheet" href="stylesheet/footer.css" type="text/css">
		<link rel="stylesheet" href="stylesheet/content.css" type="text/css">

		<!-- The icon in the tab -->
		<link rel="icon" href="image/avatar/circle-128.webp" type="image/webp">

		<!-- Search engine crawling and indexing -->
		<?php if ( isset( $errorCode ) ) { ?>
			<meta name="robots" content="noindex,nofollow,noarchive,noimageindex">
		<?php } else { ?>
			<meta name="robots" content="index,follow,noarchive,noimageindex">
		<?php } ?>

		<!-- Remove Highlight.js bullshit -->
		<style>
			pre code.hljs {
				padding: 3px 3px 5px 3px;
				background-color: #f6f6f6;
			}

			pre code.hljs * {
				font-family: monospace;
			}
		</style>

	</head>
	<body>

		<!-- Header above the content -->
		<header>

			<!-- Title -->
			<h1><img src="image/avatar/circle-448.webp" alt="viral32111's avatar" height="29px"><?= $_SERVER[ "SITE_NAME" ]; ?></h1>

			<!-- Navigation -->
			<nav>
				<?php foreach ( $navigationPages as $navigationPageName ) {

					// Add a clickable link if the file exists
					if ( is_file( $_SERVER[ "PAGE_DIRECTORY" ] . "/" . $navigationPageName . ".md" ) ) {
						echo( '<a ' . ( $navigationPageName === $pageName ? ' class="current"' : '' ) . ' href="/' . $navigationPageName . '">' . ucfirst( $navigationPageName ) . '</a>' );

					// Otherwise, add a disabled link
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

			<!-- Display the parsed Markdown content -->
			<?= $pageHTML ?>

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

			<!-- No JavaScript easter egg -->
			<noscript>
				<p style="color: #fc2a2e; margin-top: 15px; font-style: italic"><code style="padding: 3px;">// NOTE: Syntax highlighting for code blocks is unavailable while JavaScript is disabled :c</code></p>
			</noscript>

		</footer>

	</body>

	<!-- Apply Highlight.js styling -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/highlight.min.js"></script>
	<script>hljs.highlightAll();</script>

</html>
