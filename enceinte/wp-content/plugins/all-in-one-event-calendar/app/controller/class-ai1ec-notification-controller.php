<?php
/**
 * @author Timely Network Inc
 *
 * This class handles notifications for events
 */

class Ai1ec_Notification_Controller {

	/**
	 * @constant string
	 */
	const SAVED_NOTIFICATIONS = 'ai1ec_events_notifications';

	/**
	 * @constant string
	 */
	const CRON_OPTION = 'ai1ec_notification_cron';

	/**
	 * @constant string
	 */
	const CRON_HOOK = 'ai1ec_events_notification';

	/**
	 * @constant int
	 */
	const CRON_VERSION = 1;

	/**
	 * @constant int How much before should we notify for an event ( this is 6 hours );
	 */
	const NOTIFICATION_INTERVAL = 21600;

	/**
	 * _instance class variable
	 *
	 * Class instance
	 *
	 * @var null|object
	 **/
	private static $_instance = NULL;

	/**
	 * get_instance function
	 *
	 * Return singleton instance
	 *
	 * @return Ai1ec_Notification_Controller
	 **/
	static function get_instance() {
		if( self::$_instance === NULL ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	private function __construct() {
		add_action( self::CRON_HOOK , array( $this, 'send_notifications_for_events' ) );
		$saved_version = Ai1ec_Meta::get_option( self::CRON_OPTION );
		if( (int) $saved_version !== self::CRON_VERSION ) {
			wp_clear_scheduled_hook( self::CRON_HOOK );
			// reset flags
			update_option( self::CRON_OPTION , self::CRON_VERSION );
			// set the new cron
			wp_schedule_event(
				Ai1ec_Time_Utility::current_time(),
				'hourly',
				self::CRON_HOOK
			);
		}
	}

	/**
	 * Cron callback processing (retrieving and sending) pending messages
	 *
	 * @return int Number of messages posted to Twitter
	 */
	public function send_twitter_messages() {
		$pending    = $this->_get_pending_twitter_events();
		$successful = 0;
		foreach ( $pending as $event ) {
			try {
				if ( $this->_send_twitter_message( $event ) ) {
					++$successful;
				}
			} catch ( Exception $exception ) {
				// exception is ignored
			}
		}
		return $successful;
	}

	/**
	 * This is the CRON function which sends emails
	 *
	 */
	public function send_notifications_for_events() {
		global $ai1ec_settings;
		if ( ! $ai1ec_settings->enable_user_event_notifications ) {
			return false;
		}
		$notifications = Ai1ec_Meta::get_option(
			self::SAVED_NOTIFICATIONS,
			array()
		);
		foreach ( $notifications as $event_id => $instances ) {
			foreach ( $instances as $instance_id => $notifications_to_send ) {
				try {
					$event   = new Ai1ec_Event( $event_id, $instance_id );
				} catch ( Ai1ec_Event_Not_Found $excpt ) {
					unset( $notifications[$event_id] );
					continue 2;
				}
				$subject = $ai1ec_settings->user_upcoming_event_mail_subject;
				$message = $ai1ec_settings->user_upcoming_event_mail_body;
				if (
					true === $this->
						check_if_notification_should_be_sent_for_event(
							$event
						)
				) {
					$event_url    = get_permalink( $event->post_id );
					if ( 0 !== (int)$instance_id ) {
						$event_url .= $instance_id;
					}
					$translations = array(
						'[event_title]' => $event->post->post_title,
						'[event_start]' => Ai1ec_Time_Utility::date_i18n(
							'D, d M Y H:i',
							Ai1ec_Time_Utility::gmt_to_local( $event->start )
						),
						'[event_url]'   => $event_url,
						'[site_title]'  => get_bloginfo( 'name' ),
						'[site_url]'    => site_url(),
					);
					foreach (
						$notifications_to_send as $recipient => $details
					) {
						$notification = Ai1ec_Notification_Factory::create_notification_instance(
							array( $recipient ),
							$message,
							Ai1ec_Notification_Factory::EMAIL_NOTIFICATION,
							$subject
						);
						$notification->set_translations( $translations );
						$notification->send();
						// unset the notification
						unset(
							$notifications[$event_id][$instance_id][$recipient]
						);
					}
				}
				// after sending the mail, unset the instance id if all
				// mail have been sent
				if ( empty( $notifications[$event_id][$instance_id] ) ) {
					unset( $notifications[$event_id][$instance_id] );
				}
			}
			if ( empty( $notifications[$event_id] ) ) {
				unset( $notifications[$event_id] );
			}
		}
		return update_option( self::SAVED_NOTIFICATIONS, $notifications );
	}

	/**
	 * This function tells if less than the notification interval is missing from the event start time
	 *
	 * @param Ai1ec_Event $event
	 * @return boolean
	 */
	public function check_if_notification_should_be_sent_for_event( Ai1ec_Event $event ) {
		$how_much_before_event_start = $event->start - Ai1ec_Time_Utility::current_time( true );
		if( $how_much_before_event_start < self::NOTIFICATION_INTERVAL ) {
			return true;
		}
		return false;
	}

	/**
	 * The ajax function which subscribes the user to an event
	 *
	 */
	public function subscribe_to_event() {
		$notifications = Ai1ec_Meta::get_option(
			self::SAVED_NOTIFICATIONS,
			array()
		);
		$event_id = (int)$_POST['event'];
		$event_instance = (int)$_POST['event_instance'];
		$mail = filter_input( INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL );
		$return = array();
		if( ! isset( $notifications[$event_id] ) ) {
			$notifications[$event_id] = array();
		}
		if( ! isset( $notifications[$event_id][$event_instance] ) ) {
			$notifications[$event_id][$event_instance] = array();
		}
		if( isset( $notifications[$event_id][$event_instance][$mail] ) ) {
			$return['message'] = __( 'You already subscribed to this event', AI1EC_PLUGIN_NAME );
			$return['type'] = 'error';
		} else {
			$notifications[$event_id][$event_instance][$mail] = array(
				'type' => Ai1ec_Notification_Factory::EMAIL_NOTIFICATION,
			);
			$return['message'] = __(
        'You will receive a notification by e-mail 6 hours before the event starts.',
        AI1EC_PLUGIN_NAME
      );
			$return['type'] = 'success';
			update_option( self::SAVED_NOTIFICATIONS, $notifications );
		}
		echo json_encode( $return );
		exit;
	}

	/**
	 * Retrieves a list of events matching Twitter notification time interval
	 *
	 * @return array List of Ai1ec_Event objects
	 */
	protected function _get_pending_twitter_events() {
		global $ai1ec_settings, $ai1ec_calendar_helper, $ai1ec_events_helper;
		$interval = new Ai1ec_Frequency_Utility();
		$interval->parse( $ai1ec_settings->twitter_notice_interval );
		$interval = (int)$interval->to_seconds();
		$events   = $ai1ec_calendar_helper->get_events_between(
			$ai1ec_events_helper->gmt_to_local( time() + $interval - 600 ),
			$ai1ec_events_helper->gmt_to_local( time() + $interval + 6600 ),
			array()
		);
		return $events;
	}

	/**
	 * Checks and sends message to Twitter
	 *
	 * Upon successfully sending message - updates meta to reflect status change
	 *
	 * @return bool Success
	 *
	 * @throws Ai1ec_Oauth_Exception In case of some error
	 */
	protected function _send_twitter_message( $event ) {
		$format    = '[title], [date] @ [venue], [link] [hashtags]';
		$oauth     = Ai1ec_Oauth_Controller::get_instance();
		$status    = Ai1ec_Meta::instance( 'Post' )->get(
			$event->post_id,
			'_ai1ec_post_twitter',
			array( 'not_requested' )
		);
		if ( is_array( $status ) ) {
			$status = (string)current( $status );
		}
		if ( 'pending' !== $status ) {
			return false;
		}
		$terms  = array_merge(
			wp_get_post_terms(
				$event->post_id,
				'events_categories'
			),
			wp_get_post_terms(
				$event->post_id,
				'events_tags'
			)
		);
		$hashtags = array();
		foreach ( $terms as $term ) {
			$hashtags[] = '#' . implode( '_', explode( ' ', $term->name ) );
		}
		$hashtags = implode( ' ', array_unique( $hashtags ) );
		$link     = get_permalink( $event->post ) . $event->instance_id;
		$message  = str_replace(
			array(
				'[title]',
				'[date]',
				'@ [venue]',
				'[link]',
				'[hashtags]',
			),
			array(
				$event->post->post_title,
				$event->get_short_start_date(),
				$event->venue,
				$link,
				$hashtags,
			),
			$format
		);
		$message = trim(
			preg_replace(
				'/ ,/',
				',',
				preg_replace( '/\s+/', ' ', $message )
			)
		);
		$length = strlen( $message );
		$link_length = strlen( $link );
		if ( $link_length > 20 ) {
			$length += 20 - $link_length;
		}
		if ( $length > 140 ) {
			$message = substr(
				$message,
				0,
				strrpos(
					$message,
					' ',
					140 - $length
				)
			);
		}
		$status = $oauth->get_provider( 'twitter' )
			->send_message(
				$oauth->get_token( $event->post->post_author, 'twitter' ),
				$message
			);
		if ( ! $status ) {
			return false;
		}
		return update_post_meta(
			$event->post_id,
			'_ai1ec_post_twitter',
			array( 'status' => 'sent', 'twitter_status_id' => $status )
		);
	}

}
