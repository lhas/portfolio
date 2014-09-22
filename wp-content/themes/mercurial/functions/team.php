<?php

/*-----------------------------------------------------------------------------------*/
/* create custom post => infocolumns
/*-----------------------------------------------------------------------------------*/
if (!function_exists('create_team')) {
    function create_team()
    {
        $team_args = array(
            'label' => __('Team', 'framework'),
            'singular_label' => __('Team Member', 'framework'),
            'public' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'rewrite' => true,
            'supports' => array('title', 'editor'));
        register_post_type('team', $team_args);
    }

    add_action('init', 'create_team');
}
// create custom portfolio tags taxonomy

if (!function_exists('create_team_blocks')) {
    function create_team_blocks()
    {
        $labels = array(
            'name' => _x('Blocks', 'framework'),
            'singular_name' => _x('Block', 'framework'),
            'search_items' => __('Search Team Blocks', 'framework'),
            'all_items' => __('All Blocks', 'framework'),
            'parent_item' => __('Parent Block', 'framework'),
            'parent_item_colon' => __('Parent Block:', 'framework'),
            'edit_item' => __('Edit Block', 'framework'),
            'update_item' => __('Update Block', 'framework'),
            'add_new_item' => __('Add New Block', 'framework'),
            'new_item_name' => __('New Block Name', 'framework'),
        );

        register_taxonomy(
            'team-block',
            'team',
            array('hierarchical' => true,
                'labels' => $labels,
            ));

    }

    add_action('init', 'create_team_blocks');
}

/*-----------------------------------------------------------------------------------*/
/* Add portfolio Columns
/*-----------------------------------------------------------------------------------*/
if (!function_exists('add_new_team_columns')) {
    function add_new_team_columns($gallery_columns)
    {
        $new_columns['cb'] = '<input type="checkbox" />';
        $new_columns['title'] = "Title";
        $new_columns['categories1'] = 'Categories';
        $new_columns['date'] = _x('Date', 'column name');

        return $new_columns;
    }

    add_filter('manage_edit-team_columns', 'add_new_team_columns');
}
if (!function_exists('coll_team_block_column')) {
    function coll_team_block_column($column, $post_id)
    {
        global $post;

        switch ($column) {
            /* If displaying the 'genre' column. */
            case 'categories1' :

                /* Get the genres for the post. */
                $terms = get_the_terms($post_id, 'team-block');

                /* If terms were found. */
                if (!empty($terms)) {

                    $out = array();

                    /* Loop through each term, linking to the 'edit posts' page for the specific term. */
                    foreach ($terms as $term) {
                        $out[] = sprintf('<a href="%s">%s</a>',
                            esc_url(add_query_arg(array('post_type' => $post->post_type, 'team-block' => $term->slug), 'edit.php')),
                            esc_html(sanitize_term_field('name', $term->name, $term->term_id, 'team-block', 'display'))
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

    add_action('manage_team_posts_custom_column', 'coll_team_block_column', 10, 2);
}
