<?php
/**
 * Guangzhou display category widget
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

class GZ_Widget_Categories extends GZ_Widget {
	var $title      = '';
	var $exclude    = '';
	var $nested     = true;
	
	function display( $args ) {
		extract( $args );
		
		echo $before_widget;
		
		if ( $this->title )
			echo $before_title.$this->title.$after_title; 

		$cat_args = 'orderby=name&child_of=0&show_count=0&hierarchical='.( $this->nested ? 1 : 0 );
		if ( $this->exclude )
			$cat_args .= '&exclude='.$this->exclude;
			
		$cat_args .= '&title_li=';
		?>
		<ul>
			<?php wp_list_categories( $cat_args ); ?>
		</ul>
		<?php

		echo $after_widget;
	}
	
	function load( $data ) {
		if ( isset( $data['title'] ) )
			$this->title = $data['title'];

		if ( isset( $data['exclude'] ) )
			$this->exclude = $data['exclude'];
			
		if ( isset( $data['nested'] ) )
			$this->nested = $data['nested'];
	}
	
	function description() {
		return __( 'Show categories', 'guangzhou' );
	}
	
	function has_config() {
		return true;
	}
	
	function save( $data ) {
		return array( 'title' => $data['title'], 'exclude' => $data['exclude'], 'nested' => isset( $data['nested'] ) ? true : false );
	}
	
	function config( $config, $pos ) {
		?>
		<table>
			<tr>
				<th><?php _e( 'Title', 'guangzhou' ); ?>:</th>
				<td><input type="text" name="<?php echo $this->config_name( 'title', $pos ) ?>" value="<?php echo htmlspecialchars( $config['title'] ) ?>"/></td>
			</tr>
			<tr>
				<th><?php _e( 'Exclude', 'guangzhou' ); ?>:</th>
				<td><input type="text" name="<?php echo $this->config_name( 'exclude', $pos ) ?>" value="<?php echo htmlspecialchars( $config['exclude'] ) ?>"/></td>
			</tr>
			<tr>
				<th><?php _e( 'Hierarchical', 'guangzhou' ); ?>:</th>
				<td><input type="checkbox" name="<?php echo $this->config_name('nested', $pos ) ?>" <?php if ( $config['nested'] ) echo ' checked="checked"' ?>/></td>
			</tr>
		</table>
		<?php
	}
}
?>