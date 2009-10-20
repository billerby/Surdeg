<?php get_header(); ?>

<div id="main">
	<div class="pagewrap">
		<?php do_action( 'the_sniplet_place', 'guangzhou/after header' ); ?>

		<div id="content">
			<div class="latest" id="single">
			<?php $post = $posts[0];  ?>

			<?php if ( is_category() ) : ?>
				<h2 id="pagetitle"><?php printf( __( 'Archive for the &#8216;%s&#8217; category', 'guangzhou'), single_cat_title('', false) ); ?></h2>
			<?php endif; ?>

			<?php do_action( 'the_sniplet_place', 'guangzhou/category start' ); ?>
			
			<?php while ( have_posts() ) : the_post(); ?>
				<?php GZ::post_recent( $post ); ?>
			<?php endwhile; ?>

			<?php do_action( 'the_sniplet_place', 'guangzhou/category end' ); ?>

			<?php if ( GZ::is_paged() ) : ?>
				<div class="tablenav">
					<div class="tablenav-pages">
					<?php next_posts_link( __( '&laquo; Older Entries', 'guangzhou' ) ) ?>
					<?php previous_posts_link( __( 'Newer Entries &raquo;', 'guangzhou' ) ) ?>
					</div>
				</div>
				<div class="clear"></div>
			<?php endif; ?>
			</div>
		</div>
		
		<?php get_sidebar(); ?>

		<?php do_action( 'the_sniplet_place', 'guangzhou/after recent' ); ?>
		<div style="clear: both"></div>
	</div>
</div>

<?php get_footer(); ?>
