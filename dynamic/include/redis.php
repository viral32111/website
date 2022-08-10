<?php

class RedisDatabase {

	private static $instance = NULL;

	public static function Connect() : bool {

		RedisDatabase::$instance = new Redis();

		if ( RedisDatabase::$instance->connect( $_SERVER[ 'REDIS_ADDRESS' ], intval( $_SERVER[ 'REDIS_PORT' ] ), 1.0 ) !== true ) {
			exit( 'Failed to connect to the Redis server.' );
		}

		if ( RedisDatabase::$instance->auth( [ $_SERVER[ 'REDIS_USERNAME' ], $_SERVER[ 'REDIS_PASSWORD' ] ] ) !== true ) {
			exit( 'Failed to authenticate with the Redis server.' );
		}

		if ( RedisDatabase::$instance->select( intval( $_SERVER[ 'REDIS_DATABASE' ] ) ) !== true ) {
			exit( 'Failed to switch Redis database.' );
		}

		register_shutdown_function( 'RedisDatabase::Disconnect' );

		return true;

	}

	public static function Disconnect() : bool {

		if ( RedisDatabase::$instance === NULL ) return NULL;

		if ( RedisDatabase::$instance->close() !== true ) {
			exit( 'Failed to disconnect from the Redis server.' );
		}

		return true;

	}

	public static function Get( string $name ) : mixed {

		if ( RedisDatabase::$instance === NULL ) return NULL;
		if ( empty( $name ) === true ) return false;

		return RedisDatabase::$instance->get( $_SERVER[ 'REDIS_PREFIX' ] . $name );

	}

	public static function Set( string $name, string $value ) : bool {

		if ( RedisDatabase::$instance === NULL ) return NULL;
		if ( empty( $name ) === true ) return false;

		if ( RedisDatabase::$instance->set( $_SERVER[ 'REDIS_PREFIX' ] . $name, $value ) !== true ) {
			exit( 'Failed to set key in Redis database.' );
		}

		return true;

	}

	public static function Delete( string $name ) : bool {

		if ( RedisDatabase::$instance === NULL ) return NULL;
		if ( empty( $name ) === true ) return false;

		if ( RedisDatabase::$instance->del( $_SERVER[ 'REDIS_PREFIX' ] . $name ) !== 1 ) {
			exit( 'Failed to delete key in Redis database.' );
		}

		return true;

	}

}

RedisDatabase::Connect();

?>
