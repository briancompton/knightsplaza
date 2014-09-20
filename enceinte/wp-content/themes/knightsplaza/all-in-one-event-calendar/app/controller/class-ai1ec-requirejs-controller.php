<?php
/**
 *
 * @author Timely Network Inc
 *
 *
 */
class Ai1ec_Requirejs_Controller {

	// The js handle used when enqueueing
	const JS_HANDLE = 'ai1ec_requirejs';

	// The parameter that triggers loading of the web widget
	const WEB_WIDGET_GET_PARAMETER = 'ai1ec_super_widget';

	// The namespace for require.js functions
	const REQUIRE_NAMESPACE = 'timely';

	// the name of the configuration module for the frontend
	const FRONTEND_CONFIG_MODULE = 'ai1ec_calendar';

	//the name of the get parameter we use for loading js
	const LOAD_JS_PARAMETER = 'ai1ec_render_js';

	// just load backend scripts
	const LOAD_ONLY_BACKEND_SCRIPTS = 'common_backend';
	
	// just load backend scripts
	const LOAD_ONLY_FRONTEND_SCRIPTS = 'common_frontend';

	// Are we in the backend
	const IS_BACKEND_PARAMETER = 'is_backend';
	
	// Are we on the calendar page
	const IS_CALENDAR_PAGE = 'is_calendar_page';

	// this is the value of IS_BACKEND_PARAMETER which triggers loading of backend script
	const TRUE_PARAM = 'true';

	// the javascript file for event page
	const EVENT_PAGE_JS = 'event.js';

	// the javascript file for calendar page
	const CALENDAR_PAGE_JS = 'calendar.js';

	/**
	 * Holds an instance of the settings object
	 *
	 * @var Ai1ec_Settings
	 */
	private $settings;

	/**
	 * @var Ai1ec_Themes_Controller
	 */
	private $ai1ec_themes_controller;

	/**
	 * The event helper class
	 *
	 * @var Ai1ec_Events_Helper
	 */
	private $events_helper;

	/**
	 * @var Ai1ec_Locale
	 */
	private $ai1ec_locale;

	/**
	 * @var Ai1ec_Scripts
	 */
	private $ai1ec_scripts;

	/**
	 * @var Ai1ec_Wordpress_Template_Adapter
	 */
	private $template_adapter;
	
	/**
	 * @var boolean
	 */
	private static $frontend_scripts_loaded = false;

	public function __construct() {
		$this->template_adapter = new Ai1ec_Wordpress_Template_Adapter();
		// Set the adapter for locale functions
		$this->ai1ec_locale = new Ai1ec_Locale_Wordpress_Adapter();
		$this->ai1ec_scripts = new Ai1ec_Script_Wordpress_Adapter();
		// We need to specify the location of the main.js file.
		add_filter( 'clean_url', array( $this, 'add_data_main' ), 11, 1 );
	}

	/**
	 * @param Ai1ec_Themes_Controller $ai1ec_themes_controller
	 */
	public function set_ai1ec_themes_controller( Ai1ec_Themes_Controller $ai1ec_themes_controller ) {
		$this->ai1ec_themes_controller = $ai1ec_themes_controller;
	}

	/**
	 * @param Ai1ec_Events_Helper $events_helper
	 */
	public function set_events_helper( Ai1ec_Events_Helper $events_helper ) {
		$this->events_helper = $events_helper;
	}

	/**
	 * @param Ai1ec_Settings $settings
	 */
	public function set_settings( Ai1ec_Settings $settings ) {
		$this->settings = $settings;
	}

	/**
	 * Add the data-main attribute to the requirejs script
	 *
	 * @param string $url
	 * @return string
	 */
	public function add_data_main( $url ) {
		if ( FALSE === strpos( $url, 'require.js' ) ) {
			return $url;
		}
		$data_main = AI1EC_ADMIN_THEME_JS_URL . '/main.js';
		//Must be a ', not "!
		return "$url' data-main='$data_main";
	}

	/**
	 * echo the scripts in the footer for the admin. Since this action is enqueued with priority 10
	 * this will happen before the script that requires javascript for the page is loaded as
	 * scripts are loaded with priority = 20 and i need this script before that ( because that script use this as a dependency )
	 */
	public function print_admin_script_footer_for_wordpress_32() {
		$this->ai1ec_scripts->print_admin_script_footer_for_wordpress_32();
	}

	/**
	 * echo the scripts in the footer for the frontend. Since this action is enqueued with priority 10
	 * this will happen before the script that requires javascript for the page is loaded as
	 * scripts are loaded with priority = 20 and i need this script before that ( because that script use this as a dependency )
	 */
	public function print_frontend_script_footer_for_wordpress_32() {
		$this->ai1ec_scripts->print_frontend_script_footer_for_wordpress_32();
	}

	/**
	 * Load the required javascript files
	 *
	 */
	public function load_admin_js() {
		// Initialize dashboard view
		if( is_admin() ) {
			$script_to_load = FALSE;
			// Start the scripts for the Calendar feeds pages
			if( $this->are_we_on_calendar_feeds_page() === TRUE ) {
				// Load script for the importer plugins
				$script_to_load = 'calendar_feeds.js';
				// Set the page
				$data['page'] = $this->settings->settings_page;
			}
			if( $this->are_we_editing_less_variables() === TRUE ) {
				// Load script required when editing categories
				$script_to_load = 'less_variables_editing.js';
			}
			// Start the scripts for the event category page
			if( $this->are_we_editing_event_categories() === TRUE ) {
				// Load script required when editing categories
				$script_to_load = 'event_category.js';
			}
			// Load the js needed when you edit an event / add a new event
			if ( 
				true === $this->are_we_creating_a_new_event() || 
				true === $this->are_we_editing_an_event() 
			) {
				// Load script for adding / modifying events
				$script_to_load = 'add_new_event.js';
			}
			if( $this->are_we_accessing_the_calendar_settings_page() === TRUE ) {
				// Set the page
				$data['page'] = $this->settings->settings_page;
				$script_to_load = 'admin_settings.js';
			}

			if( false === $script_to_load ) {
				$script_to_load = self::LOAD_ONLY_BACKEND_SCRIPTS;
			}
			$this->add_link_to_render_js( $script_to_load, true );
		}
	}

	/**
	 * Add the link to render the javascript
	 * 
	 * @param string $page
	 * @param boolean $backend
	 */
	public function add_link_to_render_js( $page, $backend ) {
		$load_backend_script = 'false';
		if ( true === $backend ) {
			$load_backend_script = self::TRUE_PARAM;
		}
		$is_calendar_page = false;
		if( true === is_page( $this->settings->calendar_page_id ) ) {
			$is_calendar_page = self::TRUE_PARAM;
		}
		$url = $this->template_adapter->get_site_url() . '?' .
				// Add the page to load 
				self::LOAD_JS_PARAMETER . '=' . $page . '&' .
				// If we are in the backend, we must load the common scripts
				self::IS_BACKEND_PARAMETER . '=' . $load_backend_script . '&' .
				// If we are on the calendar page we must load the correct option
				self::IS_CALENDAR_PAGE . '=' . $is_calendar_page;
		if ( true === $backend ) {
			$this->ai1ec_scripts->enqueue_admin_script( 
				self::JS_HANDLE, 
				$url, 
				array( 'postbox' ), 
				true
			);
		} else {
			$this->ai1ec_scripts->enqueue_admin_script( 
				self::JS_HANDLE, 
				$url, 
				array(), 
				true
			);
		}
	}

	/**
	 * Loads version 1.9 or 2.0 of jQuery based on user agent
	 * 
	 * @param string $user_agent
	 * @return string
	 */
	public function get_jquery_version_based_on_browser( $user_agent ) {
		$js_path = AI1EC_ADMIN_THEME_JS_PATH . DIRECTORY_SEPARATOR;
		$jquery = 'jquery_timely20.js';
		preg_match( '/MSIE (.*?);/', $user_agent, $matches );
		if ( count( $matches ) > 1 ) {
			//Then we're using IE
			$version = (int) $matches[1];
			if ( $version <= 8 ) {
				//IE 8 or under!
				$jquery = 'jquery_timely19.js';
			}
		}
		return file_get_contents( $js_path . $jquery );
	}
	
	/**
	 * Create the config object for requirejs. 
	 * 
	 * @return string
	 */
	private function create_require_js_config_object() {
		$js_url    = AI1EC_ADMIN_THEME_JS_URL . '/';
		$version   = AI1EC_VERSION;
		$namespace = self::REQUIRE_NAMESPACE;
		$config    = <<<JSC
		$namespace.require.config( {
			waitSeconds : 15,
			urlArgs     : 'ver=$version',
			baseUrl     : '$js_url'
		} );
JSC;
		return $config;
	}

	/**
	 * Render the javascript for the appropriate page
	 * 
	 */
	public function render_js() {
		header( 'HTTP/1.1 200 OK' );
		header( 'Content-Type: application/javascript; charset=utf-8', true, 200 );
		// Aggressive caching to save future requests from the same client.
		$etag = '"' . md5( __FILE__ . $_GET[self::LOAD_JS_PARAMETER] ) . '"';
		header( 'ETag: ' . $etag );
		$max_age = 31536000;// One Year
		header(
			'Expires: ' .
			gmdate(
				'D, d M Y H:i:s',
				Ai1ec_Time_Utility::current_time() + $max_age
			) .
			' GMT'
		);
		header( 'Cache-Control: public, max-age=' . $max_age );
		if (
			empty( $_SERVER['HTTP_IF_NONE_MATCH'] ) ||
			$etag !== stripslashes( $_SERVER['HTTP_IF_NONE_MATCH'] )
		) {
			// compress data if possible
			if ( Ai1ec_Http_Utility::client_use_gzip() ) {
				ob_start( 'ob_gzhandler' );
				header( 'Content-Encoding: gzip' );
			} else {
				ob_start();
			}
			
			$js_path = AI1EC_ADMIN_THEME_JS_PATH . DIRECTORY_SEPARATOR;
			$common_js = '';
			$page_to_load = $_GET[self::LOAD_JS_PARAMETER];
		
			if ( $_GET[self::IS_BACKEND_PARAMETER] === self::TRUE_PARAM ) {
				$common_js = file_get_contents( $js_path . 'pages/common_backend.js' );
			} else if( $page_to_load === self::EVENT_PAGE_JS ||
				$page_to_load === self::CALENDAR_PAGE_JS || 
				$page_to_load === self::LOAD_ONLY_FRONTEND_SCRIPTS ) {
				if ( $page_to_load === self::LOAD_ONLY_FRONTEND_SCRIPTS &&
					true === self::$frontend_scripts_loaded ) {
					return;
				}
				if ( false === self::$frontend_scripts_loaded ) {
					$common_js = file_get_contents( $js_path . 'pages/common_frontend.js' );
					self::$frontend_scripts_loaded = true;
				}
			
			}
			// create the config object for require js
			$require_config = $this->create_require_js_config_object();
			// load require
			$require = file_get_contents( $js_path . 'require.js' );

			// get jquery
			$jquery = $this->get_jquery_version_based_on_browser( 
				$_SERVER['HTTP_USER_AGENT']
			);
			// load the script for the page

			$page_js = '';
			if ( $page_to_load !== self::LOAD_ONLY_BACKEND_SCRIPTS &&
				 $page_to_load !== self::LOAD_ONLY_FRONTEND_SCRIPTS
			) {
				$page_js = file_get_contents( $js_path . 'pages/' . $page_to_load );
			}


			$translation = $this->get_frontend_translation_data();
			$permalink = get_permalink( $this->settings->calendar_page_id );

			$translation['calendar_url'] = $permalink;

			$tranlsation_module = $this->create_require_js_module( 
				self::FRONTEND_CONFIG_MODULE, 
				$translation 
			);
			$config = $this->create_require_js_module(
				'ai1ec_config',
				$this->get_translation_data()
			);
			echo $require . $require_config . $tranlsation_module . 
					$config . $jquery . $page_js . $common_js;
			ob_end_flush();
		} else {
			// Not modified!
			status_header( 304 );
		}
		// We're done!
		ai1ec_stop( 0 );
	}

	/**
	 * Load javascript files for frontend pages.
	 *
	 * @param $is_calendar_page boolean Whether we are displaying the main
	 *                                  calendar page or not
	 */
	public function load_frontend_js( $is_calendar_page, $is_shortcode = false ) {
		$page = null;

		// ======
		// = JS =
		// ======
		if( $this->are_we_accessing_the_single_event_page() === true ) {
			$page = self::EVENT_PAGE_JS;
		}
		if( $is_calendar_page === true ) {
			$page = self::CALENDAR_PAGE_JS;
		}
		if( null !== $page ) {
			$this->add_link_to_render_js( $page, false );
		}
	}

	/**
	 * Renders everything that's needed for the web widget
	 *
	 */
	public function render_web_widget() {
		header( 'Content-Type: application/javascript' );
		// Aggressive caching to save future requests from the same client.
		$etag = '"' . md5( __FILE__ . AI1EC_VERSION ) . '"';
		header( 'ETag: ' . $etag );
		header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', time() + 31536000 ) . ' GMT' );
		header( 'Cache-Control: public, max-age=31536000' );
		
		if ( empty( $_SERVER['HTTP_IF_NONE_MATCH'] ) || $etag !== stripslashes( $_SERVER['HTTP_IF_NONE_MATCH'] ) ) {
			$ccs_controller = Ai1ec_Less_Factory::create_css_controller_instance();
			$require_main = AI1EC_ADMIN_THEME_JS_URL . '/require.js';
			$data_main = AI1EC_ADMIN_THEME_JS_URL . '/main_widget.js';
			$translation = $this->get_frontend_translation_data();
			$permalink = get_permalink( $this->settings->calendar_page_id );
			$css_url = $ccs_controller->get_css_url();
			$translation['calendar_url'] = $permalink;
			$translation_module = $this->create_require_js_module( self::FRONTEND_CONFIG_MODULE, $translation );
			$config = $this->create_require_js_module(
				'ai1ec_config',
				$this->get_translation_data()
			);
			// get jquery
			$jquery = $this->get_jquery_version_based_on_browser( 
				$_SERVER['HTTP_USER_AGENT']
			);
			echo <<<JS
			/******** Called once Require.js has loaded ******/
			// This needs to be global
			function timely_scriptLoadHandler() {
				// Load translations modules
				$translation_module
				$config
				$jquery
			}
			(function() {
				if( typeof timely === 'undefined' ) {
					var timely_script_tag = document.createElement( 'script' );
					timely_script_tag.setAttribute( "type","text/javascript" );
					timely_script_tag.setAttribute( "src", "$require_main" );
					timely_script_tag.setAttribute( "data-main", "$data_main" );
					timely_script_tag.async = true;
					if ( timely_script_tag.readyState ) {
						timely_script_tag.onreadystatechange = function () { // For old versions of IE
							if ( this.readyState == 'complete' || this.readyState == 'loaded' ) {
								timely_scriptLoadHandler();
							}
						};
					} else { // Other browsers
						timely_script_tag.onload = timely_scriptLoadHandler;
					}
					( document.getElementsByTagName( "head" )[0] || document.documentElement ).appendChild( timely_script_tag );
				} else {
					timely.require( ['main_widget'] );
					timely_scriptLoadHandler();
				}
				var timely_css = document.createElement( 'link' );
				timely_css.setAttribute( "type", "text/css" );
				timely_css.setAttribute( "rel", "stylesheet" );
				timely_css.setAttribute( "href", "$css_url" );
				( document.getElementsByTagName( "head" )[0] || document.documentElement ).appendChild( timely_css );
			})(); // We call our anonymous function immediately
JS;
		} else {
			// Not modified!
			status_header( 304 );
		}
		exit;
	}

	/**
	 *	Check if we are in the calendar feeds page
	 *
	 * @return boolean TRUE if we are in the calendar feeds page FALSE otherwise
	 */
	private function are_we_on_calendar_feeds_page() {
		$path_details = pathinfo( $_SERVER["SCRIPT_NAME"] );
		$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : FALSE;
		$page = isset( $_GET['page'] ) ? $_GET['page'] : FALSE;
		if( $post_type === FALSE || $page === FALSE ) {
			return FALSE;
		}
		$is_calendar_feed_page = $path_details['basename'] === 'edit.php' &&
		                         $post_type                === 'ai1ec_event' &&
		                         $page                     === 'all-in-one-event-calendar-feeds';
		return $is_calendar_feed_page;
	}

	/**
	 * Creates a requirejs module that can be used for translations
	 *
	 * @param string $object_name
	 * @param array $data
	 * @return string
	 */
	private function create_require_js_module( $object_name, array $data ) {
		foreach ( (array) $data as $key => $value ) {
			if ( !is_scalar($value) )
				continue;
			$data[$key] = html_entity_decode( (string) $value, ENT_QUOTES, 'UTF-8');
		}
		$json_data = json_encode( $data );
		$prefix = self::REQUIRE_NAMESPACE;
		$script = "$prefix.define( '$object_name', $json_data );";

		return $script;
	}

	/**
	 * Get the array with translated data for the frontend
	 *
	 * @return array
	 */
	private function get_frontend_translation_data() {
		$data = array(
			'export_url' => AI1EC_EXPORT_URL,
		);
		// Replace desired CSS selector with calendar, if selector has been set
		if( $this->settings->calendar_css_selector ) {
			$page             = get_post( $this->settings->calendar_post_id );
			$data['selector'] = $this->settings->calendar_css_selector;
			$data['title']    = $page->post_title;
		}
		$data['fonts'] = array();
		$fonts_dir = AI1EC_DEFAULT_THEME_URL . '/font_css/';
		$data['fonts'][] = array(
			'name' => 'League Gothic',
			'url'  => $fonts_dir . 'font-league-gothic.css',
		);
		$data['fonts'][] = array(
			'name' => 'fontawesome',
			'url'  => $fonts_dir . 'font-awesome.css',
		);
		return $data;
	}

	/**
	 * check if we are editing an event
	 *
	 * @return boolean TRUE if we are editing an event FALSE otherwise
	 */
	private function are_we_editing_an_event() {
		$path_details = pathinfo( $_SERVER["SCRIPT_NAME"] );
		$post_id = isset( $_GET['post'] ) ? $_GET['post'] : FALSE;
		$action = isset( $_GET['action'] ) ? $_GET['action'] : FALSE;
		if( $post_id === FALSE || $action === FALSE ) {
			return FALSE;
		}

		$editing = $path_details['basename'] === 'post.php' &&
		           $action                   === 'edit' &&
		           get_post_type( $post_id ) === AI1EC_POST_TYPE;
		return $editing;
	}

	/**
	 * check if we are creating a new event
	 *
	 * @return boolean TRUE if we are creating a new event FALSE otherwise
	 */
	private function are_we_creating_a_new_event() {
		$path_details = pathinfo( $_SERVER["SCRIPT_NAME"] );
		$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
		return $path_details['basename'] === 'post-new.php' && $post_type === AI1EC_POST_TYPE;
	}

	/**
	 * Check if we are accessing the settings page
	 *
	 * @return boolean TRUE if we are accessing the settings page FALSE otherwise
	 */
	private function are_we_accessing_the_calendar_settings_page() {
		$path_details = pathinfo( $_SERVER["SCRIPT_NAME"] );
		$page = isset( $_GET['page'] ) ? $_GET['page'] : '';
		return $path_details['basename'] === 'edit.php' && $page === AI1EC_PLUGIN_NAME . '-settings';
	}

	/**
	 * Check if we are editing less variables
	 *
	 * @return boolean TRUE if we are accessing a single event page FALSE otherwise
	 */
	private function are_we_editing_less_variables() {
		$path_details = pathinfo( $_SERVER["SCRIPT_NAME"] );
		$page = isset( $_GET['page'] ) ? $_GET['page'] : '';
		return $path_details['basename'] === 'edit.php' && $page === AI1EC_PLUGIN_NAME . '-edit-css';
	}

	/**
	 * Check if we are accessing the events category page
	 *
	 * @return boolean TRUE if we are accessing the events category page FALSE otherwise
	 */
	private function are_we_editing_event_categories() {
		$path_details = pathinfo( $_SERVER["SCRIPT_NAME"] );
		$post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
		return $path_details['basename'] === 'edit-tags.php' && $post_type === AI1EC_POST_TYPE;
	}

	/**
	 * Check if we are accessing a single event page
	 *
	 * @return boolean TRUE if we are accessing a single event page FALSE otherwise
	 */
	private function are_we_accessing_the_single_event_page() {
		return get_post_type() === AI1EC_POST_TYPE;
	}

	/**
	 * Create the array needed for translation and passing other settings to JS.
	 *
	 * @return $data array the dynamic data array
	 */
	private function get_translation_data() {
		global $ai1ec_importer_plugin_helper;

		$force_ssl_admin = force_ssl_admin();
		if ( $force_ssl_admin && ! is_ssl() ) {
			force_ssl_admin( false );
		}
		$ajax_url        = admin_url( 'admin-ajax.php' );
		force_ssl_admin( $force_ssl_admin );

		$data = array(
			'select_one_option'              => __( 'Select at least one user/group/page to subscribe to.', AI1EC_PLUGIN_NAME ),
			'is_calendar_page'               => isset( $_GET[self::IS_CALENDAR_PAGE] ) && $_GET[self::IS_CALENDAR_PAGE] === self::TRUE_PARAM,
			'error_no_response'              => __( 'An unexpected error occurred. Try reloading the page.', AI1EC_PLUGIN_NAME ),
			'no_more_subscription'           => __( 'No subscriptions yet!', AI1EC_PLUGIN_NAME ),
			'no_more_than_ten'               => __( 'Please select no more than ten users/groups/pages at a time to avoid overloading Facebook requests.', AI1EC_PLUGIN_NAME ),
			// ICS feed error messages
			'duplicate_feed_message'         => esc_html__( 'This feed is already being imported.', AI1EC_PLUGIN_NAME ),
			'invalid_url_message'            => esc_html__( 'Please enter a valid iCalendar URL.', AI1EC_PLUGIN_NAME ),
			'invalid_email_message'          => esc_html__( 'Please enter a valid e-mail address.', AI1EC_PLUGIN_NAME ),
			// Current time, used for date/time pickers
			'now'                            => $this->events_helper->gmt_to_local( Ai1ec_Time_Utility::current_time() ),
			// Date format for date pickers
			'date_format'                    => $this->settings->input_date_format,
			// Names for months in date picker header (escaping is done in wp_localize_script)
			'month_names'                    => $this->ai1ec_locale->get_localized_month_names(),
			// Names for days in date picker header (escaping is done in wp_localize_script)
			'day_names'                      => $this->ai1ec_locale->get_localized_week_names(),
			// Start the week on this day in the date picker
			'week_start_day'                 => $this->settings->week_start_day,
			// 24h time format for time pickers
			'twentyfour_hour'                => $this->settings->input_24h_time,
			// Set region biasing for geo_autocomplete plugin
			'region'                         => ( $this->settings->geo_region_biasing ) ? $this->events_helper->get_region() : '',
			'disable_autocompletion'         => $this->settings->disable_autocompletion,
			'error_message_not_valid_lat'    => __( 'Please enter a valid latitude. A valid latitude is comprised between +90 and -90.', AI1EC_PLUGIN_NAME ),
			'error_message_not_valid_long'   => __( 'Please enter a valid longitude. A valid longitude is comprised between +180 and -180.', AI1EC_PLUGIN_NAME ),
			'error_message_not_entered_lat'  => __( 'When the "Input coordinates" checkbox is checked, "Latitude" is a required field.', AI1EC_PLUGIN_NAME ),
			'error_message_not_entered_long' => __( 'When the "Input coordinates" checkbox is checked, "Longitude" is a required field.', AI1EC_PLUGIN_NAME ),
			'language'                       => $this->events_helper->get_lang(),
			// This function will be set later if needed
			'page'                           => '',
			'page_on_front_description'      => __( 'This setting cannot be changed in Event Platform mode.', AI1EC_PLUGIN_NAME ),
			// if the user is the super admin we disable this later
			'strict_mode'                    => $this->settings->event_platform_strict,
			'platform_active'                => $this->settings->event_platform_active,
			'facebook_logged_in'             => $ai1ec_importer_plugin_helper->check_if_we_have_a_valid_facebook_access_token(),
			'app_id_and_secret_are_required' => __( 'You must specify both an app ID and app secret to connect to Facebook.', AI1EC_PLUGIN_NAME ),
			'file_upload_required'           => __( 'You must specify a valid file to upload or paste your data into the text field.', AI1EC_PLUGIN_NAME ),
			'file_upload_not_permitted'      => __( 'Only .ics and .csv files are supported.', AI1EC_PLUGIN_NAME ),
			'ajax_url'                       => $ajax_url,
			'url_not_valid'                  => __( 'The URL you have entered seems to be invalid. Please remember that URLs must start with either "http://" or "https://".', AI1EC_PLUGIN_NAME ),
			'mail_url_required'              => __( 'Both the <em>calendar URL</em> and <em>e-mail address</em> fields are required.', AI1EC_PLUGIN_NAME ),
			'confirm_reset_theme'            => __( 'Are you sure you want to reset your theme options to their default values?', AI1EC_PLUGIN_NAME ),
			'license_key'                    => $this->settings->get_license_key(),
			'reset_saved_filter_text'        => __( 'Save this filter as default', AI1EC_PLUGIN_NAME ),
			'clear_saved_filter_text'        => __( 'Remove default filter', AI1EC_PLUGIN_NAME ),
			'save_filter_text_ok'            => __( 'The active filter has been saved as your default for this calendar.', AI1EC_PLUGIN_NAME ),
			'remove_filter_text_ok'          => __( 'Your default calendar filter has been removed.', AI1EC_PLUGIN_NAME ),
			'size_less_variable_not_ok'      => __( 'The value you have entered is not a valid CSS length.', AI1EC_PLUGIN_NAME ),
			'week_view_starts_at'            => $this->settings->week_view_starts_at,
			'week_view_ends_at'              => $this->settings->week_view_ends_at,
			'end_must_be_after_start'        => __( 'The end date can\'t be earlier than the start date.', AI1EC_PLUGIN_NAME ),
			'show_at_least_six_hours'        => __( 'For week and day view, you must select an interval of at least 6 hours.', AI1EC_PLUGIN_NAME ),
			'label_buy_tickets_url'          => __( 'Buy tickets URL (optional)', AI1EC_PLUGIN_NAME ),
			'label_rsvp_url'                 => __( 'Registration URL (optional)', AI1EC_PLUGIN_NAME ),
			'label_a_buy_tickets_url'        => __( 'Buy Tickets URL:', AI1EC_PLUGIN_NAME ),
			'label_a_rsvp_url'               => __( 'Registration URL:', AI1EC_PLUGIN_NAME ),
			'event_price_not_entered'        => __( 'Please enter an event cost, or mark the event as free.', AI1EC_PLUGIN_NAME ),
			'blog_timezone'                  => Ai1ec_Meta::get_option('gmt_offset'),
			'use_select2'                    => $this->settings->use_select2_widgets,
			'require_desclaimer'             => __( 'If you choose to require a disclaimer on the front-end event creation form, you must provide the disclaimer text (HTML allowed) in the appropriate field.', AI1EC_PLUGIN_NAME ),

		);
		return $data;
	}

	/**
	 * load_js_translations function
	 *
	 * Load js data required by the calendar view
	 *
	 * @param string $handle the handle to use
	 *
	 * @return void
	 **/
	private function load_frontend_js_translations( $handle ) {
		$data = $this->get_frontend_translation_data();
		$this->ai1ec_scripts->localize_script_for_requirejs(
			$handle,
			self::FRONTEND_CONFIG_MODULE,
			$data,
			true
		);
	}
}
