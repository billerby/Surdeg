<?php

class GZ {
	function GZ() {
		add_action( 'bb_init', array( &$this, 'init' ), 1 );
	}
	
	function init() {
		remove_action( 'bb_init', 'bb_register_default_views' );
		
		bb_register_view( 'no-replies', __( 'Without Replies' ), array( 'post_count' => 1, 'started' => '<' . gmdate( 'YmdH', time() - 7200 ) ) );
		bb_register_view( 'untagged'  , __( 'Without Tags' )   , array( 'tag_count'  => 0 ) );

		add_filter('style_loader_src', array (&$this, 'style_loader_src'));
		add_action('bb_head', 'wp_print_styles');	

		add_filter( 'bb_get_theme_uri', array( &$this, 'bb_get_theme_uri' ) );
		
		wp_enqueue_style( 'guangzhou', bb_get_stylesheet_uri(), array (), $this->version (), 'all');
		wp_enqueue_style( 'guangzhou-skin', bb_get_active_theme_uri().'skins/brown/style.css', array ('guangzhou'), $this->version (), 'all');
	}
	
	function bb_get_theme_uri( $url ) {
		if ( substr( $url, -1, 1 ) == '/' )
			return rtrim( $url, '/' ).'/';
		return $url;
	}
	
	function style_loader_src ($src) {
		return str_replace( 'guangzhou//', 'guangzhou/', $src);
	}
	
	function version() {
		return '0.1';
	}

	function icon( $comment ) {
		if ( bb_get_option( 'avatars_show' ) ) {
			echo '<div class="gravatar">';
			
			$user = bb_get_user( $comment->poster_id );
			if ( $user->user_url )
	    	echo '<a href="'.$user->user_url.'">';

			echo bb_get_avatar( $user->user_email, 40 );

			if ( $user->user_url )
				echo '</a>';
			
			echo '</div>';
		}
	}

	function post_edit_link( $post_id = 0 )	{
		$bb_post = bb_get_post( get_post_id( $post_id ) );
		if ( bb_current_user_can( 'edit_post', $bb_post->post_id ) )
			echo '<a href="' . attribute_escape( apply_filters( 'post_edit_uri', bb_get_option('uri') . 'edit.php?id=' . $bb_post->post_id, $bb_post->post_id ) ).'"><img src="'.bb_get_active_theme_uri ().'/image/edit.png" width="16" height="16" alt="Edit"/></a>';
	}
	
	function post_edit_text( $post_id = 0 )	{
		$bb_post = bb_get_post( get_post_id( $post_id ) );
		if ( bb_current_user_can( 'edit_post', $bb_post->post_id ) )
			$parts[] = ' | <a href="' . attribute_escape( apply_filters( 'post_edit_uri', bb_get_option('uri') . 'edit.php?id=' . $bb_post->post_id, $bb_post->post_id ) ).'">Edit</a>';
			
		if (bb_current_user_can( 'delete_post', $bb_post->post_id ) )
		{
			if ( 1 == $bb_post->post_status )
				$parts[] = "<a href='" . attribute_escape( bb_nonce_url( bb_get_option('uri') . 'bb-admin/delete-post.php?id=' . $bb_post->post_id . '&status=0&view=all', 'delete-post_' . $bb_post->post_id ) ) . "' onclick='return confirm(\" ". js_escape( __('Are you sure you wanna undelete that?') ) ." \");'>". __('Undelete') ."</a>";
			else
				$parts[] = "<a href='" . attribute_escape( bb_nonce_url( bb_get_option('uri') . 'bb-admin/delete-post.php?id=' . $bb_post->post_id . '&status=1', 'delete-post_' . $bb_post->post_id ) ) . "' onclick='return ajaxPostDelete(" . $bb_post->post_id . ", \"" . get_post_author( $post_id ) . "\");'>". __('Delete') ."</a>";
		}

		if ( count( $parts ) > 0 )
			echo implode( ' | ', $parts );
	}
	
	function topic_delete_link( $args = '' ) {
		$defaults = array( 'id' => 0, 'before' => '[', 'after' => ']' );
		extract(wp_parse_args( $args, $defaults ), EXTR_SKIP);
		$id = (int) $id;

		$topic = get_topic( get_topic_id( $id ) );

		if ( !$topic || !bb_current_user_can( 'delete_topic', $topic->topic_id ) )
			return;

		if ( 0 == $topic->topic_status )
			echo "$before<a href='" . attribute_escape( bb_nonce_url( bb_get_option('uri') . 'bb-admin/delete-topic.php?id=' . $topic->topic_id , 'delete-topic_' . $topic->topic_id ) ) . "' onclick=\"return confirm('" . js_escape( __('Are you sure you wanna delete that?') ) . "')\"><img src=\"".bb_get_active_theme_uri ().'image/delete.png" width="16" height="16" alt="Delete"/></a>'.$after;
		else
			echo "$before<a href='" . attribute_escape( bb_nonce_url( bb_get_option('uri') . 'bb-admin/delete-topic.php?id=' . $topic->topic_id . '&view=all', 'delete-topic_' . $topic->topic_id ) ) . "' onclick=\"return confirm('" . js_escape( __('Are you sure you wanna undelete that?') ) . "')\"><img src=\"".bb_get_active_theme_uri ().'image/delete.png" width="16" height="16" alt="Delete"/></a>'.$after;
	}
	
	function can_edit( $bb_post ) {
		if ( bb_current_user_can( 'edit_post', $bb_post->post_id ) )
			return true;
		return false;
	}
	
	function can_delete() {
		if ( bb_current_user_can( 'delete_topic', get_topic_id() ) )
			return true;
		return false;
	}
	
	function breadcrumbs() {
		$page = '';
		if ( bb_get_location() == 'login-page' )
			$page = __( 'Log in', 'guangzhou' );
		elseif ( is_forum() )
			$page = get_forum_name();
		elseif ( is_bb_tags() && get_tag_name() != '' )
			$page = '<a href="'.bb_get_tag_page_link().'">'.__( 'Tags' ).'</a> &raquo; '.get_tag_name();
		elseif ( is_topic() ) {
			if ( get_forum_name() )
				$page = '<a href="'.get_forum_link().'">'.get_forum_name().'</a>';
		}
		
		if ( $page )
			$page = '| '.$page;
			
		return '<a href="'.bb_get_option( 'uri' ).'">'.bb_get_option( 'name' ).'</a> '.$page;
	}
	
	function excerpt( $str ) {
		$str  = strip_tags( $str );
		$text = mb_substr( $str, 0, 70 );
		return $text.( strlen( $str ) > 70 ? '&hellip;' : '' );
	}
	
	function tag_form( $args = null ) {
		$defaults = array( 'topic' => 0, 'submit' => __('Add'), 'list_id' => 'tags-list' );
		$args = wp_parse_args( $args, $defaults );
		extract( $args, EXTR_SKIP );

		if ( !$topic = get_topic( get_topic_id( $topic ) ) )
			return false;

		if ( !bb_current_user_can( 'edit_tag_by_on', bb_get_current_user_info( 'id' ), $topic->topic_id ) )
			return false;
	?>

	<form id="tag-form" method="post" action="<?php bb_uri('tag-add.php', null, BB_URI_CONTEXT_FORM_ACTION + BB_URI_CONTEXT_BB_ADMIN); ?>" class="add:<?php echo attribute_escape( $list_id ); ?>:">
		<p>
			<input name="tag" class="text" type="text" id="tag" />
			<input type="hidden" name="id" value="<?php echo $topic->topic_id; ?>" />
			<?php bb_nonce_field( 'add-tag_' . $topic->topic_id ); ?>
			<input type="submit" class="button-secondary" name="submit" id="tagformsub" value="<?php echo attribute_escape( $submit ); ?>" />
		</p>
	</form>

	<?php
	}
	
	function topic_move_dropdown( $id = 0 ) {
		$topic = get_topic( get_topic_id( $id ) );
		if ( !bb_current_user_can( 'move_topic', $topic->topic_id ) )
			return;

		$dropdown = bb_get_forum_dropdown( array(
			'callback' => 'bb_current_user_can',
			'callback_args' => array('move_topic', $topic->topic_id),
			'selected' => $topic->forum_id
		) );

		if ( !$dropdown )
			return;

		echo '<form id="topic-move" method="post" action="' . bb_get_uri('bb-admin/topic-move.php', null, BB_URI_CONTEXT_FORM_ACTION + BB_URI_CONTEXT_BB_ADMIN) . '">' . "\n\t";
		echo "<input type='hidden' name='topic_id' value='$topic->topic_id' />\n\t";
		echo $dropdown;
		bb_nonce_field( 'move-topic_' . $topic->topic_id );
		echo "<input class='button-secondary' type='submit' name='Submit' value='". __('Move') ."' />\n</form>";
	}
}

$gz = new GZ ();
?>