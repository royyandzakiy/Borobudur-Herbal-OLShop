<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the wordpress construct of pages
 * and that other 'pages' on your wordpress site will use a
 * different template.
 *
 */
get_header();
?>
<div class="content_wrapper">
    <div class="page-content woocommerce">
        <div class="container_24">
            <div class="grid_24">
                <div class="grid_16 alpha">
                    <div class="content-bar">
                        <?php the_content(); ?>	
                        <header class="entry-header">
                            <h3 style="line-height:26px; margin-top:49px; color:#f27231; margin-bottom:-4px;">
                                <?php _e('It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.', 'salejunction'); ?>
                            </h3>
                            <br/>
                            <img style=" border:1px solid #ccc; padding:10px; border-radius:5px;" src="<?php echo get_template_directory_uri(); ?>/images/error.jpg"/>
                            <br/><br/>
                            <?php
                            get_search_form();
                            ?>
                            <br/>
                            <?php the_widget('WP_Widget_Recent_Posts', array('number' => 10), array('widget_id' => '404')); ?>
                            <br/>
                            <div class="widget">
                                <h2 class="widgettitle">
                                    <?php _e('Most Used Categories', 'salejunction'); ?>
                                </h2>
                                <br/>
                                <ul>
                                    <?php wp_list_categories(array('taxonomy' => 'download_category', 'orderby' => 'count', 'order' => 'DESC', 'show_count' => 10, 'title_li' => '', 'number' => 10)); ?>
                                </ul>
                            </div>
                            <br/>
                            <?php
                            /* translators: %1$s: smilie */
                            $archive_content = '<p>' . sprintf(__('Try looking in the monthly archives. %1$s', 'salejunction'), convert_smilies(':)')) . '</p>';
                            the_widget('WP_Widget_Archives', array('count' => 0, 'dropdown' => 1), array('after_title' => '</h2>' . $archive_content));
                            the_widget('WP_Widget_Tag_Cloud');
                            ?>
                            <br/>
                    </div>
                </div>
                <div class="grid_8 omega">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>