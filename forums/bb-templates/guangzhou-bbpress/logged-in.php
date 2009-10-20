<div class="topmenu">
	<div class="page">
		<ul>
			<li><?php bb_profile_link(array ('text' => 'Profile')); ?></li>
			
			<?php if (bb_get_option ('wp_siteurl')) : ?>
			<li><a href="<?php echo rtrim (bb_get_option ('wp_siteurl'), '/') ?>/wp-admin/"><?php _e('Dashboard', 'guangzhou'); ?></a></li>
			<?php endif; ?>
			
			<li><?php bb_logout_link(); ?></li>

			<?php do_action ('gz_profile_menu ')?>
		</ul>
	</div>
</div>