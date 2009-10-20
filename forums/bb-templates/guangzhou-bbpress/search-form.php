<form action="<?php bb_option('uri'); ?>search.php" method="get">
	<input type="text" class="text" size="20" maxlength="100" name="q" value="<?php echo attribute_escape( $q ); ?>" />
	<input class="button-secondary" type="submit" value="<?php echo attribute_escape( __('Search') ); ?>" />
</form>
