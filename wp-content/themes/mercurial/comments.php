<?php

// Do not delete these lines
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

if (post_password_required()) {
    ?>
<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'framework') ?></p>
<?php
        return;
}

/*-----------------------------------------------------------------------------------*/
/*	Display the comments + Pings
/*-----------------------------------------------------------------------------------*/


if (have_comments()) : // if there are comments
    ?>

<?php if (!empty($comments_by_type['comment'])) : // if there are normal comments ?>

<h3 id="comments"><?php comments_number(__('No Comments', 'framework'), __('One Comment', 'framework'), __('% Comments', 'framework')); ?></h3>


<ol class="comment-list clearfix">
    <?php wp_list_comments('type=comment&callback=coll_comment'); ?>
</ol>

<?php endif; ?>

<?php if (!empty($comments_by_type['pings'])) : // if there are pings ?>

<h3 id="pings"><?php _e('Trackbacks', 'framework') ?></h3>

<ol class="ping-list clearfix">
    <?php wp_list_comments('type=pings&callback=col_pings'); ?>
</ol>

<?php endif; ?>

<?php if (get_next_comments_link() || get_previous_comments_link()) :  ?>

<div class="navigation clearfix">
    <div class="older">
        <?php next_comments_link(__('Older Comments', 'framework')); ?>
    </div>
    <div class="newer">
        <?php previous_comments_link(__('Newer Comments', 'framework')); ?>
    </div>
</div>
<?php endif; ?>

<?php


    /*-----------------------------------------------------------------------------------*/
    /*	Deal with no comments or closed comments
    /*-----------------------------------------------------------------------------------*/

    if ('closed' == $post->comment_status) : // if the post has comments but comments are now closed
        ?>

    <p class="nocomments"><?php _e('Comments are now closed for this article.', 'framework') ?></p>

    <?php endif; ?>

<?php else : // no comments?>

<?php if ('open' == $post->comment_status) : // if comments are open but no comments so far?>

    <?php else : // if comments are closed ?>

    <?php if (is_singular('post')) { ?><p
                class="nocomments"><?php _e('Comments are closed.', 'framework') ?></p><?php } ?>

    <?php endif; ?>

<?php endif;


/*-----------------------------------------------------------------------------------*/
/*	Comment Form
/*-----------------------------------------------------------------------------------*/
comment_form();

