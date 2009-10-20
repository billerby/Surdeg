=== bbPress Integration ===
Contributors: mdawaffe, sambauers
Tags: bbPress, forum, forums, integration
Requires at least: 2.7
Tested up to: 2.8
Stable tag: 1.0

Provides single sign on login with a bbPress installation.

== Description ==

When a user logs in to WordPress, certain cookies are set in their browser
which indicate to the server whether the user is logged in on subsequent page
loads.

bbPress can be set up to have the ability to read the standard cookies created
by WordPress to check whether a user is logged in and can grant the user
access to bbPress based on these. The majority of this setup is done in the
bbPress administration area via the "WordPress integration" settings page, but
it is also necessary to setup this plugin so that WordPress can set a couple
of extra cookies which are required.

This plugin is only useful if you are running bbPress version 1.0-alpha-4 or
later.

== Installation ==

1. Upload `bbpress-integration.php` to your plugins directory
1. Activate the plugin through the *Plugins* menu in WordPress
1. Configure your settings

== Configuration ==

Go to the "bbPress Integration" page in the "Settings" area of the WordPress
administration area. Here you will need to supply the full URL of your bbPress
forum.

If your bbPress plugins directory is not in the standard location because you
have moved it by defining BB_PLUGIN_URL in your bbPress config file, then you
need to supply that full URL as well. If your plugins directory is in the
standard location, then you can leave this field blank.

== Versions of this plugin before version 1.0 ==

The versions of this plugin before the 1.0-alpha-4 version were used to
synchronize the roles of WordPress registrations with bbPress roles.

This functionality is now handled automatically by bbPress since bbPress
1.0-alpha-4

If you require the older versions they can be found via the SVN repository in
the tags directory.

== License ==

bbPress Live version 1.0<br />
Copyright (C) 2007 Michael Adams (http://blogwaffe.com/)<br />
Copyright (C) 2009 Sam Bauers (http://unlettered.org/)

bbPress Live comes with ABSOLUTELY NO WARRANTY This is
free software, and you are welcome to redistribute
it under certain conditions.

See accompanying license.txt file for details.

== Version History ==

* 1.0-alpha-4   :
  <br />Initial release of 1.0 versions
* 1.0-alpha-4.1 :
  <br />Compute the domain for the cookie by comparison with siteurl
* 1.0-alpha-6 :
  <br />Try to get things working better with WPMU
* 1.0-rc-1 :
  <br />Add 'WP_AUTH_COOKIE_VERSION' definition for WordPress versions < 2.8
* 1.0-rc-2 :
  <br />Revert previous versions changes, I was on crack
* 1.0-rc-3 :
  <br />Better support and instructions for WordPress 2.7 and WPMU
* 1.0 :
  <br />Fix a potential warning when no options are set