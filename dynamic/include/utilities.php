<?php

class Utilities {

	public static function CreateQueryString( array $parameters ) : string {

		return '?' . implode( '&', array_map(
	
			function( string $key, string $value ) { return $key . '=' . $value; },
	
			array_keys( $parameters ),
			array_values( $parameters )
	
		) );
	
	}

}

?>
