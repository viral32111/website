<?php

require_once( 'utilities.php' );
require_once( 'pgp.php' );
require_once( 'markdown.php' );
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

	public static function GetMarkdownPage( $pageFile ) {

		$keyName = 'markdown-pages:' . $pageFile . ':';

		// Get the Markdown content of the requested page
		// NOTE: This will evaluate any PHP code within the Markdown file
		ob_start();
		require( $_SERVER[ "PAGE_DIRECTORY" ] . "/" . $pageFile );
		$pageContent = ob_get_clean();

		$fileContent = file_get_contents( $_SERVER[ "PAGE_DIRECTORY" ] . '/' . $pageFile );
		if ( strpos( $fileContent, '<?php' ) !== false || strpos( $fileContent, '<?=' ) !== false ) {
			return Utilities::ConvertMarkdownToHTML( $pageContent );
		}

		$pageContentHash = hash( 'sha1', $pageContent, false );

		$pageHash = RedisDatabase::Get( $keyName . 'hash' );
		$pageHTML = RedisDatabase::Get( $keyName . 'html' );

		if ( ( $pageHash === false || $pageHTML === false ) || $pageHash !== $pageContentHash ) {
			$pageHash = $pageContentHash;
			$pageHTML = Utilities::ConvertMarkdownToHTML( $pageContent );

			RedisDatabase::Set( $keyName . 'hash', $pageHash );
			RedisDatabase::Set( $keyName . 'html', $pageHTML );
		}

		return $pageHTML;

	}

}

?>
