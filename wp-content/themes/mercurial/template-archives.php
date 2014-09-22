<?php
/*
Template Name: Archives
*/
?>
<?php get_header(); ?>
<div id="main" role="main" class="wrapper common">
    <div class="container">
        <div class="row">
            <div class="twelvecol">
                <div class="title common">
                    <?php
                    $title = get_the_title();
                    ?>
                    <h1 class='text'><?php echo coll_first_word($title); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="content container bottom clearfix">
        <div class="row">
            <div class="entry-content twelvecol">
                <?php the_content(); ?>
            </div>
        </div>
        <div class="row">
            <div class="latest fourcol">
                <h3><?php _e('Last 30 Posts', 'fifty') ?></h3>

                <ul>
                    <?php $archive_30 = get_posts('numberposts=30');
                    foreach ($archive_30 as $post) : ?>
                        <li><a href="<?php the_permalink(); ?>"><?php the_title();?></a></li>
                        <?php endforeach; ?>
                </ul>
            </div>

            <div class="month fourcol">
                <h3><?php _e('Archives by Month', 'fifty') ?></h3>
                <ul>
                    <?php wp_get_archives('type=monthly'); ?>
                </ul>


            </div>
            <div class="categories fourcol last">
                <h3><?php _e('Archives by Category', 'fifty') ?></h3>

                <ul>
                    <?php wp_list_categories('hierarchical=0&title_li='); ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endwhile; ?>

    <?php else:
    // no content
endif; ?>
</div>
<?php get_footer(); ?>