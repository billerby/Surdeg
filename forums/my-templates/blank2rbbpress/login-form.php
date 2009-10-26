<form class="login" method="post" action="<?php bb_option('uri'); ?>bb-login.php">
	<div class="reglog"><p><?php
		printf(
			__('<a href="%1$s">Register</a> or log in:<br/> <small>(<a href="%2$s">lost password?</a>)</small>'),
			bb_get_option('uri') . 'register.php',
			bb_get_option('uri') . 'bb-login.php'
		);
	?></p>
	</div>
	<div>
		<label><?php _e('Username:'); ?><br />
			<input name="user_login" type="text" id="user_login" size="18" maxlength="50" value="<?php if (!is_bool($user_login)) echo $user_login; ?>" tabindex="1" />
		</label>
		<label><?php _e('Password:'); ?><br />
			<input name="password" type="password" id="password" size="18" maxlength="50" tabindex="2" />
		</label>
		<input name="re" type="hidden" value="<?php echo $re; ?>" />
		<?php wp_referer_field(); ?>
		<input type="submit" name="Submit" id="submit" value="<?php echo attribute_escape( __('Log in') ); ?>" tabindex="4" />
	</div>
	<div class="remember">
		<label>
			<input name="remember" type="checkbox" id="remember" value="1" tabindex="3"<?php echo $remember_checked; ?> />
			<?php _e('Remember me'); ?>
		</label>
	</div>
</form>
