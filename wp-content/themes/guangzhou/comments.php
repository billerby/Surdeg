<?php 
if ( !empty( $_SERVER['SCRIPT_FILENAME'] ) && 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) )
	die( __( 'Please do not load this page directly. Thanks!', 'guangzhou' ) );

if ( post_password_required() )
{
	echo __( 'This post is password protected. Enter the password to view comments.', 'guangzhou' );
	return;
}
?>

<?php if ( GZ_Comments::comments_number() > 0 || $post->comment_status == 'open' ) : ?>
<div id="comments">
	<div class="pagewrap">
<?php endif;?>

<?php if ( $post->comment_status == 'open' ) : ?>
	<div class="info">
		<a href="#respond" title="Skip all the comments"><?php _e( 'Reply now', 'guangzhou'); ?></a> | 
		<?php post_comments_feed_link( '<img src="'.get_bloginfo( 'template_url' ).'/image/feed.png" width="16" height="16" alt="Feed"/>' ); ?>
	</div>
<?php endif; ?>

<?php if ( GZ_Comments::comments_number() > 0 ) : ?>
	<h3><?php echo GZ_Comments::comments_title();?></h3>

	<?php if ( GZ_Comments::is_paged() ) :?>
		<div class="tablenav">
			<div class="tablenav-pages">
				<?php _e( 'Page', 'guangzhou' ) ?>: <?php	paginate_comments_links( array( 'mid_size' => 4, 'end_size' => 4, 'prev_next' => false ) ); ?>
			</div>
		</div>
	<?php endif; ?>

	<ol>
		<?php wp_list_comments( array( 'walker' => new GZ_Comment_Walker, 'avatar_size' => 40, 'type' => 'comment' ) ); ?>
	</ol>

	<?php if ( GZ_Comments::is_paged() ) :?>
	<div class="tablenav">
		<div class="tablenav-pages">
			<?php _e( 'Page', 'guangzhou' ) ?>: <?php	paginate_comments_links( array( 'mid_size' => 4, 'end_size' => 4, 'prev_next' => false ) ); ?>
		</div>
	</div>
	<?php endif; ?>
<?php endif; ?>
	
<?php if ( GZ_Comments::show_pings() && GZ_Comments::pings_number() > 0 ) : ?>
<h3><?php _e( 'Pings &amp; Trackbacks', 'guangzhou' ) ?></h3>

<p><?php wp_list_comments( array( 'walker' => new GZ_Ping_Walker, 'type' => 'pings', 'per_page' => 0 ) ); ?></p>
<?php endif; ?>

<?php if ( 'open' == $post->comment_status ) : ?>
	<h3><?php comment_form_title(); ?></h3>
	
	<?php if ( get_option( 'comment_registration' ) && !$user_ID ) : ?>
		<p><?php printf( __( 'You must be <a href="%1s/wp-login.php?redirect_to=%2s">logged in</a> to post a comment.', 'guangzhou' ), get_option( 'siteurl' ), the_permalink() ); ?></p>
	<?php else : ?>

	<div id="respond">
		<form action="<?php echo get_option( 'siteurl' ); ?>/wp-comments-post.php" method="post" id="commentform">
			<?php comment_id_fields(); ?>
			
				<?php if ( $user_ID ) : ?>
				<p><?php printf( __( 'Logged in as <a href="%1s/wp-admin/profile.php">%2s</a>. <a href="%3s/wp-login.php?action=logout" title="Log out of this account">Logout &raquo;</a>', 'guangzhou' ), get_option( 'siteurl' ), $user_identity, get_option( 'siteurl' ) ); ?></p>
				<?php else : ?>

				<br/>

				<p>
					<input class="text" type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="40" tabindex="1" />
					<label for="author"><small><?php _e( 'Name', 'guangzhou' ); ?> <?php if ($req) _e ( '(required)', 'guangzhou' ) ?></small></label>
				</p>

				<p>
					<input class="text" type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="40" tabindex="2" />
					<label for="email"><small><?php _e( 'Mail (will not be published)', 'guangzhou' ); ?> <?php if ( $req ) _e ( '(required)', 'guangzhou' ); ?></small></label>
				</p>

				<p>
					<input class="text" type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="40" tabindex="3" />
					<label for="url"><small><?php _e( 'Website', 'guangzhou' ); ?></small></label>
				</p>

				<?php endif; ?>

			<p><small><strong><?php _e( 'XHTML', 'guangzhou' ); ?>:</strong> <?php printf( __( 'You can use these tags: %s', 'guangzhou' ), allowed_tags() ); ?></small></p>

			<p><textarea class="text" name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

			<p>
				<div id="cancel-comment-reply">
					<input class="button-primary" name="submit" type="submit" id="submit" tabindex="5" value="<?php _e( 'Submit Comment', 'guangzhou'); ?>" />
					<small><?php cancel_comment_reply_link( __( '| Cancel Reply', 'guangzhou' ) ) ?></small>
				</div>
			</p>

			<?php do_action( 'comment_form', $post->ID ); ?>
		</form>
	</div>
	<?php endif;  ?>

<?php else : ?>
	<?php do_action( 'comment_form', $post->ID ); ?>
<?php endif; ?>

<?php if ( count( $comments ) > 0 || $post->comment_status == 'open' ) : ?>
	</div>
</div>
<?php else : ?>

<div id="pageborder"></div>
	
<?php endif;?>
