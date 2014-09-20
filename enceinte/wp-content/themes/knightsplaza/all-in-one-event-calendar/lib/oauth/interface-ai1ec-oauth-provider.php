<?php

/**
 * Interface describing OAuth Provider behaviour
 *
 * @author     Timely Network Inc
 * @since      2013.05.29
 *
 * @package    AllInOneEventCalendar
 * @subpackage AllInOneEventCalendar.Lib.OAuth
 */
interface Ai1ec_Oauth_Provider
{

	/**
	 * Return public name for current provider
	 *
	 * Used to output name of provider on screen.
	 *
	 * @return string Name of provider
	 */
	public function get_name();

	/**
	 * Method to prepare (validate) data before querying provider.
	 *
	 * @return bool Success - whereas data was valid
	 */
	public function prepare();

	/**
	 * Redirect user to provider for authentification
	 *
	 * Shall return string (URI) to redirect to (via 'Location' header),
	 * or bool value `false` to skip redirection and call `self::validate()`
	 * directly.
	 *
	 * @return string|bool URI or bool(false)
	 */
	public function auth_redirect();

	/**
	 * Validate user response
	 *
	 * Usually pass `$_GET` to this method. Validate user returning from
	 * OAuth provider.
	 *
	 * @param array $response User carried response data
	 *
	 * @return bool Success - `true` if data is valid
	 */
	public function validate( array $response );

	/**
	 * Return long-term authentication token
	 *
	 * After returning from provider, if the token is available.
	 * Token may be of any *serializable* (mandatory) format that
	 * would be later accepted by the interface.
	 *
	 * @return mixed Only value to watch out for is NULL meaning failure
	 */
	public function get_token();

	/**
	 * Retrieve user details given authentication token.
	 *
	 * @param mixed $token Access token as returned by {@see self::get_token()}
	 *
	 * @return array User details formatted, to some extent
	 */
	public function get_details( $token );

	/**
	 * Get referenced (authorized via token) user ID in provider database.
	 *
	 * @param mixed Access token as returned by {@see self::get_token()}
	 *
	 * @return string Remote user ID
	 */
	public function get_ref( $token );

	/**
	 * Get expiration date of token
	 *
	 * @param mixed Access token as returned by {@see self::get_token()}
	 *
	 * @return string Expiration time identifier
	 */
	public function get_expiration( $token );

}