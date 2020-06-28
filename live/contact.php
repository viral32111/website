<?php
// Setup entity references for characters used in emails
// https://en.wikipedia.org/wiki/List_of_XML_and_HTML_character_entity_references#Character_entity_references_in_HTML
$references = array(
	'@' => 'commat',
	':' => 'colon',
	'.' => 'period'
);

// A function to generate protected text
function protect( $text ) {

	// Include the entity references in this scope
	global $references;

	// Placeholder for the final protected text
	$protected = "";

	// Loop through each character in the text
	foreach ( str_split( $text ) as $character ) {

		// Create an array to hold the encoded versions of this character
		$encodings = array(
			'#'.ord( $character ), // Denary
			'#x'.bin2hex( $character ) // Hexadecimal
		);

		// Try fetch the entity reference for this character
		$named = $characterNames[ $character ] ?? null;

		// If there is an entity reference, add it to the encodings array
		if ( is_string( $named ) ) array_push( $encodings, $named );

		// Randomly pick an encoding from the array
		$choice = $encodings[ array_rand( $encodings ) ];

		// Append it to the end of the protected text
		$protected .= '&'.$choice.';';
	}

	// Return the final protected text
	return $protected;

}
?>
<!DOCTYPE html>
<html lang="en-GB">
	<head>
		<title>Contact</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1.0">
		<link rel="stylesheet" href="/styles.css" type="text/css">
		<?php if ( isset( $_GET[ 'dark' ] ) ) { ?>
		<link rel="stylesheet" href="/dark.css" type="text/css">
		<?php } ?>
	</head>
	<body>
		<hr>
		<h1>Contact</h1>
		<p>The ideal way to get in contact with me is to send an email to <a class="noexternal" href="<?=protect('mailto:viral32111@pm.me');?>?subject=I%20wish%20to%20speak%20to%20you." rel="noopener noreferrer" title="Open your default email application with a new draft with me as the recipient."><?=protect('viral32111@pm.me');?></a>.<br>I check my inbox regularly throughout the week, so expect a reply within a few days.</p>

		<p>Do not bother contacting me on Discord, Steam or any other platform I have an account on. If I wish to speak with you on another platform, I will add that to my reply.</p>

		<p style="margin-bottom: 2px;">If you do not receive a reply, this could mean your email has been flagged by a spam filter and therefore has been rejected. If you do not want this to happen with your email, ensure that:
		<ul style="margin-top: 2px;">
			<li>You are <u>not</u> using suspicious links in your message.</li>
			<li>You are <u>not</u> sending from a throwaway email provider.</li>
			<li>Your email address is <u>not</u> in a known spam blacklist.</li>
			<li>The server's IP address is <u>not</u> behind a proxy network.</li>
			<li>The server's IP address is <u>not</u> in a known spam blacklist.</li>
		</ul>

		<p>Whenever possible, write your emails in plain text instead of HTML mode. This makes it easier for me to read and mitigates security issues such as phishing links and downloading content.</p>

		<p>Try to reduce the number of emails you are sending. You should write everything you wish to say in a single email, even if you have multiple unrelated topics you wish to speak about.</p>

		<p>If you need to send files with your message, add them as attachments to the email instead of pasting them into the message or uploading them to online file sharing services. The same goes for using short-link services to reduce the size of or mask the original link, I do not care about the size of the link. Services like these could be malicious and modify files/links after you submit them, they also tend to serve advertisements and log personally identifiable visitor information.</u>

		<p>Everything mentioned above will also help to reduce the chance of your email being flagged as spam.</p>

		<p>If you care about privacy, consider encrypting your message using <a href="/public.txt" target="_blank" rel="noopener">my public key</a> so that only I can read your message. It would be wise for you to send your public key in your first email to me so that I too may encrypt my replies.</p>

		<p class="warning">Sending junk or any form of spam to my inbox will get you blacklisted until the end of time, so I strongly advise against doing that if you ever wish to speak with me in the future.</p>

		<hr>

		<address>Your request took <?=round((microtime(true)-$_SERVER["REQUEST_TIME_FLOAT"])*1000, 2);?>ms to process.

		<?php if ( isset( $_GET[ 'dark' ] ) ) { ?>
		<a href="/contact.php">[Switch to light mode]</a>
		<?php } else { ?>
		<a href="?dark">[Switch to dark mode]</a>
		<?php } ?>

		<address>
	</body>
</html>