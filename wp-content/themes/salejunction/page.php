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
<div class="content_wrapper woocommerce">
    <div class="page-content">
        <div class="container_24">
            <div class="grid_24">
                <div class="fullwidth">
                    <div class="fullwidth_inner">
                        <h1 class="page-title"><?php the_title(); ?></h1>
                        <?php
                        if (have_posts()) : the_post();
                            the_content();
                        endif;

                        wp_link_pages(array(
                            'before' => '<div class="clear"></div><div class="page-link"><span>' . __('Pages:', 'salejunction') . '</span>',
                            'after' => '</div>'));

                        comments_template();
                        ?>

                    </div> 
                </div> 
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>