<div class="topmenu">
	<div class="page">
		<ul>
			<?php do_action ('gz_profile_menu ')?>
			<li><a rel="nofollow" href="<?php echo bb_get_uri('register.php', null, BB_URI_CONTEXT_A_HREF + BB_URI_CONTEXT_BB_USER_FORMS); ?>"><?php _e( 'Register', 'guangzhou')?></a></li>
			<li><a rel="nofollow" href="<?php echo bb_get_uri('bb-login.php', null, BB_URI_CONTEXT_FORM_ACTION + BB_URI_CONTEXT_BB_USER_FORMS); ?>"><?php _e( 'Login', 'guangzhou')?></a></li>
		</ul>
	</div>
</div>