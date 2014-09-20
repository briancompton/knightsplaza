<?php

/**
 * Factory class for notifications.
 *
 * @author     Timely Network Inc
 * @since      2013.04.22
 *
 * @package    AllInOneEventCalendar
 * @subpackage AllInOneEventCalendar.Lib.Factory
 */

class Ai1ec_Notification_Factory {
	
	const EMAIL_NOTIFICATION = 'email';

	/**
	 * @param array $recipients
	 * @param string $message
	 * @param string $type
	 * @param string $subject
	 * @return Ai1ec_Notification
	 */
	static public function create_notification_instance( 
		array $recipients, 
		$message, 
		$type = self::EMAIL_NOTIFICATION,
		$subject = ''
	) {
		switch ( $type ) {
			case self::EMAIL_NOTIFICATION : 
				return new Ai1ec_Email_Notification( $recipients, $message, $subject );
		}
	}
}