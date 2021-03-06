<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Extra post classes
$classes = array();

switch ($woocommerce_loop['columns']) {
	case '2':
			$coll=6;
		break;
	case '3':
			$coll=4;
		break;
	case '4':
			$coll=3;
		break;
	case '12':
			$coll=1;
		break;
	
	default:
			$coll=12;
		break;
}

$classes[] = 'col-sm-'.$coll;


if(version_compare(WC()->version,'2.6.0','<')){

	// Increase loop count
	$woocommerce_loop['loop']++;

	if ( 0 === ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 === $woocommerce_loop['columns'] ) {
		$classes[] = 'first';
	}
	if ( 0 === $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
		$classes[] = 'last';
	}
}

?>
<div <?php post_class( $classes ); ?>>

	<?php
	/**
	 * woocommerce_before_shop_loop_item hook.
	 *
	 * @hooked woocommerce_template_loop_product_link_open - 10
	 */
	do_action( 'woocommerce_before_shop_loop_item' );
	?>

	<p class="product-name"><?php the_title(); ?></p>

	<div class="product-thumbnail">
		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		<!--img alt="" src="_/images/shop/tees_1/tees_1.jpg" class="img-responsive"-->
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
		<div class="col-xs-12 dt-fix-height">
			<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
			<!--a class="add-to-cart btn-active add_to_cart_button" href=""><?php echo __('Add to Cart','WooCommerce');?></a-->
		</div>
	</div>
</div>
