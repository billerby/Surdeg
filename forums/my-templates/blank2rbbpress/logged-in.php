<div class="loggedin">
	<p><?php printf(__('Welcome, <em>%1$s</em>!'), bb_get_profile_link(bb_get_current_user_info( 'name' )));?>
	<?php bb_admin_link( 'before= <br/>' );?>
	| <?php bb_logout_link(); ?></p>
</div>
