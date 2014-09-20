<?php

/**
 *
 * @author Timely Network Inc
 *
 * This class is responsible for handling the rendering of deferred renderables
 * like Admin notices and bootstrap modals.
 * 
 * This class can be used for all the renderables that need to be grouped
 * and rendered later at the same time 
 *
 * It will handle two types of notices; as it iss now it will just handle
 * "request" notices, which are set in various parts of the app and just need
 * to be displayed.
 *
 * Later on we will add support for DB notices which must be displayed on every
 * page view until dismissed. I really don't like singletons but this is one of
 * the rare case in which it makes a lot of sense.
 */
class Ai1ec_Deferred_Rendering_Helper implements Ai1ec_Renderable
{

	const TRANSIENT_ADMIN_MESSAGES   = 'ai1ec_transient_admin_messages';
	const TRANSIENT_BOOTSTRAP_MODALS = 'ai1ec_transient_bootstrap_modals';

	const ADMIN_MESSAGES_ACTION      = 'admin_notices';
	const BOOTSTRAP_MODALS_ACTION    = 'wp_footer';

	/**
	 * @var array Map of filter and transients, which store messages, name
	 */
	private $transient_matches_for_action = array(
		self::ADMIN_MESSAGES_ACTION   => self::TRANSIENT_ADMIN_MESSAGES,
		self::BOOTSTRAP_MODALS_ACTION => self::TRANSIENT_BOOTSTRAP_MODALS,
	);

	/**
	 * @var null|object Singletonian instance of self
	 */
	private static $_instance = NULL;

	/**
	 * Get singletonian instance of this class
	 *
	 * @return Ai1ec_Deferred_Rendering_Helper Instance of self
	 */
	static public function get_instance() {
		if ( self::$_instance === NULL ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * Private constructor, to ensure there is only one instance of this class
	 *
	 * @return void Constructor does not return
	 */
	private function __construct() {
	}

	/**
	 * Adds a renderable child to the element
	 *
	 * @param Ai1ec_Renderable $renderable Object to be rendered in the future
	 *
	 * @return bool Success
	 */
	public function add_renderable_children( Ai1ec_Renderable $renderable ) {
		$transient  = $this->get_transient_name_from_classname(
			get_class( $renderable )
		);
		$messages   = get_transient( $transient );
		if ( false === $messages ) {
			$messages = array();
		}
		$messages[] = $renderable;
		return set_transient( $transient, $messages, 7200 );
	}

	/**
	 * This is needed because {@see get_transient()} requires it
	 *
	 * @return string Content to output
	 */
	public function __toString() {
		return '';
	}

	/* (non-PHPdoc)
	 * @see Ai1ec_Renderable::render()
	 */
	public function render() {
		$current_filter = current_filter();
		$transient      = $this->transient_matches_for_action[$current_filter];
		$messages       = get_transient( $transient );
		if ( false !== $messages ) {
			foreach ( $messages as $renderable ) {
				$renderable->render();
			}
		}
		return delete_transient( $transient );
	}

	/**
	 * Return the transient name from the class name
	 *
	 * @param string $classname Name of class to decode
	 *
	 * @return string Name of transient to use for storing renderable
	 */
	private function get_transient_name_from_classname( $classname ) {
		static $classes_map = array(
			'Ai1ec_Admin_Message_Helper' => self::TRANSIENT_ADMIN_MESSAGES,
			'Ai1ec_Bootstrap_Modal'      => self::TRANSIENT_BOOTSTRAP_MODALS,
		);
		if ( ! isset( $classes_map[$classname] ) ) {
		    return NULL;
		}
		return $classes_map[$classname];
	}

}