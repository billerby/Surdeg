<div class="meta">
	<?php echo GZ::icon ($bb_post); ?>

	<div class="info"><a href="<?php echo post_anchor_link() ?>"><?php global $pos; echo $pos ?></a></div>
	
	<cite><?php post_author_link (); ?>:</cite>
	<p><?php printf( __('Posted %s ago'), bb_get_post_time() ) ?> by <?php post_author_title(); ?><?php GZ::post_edit_text (); ?></p>
</div>

<?php post_text(); ?>