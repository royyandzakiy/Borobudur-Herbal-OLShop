<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		Inkthemes
 * @package 	SalesJunction/Templates
 * @version     1.6.4
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
global $product, $woocommerce_loop;
// Store loop count we're currently on
if (empty($woocommerce_loop['loop']))
    $woocommerce_loop['loop'] = 0;
// Store column count for displaying the grid
if (empty($woocommerce_loop['columns']))
    $woocommerce_loop['columns'] = apply_filters('loop_shop_columns', 4);
// Ensure visibility
if (!$product->is_visible())
    return;
// Increase loop count
$woocommerce_loop['loop'] ++;

// Extra post classes
$classes = array();
if (0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'])
    $classes[] = 'first';
if (0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'])
    $classes[] = 'last';
?>
<li id="product_item" <?php post_class($classes); ?>>
    <?php do_action('woocommerce_before_shop_loop_item'); ?>
<section class="edd-image">
    <?php
    if (has_post_thumbnail()) {
        get_post_thumbnail_id();
    } else {
        salejunction_get_image();
    }
    ?>
</section>
<?php if ($price_html = $product->get_price_html()) : ?>
    <span class="price"><?php echo $price_html; ?></span>
    <?php
endif;
if ($product->is_on_sale()) {
    ?>
    <span class="tag-sale"></span>
<?php } ?>
<h6><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h6>
<section class="thumb-content">
    <p><?php echo salejunction_custom_trim_excerpt(15); ?></p>
</section>
</li>