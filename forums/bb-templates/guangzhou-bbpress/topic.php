<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			<div class="latest" id="single">
				<div class="post">
					<?php $bb_post = $posts[0]?>
					<?php if (GZ::can_edit ($bb_post)) : ?>
					<div class="info">
						<?php GZ::post_edit_link(); ?>
						<?php if (GZ::can_delete ()) : ?>
							<?php GZ::topic_delete_link (array ('before' => '', 'after' => '')); ?>
						<?php endif; ?>
					</div>
					<?php endif; ?>

					<h3 class="breadcrumb"><?php echo GZ::breadcrumbs (); ?></h3>
					
					<?php echo GZ::icon ($bb_post); ?>
					<h2<?php topic_class( 'topictitle' ); ?>><?php topic_title(); ?></h2>
					<div class="meta">
						<?php printf( __('%s ago'), bb_get_post_time() ); ?> | <?php post_author_link(); ?> (<?php post_author_title(); ?>)
						
						<?php if (bb_current_user_can( 'view_by_ip' ) ) { echo ' | '; post_ip_link(); } ?>
						
						<?php if (bb_current_user_can('edit_favorites') ) : ?>
							| <span id="favorite-toggle"><?php user_favorites_link (array ('mid' => __('Add To Favourites', 'guangzhou'), array ('pre' => __('Favourite')))); ?></span>
						<?php endif; ?>
					</div>

					<div class="entry">
						<?php post_text (); ?>
					</div>
					
					<p><a href="#comments"><?php _e('Read responses...', 'guangzhou'); ?></a></p>
				</div>
			</div>
			
			<?php do_action ('under_title', ''); ?>
				
			<?php if ($posts) : ?>
			<div id="ajax-response"></div>
			<?php endif; ?>
		</div>
		
		<div class="sidebar">
			<ul>
				<li id="page-info">
					<div class="info">
						<a href="<?php topic_rss_link(); ?>"><img src="<?php echo bb_get_active_theme_uri () ?>image/feed.png" width="16" height="16" alt="Feed"/></a>
					</div>
					
					<h2><?php _e('Topic Information', 'guangzhou'); ?></h2>
					<p><?php printf(__('Started %1$s ago by <strong>%2$s</strong>', 'guangzhou'), get_topic_start_time(), get_topic_author()) ?>, with a total of <?php topic_posts_link(); ?>.  Follow this topic with
					the <a href="<?php topic_rss_link(); ?>">RSS feed</a>.</p>
					
					<?php do_action('topicmeta'); ?>
				</li>
				<li>
					<h2><?php _e('Tags', 'guangzhou'); ?></h2>

					<?php topic_tags(); ?>
				</li>
				
				<?php do_action ('gz_place_sidebar'); ?>
				<li>
					<h2><?php _e('Search', 'guangzhou'); ?></h2>
					<?php include (dirname (__FILE__).'/search-form.php')?>
				</li>
				
				<?php if ( bb_current_user_can( 'delete_topic', get_topic_id() ) || bb_current_user_can( 'close_topic', get_topic_id() ) || bb_current_user_can( 'stick_topic', get_topic_id() ) || bb_current_user_can( 'move_topic', get_topic_id() ) ) : ?>
					<li>
						<h2><a href="#" onclick="jQuery('#admin-functions').toggle(); return false"><?php _e('Admin Functions', 'guangzhou'); ?></a></h2>
						<ul id="admin-functions" style="display: none">
							<?php topic_close_link (array ('before' => '<li>', 'after' => '</li>')); ?>
							<?php topic_sticky_link (array ('before' => '<li>', 'after' => '</li>')); ?>
							
							<li><?php GZ::topic_move_dropdown(); ?></li>
						</ul>
					</li>
				<?php endif; ?>
			</ul>
		</div>
		
		<?php do_action ('gz_place_bottom'); ?>
		
		<div style="clear: both"></div>
	</div>
	<div style="clear: both"></div>
</div>

<div style="clear: both"></div>
<div id="comments">
	<div class="page">
		<?php if (count ($posts) > 1) : ?>
		<h2><?php _e( 'Responses', 'guangzhou'); ?></h2>
		<?php endif; ?>
		
		<ol id="thread" start="<?php echo $list_start; ?>">
		<?php global $pos; unset ($posts[0]); foreach ($posts as $pos => $bb_post) : $del_class = post_del_class(); ?>
			<li id="post-<?php post_id(); ?>"<?php alt_class('post', $del_class); ?>>
				<?php bb_post_template(); ?>
			</li>
		<?php endforeach; ?>
		</ol>
		
		<div class="tablenav">
			<div class="tablenav-pages">
				<?php topic_pages(); ?>
			</div>
		</div>
		
		<?php if ( topic_is_open( $bb_post->topic_id ) ) : ?>
			<div id="reply">
				<?php post_form(); ?>
			</div>
		<?php else : ?>
			<h2><?php _e('Topic Closed') ?></h2>
			<p><?php _e('This topic has been closed to new replies.') ?></p>
		<?php endif; ?>
	</div>
</div>
<?php bb_get_footer(); ?>
