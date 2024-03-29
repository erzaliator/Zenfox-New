<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'wordpress');

/** MySQL database password */
define('DB_PASSWORD', 'e6e3be2d833cdf5d9d4c7bc2f85cd098');

/** MySQL hostname */
define('DB_HOST', 'zenfox-master');

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
define('AUTH_KEY',         'jS`D|oe&pp|-``r/Yoc|}-BmIuQL&@8!zS@J9+#A-v!rGdp~}c#w265>%D=h`.U+');
define('SECURE_AUTH_KEY',  'U(OO>}~,y {tjOjxQ.=va@7ht=f-;/h0Vz5?#),oO25]yo!dmF}_k.*Je4PjM1J}');
define('LOGGED_IN_KEY',    'uv9y@FJCN]+^VgP:>cZlY||+[dVy/M0pj=h[Y^p+OXGx WCf@Z8v$+cG&?(bIQ#5');
define('NONCE_KEY',        '8P&S9Jb`C]orRGf%;4Q.NY#eq{Z@-:DJWbW@9<zj8+3s{b88 ?-8p,ZFt o[LbNr');
define('AUTH_SALT',        'MU|JlR,alYY/sJb.#8SR-.lqL3%_?VqLp/6gtt;Xhz _[U-+3FXK4%3:D+:r=I|S');
define('SECURE_AUTH_SALT', '#l=3`` 5K@4SSYm%mcAY:-riOoi)jBoTMIF3or9oJU~44js}=BxQ<~$3u$BY|,FJ');
define('LOGGED_IN_SALT',   '}Y7$(:qc^4N&/0Q3Q+Qv8iJ|w0IqvjJ-W[?hI6$i]vK^,P[@6l7m=h[+pPnXgV%.');
define('NONCE_SALT',       '6{5rHB9Mt9zU~7xs?T~Eu{S|cYk(8S&sy7=MCX*{ss__OUJGX>(|7!-O{AT_yP5`');

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
