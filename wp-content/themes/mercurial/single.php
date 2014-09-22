<?php
/*
Template Name: Blog
*/
?>
<?php get_header(); ?>
<div id="main" role="main" class="wrapper common">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
    <div class="container clearfix posts">
        <div class="row">
            <div class="twelvecol">
                <!--BEGIN .hentry -->
                <article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
                    <?php $format = get_post_format();
                    if (false === $format)
                        $format = 'standard';

                    get_template_part('includes/' . $format); ?>

                    <div class="entry-title">

                        <h3 class="text"><?php the_title(); ?></h3>

                    </div>
                    <?php  get_template_part('includes/post-meta');?>
                    <div class="entry-content">
                        <?php the_content(); ?>
                    </div>
                </article>
                <div class="comments">
                    <?php comments_template('', true); ?>
                </div>
            </div>

        </div>

    </div>
    <?php endwhile; ?>

    <?php else:
    // no content
endif; ?>

</div>
<?php get_footer(); ?>