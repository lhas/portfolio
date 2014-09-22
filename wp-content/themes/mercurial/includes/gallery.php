<div class="entry-assets flexslider">
    <ul class="slides">

        <?php  $args = array(
        'orderby' => 'menu_order',
        'post_type' => 'attachment',
        'post_parent' => get_the_ID(),
        'post_mime_type' => 'image',
        'post_status' => null,
        'numberposts' => -1,
    );
        $attachments = get_posts($args);

        if ($attachments) :
            foreach ($attachments as $attachment) :
                $src = wp_get_attachment_image_src($attachment->ID, 'thumbnail-large');
                ?>
                <li><img src="<?php echo $src[0]; ?>"/></li>
                <?php endforeach; ?>
            <?php endif; ?>

    </ul>
</div>
