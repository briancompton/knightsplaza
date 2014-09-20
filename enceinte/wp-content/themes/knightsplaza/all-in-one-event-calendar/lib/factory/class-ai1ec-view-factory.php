<?php

/**
 * @author Timely Network Inc
 */

class Ai1ec_View_Factory {

	/**
	 * @var boolean
	 */
	private static $pretty_permalinks_enabled = false;

	/**
	 * @var string
	 */
	private static $page;

	/**
	 * @param boolean $pretty_permalinks_enabled
	 */
	public static function set_pretty_permalinks_enabled(
		$pretty_permalinks_enabled
		) {
		Ai1ec_View_Factory::$pretty_permalinks_enabled = $pretty_permalinks_enabled;
	}

	/**
	 * @param string $page
	 */
	public static function set_page( $page ) {
		Ai1ec_View_Factory::$page = $page;
	}

	/**
	 * @param array $args
	 * @param string $type
	 * @return Ai1ec_Href_Helper
	 */
	static public function create_href_helper_instance( array $args, $type = 'normal' ) {
		$href = new Ai1ec_Href_Helper( $args, self::$page );
		$href->set_pretty_permalinks_enabled( self::$pretty_permalinks_enabled );
		switch ( $type ) {
			case 'category':
				$href->set_is_category( true );
				break;
			case 'tag':
				$href->set_is_tag( true );
				break;
			case 'author':
				$href->set_is_author( true );
				break;
			default:
				break;
		}

		return $href;
	}

	/**
	 * Create the html element used as the UI control for the datepicker button.
	 * The href must keep only active filters.
	 *
	 * @param array           $args         Populated args for the view
	 * @param int|string|null $initial_date The datepicker's initially set date
	 * @return Ai1ec_Generic_Html_Tag
	 */
	static public function create_datepicker_link(
		array $args, $initial_date = null
	) {
		global $ai1ec_settings,
		       $ai1ec_view_helper;

		$link = Ai1ec_Helper_Factory::create_generic_html_tag( 'a' );

		$date_format_pattern = Ai1ec_Time_Utility::get_date_pattern_by_key(
			$ai1ec_settings->input_date_format
		);

		if ( $initial_date == null ) {
			// If exact_date argument was provided, use its value to initialize
			// datepicker.
			if ( isset( $args['exact_date'] ) &&
			     $args['exact_date'] !== false &&
			     $args['exact_date'] !== null ) {
				$initial_date = $args['exact_date'];
			}
			// Else default to today's date.
			else {
				$initial_date = Ai1ec_Time_Utility::gmt_to_local(
					Ai1ec_Time_Utility::current_time()
				);
			}
		}
		// Convert initial date to formatted date if required.
		if ( Ai1ec_Validation_Utility::is_valid_time_stamp( $initial_date ) ) {
			$initial_date = Ai1ec_Time_Utility::format_date(
				Ai1ec_Time_Utility::gmt_to_local( $initial_date ),
				$ai1ec_settings->input_date_format
			);
		}

		$link->add_class( 'ai1ec-minical-trigger btn' );
		$link->set_attribute( 'data-date', $initial_date );
		$link->set_attribute( 'data-date-format', $date_format_pattern );
		$link->set_attribute( 'data-date-weekstart',
			$ai1ec_settings->week_start_day );
		$link->set_attribute_expr( $args['data_type'] );

		$text = '<img src="' .
			esc_attr( $ai1ec_view_helper->get_theme_img_url( 'date-icon.png' ) ) .
			'" class="ai1ec-icon-datepicker" />';
		$link->set_text( $text );

		$href_args = array(
			'action' => $args['action'],
			'cat_ids' => $args['cat_ids'],
			'tag_ids' => $args['tag_ids'],
			'exact_date' => "__DATE__",
		);
		$data_href = self::create_href_helper_instance( $href_args );
		$link->set_attribute( 'data-href', $data_href->generate_href() );

		$link->set_attribute( 'href', '#' );
		return $link;
	}

	/**
	 * @return Ai1ec_Blank_Html_Element
	 */
	static public function create_blank_html_element() {
		return new Ai1ec_Blank_Html_Element();
	}

	/**
	 * Creates a multiselect for use with Select2 widget.
	 *
	 * @return Ai1ec_Html_Element
	 */
	static public function create_select2_multiselect( array $args, array $options, array $view_args = null ) {
		// if no data is present and we are in the frontend, return a blank element.
		if( empty( $options ) && null !== $view_args ) {
			return self::create_blank_html_element();
		}
		$ai1ec_events_helper = Ai1ec_Events_Helper::get_instance();
		static $cached_flips = array();
		$select2 = Ai1ec_Helper_Factory::create_select_instance(
			$args['id'],
			$args['name']
		);
		$use_id = isset( $args['use_id'] );
		foreach ( $options as $term ) {
			$option_arguments = array();
			$color = false;
			if( $args['type'] === 'category' ) {
				$color = $ai1ec_events_helper->get_category_color( $term->term_id );
			}
			if ( $color ) {
				$option_arguments["data-color"] = $color;
			}
			if( null !== $view_args ) {
				// create the href for ajax loading
				$href = self::create_href_helper_instance( $view_args, $args['type'] );
				$href->set_term_id( $term->term_id );
				$option_arguments["data-href"] = $href->generate_href();
				// check if the option is selected
				$type_to_check = '';
				// first let's check the correct type
				switch ( $args['type'] ) {
					case 'category': 
						$type_to_check = 'cat_ids';
						break;
					case 'tag':
						$type_to_check = 'tag_ids';
						break;
					case 'author':
						$type_to_check = 'auth_ids';
						break;
				}
				// let's flip the array. Just once for performance sake,
				// the categories doesn't change in the same request
				if( ! isset( $cached_flips[$type_to_check] ) ) {
					$cached_flips[$type_to_check] = array_flip( $view_args[$type_to_check] );
				}
				if( isset( $cached_flips[$type_to_check][$term->term_id] ) ) {
					$option_arguments["selected"] = 'selected';
				}
			}
			if ( true === $use_id ) {
				$select2->add_option( $term->name, $term->term_id, $option_arguments );
			} else {
				$select2->add_option( $term->name, $term->name, $option_arguments );
			}

		}
		$select2->set_attribute( "multiple", "multiple" );
		$select2->set_attribute( "data-placeholder", $args['placeholder'] );
		$select2->add_class( 'ai1ec-select2-multiselect-selector span12' );
		$container = Ai1ec_Helper_Factory::create_generic_html_tag( 'div' );
		if( isset( $args['type'] ) ) {
			$container->add_class( 'ai1ec-' . $args['type'] . '-filter' );
		}
		$container->add_renderable_children( $select2 );
		return $container;
	}

	/**
	 * Creates a tag selector using the Select2 widget.
	 *
	 * @return Ai1ec_Input
	 */
	static public function create_select2_tags( array $args ) {
		if( ! isset ( $args['name'] ) ) {
			$args['name'] = $args['id'];
		}
		// Get tags.
		$tags = get_terms(
			'events_tags',
			array(
				'orderby' => 'name',
				'hide_empty' => 0,
			)
		);

		// Build tags array to pass as JSON.
		$tags_json = array();
		foreach ( $tags as $term ) {
			$tags_json[] = $term->name;
		}
		$tags_json = json_encode( $tags_json );
		$tags_json = _wp_specialchars( $tags_json, 'single', 'UTF-8' );
		$input = Ai1ec_Helper_Factory::create_input_instance();
		$input->set_id( $args['id'] );
		$input->set_name( $args['name'] );
		$input->set_attribute( "data-placeholder",
			__( 'Tags (optional)', AI1EC_PLUGIN_NAME )
		);
		$input->set_attribute( "data-ai1ec-tags", $tags_json );
		$input->add_class( 'ai1ec-tags-selector span12' );
		return $input;
	}

	/**
	 * Check if the cookie and the request arg are the same.
	 * 
	 * @param array $view_args
	 * @param array $cookie
	 * @return boolean
	 */
	static private function check_if_saved_cookie_and_requested_page_match( array $view_args, array $cookie ) {
		foreach( Ai1ec_Cookie_Utility::$types as $type ) {
			// In the cookie values are stored as comma separated valued
			// Convert them to array
			if ( $cookie[$type] != $view_args[$type] ) {
				return false;
			}
		}
		if ( $view_args['action'] !== $cookie['action'] ) {
			return false;
		}
		return true;
	}

	/**
	 * @return Ai1ec_Generic_Html_Tag
	 */
	static public function create_save_filtered_view_buttongroup( array $view_args, $shortcode ) {
		$btn_group = Ai1ec_Helper_Factory::create_generic_html_tag( 'div' );
		$btn_group->add_class( 'btn-group' );
		$btn = Ai1ec_Helper_Factory::create_bootstrap_button_instance();
		$btn->add_class( 'btn-mini ai1ec-tooltip-trigger' );

		$btn->set_id( 'save_filtered_views' );
		$icon = Ai1ec_Helper_Factory::create_generic_html_tag( 'icon' );
		$icon->add_class( 'icon-pushpin' );
		$btn->add_renderable_children( $icon );

		$ai1ec_router = Ai1ec_Router::instance();
		$cookie_dto = $ai1ec_router->get_cookie_set_dto();
		$cookie_set = $cookie_dto->get_is_a_cookie_set_for_this_page();
		// if there are no filter set, but the cookie is set i need to show the button so that the cookie can be removed
		if( 
			false === Ai1ec_Router::is_at_least_one_filter_set_in_request( $view_args ) && 
			! $cookie_set 
		) {
			$btn->add_class( 'hide' );
		}
		$cookie = false;
		if( true === $cookie_set ) {
			$cookie = 'true' === $shortcode ?
				$cookie_dto->get_shortcode_cookie() :
				$cookie_dto->get_calendar_cookie();
		}
		// If we have a cookie and the filters are in the same state of the cookie, show the remove version
		// Saving the same state again would not make sense
		// if we have a cookie and no filters are set, show the remove button, the user can't save the 
		// standard calendar view
		if ( 
			$cookie_set &&
			( self::check_if_saved_cookie_and_requested_page_match( $view_args, $cookie ) ||
			false === Ai1ec_Router::is_at_least_one_filter_set_in_request( $view_args ) )
		) {
			$btn->add_class( 'active' );
			$text = __( "Remove default filter", AI1EC_PLUGIN_NAME );
		}
		else {
			$text = __( "Save this filter as default", AI1EC_PLUGIN_NAME );
		}
		// Add a span to hold text
		$btn->set_attribute( 'title', $text );
		$btn_group->add_renderable_children( $btn );

		return $btn_group;
	}
}
