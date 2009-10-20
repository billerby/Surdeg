<?php get_header(); ?>

<div id="main">
	<div class="pagewrap">
		<?php do_action( 'the_sniplet_place', 'guangzhou/after header' ); ?>
		
		<div id="content">
			<div class="latest" id="single">

			<div class="post">
				<h2><?php printf( __( 'Profile for %s', 'guangzhou' ), get_query_var( 'author_name' ) ); ?></h2>

				<?php if ( have_posts() ) : ?>
				<h3><?php _e( 'Recent Posts', 'guangzhou' ) ?></h3>

				<ul>
					<?php while ( have_posts() ) : the_post(); ?>
						<li><a href="<?php the_permalink () ?>"><?php the_title() ?></a></li>
					<?php endwhile; ?>
				</ul>
				<?php endif; ?>
			</div>

			<?php if ( GZ::is_paged() ) : ?>
			<div class="navigation">
		 		<?php GZ::next_posts_link( __( '&laquo; Older entries', 'guangzhou' ), '<div class="right">', '</div>' ) ?>
		 		<?php GZ::previous_posts_link( __( 'Newer entries &raquo;', 'guangzhou' ), '<div class="left">', '</div>' ) ?>&nbsp;
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
