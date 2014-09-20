<?php

/**
 * WordPress backed meta management
 *
 * @author     Timely Network Inc
 * @since      2012.10.02
 *
 * @package    AllInOneCalendar
 * @subpackage AllInOneCalendar.Lib.Strategy
 */
class Ai1ec_Strategies_Factory
{

	/**
	 * @var array Map of cache directories and writability
	 */
	private static $cache_directories = array();

	/**
	 * create_cache_strategy_instance method
	 *
	 * Method to instantiate new cache strategy object
	 *
	 * @param string $cache_directory Cache directory to use
	 * @param bool   $skip_small_bits Set to true, to ignore small entities
	 *                                cache engines, as APC [optional=false]
	 *
	 * @return Ai1ec_Cache_Strategy Instantiated writer
	 */
	public static function create_cache_strategy_instance(
		$cache_directory = NULL,
		$skip_small_bits = false
	) {
		$engine = NULL;
		$name   = '';
		if ( true !== $skip_small_bits && Ai1ec_Apc_Cache::is_available() ) {
			$engine = new Ai1ec_Apc_Cache();
			$name   = 'apc';
		} else if (
			NULL !== $cache_directory &&
			self::_is_cache_dir_writable( $cache_directory )
		) {
			$engine = new Ai1ec_File_Cache( $cache_directory );
			$name   = 'file';
		} else if ( true !== $skip_small_bits ) {
			$engine = new Ai1ec_Db_Cache(
				Ai1ec_Adapters_Factory::create_db_adapter_instance()
			);
			$name   = 'db';
		} else {
			$engine = new Ai1ec_Void_Cache();
			$name   = 'void';
		}
		$engine->inject_logger( Logger::getLogger( 'cache.' . $name ) );
		return $engine;
	}

	/**
	 * create_persistence_context method
	 *
	 * @param string               $key_for_persistance
	 * @param Ai1ec_Cache_Strategy $cache_strategy
	 * @param string               $cache_directory
	 *
	 * @return Ai1ec_Persistence_Context Instance of persistance context
	 */
	public static function create_persistence_context( 
		$key_for_persistance,
		$cache_directory = null
	) {
		return new Ai1ec_Persistence_Context( 
			$key_for_persistance, 
			self::create_cache_strategy_instance( $cache_directory )
		);
	}

	/**
	 * create_blob_persistence_context method
	 *
	 * Create new Ai1ec_Persistence_Context instance suited for BLOB, or
	 * literary any large objects storage
	 *
	 * @param string $key_for_persistance Storage key to be used
	 * @param string $cache_directory     Path to base storage directory
	 *
	 * @return Ai1ec_Persistence_Context Cache storage instance
	 */
	public static function create_blob_persistence_context(
		$key_for_persistance,
		$cache_directory
	) {
		return new Ai1ec_Persistence_Context(
			$key_for_persistance,
			self::create_cache_strategy_instance( $cache_directory, true )
		);
	}

	/**
	 * _is_cache_dir_writable method
	 *
	 * Check if given cache directory is writable.
	 *
	 * @param string $directory A path to check for writability
	 *
	 * @return bool Writability
	 */
	protected static function _is_cache_dir_writable( $directory ) {
		if ( ! isset( self::$cache_directories[$directory] ) ) {
			self::$cache_directories[$directory] =
				Ai1ec_Filesystem_Utility::is_writable(
					$directory
				);
		}
		return self::$cache_directories[$directory];
	}

}
