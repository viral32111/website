<?php

$pagePath = $_SERVER[ 'REQUEST_URI' ];

$pages = [
	'/' => 'Home',
	'/about' => 'About',
	'/projects' => 'Projects',
	'/blog' => 'Blog',
	'/guides' => 'Guides',
	'/community' => 'Community',
	'/contact' => 'Contact',
	'/donate' => 'Donate'
];

?>

<!-- Header -->
<header>
	<!-- Title -->
	<h1><img src="/images/avatars/circle-448.webp" alt="viral32111's avatar" height="29px"><?= $siteName; ?></h1>

	<!-- Navigation -->
	<nav>
		<?php foreach ( $pages as $path => $name ) {
			echo( '<a href="' . $path . '"' . ( $path === $pagePath ? ' class="selected"' : '' ) . '>[' . $name . ']</a>' );
		} ?>
	</nav>
</header>

<!-- Divider -->
<hr>
