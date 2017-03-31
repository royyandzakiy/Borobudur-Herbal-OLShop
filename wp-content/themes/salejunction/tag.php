<?php
/**
 * The template used to display Tag Archive pages
 *
 * @package WordPress
 * 
 */
get_header();
?>
<div class="content_wrapper">
    <div class="page-content">
        <div class="container_24">
            <div class="grid_24">
                <div class="grid_16 alpha">
                    <div class="content-bar">                         
                        <?php if (have_posts()) : ?>
                            <h1><?php printf(__('Tag Archives: %s', 'salejunction'), single_cat_title('', false)); ?></h1>
                            <?php
                            get_template_part('loop', 'index');
                            /* Display navigation to next/previous pages when applicable */
                            ?>
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