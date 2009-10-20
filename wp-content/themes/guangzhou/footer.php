<div id="footer">
	<div class="pagewrap">
		<ul id="interesting">
		<?php if ( !function_exists( 'dynamic_sidebar' ) || !dynamic_sidebar( 2 )) : ?>
			<?php wp_list_categories( array() . '&title_li=<h2>Categories</h2>&exclude=17,19' ); ?>
		<?php endif; ?>
		</ul>
		
		<div style="clear: both"></div>
	</div>
</div>

<div id="end">
	<div class="pagewrap">
		<?php if ( GZ::get_options( 'footer_logo' ) ) : ?>
			<div class="sidebar" style="margin-top: -1.6em">
				<a href="http://wordpress.org"><img valign="middle" src="<?php bloginfo( 'template_url' ) ?>/image/wp-logo2.png" width="50" height="50" alt="Wp Logo"/></a>
			<?php else : ?>
			<div class="sidebar">
				<a href="http://wordpress.org">WordPress</a> &mdash;
			<?php endif; ?>
			
			<?php _e( 'Theme', 'guangzhou' ); ?>: <a href="http://urbangiraffe.com/themes/guangzhou/" title="<?php printf( __( 'Get this theme that took %d queries and %s seconds to generate', 'guangzhou' ), get_num_queries(), timer_stop() ); ?>"><?php _e( 'Guangzhou', 'guangzhou' ); ?></a>
		</div>

		<div class="content">
			<a href="<?php bloginfo( 'url' ); ?>"><?php _e( 'Home', 'guangzhou' ); ?></a>
			<?php if ( GZ::get_options( 'skip_links' ) ) : ?>
				| <a href="#content"><?php _e( 'Main content', 'guangzhou'); ?></a>
			<?php endif; ?>

			<?php foreach ( GZ::bottom_menu() AS $link ) : ?>
				| <?php echo GZ::link_detail( $link ); ?>
			<?php endforeach; ?>
			
			<?php if ( GZ::get_options( 'copyright' ) ) echo '| '.str_replace( '%year%', date( 'Y' ), GZ::get_options( 'copyright' ) )?>
		</div>
		<div style="clear: both"></div>
	</div>
</div>

<?php wp_footer();  ?>
</body>
</html>
