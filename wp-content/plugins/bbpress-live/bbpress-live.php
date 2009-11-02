<?php
/*
Plugin Name: bbPress Live
Plugin URI: http://wordpress.org/extend/plugins/bbpress-live/
Description: Pull data from a bbPress 1.0 forum.
Version: 0.1.2
Author: Sam Bauers
Author URI: http://unlettered.org/
*/



if ( defined('XMLRPC_REQUEST') && XMLRPC_REQUEST ) {
	return;
}

if ( defined('DOING_AJAX') && DOING_AJAX ) {
	return;
}

include_once( ABSPATH . WPINC . '/class-IXR.php' );



class bbPress_Live_Widget_Forums
{
	var $options;

	function bbPress_Live_Widget_Forums()
	{
		if ( !$this->options = get_option( 'bbpress_live_widget_forums' ) ) {
			$this->options = array();
		}

		add_action( 'widgets_init', array($this, 'init') );
	}

	function init()
	{
		$widget_options = array(
			'classname' => 'bbpress_live_widget_forums',
			'description' => __('Forum lists from your bbPress forums')
		);

		$control_options = array(
			'height' => 350,
			'id_base' => 'bbpress_live_widget_forums'
		);

		if ( !count($this->options) ) {
			$options = array(-1 => false);
		} else {
			$options = $this->options;
		}
		foreach ( $options as $instance => $option ) {
			wp_register_sidebar_widget(
				'bbpress_live_widget_forums-' . $instance,
				__('bbPress Forum list', 'bbpress_live'),
				array($this, 'display'),
				$widget_options,
				array( 'number' => $instance )
			);

			wp_register_widget_control(
				'bbpress_live_widget_forums-' . $instance,
				__('bbPress Forum list', 'bbpress_live'),
				array($this, 'control'),
				$control_options,
				array( 'number' => $instance )
			);
		}
	}

	function display( $args, $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric($instance) || 1 > $instance ) {
			return;
		}

		global $bbpress_live;

		extract($args);

		echo $before_widget;
		if ( $this->options[$instance]['title'] ) {
			echo $before_title;
			echo $this->options[$instance]['title'];
			echo $after_title;
		}

		if ( $forums = $bbpress_live->get_forums($this->options[$instance]['parent'], $this->options[$instance]['depth']) ) {
			switch ($this->options[$instance]['layout']) {
				default:
				case 'list':
					echo '<ol>';
					foreach ( $forums as $forum ) {
						echo '<li>';
						echo '<a href="' . $forum['forum_uri'] . '">' . $forum['forum_name'] . '</a> ';
						echo '</li>';
					}
					echo '</ol>';
					break;

				case 'table':
					echo '<table>';
					echo '<tr>';
					echo '<th>'. __('Forum', 'bbpress_live') . '</th>';
					echo '<th>'. __('Topics', 'bbpress_live') . '</th>';
					echo '<th>'. __('Posts', 'bbpress_live') . '</th>';
					echo '</tr>';
					foreach ( $forums as $forum ) {
						echo '<tr>';
						echo '<td><a href="' . $forum['forum_uri'] . '">' . $forum['forum_name'] . '</a></td>';
						echo '<td>' . $forum['topics'] . '</td>';
						echo '<td>' . $forum['posts'] . '</td>';
						echo '</tr>';
					}
					echo '</table>';
					break;
			}
		}
		echo $after_widget;
	}

	function control( $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric($instance) || 1 > $instance ) {
			$instance = '%i%';
		}

		$options = $this->options;

		if ( 'POST' == strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
			if ( isset( $_POST['bbpress_live_widget_forums'] ) ) {
				foreach ( $_POST['bbpress_live_widget_forums'] as $_instance => $_value ) {
					if ( !$_value ) {
						continue;
					}
					$options[$_instance]['title'] = strip_tags( stripslashes( $_POST['bbpress_live_widget_forums'][$_instance]['title'] ) );
					$options[$_instance]['parent'] = strip_tags( stripslashes( $_POST['bbpress_live_widget_forums'][$_instance]['parent'] ) );
					$options[$_instance]['depth'] = (int) $_POST['bbpress_live_widget_forums'][$_instance]['depth'];
					$layout = $_POST['bbpress_live_widget_forums'][$_instance]['layout'];
					if ( in_array( $layout, array('list', 'table') ) ) {
						$options[$_instance]['layout'] = $layout;
					} else {
						$options[$_instance]['layout'] = 'list';
					}
				}
				if ( $this->options != $options ) {
					$this->options = $options;
					update_option('bbpress_live_widget_forums', $this->options);
				}
			} else {
				$this->options = array();
				delete_option('bbpress_live_widget_forums');
			}
		}

		$options['%i%']['title'] = '';
		$options['%i%']['parent'] = '';
		$options['%i%']['depth'] = '';
		$options['%i%']['layout'] = 'list';

		$title = attribute_escape( stripslashes( $options[$instance]['title'] ) );
		$parent = attribute_escape( stripslashes( $options[$instance]['parent'] ) );
		if ( !$depth = $options[$instance]['depth'] ) {
			$depth = '';
		}
		if ( !$options[$instance]['layout'] ) {
			$options[$instance]['layout'] = 'list';
		}
		$layout = array(
			'list' => '',
			'table' => ''
		);
		$layout[$options[$instance]['layout']] = ' checked="checked"';
?>
			<p>
				<label for="bbpress_live_widget_forums_title_<?php echo $instance; ?>">
					<?php _e('Title:', 'bbpress_live'); ?>
					<input class="widefat" id="bbpress_live_widget_forums_title_<?php echo $instance; ?>" name="bbpress_live_widget_forums[<?php echo $instance; ?>][title]" type="text" value="<?php echo $title; ?>" />
				</label>
			</p>
			<p>
				<label for="bbpress_live_widget_forums_parent_<?php echo $instance; ?>">
					<?php _e('Parent forum id or slug (optional):', 'bbpress_live'); ?>
					<input class="widefat" id="bbpress_live_widget_forums_parent_<?php echo $instance; ?>" name="bbpress_live_widget_forums[<?php echo $instance; ?>][parent]" type="text" value="<?php echo $parent; ?>" />
				</label>
			</p>
			<p>
				<label for="bbpress_live_widget_forums_depth_<?php echo $instance; ?>">
					<?php _e('Hierarchy depth:', 'bbpress_live'); ?>
					<input style="width: 25px;" id="bbpress_live_widget_forums_depth_<?php echo $instance; ?>" name="bbpress_live_widget_forums[<?php echo $instance; ?>][depth]" type="text" value="<?php echo $depth; ?>" />
				</label>
			</p>
			<div>
				<p style="margin-bottom: 0;">
					<?php _e('Layout style:', 'bbpress_live'); ?>
				</p>
				<div>
					<label for="bbpress_live_widget_forums_list_<?php echo $instance; ?>">
						<input id="bbpress_live_widget_forums_list_<?php echo $instance; ?>" name="bbpress_live_widget_forums[<?php echo $instance; ?>][layout]" type="radio" value="list"<?php echo $layout['list']; ?> /> <?php _e('ordered list', 'bbpress_live'); ?>
					</label>
				</div>
				<div>
					<label for="bbpress_live_widget_forums_table_<?php echo $instance; ?>">
						<input id="bbpress_live_widget_forums_table_<?php echo $instance; ?>" name="bbpress_live_widget_forums[<?php echo $instance; ?>][layout]" type="radio" value="table"<?php echo $layout['table']; ?> /> <?php _e('table', 'bbpress_live'); ?>
					</label>
				</div>
			</div>
			<input type="hidden" id="bbpress_live_widget_forums_submit" name="bbpress_live_widget_forums[<?php echo $instance; ?>][submit]" value="1" />
<?php
	}
}



class bbPress_Live_Widget_Topics
{
	var $options;

	function bbPress_Live_Widget_Topics()
	{
		if ( !$this->options = get_option( 'bbpress_live_widget_topics' ) ) {
			$this->options = array();
		}

		add_action( 'widgets_init', array($this, 'init') );
	}

	function init()
	{
		$widget_options = array(
			'classname' => 'bbpress_live_widget_topics',
			'description' => __('The latest topics from your bbPress forums')
		);

		$control_options = array(
			'height' => 350,
			'id_base' => 'bbpress_live_widget_topics'
		);

		if ( !count($this->options) ) {
			$options = array(-1 => false);
		} else {
			$options = $this->options;
		}
		foreach ( $options as $instance => $option ) {
			wp_register_sidebar_widget(
				'bbpress_live_widget_topics-' . $instance,
				__('bbPress latest topics', 'bbpress_live'),
				array($this, 'display'),
				$widget_options,
				array( 'number' => $instance )
			);

			wp_register_widget_control(
				'bbpress_live_widget_topics-' . $instance,
				__('bbPress latest topics', 'bbpress_live'),
				array($this, 'control'),
				$control_options,
				array( 'number' => $instance )
			);
		}
	}

	function display( $args, $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric($instance) || 1 > $instance ) {
			return;
		}

		global $bbpress_live;

		extract($args);

		echo $before_widget;
		if ( $this->options[$instance]['title'] ) {
			echo $before_title;
			echo $this->options[$instance]['title'];
			echo $after_title;
		}

		if ( $topics = $bbpress_live->get_topics($this->options[$instance]['forum'], $this->options[$instance]['number']) ) {
			switch ($this->options[$instance]['layout']) {
				default:
				case 'list':
					echo '<ol>';
					foreach ( $topics as $topic ) {
						echo '<li>';
						echo '<a href="' . $topic['topic_uri'] . '">' . $topic['topic_title'] . '</a> ';
						printf( __( '%1$s posted %2$s ago', 'bbpress_live' ), $topic['topic_last_poster_display_name'], $topic['topic_time_since'] );
						echo '</li>';
					}
					echo '</ol>';
					break;

				case 'table':
					echo '<table>';
					echo '<tr>';
					echo '<th>'. __('Topic', 'bbpress_live') . '</th>';
					echo '<th>'. __('Posts', 'bbpress_live') . '</th>';
					echo '<th>'. __('Last Poster', 'bbpress_live') . '</th>';
					echo '<th>'. __('Freshness', 'bbpress_live') . '</th>';
					echo '</tr>';
					foreach ( $topics as $topic ) {
						echo '<tr>';
						echo '<td><a href="' . $topic['topic_uri'] . '">' . $topic['topic_title'] . '</a></td>';
						echo '<td>' . $topic['topic_posts'] . '</td>';
						echo '<td>' . $topic['topic_last_poster_display_name'] . '</td>';
						echo '<td>' . $topic['topic_time_since'] . '</td>';
						echo '</tr>';
					}
					echo '</table>';
					break;
			}
		}
		echo $after_widget;
	}

	function control( $instance = false )
	{
		if ( is_array( $instance ) ) {
			$instance = $instance['number'];
		}

		if ( !$instance || !is_numeric($instance) || 1 > $instance ) {
			$instance = '%i%';
		}

		$options = $this->options;

		if ( 'POST' == strtoupper( $_SERVER['REQUEST_METHOD'] ) ) {
			if ( isset( $_POST['bbpress_live_widget_topics'] ) ) {
				foreach ( $_POST['bbpress_live_widget_topics'] as $_instance => $_value ) {
					if ( !$_value ) {
						continue;
					}
					$options[$_instance]['title'] = strip_tags( stripslashes( $_POST['bbpress_live_widget_topics'][$_instance]['title'] ) );
					$options[$_instance]['forum'] = strip_tags( stripslashes( $_POST['bbpress_live_widget_topics'][$_instance]['forum'] ) );
					$options[$_instance]['number'] = (int) $_POST['bbpress_live_widget_topics'][$_instance]['number'];
					$layout = $_POST['bbpress_live_widget_topics'][$_instance]['layout'];
					if ( in_array( $layout, array('list', 'table') ) ) {
						$options[$_instance]['layout'] = $layout;
					} else {
						$options[$_instance]['layout'] = 'list';
					}
				}
				if ( $this->options != $options ) {
					$this->options = $options;
					update_option('bbpress_live_widget_topics', $this->options);
				}
			} else {
				$this->options = array();
				delete_option('bbpress_live_widget_topics');
			}
		}

		$options['%i%']['title'] = '';
		$options['%i%']['forum'] = '';
		$options['%i%']['number'] = 5;
		$options['%i%']['layout'] = 'list';

		$title = attribute_escape( stripslashes( $options[$instance]['title'] ) );
		$forum = attribute_escape( stripslashes( $options[$instance]['forum'] ) );
		if ( !$number = (int) $options[$instance]['number'] ) {
			$number = 5;
		}
		if ( !$options[$instance]['layout'] ) {
			$options[$instance]['layout'] = 'list';
		}
		$layout = array(
			'list' => '',
			'table' => ''
		);
		$layout[$options[$instance]['layout']] = ' checked="checked"';
?>
			<p>
				<label for="bbpress_live_widget_topics_title_<?php echo $instance; ?>">
					<?php _e('Title:', 'bbpress_live'); ?>
					<input class="widefat" id="bbpress_live_widget_topics_title_<?php echo $instance; ?>" name="bbpress_live_widget_topics[<?php echo $instance; ?>][title]" type="text" value="<?php echo $title; ?>" />
				</label>
			</p>
			<p>
				<label for="bbpress_live_widget_topics_forum_<?php echo $instance; ?>">
					<?php _e('Forum id or slug (optional):', 'bbpress_live'); ?>
					<input class="widefat" id="bbpress_live_widget_topics_forum_<?php echo $instance; ?>" name="bbpress_live_widget_topics[<?php echo $instance; ?>][forum]" type="text" value="<?php echo $forum; ?>" />
				</label>
			</p>
			<p>
				<label for="bbpress_live_widget_topics_number_<?php echo $instance; ?>">
					<?php _e('Number of topics to show:', 'bbpress_live'); ?>
					<input style="width: 25px;" id="bbpress_live_widget_topics_number_<?php echo $instance; ?>" name="bbpress_live_widget_topics[<?php echo $instance; ?>][number]" type="text" value="<?php echo $number; ?>" />
				</label>
			</p>
			<div>
				<p style="margin-bottom: 0;">
					<?php _e('Layout style:', 'bbpress_live'); ?>
				</p>
				<div>
					<label for="bbpress_live_widget_topics_list_<?php echo $instance; ?>">
						<input id="bbpress_live_widget_topics_list_<?php echo $instance; ?>" name="bbpress_live_widget_topics[<?php echo $instance; ?>][layout]" type="radio" value="list"<?php echo $layout['list']; ?> /> <?php _e('ordered list', 'bbpress_live'); ?>
					</label>
				</div>
				<div>
					<label for="bbpress_live_widget_topics_table_<?php echo $instance; ?>">
						<input id="bbpress_live_widget_topics_table_<?php echo $instance; ?>" name="bbpress_live_widget_topics[<?php echo $instance; ?>][layout]" type="radio" value="table"<?php echo $layout['table']; ?> /> <?php _e('table', 'bbpress_live'); ?>
					</label>
				</div>
			</div>
			<input type="hidden" id="bbpress_live_widget_topics_submit" name="bbpress_live_widget_topics[<?php echo $instance; ?>][submit]" value="1" />
<?php
	}
}



class bbPress_Live_Fetch
{
	var $endpoint = false;
	var $result;
	var $readonly_methods = array(
		'bb.getForums',
		'bb.getTopics'
	);

	function bbPress_Live_Fetch()
	{
		$this->options = array(
			'target_uri'    => '',
			'username' => '',
			'password' => '',
			'always_use_auth' => false
		);

		if ( $options = get_option( 'bbpress_live_fetch' ) ) {
			$this->options = array_merge( $this->options, $options );
		}
		
		$this->set_endpoint( $this->options['target_uri'] );
	}

	function set_endpoint( $uri = false )
	{
		$old_endpoint = $this->endpoint;
		if ( $new_endpoint = discover_pingback_server_uri( $uri ) ) {
			$this->endpoint = $new_endpoint;
		}
		return $old_endpoint;
	}

	function query( $method, $args = false )
	{
		if (!$method) {
			return false;
		}

		$client = new IXR_Client( $this->endpoint );
		$client->debug = false;
		$client->timeout = 3;
		$client->useragent .= ' -- bbPress Live Data/0.1.2';

		if ( $this->options['always_use_auth'] || !in_array( $method, $this->readonly_methods ) ) {
			array_unshift( $args, $this->options['username'], $this->options['password'] );
		} else {
			array_unshift( $args, false, false );
		}

		if ( !$client->query( $method, $args ) ) {
			return false;
		}

		return $client->getResponse();
	}
}



class bbPress_Live
{
	var $options;
	var $fetch;

	function bbPress_Live()
	{
		$this->options = array(
			'cache_enabled' => false,
			'cache_timeout' => 3600,
			'widget_forums' => true,
			'widget_topics' => true,
			'post_to_topic' => false,
			'post_to_topic_forum' => false,
			'post_to_topic_delay' => 60,
			'host_all_comments' => false
		);

		if ( $options = get_option('bbpress_live') ) {
			$this->options = array_merge( $this->options, $options );
		}

		$this->fetch = new bbPress_Live_Fetch();

		if ( $this->options['widget_forums'] ) {
			new bbPress_Live_Widget_Forums();
		}

		if ( $this->options['widget_topics'] ) {
			new bbPress_Live_Widget_Topics();
		}
	}

	function cache_update( $key, $value )
	{
		if ( !$key ) {
			return false;
		}

		if ( !$value ) {
			return $this->cache_delete( $key );
		}

		$cache = array(
			'time' => time(),
			'content' => $value
		);

		if ( !update_option( 'bbpress_live_cache_' . $key, $cache ) ) {
			return false;
		}

		return $cache['time'];
	}

	function cache_delete( $key )
	{
		if ( !$key ) {
			return false;
		}

		if ( !delete_option( 'bbpress_live_cache_' . $key ) ) {
			return false;
		}

		return true;
	}

	function cache_get( $key )
	{
		if ( !$key ) {
			return false;
		}

		if ( !$this->options['cache_enabled'] ) {
			return false;
		}

		$cache = get_option( 'bbpress_live_cache_' . $key );

		if ( ( (int) $cache['time'] + (int) $this->options['cache_timeout'] ) < time() ) {
			return false;
		}

		return $cache['content'];
	}

	function get_forums( $parent = 0, $depth = 0 )
	{
		$key = md5('forums_' . $parent . '_' . $depth);

		if ( $forums = $this->cache_get( $key ) ) {
			return $forums;
		}

		if ( !$forums = $this->fetch->query( 'bb.getForums', array($parent, $depth) ) ) {
			return false;
		}

		$this->cache_update( $key, $forums );

		return $forums;
	}

	function get_topics( $forum = 0, $number = 0, $page = 1 )
	{
		$key = md5('topics_' . $forum . '_' . $number . '_' . $page);

		if ( $topics = $this->cache_get( $key ) ) {
			return $topics;
		}

		if ( !$topics = $this->fetch->query( 'bb.getTopics', array($forum, $number, $page) ) ) {
			return false;
		}

		$this->cache_update( $key, $topics );

		return $topics;
	}
}



$bbpress_live = new bbPress_Live();

function bbpress_live_get_forums( $parent = 0, $depth = 0 )
{
	global $bbpress_live;
	return $bbpress_live->get_forums( $parent, $depth );
}

function bbpress_live_get_topics( $forum = 0, $number = 0, $page = 1 )
{
	global $bbpress_live;
	return $bbpress_live->get_topics( $forum, $number, $page );
}



// We can bail now if we are not in the admin area
if ( !defined( 'WP_ADMIN' ) || !WP_ADMIN ) {
	return;
}

function bbpress_live_admin_page_add()
{
	add_options_page( __('bbPress Live', 'bbpress_live'), __('bbPress Live', 'bbpress_live'), 'manage_options', 'bbpress-live-admin', 'bbpress_live_admin_page' );
}

function bbpress_live_admin_page_process()
{
	if ( strtolower( $_SERVER['REQUEST_METHOD'] ) == 'post' && $_POST['option_page'] == 'bbpress-live' ) {
		check_admin_referer( 'bbpress-live-admin' );

		$_fetch_options = array(
			'target_uri' => stripslashes((string) $_POST['target_uri']),
			'username' => stripslashes((string) $_POST['username']),
			'password' => stripslashes((string) $_POST['password']),
			'always_use_auth' => (bool) $_POST['always_use_auth']
		);
		update_option('bbpress_live_fetch', $_fetch_options);

		$_options = array(
			'cache_enabled' => (bool) $_POST['cache_enabled'],
			'cache_timeout' => (int) $_POST['cache_timeout'],
			'widget_forums' => (bool) $_POST['widget_forums'],
			'widget_topics' => (bool) $_POST['widget_topics'],
			'post_to_topic' => (bool) $_POST['post_to_topic'],
			'post_to_topic_forum' => stripslashes((string) $_POST['post_to_topic_forum']),
			'post_to_topic_delay' => (int) $_POST['post_to_topic_delay']
		);
		update_option('bbpress_live', $_options);

		$goback = add_query_arg('updated', 'true', wp_get_referer());
		wp_redirect($goback);
		return;
	}
}

function bbpress_live_admin_page()
{
	global $bbpress_live;

	$fetch_options = $bbpress_live->fetch->options;
	$options = $bbpress_live->options;
?>
<div class="wrap">
	<p>
		Test
	</p>
	<form method="post" action="admin.php?page=bbpress-live-admin">
		<?php wp_nonce_field('bbpress-live-admin'); ?>
		<input type="hidden" name="option_page" value="bbpress-live" />
		<h3><?php _e( 'Connect to bbPress', 'bbpress_live' ); ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="target_uri"><?php _e( 'bbPress URL', 'bbpress_live' ) ?></label></th>
				<td>
					<input name="target_uri" type="text" id="target_uri" value="<?php echo attribute_escape( $fetch_options['target_uri'] ); ?>" size="60" /><br />
					<?php _e( 'Just the URL of the front page of your bbPress forums.', 'bbpress_live' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="username"><?php _e( 'bbPress username', 'bbpress_live' ) ?></label></th>
				<td>
					<input name="username" type="text" id="username" value="<?php echo attribute_escape( $fetch_options['username'] ); ?>" size="20" /><br />
					<?php _e( 'Usually only required for operations that write data.', 'bbpress_live' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="password"><?php _e( 'bbPress password', 'bbpress_live' ) ?></label></th>
				<td>
					<input name="password" type="password" id="password" value="<?php echo attribute_escape( $fetch_options['password'] ); ?>" size="20" /><br />
					<?php _e( 'Usually only required for operations that write data.', 'bbpress_live' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="always_use_auth"><?php _e( 'Always authenticate', 'bbpress_live' ) ?></label></th>
				<td>
					<input name="always_use_auth" type="checkbox" id="always_use_auth" value="1"<?php echo( $fetch_options['always_use_auth'] ? ' checked="checked"' : '' ); ?> />
					<?php _e( 'This will force bbPress Live to always send your username and password, even for read-only operations.', 'bbpress_live' ); ?>
				</td>
			</tr>
		</table>
		<h3><?php _e( 'Cache requests', 'bbpress_live' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="cache_enabled"><?php _e( 'Caching enabled', 'bbpress_live' ) ?></label></th>
				<td>
					<input name="cache_enabled" type="checkbox" id="cache_enabled" value="1"<?php echo( $options['cache_enabled'] ? ' checked="checked"' : '' ); ?> />
					<?php _e( 'Turn on caching of requests to reduce latency and load.', 'bbpress_live' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="cache_timeout"><?php _e( 'Cache timeout', 'bbpress_live' ) ?></label></th>
				<td>
					<input name="cache_timeout" type="text" id="cache_timeout" value="<?php echo attribute_escape( $options['cache_timeout'] ); ?>" size="10" /> <?php _e( '(seconds)', 'bbpress_live' ) ?><br />
					<?php _e( 'The amount of time in seconds that a cached request is valid for.', 'bbpress_live' ); ?>
				</td>
			</tr>
		</table>
		<h3><?php _e( 'Widgets', 'bbpress_live' ) ?></h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="widget_forums"><?php _e( 'Enable forums widget', 'bbpress_live' ) ?></label></th>
				<td><input name="widget_forums" type="checkbox" id="widget_forums" value="1"<?php echo( $options['widget_forums'] ? ' checked="checked"' : '' ); ?> /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="widget_topics"><?php _e( 'Enable topics widget', 'bbpress_live' ) ?></label></th>
				<td><input name="widget_topics" type="checkbox" id="widget_topics" value="1"<?php echo( $options['widget_topics'] ? ' checked="checked"' : '' ); ?> /></td>
			</tr>
		</table>
		<h3><?php _e( 'Copy new WordPress posts to bbPress', 'bbpress_live' ) ?> (not implemented)</h3>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for=""><?php _e( 'Enable copying', 'bbpress_live' ) ?></label></th>
				<td>
					<input name="post_to_topic" type="checkbox" id="post_to_topic" value="1"<?php echo( $options['post_to_topic'] ? ' checked="checked"' : '' ); ?> />
					<?php _e( 'When new posts are made in WordPress, a new topic will be created in bbPress.', 'bbpress_live' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="post_to_topic_forum"><?php _e( 'Post forum', 'bbpress_live' ) ?></label></th>
				<td>
					<input name="post_to_topic_forum" type="text" id="post_to_topic_forum" value="<?php echo attribute_escape( $options['post_to_topic_forum'] ); ?>" size="20" /><br />
					<?php _e( 'New WordPress posts will be copied into this forum. Specify a numeric forum id or slug only.', 'bbpress_live' ); ?>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="post_to_topic_delay"><?php _e( 'Copy delay', 'bbpress_live' ) ?></label></th>
				<td>
					<input name="post_to_topic_delay" type="text" id="post_to_topic_delay" value="<?php echo attribute_escape( $options['post_to_topic_delay'] ); ?>" size="10" /> <?php _e( '(seconds)', 'bbpress_live' ) ?><br />
					<?php _e( 'The delay in seconds before a WordPress post will be copied to bbPress.', 'bbpress_live' ); ?>
				</td>
			</tr>
		</table>
		<p class="submit"><input type="submit" name="Submit" value="<?php _e( 'Save Changes', 'bbpress_live' ); ?>" />
			<input type="hidden" name="action" value="update" />
		</p>
	</form>
</div>
<?php
}

// Actions to enable admin interface
add_action('admin_menu', 'bbpress_live_admin_page_add');
add_action('admin_init', 'bbpress_live_admin_page_process');

?>