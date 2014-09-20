<?php

/**
 * @author Timely Network Inc
 *
 *
 */

class Ai1ec_Facebook_Proxy extends Facebook_WP_Extend_Ai1ec {

	// an exception caused by authentication
	const OAUTHEXCEPTION         = 'OAuthException';

	public function api( /** polymorphic **/ ) {
		$throwable = NULL;
		try {
			$argv = func_get_args();
			return call_user_func_array( array( 'parent', 'api' ), $argv );
		} catch ( WP_FacebookApiException $exception ) {
			if ( self::OAUTHEXCEPTION === $exception->getType() ) {
				Ai1ec_Importer_Plugin_Helper::get_instance()
				->get_plugin_instance( 'Ai1ecFacebookConnectorPlugin' )
				->do_facebook_logout();
			}
			$throwable = $exception;
		}
		throw $throwable;
	}

}
