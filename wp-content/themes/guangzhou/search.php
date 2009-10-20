<?php get_header(); ?>

<div id="main">
	<div class="pagewrap">
		<?php do_action( 'the_sniplet_place', 'guangzhou/after header' ); ?>
		
		<div id="content">
			<div class="latest" id="single">
			<?php if ( have_posts() ) : ?>

			<h2><?php printf( __( "Search results for '%s'", 'guangzhou' ), stripslashes( htmlspecialchars ( $_GET['s'] ) ) ); ?></h2>

			<ol>
			<?php while ( have_posts() ) : the_post(); ?>
				<li><?php GZ::post_recent( $post ); ?></li>
			<?php endwhile; ?>
			</ol>

			<?php if ( GZ::is_paged() ) : ?>
				<div class="tablenav">
					<div class="tablenav-pages">
					<?php next_posts_link( __( '&laquo; Older Entries', 'guangzhou' ) ) ?>
					<?php previous_posts_link( __( 'Newer Entries &raquo;', 'guangzhou' ) ) ?>
					</div>
				</div>
			<div class="clear"></div>
			<?php endif; ?>

		<?php else : ?>
			<h2 class="center"><?php printf( "Nothing found for '%s'", htmlspecialchars( $_GET['s'] ) ); ?></h2>
			<p><?php _e( 'We could find nothing that matched your search term.  Please try another term, or navigate elsewhere on the site.', 'guangzhou' ) ?></p>
		<?php endif; ?>
			</div>
		</div>

		<?php get_sidebar(); ?>
		<?php do_action( 'the_sniplet_place', 'guangzhou/after recent' ); ?>
		
		<div style="clear: both"></div>
	</div>
</div>

<?php get_footer(); ?>
