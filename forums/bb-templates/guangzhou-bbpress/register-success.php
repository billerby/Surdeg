<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			<div class="post">
				<h2 id="register"><?php _e('Great!'); ?></h2>

				<p><?php printf(__('Your registration as <strong>%s</strong> was successful. Within a few minutes you should receive an email with your password.'), $user_login) ?>
			</div>
		</div>
	</div>
</div>

<?php bb_get_footer(); ?>
