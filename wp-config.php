<?php
/** Enable W3 Total Cache */
define('WP_CACHE', true); // Added by W3 Total Cache

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
define( 'DB_NAME', 'booliof' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

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
define( 'AUTH_KEY',         'I>u%ez;qZd<E]QC&3H$N;/O_sRULpAAAuAN`f)sPW?UBvx&}S/I~F8MzY+u7|61z' );
define( 'SECURE_AUTH_KEY',  'n*Kk,!f[}16A{s^a}<^UP9ybm?NW0#6s]^E0iNmC3(U@vlSs3=H8{K&$FI[`xw`0' );
define( 'LOGGED_IN_KEY',    '=<6r4L..U-m ]zGjc2l:t^=,rXKAkz ^%k?ITxp?}[#3WQ_X:<ah,:oYb%#TodJm' );
define( 'NONCE_KEY',        'Brln(z_ y::e>Qu9QtD:&lND&Ecjw_sFY>UwpLZ_t/C$C5wh{zPx^(T/eSkzJP>T' );
define( 'AUTH_SALT',        'p0(i1n-m/!eXk!4S~9/lM:=6*;3aBX2RE I9Qon)2V;Q`7pSQ8_ikzW6gHy__e:B' );
define( 'SECURE_AUTH_SALT', '2tt*]bYZbS>HIDA!F,ypCr,>d<Wjm(C_mS7TASmT}ScAJ)KD7m[]ilIOnAa}E_mj' );
define( 'LOGGED_IN_SALT',   'Yp)ujX.^6,SQ,e,#]XPA;o({(Y-AO&+8#F9JxOn+<CHU}1|aeyCO%~S<rhFqylF2' );
define( 'NONCE_SALT',       'q3*`%r;EE~hMg]l]X<YMg#/DDl86^~o1/NHWS4&iD-I9J{pzhi)bygz()o[]qCyi' );

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
