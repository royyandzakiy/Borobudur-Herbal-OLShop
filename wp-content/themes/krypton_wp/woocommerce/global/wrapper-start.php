<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$template = get_option( 'template' );

global $krypton_config;

switch ($krypton_config['layout']) {
	case 1:
		$sidebar_position = "nosidebar";
		$col_class = "col-sm-12";
		break;
	case 2:
		$sidebar_position = "sidebar-left";
		$col_class = "col-sm-8";
		break;
	case 3:
		$sidebar_position = "sidebar-right";
		$col_class = "col-sm-8";
		break;
	default:
		$sidebar_position = "sidebar-left";
		$col_class = "col-sm-8";
}

switch( $template ) {
	case 'twentyeleven' :
		echo '<div id="primary"><div id="content" role="main">';
		break;
	case 'twentytwelve' :
		echo '<div id="primary" class="site-content"><div id="content" role="main">';
		break;
	case 'twentythirteen' :
		echo '<div id="primary" class="site-content"><div id="content" role="main" class="entry-content twentythirteen">';
		break;
	case 'twentyfourteen' :
		echo '<div id="primary" class="content-area"><div id="content" role="main" class="site-content twentyfourteen"><div class="tfwc">';
		break;
	default :
?>
		<div class="dt-category-view <?php echo $sidebar_position; ?>">
			<section class="subpage-banner shop-detail-fullwidth-banner">
				<div class="container">
					<div class="row header-group">
						<div class="col-sm-8 col-sm-12">
			<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
							<h1><?php woocommerce_page_title(); ?></h1>
			<?php endif; ?>
							<p><?php do_action( 'woocommerce_archive_description' ); ?></p>
						</div>
						<div class="col-xs-4 hidden-xs"> 
							<?php add_action('woocommerce_dt_breadcrumb','woocommerce_breadcrumb',1); ?>
							<?php do_action('woocommerce_dt_breadcrumb'); ?>
						</div>
					</div>
				</div>
			</section>
			
			<div class="container">
				<div class="row">


<?php
		break;
}