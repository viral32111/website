<?php
require( 'php/protect.php' );

// Set timezone to UTC
date_default_timezone_set( 'UTC' );
?>
<!DOCTYPE html>
<html lang="en-GB">
	<head>
		<title>Contact</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<?php if ( isset( $_GET[ 'nocss' ] ) == FALSE ) { ?>
		<link rel="stylesheet" href="/css/global.css" type="text/css">
		<link rel="stylesheet" href="/css/responsive.css" type="text/css">
		<link rel="stylesheet" href="/css/markdown.css" type="text/css">
		<?php if ( isset( $_GET[ 'dark' ] ) ) { ?>
		<link rel="stylesheet" href="/css/dark.css" type="text/css">
		<?php } ?>
		<?php } ?>
	</head>
	<body>
		<!-- Header -->
		<header>
			<h1>viral32111's website</h1>
			<nav>
				<a href="/index.php">[Home]</a>
				<a href="/about.php">[About]</a>
				<a href="/projects.php">[Projects]</a>
				<a href="/blog/index.php">[Blog]</a>
				<a href="/guides/index.php">[Guides]</a>
				<a href="/community.php">[Community]</a>
				<a href="/contact.php" class="selected">[Contact]</a>
				<a href="/donate.php">[Donate]</a>
			</nav>
			<hr>
		</header>

		<!-- Content -->
		<p>The ideal way to get in contact with me is to send an email to <a class="noexternal" href="<?=protect('mailto:viral32111@pm.me');?>?subject=Contact" rel="noopener noreferrer" title="Open your default email application with a new draft with me as the recipient."><?=protect('viral32111@pm.me');?></a>.<br>I check my inbox regularly throughout the week, so expect a reply within a few days.</p>

		<p>Do not bother contacting me on other platforms that I have an account on. If I wish to speak with you on a different platform, I will add that to my reply.</p>

		<p style="margin-bottom: 2px;">If you do not receive a reply, this could mean your email has been flagged by a spam filter and therefore has been rejected. If you do not want this to happen with your email, ensure that:
		<ul style="margin-top: 2px;">
			<li>You are <u>not</u> using suspicious links in your message.</li>
			<li>You are <u>not</u> sending from a throwaway email provider.</li>
			<li>Your email address is <u>not</u> in a known spam blacklist.</li>
			<li>The email server's IP address is <u>not</u> behind a proxy network.</li>
			<li>The email server's IP address is <u>not</u> in a known spam blacklist.</li>
		</ul>

		<p>Whenever possible, write your emails in plaintext instead of HTML mode. This makes it easier for me to read and mitigates security issues such as phishing links and downloading remote content.</p>

		<p>Try to reduce the number of emails you are sending. You should write everything you wish to say in a single email, even if you have multiple unrelated topics you wish to speak about.</p>

		<p>If you need to send files with your message, add them as attachments to the email instead of pasting them inline with the message or uploading them to online file sharing services. The same goes for using shortlink services to reduce the size of, or mask the original link. I do not care about the size of the link. Services like these could be malicious and modify files/links after you submit them, they also tend to serve advertisements and log visitor information.</u>

		<p>Everything mentioned above will also help to reduce the chance of your email being flagged as spam.</p>

		<p>If you care about privacy, consider encrypting your message using <a href="/public.txt" target="_blank" rel="noopener">my public key</a> so that only I can read your message. It would be wise for you to send your public key in your first email to me so that I too may encrypt my replies.</p>

		<p class="warning">Sending junk or any form of spam to my inbox will get you blacklisted until the end of time, so I strongly advise against doing that if you ever wish to speak with me in the future.</p>

		<!-- Footer -->
		<footer>
			<hr>
			<?php if ( $_SERVER[ 'HTTPS' ] == "on" ) { ?>
			<p>This connection is encrypted with <?=$_SERVER[ 'SSL_PROTOCOL' ]?> using <?=$_SERVER[ 'SSL_CIPHER_USEKEYSIZE' ]?>-bit keys (<code><?=$_SERVER[ 'SSL_CIPHER' ]?></code>).</p>
			<?php } else { ?>
			<p>This connection is <u>not</u> encrypted.</p>
			<?php } ?>

			<p>You are viewing a cached copy. Page content last modified at xxxxxxx. <a href="?history">[View history]</a></p>

			<p>This page has been viewed 12,634 times, 176 of those were unique.

			<p>Your request took <?=round( ( microtime( true ) - $_SERVER[ 'REQUEST_TIME_FLOAT' ] ) * 1000, 2 )?>ms to process. Received on <?=date( 'l dS F Y, H:i:s T', $_SERVER[ 'REQUEST_TIME_FLOAT' ] )?>.

			<br><br>

			<?php if ( isset( $_GET[ 'nocss' ] ) ) { ?>
			<a href="/contact.php">[Enable CSS]</a>
			<?php } else { ?>
			<a href="?nocss">[Disable CSS]</a>

			<?php if ( isset( $_GET[ 'dark' ] ) ) { ?>
			<a href="/contact.php">[Use Light Theme]</a>
			<?php } else { ?>
			<a href="?dark">[Use Dark Theme]</a>
			<?php } ?>

			<?php } ?>

			<br><br>

			<a href="/tos.php">[Terms of Service]</a> <a href="/privacy.php">[Privacy Policy]</a> <a href="/cookies.php">[Cookie Policy]</a>

			<br><br>

			<a href="http://viral32111.local">[Surface]</a> <a href="http://viralcra3zyjdrnx2mzve6vn7sdwodwbngrc266s5ybmln3dac3mvhad.onion">[Onion]</a>

			<br>

			<p>Icons provided by <a href="http://famfamfam.com/lab/icons/silk/">Mark James</a> under <a href="https://creativecommons.org/licenses/by/2.5/">CC-BY-2.5</a>.<br>
			Copyright (C) 2020 viral32111.</p>
		</footer>
	</body>
</html>