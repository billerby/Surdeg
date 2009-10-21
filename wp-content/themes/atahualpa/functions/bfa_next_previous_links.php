<?php

/* Check if several pages exist to avoid empty
   next/prev navigation on multi post pages */

function show_posts_nav() {
	global $wp_query;
	return ($wp_query->max_num_pages > 1) ? TRUE : FALSE;
}


global $bfa_ata;

/* if this is a multi post page, and a "home" link is set for the next/prev
   navigation on multi post pages, figure out if we are on the blog homepage,
   and remove the "home" link from the next/prev navigation if true */

if ( !is_single() AND !is_page() AND $bfa_ata['home_multi_next_prev'] != '' ) {

	$nav_home_div_on = '<div class="home"><a href="' . $bfa_ata['get_option_home'] . '/">' . 
	$bfa_ata['home_multi_next_prev'] . '</a></div>'; 
	
	// for WP 2.5 and newer
	if ( function_exists('is_front_page') ) {

		// make sure this is the real homepage and not a subsequent page
		if ( is_front_page() AND !is_paged() ) {
			$nav_home_add = ""; $nav_home_div = ""; 
		} else {
			$nav_home_add = '-home';
			$nav_home_div = $nav_home_div_on; 
		}
	} 
	
	/* For WP 2.3 and older: Make sure this is the real homepage
       and not a subsequent page */
	elseif ( is_home() AND !is_paged() ) {
		$nav_home_add = ""; $nav_home_div = "";
	} else { 
		$nav_home_add = '-home'; 
		$nav_home_div = $nav_home_div_on; 
	}
	
}




// Home link for next/prev on single pages

if ( is_single() ) {

	if ( $bfa_ata['home_single_next_prev'] != '' ) {

		$nav_home_div_on_single = '<div class="home"><a href="' .
        $bfa_ata['get_option_home'] . '/">' .
		$bfa_ata['home_single_next_prev'] . '</a></div>';
		$nav_home_add_single = '-home';

	} else {

		$nav_home_div_on_single = "";
		$nav_home_add_single = "";

	}
}




/* Next/Previous PAGE Links (on multi post pages)
   in next_posts_link "next" means older posts
   Available parameters for $location: Top, Bottom. Default: Top */

function bfa_next_previous_page_links($location = "Top") {

global $bfa_ata;

	if ( !is_single() AND !is_page() AND
    strpos($bfa_ata['location_multi_next_prev'],$location) !== FALSE AND
    
    // don't display on WP Email pages
    intval(get_query_var('email')) != 1 AND
    
    // display only if next/prev links actually exist
    show_posts_nav() ) {

		if ( function_exists('wp_pagenavi') ) {

			echo '<div class="wp-pagenavi-navigation">'; wp_pagenavi();
			echo '</div>';

		} else {

			echo '<div class="navigation-'.strtolower($location).'">
			<div class="older' . $nav_home_add . '">';

			$bfa_ata['next_prev_orientation'] == 'Older Left, Newer Right' ? 
			next_posts_link($bfa_ata['multi_next_prev_older']) : 
			previous_posts_link($bfa_ata['multi_next_prev_newer']);

			echo ' &nbsp;</div>' . $nav_home_div . '<div class="newer' .
            $nav_home_add . '">&nbsp; ';

			$bfa_ata['next_prev_orientation'] == 'Older Left, Newer Right' ? 
			previous_posts_link($bfa_ata['multi_next_prev_newer']) : 
			next_posts_link($bfa_ata['multi_next_prev_older']);

			echo '</div><div class="clearboth"></div></div>';

		}

	} 						
}




/* Next/Previous POST Links (on single post pages)
   in next_post_link "next" means newer posts
   Available parameters for $location: Top, Middle, Bottom. Default: Top  */

function bfa_next_previous_post_links($location = "Top") {

global $bfa_ata;

	if ( is_single() AND strpos($bfa_ata['location_single_next_prev'],$location) !== FALSE AND
	
    // don't display on WP Email pages
    intval(get_query_var('email')) != 1 )  {

		echo '<div class="navigation-'.strtolower($location).'">
		<div class="older' . ($bfa_ata['home_single_next_prev'] != '' ?
        '-home' : '') . '">';

		$bfa_ata['next_prev_orientation'] == 'Older Left, Newer Right' ? 
		previous_post_link($bfa_ata['single_next_prev_older']) : 
		next_post_link($bfa_ata['single_next_prev_newer']);

		echo ' &nbsp;</div>' . ($bfa_ata['home_single_next_prev'] != '' ?
        '<div class="home"><a href="' . $bfa_ata['get_option_home'] . '/">' .
        $bfa_ata['home_single_next_prev'] . '</a></div>' : '') .
		'<div class="newer' . ($bfa_ata['home_single_next_prev'] != '' ?
        '-home' : '') . '">&nbsp; ';

		$bfa_ata['next_prev_orientation'] == 'Older Left, Newer Right' ? 
		next_post_link($bfa_ata['single_next_prev_newer']) : 
		previous_post_link($bfa_ata['single_next_prev_older']);

		echo '</div><div class="clearboth"></div></div>';

	}

}




/* Next/Previous Comments Links.
   In next_comments_link "next" means newer.
   If navigation above comments is set: */

function bfa_next_previous_comments_links($location = "Above") {

global $bfa_ata;

  if ( strpos($bfa_ata['location_comments_next_prev'],$location) !== FALSE ) {

    // if any navigation links exist, paginated or next/previous:
    if ( get_comment_pages_count() > 1 ) {

      // Overall navigation container
      echo '<div class="navigation-comments-'.strtolower($location).'">';

    	if ( $bfa_ata['next_prev_comments_pagination'] == "Yes" ) {

    	    // paginated links
    		paginate_comments_links(array(
    		'prev_text' => $bfa_ata['comments_next_prev_older'],
    		'next_text' => $bfa_ata['comments_next_prev_newer'],
    		));

    	} else {

    	    // next/previous links
    		echo '<div class="older">';

    		$bfa_ata['next_prev_orientation'] == 'Older Left, Newer Right' ?
    		previous_comments_link($bfa_ata['comments_next_prev_older']) :
    		next_comments_link($bfa_ata['comments_next_prev_newer']);

    		echo ' &nbsp;</div><div class="newer">&nbsp; ';

    		$bfa_ata['next_prev_orientation'] == 'Older Left, Newer Right' ?
    		next_comments_link($bfa_ata['comments_next_prev_newer']) :
    		previous_comments_link($bfa_ata['comments_next_prev_older']);

    		echo '</div><div style="clear:both"></div>';

    	}
      echo '</div>';
    }
  }

}


?>