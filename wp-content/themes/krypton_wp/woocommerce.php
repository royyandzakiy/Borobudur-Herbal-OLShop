<?php
defined('ABSPATH') or die();

/**
 * The default template for displaying content
 *
 * Used for single page.
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 */

global $krypton_config,$wp_registered_sidebars;

get_header('shop');?>
<?php 

$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['shop-sidebar']) && count($sidebars['shop-sidebar'])){
	$sidebar='shop-sidebar';

}


$shop_page_id = wc_get_page_id( 'shop' );
$sidebar_position = get_post_meta( $shop_page_id, 'sidebar_position', true );

if(!isset($sidebar_position) || empty($sidebar_position) || $sidebar_position=='default'){
	switch ($krypton_config['layout']) {
		case 1:
			$sidebar_position = "nosidebar";
			break;
		case 2:
			$sidebar_position = "sidebar-left";
			break;
		case 3:
			$sidebar_position = "sidebar-right";
			break;
		default:
			$sidebar_position = "sidebar-left";
	}


}

if(!$sidebar){
	$sidebar_position = "nosidebar";
}

set_query_var('sidebar',$sidebar);
$class_sidebar = $sidebar_position;

?>

<div <?php post_class("dt-category-view ".$class_sidebar); ?>>
	<?php if(!is_shop() || (!$krypton_config['show-shop-slide'] && is_shop())):?>
	<section class="subpage-banner shop-detail-fullwidth-banner">
				<div class="container">
					<div class="row header-group">
						<div class="col-sm-8 col-sm-12">
			<?php //if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
							<h1><?php woocommerce_page_title();?></h1>
			<?php //endif; ?>
							<p><?php do_action( 'woocommerce_archive_description' );?></p>
						</div>
						<div class="col-xs-4 hidden-xs"> 
							<?php echo woocommerce_breadcrumb(); ?>
							<?php //add_action('woocommerce_dt_breadcrumb','woocommerce_breadcrumb',1); ?>
							<?php //do_action('woocommerce_dt_breadcrumb'); ?>
						</div>
					</div>
				</div>
	</section>
<?php endif;?>

	<div class="container">
		<div class="row">
<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
<?php	} else { ?>
			<div class="col-sm-8<?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?>">
<?php	} ?>

<?php 	if ( is_singular( 'product' )) {
?>
			<div class="row">
			<?php woocommerce_content();?>
			</div>

<?php		}
		elseif (!is_product_category()) { ?>
			<div class="section-head no-description">
				<header class="centered">
					<section>
						<h2><?php woocommerce_page_title(); ?></h2>
					</section>
					<hr>
				</header>
			</div>
			<div class="row">
			<?php woocommerce_content();?>
			</div>
<?php 	} else { //if (!is_product_category()) ?>
			<div class="row">
			<?php dt_woocommerce_content();?>
			</div>
<?php 	} //if (!is_product_category()) ?>
				<?php if ( is_active_sidebar( 'shop-bottom' ) ) :?>
				<div class="row">
					<div class="shop-bottom">
						<?php dynamic_sidebar("shop-bottom");?>
					</div>
				</div>
			<?php endif;?>

			</div>
<?php if ('sidebar-right'==$sidebar_position) { ?>
			<div class="col-sm-4 sidebar">
				<?php get_sidebar('shop'); ?>
			</div>
<?php }
	elseif ($sidebar_position=='sidebar-left') { ?>
			<div class="col-sm-4 sidebar col-sm-pull-8">
				<?php get_sidebar('shop'); ?>
			</div>
<?php }?>
		</div><!-- .row -->
	</div><!-- .container -->	
</div>
<?php
get_footer('shop');
?>