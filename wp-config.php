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

if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'vetenskapsfestivalen');
//define('DB_NAME', 'vetensk1_wp');

/** MySQL database username */
define('DB_USER', 'root');
//define('DB_USER', 'vetensk1_root');

/** MySQL database password */
define('DB_PASSWORD', 'root');
//define('DB_PASSWORD', 'Cool163@v');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '-po7%?wrb.ZhI_U++ a#&1@lF(aI6_W/)V]?XB!mGlzB;03+]8-eQ]/)KT=.T<-E');
define('SECURE_AUTH_KEY',  'k1t0|b2-_#Vl }^fOigke$C#95|?TpugrAqTDj7r{-l#x#l[^DG>-0vX_iZ8&oVB');
define('LOGGED_IN_KEY',    'T,#=_d-m!jo@c)Oz{ndt#<(LZ,~wL7-|pM(F<>SYfH/P<B/:`9n_oXG~r?78JM{-');
define('NONCE_KEY',        'SeaH/CF6I=?7wfU[jG(H;t>RQ1ZINuIC7T4P&Qj~zbk}pVkD8Q{?~:+RnFVaJ+S|');
define('AUTH_SALT',        'q!0?HK^c}Q%D]sbn~%VJ+^dJ*HDGCXUwntw!/3Y{0f,$ja|e<7p-d-o1%tt/ @2X');
define('SECURE_AUTH_SALT', 'S.>#fqeICLNCk3d_gY:-&Z5Zdlv#,5{+ofSGM*++}[>w``fnJ<Whm-=*=HuOZNWS');
define('LOGGED_IN_SALT',   'VTzlpwMQUsH-4Y!:40|wvLm(.Zq 6Nmh%D)?jXp9Se(pI0UG8!47m7.D6hkQ P|s');
define('NONCE_SALT',       '5Iba/2Qvj1[uq/hQi>g0[OnZADZ?-R-Oy1ogp@!<SDMI77_Mk5b-P_WX{cC#S(Q`');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */

// Turns WordPress debugging on
define('WP_DEBUG', true);

// Tells WordPress to log everything to the /wp-content/debug.log file
define('WP_DEBUG_LOG', true);

// Doesn't force the PHP 'display_errors' variable to be on
define('WP_DEBUG_DISPLAY', true);

// Hides errors from being displayed on-screen
//@ini_set('display_errors', 0);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */


/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
