<?php get_header(); ?>
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
<a id="redirect" href="<?php echo home_url(); ?>/#<?php echo $post->post_name; ?>"></a>
<article id="slidebox" class="slidebox">
    <div class="close-container options">
        <a class="close"><span class="sprite"></span></a>
    </div>
    <div class="details-container options">
        <a class="details"><span class="sprite"></span></a>
    </div>
    <?php $color = get_post_meta($post->ID, 'coll_background_color', true); ?>
    <div class="content wrapper" style="<?php if ($color) echo "background-color:" . $color; ?>">
        <div class="navigation">
            <a class="next"><span class="sprite"></span></a>
            <a class="previous"><span class="sprite"></span></a>
        </div>
        <div class="items">
            <?php
            $pi_data = get_port_item_content(get_the_ID());
            // add content
            if ($pi_data) {
                foreach ($pi_data as $content_info) {
                    echo '<div class="item wrapper">';
                    switch ($content_info->type) {
                        case "image":
                            echo '<div class="image"><img src="' . $content_info->url . '"/></div>';
                            break;
                        case "youtube":
                            //check to see if the video has any options, the ? sign
                            $has = strstr($content_info->url, "?");
                            if (!$has) {
                                $embed = explode('"', $content_info->url);
                                // insert enablejsapi option
                                $embed[5] .= "?wmode=transparent";
                                $embed = implode('"', $embed);
                            } else {
                                // insert enablejsapi option
                                $embed = str_ireplace("&", "&amp;", $content_info->url);
                                $embed = str_ireplace("?", "?wmode=transparent&amp;", $embed);
                            }
                            echo '<div class="video youtube">' . $embed . '</div>';
                            break;
                        case "vimeo":
                            $embed = $content_info->url;
                            echo '<div class="video vimeo">' . $embed . '</div>';
                            break;
                    }
                    echo '</div>';
                }
            } ?>
        </div>
    </div>
    <?php $color = get_post_meta($post->ID, 'coll_background_details_color', true); ?>
    <footer class="info wrapper hide">
        <div class="bg" style="<?php if ($color) echo "background-color:" . $color; ?>"></div>
        <div class="container">
            <div class="row">
                <div class="fourcol"></div>
                <div class="title fourcol "><h1 class="text border bottom centered big thick"><?php the_title(); ?></h1>
                </div>
                <div class="fourcol last"></div>
                <?php
                $client = get_post_meta(get_the_ID(), 'client', true);
                $date = get_post_meta(get_the_ID(), 'date', true);
                $lproj = get_post_meta(get_the_ID(), 'url', true);

                if (!empty($client) || !empty($date) || !empty($lproj)) :
                    ?>
                    <div class="fourcol"></div>
                    <div class="meta fourcol">
                        <ul class="border bottom centered  big thick ">
                            <?php if (!empty($client)) : ?>
                            <li class="client"><?php _e('Client: ', 'framework'); echo $client; ?></li>
                            <?php endif; ?>
                            <?php if (!empty($date)) : ?>
                            <li class="date"><?php _e('Date: ', 'framework'); echo $date; ?></li>
                            <?php endif; ?>
                            <?php  if (!empty($lproj)) : ?>
                            <li class="launch">
                                <a href="
                                <?php echo get_post_meta(get_the_ID(), 'url', true); ?>" class="button website">
                                    <?php _e('Launch Project', 'framework'); ?>
                                </a>
                            </li>
                            <?php endif; ?>
                        </ul>
                    </div>
                    <div class="fourcol last"></div>
                    <?php endif; ?>
            </div>
            <div class="row description">
                <div class="twelvecol"><?php the_content(); ?></div>
            </div>
        </div>
    </footer>
</article>
<?php endwhile; endif; ?>
<?php get_footer(); ?>