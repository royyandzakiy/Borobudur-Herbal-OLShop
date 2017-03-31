<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes

?>


<div <?php post_class(); ?>>
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	<p class="product-name"><?php the_title(); ?></p>
	<div class="product-thumbnail">
		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
		do_action( 'woocommerce_before_shop_loop_item_title' );


		?>
		<div class="plus-detail"><a href="<?php echo the_permalink(); ?>"><?php echo __('+ Detail','WooCommerce'); ?></a></div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="product-teaser-price">
		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			remove_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_rating' , 5);
			remove_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_price' , 10);

			add_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_price' , 10);
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
				
			</div>
			<div class="product-teaser-rating">
		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			remove_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_rating' , 5);
			remove_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_price' , 10);

			add_action( 'woocommerce_after_shop_loop_item_title' , 'woocommerce_template_loop_rating' , 5);
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>
				
			</div>
		</div>
		<div class="col-xs-12">
			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
		</div>
	</div>
</div>
