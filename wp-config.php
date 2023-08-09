<?php
define( 'WP_CACHE', true );
 // WP-Optimize Cache
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
define( 'DB_NAME', 'u989688937_WtNbV' );
/** MySQL database username */
define( 'DB_USER', 'u989688937_IHLyR' );
/** MySQL database password */
define( 'DB_PASSWORD', 'vjdC7p5XBy' );
/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1:3306' );
/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );
/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );
/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          '_HC+x[uckTq;hDIIod:oegs lgF>d(nI^OsA ly]Ew.o3`v.wpB`/!7f`2!Q[5^=' );
define( 'SECURE_AUTH_KEY',   'ZSa]1b!I|T`&,(o{zM0[V*-yCVoSb5NK^qZM2Mp6I.1()xfI3XPk]>YMH:X5!T}/' );
define( 'LOGGED_IN_KEY',     '7X^2SD,&90bp8pE*{A:Q/gWSMDS z1L}717k}n,$n~W`y4tz$+j?`3-|@ud@-ym,' );
define( 'NONCE_KEY',         'u)N&]4jvqfrltk)eXk?O[O.27Z@m{QL%QV!pa(*.}sEixK|8f%;RA Wr^(3>8a6U' );
define( 'AUTH_SALT',         '5SHN$,5(X_hqa:vg?w;;Dd4>SNsg[|FdUQ/RWTM#w(+G58YZFs}|*91o3[[UV[DW' );
define( 'SECURE_AUTH_SALT',  '2nGl(UA55kB*aBb4x.);b,VW5Ua-*zW{|YqjQA7dZvxT2:SE|$O^48|>$tr&rc]W' );
define( 'LOGGED_IN_SALT',    ']UY+]n)X72P6m=ynAWPQ,/@w=}r`K</I;0#/?9[y&kG-.X0gc0c2Pw?Q E{6H$yi' );
define( 'NONCE_SALT',        '^:k3*`5L,258o=)=n`TEc-5t)0`uhY{J-,24=?OW.Rpb/5cUMNJR+P~8A@3GEM,W' );
define( 'WP_CACHE_KEY_SALT', 'V{DTF}apI.0K?~VR6*=:Y(CYi23PrZzs/0Jzm*G:l,*X_S(EN-PsW&!=Hf-`.K-t' );
/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';
define( 'WP_AUTO_UPDATE_CORE', true );
define( 'FS_METHOD', 'direct' );
/* That's all, stop editing! Happy publishing. */
/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}
/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';