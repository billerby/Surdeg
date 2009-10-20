<?php

/**
 * Guangzhou random posts widget
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

class GZ_Widget_RandomPosts extends GZ_Widget {
	var $title = '';
	
	function random_posts($limit = 5) {
	  global $wpdb;

	  $posts = $wpdb->get_results( "SELECT * FROM $wpdb->posts WHERE post_status = 'publish' AND post_password = '' ORDER BY rand() DESC LIMIT 0,$limit" );
	  if ( $posts ) {
	    foreach ( $posts AS $post ) {
	      echo "<li>".'<a href="'.get_permalink( $post->ID ).'">'.htmlspecialchars( $post->post_title ).'</a></li>';
			}
	  }
	}
	
	function display( $args ) {
		extract( $args );

		if ( $this->title )
			echo $before_widget.$before_title.$this->title.$after_title;
			
		echo '<ul>';
		$this->random_posts( 10 );
		echo '</ul>';
		
		echo $after_widget;
	}
	
	function load( $data ) {
		if ( isset( $data['title'] ) )
			$this->title = $data['title'];
	}
	
	function description() {
		return __( 'Show random post', 'guangzhou' );
	}
	
	function has_config() {
		return true;
	}
	
	function save( $data ) {
		return array( 'title' => $data['title'] );
	}
	
	function config( $config, $pos ) {
		?>
		<table>
			<tr>
				<th><?php _e( 'Title', 'guangzhou' ); ?>:</th>
				<td><input type="text" name="<?php echo $this->config_name( 'title', $pos ) ?>" value="<?php echo htmlspecialchars( $config['title'] ) ?>"/></td>
			</tr>
		</table>
		<?php
	}
}
?>