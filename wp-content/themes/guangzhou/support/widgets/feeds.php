<?php
/**
 * Guangzhou feed display widget
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

class GZ_Widget_Feeds extends GZ_Widget {
	function display( $args )
	{
		extract( $args );

		$options = GZ::get_options();
		
		echo $before_widget.$before_title.'Feeds'.$after_title;
		?>
			<p><?php _e( 'Those all-important RSS feeds', 'guangzhou' ); ?>:</p>

			<ul class="feeds">
				<li>
					<a href="<?php bloginfo( 'rss2_url' ); ?>"><img src="<?php bloginfo ( 'template_url' ) ?>/image/feed.png" width="16" height="16" alt="<?php _e( 'Get The Feed', 'guangzhou' ); ?>"/></a>
					<a href="<?php bloginfo( 'rss2_url' ); ?>"><?php _e( 'Posts', 'guangzhou' ); ?></a> <?php printf( __( '(or get it via <a href="%s">email</a>)', 'guangzhou' ), $options['feedemail'] ); ?><br/>
				</li>
				<li>
					<a href="<?php bloginfo( 'comments_rss2_url' ); ?>"><img src="<?php bloginfo ( 'template_url' ) ?>/image/feed.png" width="16" height="16" alt="<?php _e( 'Get The Feed', 'guangzhou' ); ?>"/></a>
					<a href="<?php bloginfo( 'comments_rss2_url' ); ?>"><?php _e( 'Comments RSS', 'guangzhou' ); ?></a>
				</li>
			</ul>
		<?php
		
		echo $after_widget;
	}
	
	function description() {
		return __( 'Show feed information', 'guangzhou' );
	}
}
	
?>