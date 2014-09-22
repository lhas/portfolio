<?php get_header(); ?>

<div id="main" role="main">

    <?php
    $all_pages = new WP_Query(array('post_type' => 'fp-sections', 'order' => 'ASC', 'orderby' => 'menu_order', 'posts_per_page' => -1));
    while ($all_pages->have_posts()) : $all_pages->the_post(); ?>

        <section id="<?php echo $post->post_name; ?>" class="page-container
        <?php if (!get_post_meta($post->ID, 'coll_section_height', true)) {
            echo 'min-full ';
        }
            echo implode(' ', get_post_class('', $post->ID));?>">

            <!--  BACKGROUND  -->
            <?php coll_isert_bg($post); ?>

            <div class="wrapper container">

                <!--  TITLE  -->
                <?php $show_title = get_post_meta($post->ID, 'coll_title_show', true); ?>
                <div class="row <?php if (!$show_title) echo 'hidden'; ?>">
                    <div class="fourcol"></div>
                    <div class="page-title fourcol">
                        <h1 class="text  border bottom centered thick big"><?php the_title();?></h1>
                    </div>
                    <div class="fourcol last"></div>
                </div>

                <!--  CONTENT  -->
                <div class="row">
                    <div class="page-content twelvecol">
                        <?php the_content();  ?>
                    </div>
                </div>
            </div>

        </section>

        <?php endwhile; ?> <!-- END THE LOOP -->
    <?php wp_reset_postdata(); ?>

</div>

<?php get_footer(); ?>