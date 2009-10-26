<?php global $is_bb; $is_bb = true; get_header();; ?>

<h3 class="bbcrumb"><a href="<?php bb_option('uri'); ?>"><?php bb_option('name'); ?></a> &raquo; <?php echo $profile_page_title; ?></h3>
<h2><?php echo get_user_name( $user->ID ); ?></h2>

<?php bb_profile_base_content(); ?>

<?php get_footer(); ?>
