<?php

require_once( 'utilities.php' );

class Discord {

	private static $baseUrl = 'discord.com/api/v10';

	public static function FetchUserName( $userID ) {

		$apiRequest = curl_init( 'https://' . Discord::$baseUrl . '/users/' . $userID );

		curl_setopt( $apiRequest, CURLOPT_TIMEOUT, 3 );
		curl_setopt( $apiRequest, CURLOPT_RETURNTRANSFER, true );
	
		curl_setopt( $apiRequest, CURLOPT_USERAGENT, Utilities::GetUserAgent() );

		curl_setopt( $apiRequest, CURLOPT_HTTPHEADER, [
			'Authorization: Bot ' . $_SERVER[ 'DISCORD_BOT_TOKEN' ]
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
