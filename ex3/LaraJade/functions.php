<?php
/*
    Description: Lara Jade Theme functions
    Version: 1.0.0
    Authors: Amrollah Seifoddini, Matthias Bloch, David Lanyi
*/

/*------------------------------------*\
	Theme Support
\*------------------------------------*/

if (function_exists('add_theme_support'))
{
    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
}

/*------------------------------------*\
	Start Session
\*------------------------------------*/

function register_session(){
        if( !session_id())
            session_start();
}

add_action('init','register_session');

$tmpl_uri = get_template_directory_uri();
$img_uri = get_template_directory_uri().'/img/';

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/


/*------------------------------------*\
	JS
\*------------------------------------*/

// Load scripts
function lj_header_scripts()
{
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
		
        wp_register_script('jq-ui', get_template_directory_uri() . '/js/vendor/jquery-ui.min.js', array('jquery'), '1.0.0'); // jq ui
		wp_enqueue_script('jq-ui'); // Enqueue it!
		
        wp_register_script('pin_menu', get_template_directory_uri() . '/js/pin_menu.js', array('jquery'), '1.0.0'); // Pin Menu
		wp_enqueue_script('pin_menu'); // Enqueue it!
		
        wp_register_script('scripts', get_template_directory_uri() . '/js/scripts.js', array('jquery'), '1.0.0'); // Custom scripts
        wp_localize_script('scripts', 'WPURLS', array( 'site_url' => get_option('siteurl'), 'template_url' => get_bloginfo('template_url') )); // Add Page Structure
		wp_enqueue_script('scripts'); // Enqueue it!

    }
}

// Load conditional scripts
function lj_conditional_scripts()
{
    if (is_admin()) {
	
		
    }
}

/*------------------------------------*\
	Stylesheets
\*------------------------------------*/

// Load styles
function lj_styles()
{
	
    wp_register_style('lj_template', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
    wp_enqueue_style('lj_template'); // Enqueue it!

}

/*------------------------------------*\
	Content manipulation
\*------------------------------------*/

/*------------------------------------*\
	Actions, Filters, ShortCodes
\*------------------------------------*/

// Add Actions
add_action('init', 'lj_header_scripts'); // Add Custom Scripts to wp_head
add_action('wp_print_scripts', 'lj_conditional_scripts'); // Add Conditional Page Scripts
add_action('wp_enqueue_scripts', 'lj_styles'); // Add Theme Stylesheet

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

// Add Filters

// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

/*------------------------------------*\
	Display functions
\*------------------------------------*/


?>
