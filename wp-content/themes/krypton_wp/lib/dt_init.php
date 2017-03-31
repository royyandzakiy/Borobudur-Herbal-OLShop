<?php
defined('ABSPATH') or die();

if(!defined('DETHEME_INSTALLED')) define("DETHEME_INSTALLED",true);

if ( ! isset( $content_width ) ) $content_width = 2000;

if ( !class_exists( 'DethemeReduxFramework' ) && @file_exists( get_template_directory(). '/redux-framework/ReduxCore/framework.php' ) ) {

	locate_template('redux-framework/ReduxCore/framework.php',true);

}



if ( !isset( $krypton_config ) && file_exists( get_template_directory() . '/redux-framework/option/config.php' ) ) {

	locate_template('redux-framework/option/config.php',true);

}


// Display menu under admin bar when user logged in.
function dt_inline_css_menu(){
	if ( is_admin_bar_showing() ) {
		
	$custom_css = '.navbar-fixed-top { top: 32px; } @media (max-width: 600px) {.navbar-fixed-top { top: 0; }}';
?>
	<style type="text/css">
	<?php print $custom_css;?>
	</style>
<?php
	}
}


// Display featured image using inline style (wp_add_inline_style)
function dt_inline_css_featured_image(){
	global $krypton_config;

	$custom_title_css = '';
		//Make sure we're actually on a page
		if ( is_single() or is_page() ) {
			$post = get_post();
			$post_id = $post->ID;

			$content_top_margin = 0;
			if(!empty($krypton_config['dt-content-top-margin'])){
				$content_top_margin = intval($krypton_config['dt-content-top-margin']);
			}

			if ( has_post_thumbnail( $post_id ) ) {
				$featured_img_fullsize_url = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' );
				$custom_title_css = '.blog-single-post .subpage-banner { 
					background-image: url(' . $featured_img_fullsize_url['0'] . '); 
					margin-bottom: '.$content_top_margin.'px; 
				}';
			} else {
				if ($krypton_config['dt-use-default-banner-single-page']==1) {

					$custom_title_css = (!isset($krypton_config['dt-banner-single-page']['url']) || empty($krypton_config['dt-banner-single-page']['url']))?'.blog-single-post .subpage-banner { min-height: 0px; max-height: 0px; height: 0px; margin-bottom: '.$content_top_margin.'px }':'.blog-single-post .subpage-banner { background-image: url(' . $krypton_config['dt-banner-single-page']['url'] . '); margin-bottom: '.$content_top_margin.'px }';
				} else {
					$custom_title_css ='.blog-single-post .subpage-banner { background-image: none; min-height: 0px; max-height: 0px; height: 0px; margin-bottom: '.$content_top_margin.'px }';
				}
			}
			?>
<style type="text/css">
<?php print $custom_title_css;?>
</style><?php
		}
}


// Display default banner image using inline style (wp_add_inline_style)
function dt_inline_css_default_banner_image(){
	global $krypton_config;
	$custom_title_css = '';
	$post =get_post();
	$post_id = ($post)?$post->ID:0;
	

	$slidedata = $krypton_config['homeslide'];

	$content_top_margin = 0;
	if(!empty($krypton_config['dt-content-top-margin'])){
		$content_top_margin = intval($krypton_config['dt-content-top-margin']);
	}

	if (isset($krypton_config['dt-display-header']) && $krypton_config['dt-display-header']==1) {

		$blog_page_id = get_option( 'page_for_posts' );
		$queried_object_id = get_queried_object_id();


		if ($blog_page_id==$queried_object_id) { // kalo di page yg di set sbg posts page
			$featured_img_fullsize_url = wp_get_attachment_image_src( get_post_thumbnail_id($blog_page_id), 'full' );
			
			if (isset($featured_img_fullsize_url) && !empty($featured_img_fullsize_url)) {
				$custom_title_css = '.blog_classic .subpage-banner { background: url(' . esc_url($featured_img_fullsize_url['0']) . ') no-repeat scroll 0 0 !important; background-size: cover!important; margin-bottom: '.$content_top_margin.'px;}';
			} else {
				$custom_title_css ='.blog_classic .subpage-banner { background: url('.esc_url($krypton_config['dt-banner-image']['url']).') no-repeat scroll 0 0 !important; background-size: cover!important; margin-bottom: '.$content_top_margin.'px; }';
			}
		} else if ( has_post_thumbnail( $post_id ) ) {
			$featured_img_fullsize_url = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), 'full' );
			
			if(is_front_page() && isset($slidedata) && is_array($slidedata) && count($slidedata) && ($krypton_config['showslide']==1) && 
				(!empty($slidedata[0]['title'])	|| !empty($slidedata[0]['attachment_id']) || !empty($slidedata[0]['description'])
				|| !empty($slidedata[0]['logo_id']) || !empty($slidedata[0]['slidelabel']))) {
				$custom_title_css = '.blog_classic .subpage-banner { background: url(' . esc_url($featured_img_fullsize_url['0']) . ') no-repeat scroll 0 0 !important; background-size: cover!important; margin-bottom: '.$content_top_margin.'px;}';
			} else {
				$custom_title_css = '.blog_classic .subpage-banner { background: url(' . esc_url($featured_img_fullsize_url['0']) . ') no-repeat scroll 0 0 !important; background-size: cover!important; margin-bottom: '.$content_top_margin.'px;}';
			}
		} else {
			if (isset($krypton_config['dt-banner-image']['url']) && $krypton_config['dt-banner-image']['url']!='') {
				if(is_front_page() && isset($slidedata) && is_array($slidedata) && count($slidedata) && ($krypton_config['showslide']==1) && 
					(!empty($slidedata[0]['title'])	|| !empty($slidedata[0]['attachment_id']) || !empty($slidedata[0]['description'])
					|| !empty($slidedata[0]['logo_id']) || !empty($slidedata[0]['slidelabel']))) {
					$custom_title_css ='.blog_classic .subpage-banner { background: url('.esc_url($krypton_config['dt-banner-image']['url']).') no-repeat scroll 0 0 !important; background-size: cover!important; margin-bottom: '.$content_top_margin.'px;}';
				} else {
					$custom_title_css ='.blog_classic .subpage-banner { background: url('.esc_url($krypton_config['dt-banner-image']['url']).') no-repeat scroll 0 0 !important; background-size: cover!important; margin-bottom: '.$content_top_margin.'px; }';
				}

			} else {
				$custom_title_css = '.blog_classic .subpage-banner { background-color: rgba(200,200,200,0.7); margin-bottom: '.$content_top_margin.'px; } .blog_classic .subpage-banner .container .header-group h1 {font-size:30px;}';
			}
		}
	} else { //if (isset($krypton_config['dt-display-header']) && $krypton_config['dt-display-header']==1)
		if(is_front_page() && isset($slidedata) && is_array($slidedata) && count($slidedata) && ($krypton_config['showslide']==1) && 
			(!empty($slidedata[0]['title'])	|| !empty($slidedata[0]['attachment_id']) || !empty($slidedata[0]['description'])
			|| !empty($slidedata[0]['logo_id']) || !empty($slidedata[0]['slidelabel']))) {
			$custom_title_css = '.blog_classic .subpage-banner { min-height: 0px; max-height: 0px; height: 0px; margin-bottom: '.$content_top_margin.'px; } .blog_classic .subpage-banner .container { display: none !important; } ';
			//$custom_title_css = '.blog_classic .subpage-banner { margin-bottom: 40px; height: 0px; margin-bottom: '.$content_top_margin.'px; } .blog_classic .subpage-banner .container { display: none !important; } ';
		} else {
			$custom_title_css = '.blog_classic .subpage-banner { min-height: 0px; max-height: 0px; height: 0px; margin-bottom: '.$content_top_margin.'px } .blog_classic .subpage-banner .container { display: none !important; } ';
			//$custom_title_css = '.blog_classic .subpage-banner { margin-bottom: 100px; height: 0px; margin-bottom: '.$content_top_margin.'px } .blog_classic .subpage-banner .container { display: none !important; } ';
		}


	}
?>
<style type="text/css">
<?php print $custom_title_css;?>
</style>
<?php
}

// Display default shop banner image using inline style (wp_add_inline_style)
function dt_inline_css_default_shop_banner_image(){
	global $krypton_config;
	$custom_title_css = '';
	if (isset($krypton_config['dt-shop-banner-image']['url']) && $krypton_config['dt-shop-banner-image']['url']!='') {
		$custom_title_css ='.woocommerce-page .subpage-banner, .woocommerce-page .blog-single-post .subpage-banner, .page-template-woocommerce-page-php .subpage-banner { background: url('.$krypton_config['dt-shop-banner-image']['url'].') no-repeat scroll 0 0; }';
	} else {
		$custom_title_css = '.woocommerce-page .subpage-banner, .woocommerce-page .blog-single-post .subpage-banner, .page-template-woocommerce-page-php .subpage-banner { background-color: rgba(200,200,200,0.7); }';
	}
?>
<style type="text/css">
<?php print $custom_title_css;?>
</style>
<?php
}

// Display footer background image using inline style (wp_add_inline_style)
function dt_inline_css_footer_background_image(){
	global $krypton_config;

	$custom_title_css = '';
		if (isset($krypton_config['dt-background-footer']['url']) && $krypton_config['dt-background-footer']['url']!='') {
			$custom_title_css = '.ss-style-doublediagonal:after { background: url(' . esc_url($krypton_config['dt-background-footer']['url']) . ') no-repeat center center !important; background-size: cover !important; }';
?>
<style type="text/css">
<?php print $custom_title_css;?>
</style>
<?php 	
		} else {
			$custom_title_css = '.ss-style-doublediagonal:after { background:  $ccc;background-size: cover !important; }';
?>
<style type="text/css">
<?php print $custom_title_css;?>
</style>
<?php 	
	}
}


if(!is_admin()):
	add_action( 'wp_print_scripts', 'dt_inline_css_menu' );
	add_action( 'wp_print_scripts', 'dt_inline_css_featured_image' );
	add_action( 'wp_print_scripts', 'dt_inline_css_default_banner_image' );
	add_action( 'wp_print_scripts', 'dt_inline_css_default_shop_banner_image' );
	add_action( 'wp_print_scripts', 'dt_inline_css_footer_background_image',99999 );
	add_action( 'wp_print_scripts', 'dt_inline_css_map_background_image' );
	add_action( 'wp_print_scripts', 'dt_inline_css_404_image' );

endif;

// Display map background image using inline style (wp_add_inline_style)
function dt_inline_css_map_background_image(){

	global $krypton_config;

	$custom_title_css = '';
		if (isset($krypton_config['map-image']['url']) && $krypton_config['map-image']['url']!='') {
			$custom_title_css = '.map-image-area { background-image: url(' . esc_url($krypton_config['map-image']['url']) . ') !important; background-size: cover !important; }';
?>
<style type="text/css">
<?php print $custom_title_css;?>
</style>
<?php 	
		} else {
			$custom_title_css = '.map-image-area { background-image: url('.get_template_directory_uri().'/images/aerial_view.jpg) !important; background-size: cover !important; }';
?>
<style type="text/css">
<?php print $custom_title_css;?>
</style>
<?php 	
		}
}


// Display 404 error image using inline style (wp_add_inline_style)
function dt_inline_css_404_image(){

	global $krypton_config;

	$custom_title_css = '';
	if (is_404()) {
		if (isset($krypton_config['dt-background-footer']['url']) && $krypton_config['dt-404-image']['url']!='') {
			$custom_title_css = 'body.error404 .centered { background: url("'. esc_url($krypton_config['dt-404-image']['url']) .'") no-repeat scroll 50% 0 rgba(0, 0, 0, 0) !important;';
?>
<style type="text/css">
<?php print $custom_title_css;?>
</style>
<?php 
		}
	}
}
?>