<?php get_header(); ?>

<div id="main">
	<div class="pagewrap">
		<div id="content">
			<div class="latest" id="single">
				<h2><?php _e( 'Error 404 - Not Found', 'guangzhou'); ?></h2>
	
				<p><?php _e( 'The page you tried to access does not exist.  Please consider using search to find what you want.', 'guangzhou' ); ?></p>
	
				<p><?php _e( 'The most recent articles on this site are:', 'guangzhou' ); ?></p>
	
				<div class="post">
		    	<ul><?php wp_get_archives( 'type=postbypost&limit=10' ) ?></ul>
				</div>
			</div>
		</div>

		<?php get_sidebar(); ?>
		<div style="clear: both"></div>
	</div>
</div>

<?php get_footer(); ?>
