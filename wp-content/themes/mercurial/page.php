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
    <div class="container clearfix posts">
        <div class="row">
            <div class="twelvecol">
                <!--BEGIN .hentry -->
                <div class="entry-content">
                    <?php the_content(); ?>
                </div><!-- END CONTENT-->
            </div>
        </div>

    </div>
    <?php endwhile; ?>

    <?php else:
    // no content
endif; ?>
</div>
<?php get_footer(); ?>