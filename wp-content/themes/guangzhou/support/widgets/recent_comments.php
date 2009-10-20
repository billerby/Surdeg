<?php
/**
 * Guangzhou recent comments widget
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

class GZ_Widget_Comments extends GZ_Widget {
	function display( $args ) {
		if ( is_home() ) {
			extract( $args );

			echo $before_widget;
			?>
<div class="info">
	<a title="<?php _e( 'Subscribe to this!', 'guangzhou' ); ?>" href="<?php bloginfo( 'comments_rss2_url' ); ?>"><img src="<?php bloginfo( 'template_url' ) ?>/image/feed.png" width="16" height="16" alt="Feed Big"/></a>
</div>
			<?php
			
			if ( $this->title )
				echo $before_title.$this->title.$after_title;
				
			$this->recent_comments( 4 );
			echo $after_widget;
		}
	}
	
	function recent_comments( $number = 10, $words = 12 )	{
		global $wpdb;

		$ignore = '';
		if ( $this->ignore )
			$ignore = "AND user_id NOT IN({$this->ignore})";
			
		$comments = $wpdb->get_results( "SELECT comment_author, comment_author_url, comment_ID, comment_post_ID, comment_content FROM $wpdb->comments WHERE comment_approved = '1' AND comment_type='' $ignore ORDER BY comment_date_gmt DESC LIMIT $number" );
		
		wp_cache_add( 'recent_comments', $comments, 'GZ' );
		if ( $comments ) {
			echo '<ul class="comments">';
			
			foreach ( $comments AS $comment ) {
			?>
			<li>
				<blockquote><?php echo $this->limit_words( $comment->comment_content, $words );?>
					&ndash;
					<cite>
						<a href="<?php echo get_permalink($comment->comment_post_ID) ?>#comment-<?php echo $comment->comment_ID ?>"><?php echo htmlspecialchars( $comment->comment_author ) ?></a>
					</cite>
				</blockquote>
			</li>
			<?php
			}
			
			echo '</ul>';
		}
	}
	
	function deep_strip( $text ) {
		$tmp = strip_tags( $text );
		
		while ( $tmp != $text ) {
			$text = $tmp;
			$tmp = strip_tags( $text );
		}
		
		return $text;
	}
	
	function limit_words( $text, $limit = 10, $characters = 100 ) {
		$text  = $this->deep_strip( $text );
		$parts = explode( ' ', $text );
		
		if ( count( $parts ) > $limit )
			$text = implode( ' ', array_splice( $parts, 0, $limit ) ).'...';
			
		return substr( $text, 0, $characters );
	}
	
	function load($data) {
		if ( isset( $data['title'] ) )
			$this->title = $data['title'];
			
		if ( isset( $data['ignore'] ) )
			$this->ignore = $data['ignore'];
	}
	
	function has_config() {
		return true;
	}
	
	function save( $data ) {
		return array( 'title' => $data['title'], 'ignore' => $data['ignore'] );
	}
	
	function description() {
		return __( 'Show recent comments', 'guangzhou' );
	}
	
	function config( $config, $pos ) {
		?>
<table>
	<tr>
		<th><?php _e( 'Title', 'guangzhou' ); ?>:</th>
		<td><input type="text" name="<?php echo $this->config_name( 'title', $pos ) ?>" value="<?php echo htmlspecialchars( isset( $config['title']  ) ? $config['title'] : '' ) ?>"/></td>
	</tr>
	<tr>
		<th><?php _e('Ignore users', 'guangzhou'); ?>:</th>
		<td><input type="text" name="<?php echo $this->config_name( 'ignore', $pos ) ?>" value="<?php echo htmlspecialchars( isset( $config['ignore']  ) ? $config['ignore'] : '' ) ?>"/></td>
	</tr>
</table>
		<?php
	}
}

?>