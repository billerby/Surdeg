<?php
/* get options from database and use default options from bfa_theme_options.php for options where 
nothing is saved in the database yet, move all options into one big array $bfa_ata which can be 
accessed from header.php, footer.php and other files that are either standard Wordpress files 
(page.php, single.php, category.php, 404.php etc...) or are called from within one of these standard files, 
i.e. through include(...) or get_header(). 

Put "global $bfa_ata" on top of any of these files to access 
theme options like this: echo $bfa_ata['option_name_here'] */

global $options, $bfa_ata;

foreach ($options as $value) { 

	if (get_option( $value['id'] ) === FALSE) 
		$$value['id'] = $value['std']; 
	else  
		$$value['id'] = get_option( $value['id'] ); 
	
	$short_func_name = str_replace("bfa_ata_", "", $value['id']);
	$bfa_ata[$short_func_name] = $$value['id'];
	
}


$bfa_ata['siteurl'] = get_option('siteurl');
$bfa_ata['template_directory'] = get_bloginfo('template_directory');

$bfa_ata['get_option_home'] = get_option('home');

ob_start(); bloginfo('name'); $bfa_ata['bloginfo_name'] = ob_get_contents(); ob_end_clean();
ob_start(); bloginfo('description'); $bfa_ata['bloginfo_description'] = ob_get_contents(); ob_end_clean();

ob_start(); bloginfo('comments_rss2_url'); $bfa_ata['bloginfo_comments_rss2_url'] = ob_get_contents(); ob_end_clean();
ob_start(); bloginfo('rss2_url'); $bfa_ata['bloginfo_rss2_url'] = ob_get_contents(); ob_end_clean();

/*
if ( is_page() ) {
	global $wp_query;
	$current_page_id = $wp_query->get_queried_object_id();
	}
*/

global $wp_query;
$bfa_ata['current_page_id'] = $wp_query->get_queried_object_id();


//figure out sidebars and "colspan=XX", based on theme options and type or ID of page that we are currently on:

$cols = 1;

if ( is_page() AND (function_exists('is_front_page') ? !is_front_page() : '') AND !is_home() ) {


	if ($bfa_ata['left_col_pages_exclude'] != "") { 
		$pages_exlude_left = explode(",", str_replace(" ", "", $bfa_ata['left_col_pages_exclude']));
		if ( $bfa_ata['leftcol_on']['page'] AND !in_array($bfa_ata['current_page_id'], $pages_exlude_left) ) {
			$cols++; $left_col = "on";
		}
	} else {
		if ( $bfa_ata['leftcol_on']['page'] ) {
			$cols++; $left_col = "on";
		}
	}

	if ($bfa_ata['left_col2_pages_exclude'] != "") { 
		$pages_exlude_left2 = explode(",", str_replace(" ", "", $bfa_ata['left_col2_pages_exclude']));
		if ( $bfa_ata['leftcol2_on']['page'] AND !in_array($bfa_ata['current_page_id'], $pages_exlude_left2) ) {
			$cols++; $left_col2 = "on";
		}
	} else {
		if ( $bfa_ata['leftcol2_on']['page'] ) {
			$cols++; $left_col2 = "on";
		}
	}
		
	if ($bfa_ata['right_col_pages_exclude'] != "") { 
		$pages_exlude_right = explode(",", str_replace(" ", "", $bfa_ata['right_col_pages_exclude']));
		if ( $bfa_ata['rightcol_on']['page'] AND !in_array($bfa_ata['current_page_id'], $pages_exlude_right) ) {
			$cols++; $right_col = "on"; 
		}
	} else {
		if ( $bfa_ata['rightcol_on']['page'] ) {
			$cols++; $right_col = "on"; 
		}
	}

	if ($bfa_ata['right_col2_pages_exclude'] != "") { 
		$pages_exlude_right2 = explode(",", str_replace(" ", "", $bfa_ata['right_col2_pages_exclude']));
		if ( $bfa_ata['rightcol2_on']['page'] AND !in_array($bfa_ata['current_page_id'], $pages_exlude_right2) ) {
			$cols++; $right_col2 = "on"; 
		}
	} else {
		if ( $bfa_ata['rightcol2_on']['page'] ) {
			$cols++; $right_col2 = "on"; 
		}
	}
	
} elseif ( is_category() ) {

	$current_cat_id = get_query_var('cat');

	if ($bfa_ata['left_col_cats_exclude'] != "") {
		$cats_exlude_left = explode(",", str_replace(" ", "", $bfa_ata['left_col_cats_exclude']));
		if ( $bfa_ata['leftcol_on']['category'] AND !in_array($current_cat_id, $cats_exlude_left) ) {
			$cols++; $left_col = "on"; 
		}
	} else {
		if ( $bfa_ata['leftcol_on']['category'] ) {
			$cols++; $left_col = "on"; 
		}
	}

	if ($bfa_ata['left_col2_cats_exclude'] != "") {
		$cats_exlude_left2 = explode(",", str_replace(" ", "", $bfa_ata['left_col2_cats_exclude']));
		if ( $bfa_ata['leftcol2_on']['category'] AND !in_array($current_cat_id, $cats_exlude_left2) ) {
			$cols++; $left_col2 = "on"; 
		}
	} else {
		if ( $bfa_ata['leftcol2_on']['category'] ) {
			$cols++; $left_col2 = "on"; 
		}
	}
		
	if ($bfa_ata['right_col_cats_exclude'] != "") {
		$cats_exlude_right = explode(",", str_replace(" ", "", $bfa_ata['right_col_cats_exclude']));
		if ( $bfa_ata['rightcol_on']['category'] AND !in_array($current_cat_id, $cats_exlude_right) ) {
			$cols++; $right_col = "on"; 
		}
	} else {
		if ( $bfa_ata['rightcol_on']['category'] ) {
			$cols++; $right_col = "on"; 
		}
	}

	if ($bfa_ata['right_col2_cats_exclude'] != "") {
		$cats_exlude_right2 = explode(",", str_replace(" ", "", $bfa_ata['right_col2_cats_exclude']));
		if ( $bfa_ata['rightcol2_on']['category'] AND !in_array($current_cat_id, $cats_exlude_right2) ) {
			$cols++; $right_col2 = "on"; 
		}
	} else {
		if ( $bfa_ata['rightcol2_on']['category'] ) {
			$cols++; $right_col2 = "on"; 
		}
	}
		
} else {

	if ( (is_home() && $bfa_ata['leftcol_on']['homepage']) OR 
	( function_exists('is_front_page') ? is_front_page() AND $bfa_ata['leftcol_on']['frontpage'] : '') OR 
	( is_single() && $bfa_ata['leftcol_on']['single']) OR ( is_date() AND $bfa_ata['leftcol_on']['date']) OR 
	( is_tag() && $bfa_ata['leftcol_on']['tag']) OR ( is_archive() AND !( is_tag() OR is_author() OR is_date() OR is_category()) && $bfa_ata['leftcol_on']['taxonomy']) 
	OR ( is_search() AND $bfa_ata['leftcol_on']['search']) OR 
	( is_author() && $bfa_ata['leftcol_on']['author']) OR ( is_404() AND $bfa_ata['leftcol_on']['404']) OR 
	( is_attachment() && $bfa_ata['leftcol_on']['attachment']) ) {
		$cols++; $left_col = "on"; 
	}

	if ( (is_home() && $bfa_ata['leftcol2_on']['homepage']) OR 
	( function_exists('is_front_page') ? is_front_page() AND $bfa_ata['leftcol2_on']['frontpage'] : '') OR 
	( is_single() && $bfa_ata['leftcol2_on']['single']) OR ( is_date() AND $bfa_ata['leftcol2_on']['date']) OR 
	( is_tag() && $bfa_ata['leftcol2_on']['tag']) OR ( is_archive() AND !( is_tag() OR is_author() OR is_date() OR is_category()) && $bfa_ata['leftcol2_on']['taxonomy']) 
	OR ( is_search() AND $bfa_ata['leftcol2_on']['search']) OR 
	( is_author() && $bfa_ata['leftcol2_on']['author']) OR ( is_404() AND $bfa_ata['leftcol2_on']['404']) OR 
	( is_attachment() && $bfa_ata['leftcol2_on']['attachment']) ) {
		$cols++; $left_col2 = "on"; 
	}
		
	if ( (is_home() && $bfa_ata['rightcol_on']['homepage']) OR 
	( function_exists('is_front_page') ? is_front_page() AND $bfa_ata['rightcol_on']['frontpage'] : '') OR 
	( is_single() && $bfa_ata['rightcol_on']['single']) OR ( is_date() AND $bfa_ata['rightcol_on']['date']) OR 
	( is_tag() && $bfa_ata['rightcol_on']['tag']) OR ( is_archive() AND !( is_tag() OR is_author() OR is_date() OR is_category()) && $bfa_ata['rightcol_on']['taxonomy']) 
	OR ( is_search() AND $bfa_ata['rightcol_on']['search']) OR 
	( is_author() && $bfa_ata['rightcol_on']['author']) OR ( is_404() AND $bfa_ata['rightcol_on']['404']) OR 
	( is_attachment() && $bfa_ata['rightcol_on']['attachment']) ) {
		$cols++; $right_col = "on"; 
	}

	if ( (is_home() && $bfa_ata['rightcol2_on']['homepage']) OR 
	( function_exists('is_front_page') ? is_front_page() AND $bfa_ata['rightcol2_on']['frontpage'] : '') OR 
	( is_single() && $bfa_ata['rightcol2_on']['single']) OR ( is_date() AND $bfa_ata['rightcol2_on']['date']) OR 
	( is_tag() && $bfa_ata['rightcol2_on']['tag']) OR ( is_archive() AND !( is_tag() OR is_author() OR is_date() OR is_category()) && $bfa_ata['rightcol2_on']['taxonomy']) 
	OR ( is_search() AND $bfa_ata['rightcol2_on']['search']) OR 
	( is_author() && $bfa_ata['rightcol2_on']['author']) OR ( is_404() AND $bfa_ata['rightcol2_on']['404']) OR 
	( is_attachment() && $bfa_ata['rightcol2_on']['attachment']) ) {
		$cols++; $right_col2 = "on"; 
	}
		
}


// Put the sidebar results into our global options variable in case we need it somewhere else:
$bfa_ata['cols'] = $cols;
$bfa_ata['left_col'] = $left_col;
$bfa_ata['left_col2'] = $left_col2;
$bfa_ata['right_col'] = $right_col;
$bfa_ata['right_col2'] = $right_col2;



// $bfa_ata['h1_on_single_pages'] turn the blogtitle to h2 and the post/page title to h1 on single post pages and static "page" pages
if ( $bfa_ata['h1_on_single_pages'] == "Yes"  AND ( is_single() OR is_page() ) ) {
	$bfa_ata['h_blogtitle'] = 2; $bfa_ata['h_posttitle'] = 1; 
} else {
	$bfa_ata['h_blogtitle'] = 1; $bfa_ata['h_posttitle'] = 2; 
}



?>