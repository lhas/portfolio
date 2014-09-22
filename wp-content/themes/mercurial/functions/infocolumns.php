<?php

/*-----------------------------------------------------------------------------------*/
/* create custom post => infocolumns
/*-----------------------------------------------------------------------------------*/
if (!function_exists('create_info_columns')) {
    function create_info_columns()
    {
        $ic_args = array(
            'label' => __('Info Columns', 'framework'),
            'singular_label' => __('InfoColumns', 'framework'),
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => true,
            'supports' => array('title', 'editor'));
        register_post_type('infocolumns', $ic_args);
    }

    add_action('init', 'create_info_columns');
}
// create custom portfolio tags taxonomy

if (!function_exists('create_infocolumns_categories')) {
    function create_infocolumns_categories()
    {
        $labels = array(
            'name' => _x('Blocks', 'framework'),
            'singular_name' => _x('Block', 'framework'),
            'search_items' => __('Search Info Columns Categories', 'framework'),
            'all_items' => __('All Categoies', 'framework'),
            'parent_item' => __('Parent Location', 'framework'),
            'parent_item_colon' => __('Parent Location:', 'framework'),
            'edit_item' => __('Edit Category', 'framework'),
            'update_item' => __('Update Category', 'framework'),
            'add_new_item' => __('Add New Category', 'framework'),
            'new_item_name' => __('New Category Name', 'framework'),
        );

        register_taxonomy(
            'ic-cat',
            'infocolumns',
            array('hierarchical' => true,
                'labels' => $labels,
            ));

    }

    add_action('init', 'create_infocolumns_categories');
}

/*-----------------------------------------------------------------------------------*/
/* Add portfolio Columns
/*-----------------------------------------------------------------------------------*/
if (!function_exists('add_new_infocolumns_columns')) {
    function add_new_infocolumns_columns($gallery_columns)
    {
        $new_columns['cb'] = '<input type="checkbox" />';
        $new_columns['title'] = "Title";
        $new_columns['categories1'] = 'Categories';
        $new_columns['date'] = _x('Date', 'column name');

        return $new_columns;
    }

    add_filter('manage_edit-infocolumns_columns', 'add_new_infocolumns_columns');
}
if (!function_exists('coll_ic_cat_column')) {
    function coll_ic_cat_column($column, $post_id)
    {
        global $post;

        switch ($column) {
            /* If displaying the 'genre' column. */
            case 'categories1' :

                /* Get the genres for the post. */
                $terms = get_the_terms($post_id, 'ic-cat');

                /* If terms were found. */
                if (!empty($terms)) {

                    $out = array();

                    /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                    foreach ($terms as $term) {
                        $out[] = sprintf('<a href="%s">%s</a>',
                            esc_url(add_query_arg(array('post_type' => $post->post_type, 'ic-cat' => $term->slug), 'edit.php')),
                            esc_html(sanitize_term_field('name', $term->name, $term->term_id, 'ic-cat', 'display'))
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

    add_action('manage_infocolumns_posts_custom_column', 'coll_ic_cat_column', 10, 2);
}
