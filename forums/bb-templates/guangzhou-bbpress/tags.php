<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			<h2><?php _e('Tags', 'guangzhou'); ?></h2>
			<div class="latest" id="single">
				<div class="post">
				<?php bb_tag_heat_map( 9, 38, 'pt', 80 ); ?>
				</div>
			</div>
		</div>
		
		<div class="sidebar">
			<ul>
				<li id="page-info">
					<h2><?php _e('Page Information', 'guangzhou'); ?></h2>
					<p><?php _e('This is a collection of <strong>tags</strong> that are currently popular on the forums.', 'guangzhou'); ?></p>
					<?php $tags = bb_get_top_tags (); ?>
					
					<p><?php printf(__('There are <strong>%d tags</strong> in total.', 'guangzhou'), count ($tags)); ?></p>
				</li>
				<li>
					<?php do_action('gz_place_sidebar'); ?>
				</li>
			</ul>
		</div>
		<?php do_action('gz_place_bottom'); ?>
	</div>
	<div class="clear"></div>
</div>

<?php bb_get_footer(); ?>
