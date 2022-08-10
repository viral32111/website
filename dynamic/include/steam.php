<?php

require_once( 'credentials.php' );
require_once( 'utilities.php' );

class Steam {

	private static $baseUrl = 'api.steampowered.com';

	public static function FetchProfileNames( $steamIDs ) {

		global $steamWebKey;
	
		$profileNames = [];

		$apiRequest = curl_init( 'https://' . Steam::$baseUrl . '/ISteamUser/GetPlayerSummaries/v2/?' . Utilities::CreateQueryString( [
			'key' => $steamWebKey,
			'steamids' => implode( ',', $steamIDs )
		] ) );

		curl_setopt( $apiRequest, CURLOPT_TIMEOUT, 3 );
		curl_setopt( $apiRequest, CURLOPT_RETURNTRANSFER, true );
	
		curl_setopt( $apiRequest, CURLOPT_USERAGENT, "viral32111's website (https://viral32111.com; contact@viral32111.com)" );

		$apiResponse = curl_exec( $apiRequest );

		$statusCode = curl_getinfo( $apiRequest, CURLINFO_RESPONSE_CODE );
		if ( $statusCode !== 200 ) {
			exit( 'Unsuccessful response from Steam API.' );
		}

		$responseData = json_decode( $apiResponse, true );
		foreach ( $responseData[ 'response' ][ 'players' ] as $playerSummary ) {
			$profileNames[ $playerSummary[ 'steamid' ] ] = $playerSummary[ 'personaname' ];
		}

		curl_close( $apiRequest );
	
		ksort( $profileNames ); // Steam API returns profiles in a random order

		return $profileNames;

	}

}

?>
