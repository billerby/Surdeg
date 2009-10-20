<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			<h2><?php _e ('Edit post', 'guangzhou'); ?></h2>

			<div id="commentform">
			<?php edit_form(); ?>
			</div>

			<span id="favorite-toggle" style="display: none"><?php user_favorites_link (); ?></span>
		</div>
	</div>
</div>
<div style="clear: both"></div>
<?php bb_get_footer(); ?>
