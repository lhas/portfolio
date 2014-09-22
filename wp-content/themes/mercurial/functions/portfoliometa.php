<?php
/*
 * Create thumbnail , content, url custom boxes
 *
 *
 * */
$thumb_box = array(
    'id' => 'thumb-meta-box-portfolio',
    'title' => __('Project Thumbnail', 'framework'),
    'page' => 'portfolio',
    'context' => 'normal',
    'priority' => 'high'
);
$content_box = array(
    'id' => 'content-meta-box-portfolio',
    'title' => __('Project Content', 'framework'),
    'page' => 'portfolio',
    'context' => 'normal',
    'priority' => 'high'
);
$url_box = array(
    'id' => 'url-meta-box-portfolio',
    'title' => __('Project Url', 'framework'),
    'page' => 'portfolio',
    'context' => 'normal',
    'priority' => 'high'
);
$client_box = array(
    'id' => 'client-meta-box-portfolio',
    'title' => __('Project Client', 'framework'),
    'page' => 'portfolio',
    'context' => 'normal',
    'priority' => 'high'
);
$date_box = array(
    'id' => 'date-meta-box-portfolio',
    'title' => __('Project Date', 'framework'),
    'page' => 'portfolio',
    'context' => 'normal',
    'priority' => 'high'
);

$bg_box_port = array(
    'id' => 'bg-meta-box',
    'title' => 'Background Settings',
    'page' => 'portfolio',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => __('Background Color', 'framework'),
            'desc' => __('Select a custom background color for the project lightbox.', 'framework'),
            'id' => 'coll_background_color',
            'type' => 'color',
            'std' => ''
        ),
        array(
            'name' => __('Info Background Color', 'framework'),
            'desc' => __('Select a custom background color for the project details.', 'framework'),
            'id' => 'coll_background_details_color',
            'type' => 'color',
            'std' => ''
        )

    )
);

// add content meta boxes
add_action('admin_menu', 'add_portfolio_meta_boxes');

function add_portfolio_meta_boxes()
{
    global $thumb_box, $content_box, $url_box, $client_box, $date_box, $bg_box_port;
    add_meta_box($thumb_box['id'], $thumb_box['title'], 'show_thumb_content_meta_box', $thumb_box['page'], $thumb_box['context'], $thumb_box['priority']);
    add_meta_box($content_box['id'], $content_box['title'], 'show_portfolio_content_meta_box', $content_box['page'], $content_box['context'], $content_box['priority']);
    add_meta_box($url_box['id'], $url_box['title'], 'show_url_content_meta_box', $url_box['page'], $url_box['context'], $url_box['priority']);
    add_meta_box($client_box['id'], $client_box['title'], 'show_client_content_meta_box', $client_box['page'], $client_box['context'], $client_box['priority']);
    add_meta_box($date_box['id'], $date_box['title'], 'show_date_content_meta_box', $date_box['page'], $date_box['context'], $date_box['priority']);
    add_meta_box($bg_box_port['id'], $bg_box_port['title'], 'show_bg_meta_box_port', $bg_box_port['page'], $bg_box_port['context'], $bg_box_port['priority']);

}

function show_thumb_content_meta_box()
{
    global $post;
    $meta = get_post_meta($post->ID, 'thumbnail', true);
    ?>
<div id="portfolioThumb" style="padding: 20px 10px 20px 10px;">
    <label
        style="position: relative; float: left; width: 150px;"><strong><?php _e('Project Thumbnail', 'framework') ?></strong><span
        style="display:block;color: #999"><?php _e('Insert thumbnail url', 'framework') ?></span></label>
    <input style="width: 50%; margin-left: 10px;" class='thumb' name='thumbnail' type='text'
           value='<?php echo $meta ? $meta : stripslashes(htmlspecialchars((""), ENT_QUOTES)); ?>'/>
    <input style="margin-left: 25px;" class='browse-image-button button' type='button' value='Browse'/>

</div>
<?php

}

// end show_thumb_content_meta_box function
function show_portfolio_content_meta_box()
{
    global $post, $wpdb;

    $post_id = $post->ID;
    ?>
<div id="addContentItem" style="background-color: #fff;">
    <div style="padding: 10px;"><strong><label><?php _e('Content Type:', 'framework') ?></label></strong>
        <select id="selectedContentType">
            <option value="image"><?php _e('Image', 'framework') ?></option>
            <option value="youtube"><?php _e('YouTube', 'framework') ?></option>
            <option value="vimeo"><?php _e('Vimeo', 'framework') ?></option>
        </select>
        <input class="button" type="button" id="addContentButton" value="Add Content"/>
    </div>

    <div id="contentItemData" style="border-bottom: 1px solid #eee; padding: 30px 10px 50px 10px; margin-bottom: 30px;">
        <div class="image">
            <label
                style="position: relative; float: left; width: 150px;"><strong><?php _e('Image Url', 'framework') ?></strong><span
                style="display:block;color: #999"><?php _e('insert image url', 'framework') ?></span></label>
            <input type='text' style="width: 50%; margin-left: 10px;"/>
            <input style="margin-left: 25px;" class='browse-image-button button' type='button' value='Browse'/>
        </div>
        <div class="youtube">
            <label
                style="position: relative; float: left; width: 150px;"><strong><?php _e('Youtube', 'framework') ?></strong><span
                style="display:block;color: #999"><?php _e('insert embed code', 'framework') ?></span></label>
            <textarea style="width: 50%; margin-left: 10px; height: 60px;outline: 0;"></textarea>
        </div>
        <div class="vimeo">
            <label
                style="position: relative; float: left; width: 150px;"><strong><?php _e('Vimeo', 'framework') ?></strong><span
                style="display:block;color: #999"><?php _e('insert embed code', 'framework') ?></span></label>
            <textarea style="width: 50%; margin-left: 10px; height: 60px;outline: 0;"></textarea>
        </div>
        <div class="video">
            <div>
                <label
                    style="position: relative; float: left; width: 150px;"><strong><?php _e('Poster', 'framework') ?></strong><span
                    style="display:block;color: #999"><?php _e('insert poster url', 'framework') ?></span></label>
                <input type='text' style="width: 50%; margin-left: 10px;"/>
            </div>
            <div style="clear:both;margin-top: 20px;">
                <label
                    style="position: relative; float: left; width: 150px;"><strong><?php _e('Width', 'framework') ?></strong><span
                    style="display:block;color: #999"><?php _e('insert the video width', 'framework') ?></span></label>
                <input type='text' style="width: 50%; margin-left: 10px;"/>
            </div>
            <div style="clear:both;margin-top: 20px;">
                <label
                    style="position: relative; float: left; width: 150px;"><strong><?php _e('Height', 'framework') ?></strong><span
                    style="display:block;color: #999"><?php _e('insert the video height', 'framework') ?></span></label>
                <input type='text' style="width: 50%; margin-left: 10px;"/>
            </div>
            <div style="clear:both;margin-top: 20px;">
                <label
                    style="position: relative; float: left; width: 150px;"><strong><?php _e('M4V', 'framework') ?></strong><span
                    style="display:block;color: #999"><?php _e('insert video source (m4v)', 'framework') ?></span></label>
                <input type='text' style="width: 50%; margin-left: 10px;"/>
            </div>
            <div style="clear:both;margin-top: 20px;">
                <label
                    style="position: relative; float: left; width: 150px;"><strong><?php _e('OGV', 'framework') ?></strong><span
                    style="display:block;color: #999"><?php _e('insert video source (ogv)', 'framework') ?></span></label>
                <input type='text' style="width: 50%; margin-left: 10px;"/>
            </div>


        </div>
    </div>
</div>

<div id="contentItems" style="padding: 10px 10px 10px 10px;">
    <?php
    // get the metadata rows
    $query = "SELECT * FROM $wpdb->postmeta WHERE post_id = '$post_id' AND meta_key LIKE 'content-item%'";
    $content = $wpdb->get_results($query);
    sort($content);

    foreach ($content as $content_item) {
        // load info
        $item_number = substr($content_item->meta_key, 13);
        $data = json_decode($content_item->meta_value);
        $input_type = $data->type;
        $input_name = $data->name;
        switch ($input_type) {
            case "image":
                $input_url = $data->url;
                ?>
                    <div class='<?php echo "$item_number content-item $input_type" ?>' style="margin-top: 20px;">
                        <label
                            style="position: relative; float: left; width: 150px;"><strong><?php _e('Image', 'framework') ?></strong><span
                            style="display:block;color: #999"><?php _e('edit image url', 'framework') ?></span></label>
                        <input type='text' style="width: 50%; margin-left: 10px;margin-top: 4px; float: left;"
                               value='<?php echo $input_url ?>'/>
                        <input style="margin-left: 25px;margin-top: 5px;" class='update-item-button button'
                               type='button'
                               value='Update'/>
                        <input style="margin-left: 10px;" class='remove-item-button button' type='button'
                               value='Remove Item'/>

                        <div style="clear: both;"></div>
                    </div>
                    <?php
                break;
            case "youtube":
                $input_url = $data->url;
                ?>
                    <div class='<?php echo "$item_number content-item $input_type" ?>' style="margin-top: 20px;">
                        <label
                            style="position: relative; float: left; width: 150px;"><strong><?php _e('Youtube', 'framework') ?></strong><span
                            style="display:block;color: #999"><?php _e('edit embed code', 'framework') ?></span></label>
                        <textarea
                            style="width: 50%; margin-left: 10px; height: 60px;outline: 0; float: left;"><?php echo $input_url ?></textarea>
                        <input style="margin-left: 25px;margin-top: 22px;float: left;" class='update-item-button button'
                               type='button'
                               value='Update'/>
                        <input style="margin-left: 10px;margin-top: 22px;" class='remove-item-button button'
                               type='button'
                               value='Remove Item'/>

                        <div style="clear: both;"></div>
                    </div>
                    <?php
                break;
            case "vimeo":
                $input_url = $data->url;
                ?>
                    <div class='<?php echo "$item_number content-item $input_type" ?>' style="margin-top: 20px;">
                        <label
                            style="position: relative; float: left; width: 150px;"><strong><?php _e('Vimeo', 'framework') ?></strong><span
                            style="display:block;color: #999"><?php _e('edit embed code', 'framework') ?></span></label>
                        <textarea
                            style="width: 50%; margin-left: 10px; height: 60px;outline: 0;float: left;"><?php echo $input_url ?></textarea>
                        <input style="margin-left: 25px;margin-top: 22px;" class='update-item-button button'
                               type='button'
                               value='Update'/>
                        <input style="margin-left: 10px;margin-top: 22px;" class='remove-item-button button'
                               type='button'
                               value='Remove Item'/>

                        <div style="clear: both;"></div>
                    </div>
                    <?php
                break;
            case "video":
                $input_tmb = $data->tmb;
                $input_width = $data->width;
                $input_height = $data->height;
                $input_m4v = $data->m4v;
                $input_ogv = $data->ogv;
                ?>
                    <div class='<?php echo "$item_number content-item $input_type" ?>' style="margin-top: 20px;">
                        <div style="width:150px;float:left;">
                            <label style=" float: left;"><strong><?php _e('Video', 'framework') ?></strong></label>
                            <span
                                style="clear:both;float: left;color: #999"><?php _e('edit poster url', 'framework') ?></span>
                            <span
                                style="margin-top: 9px;clear:both;float: left;color: #999"><?php _e('edit video width', 'framework') ?></span>
                            <span
                                style="margin-top: 9px;clear:both;float: left;color: #999"><?php _e('edit video height', 'framework') ?></span>
                            <span
                                style="margin-top: 9px;clear:both;float: left;color: #999"><?php _e('edit video m4v src', 'framework') ?></span>
                            <span
                                style="clear:both;margin-top: 9px;float: left;color: #999"><?php _e('edit video ogv src', 'framework') ?></span>
                        </div>
                        <div style="margin-left: 10px;margin-top: 10px;width: 50%;float: left;">
                            <input style="width: 100%;" type='text' value='<?php echo $input_tmb ?>'/>
                            <input style="width: 100%;" type='text' value='<?php echo $input_width ?>'/>
                            <input style="width: 100%;" type='text' value='<?php echo $input_height ?>'/>
                            <input style="width: 100%;" type='text' value='<?php echo $input_m4v ?>'/>
                            <input style="width: 100%;" type='text' value='<?php echo $input_ogv ?>'/>
                        </div>
                        <div style="margin-top: 50px;float: left;">
                            <input style="margin-left: 25px;" class='update-item-button button'
                                   type='button' value='Update'/>
                            <input style="margin-left: 10px;" class='remove-item-button button' type='button'
                                   value='Remove Item'/>
                        </div>


                        <div style="clear: both;"></div>

                    </div>
                    <?php
                break;
        }
    }
    ?>
</div>


<?php

}

// end show_portfolio_content_meta_box function

function show_url_content_meta_box()
{
    global $post;
    $meta = get_post_meta($post->ID, 'url', true);
    ?>
<div id="portfolioUrl" style="margin-left: 10px;">
    <label
        style="position: relative; float: left; width: 150px;margin-top: 4px;"><?php _e('Insert project url', 'framework') ?></label>
    <input class='url' name='url' type='text' style="width: 50%; margin-left: 10px;margin-top: 0px; float: left;"
           value='<?php echo $meta ? $meta : stripslashes(htmlspecialchars((""), ENT_QUOTES)); ?>'/>

    <div style="clear: both;"></div>
</div>

<?php

}

// end show_url_content_meta_box function
function show_client_content_meta_box()
{
    global $post;

    $meta = get_post_meta($post->ID, 'client', true);
    ?>
<div id="portfolioClient" style="margin-left: 10px;">
    <label
        style="position: relative; float: left; width: 150px;margin-top: 4px;"><?php _e('Insert client name', 'framework') ?></label>
    <input class='client' name='client' type='text' style="width: 50%; margin-left: 10px;margin-top: 0px; float: left;"
           value='<?php echo $meta ? $meta : stripslashes(htmlspecialchars((""), ENT_QUOTES)); ?>'/>

    <div style="clear: both;"></div>
</div>

<?php

}

function show_date_content_meta_box()
{
    global $post;

    $meta = get_post_meta($post->ID, 'date', true);
    ?>
<div id="portfolioDate" style="margin-left: 10px;">
    <label
        style="position: relative; float: left; width: 150px;margin-top: 4px;"><?php _e('Insert completion date', 'framework') ?></label>
    <input class='date' name='date' type='text' style="width: 50%; margin-left: 10px;margin-top: 0px; float: left;"
           value='<?php echo  $meta ? $meta : stripslashes(htmlspecialchars((""), ENT_QUOTES)); ?>'/>

    <div style="clear: both;"></div>
</div>

<?php

}

function show_bg_meta_box_port()
{
    global $bg_box_port, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table class="form-table">';

    foreach ($bg_box_port['fields'] as $field) {
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

/* ----------------------------------------------------------------------------------- */
/* 	Save data when post is edited
  /*----------------------------------------------------------------------------------- */
add_action('save_post', 'save_data_portfolio');

function save_data_portfolio($post_id)
{
    global $bg_box_port;


    $new = '';


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


    //save thumbnail
    $old = get_post_meta($post_id, 'thumbnail', true);
    if (isset($_POST['thumbnail'])) {
        $new = $_POST['thumbnail'];
    }


    if ($new && $new != $old) {
        update_post_meta($post_id, 'thumbnail', stripslashes(htmlspecialchars($new)));
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, 'thumbnail', $old);
    }


    // save url
    $old = get_post_meta($post_id, 'url', true);
    if (isset($_POST['url'])) {
        $new = $_POST['url'];
    }

    if ($new && $new != $old) {
        update_post_meta($post_id, 'url', stripslashes(htmlspecialchars($new)));
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, 'url', $old);
    }

    // save client
    $old = get_post_meta($post_id, 'client', true);
    if (isset($_POST['client'])) {
        $new = $_POST['client'];
    }

    if ($new && $new != $old) {
        update_post_meta($post_id, 'client', stripslashes(htmlspecialchars($new)));
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, 'client', $old);
    }

    // save date
    $old = get_post_meta($post_id, 'date', true);
    if (isset($_POST['date'])) {
        $new = $_POST['date'];
    }


    if ($new && $new != $old) {
        update_post_meta($post_id, 'date', stripslashes(htmlspecialchars($new)));
    } elseif ('' == $new && $old) {
        delete_post_meta($post_id, 'date', $old);
    }

    foreach ($bg_box_port['fields'] as $field) {
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

// update content custom fields (update/delete)
add_action('wp_ajax_update_post_meta', 'ajax_update_post_meta');
add_action('wp_ajax_delete_post_meta', 'ajax_delete_post_meta');

function ajax_update_post_meta()
{
    $post_id = $_POST['post_id'];
    $meta_key = $_POST['meta_key'];
    $meta_value = $_POST['meta_value'];
    //$meta_value = stripslashes(htmlspecialchars($_POST['meta_value']));
    // add metadata row
    update_post_meta($post_id, $meta_key, $meta_value);

    echo "success";
    die(); // this is required to return a proper result
}

function ajax_delete_post_meta()
{
    $post_id = $_POST['post_id'];
    $meta_key = $_POST['meta_key'];
    $meta_value = $_POST['meta_value'];

    // remove metadata row
    delete_post_meta($post_id, $meta_key);

    echo "success";
    die(); // this is required to return a proper result
}

/* ----------------------------------------------------------------------------------- */
/* 	Queue Scripts
  /*----------------------------------------------------------------------------------- */
add_action('admin_print_scripts', 'add_admin_scripts_portfolio');
add_action('admin_print_styles', 'add_admin_styles_portfolio');

function add_admin_scripts_portfolio()
{
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_register_script('fcw_portfolio', get_template_directory_uri() . '/functions/js/portfolio.js', array('jquery', 'media-upload', 'thickbox'));
    wp_enqueue_script('fcw_portfolio');
}

function add_admin_styles_portfolio()
{
    wp_enqueue_style('thickbox');
}

?>