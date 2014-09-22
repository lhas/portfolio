<?php get_header(); ?>
<div id="main" role="main" class="wrapper common">
    <div class="container">
        <div class="row">
            <div class="twelvecol">
                <div class="title common">
                    <h1 class='text'><?php  _e('Oops!', 'framework'); ?></h1>
                </div>
            </div>
        </div>
    </div>
    <div class="container clearfix posts">
        <div class="row">
            <div class="twelvecol">
                <!--BEGIN .hentry -->
                <div class="entry-content">
                    <p> <?php _e('The page you are looking for does not exist!', 'framework') ?></p>
                </div>
                <!-- END CONTENT-->
            </div>
        </div>
    </div>
</div>


<?php get_footer(); ?>