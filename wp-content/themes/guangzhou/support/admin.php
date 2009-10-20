<?php
/**
 * Guangzhou admin interface
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

require dirname(__FILE__).'/plugin.php';

/**
 * Admin handling class
 **/
class GZ_Admin extends GZ_Plugin {
	function GZ_Admin() {
		$this->register_plugin( 'guangzhou', __FILE__ );
		
		$this->add_action( 'admin_menu' );
		$this->add_filter( 'admin_head' );
		$this->add_filter( 'contextual_help', 'contextual_help', 10, 2 );
	}
	
	function admin_head()	{
		if ( strpos( $_SERVER['REQUEST_URI'], 'themes.php' ) !== false )
			$this->render_admin( 'head' );
	}
	
	function get_contents( $url ) {
		if ( substr( $url, 0, 5 ) == 'http:' )
			return wp_get_http ( $url );
		return file_get_contents( $url );
	}
	
	function get_skins() {
		$skins = array();
		$files = glob( dirname( __FILE__ ).'/../skins/*', GLOB_ONLYDIR );
		
		foreach( (array)$files AS $file)	{
			$contents = $this->get_contents( $file.'/style.css' );
			
			if ( preg_match( '@Name:(.*)@', $contents, $matches ) > 0 )
				$name = $matches[1];
			else
				$name = basename( $file );
		
			$skins[basename( $file )] = $name;
		}
		
		return $skins;
	}
	
	function get_stripes() {
		$skins = array();
		$files = glob( dirname( __FILE__ ).'/../stripes/*' );

		foreach( (array)$files AS $file )
			$skins[] = basename( $file );

		return $skins;
	}

	function options_page() {
		$options = GZ::get_options();
		
		if ( isset( $_POST['save'] ) ) {
			$_POST = stripslashes_deep( $_POST );

			$options['author_posts'] = intval( $_POST['author_posts'] );
			$options['top_menu']     = $_POST['top_menu'];
			$options['main_menu']    = $_POST['main_menu'];
			$options['bottom_menu']  = $_POST['bottom_menu'];
			$options['latest']       = $_POST['latest'];
			$options['recent']       = $_POST['recent'];
			$options['exclude']      = $_POST['exclude'];
			$options['copyright']    = $_POST['copyright'];
			$options['feedemail']    = $_POST['feedemail'];
			$options['twitter']      = $_POST['twitter'];
			$options['author']       = isset( $_POST['author'] ) ? true : false;
			$options['show_pings']   = isset( $_POST['show_pings'] ) ? true : false;
			$options['skip_links']   = isset( $_POST['skip_links'] ) ? true : false;
			$options['login_menu']   = isset( $_POST['login_menu'] ) ? true : false;
			$options['footer_logo']  = isset( $_POST['footer_logo'] ) ? true : false;
			$options['exclude']      = preg_replace( '/[^0-9,]/', '', $options['exclude'] );

			update_option( 'guangzhou_options', $options );
			
			$this->render_message( __( 'Your options have been saved', 'guangzhou' ) );
		}

		$terms = get_terms( 'link_category', 'hide_empty=1' );
		$menus = array();
		
		foreach( (array)$terms AS $menu)
			$menus[$menu->name] = $menu->name;
		
		$this->render_admin( 'options', array( 'options' => $options, 'menus' => $menus ) );
	}

	function options_skin()	{
		$options = GZ::get_options();
		
		if ( isset( $_POST['save'] ) ) {
			$_POST = stripslashes_deep( $_POST );

			$options['skin']          = $_POST['skin'];
			$options['skin_url']      = $_POST['skin_url'];
			$options['page_width']    = intval( $_POST['page_width'] );

			update_option( 'guangzhou_options', $options );

			$this->render_message( __( 'Your options have been saved', 'guangzhou' ) );
		}

		$stripes = $this->get_stripes();
		$skins   = $this->get_skins();
		
		$this->render_admin( 'skin', array( 'stripes' => $stripes, 'skins' => $skins, 'options' => $options ) );
	}
	
	function options_support() {
		$this->render_admin( 'support' );
	}
	
	function admin_menu() {
		add_theme_page( __( 'Guangzhou Options', 'guangzhou' ), __( 'Guangzhou Options', 'guangzhou' ), 'edit_themes', 'options', array( &$this, 'options_page' ) );
		add_theme_page( __( 'Guangzhou Skin', 'guangzhou' ), __( 'Guangzhou Skin', 'guangzhou' ), 'edit_themes', 'skins', array( &$this, 'options_skin' ) );
		add_theme_page( __( 'Guangzhou Support', 'guangzhou' ), __( 'Guangzhou Support', 'guangzhou' ), 'edit_themes', 'support', array( &$this, 'options_support' ) );
	}
	
	function locales() {
		$locales = array( __( 'English', 'guangzhou' ) => __( 'Provided by default', 'guangzhou' ) );
		$readme  = @file_get_contents( dirname( __FILE__ ).'/readme.txt' );
		if ( $readme ) {
			if ( preg_match_all( '/^\* (.*?) by \[(.*?)\]\((.*?)\)/m', $readme, $matches ) ) {
				foreach ( $matches[1] AS $pos => $match ) {
					$locales[$match] = '<a href="'.$matches[3][$pos].'">'.$matches[2][$pos].'</a>';
				}
			}
		}
		
		ksort( $locales );
		return $locales;
	}
	
	/**
	 * WordPress contextual help. 2.7+
	 *
	 * @return string
	 **/
	function contextual_help( $help, $screen ) {
		if ( in_array( $screen, array( 'appearance_page_support', 'appearance_page_options', 'appearance_page_skins' ) ) ) {
			$help .= '<h5>' . __( 'Guangzhou Help' ) . '</h5><div class="metabox-prefs">';
			$help .= '<a href="http://urbangiraffe.com/themes/guangzhou/">'.__( 'Guangzhou Documentation', 'guangzhou' ).'</a><br/>';
			$help .= '<a href="http://urbangiraffe.com/support/forum/guangzhou">'.__( 'Guangzhou Support Forum', 'guangzhou' ).'</a><br/>';
			$help .= '<a href="http://urbangiraffe.com/tracker/projects/guangzhou/issues?set_filter=1&amp;tracker_id=1">'.__( 'Guangzhou Bug Tracker', 'guangzhou' ).'</a><br/>';
			$help .= '<a href="http://urbangiraffe.com/themes/guangzhou/faq/">'.__( 'Guangzhou FAQ', 'guangzhou' ).'</a><br/>';
			$help .= '<p>'.__( 'Please read the documentation and FAQ, and check the bug tracker, before asking a question.', 'guangzhou' ).'</p>';
			$help .= '</div>';
		}

		return $help;
	}
}

$gz_admin = new GZ_Admin();
