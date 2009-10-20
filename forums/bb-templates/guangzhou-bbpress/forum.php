<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
				<h2><?php echo GZ::breadcrumbs (); ?></h2>
				
				<?php if ( $topics || $stickies ) : ?>
				<table class="widefat">
					<thead>
					<tr>
						<th><?php _e('Topic'); ?></th>
						<th><?php _e('Posts'); ?></th>
						<th><?php _e('Last Poster'); ?></th>
						<th><?php _e('Freshness'); ?></th>
					</tr>
					</thead>

					<?php if ( $stickies ) : foreach ( $stickies as $topic ) : ?>
					<tr<?php topic_class(); ?>>
						<td><?php _e('Sticky:'); ?> <big><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></big></td>
						<td class="num"><?php topic_posts(); ?></td>
						<td class="num"><?php topic_last_poster(); ?></td>
						<td class="num"><small><?php topic_time(); ?></small></td>
					</tr>
					<?php endforeach; endif; ?>

					<?php if ( $topics ) : foreach ( $topics as $topic ) : ?>
					<tr<?php topic_class(); ?>>
						<td><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></td>
						<td class="num"><?php topic_posts(); ?></td>
						<td class="num"><?php topic_last_poster(); ?></td>
						<td class="num"><small><?php topic_time(); ?></small></td>
					</tr>
					<?php endforeach; endif; ?>
				</table>

				<div class="tablenav">
					<div class="tablenav-pages">
						<?php forum_pages(); ?>
					</div>
				</div>
				<?php endif; ?>
			</div>
		
		<div class="sidebar">
			<ul>
				<li id="page-info">
					<div class="info">
						<a href="<?php echo bb_get_forum_posts_rss_link(); ?>"><img src="<?php echo bb_get_active_theme_uri () ?>image/feed.png" width="16" height="16" alt="Feed"/></a>
					</div>
					<h2><?php _e( 'Page Information', 'guangzhou'); ?></h2>
					<?php if (get_forum_description ()) echo '<p>'.get_forum_description ().'</p>' ?>
					
					<p><?php printf( __( 'Subscribe through your <a href="%s">feed reader</a>.', 'guangzhou'), bb_get_forum_posts_rss_link()); ?></p>
				</li>
				<?php do_action('gz_place_sidebar'); ?>
				
				<li>
					<h2><?php _e('Search'); ?></h2>
					<?php include (dirname (__FILE__).'/search-form.php')?>
				</li>

				<li>
					<h2><?php _e('Hot Tags'); ?></h2>
					<p class="frontpageheatmap"><?php bb_tag_heat_map(array ('limit' => 30, 'largest' => 15)); ?></p>
				</li>
			</ul>
		</div>
		
		<?php do_action ('gz_place_bottom'); ?>
	</div>
	<div class="clear"></div>
</div>

<div class="clear"></div>

<div id="comments">
	<div class="page">
		<?php post_form (__('Add a new topic', 'guangzhou')); ?>
	</div>
</div>

<?php bb_get_footer(); ?>
