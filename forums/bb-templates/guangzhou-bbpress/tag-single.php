<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			<h2><?php _e('Tags', 'guangzhou'); ?></h2>
			<?php do_action('tag_above_table', ''); ?>

			<?php if ( $topics ) : ?>

				<div id="discussions">
			<table id="latest">
			<tr>
				<th><?php _e('Topic'); ?></th>
				<th><?php _e('Posts'); ?></th>
				<th><?php _e('Last Poster'); ?></th>
				<th><?php _e('Freshness'); ?></th>
			</tr>

			<?php foreach ( $topics as $topic ) : ?>
			<tr<?php topic_class(); ?>>
				<td><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></td>
				<td class="num"><?php topic_posts(); ?></td>
				<td class="num"><?php topic_last_poster(); ?></td>
				<td class="num"><small><?php topic_time(); ?></small></td>
			</tr>
			<?php endforeach; ?>
			</table>
			<div class="nav">
			<?php tag_pages(); ?>
			</div>
			<?php endif; ?>

			<?php do_action('tag_below_table', ''); ?>

					</div>
		</div>
		
		<div class="sidebar">
			<ul>
				<li id="page-info">
					<div class="info">
						<a href="<?php bb_tag_rss_link(); ?>"><img src="<?php echo bb_get_active_theme_uri () ?>image/feed.png" width="16" height="16" alt="Feed"/></a>
					</div>
					<h2><?php _e('Page Information', 'guangzhou'); ?></h2>
					<p><?php printf(__('This page shows <strong>%1s</strong> with the tag <strong>%2s</strong>.', 'guangzhou'), sprintf( __ngettext ('%d topic', '%d topics', count ($topics)), count ($topics)), get_tag_name ()); ?></p>
					<p><?php printf(__('Subscribe through your <a href="%s">feed reader</a>.', 'guangzhou'), bb_get_tag_rss_link()); ?></p>
				</li>
				<li>
					<?php do_action('gz_place_sidebar'); ?>
				</li>
				<?php if ( bb_current_user_can('manage_tags') ) : ?>
				<li>
					<h2><?php _e('Tag Management', 'guangzhou'); ?></h2>
					<?php manage_tags_forms(); ?>
				</li>
				<?php endif; ?>

			</ul>
		</div>
		
		<?php do_action('gz_place_bottom'); ?>
	</div>
	<div style="clear: both"></div>
</div>

<?php bb_get_footer(); ?>
