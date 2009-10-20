<div class="wrap">
	<?php screen_icon(); ?>
	<?php $this->render_admin( 'annoy' );?>
	
	<h2><?php _e( 'Guangzhou | Options', 'guangzhou' ); ?></h2>

	<form action="<?php echo $_SERVER['REQUEST_URI'] ?>" method="post" accept-charset="utf-8">
		<h3><?php _e( 'Sizes', 'guangzhou' ); ?></h3>
		<p><?php _e( 'Physical dimensions of various parts of the page.', 'guangzhou' ); ?></p>
		<table class="form-table">
			<tr>
				<th><?php _e( 'Page width', 'guangzhou' ); ?>:</th>
				<td>
					<input type="text" size="5" name="page_width" value="<?php echo $options['page_width'] ?>"/> <?php _e( 'pixels', 'guangzhou' ); ?>
				</td>
			</tr>
		</table>

	
		<h3><?php _e( 'Colour', 'guangzhou' ); ?></h3>
		<p><?php _e( 'Skins allow you to apply different colours to the theme.', 'guangzhou' ); ?></p>
		<table class="form-table">
			<tr>
				<th><?php _e( 'Main Skin', 'guangzhou' ); ?>:</th>
				<td>
					<select name="skin">
						<?php foreach ( $skins AS $id => $skin ) : ?>
							<option value="<?php echo $id ?>"<?php if ( $options['skin'] == $id ) echo ' selected="selected"' ?>><?php echo htmlspecialchars( $skin ) ?></option>
						<?php endforeach; ?>
					</select>
				</td>
			</tr>
			<tr>
				<th valign="top"><?php _e( 'URL-specific skins', 'guangzhou' ); ?>:</th>
				<td>
					<textarea name="skin_url" style="width: 95%" rows="6"><?php echo htmlspecialchars( $options['skin_url'] ); ?></textarea><br/>
					<p><span class="sub"><?php _e( 'Separate each URL on a new line.  The format is: <code>URL=skin</code>, where URL will match any substring', 'guangzhou' ); ?></span></p>
					<p><span class="sub"><?php _e( 'Available skins: ', 'guangzhou' ); ?><?php echo implode( ', ', array_keys( $skins ) ); ?></span></p>
				</td>
			</tr>
		</table>

		<input class="button-primary" type="submit" name="save" value="<?php _e( 'Save Changes', 'guangzhou' ); ?>"/>
	</form>
</div>
