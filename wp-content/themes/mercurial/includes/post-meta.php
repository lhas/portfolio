<ul class="entry-meta border centered small thin">
    <li class="meta-author"><?php _e('By ', 'framework'); the_author_posts_link(); ?></li>
    <li class="meta-date"><?php  _e('On ', 'framework'); echo get_the_date();  ?></li>
    <li class="meta-comment"><?php  _e('With ', 'framework'); comments_popup_link(__('No Comments', 'framework'), __('1 Comment', 'framework'), __('% Comments', 'framework')); ?></li>
    <li class="meta-categories"><?php  _e('In ', 'framework');  the_category(', '); ?></li>
    <li class="meta-tags"><?php the_tags(__('Tagged ', 'framework'),', '); ?></li>
</ul>
