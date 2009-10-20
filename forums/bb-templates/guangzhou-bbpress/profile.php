<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			<h2 id="userlogin"><?php _e('User Profile', 'guangzhou'); ?>: <?php echo get_user_name( $user->ID ); ?></h2>

			<?php if ( $updated ) : ?>
			<div class="notice">
			<p><?php _e('Profile updated'); ?>. <a href="<?php profile_tab_link( $user_id, 'edit' ); ?>"><?php _e('Edit again &raquo;'); ?></a></p>
			</div>
			<?php elseif ( $user_id == bb_get_current_user_info( 'id' ) ) : ?>
			<p><?php printf(__('This is how your profile appears to a fellow logged in member, you may <a href="%1$s">edit this information</a>. You can also <a href="%2$s">manage your favorites</a> and subscribe to your favorites&#8217; <a href="%3$s"><abbr title="Really Simple Syndication">RSS</abbr> feed</a>'), attribute_escape( get_profile_tab_link( $user_id, 'edit' ) ), attribute_escape( get_favorites_link() ), attribute_escape( get_favorites_rss_link() )); ?></p>
			<?php endif; ?>

			<div class="post"><h4><?php _e('Recent Replies'); ?></h4>
			<?php if ( $posts ) : ?>
			<ol>
			<?php foreach ($posts as $bb_post) : $topic = get_topic( $bb_post->topic_id ) ?>
			<li<?php alt_class('replies'); ?>>
				<a href="<?php topic_link(); ?>"><?php topic_title(); ?></a>
				<?php if ( $user->ID == bb_get_current_user_info( 'id' ) ) printf(__(' - you last replied %s ago'), bb_get_post_time()); else printf(__(' - user last replied %s ago'), bb_get_post_time()); ?>,

				<span class="freshness"><?php
					if ( bb_get_post_time( 'timestamp' ) < get_topic_time( 'timestamp' ) )
						printf(__('most recent reply %s ago.'), get_topic_time());
					else
						_e('no replies since.');
				?></span>
			</li>
			<?php endforeach; ?>
			</ol>
			<?php else : if ( $page ) : ?>
			<p><?php _e('No more replies.') ?></p>
			<?php else : ?>
			<p><?php _e('No replies yet.') ?></p>
			<?php endif; endif; ?>
			</div>

			<div class="post">
			<h4><?php _e('Threads Started') ?></h4>
			<?php if ( $threads ) : ?>
			<ol>
			<?php foreach ($threads as $topic) : ?>
			<li<?php alt_class('threads'); ?>>
				<a href="<?php topic_link(); ?>"><?php topic_title(); ?></a> - 
				<?php printf(__('started %s ago, '), get_topic_start_time()); ?>

				<span class="freshness"><?php
					if ( get_topic_start_time( 'timestamp' ) < get_topic_time( 'timestamp' ) )
						printf(__('most recent reply %s ago.'), get_topic_time());
					else
						_e('no replies.');
				?></span>
			</li>
			<?php endforeach; ?>
			</ol>
			<?php else : if ( $page ) : ?>
			<p><?php _e('No more topics posted.') ?></p>
			<?php else : ?>
			<p><?php _e('No topics posted yet.') ?></p>
			<?php endif; endif;?>
			</div><br style="clear: both;" />
			<div class="tablenav">
				<div class="tablenav-pages">
			<?php profile_pages(); ?>
			</div>
			</div>
		</div>
		
		<div class="sidebar">
			<ul>
				<li id="page-info">
					<div class="info">
						<a href="<?php echo get_favorites_rss_link(); ?>"><img src="<?php echo bb_get_active_theme_uri () ?>image/feed.png" width="16" height="16" alt="Feed"/></a>
					</div>
					<h2><?php _e('User Profile', 'guangzhou'); ?></h2>
					<p><?php printf(__('This is the profile for <strong>%s</strong>.', 'guangzhou'), get_user_name( $user->ID )); ?></p>
					<?php bb_profile_data(); ?>
				</li>
				<li>
					<?php do_action ('gz_place_sidebar'); ?>
				</li>
				<?php if ( is_bb_profile() ) : ?>
				<li>
					<h2><?php _e('Management', 'guangzhou'); ?></h2>
					
					<?php profile_menu(); ?>
				</li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</div>

<?php bb_get_footer(); ?>
