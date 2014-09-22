<?php
$prices_box_data = array(
    'id' => 'data-meta-box',
    'title' => 'Price Column Settings',
    'page' => 'pricetables',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Plan background color', 'framework'),
            'desc' => __('Select a custom background color for the price plan column.', 'framework'),
            'id' => 'coll_background_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Price', 'framework'),
            'desc' => __('Enter the price for this plan', 'framework'),
            'id' => 'coll_price',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Link Url', 'framework'),
            'desc' => __('Enter the url for this plan', 'framework'),
            'id' => 'coll_link_url',
            "type" => "text",
            'std' => ''
        ),
        array(
            'name' => __('Link Text', 'framework'),
            'desc' => __('Enter the link text', 'framework'),
            'id' => 'coll_link_text',
            "type" => "text",
            'std' => ''
        ),
          array(
              'name' => __('Stand Out', 'framework'),
              'desc' => __('Check this if u want the price plan to stand out', 'framework'),
              'id' => 'coll_stand_out',
              "type" => "checkbox",
              'std' => ''
          )
    )
);


add_action('admin_menu', 'add_prices_meta_boxes');
function add_prices_meta_boxes()
{
    global $prices_box_data;

    add_meta_box($prices_box_data['id'], $prices_box_data['title'], 'show_prices_box_data', $prices_box_data['page'], $prices_box_data['context'], $prices_box_data['priority']);


}


function show_prices_box_data()
{
    global $prices_box_data, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($prices_box_data['fields'] as $field) {
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


add_action('save_post', 'save_prices_meta_data');
function save_prices_meta_data($post_id)
{
    global $prices_box_data;
    $new = '';
    // verify nonce
    if (isset($_POST['meta_box_nonce']) && !wp_verify_nonce($_POST['meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }

    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check quickedit
    if (defined('DOING_AJAX') && DOING_AJAX)
        return;

    // check permissions
    if (isset($_POST['post_type']) && 'prices' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }


    foreach ($prices_box_data['fields'] as $field) {
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