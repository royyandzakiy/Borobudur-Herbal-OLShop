<?php
defined('ABSPATH') or die();

/**
 * footer area
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 3.0
 * @version 3.0
 */
global $krypton_config;


$sidebars=wp_get_sidebars_widgets();
?>

<section class="bottom_section clearfix">
	<div class="container">
		<div class="row">
<?php 
if(is_active_sidebar('krypton-bottom')){
	dynamic_sidebar("krypton-bottom");
}
elseif(is_active_sidebar('sidebar-3') && !is_active_sidebar('krypton-bottom')){
	dynamic_sidebar("Bottom Widget");
}
 ?>
		</div>
	</div>
</section>

<?php 

$menuFooterParams=array(
	'theme_location' => 'footer_navigation',
	'container'=>'div',
	'container_class'=>'footer-menu',
	'menu_class'=>'nav nav-pills',
	'depth'=>1
);
$footertext=function_exists('icl_t') ? icl_t('krypton', 'footer-text', $krypton_config['footer-text']):$krypton_config['footer-text'];
?>
<footer>
<section class="container footer-section">
		<div class="col-md-5 col-xs-12"><?php echo do_shortcode($footertext); ?></div>
		<div class="col-md-7">
			<?php wp_nav_menu($menuFooterParams); ?>
		</div>
</section>
<section class="ss-style-doublediagonal" data-type="background" data-speed="10"></section>
</footer>