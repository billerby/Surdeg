<?php
/**
 * Comment functionality
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

class GZ_Comments {
	function GZ_Comments() {
		add_filter( 'comment_post_redirect', array( &$this, 'comment_post_redirect' ), 10, 2 );
			
		//add_filter( 'get_comments_number', array( &$this, 'comments_number' ) );
	}
	
	function show_pings() {
		global $gz_theme;
		
		$options = $gz_theme->get_options();
		if ( $options['show_pings'] )
			return true;
		return false;
	}
	
	function comment_post_redirect( $location, $comment) {
		return get_permalink( $comment->comment_post_ID ).'#comments';
	}
	
	function load() {
		global $multipage, $page, $pings;

		if ( $page == 1 )
				comments_template( '', true );
		else {
			?>
			<div id="comments">
				<div class="page">
					<h3><?php _e( 'Comments', 'guangzhou' ); ?></h3>
					<p><?php printf( __( 'Comments are shown on the <a href="%s">first page</a>.', 'guangzhou' ), post_permalink() ); ?></p>
				</div>
			</div>
			<?php
		}
	}

	function is_paged() {
		$ppage = get_query_var( 'comments_per_page' );
		$num   = get_comments_number();

		if ( $num > $ppage)
			return true;
		return false;
	}
	
	function pings_number() {
		global $wp_query;
		
		return count( $wp_query->comments_by_type['pings'] );
	}
	
	function comments_number() {
		global $wp_query;

		return count( $wp_query->comments_by_type['comment'] );
	}
	
	// Adjust comments number so comments_number() function is correct
	function comments_title() {
		global $wp_query;
		
		$ppage = get_query_var( 'comments_per_page' );
		$num   = get_comments_number();

		// Subtract pings from this number
		$num -= count( $wp_query->comments_by_type['pings']);
		
		if ( $num > $ppage )
			echo sprintf( __( 'Comments (page %d of %d)', 'guangzhou' ), get_query_var( 'cpage' ), get_comment_pages_count() );
		else if ( $num > 0 )
			echo sprintf( _n( '%d Comment', '%d Comments', $num, 'guangzhou' ), $num );
		else
			_e( 'No comments', 'guangzhou' );
	}
	
	function has_comments() {
		global $post;
		
		if ( ( is_single() || is_page() ) && $post->comment_status == 'open' )
			return true;
		return false;
	}
	
	function get_ping_text( $comment) {
		if ( preg_match( '@//(.*?)(?::\d+|/+)@', $comment->comment_author_url, $matches ) > 0 )
			$text = str_replace( 'www.', '', $matches[1] );
		else
			$text = $comment->comment_author;
		
		return $text;
	}
	
	function comment_count() {
		global $post;
		
		if ( $post->comment_status != 'closed' ) {
			global $wpdb;
			
			$comments = $wpdb->get_var( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_post_ID='{$post->ID}' AND comment_type='' AND comment_approved='1'" );
			$pings    = $wpdb->get_var( "SELECT COUNT(comment_ID) FROM $wpdb->comments WHERE comment_post_ID='{$post->ID}' AND comment_type!='' AND comment_type!='gone' AND comment_approved='1'" );

			echo '<p>';
			
			if ( $pings > 0 && $comments > 0) {
				printf( _n( 'There is <strong>%d comment</strong>', 'There are <strong>%d comments</strong>', $comments, 'guangzhou' ), $comments );
				printf( _n( ' and <strong>%d ping</strong>.', ' and <strong>%d pings</strong>.', $pings, 'guangzhou' ), $pings );
			}
			else if ( $comments > 0)
				printf( _n( 'There is <strong>%d comment</strong>.', 'There are <strong>%d comments</strong>.', $comments, 'guangzhou' ), $comments );
			else if ( $pings > 0)
				printf( _n( 'There is <strong>%d ping</strong>.', 'There are <strong>%d pings</strong>.', $pings, 'guangzhou' ), $pings );
			else
				echo __( 'There are <strong>no comments</strong>.', 'guangzhou' );
				
			echo __( ' You can keep track of all comments with the ', 'guangzhou' );
			post_comments_feed_link( 'RSS' );
			echo __( ' feed.</p>', 'guangzhou' );
		}
	}
	
	function author( $comment) {
		if ( $comment->user_id > 0) {
			$user = get_userdata( $comment->user_id );
			
			if ( isset( $user->wp_capabilities ) && count( $user->wp_capabilities ) > 0) {
				$roles = array_keys( $user->wp_capabilities );
				$role  = $roles[0];
				
				if ( $role == 'administrator' )
					$role = 'author';
				
				echo '( '.$role.' )';
			}
		}
	}
}

class GZ_Comment_Walker extends Walker_Comment {
	var $count = 0;
	
	function start_el( &$output, $comment, $depth, $args ) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;

		if ( !empty( $args['callback']) ) {
			call_user_func( $args['callback'], $comment, $args, $depth);
			return;
		}

		if ( $this->count == 0)
			$this->count = get_comments_number();
			
		$GLOBALS['comment'] = $comment;
		extract( $args, EXTR_SKIP);

		if ( 'div' == $args['style'] ) {
			$tag = 'div';
			$add_below = 'comment';
		} else {
			$tag = 'li';
			$add_below = 'div-comment';
		}
?>
		<<?php echo $tag ?> <?php comment_class() ?> id="comment-<?php comment_ID() ?>">
		<?php if ( 'ul' == $args['style'] ) : ?>
		<div id="div-comment-<?php comment_ID() ?>">
		<?php endif; ?>
<?php if ( $comment->comment_approved == '0' ) : ?>
		<em><?php _e( 'Your comment is awaiting moderation.' ) ?></em>
		<br />
<?php endif; ?>

		<div class="meta">
			<div class="gravatar vcard">
				<?php if ( $args['avatar_size'] != 0) echo get_avatar( $comment, $args['avatar_size'] ); ?>
			</div>

			<div class="info"><a href="<?php echo get_comment_link() ?>">#<?php comment_ID();?></a></div>
			<cite><?php comment_author_link(); GZ_Comments::author( $comment) ?> :</cite>
				<p>
				<?php comment_date( 'M j, Y' ) ?> <?php comment_time(); ?> |
				<?php comment_reply_link(array_merge( $args, array( 'add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
					
				<?php edit_comment_link( 'Edit', ' | ', '' ); ?>
			</p>
		</div>
		
		<?php comment_text() ?>

		<?php if ( 'ul' == $args['style'] ) : ?>
		</div>
		<?php endif; ?>
<?php
	}
}

class GZ_Empty_Walker extends Walker_Comment {
	function start_el(&$output, $comment, $depth, $args) {
	}
}

class GZ_Ping_Walker extends Walker_Comment {
	var $count = 0;
	
	function start_el(&$output, $comment, $depth, $args) {
		$depth++;
		$GLOBALS['comment_depth'] = $depth;

		if ( !empty( $args['callback']) ) {
			call_user_func( $args['callback'], $comment, $args, $depth);
			return;
		}

		if ( $this->count == 0)
			$this->count = get_comments_number();
			
		$GLOBALS['comment'] = $comment;
		extract( $args, EXTR_SKIP);
		echo get_comment_author_url_link(GZ_Comments::get_ping_text( $comment)).', ';
	}
}

$gz_comments = new GZ_Comments();
?>