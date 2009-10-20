<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			<h2><?php view_name(); ?></h2>

			<?php if ( $topics || $stickies ) : ?>
			<div id="discussions">
			<table  class="widefat" id="latest">
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

			<?php else : ?>
				<p><?php _e('There are no topics!', 'guangzhou'); ?></p>
			<?php endif; ?>
			
			<div class="tablenav">
				<div class="tablenav-pages">
					<?php view_pages(); ?>
				</div>
			</div>
			</div>
			
				<?php do_action('gz_place_bottom'); ?>
			</div>
			
			<div class="sidebar">
				<ul>
					<li id="page-info">
						<h2><?php _e('Page Information', 'guangzhou'); ?></h2>
						<p>There <?php printf (__ngettext ('is <strong>%d topic', 'are <strong>%d topics', count ($topics)), count ($topics)); ?></strong> on this page.</p>
					</li>
					<li>
						<h2><?php _e('Search'); ?></h2>
						<?php include (dirname (__FILE__).'/search-form.php')?>
					</li>
					
					<li>
						<?php do_action('gz_place_sidebar'); ?>
					</li>
					<?php if ( bb_is_user_logged_in() ) : ?>
					<li>
						<h2><?php _e('Views'); ?></h2>
						<?php foreach ( bb_get_views() as $view => $title ) : ?>
						<a href="<?php view_link(); ?>"><?php view_name(); ?> |
						<?php endforeach; ?>
					</li>
					<?php endif; // bb_is_user_logged_in() ?>
				</ul>
			</div>
		</div>
		

		<div class="clear"></div>
</div>
<?php bb_get_footer(); ?>
