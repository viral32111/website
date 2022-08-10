<?php

class Utilities {

	private static ?array $requestHeaders = NULL;

	public static function CreateQueryString( array $parameters ) : string {

		return '?' . implode( '&', array_map(
	
			function( string $key, string $value ) { return $key . '=' . $value; },
	
			array_keys( $parameters ),
			array_values( $parameters )
	
		) );
	
	}

	public static function GetRequestHeader( string $name, string $fallbackValue = 'Unknown' ) : string {

		if ( Utilities::$requestHeaders === NULL ) {
			Utilities::$requestHeaders = array_change_key_case( apache_request_headers(), CASE_LOWER );
		}

		return Utilities::$requestHeaders[ strtolower( $name ) ] ?? $fallbackValue;

	}

	public static function ConvertMarkdownToHTML( string $pageContent ) : string {

		// Remove the PGP signature, if there is one
		[ $pageMarkdown, $hasSignature ] = PGP::StripSignature( $pageContent );

		// Convert the Markdown content to HTML
		return MarkdownToHTML::ConvertString( $pageMarkdown );

	}

	public static function GetUserAgent() : string {
		return $_SERVER[ 'WEBSITE_TITLE' ] . ' (' . $_SERVER[ 'HTTP_HOST' ] . '; ' . $_SERVER[ 'SERVER_ADMIN' ] . ')';
	}

	// TODO: HTTP request method for Discord & Steam classes to use

}

?>
