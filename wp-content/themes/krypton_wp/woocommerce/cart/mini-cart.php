<?php
/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you (the theme developer).
 * will need to copy the new files to your theme to maintain compatibility. We try to do this.
 * as little as possible, but it does happen. When this occurs the version of the template file will.
 * be bumped and the readme will list any important changes.
 *
 * @see     http://docs.woothemes.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php do_action( 'woocommerce_before_mini_cart' ); ?>

<div class="cart_list product_list_widget <?php echo $args['list_class']; ?>">

	<?php if ( ! WC()->cart->is_empty() ) : ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
				$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key ) ) {

					$product_name  = apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );
					$thumbnail     = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
					$product_price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
					?>

					<div class="popup-item <?php echo esc_attr( apply_filters( 'woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key ) ); ?>">
						<div class="row">
							<div class="col-xs-8">
								<?php
								echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
									'<a href="%s" class="remove remove-it" title="%s" data-product_id="%s" data-product_sku="%s"><i class="icon-cancel-circled-outline"></i></a>',
									esc_url( WC()->cart->get_remove_url( $cart_item_key ) ),
									__( 'Remove this item', 'woocommerce' ),
									esc_attr( $product_id ),
									esc_attr( $_product->get_sku() )
								), $cart_item_key );
								?>
								<div class="text-item">
									<?php if ( ! $_product->is_visible() ) : ?>
										<?php echo $product_name . '&nbsp;'; ?>
									<?php else : ?>
										<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>" class="cart-popup-title" >
											<?php echo $product_name . '&nbsp;'; ?>
										</a>
									<?php endif; ?>

									<p class="cart-popup-info"><span class="mini-cart-price"><?php print $product_price;?></span> /Qty : <span class="popup-quality"><?php print $cart_item['quantity'];?></span></p>
								</div> 
							</div>
							<div class="col-xs-4 thumb">
								<?php if ( ! $_product->is_visible() ) : ?>
									<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
								<?php else : ?>
									<a href="<?php echo esc_url( $_product->get_permalink( $cart_item ) ); ?>">
										<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
						<?php echo WC()->cart->get_item_data( $cart_item ); ?>

					</div>

					<?php
				}
			}
		?>
		
		<?php if ( ! WC()->cart->is_empty() ) : ?>
		
		<div class="popup-bottom-info">
			<div class="total subtotal" data-items="<?php echo WC()->cart->get_cart_contents_count(); ?>">
				<?php _e( 'Subtotal', 'woocommerce' ); ?> <span class="subtotal-price"><?php echo WC()->cart->get_cart_subtotal(); ?></span>
			</div>
			<?php do_action( 'woocommerce_widget_shopping_cart_before_buttons' ); ?>
			<div>
				<a href="<?php echo WC()->cart->get_cart_url(); ?>" class="popup-view-cart">
					<?php _e( 'View Cart', 'woocommerce' ); ?>
				</a>
			</div>
			<div>
				<a href="<?php echo WC()->cart->get_checkout_url(); ?>" class="checkout popup-button-proceed">
					<?php _e( 'Checkout', 'woocommerce' ); ?>
				</a>
			</div>
		</div>

		<?php endif; ?>

	<?php else : ?>

		<div class="empty"><?php _e( 'No products in the cart.', 'woocommerce' ); ?></div>

	<?php endif; ?>

</div><!-- end product list -->

<?php do_action( 'woocommerce_after_mini_cart' ); ?>
