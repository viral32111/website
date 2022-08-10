<?php

class Utilities {

	private static $requestHeaders = NULL;

	public static function CreateQueryString( array $parameters ) : string {

		return '?' . implode( '&', array_map(
	
			function( string $key, string $value ) { return $key . '=' . $value; },
	
			array_keys( $parameters ),
			array_values( $parameters )
	
		) );
	
	}

	public static function GetRequestHeader( string $name, string $fallbackValue = 'Unknown' ) {
		if ( Utilities::$requestHeaders === NULL ) {
			Utilities::$requestHeaders = array_change_key_case( apache_request_headers(), CASE_LOWER );
		}

		return Utilities::$requestHeaders[ strtolower( $name ) ] ?? $fallbackValue;
	}

	public static function ConvertMarkdownToHTML( $pageContent ) {

		// Remove the PGP signature, if there is one
		[ $pageMarkdown, $hasSignature ] = PGP::StripSignature( $pageContent );

		// Convert the Markdown content to HTML
		return MarkdownToHTML::ConvertString( $pageMarkdown );

	}

}

?>
