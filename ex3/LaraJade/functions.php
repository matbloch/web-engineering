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
	Backend
\*------------------------------------*/

require('inc/contactform.php');

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

require('inc/cpt.php');

$cpts = new CPT();

/*------------------------------------*\
	Post to portfolio relation
\*------------------------------------*/


function my_connection_types() {
    p2p_register_connection_type( array(
        'name' => 'posts_to_portfolios',
        'from' => 'post',
        'to' => 'portfolio'
    ) );
}
add_action( 'p2p_init', 'my_connection_types' );

/*------------------------------------*\
	Pagination
\*------------------------------------*/

function my_pagination($pages = '', $range = 1)
{  
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   

     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}

/*------------------------------------*\
	Custom headers
\*------------------------------------*/

$args = array(
	'flex-width'    => true,
	'width'         => 1000,
	'flex-height'    => true,
	'height'        => 200,
	'default-image' => get_template_directory_uri() . '/img/header1.jpg',
	'uploads'       => true,
);
add_theme_support( 'custom-header', $args );


/*------------------------------------*\
	Theme customize page
\*------------------------------------*/

function my_customizer_menu() {
    add_theme_page( 'Customize', 'myCustomize', 'edit_theme_options', 'customize.php' );
}
add_action( 'admin_menu', 'my_customizer_menu' );

/**
 * Adds the individual sections, settings, and controls to the theme customizer
 */
function my_customizer( $wp_customize ) {
    $wp_customize->add_section(
        'contact_section',
        array(
            'title' => 'Contact Info Settings',
            'description' => '',
            'priority' => 35,
        )
    );
    $wp_customize->add_setting(
    'contact_address',
    array(
        'default' => get_theme_mod( 'contact_address', 'No contact address has been set yet.' ),
    )
);
$wp_customize->add_control(
    'contact_address',
    array(
        'label' => 'Address text',
        'section' => 'contact_section',
        'type' => 'text',
    )
);

$wp_customize->add_setting(
    'contact_phone',
    array(
        'default' => get_theme_mod( 'contact_phone', '' ),
    )
);
$wp_customize->add_control(
    'contact_phone',
    array(
        'label' => 'Phone number',
        'section' => 'contact_section',
        'type' => 'text',
    )
);

$wp_customize->add_setting(
    'contact_email',
    array(
        'default' => get_theme_mod( 'contact_email', '' ),
    )
);
$wp_customize->add_control(
    'contact_email',
    array(
        'label' => 'Email Address',
        'section' => 'contact_section',
        'type' => 'text',
    )
);


$wp_customize->add_setting(
    'headline-color',
    array(
        'default' => get_theme_mod( 'headline-color', '#444444' ),
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
 
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'headline-color',
        array(
            'label' => 'Headline text color',
            'section' => 'colors',
            'settings' => 'headline-color'
        )
    )
);


$wp_customize->add_setting(
    'background-color',
    array(
        'default' => get_theme_mod( 'background-color', '#2d2d2d' ),
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
 
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'background-color',
        array(
            'label' => 'Background Color',
            'section' => 'colors',
            'settings' => 'background-color'
        )
    )
);

$wp_customize->add_setting(
    'article-color',
    array(
        'default' => get_theme_mod( 'article-color', '#444444' ),
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
 
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'article-color',
        array(
            'label' => 'Article text color',
            'section' => 'colors',
            'settings' => 'article-color'
        )
    )
);
}
add_action( 'customize_register', 'my_customizer' );

define( 'NO_HEADER_TEXT', true );
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

function new_excerpt_more( $more ) {
	return ' <a class="read-more" href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'your-text-domain') . '</a>';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

function lj_excerpt($post, $more = true, $length = 30 ) {    
    if( $post->post_excerpt ) {
        $excerpt = $post->post_excerpt;
    } else {
        $content = $post->post_content;
        $excerpt = wp_trim_words( $content , $length );
    }
	
    echo $excerpt;

	if($more){
		echo '<a class="read_more" href="'.esc_url(get_permalink($post->ID)).'">More</a>';
	}
}


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
