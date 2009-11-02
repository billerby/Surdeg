=== bbPress Live ===
Contributors: sambauers
Tags: bbPress, forums
Requires at least: 2.6.2
Tested up to: 2.6.2
Stable tag: 0.1.2

bbPress Live allows you to pull data from a bbPress 1.0 forum using the new
XML-RPC publishing API in bbPress.

== Description ==

bbPress Live allows the display of information from a
<a href="http://bbpress.org/">bbPress</a> 1.0 forum from inside a WordPress blog.

Specifically, it provides two new widgets:

* **bbPress Forum List** - Provides a list or table of forums
* **bbPress Latest Topics** - Provides a list or table of the latest topics

Each widget can be used multiple times, and configured individually.

There are also two functions for use in themes. These functions return a raw
php array which can be manipulated inside the theme:

* `bbpress_live_get_forums()` - Provides an array of forums
* `bbpress_live_get_topics()` - Provides an array of the latest topics

bbPress Live can only connect to a bbPress forum running bbPress with a version of
1.0 or higher. The bbPress blog must have XML-RPC enabled in it's settings.

== Installation ==

1. Upload `bbpress-live.php` to your plugins directory
1. Activate the plugin through the *Plugins* menu in WordPress
1. Configure your settings in the *bbPress live* section under the *Plugins* section

== Frequently Asked Questions ==

= What parameters does the bbpress_live_get_forums() function accept? =

The parameters are as follows:

1. `$parent` integer|string The parent forum id or slug whose child forums are to be fetched. Default "0" means start at the root.
1. `$depth` integer The depth to which child forums of the parent forum will be fetched. Default "0" means no limit.

= What parameters does the bbpress_live_get_topics() function accept? =

The parameters are as follows:

1. `$forum` integer|string The forum id or slug whose child topics are to be fetched. Default "0" means get all forums.
1. `$page` integer The the page number to fetch. Default is "1".
1. `$number` integer The number of forums per page. Default "0" means use bbPress' default number per page.

== License ==

bbPress Live version 0.1.2<br />
Copyright (C) 2008 Sam Bauers (http://unlettered.org/)

bbPress Live comes with ABSOLUTELY NO WARRANTY This is
free software, and you are welcome to redistribute
it under certain conditions.

See accompanying license.txt file for details.

== Version History ==

* 0.1 : 
  <br />Initial release
* 0.1.1 : 
  <br />Change order of arguments in get_topics methods
  <br />Fix bad markdown in readme file
* 0.1.2 : 
  <br />Sync up XML-RPC calls with latest bbPress methods
  <br />Add administration page for options