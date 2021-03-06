<?php 
defined('ABSPATH') or die();
/**
 *
 *
 * @package WordPress
 * @subpackage Krypton
 * @version 3.0
 * @since Krypton 1.0
 */

global $krypton_config;

$showSlide=$krypton_config['show-shop-slide'];

?>
<!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8) ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php 
	if (!is_404()) {
			locate_template( 'shopnavigation.php',true);

		if( function_exists('is_shop') &&  is_shop() && $showSlide){

			locate_template( 'shopslide.php',true);

		}
	} 
?>