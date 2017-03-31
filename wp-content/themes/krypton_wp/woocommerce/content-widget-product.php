<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see 	http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product; ?>

<div class="list-item">
	<div class="row">
		<div class="col-xs-5">
			<a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>"><?php echo $product->get_image(); ?></a>
		</div>
		<div class="col-xs-7">
			<div class="product-title"><a href="<?php echo esc_url( get_permalink( $product->id ) ); ?>"><?php echo esc_attr( $product->get_title() ); ?></a></div>
			<?php if ( ! empty( $show_rating ) ): ?>
			<div class="row split">
				<div class="col-xs-6">
					<div class="product-price"><?php echo apply_filters('detheme_woocommerce_product_price_html',$product); ?></div>	
				</div>
				<div class="col-xs-6">
					<?php echo $product->get_rating_html();?>
					<div class="rating small" data-average="4.7"></div>
				</div>
			</div>
		<?php else:?>
			<div class="product-price"><?php echo apply_filters('detheme_woocommerce_product_price_html',$product); ?></div>
		<?php endif;?>
		</div>
	</div>
</div>