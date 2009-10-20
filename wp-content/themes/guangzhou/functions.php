<?php
/**
 * Main Guangzhou functions
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

class GZ
{
	var $options;
	var $latest;
	
	function GZ()	{
		$options = $this->get_options();

		if ( !is_admin() )
			add_filter( 'pre_get_posts', array( &$this, 'exclude_from_front' ) );
			
		add_action( 'register', array( &$this, 'register' ) );
		add_action( 'loginout', array( &$this, 'register' ) );
		add_action( 'wp_head', array( &$this, 'wp_head' ), 1 );
		add_filter( 'sniplet_places', array( &$this, 'sniplet_places' ) );
		
		if ( $options['author_posts'] != 10 && $options['author_posts'] != 0 )
			add_filter( 'post_limits', array( &$this, 'author_post_limit' ) );
		
		if ( function_exists( 'automatic_feed_links' ) )
			automatic_feed_links();
	}
	
	function version() {
		return '0.2,2';
	}
	
	function author_post_limit( $limits ) {
		global $wp_query;
		
		if ( is_author() ) {
			global $wp_query;
			
			$options = $this->get_options();
			$limits  = str_replace( get_query_var( 'posts_per_page' ), $options['author_posts'], $limits );
			set_query_var( 'posts_per_page', $options['author_posts'] );
		}
		
		return $limits;
	}

	function profile_link()	{
		global $current_user;
		
		$user = get_currentuserinfo();
		$user = $current_user;
		
		if ( $user && $user->data->ID > 0 )
			echo '<a rel="nofollow" href="'.get_author_posts_url( $user->data->ID ).'">Profile</a>';
	}
	
	function register( $text ) {
		$text = str_replace( 'Site Admin', 'Dashboard', $text );
		$text = str_replace( '/wp-login.php?action=register', '/login/register/', $text );
		$text = str_replace( '/wp-login.php"', '/login/"', $text );
		$text = str_replace( 'href=', 'rel="nofollow" href=', $text );
		$text = str_replace( '/site/', '/', $text);
		$text = str_replace( '/wp-admin/', '/site/wp-admin/', $text );
		return $text;
	}
	
	function sniplet_places()	{
		return array(
			'Guangzhou' => array(
				'guangzhou/after header'       => 'After Header',
				'guangzhou/after lead'         => 'After Lead Post',
				'guangzhou/before single post' => 'Before Single Post',
				'guangzhou/after recent'       => 'After Recent Posts',
				'guangzhou/category start'     => 'Category Start',
				'guangzhou/category end'       => 'Category End'
			)
		);
	}
	
	function recent()	{
		$options = GZ::get_options();
		return $options['recent'];
	}
	
	function latest()	{
		$options = GZ::get_options();
		return $options['latest'];
	}
	
	function get_options($name = '') {
		global $gz_theme;
		
		if ( !empty( $gz_theme->options ) )
			$options = $gz_theme->options;
		else {
			$options = get_option( 'guangzhou_options' );
			if ( $options === false )
				$options = array();

			$defaults = array(
				'skin'        => 'clear',
				'latest'      => 1,
				'recent'      => 4,
				'top_menu'    => 'Top Menu',
				'main_menu'   => 'Menu',
				'bottom_menu' => 'Bottom Menu',
				'skip_links'  => false,
				'login_menu'  => false,
				'page_width'  => 1000,
				'footer_logo' => true
			);
			
			foreach ( $defaults AS $key => $value )	{
				if ( is_array( $value ) && isset( $options[$key] ) ) {
					foreach ($value AS $name2 => $value2) {
						if ( !isset( $options[$key][$name2] ) )
							$options[$key][$name2] = $value2;
					}
				}
				else if ( !isset( $options[$key] ) )
					$options[$key] = $value;
			}
			
			$gz_theme->options = $options;
		}
		
		if ( $name )
			return $options[$name];
		return $options;
	}

	function main_menu($default = '/') {
		// Run through the menus and pick the one that is 'selected'
		$options     = GZ::get_options();
		$menu        = get_bookmarks( "category_name={$options['main_menu']}&orderby=rating" );
		$default_pos = false;

		foreach ( $menu AS $pos => $link ) {
			if ( substr( $_SERVER['REQUEST_URI'], 0, strlen( $link->link_url ) ) == $link->link_url && $link->link_url != $default ) {
				$menu[$pos]->selected = true;
				$menu[$pos]->class    = ' class="selected"';
				return $menu;
			}
			else if ( $link->link_url == $default )
				$default_pos = $pos;
		}

		// None, so pick the default
		if ( $default_pos !== false ) {
			$menu[$default_pos]->class  = ' class="selected"';
			$menu[$default_pos]->selected   = true;
		}

		return $menu;
	}
	
	function top_menu( $default = '/' ) {
		$options = GZ::get_options();
		return get_bookmarks( "category_name={$options['top_menu']}&orderby=rating" );
	}
	
	function bottom_menu() {
		$options = GZ::get_options();
		return get_bookmarks( "category_name={$options['bottom_menu']}&orderby=rating" );
	}

	function page_title() {
		global $wp_query;

		if ( $wp_query->max_num_pages > 1 ) {
			$paged = get_query_var( 'paged' );
			$max   = $wp_query->max_num_pages;
			
			if ( $paged == 0 )
				$paged = 1;
			$pre = sprintf( __( ' (page %d of %d)', 'guangzhou' ), $paged, $max );
		}

		$title = wp_title( '', false );
		
		if ( function_exists( 'is_tag' ) && is_tag() )
			$title = sprintf( __( 'Posts tagged with \'%s\'', 'guangzhou' ), single_tag_title( '', false ) );
		else if ( is_archive() )
			$title .= $pre;
		else if ( is_404() )
			$title = __( 'Error 404 - Page not found', 'guangzhou' );
		
		if ( $title )
			$title .= ' | ';
			
		$title .= get_bloginfo( 'name' );
		return trim( $title );
	}

	function exclude_from_front( $query ) {
		if ( $query->is_home ) {
			$options = GZ::get_options();
			if ( $options['exclude'] ) {
				$cats = explode( ',', $options['exclude'] );
				$query->set( 'cat', '-'.implode( ',-', $cats ) );
			}
		}
		
		$options = GZ::get_options();

		$total = 0;
		if ( isset( $options['recent'] ) )
			$total += $options['recent'];
			
		if ( isset( $options['latest'] ) )
			$total += $options['latest'];

		$query->set( 'posts_per_page', $options['recent'] + $options['latest'] );
	}

	function wp_head() {
		if ( is_singular() )
			wp_enqueue_script( 'comment-reply' );
			
		$skin    = GZ::skin();
		$data    = GZ::custom_css();
		
		wp_enqueue_style ('guangzhou', get_bloginfo('stylesheet_url'), array (), $this->version (), 'all');
		wp_enqueue_style ('guangzhou-skin', get_bloginfo('template_url').'/skins/'.$skin.'/style.css', array ('guangzhou'), $this->version (), 'all');
		
		if ($data)
			echo '<style type="text/css" media="screen">'.$data.'</style>';

//		wp_enqueue_style ('guangzhou-print', get_bloginfo('template_url').'/print.css', array ('guangzhou'), $this->version (), 'print');
	}
	
	function custom_css() {
		$options = GZ::get_options();
		
		$data = '';
		if ( isset($options['stripe']) && $options['stripe'] != 'none' )
			$data = '#header	{	background: black url('.get_bloginfo( 'template_url' ).'/stripes/'.$options['stripe'].') repeat-x top left; }';
		
		if ( isset($options['header_height']) )
			$data .= '#header { height: '.$options['header_height'].'}';
		
		if ( isset($options['page_width']) && $options['page_width'] != 1000 ) {
			$data .= '.page { width: '.$options['page_width']."px !important; }\r\n";
			$data .= '#content { width: '.( $options['page_width'] - 300 )."px !important; }\r\n";
			$data .= '#recent ul { width: '.( intval( ( $options['page_width'] - 320 ) / 2 )).'px !important; }';
		}
		
		global $is_IE;
		
		if ( $is_IE ) {
			echo "<!--[if lte IE 6]>
			<style type=\"text/css\" media=\"screen\">
				.mainmenu ul li { margin-bottom: 0px !important }
			</style>
			<![endif]-->\r\n";
		}
		
		return $data;
	}
	
	function link_detail( $link ) {
		$other = array();
		
		if ( isset($link->class) )
			$other[] = $link->class;
			
		if ( $link->link_description )
			$other[] = 'title="'.htmlspecialchars( $link->link_description ).'"';
			
		if ( $link->link_target )
			$other[] = 'target="'.$link->link_target.'"';
		
		if ( $link->link_rel )
			$other[] = 'rel="'.$link->link_rel.'"';

		return sprintf( '<a href="%s"%s>%s</a>', $link->link_url, implode( ' ', $other ), $link->link_name );
	}
	
	function skin() {
		global $gz_theme;
		
		$options = GZ::get_options();
		$skin    = $options['skin'];

		if ( !empty( $options['skin_url'] ) ) {
			$parts = explode( "\r\n", $options['skin_url'] );

			if ( count( $parts ) > 0 ) {
				foreach ( $parts AS $line ) {
					$urlparts = explode( '=', $line );
					
					if ( count( $urlparts ) == 2 ) {
						if ( substr( $_SERVER['REQUEST_URI'], 0, strlen( $urlparts[0] ) ) == $urlparts[0] )	{
							$skin = $urlparts[1];
							break;
						}
					}
				}
			}
		}
		
		if ( !file_exists( TEMPLATEPATH.'/skins/'.$skin.'/style.css' ) )
			$skin = 'clear';
		
		return $skin;
	}

	function is_first_page() {
		global $paged;
		if ( $paged == 0 )
			return true;
		return false;
	}
	
	function is_paged() {
		global $wp_query;
		return $wp_query->max_num_pages > 1 ? true : false;
	}

	function previous_page( $before = '<div class="left">', $after = '</div>' ) {
		global $id, $page, $numpages, $multipage, $more, $pagenow;

		$previouspagelink = __( '&laquo; Previous page', 'guangzhou' );
		$output = '';
		
		if ( $more ) {
			$i = $page - 1;
			if ( $i && $more ) {
				if ( 1 == $i ) {
					$output .= '<a href="' . get_permalink() . '">'.$previouspagelink.'</a>';
				} else {
					if ( '' == get_option( 'permalink_structure') || 'draft' == $post->post_status )
						$output .= '<a href="' . get_permalink() . '&amp;page=' . $i . '">' . $previouspagelink . '</a>';
					else
						$output .= '<a href="' . trailingslashit( get_permalink() ) . user_trailingslashit( $i, 'single_paged' ) . '">' . $previouspagelink . '</a>';
				}
			}
			
			$output = $before.$output.$after;
		}
			
		return $output;
	}
	
	function next_page($before = '<div class="right">', $after = '</div>') {
		global $id, $page, $numpages, $multipage, $more, $pagenow, $post;

		$nextpagelink = __( 'Next page &raquo;', 'guangzhou' );
		$output = '';
		if ( $more ) {
			$i = $page + 1;
			if ( $i <= $numpages && $more ) {
				if ( 1 == $i ) {
					$output .= '<a href="' . get_permalink() . '">'.$nextpagelink.'</a>';
				} else {
					if ( '' == get_option( 'permalink_structure' ) || 'draft' == $post->post_status )
						$output .= '<a href="' . get_permalink() . '&amp;page=' . $i . '">' . $nextpagelink . '</a>';
					else
						$output .= '<a href="' . trailingslashit( get_permalink() ) . user_trailingslashit( $i, 'single_paged' ) . '">' . $nextpagelink . '</a>';
				}
			}
			
			$output = $before.$output.$after;
		}
		return $output;
	}
	
	function next_posts_link($label, $before, $after) {
		global $paged, $wpdb, $wp_query;
		if ( !$max_page ) {
			$max_page = $wp_query->max_num_pages;
		}
		if ( !$paged )
			$paged = 1;
		$nextpage = intval( $paged ) + 1;
		if ( (! is_single() ) && ( empty( $paged) || $nextpage <= $max_page ) ) {
			echo $before.'<a href="';
			next_posts( $max_page );
			echo '">'. preg_replace( '/&([^#])(?![a-z]{1,8};)/', '&#038;$1', $label ) .'</a>'.$after;
		}
	}

	function previous_posts_link( $label, $before, $after ) {
		global $paged;
		if ( ( !is_single() ) && ( $paged > 1 ) ) {
			echo $before.'<a href="';
			previous_posts();
			echo '">'. preg_replace( '/&([^#])(?![a-z]{1,8};)/', '&#038;$1', $label ) .'</a>'.$after;
		}
	}
	
	function more_link_text($text) {
		return preg_replace( '@<a href="(.*?)" class="more-link">(.*?)</a>@', '<p><a href="$1" class="more-link">$2</a></p>', $text );
	}
	
	function display_comments() {
		if ( post_password_required() || ( !comments_open() && !pings_open() ) )
			return false;
		return true;
	}
	
	function post_latest($post)	{
		?>
<div class="post" id="post-<?php the_ID(); ?>">
	<div class="comment-count">
		<?php if ( GZ::display_comments() ) :?>
		<?php comments_popup_link( __( 'Comments: 0', 'guangzhou' ), __( '1', 'guangzhou' ), __( '%', 'guangzhou' ) ); ?>
		<?php endif; ?>
	</div>

	<h2><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Read the full story', 'guangzhou' ); ?>"><?php the_title(); ?></a></h2>
	
	<div class="meta">
		<?php the_time( get_option( 'date_format' ) ) ?>
	</div>

	<div class="entry">
		<?php the_content( __( '<span class="more-link">Read more here&hellip;</span>', 'guangzhou' ) ); ?>
	</div>
</div>
		<?php
	}
	
	function post_recent( $post )	{
		?>
<div class="post" id="post-<?php the_ID(); ?>">
	<?php if ( GZ::display_comments() ) :?>
	<div class="comment-count">
		<?php comments_popup_link( __( '0', 'guangzhou' ), __( '1', 'guangzhou' ), __( '%', 'guangzhou' ) ); ?>
	</div>
	<?php endif; ?>
	
	<h3><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Read the full story', 'guangzhou' ); ?>"><?php the_title(); ?></a></h3>

	<div class="meta">
		<?php the_time( get_option( 'date_format' ) ) ?>
	</div>

	<div class="entry">
		<?php the_excerpt( __('Read more here&hellip;', 'guangzhou') ); ?>
		
		<p class="more-link"><a href="<?php the_permalink(); ?>"><?php _e( 'Read more here&hellip;', 'guangzhou' ); ?></a></p>
	</div>
</div>
	<?php
	}
	
	function post_single( $post, $showmeta = true ) {
		?>
<div class="post" id="post-<?php the_ID(); ?>">
	<?php edit_post_link( '<img src="'.get_bloginfo( 'template_url' ).'/image/edit.png" width="16" height="16" alt="edit" style="margin-right: 5px"/>', '<div class="info">','</div>' ); ?>
	<h2><a href="<?php echo get_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>

	<div class="entry">
		<?php the_content( '' ); ?>
	</div>

	<?php wp_link_pages( array( 'before' => '<div class="tablenav"><div class="tablenav-pages">'.GZ::previous_page( '', '' ), 'after' => GZ::next_page( '', '' ).'</div></div>', 'next_or_number' => 'number')); ?>
	<div class="clear"></div>
</div>
		<?php
	}
}

$gz_theme = new GZ();
		
if ( is_admin() )
	include dirname( __FILE__ ).'/support/admin.php';
	
include dirname( __FILE__ ).'/support/widgets.php';
include dirname( __FILE__ ).'/support/comments.php';
