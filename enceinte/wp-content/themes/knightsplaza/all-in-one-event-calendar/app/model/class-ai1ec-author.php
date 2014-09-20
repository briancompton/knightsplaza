<?php

/**
 * Author object representation
 *
 * @author     Timely Network Inc
 * @since      2.0
 *
 * @package    AllInOneEventCalendar
 * @subpackage AllInOneEventCalendar.App.Model
 */
class Ai1ec_Author
{

	/**
	 * @var Ai1ec_Author Singletonian instance of self
	 */
	static protected $_instance = NULL;

	/**
	 * @var wpdb Instance of DB provider
	 */
	protected $_db              = NULL;

	/**
	 * Get singletonian instance of this class
	 *
	 * @return Ai1ec_Author Singletonian instance of this class
	 */
	static public function get_instance() {
		if ( ! ( self::$_instance instanceof self ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	 * List of authors having authored at least one event
	 *
	 * Returned array contains following keys: user_id, display_name and
	 * event_count, respectively referencing author ID, to use as filter
	 * argument, his name, and number of events he had authored.
	 *
	 * @param bool $flush Set to true, to ignore cache [optional=false]
	 *
	 * @return array List of authors
	 */
	public function get_all( $flush = false ) {
		global $ai1ec_settings;
		if ( ! $ai1ec_settings->use_authors_filter ) {
			return array();
		}
		$persistance = Ai1ec_Strategies_Factory::create_persistence_context(
			__METHOD__
		);
		$list        = NULL;
		if ( false === $flush ) {
			try {
				$list = $persistance->get_data_from_persistence();
			} catch ( Ai1ec_Cache_Not_Set_Exception $exception ) {
				$list = NULL;
			}
		}
		if ( NULL === $list ) {
			$list = $this->_fetch_all();
			try {
				$persistance->write_data_to_persistence( $list );
			} catch ( Ai1ec_Cache_Not_Set_Exception $wrt_exception ) {
				// ignore write failures
			}
		}
		return $list;
	}

	/**
	 * Gets all the authors for the select2 widget
	 * 
	 * @return array 
	 */
	public function get_all_for_select2() {
		$authors_for_select2 = array();
		$authors             = $this->get_all();
		if ( count( $authors ) > 1 ) {
			foreach ( $authors as $author ) {
				$auth                  = new stdClass();
				$auth->term_id         = $author->user_id;
				$auth->name            = $author->display_name;
				$authors_for_select2[] = $auth;
			}
		}
		return $authors_for_select2;
	}
	/**
	 * Return list of authors who have authored events
	 *
	 * For inner details {@see self::get_all()}.
	 *
	 * @return array List of authors
	 */
	protected function _fetch_all() {
		$sql_query = '
			SELECT
				user.ID           AS user_id,
				user.display_name AS display_name,
				COUNT( post.ID )  AS event_count
			FROM
				' . $this->_db->users . ' AS user
				INNER JOIN ' . $this->_db->posts . ' AS post
					ON (
						post.post_author = user.ID AND
						post.post_type   = \'' . AI1EC_POST_TYPE . '\' AND
						post.post_status = \'publish\'
					)
			GROUP BY
				user.display_name ASC,
				user.ID ASC
		';
		$result = $this->_db->get_results( $sql_query );
		return $result;
	}

	/**
	 * Constructor
	 *
	 * Initialize local variables
	 *
	 * @return void Constructor does not return
	 */
	protected function __construct() {
		global $wpdb;
		$this->_db = $wpdb;
	}

}
