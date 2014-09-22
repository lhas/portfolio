<?php

/*-----------------------------------------------------------------------------------*/
/* create custom post => front page sections
/*-----------------------------------------------------------------------------------*/
if (!function_exists('create_fp_sections')) {
    function create_fp_sections()
    {
        $fps_args = array(
            'label' => __('Front Page Sections', 'framework'),
            'singular_label' => __('Section', 'framework'),
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'page',
            'hierarchical' => false,
            'rewrite' => true,
            'supports' => array('title', 'editor', 'page-attributes'));
        register_post_type('fp-sections', $fps_args);
    }

    add_action('init', 'create_fp_sections');
}
