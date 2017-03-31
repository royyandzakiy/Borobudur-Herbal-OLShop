<?php
/**
 * Order Customer Details
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="row">
	<div class="col-sm-4">
		<header>
			<h2><?php _e( 'Customer details', 'woocommerce' ); ?></h2>
		</header>
		<dl class="customer_details">
			<?php if ( $order->customer_note ) : ?>
			<dt><?php _e( 'Note:', 'woocommerce' ); ?></dt>
			<td><?php echo wptexturize( $order->customer_note ); ?></td>
		<?php endif; ?>
		<?php
			if ( $order->billing_email ) echo '<dt>' . __( 'Email:', 'woocommerce' ) . '</dt><dd>' . esc_html( $order->billing_email ) . '</dd>';
			if ( $order->billing_phone ) echo '<dt>' . __( 'Telephone:', 'woocommerce' ) . '</dt><dd>' . esc_html( $order->billing_phone ) . '</dd>';

			// Additional customer details hook
			do_action( 'woocommerce_order_details_after_customer_details', $order );
		?>
		</dl>
	</div>

	<div class="col-sm-8">
		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

		<div class="col2-set addresses">
			
			<div class="col-1">

		<?php endif; ?>

				<header class="title">
					<h3><?php _e( 'Billing Address', 'woocommerce' ); ?></h3>
				</header>
				<address><p>
					<?php echo ( $address = $order->get_formatted_billing_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
				</p></address>

		<?php if ( ! wc_ship_to_billing_address_only() && $order->needs_shipping_address() ) : ?>

			</div><!-- /.col-1 -->

			<div class="col-2">

				<header class="title">
					<h3><?php _e( 'Shipping Address', 'woocommerce' ); ?></h3>
				</header>
				<address><p>
					<?php echo ( $address = $order->get_formatted_shipping_address() ) ? $address : __( 'N/A', 'woocommerce' ); ?>
				</p></address>

			</div><!-- /.col-2 -->

		</div><!-- /.col2-set -->

		<?php endif; ?>
	</div><!--div class="col-sm-8"-->
</div><!--div class="row"-->