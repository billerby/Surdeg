<?php get_header(); ?>

<div id="main">
	<div class="pagewrap">
		<?php do_action( 'the_sniplet_place', 'guangzhou/before single post' ); ?>
		<div id="content">
			<div class="latest" id="single">
				<?php the_post(); ?>
				<?php GZ::post_single( $post ); ?>
			</div>

			<?php do_action( 'the_sniplet_place', 'guangzhou/after single post' ); ?>
		</div>

		<?php get_sidebar(); ?>

		<div style="clear: both"></div>
	</div>
</div>

<?php GZ_Comments::load(); ?>

<?php get_footer(); ?>
