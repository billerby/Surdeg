<?php
/**
 * Guangzhou search widget
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

class GZ_Widget_Search extends GZ_Widget {
	function display( $args ) {
		extract( $args );

		echo $before_widget;
		?>
<form method="get" id="searchform" action="<?php bloginfo( 'home' ); ?>/">
	<input class="text" type="text" value="<?php the_search_query(); ?>" name="s" id="s" />
	<input class="button-secondary" type="submit" id="searchsubmit" value="<?php _e( 'Search', 'guangzhou' ); ?>" />
</form>
		<?php
		echo $after_widget;
	}
	
	function description() {
		return __( 'Guangzhou search box', 'guangzhou' );
	}
}

?>