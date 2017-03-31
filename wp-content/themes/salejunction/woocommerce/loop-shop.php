<?php
/**
 * Loop-shop (deprecated)
 *
 * Outputs a product loop
 *
 * @author 		Inkthemes
 * @package 	SalesJunction/Templates
 * @version     1.6.4
 * @deprecated 	1.6
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
_deprecated_file(basename(__FILE__), '1.6', '', 'Use your own loop code, as well as the content-product.php template. loop-shop.php will be removed in WC 2.1.');

if (have_posts()) :
    do_action('woocommerce_before_shop_loop');
    woocommerce_product_loop_start();
    woocommerce_product_subcategories();
    while (have_posts()) : the_post();
        woocommerce_get_template_part('content', 'product');
    endwhile; // end of the loop.          
    woocommerce_product_loop_end();
    do_action('woocommerce_after_shop_loop');
else :
    if (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) :
        ?>
        <p><?php _e('No products found which match your selection.', 'salejunction'); ?></p>
        <?php
    endif;
endif;
?>
<div class="clear"></div>