<?php

// Start the session
session_start();

// Dictionary of error messages
$errorMessages = [

	// Informational
	100 => 'Continue',
	101 => 'Switching Protocols',
	102 => 'Processing',
	103 => 'Early Hints',

	// Success
	200 => 'OK',
	201 => 'Created',
	202 => 'Accepted',
	203 => 'Non-Authoritative Information',
	204 => 'No Content',
	205 => 'Reset Content',
	206 => 'Partial Content',
	207 => 'Multi-Status',
	208 => 'Already Reported',
	226 => 'IM Used',

	// Redirection
	300 => 'Multiple Choices',
	301 => 'Moved Permanently',
	302 => 'Found',
	303 => 'See Other',
	304 => 'Not Modified',
	305 => 'Use Proxy',
	306 => 'Switch Proxy',
	307 => 'Temporary Redirect',
	308 => 'Permanent Redirect',

	// Client Errors
	400 => 'Bad Request',
	401 => 'Unauthorized',
	402 => 'Payment Required',
	403 => 'Forbidden',
	404 => 'Not Found',
	405 => 'Method Not Allowed',
	406 => 'Not Acceptable',
	407 => 'Proxy Authentication Required',
	408 => 'Request Timeout',
	409 => 'Conflict',
	410 => 'Gone',
	411 => 'Length Required',
	412 => 'Precondition Failed',
	413 => 'Payload Too Large',
	414 => 'URI Too Long',
	415 => 'Unsupported Media Type',
	416 => 'Range Not Satisfiable',
	417 => 'Expectation Failed',
	418 => 'I\'m a tealpot',
	421 => 'Misdirected Request',
	422 => 'Unprocessable Entity',
	423 => 'Locked',
	424 => 'Failed Dependency',
	425 => 'Too Early',
	426 => 'Upgrade Required',
	428 => 'Precondition Required',
	429 => 'Too Many Requests',
	431 => 'Request Header Fields Too Large',
	451 => 'Unavailable For Legal Reasons',

	// Server Errors
	500 => 'Internal Server Error',
	501 => 'Not Implemented',
	502 => 'Bad Gateway',
	503 => 'Service Unavailable',
	504 => 'Gateway Timeout',
	505 => 'HTTP Version Not Supported',
	506 => 'Variant Also Negotiates',
	507 => 'Insufficient Storage',
	508 => 'Loop Detected',
	510 => 'Not Extended',
	511 => 'Network Authentication Required'

];

?>
<!DOCTYPE html>
<html lang="en-gb">
	<head>
		<!-- Tab title -->
		<title><?= $_SERVER[ 'REDIRECT_STATUS' ] ?> - viral32111's website</title>
	
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
		<meta name="og:image:type" content="image/png">
		<meta name="og:image:alt" content="viral32111's avatar">
		<meta name="og:locale" content="en_gb">

		<!-- Required stylesheets -->
		<link rel="stylesheet" href="/css/global.css" type="text/css">
		<link rel="stylesheet" href="/css/header.css" type="text/css">
		<link rel="stylesheet" href="/css/content.css" type="text/css">
		<link rel="stylesheet" href="/css/footer.css" type="text/css">

		<!-- Tab icon -->
		<link rel="icon" href="/img/avatar-circle-128.webp" type="image/png">

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
				<a href="/">[Home]</a><a href="/about">[About]</a><a href="/projects">[Projects]</a><a href="/blog">[Blog]</a><a href="/guides">[Guides]</a><a href="/community">[Community]</a><a href="/contact">[Contact]</a><a href="/donate">[Donate]</a>
			</nav>
		</header>

		<!-- Divider -->
		<hr>

		<!-- Content -->
		<main>
			<p>This page does not exist.</p>
			<p>Feel free to <a href="/contact">contact me</a> if you believe there is meant to be a page here.</p>
			</p>
		</main>

		<!-- Divider -->
		<hr>

		<!-- Footer -->
		<footer>
			<!-- Legal -->
			<p>Copyright &copy; 2016 - <?= date( 'Y' ) ?> viral32111. All rights reserved unless stated otherwise.</p>
			<a href="/legal/tos">[Terms of Service]</a>
			<a href="/legal/privacy">[Privacy Policy]</a>
			<a href="/legal/cookies">[Cookie Policy]</a>
			<a href="/legal/thirdparty">[Thirdparty Notices]</a>
		</footer>
	</body>
</html>
