<?php
/*
 * Setup boxes
 * */
$quote_box = array(
    'id' => 'meta-box-quote',
    'title' => __('Quote', 'framework'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array("name" => __('Insert Text', 'framework'),
              "id" => "quote",
              'std' => ''
        ),
    ),


);

$link_box = array(
    'id' => 'meta-box-link',
    'title' => __('Link', 'framework'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array("name" => __('Insert URL', 'framework'),
              "id" => "link",
              'std' => ''
        ),
    ),

);


$audio_box = array(
    'id' => 'meta-box-audio',
    'title' => __('Audio', 'framework'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array("name" => __('MP3 File URL', 'framework'),
              "id" => "audio_mp3",
              'std' => ''
        ),
        array("name" => __('OGA/OGG File URL', 'framework'),
              "id" => "audio_ogg",
              'std' => ''
        )
    ),


);

$video_box = array(
    'id' => 'meta-box-video',
    'title' => __('Video', 'framework'),
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array("name" => __('Embedded Code', 'framework'),
              "id" => "video_embed",
              'std' => ''
        ),

    )


);

$bg_box_post = array(
    'id' => 'bg-meta-box',
    'title' => 'Background Settings',
    'page' => 'post',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Custom Background Image', 'framework'),
            'desc' => __('Upload a custom background image for this page. Once uploaded, click "Insert to Post".', 'framework'),
            'id' => 'coll_background_image',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => '',
            'desc' => '',
            'id' => 'coll_background_image_button',
            'type' => 'button',
            'std' => 'Browse'
        ),
        array(
            'name' => __('Custom Background Repeat', 'framework'),
            'desc' => __('Select a custom background repeat for the uploaded image.', 'framework'),
            'id' => 'coll_background_repeat',
            'type' => 'select',
            'std' => '',
            'options' => array(__('No Repeat', 'framework'), __('Repeat', 'framework'), __('Repeat Horizontally', 'framework'), __('Repeat Vertically', 'framework')),
        ),
        array(
            'name' => __('Custom Background Position', 'framework'),
            'desc' => __('Select a custom background position for the uploaded image.', 'framework'),
            'id' => 'coll_background_position',
            'type' => 'select',
            'std' => '',
            'options' => array(__('Left', 'framework'), __('Right', 'framework'), __('Centered', 'framework'), __('Full Screen', 'framework'))
        ),
        array(
            'name' => __('Custom Background Color', 'framework'),
            'desc' => __('Select a custom background color for the uploaded image.', 'framework'),
            'id' => 'coll_background_color',
            'type' => 'color',
            'std' => ''
        )

    )
);

/*
 * create boxes
 * */

add_action('admin_menu', 'add_post_meta_boxes');
function add_post_meta_boxes()
{
    global $quote_box, $link_box, $audio_box, $video_box, $bg_box_post;

    add_meta_box($quote_box['id'], $quote_box['title'], 'show_post_quote_meta_box', $quote_box['page'], $quote_box['context'], $quote_box['priority']);
    add_meta_box($link_box['id'], $link_box['title'], 'show_post_link_meta_box', $link_box['page'], $link_box['context'], $link_box['priority']);
    add_meta_box($audio_box['id'], $audio_box['title'], 'show_post_audio_meta_box', $audio_box['page'], $audio_box['context'], $audio_box['priority']);
    add_meta_box($video_box['id'], $video_box['title'], 'show_post_video_meta_box', $video_box['page'], $video_box['context'], $video_box['priority']);
    add_meta_box($bg_box_post['id'], $bg_box_post['title'], 'show_bg_meta_box_post', $bg_box_post['page'], $bg_box_post['context'], $bg_box_post['priority']);

}

function show_post_quote_meta_box()
{
    global $quote_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    // get current post meta data
    $meta = get_post_meta($post->ID, $quote_box['fields'][0]['id'], true);
    ?>
<div>
    <label style="position: relative; float: left; width: 150px;"><strong><?php echo $quote_box['fields'][0]['name'] ?></strong></label>
    <textarea name="<?php echo $quote_box['fields'][0]['id'] ?>"
              style="width: 50%; margin-left: 10px; height: 60px;outline: 0; float: left;"><?php echo $meta ? $meta
            : stripslashes(htmlspecialchars(($quote_box['fields'][0]['std']), ENT_QUOTES)) ?></textarea>

    <div style="clear: both;"></div>
</div>
<?php


}

function show_post_link_meta_box()
{
    global $link_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';


    // get current post meta data
    $meta = get_post_meta($post->ID, $link_box['fields'][0]['id'], true);
    ?>
<div>
    <label style="position: relative; float: left; width: 150px;"><strong><?php echo $link_box['fields'][0]['name'] ?></strong></label>
    <input type='text' name="<?php echo $link_box['fields'][0]['id'] ?>"
           style="width: 50%; margin-left: 10px;margin-top: 4px; float: left;"
           value='<?php echo $meta ? $meta
                   : stripslashes(htmlspecialchars(($link_box['fields'][0]['std']), ENT_QUOTES)) ?>'/>

    <div style="clear: both;"></div>
</div>
<?php

}

function show_post_audio_meta_box()
{
    global $audio_box, $post;
    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';


    // get current post meta data
    $meta0 = get_post_meta($post->ID, $audio_box['fields'][0]['id'], true);
    $meta1 = get_post_meta($post->ID, $audio_box['fields'][1]['id'], true);

    ?>
<div>
    <div style="width:150px;float:left;">
        <span style="margin-top: 15px;clear:both;float: left;color: #999"><?php echo $audio_box['fields'][0]['name'] ?></span>
        <span style="margin-top: 9px;clear:both;float: left;color: #999"><?php echo $audio_box['fields'][1]['name'] ?></span>
    </div>
    <div style="margin-left: 10px;margin-top: 10px;width: 50%;float: left;">
        <input style="width: 100%;" type='text' name="<?php echo $audio_box['fields'][0]['id'] ?>"
               value='<?php echo $meta0 ? $meta0
                       : stripslashes(htmlspecialchars(($audio_box['fields'][0]['std']), ENT_QUOTES)) ?>'/>
        <input style="width: 100%;" type='text' name="<?php echo $audio_box['fields'][1]['id'] ?>"
               value='<?php echo $meta1 ? $meta1
                       : stripslashes(htmlspecialchars(($audio_box['fields'][1]['std']), ENT_QUOTES)) ?>'/>

    </div>
    <div style="clear: both;"></div>
</div>

<?php

}

function show_post_video_meta_box()
{
    global $video_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';


    // get current post meta data
    $meta0 = get_post_meta($post->ID, $video_box['fields'][0]['id'], true);




    ?>
<div>
    <div style="width:150px;float:left;">
        <span style="margin-top: 15px;clear:both;float: left;color: #999"><?php echo $video_box['fields'][0]['name'] ?></span>
    </div>
    <div style="margin-left: 10px;margin-top: 10px;width: 50%;float: left;">

        <textarea name="<?php echo $video_box['fields'][0]['id'] ?>"
                  style="width: 100%; height: 60px;outline: 0; float: left;"><?php echo $meta0 ? $meta0
                : stripslashes(htmlspecialchars(($video_box['fields'][0]['std']), ENT_QUOTES)) ?></textarea>


    </div>


    <div style="clear: both;"></div>

</div>

<?php

}
function show_bg_meta_box_post()
{
    global $bg_box_post, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($bg_box_post['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        switch ($field['type']) {


            //If Text
            case 'text':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta
                    : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';

                break;

            //If Button
            case 'button':
                echo '<input style="float: left;" type="button" class="button" name="', $field['id'], '" id="', $field['id'], '" value="Browse" />';
                echo     '</td>',
                '</tr>';

                break;

            //If Select
            case 'select':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo'<select name="' . $field['id'] . '">';

                foreach ($field['options'] as $option) {

                    echo'<option';
                    if ($meta == $option) {
                        echo ' selected="selected"';
                    }
                    echo'>' . $option . '</option>';

                }

                echo'</select>';

                break;

            case 'color':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo '<div id="' . $field['id'] . '_picker" class="colorSelector"><div></div></div>';
                echo '<input style="width:75px; margin-left: 5px;" class="tz-color" name="' . $field['id'] . '" id="' . $field['id'] . '" type="text" value="' . $meta . '" />';
                ?>
                <script type="text/javascript" language="javascript">
                    jQuery(document).ready(function() {
                        //Color Picker
                        jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '<?php echo $meta; ?>');
                        jQuery('#<?php echo $field['id']; ?>_picker').ColorPicker({
                            color: '<?php echo $meta; ?>',
                            onShow: function (colpkr) {
                                jQuery(colpkr).fadeIn(500);
                                return false;
                            },
                            onHide: function (colpkr) {
                                jQuery(colpkr).fadeOut(500);
                                return false;
                            },
                            onChange: function (hsb, hex, rgb) {
                                //jQuery(this).css('border','1px solid red');
                                jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '#' + hex);
                                jQuery('#<?php echo $field['id']; ?>_picker').next('input').attr('value', '#' + hex);
                            }
                        });
                    });
                </script>
                <?php       break;

        }

    }

    echo '</table>';
}

add_action('save_post', 'save_post_meta_data');


/*
 * save metadata
 * */
function save_post_meta_data($post_id)
{
    global $quote_box, $link_box, $audio_box, $video_box, $bg_box_post;
    $new = '';

    // verify nonce
    if (isset($_POST['meta_box_nonce']) && !wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }


    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX )
        return;
    // check permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($quote_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);

        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }


        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }

    foreach ($link_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }

    foreach ($audio_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }

        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }

    foreach ($video_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }

    foreach ($bg_box_post['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        if (isset($_POST[$field['id']])) {
            $new = $_POST[$field['id']];
        }
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }


}


/*-----------------------------------------------------------------------------------*/
/*	Queue Scripts
/*-----------------------------------------------------------------------------------*/
add_action('admin_print_scripts', 'add_admin_scripts_post');
function add_admin_scripts_post()
{
    wp_register_script('postmeta', get_template_directory_uri() . '/functions/js/post.js');
    wp_enqueue_script('postmeta');
}



