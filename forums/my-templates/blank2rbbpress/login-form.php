<form class="login" method="post" action="<?php bb_option('uri'); ?>bb-login.php"><br/>
	<div class="reglog"><p><?php
		printf(
			__('<a href="%1$s">Registrera dig</a> eller logga in:<br/> <small>(<a href="%2$s">glömt lösenordet?</a>)</small>'),
			bb_get_option('uri') . 'register.php',
			bb_get_option('uri') . 'bb-login.php'
		);
	?></p>
	</div>
	<div id="logindiv">
		<label><?php _e('Username:'); ?>
			<input name="user_login" type="text" id="user_login" size="18" maxlength="50" value="<?php if (!is_bool($user_login)) echo $user_login; ?>" tabindex="1" />
		</label>
		<label><?php _e('Password:'); ?>
			<input name="password" type="password" id="password" size="18" maxlength="50" tabindex="2" />
		</label>
		<input name="re" type="hidden" value="<?php echo $re; ?>" />
		<?php wp_referer_field(); ?>
		<input type="submit" name="Submit" id="submit" value="<?php echo attribute_escape( __('Log in') ); ?>" tabindex="4" />
		<label>
			<?php _e('Remember me'); ?>
			<input name="remember" type="checkbox" id="remember" value="1" tabindex="3"<?php echo $remember_checked; ?> />
			
		</label>
	</div>
</form>
