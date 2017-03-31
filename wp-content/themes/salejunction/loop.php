<!-- Start the Loop. -->
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>          
        <!--post start-->
        <h1 class="post_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php printf(__('Permanent Link to %s', 'salejunction'), the_title_attribute('echo=0')); ?>"><?php the_title(); ?></a></h1>
        <div id="post-<?php the_ID(); ?>" <?php post_class('blog'); ?>>		 
            <div class="post_content">
                <ul class="post_meta blog">
                    <li class="post_date">&nbsp;&nbsp;
                        <?php
                        $archive_year = get_the_time('Y');
                        $archive_month = get_the_time('m');
                        $archive_day = get_the_time('d');
                        ?>
                        <a href="<?php
                        echo get_day_link($archive_year, $archive_month, $archive_day);
                        ?>"><?php echo get_the_time('M, d, Y') ?></a></li>
                    <li class="posted_by"><?php _e('by&nbsp;', 'salejunction'); ?><span><?php the_author_posts_link(); ?></span></a></li>
                    <li class="post_category"><?php the_category(', '); ?></li>
                    <li class="post_comment"><span><?php
                            comments_popup_link(__('No Comments.', 'salejunction'), __('1 Comment.', 'salejunction'), __('% Comments.', 'salejunction'));
                            ?></li>
                </ul>           
                <?php
                if (has_post_thumbnail()) {

                    get_post_thumbnail_id();
                } else {

                    salejunction_get_image();
                }
                the_excerpt();
                ?>
                <a class="read_more" href="<?php the_permalink() ?>"><?php _e('Read More...', 'salejunction'); ?></a> </div>
            <div class="clear"></div>
            <?php if (has_tag()) { ?>
                <div class="tag">
                    <?php
                    the_tags(__('Post Tagged with&nbsp;', 'salejunction'), ', ', '');
                    ?>
                </div>
            <?php } ?>
        </div>
        <!--End Post-->
        <?php
    endwhile;
else:
    ?>
    <div class="post">
        <p>
            <?php _e('Sorry, no posts matched your criteria.', 'salejunction'); ?>
        </p>

    </div>
<?php endif; ?>
<!--End Loop-->