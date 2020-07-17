<?php

function parseContent( $path ) {

	// Don't continue if the file isn't a markdown file
	if ( pathinfo( $path, PATHINFO_EXTENSION ) !== 'md' ) return FALSE;

	// Don't continue if the file doesn't exist
	if ( is_file( $path ) !== TRUE ) return FALSE;

	// Open the file for reading
	$handle = fopen( $path, 'r' );

	// Read the entire file into a string
	$contents = fread( $handle, filesize( $path ) );

	// Close the file
	fclose( $handle );

	// Split the file up every new line
	$lines = explode( "\n", $contents );

	// Array that will contain the final results after parsing
	$parsed = [
		
		// Placeholder array to be filled with any metadata configs
		'metadata' => [

			// Defaults
			'title' => 'viral32111\'s website',
			'summary' => 'Hey, I\'m viral32111, A programmer & Developer!',
			'thumbnail' => '/img/avatar.png'

		],

		// Placeholder string to contain the markdown version
		//'markdown' => '',

		// Placeholder string to contain the HTML version
		'html' => '',

		// Placeholder array to contain the JSON version
		//'json' => []

	];

	// Loop through each line
	foreach ( $lines as $line ) {

		// Skip empty lines
		if ( $line === '' ) continue;

		// Placeholder array to be filled with the metadata match groups
		$groups = [];

		// Is the line actually a metadata config?
		if ( preg_match( '/^;([a-z]+)=(.+)$/', $line, $groups ) === 1 ) {
			
			// Fetch the key & value of the metadata config
			$key = $groups[ 1 ];
			$value = $groups[ 2 ];

			// Add it to the metadata array
			$parsed[ 'metadata' ][ $key ] = $value;

		// This is just a regular markdown line
		} else {

			// Add to markdown
			//$parsed[ 'markdown' ] .= $line . "\n\n";

			// Add to HTML
			$parsed[ 'html' ] .= '<p>' . $line . '</p>' . "\n\n";

			// Add to JSON
			//array_push( $parsed[ 'json' ], $line );

		}

	}

	// Return the final result
	return $parsed;
}

?>