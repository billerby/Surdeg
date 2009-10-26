<div id="sidebar">

<div class="rightcontent">

<div class="formsection">
<?php login_form(); ?>
</div>

<?php if ( is_bb_profile() ) profile_menu(); ?>


<?php if ( $topic_id ) : ?>
<div id="topic-info-side">
<h2>About This Topic</h2>

<ul class="topicmeta">
	<li><?php printf(__('Started %1$s ago by %2$s'), get_topic_start_time(), get_topic_author()) ?></li>
<?php if ( 1 < get_topic_posts() ) : ?>
	<li><?php printf(__('<a href="%1$s">Latest reply</a> from %2$s'), attribute_escape( get_topic_last_post_link() ), get_topic_last_poster()) ?></li>
<?php endif; ?>
<?php if ( bb_is_user_logged_in() ) : $class = 0 === is_user_favorite( bb_get_current_user_info( 'id' ) ) ? ' class="is-not-favorite"' : ''; ?>
	<li<?php echo $class;?> id="favorite-toggle"><?php user_favorites_link(); ?></li>
<?php endif; do_action('topicmeta'); ?>
</ul>
</div>

<?php topic_tags(); ?>
<?php endif; ?>

<h2>Search</h2>
<?php include ('search-form.php'); ?>

</div>


</div>

