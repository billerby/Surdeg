<?php 	/* get all options: */
include (TEMPLATEPATH . '/functions/bfa_get_options.php');
get_header(); ?>

<?php /* If there are any posts: */
if (have_posts()) : $bfa_ata['postcount'] == 0; /* Postcount needed for option "XX first posts full posts, rest excerpts" */ ?>

	<?php /* This outputs the next/previous post or page navigation. 
	This can be edited at Atahualpa Theme Options -> Style & edit the Center column */
	bfa_center_content($bfa_ata['content_above_loop']); ?>

	<?php /* The LOOP starts here. Do this for all posts: */
	while (have_posts()) : the_post(); $bfa_ata['postcount']++; ?>
	
		<?php /* Add Odd or Even post class so post containers can get alternating CSS style (optional) */
		$odd_or_even = (($bfa_ata['postcount'] % 2) ? 'odd-post' : 'even-post' ); ?> 

		<?php /* This is the actual Wordpress LOOP. 
		The output can be edited at Atahualpa Theme Options -> Style & edit the Center column */
		bfa_center_content($bfa_ata['content_inside_loop']); ?>
						
	<?php /* END of the LOOP */
	endwhile; ?>

	<?php /* This outputs the next/previous post or page navigation and the comment template.
	This can be edited at Atahualpa Theme Options -> Style & edit the Center column */
	bfa_center_content($bfa_ata['content_below_loop']); ?>

<?php /* END of: If there are any posts */
else : /* If there are no posts: */ ?>

<?php /* This outputs the "Not Found" content, if neither posts, pages nor attachments are available for the requested page.
This can be edited at Atahualpa Theme Options -> Style & edit the Center column */
bfa_center_content($bfa_ata['content_not_found']); ?>

<?php endif; /* END of: If there are no posts */ ?>

<?php bfa_center_content($bfa_ata['center_content_bottom']); ?>

<?php get_footer(); ?>