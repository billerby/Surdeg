<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			<h2><?php isset($_POST['user_login']) ? _e('Log in Failed') : _e('Log in') ; ?></h2>

			<form method="post" action="<?php bb_option('uri'); ?>bb-login.php">
				<table width="50%">
				<?php if ( $user_exists ) : ?>
					<tr valign="top">
						<th scope="row"><?php _e('Username:'); ?></th>
						<td><input size="40" name="user_login" type="text" value="<?php echo $user_login; ?>" /></td>
					</tr>
					<tr valign="top" class="error">
						<th scope="row"><?php _e('Password:'); ?></th>
						<td><input size="40" name="password" type="password" /><br /><br/>
						<span class="error"><?php _e('Incorrect password'); ?></span></td>
					</tr>
				<?php elseif ( isset($_POST['user_login']) ) : ?>
					<tr valign="top" class="error">
						<th scope="row"><?php _e('Username:'); ?></th>
						<td><input size="40" name="user_login" type="text" value="<?php echo $user_login; ?>" /><br />
							<br/>
						<span class="error"><?php _e('This username does not exist.'); ?> <a href="<?php bb_option('uri'); ?>register.php?user=<?php echo $user_login; ?>"><?php _e('Register it?'); ?></a></span></td>
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Password:'); ?></th>
						<td><input size="40" name="password" type="password" /></td>
					</tr>
				<?php else : ?>
					<tr valign="top" class="error">
						<th scope="row"><?php _e('Username:'); ?></th>
						<td><input size="40" name="user_login" type="text" /><br />
					</tr>
					<tr valign="top">
						<th scope="row"><?php _e('Password:'); ?></th>
						<td><input size="40" name="password" type="password" /></td>
					</tr>
				<?php endif; ?>
					<tr>
						<th scope="row">&nbsp;</th>
						<td>
							<input name="re" type="hidden" value="<?php echo $redirect_to; ?>" />
							<input class="button-primary" type="submit" value="<?php echo attribute_escape( isset($_POST['user_login']) ? __('Try Again'): __('Log in') ); ?>" />
							<?php wp_referer_field(); ?>
						</td>
					</tr>
				</table>
			</form>

			<?php if ( $user_exists ) : ?>
				<br/>
			<hr />
			<br/>
			<form method="post" action="<?php bb_option('uri'); ?>bb-reset-password.php">
				<p><?php _e('If you would like to recover the password for this account, you may use the following button to start the recovery process:'); ?><br />
				<input name="user_login" type="hidden" value="<?php echo $user_login; ?>" /><br/>
				<input type="submit" value="<?php echo attribute_escape( __('Recover Password') ); ?>" /></p>
			</form>
			<?php endif; ?>

		</div>
	</div>
	<div class="clear"></div>
</div>
<?php bb_get_footer(); ?>
