<?php

/**
 * OAuth tokens acquisition controller
 *
 * @author     Timely Network Inc
 * @since      2013.05.27
 *
 * @package    AllInOneEventCalendar
 * @subpackage AllInOneEventCalendar.App.Controller
 */
class Ai1ec_Oauth_Controller
{

	static protected $_instance = NULL;

	/**
	 * @var Ai1ec_Oauth_Provider Instance of OAuth provider
	 */
	protected $_provider = NULL;

	/**
	 * Returns singletonian instance of this object
	 *
	 * @return Ai1ec_Oauth_Controller Singletonian instance of self
	 */
	static public function get_instance() {
		if ( ! ( self::$_instance instanceof self ) ) {
			global $wpdb;
			self::$_instance = new self(
				$wpdb,
				Ai1ec_Settings::get_instance()
			);
		}
		return self::$_instance;
	}

	/**
	 * Initiate controller
	 *
	 * @param wpdb           $database Instance of wpdb
	 * @param Ai1ec_Settings $settings Instance of Ai1ec_Settings
	 *
	 * @return void Constructor does not return
	 */
	public function __construct( wpdb $database, Ai1ec_Settings $settings ) {
		$this->_db       = $database;
		$this->_settings = $settings;
	}

	/**
	 * Generate HTML box to be rendered on event editing page
	 *
	 * @return void Method does not return
	 */
	public function post_meta_box() {
		global $post;
		if (
			! isset( $post ) ||
			! isset( $post->post_type ) ||
			AI1EC_POST_TYPE !== $post->post_type
		) { // ignore not-an-events
			return NULL;
		}
		$event = NULL;
		try {
			$event = new Ai1ec_Event( $post->ID );
		} catch ( Ai1ec_Event_Not_Found $exception ) {
			$event = NULL; // not saved yet
		}
		$available = $this->_get_providers();
		$html      = '';
		$output    = '<div id="ai1ec-box-oauth-provider-{provider}" class="misc-pub-section">
			<label for="ai1ec-oauth-provider-{provider}">{label}</label>
			<input type="checkbox" value="1" {checked}
			       name="ai1ec_oauth_provider_{provider}"
			       id="ai1ec-oauth-provider-{provider}" />
		</div>';
		foreach ( $available as $provider => $class ) {
			try {
				$object  = $this->get_provider( $provider );
				$html   .= str_replace(
					array(
						'{provider}',
						'{name}',
						'{label}',
						'{checked}',
					),
					array(
						$provider,
						$object->get_name(),
						sprintf(
							__( 'Post to %s', AI1EC_PLUGIN_NAME ),
							$object->get_name()
						),
						$this->_selected_for_posting( $event, $provider ),
					),
					$output
				);
			} catch ( Ai1ec_Oauth_Exception $exception ) {
				continue;
			}
		}
		echo $html;
	}

	/**
	 * Handle request - perform variables initialization and inner routing
	 *
	 * @return bool OAuth success status
	 */
	public function handle_request() {
		$result  = false;
		$message = NULL;
		try {
			$this->_provider = $this->get_provider();
			$result          = $this->authorize();
		} catch ( Ai1ec_Oauth_Exception $exception ) {
			// @RELEASE $this->_log->error( 'OAuth failure: ' . $exception->getMessage() );
			$result  = false;
			$message = $exception->getMessage();
		}
		$renderable = NULL;
		if ( $result ) {
			$renderable = Ai1ec_Helper_Factory::create_admin_message_instance(
				sprintf( __(
						'You have successfully linked your account with <strong>%s</strong>.',
						AI1EC_PLUGIN_NAME
					),
					$this->_provider->get_name()
				),
				__( 'External Service linked', AI1EC_PLUGIN_NAME )
			);
			$renderable->set_message_type( 'updated' );
		} else {
			$renderable = Ai1ec_Helper_Factory::create_admin_message_instance(
				sprintf( __(
						'There was a failure linking your account with <strong>%s</strong>: %s.',
						AI1EC_PLUGIN_NAME
					),
					$this->_provider->get_name(),
					$message
				),
				__( 'External Service linking error', AI1EC_PLUGIN_NAME )
			);
			$renderable->set_message_type( 'error' );
		}
		Ai1ec_Deferred_Rendering_Helper::get_instance()
			->add_renderable_children( $renderable );
		return ai1ec_redirect( admin_url( AI1EC_SETTINGS_BASE_URL ) );
	}

	/**
	 * Get URL for OAuth callback
	 *
	 * @param string $provider Name of OAuth provider to get callback URL for
	 *
	 * @return string Callback URL
	 */
	public function get_callback_url( $provider ) {
		return site_url( '?ai1ec_oauth=' . $provider );
	}

	/**
	 * Get instance of matching OAuth provider
	 *
	 * @param string $provider Name of OAuth provider to acquire [optional=NULL]
	 *
	 * @return Ai1ec_Oauth_Provider Instance of matching OAuth provider
	 *
	 * @throws Ai1ec_Oauth_Exception If error is encountered
	 */
	public function get_provider( $provider = NULL ) {
		if ( NULL === $provider ) {
			foreach ( array( 'oauth_provider', 'ai1ec_oauth' ) as $key ) {
				if (
					isset( $_REQUEST[$key] ) &&
					is_string( $_REQUEST[$key] )
				) {
					$provider = $_REQUEST[$key];
					break;
				}
			}
			if ( NULL === $provider ) {
				throw new Ai1ec_Oauth_Exception( 'Provider not supplied' );
			}
			$provider = $this->_normalize_name( $provider );
		}
		$available = $this->_get_providers();
		if ( ! isset( $available[$provider] ) ) {
			throw new Ai1ec_Oauth_Exception( 'Provider unknown' );
		}
		$object    = NULL;
		$throwable = NULL;
		try {
			$object = new $available[$provider]();
		} catch ( Ai1ec_Oauth_Exception $exception ) {
			// @RELEASE global $ai1ec_settings;
			// @RELEASE $this->_log->warn(
			// @RELEASE 	'Failed to initialize ' . $provider . ' with ' .
			// @RELEASE 	var_export( $ai1ec_settings, true )
			// @RELEASE );
			$throwable = $exception;
		}
		if ( NULL !== $throwable ) {
			throw $throwable;
		}
		return $object;
	}

	/**
	 * Perform OAuth authorization
	 *
	 * @return bool Success
	 *
	 * @throws Ai1ec_Oauth_Exception In case of failure
	 */
	public function authorize() {
		if ( NULL === $this->_provider ) {
			throw new Ai1ec_Oauth_Exception( 'Provider not initiated' );
		}
		if ( isset( $_GET['denied'] ) ) {
			throw new Ai1ec_Oauth_Exception(
				__( 'Authorization was rejected', AI1EC_PLUGIN_NAME )
			);
		}
		// user returning from provider
		if ( isset( $_GET['oauth_token'] ) || isset( $_GET['code'] ) ) {
			if ( ! $this->_provider->validate( $_GET ) ) {
				throw new Ai1ec_Oauth_Exception( 'Invalid callback' );
			}
			return $this->persist(
				get_class( $this->_provider ),
				$this->_provider->get_token()
			);
		}
		// new request - prepare and redirect
		if ( ! $this->_provider->prepare() ) {
			throw new Ai1ec_Oauth_Exception( 'Provider unavailable' );
		}
		$location = $this->_provider->auth_redirect();
		if ( false !== $location ) {
			return ai1ec_redirect( $location, 303 );
		}
		throw new Ai1ec_Oauth_Exception( 'Invalid workflow' );
	}

	/**
	 * Store token in permanent store
	 *
	 * @param string $provider Name of provider (class name)
	 * @param mixed  $token    Provider-specific token value
	 * @param bool   $_fail    Inner value set to fail upon first store failure
	 *
	 * @return bool Success
	 */
	public function persist( $provider, $token, $_fail = false ) {
		$user_id    = (int)get_current_user_id();
		$meta_key   = 'ai1ec_oauth_tokens';
		// intentionally using `get_user_meta()` instead of `Ai1ec_Meta`
		// to bypass cache
		$meta_entry = get_user_meta( $user_id, $meta_key, true );
		$new_entry  = $meta_entry;
		$new_entry[$provider] = $token;
		if ( $_fail ) {
			return update_user_meta( $user_id, $meta_key, $new_entry );
		}
		if (
			false === add_user_meta( $user_id, $meta_key, $new_entry, true ) &&
			false === update_user_meta(
				$user_id,
				$meta_key,
				$new_entry,
				$meta_entry
			)
		) {
			// @RELEASE $this->_log->debug(
			// @RELEASE 	'Failed to add/update meta ' . $user_id . '/' . $meta_key
			// @RELEASE );
			return $this->persist( $provider, $token, true );
		}
		return true;
	}

	public function get_token( $user_id, $provider ) {
		$user_id   = (int)$user_id;
		$providers = $this->_get_providers();
		if ( $user_id < 0 || ! isset( $providers[$provider] ) ) {
			throw new Ai1ec_Oauth_Exception(
				'Unknown provider \'' . $provider . '\''
			);
		}
		$class     = $providers[$provider];
		$keys      = (array)Ai1ec_Meta::instance( 'User' )
			->get( $user_id, 'ai1ec_oauth_tokens', array() );
		if ( isset( $keys[0] ) ) {
			$keys = $keys[0];
		}
		if ( ! isset( $keys[$class] ) ) {
			throw new Ai1ec_Oauth_Exception(
				'Token not available for user \'' . $user_id .
				'\' and provider \'' . $provider . '\''
			);
		}
		return $keys[$class];
	}

	/**
	 * Get a list of OAuth providers
	 *
	 * @return array Map of provider names and corresponding classes
	 *
	 * @staticvar $names Map of provider names and corresponding classes
	 */
	protected function _get_providers() {
		static $names = NULL;
		if ( NULL === $names ) {
			$classes = Ai1ec_Loader::instance()->get_matches(
				'/^Ai1ec_Oauth_Provider_[A-Z][a-z]+$/'
			);
			$names   = array();
			foreach ( $classes as $class ) {
				$names[$this->_normalize_name( $class )] = $class;
			}
		}
		return $names;
	}

	/**
	 * Create canonical OAuth name reprezentation given arbitrary input
	 *
	 * @param string $name Class name, or request value
	 *
	 * @return string Normalized OAuth provider name
	 */
	protected function _normalize_name( $name ) {
		if ( 0 === strncasecmp( $name, 'ai1ec_', 6 ) ) {
			$name = substr( $name, 21 );
		}
		return strtolower( $name );
	}

	/**
	 * Return checkbox `checked` status for given event and provider
	 *
	 * @param Ai1ec_Event $event    Instance of Ai1ec_Event concerned
	 * @param string      $provider Name of provider to check
	 *
	 * @return string Value for `checked` part of checkbox
	 */
	protected function _selected_for_posting(
		Ai1ec_Event $event = NULL,
		$provider
	) {
		if (
			NULL === $event ||
			! isset( $event->post_id ) ||
			empty( $event->post_id )
		) {
			return '';
		}
		$meta   = '_ai1ec_post_' . $provider;
		$status = Ai1ec_Meta::instance( 'Post' )
			->get( $event->post_id, $meta, false );
		if ( false === $status ) {
			return '';
		}
		return 'checked="checked"';
	}

}