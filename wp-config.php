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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'smartfit' );

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
define( 'AUTH_KEY',         'w^eeU=_l*h=`o1-U1C`!2J8z>|B8]?~zg-G(z1:ysu/ePA5sdZxsh}hfho(uA~b!' );
define( 'SECURE_AUTH_KEY',  'Z/FvNyoqJvD`zlKW7=XrN9w@%NW7rcIr-ianpJ7,k}{g/)oL fx$$qpMfQHUl[M3' );
define( 'LOGGED_IN_KEY',    'LzKJaE]Y}0sfsA%(<77([;A|<=WI7E 4APyTAAXzPX .<.)B[&r02di*HYfoRM#f' );
define( 'NONCE_KEY',        '}j;$uo;^@7y`p]g9CZ#e+[b*yXJ7?:!cRlZ?Fvtq!3aDDHe?J:*;RU#2U}!=a&j#' );
define( 'AUTH_SALT',        'wTpiVFQ{d ()Tgcx]>auHaVw]2Zz{Y{>ZOgM*nKKEl^$aYxIoi] as5BYE9,=lkt' );
define( 'SECURE_AUTH_SALT', '[:0xyKY]@kK.nu_%iv(o53O8txeBP^Am/=2c]&&OJV|Fggt3cVNJaB~7Qc@`R>1K' );
define( 'LOGGED_IN_SALT',   'Y]uHx>76lTElZ1+?Da-t-z~V,LU+nd3T7V0k=Yc-7kmg>lx=eY#t+duh~z7 gzk_' );
define( 'NONCE_SALT',       'Fy]B _7W;kNrW=u#8{f>JjN5YAR0{Fdflc$fv>iul*R=!y:?&X~m*dHJQW#_H=2/' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
