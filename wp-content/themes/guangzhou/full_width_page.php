<?php
/*
Template Name: Full Width Page
*/
?>

<?php get_header(); ?>

<div id="main">
	<div class="pagewrap">
		<div id="content" class="full">
		<?php if ( have_posts() ) : $x = 0;?>
			<div class="latest" id="single">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php GZ::post_single( $post, false ); ?>
				<?php $x++; if ( $x == $gz_theme->latest ) break; endwhile; ?>
			</div>
		<?php endif; ?>

		</div>

		<div style="clear: both"></div>
	</div>
</div>

<?php GZ_Comments::load(); ?>

<?php get_footer(); ?>

