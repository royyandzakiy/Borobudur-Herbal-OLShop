<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'test2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'ym.]]UnRJW]:Ard6Y(g9`pfgzG6-rX<ao$]c|A6`M#0c@l[IvvC05,p[Hog};20V');
define('SECURE_AUTH_KEY',  '(}xph|x[gi#W3OjlSH(v9[gDy/XI>7[I9N@PX oeEMt/uU9rWwYl*jItyodi=Gmq');
define('LOGGED_IN_KEY',    '_{?rC#l`QJ<mi-a/sKQ+*)]T({_P?HbU-4z4a39_0<L:V_J3oWSt=Nk.E }{382F');
define('NONCE_KEY',        'X1(M?o&(dD35M5OH}mjFb/Y2H{K~:)U%3qO7Vk?mN<=w!4O2pFooqhGK(QL,<{zM');
define('AUTH_SALT',        '7QnSzqLOu;I#Ch_DChFBS[=E-r7mU6mC~N-V!B4NZ{:Gf^<HW/IC#9kB>>GKJU%b');
define('SECURE_AUTH_SALT', 'r=Cqa.hnX[H@pW>|=p,[TC3#ofg@A(==@%98RmLhVB/jUpf(+2Lr2!-F.xe>A&$V');
define('LOGGED_IN_SALT',   '<*I7~^&Y=`9bu:8`}|B3;zPPOBFwYe/mD7lSOvFY3<tD<* ,#Ng8Q(i+Y<p_*av!');
define('NONCE_SALT',       'V402[[U%s=i&O:Ce-/{+t27G1{L}zggd}f)h-7%d[-BU.%N(F<3QZ}ySHr4{o:ET');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
