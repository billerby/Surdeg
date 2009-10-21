<?php /* if index.php or another page template (copied from index.php) was not used
(i.e. by a plugin such as WPG2), the global $bfa_ata will be empty */
global $bfa_ata; if ($bfa_ata == "")
	include_once (TEMPLATEPATH . '/functions/bfa_get_options.php'); ?>
</td>
<!-- / Main Column -->

<?php if ( $bfa_ata['right_col2'] == "on" ) { ?>
<!-- Right Inner Sidebar -->
<td id="right-inner">

	<?php // Widgetize the Right Inner Sidebar
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Inner Sidebar') ) : ?>

		<!-- No default content for the RIGHT INNER sidebar -->

	<?php endif; ?>

</td>
<!-- / Right Inner Sidebar -->
<?php } ?>

<?php if ( $bfa_ata['right_col'] == "on" ) { ?>
<!-- Right Sidebar -->
<td id="right">

	<?php // Widgetize the Right Sidebar
	if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Right Sidebar') ) : ?>

    	<div class="widget"><div class="widget-title">
    	<h3>Recent Posts</h3></div>
<?php $r = new WP_Query(array(
	'showposts' => 20,
	'what_to_show' => 'posts',
	'nopaging' => 0,
	'post_status' => 'publish',
	'caller_get_posts' => 1));
if ($r->have_posts()) : ?>
<ul><?php  while ($r->have_posts()) : $r->the_post(); ?>
<li><a href="<?php the_permalink() ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a></li>
    	<?php endwhile; ?>
    	</ul>
    	<?php wp_reset_query();  // Restore global post data stomped by the_post().
    	endif; ?>
    </div>

    	<div id="linkcat-99" class="widget widget_links"><div class="widget-title">
    	<?php wp_list_bookmarks('category_before=&category_after=&title_before=<h3>&title_after=</h3></div>'); ?>
    	</div>

    	<div class="widget"><div class="widget-title">
    	<h3><?php _e('Meta','atahualpa'); ?></h3>
    	</div>
    	<ul>
    		<?php wp_register(); ?>
    		<li><?php wp_loginout(); ?></li>
    		<li><a href="http://wordpress.org/" title="
    		<?php _e('Powered by WordPress, state-of-the-art semantic personal publishing platform.','atahualpa'); ?>">
    		<?php _e('WordPress','atahualpa'); ?></a></li>
    		<?php wp_meta(); ?>
    	</ul>
    	</div>

	<?php endif; ?>

</td>
<!-- / Right Sidebar -->
<?php } ?>

</tr>
<!-- / Main Body -->
<tr>

<!-- Footer -->
<td id="footer" colspan="<?php echo $bfa_ata['cols']; ?>">

    <p>
    <?php echo bfa_footer($bfa_ata['footer_style_content']); ?>
    </p>
    <?php if ($bfa_ata['footer_show_queries'] == "Yes - visible") { ?>
    <p>
    <?php echo $wpdb->num_queries; ?><?php _e(' queries. ','atahualpa'); ?><?php timer_stop(1); ?><?php _e(' seconds.','atahualpa'); ?>
    </p>
    <?php } ?>

    <?php if ($bfa_ata['footer_show_queries'] == "Yes - in source code") { ?>
    <!--
    <?php echo $wpdb->num_queries; ?><?php _e(' queries. ','atahualpa'); ?><?php timer_stop(1); ?><?php _e(' seconds.','atahualpa'); ?>
    -->
    <?php } ?>

    <?php wp_footer(); ?>

</td>
<!-- / Footer -->

</tr>
</table><!-- / layout -->
</div><!-- / container -->
</div><!-- / wrapper -->
<?php echo ($bfa_ata['html_inserts_body_bottom'] != "" ? apply_filters(widget_text, $bfa_ata['html_inserts_body_bottom']) : ''); ?>
</body>
</html>