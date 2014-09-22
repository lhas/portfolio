<?php
/*-----------------------------------------------------------------------------------*/
/*	Load Translation Text Domain
/*-----------------------------------------------------------------------------------*/

load_theme_textdomain('framework');


/*-----------------------------------------------------------------------------------*/
/*	register WP3.0+ menus
/*-----------------------------------------------------------------------------------*/
if (!function_exists('register_menu')) {
    function register_menu()
    {
        register_nav_menu('primary-menu', __('Main Menu', 'framework'));
    }

    add_action('init', 'register_menu');
}
/*-----------------------------------------------------------------------------------*/
/*	search only posts
/*-----------------------------------------------------------------------------------*/
if (!function_exists('search_only_posts')) {
    function search_only_posts($query)
    {
        if ($query->is_search) {
            $query->set('post_type', 'post');
        }
        return $query;
    }

    add_filter('pre_get_posts', 'search_only_posts');
}

/*-----------------------------------------------------------------------------------*/
/* Enable post formats
/*-----------------------------------------------------------------------------------*/
$formats = array(
    'gallery',
    'video'
);

add_theme_support('post-formats', $formats);
add_post_type_support('post', 'post-formats');

/*-----------------------------------------------------------------------------------*/
/*	Configure WP2.9+ Thumbnails
/*-----------------------------------------------------------------------------------*/
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
    //set_post_thumbnail_size(336, 188, true); // default Post Thumbnail dimensions
}

if (function_exists('add_image_size')) {
//    add_image_size('thumbnail-large', 745, 9999, false); // for blog pages
//    add_image_size('slider-large', 960, 9999, false); // for blog pages
}


/*-----------------------------------------------------------------------------------*/
/*	Change Default Excerpt Length
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_excerpt_length')) {
    function coll_excerpt_length($length)
    {
        return 17;
    }

    add_filter('excerpt_length', 'coll_excerpt_length');
}
/*-----------------------------------------------------------------------------------*/
/*	Configure Excerpt String
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_excerpt_more')) {
    function coll_excerpt_more($excerpt)
    {
        return str_replace('[...]', '', $excerpt);
    }

    add_filter('wp_trim_excerpt', 'coll_excerpt_more');

}

/*-----------------------------------------------------------------------------------*/
/* enable sidebars
/*-----------------------------------------------------------------------------------*/
//
//if (function_exists('register_sidebar')) {
//    register_sidebar(array(
//        'name' => 'Main Sidebar',
//        'before_widget' => '<div id="%1$s" class="widget %2$s">',
//        'after_widget' => '</div>',
//        'before_title' => '<h3 class="widget-title"><span>',
//        'after_title' => '</span></h3>',
//    ));
//}

/*-----------------------------------------------------------------------------------*/
/* Extra
/*-----------------------------------------------------------------------------------*/
add_theme_support('automatic-feed-links');
if (!isset($content_width)) $content_width = 1140;