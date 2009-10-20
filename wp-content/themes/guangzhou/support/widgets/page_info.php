<?php
/**
 * Guangzhou page information widget( shown at top of pages )
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

class GZ_Widget_PageInfo extends GZ_Widget {
	function display( $args )
	{
		global $post;
		extract( $args );

		echo $before_widget;
		
		if ( ( is_single() || is_page() ) && $post->ping_status == 'open' )
			$this->page_info();
		else if ( is_author() )
			$this->author_info();
		else if ( is_archive() )
			$this->archive_info();
		else if ( is_search() )
			$this->search_info();
		else
			$this->general_info();
			
		echo $after_widget;
	}
	
	function description() {
		return __( 'Show page information', 'guangzhou'  );
	}
	
	function page_info() {
		global $post, $authordata;
		
		$options = GZ::get_options();
		
		if ( function_exists( 'the_tags' ) )
			$tags = get_the_tag_list( __( '<strong>Tags:</strong>', 'guangzhou').' ', ', ', '' );
		?>
			<div class="info">
				<a title="<?php _e( 'Subscribe to this!', 'guangzhou' ) ?>" href="<?php echo get_post_comments_feed_link(); ?>"><img src="<?php bloginfo( 'template_url' ) ?>/image/feed.png" width="16" height="16" alt="RSS"/></a>
			</div>
		
			<h2><?php the_time( get_option( 'date_format' ) ) ?></h2>
			<p>
				
				<?php if ( isset( $options['author'] ) && $options['author'] ) : ?>
					<?php printf( __('This page was created <strong>%1s ago</strong> by <a href="%2$s">%3$s</a>.', 'guangzhou'), $this->time_since( mysql2date( 'U', $post->post_date)), get_author_posts_url( $authordata->ID, $authordata->user_nicename ), get_the_author_meta('nickname') ) ;?>
				<?php else : ?>
					<?php printf( __('This page was created <strong>%1s ago</strong>.', 'guangzhou'), $this->time_since( mysql2date( 'U', $post->post_date ) ) ) ;?>
				<?php endif;?>
		
				<?php if ( is_single() ) : ?>
					<?php printf( __('Similar pages can be found in %s.', 'guangzhou'), get_the_category_list( ', ' ) ) ?>
				<?php endif; ?>
			</p>
		
			<?php if ( $tags ) : ?>
				<p><?php echo $tags; ?></p>
			<?php endif; ?>
		
			<?php echo GZ_Comments::comment_count(); ?>
<?php
	}
	
	function author_info() {
		?>
		<div class="info">
			<a title="<?php _e( 'Subscribe to this!', 'guangzhou' ) ?>" href="<?php echo $this->archive_feed(); ?>"><img src="<?php bloginfo( 'template_url' ) ?>/image/feed.png" width="16" height="16" alt="RSS"/></a>
		</div>
		
		<h2><?php _e( 'Author Information', 'guangzhou' ); ?></h2>
		
		<?php if ( $this->archive_total() > 0 ) : ?>
			<p><?php printf( __('The author has written <strong>%s entries</strong>.', 'guangzhou' ), $this->archive_total() ); ?></p>
		<?php endif; ?>
		
		<dl>
			<dt><?php _e( 'Name', 'guangzhou' ); ?></dt>
			<dd>
				<?php the_author(); ?>
				<?php if ( get_the_author_url() ) : ?>
					<?php printf( __( '(visit <a href="%s">website</a>', 'guangzhou' ),  get_the_author_url() ); ?>
				<?php endif; ?>
			</dd>
			
			
			<?php if ( get_the_author_description() ) : ?>
			<dt><?php _e( 'Description', 'guangzhou' ); ?></dt>
			<dd><?php the_author_description(); ?></dd>
			<?php endif; ?>
			
			<?php do_action( 'author_page_info' )?>
		</dl>
		
		<?php
	}
	
	function archive_info() {
		?>
		<h2><?php _e( 'Archive Information', 'guangzhou' ); ?></h2>
		<p>
			<?php printf( __( 'This is %1s.', 'guangzhou' ), $this->archive_name() ); ?>
			<?php if ( $this->archive_total() > 0 ) printf( __( 'There are <strong>%d entries</strong> in this archive.', 'guangzhou' ), $this->archive_total() ); ?>
		</p>
	
		<p><?php printf( __( 'You can subscribe to the archive feed with <a href="%s">RSS</a>.', 'guangzhou' ), $this->archive_feed() ); ?></p>
		<?php
	}
	
	function search_info() {
		?>
		<h2><?php _e( 'Search Information', 'guangzhou' ); ?></h2>
		<p><?php printf( _n( "There is <strong>%1s entry</strong> that matched when searching for '<strong>%2s</strong>'.", "There are <strong>%1s entries</strong> that matched when searching for '<strong>%2s</strong>'.", $this->archive_total(), 'guangzhou' ), $this->archive_total(), stripslashes( htmlspecialchars( $_GET['s'] ) ) ) ?></p>
		<?php
		
		$name = $this->search_name();
		if ( $name )
			echo '<p>'.$name.'</p>';
	}
	
	function general_info()	{
		global $gz_theme;
		$options = $gz_theme->get_options();

		$subs = array();
		
		if ( $options['feedemail'] )
			$subs[] = sprintf( __( '<a rel="nofollow" href="%s">email</a>', 'guangzhou' ), $options['feedemail'] );

		$subs[] = sprintf( __('the <a title="Subscribe to this!" href="%s">RSS feed</a>', 'guangzhou'), get_bloginfo('rss2_url') );
		
		if ( $options['twitter'] )
			$subs[] = sprintf( __('<a rel="nofollow" href="%1s">twitter</a>', 'guangzhou'), $options['twitter'] );
		
		if ( count($subs) > 1 )	{
			$last = array_pop( $subs );
			$subs[] = __( 'or ', 'guangzhou' ).$last;
		}

		?>
		<div class="info">
			<?php if ( $options['twitter'] ) : ?>
			<a title="<?php _e( 'Follow me on Twitter', 'guangzhou' ); ?>" href="<?php echo $options['twitter']; ?>"><img src="<?php bloginfo( 'template_url' ) ?>/image/twitter.gif" width="16" height="16" alt="Twitter"/></a>
			<?php endif; ?>
			<a title="<?php _e( 'Subscribe to this!', 'guangzhou' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>"><img src="<?php bloginfo( 'template_url' ) ?>/image/feed.png" width="16" height="16" alt="RSS"/></a>
		</div>
	
		<h2><?php _e( 'Subscribe', 'guangzhou' ); ?></h2>
		<?php printf( __('Subscribe via %s', 'guangzhou' ), implode( ', ', $subs ) );
	}
	
	// "Time Since" by Michael Heilemann & Dunstan Orchard
	function time_since( $older_date, $newer_date = false )	{
		// array of time period chunks
		$chunks = array(
			array( 60 * 60 * 24 * 365 , __('year', 'guangzhou') ),
			array( 60 * 60 * 24 * 30 , __('month', 'guangzhou') ),
			array( 60 * 60 * 24 * 7, __('week', 'guangzhou') ),
			array( 60 * 60 * 24 , __('day', 'guangzhou') ),
			array( 60 * 60 , __('hour', 'guangzhou') ),
			array( 60 , __('minute', 'guangzhou') ),
		);

		// $newer_date will equal false if we want to know the time elapsed between a date and the current time
		// $newer_date will have a value if we want to work out time elapsed between two known dates
		$newer_date = ( $newer_date == false ) ? ( time() + ( 60 * 60 * get_option( "gmt_offset" ) ) ) : $newer_date;

		// difference in seconds
		$since = $newer_date - $older_date;
		
		if ( $since > 0 )	{
			// we only want to output two chunks of time here, eg:
			// x years, xx months
			// x days, xx hours
			// so there's only two bits of calculation below:

			// step one: the first chunk
			for ( $i = 0, $j = count($chunks); $i < $j; $i++ ) {
				$seconds = $chunks[$i][0];
				$name = $chunks[$i][1];

				// finding the biggest chunk( if the chunk fits, break )
				if ( ( $count = floor( $since / $seconds ) ) != 0 )
					break;
			}

			// set output var
			$output = ( $count == 1 ) ? '1 '.$name : "$count {$name}s";

			// step two: the second chunk
			if ( $i + 1 < $j ) {
				$seconds2 = $chunks[$i + 1][0];
				$name2    = $chunks[$i + 1][1];

				if ( ( $count2 = floor( ( $since - ( $seconds * $count ) ) / $seconds2) ) != 0 ) {
					// add to output var
					$output .=( $count2 == 1 ) ? ', 1 '.$name2 : ", $count2 {$name2}s";
				}
			}
		}
		else
			$output = __( 'a few minutes', 'guangzhou' );

		return $output;
	}

	function archive_total() {
		global $wp_query;
		
		if ( isset( $wp_query->found_posts ) && $wp_query->found_posts > 0 )
			return $wp_query->found_posts;
		return $wp_query->post_count;
	}
	
	function archive_feed($feed = '') {
		global $wp_rewrite;
		
		if ( is_category() )
			$base = get_category_link( intval( get_query_var( 'cat' ) ) );
		else
			$base = get_pagenum_link( 1 );
			
		$permalink = $wp_rewrite->get_feed_permastruct();
		if ( '' != $permalink  ) {
			$permalink = str_replace( '%feed%', $feed, $permalink );
			return $base.$permalink;
		}
		else
			return $base."/?feed={$feed}";
	}
	
	function archive_name() {
		global $wp_query;
		
		if ( $wp_query->max_num_pages > 1 ) {
			$paged = get_query_var( 'paged' );
			$max   = $wp_query->max_num_pages;
			
			if ( $paged == 0 )
				$paged = 1;
			$pre = sprintf( __( '<strong>page %d of %d</strong> of ', 'guangzhou' ), $paged, $max );
		}
			
		if ( is_category() )
			return $pre.sprintf( __( 'the <strong>\'%s\'</strong> archive', 'guangzhou' ), single_cat_title('', false ) );
		else if ( is_day() )
			return $pre.sprintf( __( 'the archive for <strong>%s</strong>', 'guangzhou' ), get_the_time( __('l, F jS, Y', 'guangzhou' ) ) );
		else if ( is_month() )
			return $pre.sprintf( __( 'the archive for <strong>%s</strong>', 'guangzhou' ), get_the_time( __('F, Y', 'guangzhou' ) ) );
		else if ( is_year() )
			return $pre.sprintf( __( 'the archive for <strong>%s</strong>', 'guangzhou' ), get_the_time( __('Y', 'guangzhou' ) ) );
		else if ( function_exists( 'is_tag') && is_tag() )
			return $pre.sprintf( __( 'all tags for <strong>%s</strong>', 'guangzhou' ), single_tag_title( '', false ) );
		return '';
	}
	
	function search_name() {
		global $wp_query;
		
		if ( $wp_query->max_num_pages > 1 )	{
			$paged = get_query_var( 'paged' );
			$max   = $wp_query->max_num_pages;
			
			if ( $paged == 0 )
				$paged = 1;
			return sprintf( __( ' This is <strong>page %d of %d</strong> results.', 'guangzhou' ), $paged, $max );
		}
		
		return '';
	}
}
