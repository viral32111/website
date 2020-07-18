<?php

// The time in seconds for which an announcement should be considered new after it's last modified time
$isNewFor = 604800; // 1 week

// Return all the new announcements
function fetchAnnouncements( $path ) {

	// Include consider new time into the scope of this function
	global $isNewFor;

	// Clear cache of file statistics
	clearstatcache();

	// Placeholder for the announcements considered new
	$newAnnouncements = [];

	// Store the current unix timestamp in seconds
	$currentTime = time();

	// Get a list of the announcements directory without the dot things ( ./ & ../ )
	$listing = array_diff( scandir( $path ), array( '..' , '.' ) );

	// Loop through each listing
	foreach ( $listing as $index => $name ) {

		// Skip if it's not a regular file
		if ( is_file( $path . '/' . $name ) === FALSE ) continue;

		// Get the last modified time of the file as a unix timestamp in seconds
		$lastModified = filemtime( $path . '/' . $name );

		// Skip if the file is not considered new
		if ( ( $lastModified + $isNewFor ) < $currentTime ) continue;

		// Add it to the new announcements array
		$newAnnouncements[ $name ] = $lastModified;

	}

	// Sort the new announcements
	arsort( $newAnnouncements );

	// Extract the file names in sorted order
	$sortedAnnouncements = array_keys( $newAnnouncements );

	// Return the sorted announcements
	return $sortedAnnouncements;

}

?>