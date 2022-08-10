<?php

require_once( 'steam.php' );
require_once( 'discord.php' );
require_once( 'redis.php' );

class Cache {

	public static function GetSteamProfileNames( $steamIDs ) {

		$keyPrefix = 'steam-profile-names:';

		$profileNames = [];
		$steamIDsToFetch = [];
	
		foreach ( $steamIDs as $steamID ) {
			$cachedProfileName = RedisDatabase::Get( $keyPrefix . $steamID );

			if ( $cachedProfileName === false ) {
				array_push( $steamIDsToFetch, $steamID );
			} else {
				$profileNames[ $steamID ] = $cachedProfileName;
			}
		}

		if ( count( $steamIDsToFetch ) > 0 ) {
			$freshProfileNames = Steam::FetchProfileNames( $steamIDsToFetch );

			foreach ( $freshProfileNames as $steamID => $freshProfileName ) {
				RedisDatabase::Set( $keyPrefix . $steamID, $freshProfileName );

				$profileNames[ $steamID ] = $freshProfileName;
			}
		}

		return $profileNames;

	}

	public static function GetDiscordUserNames( $userIDs ) {

		$keyPrefix = 'discord-user-names:';

		$userNames = [];
		$userIDsToFetch = [];

		foreach ( $userIDs as $userID ) {
			$userName = RedisDatabase::Get( $keyPrefix . $userID );

			if ( $userName === false ) {
				$userName = Discord::FetchUserName( $userID );
				RedisDatabase::Set( $keyPrefix . $userID, $userName );
			}

			$userNames[ $userID ] = $userName;
		}

		return $userNames;

	}

}

?>
