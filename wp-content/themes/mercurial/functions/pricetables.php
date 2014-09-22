<?php

/*-----------------------------------------------------------------------------------*/
/* create custom post => infocolumns
/*-----------------------------------------------------------------------------------*/
if (!function_exists('create_pricetable')) {
    function create_pricetable()
    {
        $price_args = array(
            'label' => __('Prices', 'framework'),
            'singular_label' => __('Price Column', 'framework'),
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => true,
            'supports' => array('title', 'editor'));
        register_post_type('pricetables', $price_args);
    }

    add_action('init', 'create_pricetable');
}
// create custom portfolio tags taxonomy

if (!function_exists('create_price_table')) {
    function create_price_table()
    {
        $labels = array(
            'name' => _x('Tables', 'framework'),
            'singular_name' => _x('Table', 'framework'),
            'search_items' => __('Search Price Tables', 'framework'),
            'all_items' => __('All Price Tables', 'framework'),
            'parent_item' => __('Parent Table', 'framework'),
            'parent_item_colon' => __('Parent Table:', 'framework'),
            'edit_item' => __('Edit Table', 'framework'),
            'update_item' => __('Update Table', 'framework'),
            'add_new_item' => __('Add New Table', 'framework'),
            'new_item_name' => __('New Table Name', 'framework'),
        );

        register_taxonomy(
            'price-table',
            'pricetables',
            array('hierarchical' => true,
                'labels' => $labels,
            ));

    }

    add_action('init', 'create_price_table');
}

/*-----------------------------------------------------------------------------------*/
/* Add portfolio Columns
/*-----------------------------------------------------------------------------------*/
if (!function_exists('add_new_pricetables_columns')) {
    function add_new_pricetables_columns($gallery_columns)
    {
        $new_columns['cb'] = '<input type="checkbox" />';
        $new_columns['title'] = "Title";
        $new_columns['categories1'] = 'Categories';
        $new_columns['date'] = _x('Date', 'column name');

        return $new_columns;
    }

    add_filter('manage_edit-pricetables_columns', 'add_new_pricetables_columns');
}
if (!function_exists('coll_price_table_column')) {
    function coll_price_table_column($column, $post_id)
    {
        global $post;

        switch ($column) {
            /* If displaying the 'genre' column. */
            case 'categories1' :

                /* Get the genres for the post. */
                $terms = get_the_terms($post_id, 'price-table');

                /* If terms were found. */
                if (!empty($terms)) {

                    $out = array();

                    /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                    foreach ($terms as $term) {
                        $out[] = sprintf('<a href="%s">%s</a>',
                            esc_url(add_query_arg(array('post_type' => $post->post_type, 'price-table' => $term->slug), 'edit.php')),
                            esc_html(sanitize_term_field('name', $term->name, $term->term_id, 'price-table', 'display'))
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

    add_action('manage_pricetables_posts_custom_column', 'coll_price_table_column', 10, 2);
}
