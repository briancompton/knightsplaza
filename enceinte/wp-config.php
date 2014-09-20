<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wrd_7kioabgkdb');

/** MySQL database username */
define('DB_USER', 'wrdEl9T3lCQ');

/** MySQL database password */
define('DB_PASSWORD', 'ulFw4iOBon');

/** MySQL hostname */
define('DB_HOST', 'ucfbusserv.ipowermysql.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'JujcZa4wMDrDs7gMHNlRLAWfjT7tYIL3xjDylBb69oJQwmE7Dyjpza9pBxxRvjyK');
define('SECURE_AUTH_KEY',  '3Dm5UU5QfLULUfhH0nhRK8RDJb0opZ1QR6QLsjhkONf6ULOzxqeTAGuzQYHTFvv4');
define('LOGGED_IN_KEY',    'iQlqOGvvCM9ZWvhVmYkxVIrzttKsNttGqCdHeJqB46DmdkXCWq5tmH6GThQ5NuR8');
define('NONCE_KEY',        '9hHMyq8dPwcZfjYRbfG4hhT9mljomUWu8DjtCOVGaoKpT5aAuCE2DQuWjTA3NUCF');
define('AUTH_SALT',        'pMkGaTYs73Vmk2BY2zmnJvQ019xd547iDq5TLziyfsiZS3KZ6UgIAh44hfBpD1Mf');
define('SECURE_AUTH_SALT', 'x6yJvTLZwpHUCGM6t1Bb0ZRe4W5j9jqFpHeitt4sQYfQvIiCgb0rnB39FmIc5l3h');
define('LOGGED_IN_SALT',   'nAzOtnrBj6efMZDndH46Fz7mALG9Qm20FumTdOtUYtKifeUVt3gJqn1iT4rdaP0j');
define('NONCE_SALT',       'ADK90Y6Cg0b73x8vb4qyNBNW8MIewDXdEZALDWoFNQXhY5vlGjaPUcQhCTtZy8Jv');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

/* Disable the editor */
define( 'DISALLOW_FILE_EDIT', true );

