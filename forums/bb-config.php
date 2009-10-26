<?php
/** 
 * The base configurations of bbPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys and bbPress Language. You can get the MySQL settings from your
 * web host.
 *
 * This file is used by the installer during installation.
 *
 * @package bbPress
 */
$bb->WP_BB = true;
if (file_exists('../wp-blog-header.php'))
	require_once('../wp-blog-header.php');
else
	if (file_exists('../../wp-blog-header.php'))
		require_once('../../wp-blog-header.php');

global $bfa_ata;
$bfa_ata['left_col']="on";
$bfa_ata['right_col']="on";
 $bfa_ata['cols'] = "3";

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for bbPress */
define( 'BBDB_NAME', 'surdeg' );

/** MySQL database username */
define( 'BBDB_USER', 'root' );

/** MySQL database password */
define( 'BBDB_PASSWORD', '' );

/** MySQL hostname */
define( 'BBDB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'BBDB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'BBDB_COLLATE', 'utf8_general_ci' );

/**#@+
 * Authentication Unique Keys.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/bbpress/ WordPress.org secret-key service}
 *
 * @since 1.0
 */
define( 'BB_AUTH_KEY', '}TSrR}[{bm#gq% Z]<M[@+=;pX24hvt1|)J+G&xD4C*hlLeM1ov4p&v|>n/w@AIw' );
define( 'BB_SECURE_AUTH_KEY', '8!Dpd!v-w -&R.yja|?} ,.fAEc*PmxCn&X)^OU>N-Cu{*;2(~Cq@v:_YI>G@AS|' );
define( 'BB_LOGGED_IN_KEY', '|7D9G&%mART!E`XMC8cB5p9e^SZvb|W7^*)YfUGskQTY%d-a|o #fN{pKk[i!f55' );
define( 'BB_NONCE_KEY', 'put your unique phrase here' );
/**#@-*/

/**
 * bbPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$bb_table_prefix = 'bb_';

/**
 * bbPress Localized Language, defaults to English.
 *
 * Change this to localize bbPress. A corresponding MO file for the chosen
 * language must be installed to a directory called "my-languages" in the root
 * directory of bbPress. For example, install de.mo to "my-languages" and set
 * BB_LANG to 'de' to enable German language support.
 */
define( 'BB_LANG', 'sv_SE' );
?>