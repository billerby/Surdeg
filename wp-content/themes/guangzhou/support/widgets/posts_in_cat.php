<?php
/**
 * Guangzhou display posts in category widget
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

class GZ_Widget_PostsInCat extends GZ_Widget {
	var $title      = '';
	var $categories = '';
	var $limit      = 10;
	
	function load( $data ) {
		if ( isset( $data['title'] ) )
			$this->title = $data['title'];

		if ( isset( $data['categories'] ) )
			$this->categories = $data['categories'];

		if ( isset( $data['limit'] ) )
			$this->limit = $data['limit'];
	}
	
	function has_config() {
		return true;
	}
	
	function save( $data ) {
		return array( 'title' => $data['title'], 'categories' => $data['categories'], 'limit' => $data['limit'] );
	}
	
	function config( $config, $pos ) {
		?>
		<table>
			<tr>
				<th><?php _e( 'Title', 'guangzhou' ); ?>:</th>
				<td><input type="text" name="<?php echo $this->config_name( 'title', $pos ) ?>" value="<?php echo htmlspecialchars( $config['title'] ) ?>"/></td>
			</tr>
			<tr>
				<th><?php _e( 'Category', 'guangzhou' ); ?>:</th>
				<td><input type="text" name="<?php echo $this->config_name( 'categories', $pos ) ?>" value="<?php echo htmlspecialchars( $config['categories'] ) ?>"/></td>
			</tr>
			<tr>
				<th><?php _e( 'Limit', 'guangzhou' ); ?>:</th>
				<td><input type="text" name="<?php echo $this->config_name( 'limit', $pos ) ?>" value="<?php echo htmlspecialchars( $config['limit'] ) ?>"/></td>
			</tr>
		</table>
	 <p><?php _e( '(separate multiple categories with comma)', 'guangzhou' ); ?></p>
		<?php
	}

	function recent_posts_in_category( $categories, $fulldisplay = true, $limit = 10 ) {
		$limit = intval( $limit );
		
		if ( $limit == 0 )
			$limit = 10;
			
		global $wpdb, $wp_db_version;
		if ( $wp_db_version > 6000 ) {
			$objects = array();
			
			foreach ( $categories AS $cat )
				$objects = array_merge( $objects, get_objects_in_term( $cat, 'category' ) );
				
			$rows = $wpdb->get_results( "SELECT $wpdb->posts.ID,$wpdb->posts.post_title,$wpdb->posts.post_content,$wpdb->posts.post_excerpt FROM $wpdb->posts WHERE ID IN(".implode( ',', $objects ).") ORDER BY post_date DESC LIMIT 0,$limit" );
		}
		else {
			$catstr = '';
			if ( count( $categories ) > 0 ) {
				foreach ( $categories AS $cat )
					$cats[] = "$wpdb->post2cat.category_id=$cat";
				
				$catstr = implode( " OR ", $cats );
			}
		
			$rows = $wpdb->get_results( "SELECT $wpdb->posts.ID,$wpdb->posts.post_title,$wpdb->posts.post_content,$wpdb->posts.post_excerpt FROM $wpdb->posts,$wpdb->post2cat WHERE $wpdb->posts.ID=$wpdb->post2cat.post_id AND($catstr) ORDER BY $wpdb->posts.post_date DESC LIMIT 0,$limit" );
			wp_cache_add( 'recent_posts_in_category', $comments, 'GZ' );
		}
		
		if ( $rows ) {
			echo '<ul>';
			
			foreach ( $rows AS $post ) {
			?>
			<li>
				<a href="<?php echo get_permalink( $post->ID ) ?>"><?php echo htmlspecialchars( $post->post_title ) ?></a>
				<?php if ( $fulldisplay ) echo $post->post_excerpt;?>
			</li>
			<?php
			}
			
			echo '</ul>';
		}
	}

	function description() {
		return __( 'Show posts in categories', 'guangzhou' );
	}
	
	function display( $args ) {
		$categories = explode( ',', $this->categories );

		extract( $args );

		echo $before_widget;
		if ( $this->title )
			echo $before_title.$this->title.$after_title;
			
		$this->recent_posts_in_category( $categories, false, $this->limit );
		?>
		<div class="info">
			<small><a title="<?php _e( 'Subscribe to this!', 'guangzhou' ); ?>" href="<?php get_category_rss_link( true, $categories[0], '' ); ?>">[<?php _e( 'more', 'guangzhou' )?>]</a></small>
		</div>
		<?php
		echo $after_widget;
	}
}

?>