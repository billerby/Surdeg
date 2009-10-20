<?php get_header(); ?>

<div id="main">
	<div class="pagewrap">
		<?php do_action( 'the_sniplet_place', 'guangzhou/after header' ); ?>

		<div id="content">
		<?php if ( have_posts() ) : $x = 0;?>
			<div class="latest">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php GZ::post_latest( $post ); ?>
				<?php $x++; if ( $x == GZ::latest() ) break; endwhile; ?>
			</div>
		<?php endif; ?>

		<?php do_action( 'the_sniplet_place', 'guangzhou/after lead' ); ?>

		<?php if ( have_posts() && GZ::recent() > 0 ) : ?>
			<div id="recent">
				<ul class="left">
				<?php $x = 1; while( have_posts() ) : the_post(); ?>
					<li>
						<?php GZ::post_recent( $post ); ?>
					</li>
				<?php if ( $x >= GZ::recent() / 2 ) break; $x++; endwhile; ?>
				</ul>

				<ul class="right">
				<?php $x = 1; while ( have_posts() ) : the_post(); ?>
					<li>
						<?php GZ::post_recent( $post ); ?>
					</li>
				<?php if ( $x >= GZ::recent() / 2 ) break; $x++; endwhile; ?>
				</ul>
	
				<div style="clear: both"></div>
			</div>

		<?php endif; ?>
		
			<div class="tablenav">
				<div class="tablenav-pages">
				<?php next_posts_link( __( '&laquo; Older Entries', 'guangzhou' ) ) ?>
				<?php previous_posts_link( __( 'Newer Entries &raquo;', 'guangzhou' ) ) ?>
				</div>
			</div>
		</div>

		<?php get_sidebar(); ?>
		
		<?php do_action( 'the_sniplet_place', 'guangzhou/after recent' ); ?>

		<div style="clear: both"></div>
	</div>
</div>

<?php get_footer(); ?>
