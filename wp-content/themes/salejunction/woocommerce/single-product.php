<?php
/**
 * Single product page for displaying detailed about
 * the selected product. 
 */
get_header();
global $post;
?>
<div class="content_wrapper">
    <div class="page-content">
        <div class="container_24">
            <div class="grid_24">
                <div class="grid_15 alpha">                   
                    <div class="content-bar review">
                        <!--Start Post-->
                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                <div class="post product">
                                    <div class="post_content">  
                                        <?php
                                        global $post, $product, $woocommerce;
                                        $attachment_ids = $product->get_gallery_attachment_ids();
                                        if ($attachment_ids) {
                                            ?>
                                            <div class="flexslider">                            
                                                <ul class="slides">
                                                    <?php
                                                    foreach ($attachment_ids as $attachment_id) {
                                                        $image_link = wp_get_attachment_url($attachment_id);
                                                        ?>
                                                        <li><img src="<?php echo $image_link; ?>" /></li>
                                                    <?php } ?>             
                                                </ul>                            
                                            </div>
                                        <?php } else { ?>
                                            <div class="single_image">
                                                <?php
                                                if (has_post_thumbnail()) {
                                                    echo the_post_thumbnail('page-single');
                                                } else {
                                                    salejunction_get_image();
                                                }
                                                ?></div> 
                                        <?php } ?>
                                        <div class="clear"></div>
                                        <?php
                                        if (has_post_thumbnail() && $atts['thumb'] == 1):
                                            the_post_thumbnail($atts['size']);
                                        elseif ($atts['fallback'] != ""):
                                            ?>
                                            <img src="<?php echo $atts['fallback']; ?>" alt="<?php the_title(); ?>" title="<?php the_title(); ?>"/>
                                        <?php endif; ?>                                          
                                        <div class="entry-content">                                         
                                            <?php wp_link_pages(array('before' => '<div class="page-link">' . __('Pages:', 'salejunction'), 'after' => '</div>')); ?>
                                        </div><!-- .entry-content -->
                                        <!-- .entry-meta -->
                                    </div>									
                                </div><!-- .entry -->    
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
                    </div>
                </div>
                <div class="grid_9 omega">
                    <?php get_sidebar('download'); ?>
                </div>
                <div class="clear"></div>
                <div class="review_panel">
                    <?php
                    /**
                     * woocommerce_after_single_product_summary hook
                     *
                     * @hooked woocommerce_output_product_data_tabs - 10
                     * @hooked woocommerce_output_related_products - 20
                     */
                    remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
                    do_action('woocommerce_after_single_product_summary');
                    ?>
                </div>

            </div>
        </div>
    </div>
    <?php get_footer(); ?>