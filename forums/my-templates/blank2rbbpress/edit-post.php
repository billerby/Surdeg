<?php global $is_bb; $is_bb = true; get_header();; ?>
<h3 class="bbcrumb"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a> &raquo; <?php _e('Edit Post'); ?></h3>

<?php edit_form(); ?>

<?php get_footer(); ?>
