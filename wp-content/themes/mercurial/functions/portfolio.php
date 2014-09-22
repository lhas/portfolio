<?php

/*-----------------------------------------------------------------------------------*/
/* create custom post => portfolio
/*-----------------------------------------------------------------------------------*/
if (!function_exists('create_portfolio')) {
    function create_portfolio()
    {
        $portfolio_args = array(
            'label' => __('Portfolio', 'framework'),
            'singular_label' => __('Portfolio', 'framework'),
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => true,
            'supports' => array('title', 'editor', 'excerpt'));
        register_post_type('portfolio', $portfolio_args);
    }

    add_action('init', 'create_portfolio');
}
// create custom portfolio tags taxonomy

if (!function_exists('create_portfolio_tags')) {
    function create_portfolio_tags()
    {
        $labels = array(
            'name' => _x('Categories', 'framework'),
            'singular_name' => _x('Categories', 'framework'),
            'search_items' => __('Search Portfolio Categories', 'framework'),
            'all_items' => __('All Locations', 'framework'),
            'parent_item' => __('Parent Location', 'framework'),
            'parent_item_colon' => __('Parent Location:', 'framework'),
            'edit_item' => __('Edit Category', 'framework'),
            'update_item' => __('Update Category', 'framework'),
            'add_new_item' => __('Add New Category', 'framework'),
            'new_item_name' => __('New Category Name', 'framework'),
        );

        register_taxonomy(
            'port-cat',
            'portfolio',
            array('hierarchical' => true,
                'labels' => $labels,
            ));

    }

    add_action('init', 'create_portfolio_tags');
}

/*-----------------------------------------------------------------------------------*/
/* Add portfolio Columns
/*-----------------------------------------------------------------------------------*/
if (!function_exists('add_new_portfolio_columns')) {
    function add_new_portfolio_columns($gallery_columns)
    {
        $new_columns['cb'] = '<input type="checkbox" />';
        $new_columns['title'] = "Title";
        $new_columns['categories1'] = 'Categories';
        $new_columns['date'] = _x('Date', 'column name');

        return $new_columns;
    }

    add_filter('manage_edit-portfolio_columns', 'add_new_portfolio_columns');
}
if (!function_exists('coll_port_cat_column')) {
    function coll_port_cat_column($column, $post_id)
    {
        global $post;

        switch ($column) {
            /* If displaying the 'genre' column. */
            case 'categories1' :

                /* Get the genres for the post. */
                $terms = get_the_terms($post_id, 'port-cat');

                /* If terms were found. */
                if (!empty($terms)) {

                    $out = array();

                    /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                    foreach ($terms as $term) {
                        $out[] = sprintf('<a href="%s">%s</a>',
                            esc_url(add_query_arg(array('post_type' => $post->post_type, 'port-cat' => $term->slug), 'edit.php')),
                            esc_html(sanitize_term_field('name', $term->name, $term->term_id, 'port-cat', 'display'))
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

    add_action('manage_portfolio_posts_custom_column', 'coll_port_cat_column', 10, 2);
}
/*-----------------------------------------------------------------------------------*/
/* add tag classes to the portfolio item post_class
/*-----------------------------------------------------------------------------------*/

if (!function_exists('add_portfolio_post_classes')) {
    function add_portfolio_post_classes($classes)
    {
        global $post;
        $terms = wp_get_object_terms($post->ID, 'port-cat');
        foreach ($terms as $tag) {
            $classes[] = $tag->slug;
        }
        return $classes;
    }

    add_filter('post_class', 'add_portfolio_post_classes');
}

