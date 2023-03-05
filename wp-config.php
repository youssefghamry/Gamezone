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
define( 'DB_NAME', 'Gamezone' );

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
define( 'AUTH_KEY',         'e:5lj$T}W,.AHO^nG/v_X/!<E{7AgO8$.g&PvoB$AXt7!}SfWgB7V[x?`4Gjga).' );
define( 'SECURE_AUTH_KEY',  'Fv)UT_c-V8VxOO?*&n4OS0w@MQI8cPG=`Ru7;cn !FJ95y/I7h.YUh0GPpD>}RU(' );
define( 'LOGGED_IN_KEY',    '/&#G4O;rUZ-_Wut*cd)}dhN-kvyVyS[gi^a-,}`64v/wmo;8n`T2XkH;Db6(Ag@y' );
define( 'NONCE_KEY',        '40opH#t)cI,CIUE`~FxM^p37dQYd8Wv[Y$O6?Fer-&MH_?w*,.IvXwO(W/@,4M%P' );
define( 'AUTH_SALT',        '[FFq.r9h0fjKEE8Ns(QNlG-7K1dK!I+)Rqgq^{*9gf$R/va#zVT0Bso8LFh!kE3+' );
define( 'SECURE_AUTH_SALT', 'tLcX{kT._%0g<rkXK[I@?hys,j|Yl/RX8`>L]fYIOz}<4,|^F>4Qy,}Q)fH^!-V}' );
define( 'LOGGED_IN_SALT',   '2[>;txk0+S3hdW$_:&3R)%;5HpO}-7`g%tZU/|bg#x=_*QrOO,KxLv@;n&O28|CJ' );
define( 'NONCE_SALT',       'N_c(HMR_{*1+|l}_BPyDK,ni9$^2hX&g=Wx)IB?S+o9D[E+I +s[Ze<yZ>{_$2UQ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_Gamezone';

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
