<?php // Do not delete these lines

if (!empty($_SERVER['SCRIPT_FILENAME']) AND 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die (__('Please do not load this page directly. Thanks!','atahualpa'));

if ( post_password_required() ) {
	_e('This post is password protected. Enter the password to view comments.','atahualpa');
	return;
}

global $bfa_ata;
// You can start editing below:
?>

<?php // If there are any comments
if ( have_comments() ) : ?>

	<a name="comments"></a><!-- named anchor for skip links -->
	<h3 id="comments"><?php // Comment Area Title
	comments_number(__('No comments yet to ', 'atahualpa'),
    __('1 comment to ', 'atahualpa'), __('% comments to ', 'atahualpa'));
	echo get_the_title(); ?></h3>

	<?php bfa_next_previous_comments_links('Above'); ?>

	<!-- Comment List -->
	<ul class="commentlist">
		
	<?php // Do this for every comment
	if ($bfa_ata['separate_trackbacks'] == "Yes") {

		wp_list_comments(array(
			'avatar_size'=>$bfa_ata['avatar_size'],
			'reply_text'=>__(' &middot; Reply','atahualpa'),
			'login_text'=>__('Log in to Reply','atahualpa'),
			'callback' => bfa_comments, 
			'type' => 'comment'
			));

		wp_list_comments(array(
			'avatar_size'=>$bfa_ata['avatar_size'],
			'reply_text'=>__(' &middot; Reply','atahualpa'),
			'login_text'=>__('Log in to Reply','atahualpa'),
			'callback' => bfa_comments, 
			'type' => 'pings'
			));

	} else {

		wp_list_comments(array(
			'avatar_size'=>$bfa_ata['avatar_size'],
			'reply_text'=>__(' &middot; Reply','atahualpa'),
			'login_text'=>__('Log in to Reply','atahualpa'),
			'callback' => bfa_comments, 
			'type' => 'all'
			));

	} ?>
	
	</ul>
	<!-- / Comment List -->

	<?php bfa_next_previous_comments_links('Below'); ?>

<?php else : // If there are NO comments  ?>

	<?php // If comments are open, but there are no comments:
	if ('open' == $post->comment_status) : ?>
		<!-- .... -->

	<?php else : // If comments are closed: ?>

		<?php echo $bfa_ata['comments_are_closed_text']; ?>

	<?php endif; ?>

<?php endif; // END of "If there are NO comments" ?>

<?php // If comments are open
if ('open' == $post->comment_status) : ?>


	<?php // If Login is required and User is not logged in 
	if ( get_option('comment_registration') && !$user_ID ) : ?>

	<p><?php printf(__('You must be %slogged in</a> to post a comment.', 'atahualpa'),
    '<a href="' . get_option('siteurl') . '/wp-login.php?redirect_to=' .
    urlencode(get_permalink()) . '">')?></p>

	<?php else : // If Login is not required, or User is logged in ?>
		
		<!-- Comment Form -->
		<div id="respond">
		
		<a name="commentform"></a><!-- named anchor for skip links -->
		<h3 class="reply"><?php comment_form_title($noreplytext = __('Leave a Reply','atahualpa'), 
		$replytext = __('Leave a Reply to %s','atahualpa'), $linktoparent = TRUE); ?></h3>
	
		<div id="cancel-comment-reply">
		<?php cancel_comment_reply_link(__('Cancel','atahualpa')); ?>
		</div>
	
		<form action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php"
        method="post" id="commentform">

		<?php // If User is logged in
		if ( $user_ID ) : ?>
		
			<p><?php printf(__('Logged in as %s.', 'atahualpa'), '<a href="' .
            get_option('siteurl') . '/wp-admin/profile.php">' . $user_identity .
            '</a>')?>
			<a href="<?php echo wp_logout_url(get_permalink()); ?>" title="
            <?php _e('Log out of this account','atahualpa'); ?>">
			<?php _e('Logout &raquo;','atahualpa'); ?></a></p>

		<?php // If User is not logged in: Display the form fields "Name", "Email", "URL"
		else : ?>
		
			<p>
			<input class="text author" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="30" tabindex="1" />&nbsp;
			<label for="<?php _e('author','atahualpa'); ?>"> <strong>
            <?php _e('Name ','atahualpa'); echo "</strong>";
            if ($req) _e('(required)','atahualpa'); ?></label>
			</p>

			<p>
			<input class="text email" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="30" tabindex="2" />&nbsp;
			<label for="<?php _e('email','atahualpa'); ?>"> <strong>
            <?php _e('Mail</strong> (will not be published) ','atahualpa');
			if ($req) _e('(required)','atahualpa'); ?></label>
			</p>

			<p>
			<input class="text url" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="30" tabindex="3" />&nbsp;
			<label for="<?php _e('url','atahualpa'); ?>">
            <?php _e('Website','atahualpa'); ?></label>
			</p>
			
		<?php endif; ?>
	
		<?php // Display Quicktags or allowed XHTML Tags
		if (function_exists('lmbbox_comment_quicktags_display')) {

			echo "<p>"; lmbbox_comment_quicktags_display(); echo "</p>";

		} else {

			if ($bfa_ata['show_xhtml_tags'] == "Yes") {	?>
				<p class="thesetags clearfix">
                <?php printf(__('You can use %1$sthese HTML tags</a>','atahualpa'),
				'<a class="xhtmltags" href="#" onclick="return false;">'); ?></p>
				<div class="xhtml-tags"><p><code><?php echo allowed_tags(); ?>
                </code></p></div>

		<?php }	
		} ?>
	
		<!-- Comment Textarea -->
		<p><textarea name="comment" id="comment" rows="10" cols="10" tabindex="4"></textarea></p>
		<?php do_action('comment_form', $post->ID); ?>
		
		<!-- Submit -->
		<p><input name="submit" type="submit" class="button" id="submit"
        tabindex="5" value="<?php _e('Submit Comment','atahualpa'); ?>" />
		<?php comment_id_fields(); ?></p>
		
		</form>
		</div><!-- / respond -->
		<!-- / Comment Form -->

	<?php // End of: If Login is not required, or User is logged in
	endif; ?>
	
<?php // End of: If comments are open
endif; ?>