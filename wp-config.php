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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'GFAAdmin' );

/** Database password */
define( 'DB_PASSWORD', '56xm19TjMv8mTl' );

/** Database hostname */
define( 'DB_HOST', 'gfa-db-server.mysql.database.azure.com' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',         'luu37mdlisqepmntncrsyzbdasfi9l9voji8id4j0hagp69rxp8m5rpf2kfr3zju' );
define( 'SECURE_AUTH_KEY',  'b9yiiydwkqmwas9mrnnzmiytheqdwqzktlfwmpmlqzcouwl5pjsqu9fgq1m9546l' );
define( 'LOGGED_IN_KEY',    'xkx2toqsczvhweihkris2nxwhfs9ctfxqcfx5wv3bml3whxavdzrp4qh4q1iatt7' );
define( 'NONCE_KEY',        'a5jfwyvcx83mc0kpiqaklttznjc6viozysh9tiwty3wscl1sc8bt3cdsdl70jtzq' );
define( 'AUTH_SALT',        'u58ybwyleexdvgsrr0yuxkd7n88sh7v1ilwpkzoraepu7vftw3ixnbhiifbxsbte' );
define( 'SECURE_AUTH_SALT', '3tmhgk4dnm3jmldr5c7mq0ktqb4f8sdl2ccetasdtxexplkxg1ppzphfsxdvzvrf' );
define( 'LOGGED_IN_SALT',   'tpu8fbuaj8sfxkpnu6uiukmxk5lfpcxr1v0zcbgw4m1kgldy0ouoxe2abpayhnkg' );
define( 'NONCE_SALT',       '4zr4turmz0frc1qer9qicbiugmvbhzegfc2iqfr4utmeylofxx3zr7ltg4agpjmq' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wprv_';

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
