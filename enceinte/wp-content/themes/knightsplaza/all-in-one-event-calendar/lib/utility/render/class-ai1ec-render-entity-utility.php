<?php

/**
 * Entities (snippets) rendering utility
 *
 * @author     Justas Butkus <justas@butkus.lt>
 * @since      2013.02.22
 *
 * @package    AllInOneCalendar
 * @subpackage AllInOneCalendar.Utility.Render
 */
class Ai1ec_Render_Entity_Utility
{

	/**
	 * @var array Map of Ai1ec_Render_Entity_Utility instances
	 */
	static protected $_instance = array();

	/**
	 * @var array Map of variables, passed to render engine
	 */
	protected $_arguments       = array();

	/**
	 * @var Ai1ec_Render_Renderable_Entity_Utility Rendering engine
	 */
	protected $_engine          = NULL;

	/**
	 * @var Ai1ec_View_Helper Reference to view helper
	 */
	protected $_view            = NULL;

	/**
	 * @var string Name of element being rendered
	 */
	protected $_name            = NULL;

	/**
	 * @var int Number of times element was rendered
	 */
	protected $_render_count    = 0;

	/**
	 * get_instance method
	 *
	 * Get instance for defined element
	 *
	 * @param string $name Name of element, to get instance for
	 *
	 * @return self Configured instance of self
	 */
	static public function get_instance( $name ) {
		if (
			! isset( self::$_instance[$name] ) ||
			! ( self::$_instance[$name] instanceof self )
		) {
			self::$_instance[$name] = new self( $name );
		}
		return self::$_instance[$name];
	}

	/**
	 * set method
	 *
	 * Set key, to re-use in view rendering
	 * May provide key => value pairs under first value
	 *
	 * @param string|array $key   Name of key to set, or key => value map
	 * @param mixed        $value Entry to write under key, or NULL
	 *
	 * @return self Instance of self
	 */
	public function set( $key, $value = NULL ) {
		if ( NULL !== $value || ! is_array( $key ) ) {
			$key = array( $key => $value );
		}
		foreach ( $key as $local_key => $local_value ) {
			$this->_arguments[$local_key] = $local_value;
		}
		return $this;
	}

	/**
	 * get method
	 *
	 * Get value, set via previous call to {@see self::set}
	 * When NULL is passed for $key returns all values setted
	 *
	 * @param string $key     Name of value to retrieve
	 * @param mixed  $default Value to return, if no entry is set
	 *
	 * @return mixed Value stored, or $default
	 */
	public function get( $key, $default = NULL ) {
		if ( NULL === $key ) {
			return $this->_arguments;
		}
		if ( ! isset( $this->_arguments[$key] ) ) {
			return $default;
		}
		return $this->_arguments[$key];
	}

	/**
	 * get_view method
	 *
	 * Proxy method, to pass call to {@see Ai1ec_View_Helper::get_theme_view}
	 *
	 * @param string $name View to render
	 * @param array  $args Args to pass to view
	 *
	 * @return string Rendered view
	 */
	public function get_view( $name, $args ) {
		return $this->_view->get_theme_view( $name, $args );
	}

	/**
	 * get_content method
	 *
	 * Retrieve content, to be echoed, for current element
	 * Returns non-empty value only on first call, with $no_output set to false
	 *
	 * @param bool $no_output Set to true, to suspend output [optional=false]
	 *
	 * @return string Element to render
	 */
	public function get_content( $no_output = false ) {
		if ( $no_output || $this->_render_count > 0 ) {
			return '';
		}
		++$this->_render_count;
		return $this->_engine->get_snippet();
	}

	/**
	 * Constructor
	 *
	 * Initialize default values, set environment and create render
	 * engine instance
	 *
	 * @param string $name Name of render engine to instantiate
	 *
	 * @return void Constructor does not return
	 */
	protected function __construct( $name ) {
		global $ai1ec_view_helper;
		$class  = 'Ai1ec_Render_' . $name . '_Utility';
		$this->_engine = new $class( $this );
		$this->_view   = $ai1ec_view_helper;
		$this->_name   = $name;
	}

}
