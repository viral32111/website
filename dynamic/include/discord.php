<?php

require_once( 'credentials.php' );

class Discord {

	private static $baseUrl = 'discord.com/api/v10';

	public static function FetchUserName( $userID ) {

		global $discordToken;

		$apiRequest = curl_init( 'https://' . Discord::$baseUrl . '/users/' . $userID );

		curl_setopt( $apiRequest, CURLOPT_TIMEOUT, 3 );
		curl_setopt( $apiRequest, CURLOPT_RETURNTRANSFER, true );
	
		curl_setopt( $apiRequest, CURLOPT_USERAGENT, "viral32111's website (https://viral32111.com; contact@viral32111.com)" );

		curl_setopt( $apiRequest, CURLOPT_HTTPHEADER, [
			'Authorization: Bot ' . $discordToken
		] );

		$apiResponse = curl_exec( $apiRequest );

		$statusCode = curl_getinfo( $apiRequest, CURLINFO_RESPONSE_CODE );
		if ( $statusCode !== 200 ) {
			exit( 'Unsuccessful response from Discord API.' );
		}

		$userObject = json_decode( $apiResponse, true );

		curl_close( $apiRequest );

		return $userObject[ 'username' ];

	}

}

?>
