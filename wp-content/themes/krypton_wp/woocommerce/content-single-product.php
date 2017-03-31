<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>

<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );

	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>

<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>

<div class="row detail-product-top-part">
	<div class="col-sm-6">
	<?php
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
	</div><!--div class="col-sm-6"-->

	<div class="col-sm-6">
		<?php
			add_action( 'woocommerce_dt_single_product_title', 'woocommerce_template_single_title', 5 );
			do_action( 'woocommerce_dt_single_product_title' );
		?>

		<div class="row">
		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			//do_action( 'woocommerce_single_product_summary' );
			add_action( 'woocommerce_dt_single_product_price_rating', 'woocommerce_template_single_price', 1 );
			add_action( 'woocommerce_dt_single_product_price_rating', 'woocommerce_template_single_rating', 2 );
			do_action( 'woocommerce_dt_single_product_price_rating' );
		?>
		</div>

		<?php	
			add_action( 'woocommerce_dt_single_product_excerpt', 'woocommerce_template_single_excerpt', 1 );
			do_action( 'woocommerce_dt_single_product_excerpt' );
		?>

		<div class="row after-add-to-cart">
			<div class="col-xs-12">
		<?php	
			add_action( 'woocommerce_dt_single_product_add_to_cart', 'woocommerce_template_single_add_to_cart', 1 );
			do_action( 'woocommerce_dt_single_product_add_to_cart' );
		?>
			</div>
		</div>

		<?php	
			add_action( 'woocommerce_dt_single_meta', 'woocommerce_template_single_meta', 1 );
			do_action( 'woocommerce_dt_single_meta' );
		?>

		<div class="social-share">
		<?php	
			add_action( 'woocommerce_dt_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			do_action( 'woocommerce_dt_single_product_summary' );
		?>
		</div>

	</div><!--div class="col-sm-6"-->
</div><!--div class="row detail-product-top-part"-->

	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>

	<meta itemprop="url" content="<?php the_permalink(); ?>" />

</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>