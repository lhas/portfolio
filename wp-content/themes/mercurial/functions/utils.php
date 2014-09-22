<?php
/*-----------------------------------------------------------------------------------*/
/* OTHER CUSTOM CSS
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_other_css')) {
    function coll_other_css()
    {
        global $data;
        $output = '';

        $color = $data['coll_default_menu_color'];
        if (!empty($color)) $output .= ".header {\n\t background-color: $color; \n}\n";
        $color = $data['coll_default_menu_item_color'];
        if (!empty($color)) $output .= ".sf-menu a, .sf-menu a:visited  {\n\t color: $color; \n}\n";
        $color = $data['coll_default_menu_item_over_color'];
        if (!empty($color)) $output .= ".sf-menu li:hover, .sf-menu li.sfHover, .sf-menu a:focus, .sf-menu a:hover, .sf-menu a:active, .sf-menu a.current {\n\t color: $color; \n}\n";

        /* Output our custom styles --------------------------*/
        if ($output <> '') {
            $output = "<!-- Other Custom Styling -->\n<style type=\"text/css\" id=\"other-custom\">\n" . $output . "</style>\n";
            echo stripslashes($output);
        }

    }

    add_action('wp_head', 'coll_other_css');
}
/*-----------------------------------------------------------------------------------*/
/* TITLES
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_title_color_css')) {
    function coll_title_color_css()
    {
        global $data;
        $output = '';


        if (is_home()) { // if its the homepage (scrolling page)
            // gain access to the sections
            $all_pages = new WP_Query(array('post_type' => 'fp-sections', 'order' => 'ASC', 'orderby' => 'menu_order', 'posts_per_page' => -1));
            //print_r($all_pages);
            while ($all_pages->have_posts()) :
                $all_pages->the_post();
                global $post;
                $postid = $post->ID;

                //  text types
                //.............................
                // build selector
                $selector = '.' . implode('.', get_post_class('', $postid)) . ' .text.type';

                // get the color
                $color = get_post_meta($postid, 'coll_title_color', true);

                if (!empty($color)) $output .= "$selector { \n\tcolor: $color; \n\tborder-color: $color; \n}\n";

                //  titles
                //.............................
                $selector = '.' . implode('.', get_post_class('', $postid)) . ' .page-title .text';
                // get the font size
                $fsize = get_post_meta($postid, 'coll_title_font_size', true);

                if (!empty($color)) {
                    if (!empty($fsize)) {
                        $output .= "$selector { \n\tcolor: $color; \n\tborder-color: $color;\n\tfont-size: $fsize" . "px; \n}\n";
                    } else {
                        $output .= "$selector { \n\tcolor: $color; \n\tborder-color: $color; \n}\n";
                    }
                } else {
                    if (!empty($fsize)) {
                        $output .= "$selector { \n\tfont-size: $fsize" . "px; \n}\n";
                    }
                }

            endwhile;
            wp_reset_postdata();
        }

        /* Output our custom styles --------------------------*/
        if ($output <> '') {
            $output = "<!-- Custom Section Title Styling -->\n<style type=\"text/css\" id=\"custom-section-title\">\n" . $output . "</style>\n";
            echo stripslashes($output);
        }

    }

    add_action('wp_head', 'coll_title_color_css');
}

/*-----------------------------------------------------------------------------------*/
/* BACKGROUNDS
/*-----------------------------------------------------------------------------------*/

// backgrounds for sections
if (!function_exists('coll_isert_bg')) {
    function coll_isert_bg($post)
    {
        echo "<div class='page-background'>";
        // Get the unique background image
        $bg_img = get_post_meta($post->ID, 'coll_background_image', true);

        if (empty($bg_img)) {
            // No image supplied, fall back to default values

        } else {
            // Unique background image included
            // Check background position to see if we need to continue
            $bg_pos = get_post_meta($post->ID, 'coll_background_position', true);

            if ($bg_pos == __('Full Screen', 'framework')) {
                $posttitle = $post->post_title;

                // got the details, load the image
                echo '<img class="bgimage" src="' . $bg_img . '" alt="' . $posttitle . '" />';
            }
        }
        echo '<div class="bgimage"></div> ';
        echo "</div>";
    }
}
if (!function_exists('coll_section_background_css')) {
    function coll_section_background_css()
    {
        global $data;
        $output = '';


        // do this only on homepage (scrolling page)
        if (is_home()) {
            // gain access to the sections
            $all_pages = new WP_Query(array('post_type' => 'fp-sections', 'order' => 'ASC', 'orderby' => 'menu_order', 'posts_per_page' => -1));
            //print_r($all_pages);
            while ($all_pages->have_posts()) :
                $all_pages->the_post();
                global $post;
                $postid = $post->ID;

                // build selector
                $selector = '.' . implode('.', get_post_class('', $postid)) . ' .page-background .bgimage';

                // get custom image for page
                $bg_img = get_post_meta($postid, 'coll_background_image', true);

                if (empty($bg_img)) {
                    // no image provided, check for color
                    $bg_color = get_post_meta($postid, 'coll_background_color', true);
                    if (!empty($bg_color)) {
                        $output .= "$selector { \n\tbackground-color: $bg_color; \n}\n";
                    }

                } else {
                    // Custom image provided, check default position
                    $bg_pos = get_post_meta($postid, 'coll_background_position', true);

                    if ($bg_pos != __('Full Screen', 'framework')) {
                        // We aren't dealing with a full screen image, so set up body bg
                        $bg_img = " url($bg_img)";

                        // Handle the pos
                        if ($bg_pos == __('Centered', 'framework')) {
                            $bg_pos = 'center';
                        }
                        $bg_pos = strtolower($bg_pos);

                        // Handle the repeat
                        $bg_repeat = get_post_meta($postid, 'coll_background_repeat', true);
                        if ($bg_repeat == __('No Repeat', 'framework')) {
                            $bg_repeat = 'no-repeat';
                        } elseif ($bg_repeat == __('Repeat', 'framework')) {
                            $bg_repeat = 'repeat';
                        } elseif ($bg_repeat == __('Repeat Horizontally', 'framework')) {
                            $bg_repeat = 'repeat-x';
                        } else {
                            $bg_repeat = 'repeat-y';
                        }

                        $output .= "$selector { \n\tbackground-image: $bg_img;\n\tbackground-repeat: $bg_repeat;\n\tbackground-position: top $bg_pos; \n}\n";


                    }
                }

            endwhile;
            wp_reset_postdata();
        }

        /* Output our custom styles --------------------------*/
        if ($output <> '') {
            $output = "<!-- Custom Section Background Styling -->\n<style type=\"text/css\" id=\"custom-section-style\">\n" . $output . "</style>\n";
            echo stripslashes($output);
        }


    }

    add_action('wp_head', 'coll_section_background_css');
}

// backgrounds for pages
if (!function_exists('insert_page_bg')) {
    function insert_page_bg()
    {
        // Load our custom background image
        // gain access to post id
        global $wp_query, $data;

        if (is_home()) {
            $postid = 0;
        } elseif (is_search() || is_404() || is_archive()) {
            $blog = get_page_by_title($data['coll_blog_page']);
            $postid = $blog->ID;
        } else {
            $postid = $wp_query->post->ID;
        }

        // Get the unique background image
        $bg_img = get_post_meta($postid, 'coll_background_image', true);
        if (empty($bg_img)) {
            // No image supplied, fall back to default values
            $bg_pos = $data['coll_default_bg_position'];

            // Check background position to see if we need to continue
            if ($bg_pos == 'full') {
                $bg_img = $data['coll_default_bg_image'];
                if (!empty($bg_img)) {
                    $posttitle = $wp_query->post->post_title;

                    // got the details, load the image
                    echo '<img id="background" src="' . $bg_img . '" alt="' . $posttitle . '" />';
                }
            }
        } else {
            // Unique background image included
            // Check background position to see if we need to continue
            $bg_pos = get_post_meta($postid, 'coll_background_position', true);

            if ($bg_pos == __('Full Screen', 'framework')) {
                $posttitle = $wp_query->post->post_title;

                // got the details, load the image
                echo '<img id="background" src="' . $bg_img . '" alt="' . $posttitle . '" />';
            }
        }
    }
}

if (!function_exists('coll_background_css')) {
    function coll_background_css()
    {
        global $data;
        $output = '';

        /* Set Custom Background Image if needed --------*/

        // gain access to post id
        global $wp_query;
        if (is_home()) {
            $postid = 0;

            $bg_img = $data['coll_default_bg_image'];

            if (!empty($bg_img)) {
                $bg_pos = $data['coll_default_bg_position'];

                if ($bg_pos != __('Full Screen', 'framework')) {
                    // We aren't dealing with a full screen image, so set up body bg
                    $bg_img = " url($bg_img)";

                    // Handle the pos
                    if ($bg_pos == __('Centered', 'framework')) {
                        $bg_pos = 'center';
                    }
                    $bg_pos = strtolower($bg_pos);

                    // Handle the repeat
                    $bg_repeat = $data['coll_default_bg_repeat'];
                    if ($bg_repeat == __('No Repeat', 'framework')) {
                        $bg_repeat = 'no-repeat';
                    } elseif ($bg_repeat == __('Repeat', 'framework')) {
                        $bg_repeat = 'repeat';
                    } elseif ($bg_repeat == __('Repeat Horizontally', 'framework')) {
                        $bg_repeat = 'repeat-x';
                    } else {
                        $bg_repeat = 'repeat-y';
                    }
                    $output .= "body { \n\tbackground-image: $bg_img;\n\tbackground-attachment: fixed;\n\tbackground-repeat: $bg_repeat;\n\tbackground-position: top $bg_pos; \n}\n";
                }
            } else {
                $bg_color = $data['coll_default_bg_color'];
                if (!empty($bg_color)) {
                    $output .= "body { \n\tbackground-color: $bg_color;\n}\n";
                }
            }
        } elseif (is_search() || is_404() || is_archive()) {
            $blog = get_page_by_title($data['coll_blog_page']);
            $postid = $blog->ID;
        } else {
            $postid = $wp_query->post->ID;
        }

        // get custom image for page
        $bg_img = get_post_meta($postid, 'coll_background_image', true);

        if (empty($bg_img)) {
            // No custom image supplied, check the default position
            $bg_pos = $data['coll_default_bg_position'];

            if ($bg_pos != 'full') {
                // We aren't dealing with a full screen image, so set up body bg
                $bg_img = $data['coll_default_bg_image'];
                if (!empty($bg_img)) {
                    $bg_img = " url($bg_img)";
                } else {
                    $bg_img = " none";
                }
                $bg_repeat = $data['coll_default_bg_repeat'];
                $bg_color = get_post_meta($postid, 'coll_background_color', true);
                if (empty($bg_color)) {
                    $bg_color = $data['coll_default_bg_color'];
                }

                $output .= "body { \n\tbackground-color: $bg_color;\n\tbackground-image: $bg_img;\n\tbackground-attachment: fixed;\n\tbackground-repeat: $bg_repeat;\n\tbackground-position: top $bg_pos; \n}\n";
            } else {
                $bg_color = get_post_meta($postid, 'coll_background_color', true);
                if (empty($bg_color)) {
                    $bg_color = $data['coll_default_bg_color'];
                }
                $output .= "body { \n\tbackground-color: $bg_color; \n}\n";
            }

        } else {
            // Custom image provided, check default position
            $bg_pos = get_post_meta($postid, 'coll_background_position', true);

            if ($bg_pos != __('Full Screen', 'framework')) {
                // We aren't dealing with a full screen image, so set up body bg
                $bg_img = " url($bg_img)";

                // Handle the pos
                if ($bg_pos == __('Centered', 'framework')) {
                    $bg_pos = 'center';
                }
                $bg_pos = strtolower($bg_pos);

                // Handle the repeat
                $bg_repeat = get_post_meta($postid, 'coll_background_repeat', true);
                if ($bg_repeat == __('No Repeat', 'framework')) {
                    $bg_repeat = 'no-repeat';
                } elseif ($bg_repeat == __('Repeat', 'framework')) {
                    $bg_repeat = 'repeat';
                } elseif ($bg_repeat == __('Repeat Horizontally', 'framework')) {
                    $bg_repeat = 'repeat-x';
                } else {
                    $bg_repeat = 'repeat-y';
                }

                $output .= "body { \n\tbackground-image: $bg_img;\n\tbackground-attachment: fixed;\n\tbackground-repeat: $bg_repeat;\n\tbackground-position: top $bg_pos; \n}\n";


            }
        }

        /* Output our custom styles --------------------------*/
        if ($output <> '') {
            $output = "<!-- Custom Styling -->\n<style type=\"text/css\" id=\"custom-style\">\n" . $output . "</style>\n";
            echo stripslashes($output);
        }

    }

    add_action('wp_head', 'coll_background_css');
}


/*-----------------------------------------------------------------------------------*/
/* PAGE TITLES
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_page_titles')) {
    function coll_page_titles()
    {

        $output = '';

        // gain access to post id
        global $wp_query, $data;

        if (is_home()) {
            $postid = 0;
        } elseif (is_search() || is_404() || is_archive()) {
            $blog = get_page_by_title($data['coll_blog_page']);
            $postid = $blog->ID;
        } else {
            $postid = $wp_query->post->ID;
        }



        $fsize = get_post_meta($postid, 'coll_title_font_size', true);
        $fcolor = get_post_meta($postid, 'coll_title_color', true);

        if (!empty($fsize) || !empty($fcolor) ) {
            $output .= "div.title.common .text {";
            if (!empty($fsize)) $output .= "\n\tfont-size: $fsize" . "px;";
            if (!empty($fcolor)) $output .= "\n\tcolor: $fcolor ;";
            $output .= "\n}\n";
        }

        /* Output our custom styles --------------------------*/
        if ($output <> '') {
            $output = "<!-- Custom Page Title Style -->\n<style type=\"text/css\">\n" . $output . "</style>\n";
            echo stripslashes($output);
        }

    }

    add_action('wp_head', 'coll_page_titles');
}


/*-----------------------------------------------------------------------------------*/
/* REMOVE LINKS FROM IMAGES IN ENTRY CONTENT
/*-----------------------------------------------------------------------------------*/

if (!function_exists('attachment_image_link_remove_filter')) {
    function attachment_image_link_remove_filter($content)
    {
        $content =
            preg_replace(
                array('{<a(.*?)(wp-att|wp-content\/uploads)[^>]*><img}',
                    '{ wp-image-[0-9]*" /></a>}'),
                array('<img', '" />'),
                $content
            );
        return $content;
    }

    // add_filter('the_content', 'attachment_image_link_remove_filter');
}
/*-----------------------------------------------------------------------------------*/
/* Add Favicon
/*-----------------------------------------------------------------------------------*/

if (!function_exists('coll_favicon')) {
    function coll_favicon()
    {
        global $data;
        if ($data['coll_custom_favicon'] != '') {
            echo '<link rel="shortcut icon" href="' . $data['coll_custom_favicon'] . '"/>' . "\n";
        } else {
            ?>
        <link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ?>/admin/images/favicon.ico"/>
        <?php

        }
    }

    add_action('wp_head', 'coll_favicon');
}


/*-----------------------------------------------------------------------------------*/
/* Show analytics code in footer */
/*-----------------------------------------------------------------------------------*/

if (!function_exists('coll_analytics')) {
    function coll_analytics()
    {
        global $data;
        $output = $data['coll_analytics'];
        if ($output <> "")
            echo stripslashes($output) . "\n";
    }

    add_action('wp_footer', 'coll_analytics');
}

/*-----------------------------------------------------------------------------------*/
/* get a portfolio item content items
/*-----------------------------------------------------------------------------------*/
if (!function_exists('get_port_item_content')) {
    function get_port_item_content($post_id)
    {
        global $wpdb;
        $query = "SELECT * FROM $wpdb->postmeta WHERE post_id = '$post_id' AND meta_key LIKE 'content-item%'";
        $content = $wpdb->get_results($query);
        sort($content);

        // go through each item of the $content array
        $n = 0;

        $data = array();

        foreach ($content as $content_item) {
            // get meta
            //$meta_value =;
            // add to array
            $data[] = json_decode($content_item->meta_value);

            $n++;
        }

        return $data;
    }
}
// end of get_port_item_content




/*-----------------------------------------------------------------------------------*/
/*	Comment Styling
/*-----------------------------------------------------------------------------------*/

if (!function_exists('coll_comment')) {
    function coll_comment($comment, $args, $depth)
    {

        $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(); ?> >
            <div id="comment-<?php comment_ID(); ?>">
                <div class="comment-meta clearfix">
                    <ul class="extra">
                        <li>
                            <label class="name"><?php comment_author_link(); ?></label>
                        </li>
                        <li>
                            <small><?php comment_date(); ?> </small>
                        </li>
                        <li>
                            <small><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></small>
                        </li>
                        <li>
                            <small><?php edit_comment_link(__('(Edit)', 'framework'), '<small>', '</small>') ?></small>
                        </li>
                    </ul>
                </div>
                <div class="comment-body ">
                    <?php if ($comment->comment_approved == '0') : ?>
                    <em class="moderation"><?php _e('Your comment is awaiting moderation.', 'framework') ?></em>
                    <br/>
                    <?php endif; ?>
                    <?php comment_text() ?>
                </div>
            </div>

        <?php

    }
}

/*-----------------------------------------------------------------------------------*/
/*	Add Superlink to various buttons
/*-----------------------------------------------------------------------------------*/

if (!function_exists('add_superlink')) {

    function add_superlink()
    {
        return 'class="blog-nav-item"';
    }

    add_filter('next_posts_link_attributes', 'add_superlink');
    add_filter('previous_posts_link_attributes', 'add_superlink');
    add_filter('next_comments_link_attributes', 'add_superlink');
    add_filter('previous_comments_link_attributes', 'add_superlink');
}

/*-----------------------------------------------------------------------------------*/
/*	Seperated Pings Styling
/*-----------------------------------------------------------------------------------*/

if (!function_exists('coll_pings')) {
    function coll_pings($comment, $args, $depth)
    {
        $GLOBALS['comment'] = $comment; ?>
    <li class="ping comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
        <?php

    }
}


/*-----------------------------------------------------------------------------------*/
/*	Add Custom Social Share Buttons
/*-----------------------------------------------------------------------------------*/
if (!function_exists('custom_social_share')) {
    function custom_social_share()
    {
        ?>
        <ul class="entry-social">
            <li class="facebook"><a target="_blank"
                                    href="http://www.facebook.com/sharer.php?u=<?php the_permalink();?>&t=<?php the_title(); ?>"><span
                    class="social-icon"></span></a>
            </li>
            <li class="gplus"><a href="https://plusone.google.com/_/+1/confirm?hl=en&url=<?php the_permalink();?>"><span
                    class="social-icon"></span></a></li>

            <li class="twitter">
                <a target="_blank"
                   href="http://twitter.com/share?url=<?php the_permalink(); ?>&amp;text=Currently reading <?php the_title(); ?>"><span
                        class="social-icon"></span></a>
            </li>
            <li class="pinit"><a
                    href="javascript:void((function(){var e=document.createElement('script'); e.setAttribute('type','text/javascript'); e.setAttribute('charset','UTF-8'); e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)})());">
                <span class="social-icon"></span></a></li>
        </ul>

    <?php
    }
}
/*-----------------------------------------------------------------------------------*/
/*	echo post content
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_the_content')) {
    function coll_the_content($id = NULL)
    {
        if (!$id) {
            global $post;
            $id = $post->ID;
        }

        echo coll_get_the_content($id);
    }
}
/*-----------------------------------------------------------------------------------*/
/*	get post content
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_get_the_content')) {
    function coll_get_the_content($id = NULL)
    {
        if (!$id) {
            global $post;
            $id = $post->ID;
        }

        $post_data = get_post($id);
        $the_content = str_replace(']]>', ']]&gt>', apply_filters('the_content', $post_data->post_content));

        return $the_content;
    }
}


/*-----------------------------------------------------------------------------------*/
/*	CUSTOM COMMENT FORM
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_comment_form')) {


    function coll_comment_form($form_options)
    {
        global $post_id, $user_identity;
        $commenter = wp_get_current_commenter();
        $req = get_option('require_name_email');
        $aria_req = ($req ? " aria-required='true'" : '');

        // Fields Array
        $fields = array(

            'author' =>
            '<p class="comment-form-author">' .
//            ($req ? '<span class="required">*</span>' : '') .
                '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' placeholder="' . __('Name','framework') . '" />' .
                '</p>',

            'email' =>
            '<p class="comment-form-email">' .
//            ($req ? '<span class="required">*</span>' : '') .
                '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' placeholder="' . __('Email','framework') . '" />' .
                '</p>',

            'url' =>
            '<p class="comment-form-url">' .
                '<input name="url" size="30" id="url" value="' . esc_attr($commenter['comment_author_url']) . '" type="text" placeholder="' . __('Website', 'framework') . '" />' .
                '</p>',

        );

        // Form Options Array
        $form_options = array(
            // Include Fields Array
            'fields' => apply_filters('comment_form_default_fields', $fields),

            // Template Options
            'comment_field' =>
            '<p class="comment-form-comment">' .
                '<textarea name="comment" id="comment" aria-required="true" rows="8" cols="45" placeholder="' . _x('Comment', 'noun', 'framework') . '"></textarea>' .
                '</p>',

            'must_log_in' =>
            '<p class="must-log-in">' .
                sprintf(__('You must be <a href="%s">logged in</a> to post a comment.'),
                    wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) .
                '</p>',

            'logged_in_as' =>
            '<p class="logged-in-as">' .
                sprintf(__('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>'),
                    admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) .
                '</p>',

            'comment_notes_before' => '',

            'comment_notes_after' => '',

            // Rest of Options
            'id_form' => 'commentForm',
            'id_submit' => 'comment-submit',
            'title_reply' => __('Add a comment', 'framework'),
            'title_reply_to' => __('Leave a Reply to %s', 'framework'),
            'cancel_reply_link' => __('| Cancel', 'framework'),
            'label_submit' => __('Submit Comment', 'framework'),
        );

        return $form_options;
    }

    add_filter('comment_form_defaults', 'coll_comment_form');
}

/*-----------------------------------------------------------------------------------*/
/*	first word
/*-----------------------------------------------------------------------------------*/
if (!function_exists('coll_first_word')) {
    function coll_first_word($otitle)
    {
        $output = '';


        $space_pos = strpos($otitle, ' ');
        $before = '<span class="first-word">';
        $after = '</span>';

        if ($space_pos) {
            $title = $before . $otitle;
            $output = substr_replace($title, $after . ' ', $space_pos + strlen($before), 1);
        } else $output = $before . $otitle . $after;

        return $output;
    }
}

/*-----------------------------------------------------------------------------------*/
/*	change section urls
/*-----------------------------------------------------------------------------------*/

if (!function_exists('coll_fix_menu')) {
    function  coll_fix_menu($items)
    {
        foreach ($items as $item) {
            if($item->object == 'fp-sections'){
                $post = get_post($item->object_id);
                $item->url = (is_Home()) ? "#" . $post->post_name : home_url() . "#" . $post->post_name;
            }
        }
        return $items;
    }

    add_filter('wp_nav_menu_objects', 'coll_fix_menu');

}
