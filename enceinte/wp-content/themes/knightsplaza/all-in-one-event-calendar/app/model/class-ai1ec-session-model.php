<?php

/**
 * Storage for session-like entries, based on WordPress transients
 *
 * @author     Timely Network, Inc.
 * @since      1.11
 *
 * @package    AllInOneCalendar
 * @subpackage AllInOneCalendar.Model.Transport
 */
class Ai1ec_Session_Model
{

	/**
	 * @constant int Number of seconds, before session is destroyed
	 */
	const EXPIRY    = 86400;

	/**
	 * @var string Key value passed by client
	 */
	protected $_key = NULL;

	/**
	 * Constructor optionally initializes key to given value
	 *
	 * @param string $key For format {@see self::key()}
	 *
	 * @return void Constructor does not return
	 */
	public function __construct( $key = NULL ) {
		$this->key( $key );
	}

	/**
	 * Check and set session key
	 *
	 * @param string $input User-supplied session key
	 *
	 * @return string|NULL Either value provided, if it is valid, or NULL
	 */
	public function key( $input ) {
		if ( ! is_scalar( $input ) ) {
			return NULL;
		}
		$input = (string)$input;
		if (
			! isset( $input{31} ) ||
			isset( $input{32} ) ||
			! ctype_xdigit( $input )
		) {
			return NULL;
		}
		$this->_key   = $input;
		return $input;
	}

	/**
	 * Create new session record
	 *
	 * @return string|NULL New key, or NULL if impossible to create it
	 */
	public function create() {
		$attempt = 5;
		$new_key = NULL;
		$input   = json_encode( $_SERVER );
		do {
			$candidate = md5( mt_rand() . $input . microtime( true ) );
			if ( ! $this->_exists( $candidate ) ) {
				$new_key = $candidate;
				$this->_write( $new_key, NULL );
			}
		} while ( NULL === $new_key && --$attempt > 0 );
		return $this->key( $new_key );
	}

	/**
	 * Sets value to current session
	 *
	 * For details {@see self::get()} - it may be inconvenient to use plain
	 * boolean values here.
	 *
	 * @param mixed $value Any serializable session value
	 *
	 * @return bool Success
	 */
	public function set( $value ) {
		if ( ! $this->_is_initialized( true ) ) {
			return false;
		}
		return $this->_write( $this->_key, $value );
	}

	/**
	 * Gets value from current session
	 *
	 * @return mixed On failure returns bool(false), otherwise - stored value
	 */
	public function get() {
		if ( ! $this->_is_initialized() ) {
			return false;
		}
		return $this->_read( $this->_key );
	}

	/**
	 * Delete values and destroy current session
	 *
	 * @return bool Success
	 */
	public function delete() {
		if ( ! $this->_is_initialized() ) {
			return false;
		}
		return $this->_delete( $this->_key );
	}

	/**
	 * Get value from current session and destroy it afterwards
	 *
	 * @return mixed For details {@see self::get()}
	 */
	public function get_last() {
		$value = $this->get();
		$this->delete();
		return $value;
	}

	/**
	 * Check if current session exists
	 *
	 * @param string $key Session key ({@see self::$_key})
	 *
	 * @return bool Existence
	 */
	protected function _exists( $key ) {
		return ( false !== $this->_read( $key ) );
	}

	/**
	 * Check if current session is initialized (valid)
	 *
	 * @param bool $auto_create Set to true to auto-initialize on failure
	 *
	 * @return bool Validity
	 */
	protected function _is_initialized( $auto_create = false ) {
		if ( NULL !== $this->_key ) {
			return true;
		}
		if ( false === $auto_create ) {
			return false;
		}
		return ( NULL !== $this->create() );
	}

	/**
	 * Get key to use for internal use
	 *
	 * @param string $public_key A user session key
	 *
	 * @return string Key to use in DB operations
	 */
	protected function _db_key( $public_key ) {
		return 'ai1ec_sssn_' . $public_key; // 'session' w/o vowels 'sssn'
	}

	/**
	 * Write actual data to database
	 *
	 * @param string $key   User session key
	 * @param mixed  $value Actual value to store
	 *
	 * @return bool Success
	 *
	 * @uses set_transient To store value
	 */
	protected function _write( $key, $value ) {
		return set_transient( $this->_db_key( $key ), $value, self::EXPIRY );
	}

	/**
	 * Read actual data from database
	 *
	 * @param string $key User session key
	 *
	 * @return mixed Actual value on success, or bool(false) on failure
	 *
	 * @uses get_transient To retrieve entry
	 */
	protected function _read( $key ) {
		return get_transient( $this->_db_key( $key ) );
	}

	/**
	 * Destroy session
	 *
	 * @param string $key User session key
	 *
	 * @return bool Success
	 *
	 * @uses delete_transient To remove object from store
	 */
	protected function _delete( $key ) {
		return delete_transient( $this->_db_key( $key ) );
	}

}