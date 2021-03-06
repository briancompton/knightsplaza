<?php
//
//  class-ai1ec-settings.php
//  all-in-one-event-calendar
//
//  Created by The Seed Studio on 2011-07-13.
//

/**
 * Ai1ec_Settings class
 *
 * @package Models
 * @author time.ly
 **/
class Ai1ec_Settings {
	/**
	 * Default start hour for week/day views.
	 */
	const WEEK_VIEW_STARTS_AT = 8;
	/**
	 * Default end hour for week/day views.
	 */
	const WEEK_VIEW_ENDS_AT = 24;

	/**
	 * _instance class variable
	 *
	 * Class instance
	 *
	 * @var null | object
	 **/
	private static $_instance = NULL;

	/**
	 * Class variable to list default categories
	 *
	 * @var array
	 */
	public static $default_categories = NULL;

	/**
	 * Class variable to list default tags
	 *
	 * @var array
	 */
	public static $default_tags = NULL;

	/**
	 * posterboard_events_per_page class variable
	 *
	 * @var int
	 **/
	public $posterboard_events_per_page;

	/**
	 * @var bool Set to true, to disable standard calendar filter menu
	 */
	public $disable_standard_filter_menu;

	/**
	 * posterboard_tile_min_width class variable
	 *
	 * @var int
	 **/
	public $posterboard_tile_min_width;

	/**
	 * stream_events_per_page class variable
	 *
	 * @var int
	 **/
	public $stream_events_per_page;

	/**
	 * week_view_starts_at class variable
	 *
	 * @var int
	 **/
	public $week_view_starts_at;

	/**
	 * week_view_ends_at class variable
	 *
	 * @var int
	 **/
	public $week_view_ends_at;


	/**
	 * calendar_page_id class publiciable
	 *
	 * @var int
	 **/
	public $calendar_page_id;

	/**
	 * default_calendar_view class variable
	 *
	 * @var string
	 **/
	public $default_calendar_view;

	/**
	 * view_month_enabled class variable
	 *
	 * @var string
	 **/
	public $view_month_enabled;

	/**
	 * view_week_enabled class variable
	 *
	 * @var string
	 **/
	public $view_week_enabled;

	/**
	 * view_oneday_enabled class variable
	 *
	 * @var string
	 **/
	public $view_oneday_enabled;

	/**
	 * view_agenda_enabled class variable
	 *
	 * @var string
	 **/
	public $view_agenda_enabled;

	/**
	 * week_start_day class variable
	 *
	 * @var int
	 **/
	public $week_start_day;

	/**
	 * agenda_events_per_page class variable
	 *
	 * @var int
	 **/
	public $agenda_events_per_page;

	/**
	 * agenda_include_entire_last_day class variable
	 *
	 * @var int
	 **/
	public $agenda_include_entire_last_day;

	/**
	 * calendar_css_selector class variable
	 *
	 * @var string
	 **/
	public $calendar_css_selector;

	/**
	 * include_events_in_rss class variable
	 *
	 * @var bool
	 **/
	public $include_events_in_rss;

	/**
	 * allow_publish_to_facebook class variable
	 *
	 * @var bool
	 **/
	public $allow_publish_to_facebook;

	/**
	 * facebook_credentials class variable
	 *
	 * @var array
	 **/
	public $facebook_credentials;

	/**
	 * @var string Twitter OAuth API key (id)
	 */
	public $oauth_twitter_id;

	/**
	 * @var string Twitter OAuth API secret
	 */
	public $oauth_twitter_pass;

	/**
	 * @var string Time specifier to indicate how early tweet should be sent
	 *             before the start of event
	 */
	public $twitter_notice_interval;

	/**
	 * user_role_can_create_event class variable
	 *
	 * @var bool
	 **/
	public $user_role_can_create_event;

	/**
	 * cron_freq class variable
	 *
	 * Cron frequency
	 *
	 * @var string
	 **/
	public $cron_freq;

	/**
	 * timezone class variable
	 *
	 * @var string
	 **/
	public $timezone;

	/**
	 * exclude_from_search class variable
	 *
	 * Whether to exclude events from search results
	 * @var bool
	 **/
	public $exclude_from_search;

	/**
	 * show_publish_button class variable
	 *
	 * Display publish button at the bottom of the
	 * submission form
	 *
	 * @var bool
	 **/
	public $show_publish_button;

	/**
	 * if specified, the calendar will use it as a starting date instead of the current day.
	 *
	 * @var string
	 **/
	public $exact_date;

	/**
	 * hide_maps_until_clicked class variable
	 *
	 * When this setting is on, instead of showing the Google Map,
	 * show a dotted-line box containing the text "Click to view map",
	 * and when clicked, this box is replaced by the Google Map.
	 *
	 * @var bool
	 **/
	public $hide_maps_until_clicked;

	/**
	 * agenda_events_expanded class variable
	 *
	 * When this setting is on, events are expanded
	 * in agenda view
	 *
	 * @var bool
	 **/
	public $agenda_events_expanded;

	/**
	 * show_create_event_button class variable
	 *
	 * Display "Post Your Event" button on the calendar page for those users with
	 * the privilege.
	 *
	 * @var bool
	 **/
	public $show_create_event_button;

	/**
	 * Show front-end event creation form if users click the "Post Your Event"
	 * button.
	 *
	 * @var bool
	 */
	public $show_front_end_create_form;

	/**
	 * Allow anonymous users to submit events for review using front-end event
	 * creation form.
	 *
	 * @var bool
	 */
	public $allow_anonymous_submissions;

	/**
	 * Allow anonymous users to uploads images for their events using front-end
	 * event creation form.
	 *
	 * @var bool
	 */
	public $allow_anonymous_uploads;

	/**
	 * Show front-end Add Your Calendar Feed button.
	 *
	 * @var bool
	 */
	public $show_add_calendar_button;

	/**
	 * reCAPTCHA public key
	 *
	 * @var string
	 */
	public $recaptcha_public_key;

	/**
	 * reCAPTCHA private key
	 *
	 * @var string
	 */
	public $recaptcha_private_key;

	/**
	 * turn_off_subscription_buttons class variable
	 *
	 * Hides "Subscribe"/"Add to Calendar" and same Google buttons in calendar and
	 * single event views
	 *
	 * @var bool
	 **/
	public $turn_off_subscription_buttons;

	/**
	 * inject_categories class variable
	 *
	 * Include Event Categories as part of the output of the wp_list_categories()
	 * template tag.
	 *
	 * @var bool
	 **/
	public $inject_categories;

	/**
	 * use_select2_widgets class variable
	 *
	 * Use select2 widgets for filtering
	 *
	 * @var bool
	 **/
	public $use_select2_widgets;

	/**
	 * input_date_format class variable
	 *
	 * Date format used for date input. For supported formats
	 * @see jquery.calendrical.js
	 *
	 * @var string
	 **/
	public $input_date_format;

	/**
	 * input_24h_time class variable
	 *
	 * Use 24h time in time pickers.
	 *
	 * @var bool
	 **/
	public $input_24h_time;

	/**
	 * settings_page class variable
	 *
	 * Stores a reference to the settings page added using the
	 * add_submenu_page function.
	 *
	 * @var object
	 */
	public $settings_page;

	/**
	 * feeds_page class variable
	 *
	 * Stores a reference to the calendar feeds page added using the
	 * add_submenu_page function.
	 *
	 * @var object
	 */
	public $feeds_page;

	/**
	 * Stores a reference to the less_variables page added using the
	 * add_submenu_page function.
	 *
	 * @var object
	 */
	public $less_variables_page;
	/**
	 * geo_region_biasing class variable
	 *
	 * If set to TRUE the ISO-3166 part of the configured
	 * locale in WordPress is going to be used to bias the
	 * geo autocomplete plugin towards a specific region.
	 *
	 * @var bool
	 **/
	public $geo_region_biasing;

	/**
	 * Whether to display data collection notice on the admin side.
	 *
	 * @var bool
	 */
	public $show_data_notification;

	/**
	 * Whether to display the introductory video notice.
	 *
	 * @var bool
	 */
	public $show_intro_video;

	/**
	 * Whether to display a warning about an invalid license.
	 *
	 * @var string
	 */
	public $license_warning;

	/**
	 * Whether to collect event data for Timely.
	 *
	 * @var bool
	 */
	public $allow_statistics;

	/**
	 * Turn this blog into an events-only platform (this setting is overridden by
	 * AI1EC_EVENT_PLATFORM; i.e. if that is TRUE, this setting does nothing).
	 *
	 * @var bool
	 */
	public $event_platform;

	/**
	 * Enable "strict" event platform mode for this blog.
	 *
	 * @var bool
	 */
	public $event_platform_strict;

	/**
	 * Require a disclaimer for the frontend event form.
	 *
	 * @var bool
	 */
	public $require_disclaimer;

	/**
	 * The disclaimer required by the checkbox.
	 *
	 * @var string
	 */
	public $disclaimer;

	/**
	 * Holds the configuration options of the various plugins.
	 *
	 * @var array
	 */
	public $plugins_options;

	/**
	 * Disable Google Maps autocomplete functionality on add/edit event forms.
	 * (FYI: this does NOT disable autocompletion in general, like Select2.)
	 *
	 * @var bool
	 */
	public $disable_autocompletion;

	/**
	 * Show location name in event title in various calendar views.
	 *
	 * @var bool
	 */
	public $show_location_in_title;

	/**
	 * Show year in agenda date labels.
	 *
	 * @var bool
	 */
	public $show_year_in_agenda_dates;

	/**
	 * Skip in_the_loop() check when displaying calendar page to make plugin
	 * compatible with certain themes.
	 */
	public $skip_in_the_loop_check;

	/**
	 * An array of views which have the Buy Tickets button enabled.
	 *
	 * @var array
	 */
	public $views_enabled_ticket_button;

	/**
	 * Ajaxify the events in the widget instead of redirecting the user to the calendar.
	 *
	 * @var bool
	 */
	public $ajaxify_events_in_web_widget;

	/**
	 * Pro license key.
	 *
	 * @var string
	 */
	public $license_key;

	/**
	 * @var bool Set to false to disable e-mail notifications about upcoming events
	 */
	public $enable_user_event_notifications;

	/**
	 * Subject of mail sent to admin when a new calendar feed is contributed.
	 *
	 * @var string
	 */
	public $admin_mail_subject;

	/**
	 * Body of mail sent to admin when a new calendar feed is contributed.
	 *
	 * @var string
	 */
	public $admin_mail_body;

	/**
	 * Subject of mail sent to user when a new calendar feed is contributed.
	 *
	 * @var string
	 */
	public $user_mail_subject;

	/**
	 * Body of mail sent to user when a new calendar feed is contributed.
	 *
	 * @var string
	 */
	public $user_mail_body;

	/**
	 * Whether the calendar url should be used as a base for events permalinks
	 * 
	 * @var boolean
	 */
	public $calendar_base_url_for_permalinks;

	/**
	 * @var string View cache refresh interval
	 */
	public $view_cache_refresh_interval;

	/**
	 * Body of mail sent to admin when a new event is added.
	 *
	 * @var string
	 */
	public $admin_add_new_event_mail_body;
	
	/**
	 * Subject of mail sent to admin when a new event is added.
	 *
	 * @var string
	 */
	public $admin_add_new_event_mail_subject;

	/**
	 * Body of mail sent to user about upcoming event
	 *
	 * @var string
	 */
	public $user_upcoming_event_mail_body;
	
	/**
	 * Subject of mail sent to user about upcoming event
	 *
	 * @var string
	 */
	public $user_upcoming_event_mail_subject;

	/**
	 * @var bool Set to true to enable filtering by authors
	 */
	public $use_authors_filter;

	/**
	 * @var bool Disable GZIP compression for JS/CSS
	 */
	public $disable_gzip_compression;

	/**
	 * __construct function
	 *
	 * Default constructor
	 **/
	private function __construct() {
		$this->set_defaults(); // set default settings
	}

	/**
	 * term_deletion method
	 *
	 * Action to be triggered on `delete_term`.
	 *
	 * @param int    $term_id  ID of term being deleted
	 * @param int    $tax_id   ID of taxonomy, which this term belonged to
	 * @param string $taxonomy Name of taxonomy, which this term belonged to
	 *
	 * @return void Method does not return
	 */
	public function term_deletion( $term_id, $tax_id, $taxonomy ) {
		$changed = false;
		foreach ( $this->default_categories as $key => $cat_id ) {
			if ( $cat_id == $term_id ) {
				unset( $this->default_categories[$key] );
				$changed = true;
			}
		}
		foreach ( $this->default_tags as $key => $tag_id ) {
			if ( $tag_id == $term_id ) {
				unset( $this->default_tags[$key] );
				$changed = true;
			}
		}
		if ( $changed ) {
			$this->save_only_settings_object();
		}
	}

	/**
	 * get_instance function
	 *
	 * Return singleton instance
	 *
	 * @return Ai1ec_Settings
	 **/
	static function get_instance( $refresh = false ) {
		if( self::$_instance === NULL || $refresh ) {
			// if W3TC is enabled, we have to empty the cache
			// before requesting it
			if ( defined( 'W3TC' ) || defined( 'WP_CACHE' ) ) {
				wp_cache_delete( 'alloptions', 'options' );
			}
			// get the settings from the database
			self::$_instance = Ai1ec_Meta::get_option( 'ai1ec_settings' );

			// if there are no settings in the database
			// save default values for the settings
			if( ! self::$_instance ) {
				self::$_instance = new self();
				delete_option( 'ai1ec_settings' );
				add_option( 'ai1ec_settings', self::$_instance );
			} else {
				self::$_instance->set_defaults(); // set default settings
			}
			self::$_instance = apply_filters(
				'ai1ec_settings_initiated',
				self::$_instance
			);
		}

		return self::$_instance;
	}

	/**
	 * is_timezone_open_for_change method
	 *
	 * Check if it is allowed to change timezone.
	 * It is *yes* (`bool(true)`) if WordPress timezone string was not set.
	 *
	 * @return bool True if timezone may be modified
	 */
	static public function is_timezone_open_for_change() {
		return ( ! get_option( 'timezone_string' ) );
	}

	/**
	 * Magic get function. Returns handy dynamic settings (not stored in DB).
	 *
	 * @param string $name Property name
	 *
	 * @return mixed Property value
	 */
	public function __get( $name ) {
		switch ( $name ) {
			// Returns whether Event Platform mode is active (OR of constant value and
			// current setting).
			case 'event_platform_active':
				return AI1EC_EVENT_PLATFORM || $this->event_platform;
		}
	}

	/**
	 * Save only the setting object withouth updating the CRON and other options.
	 * Used in the importer plugins architecture to avoid resetting the cron when saving plugin variables
	 *
	 *
	 * @return void
	 */
	function save_only_settings_object() {
		update_option( 'ai1ec_settings', $this );
		return Ai1ec_Events_List_Helper::get_instance()->purge();
	}

	/**
	 * save function
	 *
	 * Save settings to the database.
	 *
	 * @return void
	 **/
	function save() {
		update_option( 'ai1ec_settings', $this );
		update_option( 'start_of_week', $this->week_start_day );
		update_option( 'ai1ec_cron_version', Ai1ec_Meta::get_option( 'ai1ec_cron_version' ) + 1 );
		if ( $this->is_timezone_open_for_change() ) {
			update_option( 'timezone_string', $this->timezone );
		}
		return Ai1ec_Events_List_Helper::get_instance()->purge();
	}

	/**
	 * set_defaults function
	 *
	 * Set default values for settings.
	 *
	 * @return void
	 **/
	function set_defaults() {
		$admin_mail_subject = __( 
			"[[site_title]] New iCalendar (.ics) feed submitted for review",
			AI1EC_PLUGIN_NAME
		);
		$admin_mail_body = __(
			"A visitor has submitted their calendar feed for review:\n\niCalendar feed URL: [feed_url]\nCategories: [categories]\n\nTo add this feed to your calendar, visit your Calendar Feeds admin screen and add it as an ICS feed:\n[feeds_url]\n\nPlease respond to this user by e-mail ([user_email]) to let them know whether or not their feed is approved.\n\n[site_title]\n[site_url]",
			AI1EC_PLUGIN_NAME
		);
		$user_mail_subject = __( 
			"[[site_title]] Thanks for your calendar submission",
			 AI1EC_PLUGIN_NAME
		);
		$user_mail_body = __(
			"We have received your calendar submission. We will review it shortly and let you know if it is approved.\n\nThere is a small chance that your submission was lost in a spam trap. If you don't hear from us soon, please resubmit.\n\nThanks,\n[site_title]\n[site_url]",
			AI1EC_PLUGIN_NAME
		);
		$admin_add_new_event_subject = __(
			"[[site_title]] New event submission",
			AI1EC_PLUGIN_NAME
		);
		$admin_add_new_event_body = __(
			"A new event has been submitted to the site.\n\nEvent title: [event_title]\nModify the event here: [event_admin_url].\n\nThanks,\n[site_title]\n[site_url]",
			AI1EC_PLUGIN_NAME
		);
		$user_upcoming_event_subject = __(
			'[[site_title]] Event reminder: [event_title]',
			AI1EC_PLUGIN_NAME
		);
		$user_upcoming_event_body = __(
			"An event you have indicated interest in is about to start:\n\nEvent title: [event_title]\nStarting at: [event_start]\n\nView the event’s details here: [event_url]\n\n(You have received this alert because you asked to receive an email notification for this event.)\n\nRegards,\n[site_title]\n[site_url]",
			AI1EC_PLUGIN_NAME
		);
		$license_key = $this->get_license_key();
		$defaults    = array(
			'calendar_page_id'                 => 0,
			'default_calendar_view'            => 'posterboard',
			'default_categories'               => array(),
			'default_tags'                     => array(),
			'view_posterboard_enabled'         => TRUE,
			'view_stream_enabled'              => TRUE,
			'view_month_enabled'               => TRUE,
			'view_week_enabled'                => TRUE,
			'view_oneday_enabled'              => TRUE,
			'view_agenda_enabled'              => TRUE,
			'calendar_css_selector'            => '',
			'week_start_day'                   => Ai1ec_Meta::get_option(
				'start_of_week'
			),
			'exact_date'                       => '',
			'posterboard_events_per_page'      => 30,
			'disable_standard_filter_menu'     => false,
			'posterboard_tile_min_width'       => 240,
			'stream_events_per_page'           => 30,
			'week_view_starts_at'              => self::WEEK_VIEW_STARTS_AT,
			'week_view_ends_at'                => self::WEEK_VIEW_ENDS_AT,
			'agenda_events_per_page'           => Ai1ec_Meta::get_option(
				'posts_per_page'
			),
			'agenda_include_entire_last_day'   => FALSE,
			'agenda_events_expanded'           => FALSE,
			'include_events_in_rss'            => FALSE,
			'allow_publish_to_facebook'        => FALSE,
			'facebook_credentials'             => NULL,
			'user_role_can_create_event'       => NULL,
			'show_publish_button'              => FALSE,
			'hide_maps_until_clicked'          => FALSE,
			'exclude_from_search'              => FALSE,
			'show_create_event_button'         => FALSE,
			'show_front_end_create_form'       => FALSE,
			'allow_anonymous_submissions'      => FALSE,
			'allow_anonymous_uploads'          => FALSE,
			'show_add_calendar_button'         => FALSE,
			'recaptcha_public_key'             => '',
			'recaptcha_private_key'            => '',
			'turn_off_subscription_buttons'    => FALSE,
			'inject_categories'                => FALSE,
			'input_date_format'                => 'def',
			'input_24h_time'                   => FALSE,
			'cron_freq'                        => 'daily',
			'timezone'                         => Ai1ec_Meta::get_option(
				'timezone_string'
			),
			'geo_region_biasing'               => FALSE,
			'show_data_notification'           => TRUE,
			'show_intro_video'                 => TRUE,
			'license_warning'                  => 'valid',
			'allow_statistics'                 => TRUE,
			'event_platform'                   => FALSE,
			'event_platform_strict'            => FALSE,
			'require_disclaimer'               => FALSE,
			'disclaimer'                       => '',
			'plugins_options'                  => array(),
			'disable_autocompletion'           => FALSE,
			'show_location_in_title'           => TRUE,
			'show_year_in_agenda_dates'        => FALSE,
			'views_enabled_ticket_button'      => array(),
			'skip_in_the_loop_check'           => false,
			'ajaxify_events_in_web_widget'     => false,
			'admin_mail_subject'               => $admin_mail_subject,
			'admin_mail_body'                  => $admin_mail_body,
			'user_mail_subject'                => $user_mail_subject,
			'user_mail_body'                   => $user_mail_body,
			'admin_add_new_event_mail_body'    => $admin_add_new_event_body,
			'admin_add_new_event_mail_subject' => $admin_add_new_event_subject,
			'user_upcoming_event_mail_body'    => $user_upcoming_event_body,
			'user_upcoming_event_mail_subject' => $user_upcoming_event_subject,
			'license_key'                      => $license_key,
			'calendar_base_url_for_permalinks' => false,
			'view_cache_refresh_interval'      => NULL,
			'enable_user_event_notifications'  => true,
			'oauth_twitter_id'                 => '',
			'oauth_twitter_pass'               => '',
			'use_select2_widgets'              => false,
			'twitter_notice_interval'          => '8h',
			'use_authors_filter'               => false,
			'disable_gzip_compression'         => false,
		);
		$ai1ec_purge_events_cache = Ai1ec_Scheduling_Utility::instance()
			->get_details( 'ai1ec_purge_events_cache' );
		$defaults['view_cache_refresh_interval'] =
			$ai1ec_purge_events_cache['freq'];
		unset( $ai1ec_purge_events_cache );

		foreach ( $defaults as $key => $default ) {
			if ( ! isset( $this->$key ) ) {
				$this->$key = $default;
			}
		}

		// Force enable data collection setting.
		$this->allow_statistics = $defaults['allow_statistics'];
	}

	/**
	 * update method
	 *
	 * Route request, according to {$settings_page} to underlying interface
	 * method, which validates fields. May raise deprecation notice at some
	 * time in the future, as call shall be altered, actually.
	 *
	 * @param string $settings_page Which settings page is being updated.
	 * @param array  $params        Assoc. array of new settings
	 *
	 * @return bool Success
	 */
	function update( $settings_page, $params ) {
		static $known_pages = array(
			'settings' => true,
			'feeds'    => true,
		);

		if ( ! isset( $known_pages[$settings_page] ) ) {
			return false;
		}
		return $this->{'update_' . $settings_page}( $params );
	}

	/**
	 * update_settings method
	 *
	 * Handle settings page submit.
	 *
	 * @param array $params User supplied settings options
	 *
	 * @return bool Success
	 */
	public function update_settings( array $params ) {
		global $ai1ec_app_helper;
		// Default values to use for fields if none provided.
		$field_defaults = array(
			'default_categories' => array(),
			'default_tags'       => array(),
		);

		$field_names = array(
			'default_categories',
			'default_tags',
			'default_calendar_view',
			'calendar_css_selector',
			'week_start_day',
			'exact_date',
			'posterboard_events_per_page',
			'posterboard_tile_min_width',
			'stream_events_per_page',
			'week_view_ends_at',
			'week_view_starts_at',
			'agenda_events_per_page',
			'input_date_format',
			'allow_events_posting_facebook',
			'facebook_credentials',
			'user_role_can_create_event',
			'timezone',
			'recaptcha_public_key',
			'recaptcha_private_key',
			'admin_mail_subject',
			'admin_mail_body',
			'user_mail_subject',
			'user_mail_body',
			'view_cache_refresh_interval',
			'admin_add_new_event_mail_body',
			'admin_add_new_event_mail_subject',
			'user_upcoming_event_mail_body',
			'user_upcoming_event_mail_subject',
			'license_key',
			'oauth_twitter_id',
			'oauth_twitter_pass',
			'twitter_notice_interval',
			'disclaimer',
		);

		$checkboxes = array(
			'disable_standard_filter_menu',
			'view_posterboard_enabled',
			'view_stream_enabled',
			'view_month_enabled',
			'view_week_enabled',
			'view_oneday_enabled',
			'view_agenda_enabled',
			'agenda_include_entire_last_day',
			'agenda_events_expanded',
			'include_events_in_rss',
			'show_publish_button',
			'hide_maps_until_clicked',
			'exclude_from_search',
			'show_create_event_button',
			'show_front_end_create_form',
			'allow_anonymous_submissions',
			'allow_anonymous_uploads',
			'show_add_calendar_button',
			'turn_off_subscription_buttons',
			'inject_categories',
			'input_24h_time',
			'geo_region_biasing',
			'disable_autocompletion',
			'show_location_in_title',
			'show_year_in_agenda_dates',
			'skip_in_the_loop_check',
			'ajaxify_events_in_web_widget',
			'calendar_base_url_for_permalinks',
			'enable_user_event_notifications',
			'use_select2_widgets',
			'require_disclaimer',
			'use_authors_filter',
			'disable_gzip_compression',
		);

		// Save the Buy Tickets Button setting. Since it's a boolean we just set the
		// key so that later we can use isset() instead of in_array(), which is much
		// slower.
		$this->views_enabled_ticket_button = array();
		foreach ( $ai1ec_app_helper->view_names() as $key => $name ) {
			$checkbox_name = "buy_ticket_{$key}_enabled";
			$this->views_enabled_ticket_button[$key] =
				isset( $params[$checkbox_name] );
		}

		// Only super-admins have the power to change Event Platform mode.
		if ( is_super_admin() ) {
			$checkboxes[] = 'event_platform';
			$checkboxes[] = 'event_platform_strict';
		}

		// =====================================
		// = Save the settings for the plugins =
		// =====================================

		global $ai1ec_importer_plugin_helper;
		$ai1ec_importer_plugin_helper->save_plugins_settings( $params );


		// =================================
		// = Assign parameters to settings =
		// =================================

		foreach ( $field_names as $field_name ) {
			if ( isset( $params[$field_name] ) ) {
				$this->$field_name = stripslashes_deep( $params[$field_name] );
			} elseif ( isset( $field_defaults[$field_name] ) ) {
				$this->$field_name = $field_defaults[$field_name];
			}
		}
		foreach ( $checkboxes as $checkbox ) {
			$this->$checkbox = isset( $params[$checkbox] ) ? true : false;
		}

		$frequency = new Ai1ec_Frequency_Utility();
		$frequency->parse( $this->twitter_notice_interval );
		$this->twitter_notice_interval = $frequency->to_string();
		unset( $frequency );

		Ai1ec_Scheduling_Utility::instance()->reschedule(
			'ai1ec_purge_events_cache',
			$this->view_cache_refresh_interval
		);

		// ================================
		// = Validate specific parameters =
		// ================================

		// Posterboard events per page
		$this->posterboard_events_per_page = intval(
			$this->posterboard_events_per_page
		);
		if ( $this->posterboard_events_per_page <= 0 ) {
			$this->posterboard_events_per_page = 1;
		}

		// Stream events per page
		$this->stream_events_per_page = intval(
			$this->stream_events_per_page
		);
		if ( $this->stream_events_per_page <= 0 ) {
			$this->stream_events_per_page = 1;
		}

		// Starting time to show in the week view
		$this->week_view_starts_at = intval(
				$this->week_view_starts_at
		);
		if( $this->week_view_starts_at < 0 || $this->week_view_starts_at > 24 ) {
			$this->week_view_starts_at = self::WEEK_VIEW_STARTS_AT;
		}

		// Starting time to show in the week view
		$this->week_view_ends_at = intval(
				$this->week_view_ends_at
		);
		if( $this->week_view_ends_at < 0 || $this->week_view_ends_at > 24 ) {
			$this->week_view_ends_at = self::WEEK_VIEW_ENDS_AT;
		}

		// Posterboard tile minimum width
		$this->posterboard_tile_min_width = intval(
			$this->posterboard_tile_min_width
		);
		if ( $this->posterboard_tile_min_width <= 0 ) {
			$this->posterboard_tile_min_width = 1;
		}

		// Agenda events per page
		$this->agenda_events_per_page = intval(
			$this->agenda_events_per_page
		);
		if ( $this->agenda_events_per_page <= 0 ) {
			$this->agenda_events_per_page = 1;
		}

		// Calendar default start date
		$exact_date_valid = Ai1ec_Validation_Utility::validate_date(
			$this->exact_date, $this->input_date_format
		);
		if ( false === $exact_date_valid ) {
			$this->exact_date = '';
		}

		// =============================
		// = Update special parameters =
		// =============================

		$this->update_page( 'calendar_page_id', $params );
		// Flush rewrite rules to regenerate them. 
		// Needed for the 
		// Base permalinks of single event pages on the calendar page URL
		// setting
		flush_rewrite_rules();

		return true;
	}

	/**
	 * update_feeds method
	 *
	 * Update feed checking frequence.
	 *
	 * @param array $params Arguments passed from user input
	 *
	 * @return bool Success
	 */
	public function update_feeds( array $params ) {
		// Assign parameters to settings.
		if ( ! isset( $params['cron_freq'] ) ) {
			return false;
		}
		$this->cron_freq = $params['cron_freq'];
		return true;
	}

	/**
	 * Update setting of show_data_notification - whether to display data
	 * collection notice on the admin side.
	 *
	 * @param  boolean $value The new setting for show_data_notification.
	 * @return void
	 */
	function update_notification( $value = FALSE ) {
		$this->show_data_notification = $value;
		update_option( 'ai1ec_settings', $this );
	}

	/**
	 * Update setting of show_intro_video - whether to display the
	 * intro video notice on the admin side.
	 *
	 * @param  boolean $value The new setting for show_intro_video.
	 * @return void
	 */
	function update_intro_video( $value = FALSE ) {
		$this->show_intro_video = $value;
		update_option( 'ai1ec_settings', $this );
	}

	/**
	 * Update setting of license_warning - whether current license is valid, and
	 * whether the user cares. Can be either 'valid', 'invalid', or 'dismissed'.
	 * 'dismissed' implies an invalid license and the user does not want to see
	 * a warning about it.
	 *
	 * Trying to set license status from 'dismissed' to 'invalid' will fail; the
	 * user has indicated they do not want to be reminded of the invalid license.
	 * To return the status to 'invalid', the license must first become 'valid'
	 * again.
	 *
	 * @param  string $value The new setting for license_warning.
	 * @return void
	 */
	function update_license_warning( $value = 'valid' ) {
		if ( 'invalid' !== $value || 'dismissed' !== $this->license_warning ) {
			$this->license_warning = $value;
		}
		update_option( 'ai1ec_settings', $this );
	}

	/**
	 * update_page function
	 *
	 * Update page for the calendar with the one specified by the drop-down box.
	 * If the value is not numeric, user chose to auto-create a new page,
	 * therefore do so.
	 *
	 * @param string $field_name
	 * @param array $params
	 *
	 * @return void
	 **/
	function update_page( $field_name, &$params ) {
		if( ! is_numeric( $params[$field_name] ) &&
				preg_match( '#^__auto_page:(.*?)$#', $params[$field_name], $matches ) )
		{
			$this->$field_name = $params[$field_name] = $this->auto_add_page( $matches[1] );
		} else {
			$this->$field_name = (int) $params[$field_name];
		}
	}

	/**
	 * get_default_terms method
	 *
	 * Get list of default term IDs, set in configuration.
	 *
	 * @param string $type Type of term IDs to get, one of 'all', 'tags', 'cats'
	 *
	 * @return array List of IDs ( id => id tuples )
	 */
	public function get_default_terms( $type = 'all' ) {
		$types = array(
			'all'  => true,
			'tags' => 'default_tags',
			'cats' => 'default_categories',
		);
		if ( ! isset( $types[$type] ) ) {
			return false;
		}
		$terms = array();
		if ( true === $types[$type] ) {
			$terms = array_merge(
				$this->default_tags,
				$this->default_categories
			);
		} elseif ( ! empty( $this->{$types[$type]} ) ) {
			$terms = array_combine(
				$this->{$types[$type]},
				$this->{$types[$type]}
			);
		}
		if ( empty( $terms ) ) {
			return $terms;
		}
		return array_combine( $terms, $terms );
	}

	/**
	 * auto_add_page function
	 *
	 * Auto-create a WordPress page with given name for use by this plugin.
	 *
	 * @param string page_name
	 *
	 * @return int the new page's ID.
	 **/
	function auto_add_page( $page_name ) {
		return wp_insert_post(
			array(
				'post_title' 			=> $page_name,
				'post_type' 			=> 'page',
				'post_status' 		=> 'publish',
				'comment_status' 	=> 'closed'
			)
		);
	}

	/**
	 * Get a licence key
	 *
	 * @return string Time.ly Pro edition license key
	 */
	public function get_license_key() {
		$candidate_keys = array();
		if ( isset( $this->license_key ) ) {
			$candidate_keys[] = $this->license_key;
		}
		if ( defined( 'AI1EC_TIMELY_SUBSCRIPTION' ) ) {
			$candidate_keys[] = AI1EC_TIMELY_SUBSCRIPTION;
		}
		foreach ( $candidate_keys as $license_key ) {
			if ( 'REPLACE_ME' !== $license_key && ! empty( $license_key ) ) {
				return $license_key;
			}
		}
		return ''; // no key available
	}

}
// END class
