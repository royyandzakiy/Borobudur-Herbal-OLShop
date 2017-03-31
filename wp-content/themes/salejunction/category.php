<?php
/**
 * The template for displaying Author Archive pages.
 *
 * @package WordPress
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
                        <?php
                        if (have_posts()) :
                            $category_description = category_description();
                            if (!empty($category_description))
                                echo '' . $category_description . '';
                            /* Run the loop for the category page to output the posts.
                             * If you want to overload this in a child theme then include a file
                             * called loop-category.php and that will be used instead.
                             */
                            get_template_part('loop', 'category');
                            ?>
                            <div class="clear"></div>
                            <nav id="nav-single"> <span class="nav-previous">
                                    <?php next_posts_link(__('Newer posts &rarr;', 'salejunction')); ?>
                                </span> <span class="nav-next">
                                    <?php previous_posts_link(__('&larr; Older posts', 'salejunction')); ?>
                                </span> </nav>
                        <?php endif; ?>
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