<!--Start Comment box-->
<?php
if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die(__('Please do not load this page directly. Thanks!', 'salejunction'));
if (post_password_required()) {
    ?>
    <p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'salejunction'); ?></p>
    <?php
    return;
}
?>
<!-- You can start editing here. -->
<div id="commentsbox">
    <?php if (have_comments()) : ?>
        <h3 id="comments">
            <?php comments_number(__('No Responses', 'salejunction'), __('One Response', 'salejunction'), __('% Responses', 'salejunction')); ?>
            so far.</h3>
        <ol class="commentlist">
            <?php wp_list_comments(); ?>
        </ol>
        <div class="comment-nav">
            <div class="alignleft">
                <?php previous_comments_link() ?>
            </div>
            <div class="alignright">
                <?php next_comments_link() ?>
            </div>
        </div>
        <?php
    else : // this is displayed if there are no comments so far 
        if (comments_open()) :
            ?>
            <!-- If comments are open, but there are no comments. -->
        <?php else : // comments are closed    ?>
            <!-- If comments are closed. -->
            <p class="nocomments"></p>
        <?php
        endif;
    endif;
    if (comments_open()) :
        ?>
        <div id="comment-form">
            <?php comment_form(); ?>
        </div>
    <?php endif; // if you delete this the sky will fall on your head     ?>
</div>
<!--End Comment box--> 