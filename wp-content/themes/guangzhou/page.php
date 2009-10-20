<?php get_header(); ?>

<div id="main">
	<div class="pagewrap">
		<?php do_action( 'the_sniplet_place', 'guangzhou/after header' ); ?>
		
		<div id="content">
		<?php if ( have_posts() ) : $x = 0;?>
			<div class="latest" id="single">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php GZ::post_single( $post ); ?>
				<?php $x++; if ( $x == $gz_theme->latest ) break; endwhile; ?>
			</div>
		<?php endif; ?>

		</div>

		<?php get_sidebar(); ?>

		<div style="clear: both"></div>
	</div>
</div>

<?php GZ_Comments::load(); ?>

<?php get_footer(); ?>
