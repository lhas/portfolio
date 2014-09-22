<?php

/*-----------------------------------------------------------------------------------*/
/* Embed javascripts
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_scripts_method')) {
    function coll_scripts_method()
    {
        // script
        wp_register_script('mq', get_template_directory_uri() . '/js/css3-mediaqueries.js', '', NULL, FALSE);
        wp_register_script('modernizer', get_template_directory_uri() . '/js/modernizr-2.6.1.min.js', '', NULL, FALSE);
        wp_register_script('superfish', get_template_directory_uri() . '/js/superfish.js', '', NULL, true);
        wp_register_script('jqueryui', get_template_directory_uri() . '/js/jquery-ui-1.9.2.custom.min.js', '', NULL, true);
        wp_register_script('localscroll', get_template_directory_uri() . '/js/jquery.localscroll-1.2.7-min.js', '', NULL, true);
        wp_register_script('scrollto', get_template_directory_uri() . '/js/jquery.scrollTo.min.js', '', NULL, true);
        wp_register_script('inview', get_template_directory_uri() . '/js/jquery.inview.min.js', '', NULL, true);
        wp_register_script('validation', 'http://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js', 'jquery', NULL, true);
        wp_register_script('commons', get_template_directory_uri() . '/js/common.js', '', NULL, true);
        wp_register_script('frontpage', get_template_directory_uri() . '/js/front.page.js', '', NULL, true);
        wp_register_script('fitvids', get_template_directory_uri() . '/js/jquery.fitvids.js', '', NULL, true);
        wp_register_script('isotope', get_template_directory_uri() . '/js/jquery.isotope.min.js', '', NULL, true);
        wp_register_script('siteloader', get_template_directory_uri() . '/js/preloader.js', '', NULL, false);
        wp_register_script('lightbox', get_template_directory_uri() . '/js/jquery.slidebox.js', '', NULL, true);
        wp_register_script('sresize', get_template_directory_uri() . '/js/jquery.smartresize.js', '', NULL, true);
        wp_register_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', '', NULL, true);
        wp_register_script('touchswipe', get_template_directory_uri() . '/js/jquery.touchSwipe.min.js', '', NULL, true);
        wp_register_script('mousewheel', get_template_directory_uri() . '/js/jquery.mousewheel.min.js', '', NULL, true);
        wp_register_script('predirect', get_template_directory_uri() . '/js/portfolio.item.js', '', NULL, true);
        wp_register_script('twitter', get_template_directory_uri() . '/functions/js/twitter.js', '', NULL, true);
        wp_register_script('retina', get_template_directory_uri() . '/js/retina.js', '', NULL, true);



        wp_enqueue_script('jquery');
        wp_enqueue_script('mq');
        wp_enqueue_script('modernizer');
        wp_enqueue_script('sresize');
        wp_enqueue_script('jqueryui');
        wp_enqueue_script('twitter');
        wp_enqueue_script('retina');
//        wp_enqueue_script('fittext');


        if (is_home()) {
            wp_enqueue_script('localscroll');
            wp_enqueue_script('scrollto');
            wp_enqueue_script('inview');
            wp_enqueue_script('mousewheel');
            wp_enqueue_script('superfish');
            wp_enqueue_script('fitvids');
            wp_enqueue_script('isotope');
            wp_enqueue_script('lightbox');
            wp_enqueue_script('siteloader');
            wp_enqueue_script('touchswipe');
            wp_enqueue_script('flexslider');
            wp_enqueue_script('commons');
            wp_enqueue_script('frontpage');

        }

        if (is_singular('post')) {
            wp_enqueue_script('comment-reply');
        }

        if (is_singular('portfolio')) {
            wp_enqueue_script('predirect');
        }

        if (is_page() || is_singular('post') || is_archive()){
            wp_enqueue_script('superfish');
            wp_enqueue_script('fitvids');
            wp_enqueue_script('isotope');
            wp_enqueue_script('lightbox');
            wp_enqueue_script('touchswipe');
            wp_enqueue_script('flexslider');
            wp_enqueue_script('commons');
        }


    }

    add_action('wp_enqueue_scripts', 'coll_scripts_method');
}