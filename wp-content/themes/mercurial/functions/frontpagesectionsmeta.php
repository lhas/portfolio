<?php
/*
 * Setup boxes
 * */
$set_box_section = array(
    'id' => 'section-meta-box',
    'title' => 'Section Settings',
    'page' => 'fp-sections',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Section Height', 'framework'),
            'desc' => __('Check this if you want the section to have the height of its content (may be smaller than the browser window height)', 'framework'),
            'id' => 'coll_section_height',
            'type' => 'checkbox',
            'std' => ''
        ),
        array(
            'name' => __('Show Section Title', 'framework'),
            'desc' => __('Check this if you want to show the section title. Uncheck if you don\'t want the section title displayed', 'framework'),
            'id' => 'coll_title_show',
            'type' => 'checkbox',
            'std' => ''
        ),
        array(
            'name' => __('Title Font Size', 'framework'),
            'desc' => __('Insert a custom title font size for this section. Leave <b>blank</b> to use the size set in style.css', 'framework'),
            'id' => 'coll_title_font_size',
            'type' => 'text',
            'std' => ''
        ),
        array(
            'name' => __('Title Font Color', 'framework'),
            'desc' => __('Select a color for your title. This will also be the color used by your custom <b>text types</b>', 'framework'),
            'id' => 'coll_title_color',
            'type' => 'color',
            'std' => ''
        )

    )
);

$bg_box_section= array(
    'id' => 'bg-meta-box',
    'title' => 'Background Settings',
    'page' => 'fp-sections',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Custom Background Image', 'framework'),
            'desc' => __('Upload a custom background image for this section. Once uploaded, click "Insert to Post".', 'framework'),
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

add_action('admin_menu', 'add_section_meta_boxes');
function add_section_meta_boxes()
{
    global $set_box_section, $bg_box_section;


    add_meta_box($set_box_section['id'], $set_box_section['title'], 'show_set_meta_box_section', $set_box_section['page'], $set_box_section['context'], $set_box_section['priority']);
    add_meta_box($bg_box_section['id'], $bg_box_section['title'], 'show_bg_meta_box_section', $bg_box_section['page'], $bg_box_section['context'], $bg_box_section['priority']);

}

function show_set_meta_box_section()
{
    global $set_box_section, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($set_box_section['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);
        switch ($field['type']) {
            //If Text
            case 'text':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta
                    : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES)), '" size="30" style="width:60px; margin-right: 20px; float:left;" />';

                break;
            //If Text
            case 'text-wide':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';
                echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', $meta ? $meta
                    : stripslashes(htmlspecialchars(($field['std']), ENT_QUOTES)), '" size="30" style="width:75%; margin-right: 20px; float:left;" />';

                break;
            //If Select
            case 'checkbox':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo '<input type="hidden" name="' . $field['id'] . '" id="' . $field['id'] . '" ', $meta ? ' checked="checked"' : '', '/>';
                echo '<input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" ', $meta ? ' checked="checked"' : '', '/>';

                break;
            case 'color':

                echo '<tr>',
                '<th style="width:25%"><label for="', $field['id'], '"><strong>', $field['name'], '</strong><span style=" display:block; color:#999; margin:5px 0 0 0; line-height: 18px;">' . $field['desc'] . '</span></label></th>',
                '<td>';

                echo '<div id="' . $field['id'] . '_picker" class="colorSelector"><div></div></div>';
                echo '<input style="width:75px; margin-left: 5px;" class="tz-color" name="' . $field['id'] . '" id="' . $field['id'] . '" type="text" value="' . $meta . '" />';
                ?>
            <script type="text/javascript" language="javascript">
                jQuery(document).ready(function () {
                    //Color Picker
                    jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '<?php echo $meta; ?>');
                    jQuery('#<?php echo $field['id']; ?>_picker').ColorPicker({
                        color:'<?php echo $meta; ?>',
                        onShow:function (colpkr) {
                            jQuery(colpkr).fadeIn(500);
                            return false;
                        },
                        onHide:function (colpkr) {
                            jQuery(colpkr).fadeOut(500);
                            return false;
                        },
                        onChange:function (hsb, hex, rgb) {
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

function show_bg_meta_box_section()
{
    global $bg_box_section, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($bg_box_section['fields'] as $field) {
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
                jQuery(document).ready(function () {
                    //Color Picker
                    jQuery('#<?php echo $field['id']; ?>_picker').children('div').css('backgroundColor', '<?php echo $meta; ?>');
                    jQuery('#<?php echo $field['id']; ?>_picker').ColorPicker({
                        color:'<?php echo $meta; ?>',
                        onShow:function (colpkr) {
                            jQuery(colpkr).fadeIn(500);
                            return false;
                        },
                        onHide:function (colpkr) {
                            jQuery(colpkr).fadeOut(500);
                            return false;
                        },
                        onChange:function (hsb, hex, rgb) {
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

add_action('save_post', 'save_section_meta_data');


/*
 * save metadata
 * */
function save_section_meta_data($post_id)
{
    global $set_box_section, $bg_box_section;
    $new = '';
    // verify nonce
    if (isset($_POST['meta_box_nonce']) && !wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;
    // check permissions
    if (isset($_POST['post_type']) && 'page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }

    foreach ($set_box_section['fields'] as $field) {
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

    foreach ($bg_box_section['fields'] as $field) {
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
