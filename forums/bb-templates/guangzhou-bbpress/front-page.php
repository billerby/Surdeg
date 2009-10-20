<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			
		<?php do_action ('gz_place_top'); ?>
							
		<?php if ($forums) : ?>
			<div id="discussxions">


			<?php if (bb_forums ()) : ?>
				<h2><?php _e('Forums'); ?></h2>
				<table class="widefat">
					<thead>
					<tr>
						<th><?php _e('Main Theme'); ?></th>
						<th><?php _e('Topics'); ?></th>
						<th><?php _e('Posts'); ?></th>
					</tr>
					</thead>
					
					<?php while ( bb_forum() ) : ?>
					<tr<?php bb_forum_class(); ?>>
						<td><?php bb_forum_pad( '<div class="nest">' ); ?><a href="<?php forum_link(); ?>"><?php forum_name(); ?></a><?php forum_description('before= - <small>&after=</small>'); ?><?php bb_forum_pad( '</div>' ); ?></td>
						<td class="num"><?php forum_topics(); ?></td>
						<td class="num"><?php forum_posts(); ?></td>
					</tr>
					<?php endwhile; ?>
				</table>
			<?php endif; // bb_forums() ?>


				<?php if ($topics || $super_stickies) : ?>
					<h2><?php _e('Latest Discussions'); ?></h2>

					<table class="widefat">
						<thead>
						<tr>
							<th><?php _e('Topic'); ?></th>
							<th><?php _e('Posts'); ?></th>
							<th><?php _e('Last Poster'); ?></th>
							<th><?php _e('Freshness'); ?></th>
						</tr>
						</thead>

						<?php if ( $super_stickies ) : foreach ( $super_stickies as $topic ) : ?>
						<tr<?php topic_class(); ?>>
							<td><?php _e('Sticky:'); ?> <big><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></big></td>
							<td class="num"><?php topic_posts(); ?></td>
							<td class="num"><?php topic_last_poster(); ?></td>
							<td class="num"><small><?php topic_time(); ?></small></td>
						</tr>
						<?php endforeach; endif; // $super_stickies ?>

						<?php if ( $topics ) : foreach ( $topics as $topic ) : ?>
						<tr<?php topic_class(); ?>>
							<td><a href="<?php topic_link(); ?>"><?php topic_title(); ?></a></td>
							<td class="num"><?php topic_posts(); ?></td>
							<td class="num"><?php topic_last_poster(); ?></td>
							<td class="num"><small><?php topic_time(); ?></small></td>
						</tr>
						<?php endforeach; endif; // $topics ?>
					</table>
				<?php endif; // $topics or $super_stickies ?>
			</div>

		<?php else : // $forums ?>
			<?php post_form(); ?>
		<?php endif; // $forums ?>
		</div>
		
		
		<div class="sidebar">
			<ul>
				<li id="page-info">
					<h2><?php _e('Forum Information', 'guangzhou'); ?></h2>
					<?php do_action ('gz_place_welcome'); ?>
				</li>

				<?php do_action ('gz_place_sidebar'); ?>

				<li>
					<h2><?php _e('Search', 'guangzhou'); ?></h2>
					<?php include (dirname (__FILE__).'/search-form.php')?>
				</li>

				<li>
					<h2><?php _e('Hot Tags'); ?></h2>
					<p class="frontpageheatmap"><?php bb_tag_heat_map(array ('limit' => 30, 'largest' => 15)); ?></p>
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
		
		<?php do_action ('gz_place_bottom'); ?>
	</div>
	<div class="clear"></div>
</div>

<?php bb_get_footer(); ?>