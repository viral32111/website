<?php

require_once( 'credentials.php' );

class RedisDatabase {

	private static $instance = NULL;

	public static function Connect() : bool {

		global $redisAddress, $redisPort, $redisUsername, $redisPassword, $redisDatabase;

		RedisDatabase::$instance = new Redis();

		if ( RedisDatabase::$instance->connect( $redisAddress, $redisPort, 1.0 ) !== true ) {
			exit( 'Failed to connect to the Redis server.' );
		}

		if ( RedisDatabase::$instance->auth( [ $redisUsername, $redisPassword ] ) !== true ) {
			exit( 'Failed to authenticate with the Redis server.' );
		}

		if ( RedisDatabase::$instance->select( $redisDatabase ) !== true ) {
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

		global $redisPrefix;

		if ( RedisDatabase::$instance === NULL ) return NULL;
		if ( empty( $name ) === true ) return false;

		return RedisDatabase::$instance->get( $redisPrefix . $name );

	}

	public static function Set( string $name, string $value ) : bool {

		global $redisPrefix;

		if ( RedisDatabase::$instance === NULL ) return NULL;
		if ( empty( $name ) === true ) return false;

		if ( RedisDatabase::$instance->set( $redisPrefix . $name, $value ) !== true ) {
			exit( 'Failed to set key in Redis database.' );
		}

		return true;

	}

	public static function Delete( string $name ) : bool {

		global $redisPrefix;

		if ( RedisDatabase::$instance === NULL ) return NULL;
		if ( empty( $name ) === true ) return false;

		if ( RedisDatabase::$instance->del( $redisPrefix . $name ) !== 1 ) {
			exit( 'Failed to delete key in Redis database.' );
		}

		return true;

	}

}

RedisDatabase::Connect();

?>
