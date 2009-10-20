<div style="clear: both"></div>

<div id="footer">
	<div class="page">
		<?php do_action ('gz_interesting'); ?>
		
		<div style="clear: both"></div>
	</div>
</div>

<div id="end">
	<div class="page">
		<div class="sidebar" style="margin-top: -1.6em">
			<a href="http://bbpress.org"><img valign="middle" src="<?php echo bb_get_active_theme_uri() ?>image/wp-logo2.png" width="50" height="50" alt="bbPress Logo"/></a>
			
			<?php _e( 'Theme', 'guangzhou' ); ?>: <a href="http://urbangiraffe.com/themes/guangzhou/" title="<?php printf( __( 'Get this theme that took %d queries and %s seconds to generate', 'guangzhou' ), $bbdb->num_queries, bb_timer_stop() ); ?>"><?php _e( 'Guangzhou', 'guangzhou' ); ?></a>
		</div>

		<div class="content">
			<?php do_action('bb_foot', ''); ?>
		</div>

		<div style="clear: both"></div>
	</div>
</div>

</body>
</html>
