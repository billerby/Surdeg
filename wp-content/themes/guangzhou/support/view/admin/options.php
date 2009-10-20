<div class="wrap">
	<?php screen_icon(); ?>
	<?php $this->render_admin( 'annoy' );?>
	
	<h2><?php _e( 'Guangzhou | Options', 'guangzhou' ); ?></h2>

	<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
			<h3><?php _e( 'Menus', 'guangzhou' ); ?></h3>
			
			<p><?php _e("Here you can specify the menus that appear in the header and footer.  Menu's are taken from your <a href='edit-link-categories.php'>link categories</a>.", 'guangzhou' ); ?></p>
			
			<table class="form-table">
				<?php if ( count( $menus ) > 0 ) : ?>
				<tr>
					<th><?php _e( 'Main menu', 'guangzhou' ); ?>:</th>
					<td>
						<select name="main_menu">
							<?php echo $this->select( $menus, $options['main_menu'] ); ?>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Top menu', 'guangzhou' ); ?>:</th>
					<td>
						<select name="top_menu">
							<?php echo $this->select( $menus, $options['top_menu'] ); ?>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Bottom menu', 'guangzhou' ); ?>:</th>
					<td>
						<select name="bottom_menu">
							<?php echo $this->select( $menus, $options['bottom_menu'] ); ?>
						</select>
					</td>
				</tr>
				<?php endif; ?>
				<tr>
					<th><?php _e( 'Login menu', 'guangzhou' ); ?>:</th>
					<td>
						<label><input type="checkbox" name="login_menu"<?php if ( isset( $options['login_menu'] ) && $options['login_menu'] ) echo ' checked="checked"' ?>/>
						<span class="sub"><?php _e( 'Show the login options in the top menu', 'guangzhou' ); ?></span></label>
					</td>
				</tr>
			</table>

			<h3><?php _e( 'Post Options', 'guangzhou' ); ?></h3>
			<p><?php _e( 'These options relate to how posts are shown.', 'guangzhou' ); ?></p>
			
			<table class="form-table">
				<tr>
					<th><?php _e( 'Latest posts', 'guangzhou' ); ?>:</th>
					<td>
						<select name="latest">
							<?php for ( $x = 1; $x < 10; $x++ ) : ?>
							<option value="<?php echo $x ?>"<?php if ( $options['latest'] == $x ) echo ' selected="selected"' ?>><?php echo $x ?></option>
							<?php endfor; ?>
						</select>
						
						<strong><?php _e( 'Recent posts', 'guangzhou' ); ?>:</strong>
						<select name="recent">
							<?php for ( $x = 0; $x < 20; $x += 2 ) : ?>
							<option value="<?php echo $x ?>"<?php if ( $options['recent'] == $x ) echo ' selected="selected"' ?>><?php echo $x ?></option>
							<?php endfor; ?>
						</select>
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Author posts', 'guangzhou' ); ?>:</th>
					<td><input type="text" name="author_posts" size="5" value="<?php echo $options['author_posts'] ?>"/></td>
				</tr>
				<tr>
					<th><?php _e( 'Exclude from home', 'guangzhou' ); ?>:</th>
					<td>
						<input type="text" size="40" name="exclude" value="<?php echo htmlspecialchars( $options['exclude'] ) ?>"/>
						<span class="sub"><?php _e( 'Category IDs to exclude from home page (comma separated)', 'guangzhou' ); ?></span>
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Show author', 'guangzhou' );?>:</th>
					<td>
						<label><input type="checkbox" name="author"<?php if (isset( $options['author'] ) && $options['author']) echo ' checked="checked"' ?>/>
						<span class="sub"><?php _e( 'Show post author and link to author page', 'guangzhou' ); ?></span></label>
					</td>
				</tr>
			</table>
		
			<h3><?php _e( 'Other Options', 'guangzhou' ); ?></h3>
			
			<table class="form-table">

				<tr>
					<th><?php _e( 'Show pings', 'guangzhou' ); ?>:</th>
					<td>
						<input type="checkbox" name="show_pings"<?php if ( isset( $options['show_pings'] ) && $options['show_pings'] ) echo ' checked="checked"' ?>/>
					</td>
				</tr>
				
				<tr>
					<th><?php _e( 'Copyright', 'guangzhou' ); ?>:</th>
					<td>
						<input type="text" size="40" name="copyright" value="<?php echo htmlspecialchars( $options['copyright'] ) ?>"/>
						<span class="sub"><?php _e( 'Shown in the footer (<code>%year%</code> = current year)', 'guangzhou' ); ?></span>
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Footer Logo', 'guangzhou' ); ?>:</th>
					<td>
						<input type="checkbox" name="footer_logo"<?php if ( $options['footer_logo'] ) echo ' checked="checked"' ?>/>
					</td>
				</tr>

				<tr>
					<th><?php _e( 'FeedBurner Email', 'guangzhou' ); ?>:</th>
					<td>
						<input class="text" type="text" size="40" name="feedemail" value="<?php echo htmlspecialchars( $options['feedemail'] ) ?>"/>
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Twitter', 'guangzhou' ); ?>:</th>
					<td>
						<input class="text" type="text" size="40" name="twitter" value="<?php echo htmlspecialchars( $options['twitter'] ) ?>"/>
						<span class="sub"><?php _e( 'Twitter link', 'guangzhou' );  ?></span>
					</td>
				</tr>
				<tr>
					<th><?php _e( 'Skip links', 'guangzhou' ); ?>:</th>
					<td>
						<label><input type="checkbox" name="skip_links"<?php if (isset( $options['skip_links'] ) && $options['skip_links'] ) echo ' checked="checked"' ?>/>
						<span class="sub"><?php _e( 'Include accessibility links', 'guangzhou' ); ?></span></label>
					</td>
				</tr>
			</table>
		<br/>
		<input class="button-primary" type="submit" name="save" value="<?php _e( 'Save Changes', 'guangzhou' ); ?>"/>
	</form>
</div>
