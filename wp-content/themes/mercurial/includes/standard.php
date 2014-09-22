<?php if ((function_exists('has_post_thumbnail')) && (has_post_thumbnail())) : ?>
<div class="entry-assets">
    <?php the_post_thumbnail('thumbnail-full'); ?>
</div>
<?php endif; ?>


