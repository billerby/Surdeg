<?php

// Using hooks is absolutely the smartest, most bulletproof way to implement things like plugins,
// custom design elements, and ads. You can add your hook calls below, and they should take the 
// following form:
// add_action('thesis_hook_name', 'function_name');
// The function you name above will run at the location of the specified hook. The example
// hook below demonstrates how you can insert Thesis' default recent posts widget above
// the content in Sidebar 1:
// add_action('thesis_hook_before_sidebar_1', 'thesis_widget_recent_posts');

// Delete this line, including the dashes to the left, and add your hooks in its place.

/**
 * function custom_bookmark_links() - outputs an HTML list of bookmarking links
 * NOTE: This only works when called from inside the WordPress loop!
 * SECOND NOTE: This is really just a sample function to show you how to use custom functions!
 *
 * @since 1.0
 * @global object $post
*/

function custom_bookmark_links() {
	global $post;
?>
<ul class="bookmark_links">
	<li><a rel="nofollow" href="http://delicious.com/save?url=<?php urlencode(the_permalink()); ?>&amp;title=<?php urlencode(the_title()); ?>" onclick="window.open('http://delicious.com/save?v=5&amp;noui&amp;jump=close&amp;url=<?php urlencode(the_permalink()); ?>&amp;title=<?php urlencode(the_title()); ?>', 'delicious', 'toolbar=no,width=550,height=550'); return false;" title="Bookmark this post on del.icio.us">Bookmark this article on Delicious</a></li>
</ul>
<?php
}
remove_action('thesis_hook_before_header', 'thesis_nav_menu');
add_action('thesis_hook_after_header', 'thesis_nav_menu');
remove_action('thesis_hook_footer', 'thesis_attribution');

function my_footer() { 
  echo '<p><a href="mailto:admin@riktigtbrod.se">Kontakta oss</a></p>'; 
         
} 
add_action('thesis_hook_footer', 'my_footer');  

function my_featurebox (){
	
	global $wpdb; 
    if (is_front_page()) { 
    echo '<div class="textbox">';
    $feature_sida = get_page_by_title('valkommen'); 
    echo $feature_sida->post_content;
    echo '</div>';
    } 
}
add_action('thesis_hook_feature_box', 'my_featurebox', '1');
