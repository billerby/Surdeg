<?php get_header(); ?>

<div id="main">
	<div class="pagewrap">
		<?php do_action( 'the_sniplet_place', 'guangzhou/after header' ); ?>
		
		<div id="content">
			<div class="latest" id="single">
			<?php $post = $posts[0];  ?>

			<?php if (is_category()) : ?>
				<h2 id="pagetitle"><?php printf( __( 'Archive for the &#8216;%s&#8217; category', 'guangzhou'), single_cat_title('', false) ); ?></h2>
			<?php elseif (function_exists ('is_tag') && is_tag ()) : ?>
				<h2 id="pagetitle"><?php printf( __( 'Posts tagged with &#8216;%s&#8217', 'guangzhou'), single_cat_title('', false) ); ?></h2>
		  <?php elseif (is_day()) : ?>
				<h2 id="pagetitle"><?php printf( __( 'Archive for %s', 'guangzhou'), get_the_time('F jS, Y')); ?></h2>
		 	<?php elseif (is_month()) : ?>
				<h2 id="pagetitle"><?php printf( __( 'Archive for %s', 'guangzhou'), get_the_time('F Y')); ?></h2>
			<?php elseif (is_year()) : ?>
				<h2 id="pagetitle"><?php printf( __( 'Archive for %s', 'guangzhou'), get_the_time('Y')); ?></h2>
		  <?php elseif (is_author()) : ?>
				<h2 id="pagetitle"><?php _e( 'Author Archive', 'guangzhou'); ?></h2>
			<?php elseif (isset($_GET['paged']) && !empty($_GET['paged'])) : ?>
				<h2 id="pagetitle"><?php _e( 'Blog Archives', 'guangzhou'); ?></h2>
			<?php endif;?>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php GZ::post_recent( $post ); ?>
			<?php endwhile; ?>

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
