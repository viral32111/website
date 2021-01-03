<?php

// Start the session
session_start();

// The title of this page
$pageTitle = 'Home';

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
			<p>Welcome to my new & improved website!</p>
			<p>I know it might not look like much right now, but I have many more features planned for the future (blog system, onionsite, announcements, native dark mode, etc). The majority of my work over the last 6 months has been programming, configuring and optimising the backend system that runs the website.</p>
			<p>My previous website <a href="https://web.archive.org/web/20200310153357/https://viral32111.com/">(2019-2020)</a>, and the one before that <a href="https://web.archive.org/web/20180826152843/https://viral32111.com/">(2016-2019)</a>, were not that great due to my lack of experience in properly setting up and configuring a website. The first website had plenty of detailed content that explained who I am, showed off some of my projects, etc. The second website however, didn't have any of that and instead was simply my avatar with a dozen or so links below it to my various online profiles on different websites. Sort of pointless, considering I always told people to go to my website if they want to find information about who I am :/</p>
			<p>This website that you're reading right now, launched at the start of 2021, is hopefully going to be my last major redesign & recreation of my website, thanks to all the knowledge and experience I've learned/gained over the last 4-5 years. I intend for this website to be a centralised place where I can describe who I am, showcase my projects & achievements, direct people to my other online profiles, talk to the rest of the Internet through blog posts or guides, allow others to easily personally speak to me, etc.</p>
		</main>

		<!-- Footer -->
		<?php include( 'template/footer.html' ); ?>
	</body>
</html>
