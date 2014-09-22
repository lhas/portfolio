<?php

/*-----------------------------------------------------------------------------------*/
/* create custom post => infocolumns
/*-----------------------------------------------------------------------------------*/
if (!function_exists('create_sliders')) {
    function create_sliders()
    {
        $args = array(
            'label' => __('Slides', 'framework'),
            'singular_label' => __('Slide', 'framework'),
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => true,
            'supports' => array('title', 'editor'));
        register_post_type('sliders', $args);
    }

    add_action('init', 'create_sliders');
}
// create custom portfolio tags taxonomy

if (!function_exists('create_slider')) {
    function create_slider()
    {
        $labels = array(
            'name' => _x('Sliders', 'framework'),
            'singular_name' => _x('Slider', 'framework'),
            'search_items' => __('Search Sliders', 'framework'),
            'all_items' => __('All Sliders', 'framework'),
            'parent_item' => __('Parent Slider', 'framework'),
            'parent_item_colon' => __('Parent Slider:', 'framework'),
            'edit_item' => __('Edit Slider', 'framework'),
            'update_item' => __('Update Slider', 'framework'),
            'add_new_item' => __('Add New Slider', 'framework'),
            'new_item_name' => __('New Slider Name', 'framework'),
        );

        register_taxonomy(
            'slider',
            'sliders',
            array('hierarchical' => true,
                'labels' => $labels,
            ));

    }

    add_action('init', 'create_slider');
}

/*-----------------------------------------------------------------------------------*/
/* Add portfolio Columns
/*-----------------------------------------------------------------------------------*/
if (!function_exists('add_new_sliders_columns')) {
    function add_new_sliders_columns($gallery_columns)
    {
        $new_columns['cb'] = '<input type="checkbox" />';
        $new_columns['title'] = "Title";
        $new_columns['categories1'] = 'Slider';
        $new_columns['date'] = _x('Date', 'column name');

        return $new_columns;
    }

    add_filter('manage_edit-sliders_columns', 'add_new_sliders_columns');
}
if (!function_exists('coll_slider_column')) {
    function coll_slider_column($column, $post_id)
    {
        global $post;

        switch ($column) {
            /* If displaying the 'genre' column. */
            case 'categories1' :

                /* Get the genres for the post. */
                $terms = get_the_terms($post_id, 'slider');

                /* If terms were found. */
                if (!empty($terms)) {

                    $out = array();

                    /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                    foreach ($terms as $term) {
                        $out[] = sprintf('<a href="%s">%s</a>',
                            esc_url(add_query_arg(array('post_type' => $post->post_type, 'slider' => $term->slug), 'edit.php')),
                            esc_html(sanitize_term_field('name', $term->name, $term->term_id, 'slider', 'display'))
                        );
                    }

                    /* Join the terms, separating them with a comma. */
                    echo join(', ', $out);
                } /* If no terms were found, output a default message. */
                else {
                    _e('No Genres', 'framework');
                }

                break;

            /* Just break out of the switch statement for everything else. */
            default :
                break;
        }
    }

    add_action('manage_sliders_posts_custom_column', 'coll_slider_column', 10, 2);
}
