<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'zoa_local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'leUzAQBT]aGe4Q{Ss%R8Z[;oxl]C#Z(5$Ryt_qP tmf;2=StGs=/xFh*.>Oq Rw7' );
define( 'SECURE_AUTH_KEY',  '(~]iHI:entM%nKMrE> 9$E,jVh{;:#$8upA(ImwpAH1*[g.Q{)9RgNh8*,Nh8<_;' );
define( 'LOGGED_IN_KEY',    '/ntw_2VY$#Yz;-LwH:=1N7x@$Qh]fRn`B_lON~;j!=Qt6W$o yd=)sIB|:N9Be:7' );
define( 'NONCE_KEY',        '3f8G0/o(ka#SbeaOk1w+9C)0Jp >,seN}]!$PR,i`1|&fSIOJ|9<s<CsMy-S-k>J' );
define( 'AUTH_SALT',        '^C&/ -o|9mai}v].pc8@C(t$-FZo@Mh-ei_#F^^z^>MB7]w5oZmwmcq?5y zYQ%T' );
define( 'SECURE_AUTH_SALT', 'r+kZQ#54DZ*1[.{ GOxYy!#3?0EHKVtCIp:=%Q(wR+|p11y9&&23ahi}$;+h6mhW' );
define( 'LOGGED_IN_SALT',   'g$}7gA5:bZ07w3N8hEV=$`-eUp3/.*5l i#T1XsNm`CsW9+RAQZq!fC-(NZrFBz,' );
define( 'NONCE_SALT',       '}nkVqb=>dud]`Jhjd|<tB-~?Z9oT>^#*@C?8k43p+M#R1i%o-d{<f|}mGW<1&[|F' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
