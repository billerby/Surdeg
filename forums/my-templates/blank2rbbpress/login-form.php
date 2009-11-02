<form class="login" method="post" action="<?php bb_option('uri'); ?>bb-login.php">
<p><?php printf(__('För att delta, <a href="%1$s">registrera dig</a> eller logga in med ditt användarnamn och lösenord.'), bb_get_option('uri').'register.php') ?>:</p>
<p>
	<label><?php _e('Username:'); ?>
		<input name="user_login" type="text" id="user_login" size="13" maxlength="40" value="<?php echo attribute_escape( $_COOKIE[ bb_get_option( 'usercookie' ) ] ); ?>" />
  </label>
	<label><?php _e('Password:'); ?>
		<input name="password" type="password" id="password" size="13" maxlength="40" />
	</label>
	<input name="re" type="hidden" value="<?php global $re; echo $re; ?>" />
	<input type="submit" name="Submit" id="submit" value="<?php echo attribute_escape( __('Login &raquo;') ); ?>" />
</p>
</form>

