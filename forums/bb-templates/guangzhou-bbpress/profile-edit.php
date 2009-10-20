<?php bb_get_header(); ?>

<div id="main">
	<div class="page">
		<div id="content">
			<h2 id="userlogin"><?php _e('Edit Profile', 'guangzhou'); ?>: <?php echo get_user_name( $user->ID ); ?></h2>
			<form method="post" action="<?php profile_tab_link($user->ID, 'edit');  ?>">
			<fieldset>
				<legend><?php _e('Profile Info'); ?></legend>
				<?php bb_profile_data_form(); ?>
			</fieldset>

			<?php if ( bb_current_user_can( 'edit_users' ) ) : ?>
			<fieldset>
			<legend><?php _e('Administration'); ?></legend>
			<?php bb_profile_admin_form(); ?>
			</fieldset>
			<?php endif; ?>

			<?php if ( bb_current_user_can( 'change_user_password', $user->ID ) ) : ?>
			<fieldset>
			<legend><?php _e('Password'); ?></legend>
			<p><?php _e('To change your password, enter a new password twice below:'); ?></p>
			<table width="100%">
			<tr>
			  <th scope="row"><?php _e('New password:'); ?></th>
			  <td><input name="pass1" type="password" id="pass1" size="15" maxlength="100" /></td>
			</tr>
			<tr>
			  <th></th>
			  <td><input name="pass2" type="password" id="pass2" size="15" maxlength="100" /></td>
			</tr>
			</table>
			</fieldset>
			<?php endif; ?>
			<p class="submit right">
			  <input type="submit" name="Submit" value="<?php echo attribute_escape( __('Update Profile') ); ?>" />
			</p>
			</form>
			<form method="post" action="<?php profile_tab_link($user->ID, 'edit');  ?>">
			<p class="submit left">
			<?php bb_nonce_field( 'edit-profile_' . $user->ID ); ?>
			<?php user_delete_button(); ?>
			</p>
			</form>
		</div>
		
		<div class="sidebar">
			<ul>
				<li id="page-info">
					<div class="info">
						<a href="<?php echo get_favorites_rss_link(); ?>"><img src="<?php echo bb_get_active_theme_uri () ?>image/feed.png" width="16" height="16" alt="Feed"/></a>
					</div>
					<h2><?php _e ('User Profile', 'guangzhou'); ?></h2>
					<p><?php printf (__('This is the profile for <strong>%s</strong>.', 'guangzhou'), get_user_name( $user->ID )); ?></p>
					<?php bb_profile_data(); ?>
				</li>
				<?php if ( is_bb_profile() ) : ?>
				<li>
					<h2><?php _e('Management', 'guangzhou'); ?></h2>
					<?php profile_menu(); ?>
				</li>
				<?php endif; ?>
			</ul>
		</div>
		<div class="clear"></div>
	</div>
</div>

<?php bb_get_footer(); ?>
