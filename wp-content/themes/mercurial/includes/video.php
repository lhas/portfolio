
<?php
$embed = get_post_meta(get_the_ID(), 'video_embed', TRUE);
// if the video is embeded
if ($embed != '') :
    $embed = htmlspecialchars_decode($embed);
    if (strstr($embed, "youtube")){
        $has = strstr($embed, "?");

        if (!$has) {
            $embed = explode('"', $embed);
            $embed[5] .= "?wmode=transparent";
            $embed = implode('"', $embed);
        } else {
            $embed = str_ireplace("&", "&amp;", $embed);
            $embed = str_ireplace("?", "?wmode=transparent&amp;", $embed);
        }
    }


    ?>

<div class="entry-assets fitvid">
    <?php  echo $embed; ?>
</div>
<?php endif; ?>









