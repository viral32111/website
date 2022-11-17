<?php

// Import required scripts
require_once( 'error.php' );
require_once( 'utilities.php' );
require_once( 'cache.php' );
require_once( 'redis.php' );
require_once( 'csp.php' );

// Start a session if one does not exist
if ( session_status() === PHP_SESSION_NONE ) session_start();

// Get the error code (if one was provided)
if ( isset( $_GET[ "error" ] ) ) {
	$errorCode = $_GET[ "error" ];
	if ( empty( $errorCode ) ) showErrorPage( 400, "No error code provided." );
	showErrorPage( $errorCode );
}

// Get the name of the requested page
if ( !isset( $_GET[ "page" ] ) || empty( $_GET[ "page" ] ) ) showErrorPage( 400, "No page requested." );
$pageName = $_GET[ "page" ];

// Check if the requested page exists
$pageFile = $pageName . ".md";
if ( !is_file( $_SERVER[ "DIRECTORY_MARKDOWN_PAGES" ] . "/" . $pageFile ) ) showErrorPage( 404 );

// Capitalise the name of the page to use as the title
$pageTitle = ucwords( str_replace( '-', ' ', basename( $pageName ) ) );

// Get the description of the page
// TODO: This needs to be fetched metadata within the Markdown file
$pageDescription = "I'm a programmer & developer from the United Kingdom that has many years of experience in nearly every major programming language.";

// The pages to show in the navigation bar
$navigationPages = [ 'home', 'about', 'projects', 'tools', 'blog', 'guides', 'community', 'contact', 'donate' ];

// Generate & add CSP header
$nonces = setContentSecurityPolicy( preg_match( "/\.onion$/", $_SERVER[ "HTTP_HOST" ] ) === 0 );

$pageHTML = Cache::GetMarkdownPage( $pageFile );

?>
<!DOCTYPE html>
<html lang="en-GB">
	<head>

		<!-- The title in the tab -->
		<title><?= $pageTitle ?> - <?= $_SERVER[ "WEBSITE_TITLE" ] ?></title>

		<!-- The character encoding for this page -->
		<meta charset="utf-8">

		<!-- Compatibility with mobile viewers -->
		<meta name="viewport" content="width=device-width,initial-scale=1">

		<!-- Generic data for browsers & search engines -->
		<meta name="url" content="https://<?= $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ] ?>">
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
		<meta name="og:url" content="https://<?= $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ] ?>">
		<meta name="og:site_name" content="<?= $_SERVER[ "WEBSITE_TITLE" ] ?>">
		<meta name="og:title" content="<?= $pageTitle ?>">
		<meta name="og:description" content="<?= $pageDescription ?>">
		<meta name="og:image" content="/image/avatar/embed.webp">
		<meta name="og:image:type" content="image/webp">
		<meta name="og:image:alt" content="viral32111's avatar">
		<meta name="og:locale" content="en_gb">

		<!-- The canonical link -->
		<link rel="canonical" content="https://<?= $_SERVER[ "HTTP_HOST" ] . $_SERVER[ "REQUEST_URI" ] ?>">

		<!-- Import Highlight.js GitHub-themed stylesheet -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/styles/github.min.css" type="text/css" integrity="sha256-Oppd74ucMR5a5Dq96FxjEzGF7tTw2fZ/6ksAqDCM8GY=" crossorigin="anonymous">

		<!-- Import the required stylesheets -->
		<link rel="stylesheet" href="/stylesheet/global.css" type="text/css">
		<link rel="stylesheet" href="/stylesheet/header.css" type="text/css">
		<link rel="stylesheet" href="/stylesheet/footer.css" type="text/css">
		<link rel="stylesheet" href="/stylesheet/content.css" type="text/css">

		<!-- The icon in the tab -->
		<link rel="icon" href="/image/avatar/icon.webp" type="image/webp">

		<!-- Search engine crawling and indexing -->
		<?php if ( isset( $errorCode ) ) { ?>
			<meta name="robots" content="noindex,nofollow,noarchive,noimageindex">
		<?php } else { ?>
			<meta name="robots" content="noarchive,noimageindex">
		<?php } ?>

		<!-- Remove Highlight.js bullshit -->
		<style nonce="<?= $nonces[ "HLJS_STYLE" ] ?>">
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
			<h1><img src="/image/avatar/title.webp" alt="viral32111's avatar" width="29" height="29"><?= $_SERVER[ "WEBSITE_TITLE" ]; ?></h1>

			<!-- Navigation -->
			<nav>
				<?php foreach ( $navigationPages as $navigationPageName ) {

					// Add a clickable link if the file exists
					if ( is_file( $_SERVER[ "DIRECTORY_PAGES" ] . "/" . $navigationPageName . ".md" ) ) {
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
			<p>Copyright &copy; 2016 - <?= date( 'Y' ) ?> viral32111, under the <a class="nobrackets" href="https://www.gnu.org/licenses/agpl-3.0.en.html" target="_blank" rel="noopener noreferrer">GNU Affero General Public License Version 3</a>.</p>

			<!-- Legal pages -->
			<p>
				<a>Terms of Service</a>
				<a href="/legal/privacy-policy">Privacy Policy</a>
				<a href="/legal/cookie-policy">Cookie Policy</a>
				<a href="/legal/third-party-notices">Third-Party Notices</a>
			</p>

			<!-- No JavaScript easter egg -->
			<noscript>
				<p style="color: #fc2a2e; margin-top: 15px; font-style: italic"><code style="padding: 3px;">// NOTE: Syntax highlighting for code blocks is unavailable while JavaScript is disabled.</code></p>
			</noscript>

		</footer>

		<!-- Apply Highlight.js styling -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.6.0/highlight.min.js" integrity="sha256-4v2jQZxK6PbZEeZ2xl2ziov6NHMksBFgBlxtMZVYbQk=" crossorigin="anonymous"></script>
		<script nonce="<?= $nonces[ "HLJS_SCRIPT" ] ?>">hljs.highlightAll();</script>

	</body>

</html>
