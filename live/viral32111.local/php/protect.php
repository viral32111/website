<?php
// Setup entity references for characters used in emails
// https://en.wikipedia.org/wiki/List_of_XML_and_HTML_character_entity_references#Character_entity_references_in_HTML
$references = array(
	'@' => 'commat',
	':' => 'colon',
	'.' => 'period'
);

// A function to protect text from crawlers
function protect( $text ) {

	// Include the entity references in this scope
	global $references;

	// Placeholder for the final protected text
	$protected = '';

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