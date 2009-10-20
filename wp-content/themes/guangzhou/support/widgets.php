<?php

/**
 * Include the Guangzhou widgets
 *
 * @author John Godley
 * @version $Id$
 * @copyright John Godley, 26 April, 2009
 * @package WordPress
 **/

if (function_exists ('register_sidebar_widget')) {
	require dirname (__FILE__).'/widget_class.php';
          
	require dirname (__FILE__).'/widgets/feeds.php';
	require dirname (__FILE__).'/widgets/categories.php';
	require dirname (__FILE__).'/widgets/random_posts.php';
	require dirname (__FILE__).'/widgets/recent_comments.php';
	require dirname (__FILE__).'/widgets/search.php';
	require dirname (__FILE__).'/widgets/posts_in_cat.php';
	require dirname (__FILE__).'/widgets/page_info.php';

	$widgets[] = new GZ_Widget_Feeds       ( __( 'Feeds', 'guangzhou' ) );
	$widgets[] = new GZ_Widget_PageInfo    ( __( 'Page Information', 'guangzhou' ) );
	$widgets[] = new GZ_Widget_Search      ( __( 'Search', 'guangzhou' ) );
	$widgets[] = new GZ_Widget_Categories  ( __( 'GZ Categories', 'guangzhou' ) );
	$widgets[] = new GZ_Widget_PostsInCat  ( __( 'Posts in category', 'guangzhou' ) );
	$widgets[] = new GZ_Widget_RandomPosts ( __( 'Random Posts', 'guangzhou' ) );
	$widgets[] = new GZ_Widget_Comments    ( __( 'GZ Recent Comments', 'guangzhou' ) );
	
	foreach ( $widgets AS $pos => $widget ) {
		$widgets[$pos]->initialize();
	}

	register_sidebar( array( 'name' => 'Sidebar', 'before_title' => '<h2>', 'before_widget' => '<li id="%1$s">' ) );
	register_sidebar( array( 'name' => 'Bottom', 'before_title' => '<h2>', 'before_widget' => '<li id="%1$s">' ) );
}
	
?>