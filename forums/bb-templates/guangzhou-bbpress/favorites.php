<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			<h2 id="currentfavorites"><?php _e('Current Favorites'); ?><?php if ( $topics ) echo ' (' . $favorites_total . ')'; ?></h2>

			<p><?php _e('Your Favorites allow you to create a custom <abbr title="Really Simple Syndication">RSS</abbr> feed which pulls recent replies to the topics you specify.
			To add topics to your list of favorites, just click the "Add to Favorites" link found on that topic&#8217;s page.'); ?></p>

			<?php if ( $user_id == bb_get_current_user_info( 'id' ) ) : ?>
			<p><?php printf(__('Subscribe to your favorites&#8217; <a href="%s"><abbr title="Really Simple Syndication">RSS</abbr> feed</a>.'), attribute_escape( get_favorites_rss_link( bb_get_current_user_info( 'id' ) ) )) ?></p>
			<?php endif; ?>

			<?php if ( $topics ) : ?>

			<table id="favorites">
			<tr>
				<th><?php _e('Topic'); ?></th>
				<th><?php _e('Posts'); ?></th>
				<th><?php _e('Freshness'); ?></th>
				<th><?php _e('Remove'); ?></th>
			</tr>

			<?php foreach ( $topics as $topic ) : ?>
			<tr<?php topic_class(); ?>>
				<td><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></td>
				<td class="num"><?php topic_posts(); ?></td>
				<td class="num"><small><?php topic_time(); ?></small></td>
				<td class="num">[<?php user_favorites_link('', array('mid'=>'x'), $user_id); ?>]</td>
			</tr>
			<?php endforeach; ?>
			</table>

			<div class="nav">
			<?php favorites_pages(); ?>
			</div>

			<?php else: if ( $user_id == bb_get_current_user_info( 'id' ) ) : ?>

			<p><?php _e('You currently have no favorites.'); ?></p>

			<?php else : ?>

			<p><?php echo get_user_name( $user_id ); ?> <?php _e('currently has no favorites.'); ?></p>

			<?php endif; endif; ?>
		</div>
		<div class="sidebar">
			<ul>
				<li id="page-info">
					<div class="info">
						<a href="<?php echo get_favorites_rss_link(); ?>"><img src="<?php echo bb_get_active_theme_uri () ?>image/feed.png" width="16" height="16" alt="Feed"/></a>
					</div>
					<h2><?php _e( 'User Profile', 'guangzhou'); ?></h2>
					<p><?php printf( __('This is the profile for <strong>%s</strong>.', 'guangzhou'), get_user_name( $user->ID )); ?></p>
					<?php bb_profile_data(); ?>
				</li>
				<?php if ( is_bb_profile() ) : ?>
				<li>
					<h2><?php _e( 'Management', 'guangzhou'); ?></h2>
					<?php profile_menu(); ?>
				</li>
				<?php endif; ?>
			</ul>
		</div>
		
		<?php do_action('gz_place_bottom'); ?>
	</div>
	<div class="clear"></div>
</div>

<?php bb_get_footer(); ?>
