<?php
/*
Plugin Name: bbPress Integration
Plugin URI: http://wordpress.org/extend/plugins/bbpress-integration/
Description: Provides single sign on login with a bbPress installation.
Version: 1.0
Author: <a href="http://blogwaffe.com/">Michael Adams</a> and <a href="http://unlettered.org">Sam Bauers</a>
Author URI:
*/



if ( defined('XMLRPC_REQUEST') && XMLRPC_REQUEST ) {
	return;
}

if ( defined('DOING_AJAX') && DOING_AJAX ) {
	return;
}



function bbpress_integration_get_common_parts( $string1 = false, $string2 = false, $delimiter = '', $reverse = false )
{
	if ( !$string1 || !$string2 ) {
		return false;
	}

	if ( $string1 === $string2 ) {
		return $string1;
	}

	$string1_parts = explode( $delimiter, (string) $string1 );
	$string2_parts = explode( $delimiter, (string) $string2 );

	if ( $reverse ) {
		$string1_parts = array_reverse( $string1_parts );
		$string2_parts = array_reverse( $string2_parts );
		ksort( $string1_parts );
		ksort( $string2_parts );
	}

	$common_parts = array();
	foreach ( $string1_parts as $index => $part ) {
		if ( $string2_parts[$index] == $part ) {
			$common_parts[] = $part;
		} else {
			break;
		}
	}

	if ( !count( $common_parts ) ) {
		return false;
	}

	if ( $reverse ) {
		$common_parts = array_reverse( $common_parts );
	}

	return join( $delimiter, $common_parts );
}

function bbpress_integration_get_common_domains( $domain1 = false, $domain2 = false )
{
	if ( !$domain1 || !$domain2 ) {
		return false;
	}

	$domain1 = strtolower( preg_replace( '@^https?://([^/]+).*$@i', '$1', $domain1 ) );
	$domain2 = strtolower( preg_replace( '@^https?://([^/]+).*$@i', '$1', $domain2 ) );

	return bbpress_integration_get_common_parts( $domain1, $domain2, '.', true );
}

function bbpress_integration_get_common_paths( $path1 = false, $path2 = false )
{
	if ( !$path1 || !$path2 ) {
		return false;
	}

	$path1 = preg_replace( '@^https?://[^/]+(.*)$@i', '$1', $path1 );
	$path2 = preg_replace( '@^https?://[^/]+(.*)$@i', '$1', $path2 );

	if ( $path1 === $path2 ) {
		return $path1;
	}

	$path1 = trim( $path1, '/' );
	$path2 = trim( $path2, '/' );

	$common_path = bbpress_integration_get_common_parts( $path1, $path2, '/' );

	if ( $common_path ) {
		return '/' . $common_path . '/';
	}

	return '/';
}

function bbpress_integration_match_domains( $domain1 = false, $domain2 = false )
{
	if ( !$domain1 || !$domain2 ) {
		return false;
	}

	$domain1 = strtolower( preg_replace( '@^https?://([^/]+).*$@i', '$1', $domain1 ) );
	$domain2 = strtolower( preg_replace( '@^https?://([^/]+).*$@i', '$1', $domain2 ) );

	if ( (string) $domain1 === (string) $domain2 ) {
		return true;
	}

	return false;
}

function bbpress_integration_get_options()
{
	$defaults = array(
		'uri' => '',
		'my_plugins_uri' => '',
		'is_wpmu' => 0
	);
	if ( function_exists( 'get_site_option' ) ) {
		$options = get_site_option( 'bbpress_integration' );
	} else {
		$options = get_option( 'bbpress_integration' );
	}
	$options = wp_parse_args( $options, $defaults );
	return $options;
}

function bbpress_integration_get_cookie_domain_and_path()
{
	$options = bbpress_integration_get_options();
	if ( empty( $options['uri'] ) ) {
		return false;
	}

	if ( $options['is_wpmu'] && function_exists( 'get_blog_option' ) ) {
		global $current_blog;
		$siteurl = get_blog_option( $current_blog->site_id, 'siteurl' );
	} else {
		$siteurl = get_option( 'siteurl' );
	}

	$commondomain = bbpress_integration_get_common_domains( $options['uri'], $siteurl );
	$cookiedomain = '';
	$cookiepath = '/';
	if ( bbpress_integration_match_domains( $options['uri'], $siteurl ) ) {
		if ( !$options['is_wpmu'] ) {
			$cookiedomain = '';
		} else {
			$cookiedomain = '.' . $commondomain;
		}
		$cookiepath = bbpress_integration_get_common_paths( $options['uri'], $siteurl );
	} elseif ($commondomain && strpos($commondomain, '.') !== false) {
		$cookiedomain = '.' . $commondomain;
		$cookiepath = bbpress_integration_get_common_paths( $options['uri'], $siteurl );
		$sitecookiepath = '';
	}

	if ( $options['is_wpmu'] ) {
		$cookiehash = md5( $siteurl );
		$sitecookiepath = $cookiepath;
		$admincookiepath = rtrim( $cookiepath, " \t\n\r\0\x0B/" );
	} else {
		$cookiehash = '';
		$sitecookiepath = '';
	}

	return compact( 'cookiedomain', 'cookiepath', 'sitecookiepath', 'admincookiepath', 'cookiehash' );
}



function bbpress_integration_set_bb_cookies( $uri, $expire = false, $expiration = '', $user_id = '' )
{
	if ( !$uri_parsed = @parse_url( $uri ) ) {
		return false;
	}

	$secure = false;
	if ( strtolower( $uri_parsed['scheme'] ) === 'https' ) {
		$secure = true;
	}

	if ( $secure ) {
		$name = SECURE_AUTH_COOKIE;
		$scheme = 'secure_auth';
	} else {
		$name = AUTH_COOKIE;
		$scheme = 'auth';
	}

	if ( $expiration && $scheme ) {
		$contents = wp_generate_auth_cookie( $user_id, $expiration, $scheme );
	} else {
		$contents = ' ';
		$expire = time() - 31536000;
	}

	if ( !$cookiedomain_and_path = bbpress_integration_get_cookie_domain_and_path() ) {
		return false;
	}
	extract( $cookiedomain_and_path );

	$domain = $cookiedomain;
	$path = $uri_parsed['path'];

	// Set httponly if the php version is >= 5.2.0
	if ( version_compare( phpversion(), '5.2.0', 'ge' ) ) {
		setcookie( $name, $contents, $expire, $path, $domain, $secure, true );
	} else {
		if ( !empty( $domain ) )
			$domain .= '; HttpOnly';
		setcookie( $name, $contents, $expire, $path, $domain, $secure );
	}
}

function bbpress_integration_set_bb_auth_cookies( $auth_cookie, $expire, $expiration, $user_id, $scheme )
{
	$options = bbpress_integration_get_options();

	if ( !empty( $options['uri'] ) ) {
		$uri = rtrim( trim( $options['uri'] ), " \t\n\r\0\x0B/" );
	}

	if ( !empty( $uri ) ) {
		bbpress_integration_set_bb_cookies( $uri . '/bb-admin', $expire, $expiration, $user_id );
		bbpress_integration_set_bb_cookies( $uri . '/bb-plugins', $expire, $expiration, $user_id );
	}

	if ( !empty( $options['my_plugins_uri'] ) ) {
		$my_plugins_uri = rtrim( trim( $options['my_plugins_uri'] ), " \t\n\r\0\x0B/" );
	}

	if ( empty( $my_plugins_uri ) ) {
		bbpress_integration_set_bb_cookies( $uri . '/my-plugins', $expire, $expiration, $user_id );
	} else {
		bbpress_integration_set_bb_cookies( $my_plugins_uri, $expire, $expiration, $user_id );
	}

	return;
}

function bbpress_integration_clear_bb_auth_cookies()
{
	$options = bbpress_integration_get_options();

	if ( !empty( $options['uri'] ) ) {
		$uri = rtrim( trim( $options['uri'] ), " \t\n\r\0\x0B/" );
	}

	if ( !empty( $uri ) ) {
		bbpress_integration_set_bb_cookies( $uri . '/bb-admin' );
		bbpress_integration_set_bb_cookies( $uri . '/bb-plugins' );
	}

	if ( !empty( $options['my_plugins_uri'] ) ) {
		$my_plugins_uri = rtrim( trim( $options['my_plugins_uri'] ), " \t\n\r\0\x0B/" );
	}

	if ( empty( $my_plugins_uri ) ) {
		bbpress_integration_set_bb_cookies( $uri . '/my-plugins' );
	} else {
		bbpress_integration_set_bb_cookies( $my_plugins_uri );
	}

	return;
}

// Actions to set additional bbPress cookies
add_action( 'set_auth_cookie', 'bbpress_integration_set_bb_auth_cookies', 10, 5 );
add_action( 'clear_auth_cookie', 'bbpress_integration_clear_bb_auth_cookies' );



// We can bail now if we are not in the admin area
if ( !defined( 'WP_ADMIN' ) || !WP_ADMIN ) {
	return;
}

function bbpress_integration_admin_page_add()
{
	if ( function_exists( 'is_site_admin' ) && !is_site_admin() ) {
		return;
	}
	add_options_page( __('bbPress Integration', 'bbpress_integration'), __('bbPress Integration', 'bbpress_integration'), 'manage_options', 'bbpress-integration-admin', 'bbpress_integration_admin_page' );
}

function bbpress_integration_admin_page_process()
{
	if ( function_exists( 'is_site_admin' ) && !is_site_admin() ) {
		return;
	}
	if ( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' && $_POST['option_page'] == 'bbpress-integration-admin' ) {
		check_admin_referer( 'bbpress-integration-admin' );

		$uri = rtrim( stripslashes( (string) $_POST['uri'] ), " \t\n\r\0\x0B/" ) . '/';
		if ( $uri === '/' || !@parse_url( $uri ) ) {
			$uri = '';
		}
		$my_plugins_uri = rtrim( stripslashes( (string) $_POST['my_plugins_uri'] ), " \t\n\r\0\x0B/" );
		if ( !@parse_url( $my_plugins_uri ) ) {
			$my_plugins_uri = '';
		}
		$is_wpmu = stripslashes( (int) $_POST['is_wpmu'] );
		$_options = array(
			'uri' => $uri,
			'my_plugins_uri' => $my_plugins_uri,
			'is_wpmu' => $is_wpmu
		);
		if ( function_exists( 'update_site_option' ) ) {
			update_site_option( 'bbpress_integration', $_options );
		} else {
			update_option( 'bbpress_integration', $_options );
		}

		$goback = remove_query_arg( array( '_uri', '_my_plugins_uri', '_is_wpmu' ), wp_get_referer() );
		$goback = add_query_arg( 'updated', 'true', $goback );
		wp_redirect( $goback );
		return;
	}
}

function bbpress_integration_admin_page()
{
	if ( function_exists( 'is_site_admin' ) && !is_site_admin() ) {
		return;
	}
	$options = bbpress_integration_get_options();

	if ( isset( $_GET['_uri'] ) ) {
		$uri = urldecode( $_GET['_uri'] );
	} else {
		$uri = $options['uri'];
	}

	if ( isset( $_GET['_my_plugins_uri'] ) ) {
		$my_plugins_uri = urldecode( $_GET['_my_plugins_uri'] );
	} else {
		$my_plugins_uri = $options['my_plugins_uri'];
	}

	$_is_wpmu = 0;
	$is_wpmu = array(
		0 => ' checked="checked"',
		1 => ''
	);

	if ( isset( $_GET['_is_wpmu'] ) ) {
		$_is_wpmu = (int) $_GET['_is_wpmu'];
	} else {
		$_is_wpmu = (int) $options['is_wpmu'];
	}

	if ( 1 === $_is_wpmu ) {
		$is_wpmu = array(
			0 => '',
			1 => ' checked="checked"'
		);
	}

	$is_old_cookie = false;
	global $wpmu_version;
	global $wp_version;
	if ( $is_wpmu && isset( $wpmu_version ) ) {
		if ( -1 === version_compare( $wpmu_version, '2.8' ) ) {
			$is_old_cookie = true;
		}
	} elseif ( isset( $wp_version ) ) {
		if ( -1 === version_compare( $wp_version, '2.8' ) ) {
			$is_old_cookie = true;
		}
	}
?>
<div class="wrap">
	<h2><?php _e( 'bbPress Integration', 'bbpress_integration' ); ?></h2>
	<form method="post" action="admin.php?page=bbpress-integration-admin">
		<?php wp_nonce_field('bbpress-integration-admin'); ?>
		<input type="hidden" name="option_page" value="bbpress-integration-admin" />
		<h3><?php _e( 'Authentication Cookies', 'bbpress_integration' ); ?></h3>
		<p>
			<?php _e( 'When a user logs in to WordPress, certain cookies are set in their browser which indicate to the server whether the user is logged in on subsequent page loads.', 'bbpress_integration' ); ?>
		</p>
		<p>
			<?php _e( 'bbPress can be set up to have the ability to read the standard cookies created by WordPress to check whether a user is logged in and can grant the user access to bbPress based on these. The majority of this setup is done in the bbPress administration area via the "WordPress integration" settings page, but it is also necessary to setup this plugin so that WordPress can set a couple of extra cookies which are required.', 'bbpress_integration' ); ?>
		</p>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="uri"><?php _e( 'bbPress URL', 'bbpress_integration' ) ?></label></th>
				<td>
					<input name="uri" type="text" id="bbpress-integration-uri" value="<?php echo attribute_escape( $uri ); ?>" size="60" class="code" /><br />
					<?php _e( 'The complete URL of the front page of your bbPress forums.', 'bbpress_integration' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="my_plugins_uri"><?php _e( 'Your plugins URL', 'bbpress_integration' ) ?></label></th>
				<td>
					<input name="my_plugins_uri" type="text" id="bbpress-integration-my-plugins-uri" value="<?php echo attribute_escape( $my_plugins_uri ); ?>" size="60" class="code" /><br />
					<?php _e( 'The complete URL of your plugins directory. Leave blank if it is in the default location "my-plugins" in the bbPress directory.', 'bbpress_integration' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="is_wpmu"><?php _e( 'WordPress type', 'bbpress_integration' ) ?></label></th>
				<td>
					<input name="is_wpmu" type="radio" id="bbpress-integration-is-wpmu-0" value="0"<?php echo $is_wpmu[0]; ?> /> <?php _e( 'WordPress', 'bbpress_integration' ) ?><br />
					<input name="is_wpmu" type="radio" id="bbpress-integration-is-wpmu-1" value="1"<?php echo $is_wpmu[1]; ?> /> <?php _e( 'WordPress MU', 'bbpress_integration' ) ?><br />
					<?php _e( 'Indicate here whether you are using a standard WordPress blog, or if this is an installation of WordPress MU. If you are not sure, then just leave this setting as "WordPress".', 'bbpress_integration' ); ?>
				</td>
			</tr>
		</table>
		<p class="submit">
			<input class="button-primary" type="submit" name="Submit" value="<?php _e( 'Save Changes', 'bbpress_integration' ); ?>" />
			<input type="hidden" name="action" value="update" />
		</p>
	</form>
<?php
	if ( !empty( $uri ) ) {
		$wp_settings = '';

		if ( $cookiedomain_and_path = bbpress_integration_get_cookie_domain_and_path() ) {
			extract( $cookiedomain_and_path );
			if ( $cookiehash ) {
				$wp_settings .= 'define( \'COOKIEHASH\', \'' . $cookiehash . '\' );' . "\n";
			}
			if ( $cookiedomain ) {
				$wp_settings .= 'define( \'COOKIE_DOMAIN\', \'' . $cookiedomain . '\' );' . "\n";
			}
			if ( $sitecookiepath ) {
				$wp_settings .= 'define( \'SITECOOKIEPATH\', \'' . $sitecookiepath . '\' );' . "\n";
			}
			if ( $admincookiepath ) {
				$wp_settings .= 'define( \'ADMIN_COOKIE_PATH\', \'' . $admincookiepath . '\' );' . "\n";
			}
			$wp_settings .= 'define( \'COOKIEPATH\', \'' . $cookiepath . '\' );';
		}
	} else {
		$wp_settings = __( '// Options must be set above for manual cookie settings to appear here.', 'bbpress_integration' );
	}
?>
	<h3><?php _e( 'Manual Cookie Settings', 'bbpress_integration' ); ?></h3>
	<p>
		<?php _e( 'The following lines must be added to your <code>wp-config.php</code> file to enable cookie sharing to work.', 'bbpress_integration' ); ?>
	</p>
	<p>
		<?php _e( 'These settings are based on the above information combined with your "WordPress address (URL)" setting in the "General" settings area.', 'bbpress_integration' ); ?>
	</p>
	<form action="admin.php?page=bbpress-integration-admin" method="post">
		<p><textarea rows="5" class="large-text code readonly" name="wp_manual" id="wp-manual" readonly="readonly"><?php echo( $wp_settings ); ?></textarea></p>
	</form>
<?php
	if ( $is_old_cookie ) {
?>
	<p>
		<?php _e( 'In addition to setting up integration normally in bbPress, the following line must be added to your <code>bb-config.php</code> file inside your bbPress installation.', 'bbpress_integration' ); ?>
	</p>
	<p>
		<?php _e( 'This setting is necessary due to the your current version of WordPress or WordPress MU being less than 2.8.', 'bbpress_integration' ); ?>
	</p>
	<form action="admin.php?page=bbpress-integration-admin" method="post">
		<p><textarea rows="2" class="large-text code readonly" name="bb_manual" id="bb-manual" readonly="readonly">define( 'WP_AUTH_COOKIE_VERSION', 1 );</textarea></p>
	</form>
<?php
	}
?>
</div>
<?php
}

// Actions to enable admin interface
add_action( 'admin_menu', 'bbpress_integration_admin_page_add' );
add_action( 'admin_init', 'bbpress_integration_admin_page_process' );
?>
