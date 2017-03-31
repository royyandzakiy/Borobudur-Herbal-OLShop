<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>

<?php if ( $price_html = apply_filters('detheme_woocommerce_product_price_html',$product)) : ?>
	<span class="price"><?php echo $price_html; ?></span>
<?php endif; ?>