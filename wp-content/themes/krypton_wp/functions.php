<?php
defined('ABSPATH') or die();

/**
 * @package WordPress
 * @subpackage Krypton
 * @version 3.0.0
 * @since Krypton 1.0.0
 */

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
require_once( get_template_directory().'/lib/tgm/class-tgm-plugin-activation.php');
add_action( 'tgmpa_register', 'krypton_theme_register_required_plugins' );

function krypton_theme_register_required_plugins() {

	/**
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */

		// This is an example of how to include a plugin pre-packaged with a theme
	$plugins = array(

		// This is an example of how to include a plugin pre-packaged with a theme
		array(
			'name'     				=> 'DT Page Builder', // The plugin name
			'slug'     				=> 'detheme_builder', // The plugin slug (typically the folder name)
			'core'					=> true,
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/detheme_builder_1.3.7.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.3.4', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '1.3.7', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/detheme_builder_1.3.7.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'LayerSlider WP', // The plugin name
			'slug'     				=> 'LayerSlider', // The plugin slug (typically the folder name)
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/layersliderwp-5.5.0.installable.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '5.0.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '5.0.2', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/layersliderwp-5.5.0.installable.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Detheme Team', // The plugin name
			'slug'     				=> 'detheme-team', // The plugin slug (typically the folder name)
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/detheme-team.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '1.0.0', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/detheme-team.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Detheme Testimonials', // The plugin name
			'slug'     				=> 'detheme-testimoni', // The plugin slug (typically the folder name)
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/detheme-testimoni.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '1.0.0', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/detheme-testimoni.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Detheme Portfolio', // The plugin name
			'slug'     				=> 'detheme-portfolio', // The plugin slug (typically the folder name)
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/detheme-portfolio.1.0.6.zip', // The plugin source
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '1.0.6', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/detheme-portfolio.1.0.6.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Essential_Grid', // The plugin name
			'slug'     				=> 'essential-grid', // The plugin slug (typically the folder name)
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/essential-grid.zip', // The plugin source
			'core'					=> false,
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '2.0.6', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '2.0.6', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/essential-grid.zip', // If set, overrides default API URL and points to an external URL
		),
		array(
			'name'     				=> 'Krypton WP Demo Packages', // The plugin name
			'slug'     				=> 'krypton-demo', // The plugin slug (typically the folder name)
			'source'   				=> 'http://detheme.com/repo/mnemonic/plugins/krypton-demo_1.0.1.zip', // The plugin source
			'core'					=> false,
			'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '1.0.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'package_version' 		=> '1.0.1', // new plugin version
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> 'http://detheme.com/repo/mnemonic/plugins/krypton-demo_1.0.1.zip', // If set, overrides default API URL and points to an external URL
		)
		);

	// Change this to your theme text domain, used for internationalising strings

	/**
	 * Array of configuration settings. Amend each line as needed.
	 * If you want the default strings to be available under your own theme domain,
	 * leave the strings uncommented.
	 * Some of the strings are added into a sprintf, so see the comments at the
	 * end of each line for what each argument will be.
	 */
	$config = array(
		'id'       		    => 'krypton-tgmpa',  
		'domain'       		=> 'tgmpa',         	// Text domain - likely want to be the same as your theme.
		'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
		'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
		'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
		'menu'         		=> 'install-required-plugins', 	// Menu slug
		'has_notices'      	=> true,                       	// Show admin notices or not
		'is_automatic'    	=> false,					   	// Automatically activate plugins after installation or not
		'message' 			=> '',							// Message to output right before the plugins table
	);

	tgmpa( $plugins, $config );

}



function dtheme_startup() {

	global $dt_revealData,$krypton_Scripts,$krypton_config;


	$dt_revealData=array();
	$krypton_Scripts=array();
	$theme_name=get_template();

	$locale = get_locale();
	$localelanguage=get_template_directory() . '/languages';

	if((is_child_theme() && !load_textdomain( 'Krypton', untrailingslashit(get_stylesheet_directory()) . "/{$locale}.mo")) || (!is_child_theme() && !load_theme_textdomain('Krypton',get_template_directory() )  )){
		$aaa=load_theme_textdomain('Krypton',$localelanguage );
	}


	// Add post thumbnail supports. http://codex.wordpress.org/Post_Thumbnails
	add_theme_support('post-thumbnails');
	add_theme_support('automatic-feed-links');
	add_theme_support('menus');
	add_theme_support( 'woocommerce' );
	add_theme_support( 'title-tag' );

	register_nav_menus(array(

		'primary' => __('Top Navigation', 'Krypton'),
		'footer_navigation' => __('Footer Navigation', 'Krypton')

	));



	// sidebar widget


	register_sidebar(
		array('name'=> 'Sidebar',
			'id'=>'krypton-sidebar',
			'description'=> __('Sidebar Widget Area', 'Krypton'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<h3 class="widget_title">',
			'after_title' => '</h3>'
		));

	register_sidebar(
		array('name'=> 'Bottom Widget',
			'id'=>'krypton-bottom',
			'description'=> __('Bottom Widget Area. Recomended 3 widgets', 'Krypton'),
			'before_widget' => '<div class="col-lg-4 col-md-4 col-sm-4 clearfix"><div class="widget %s %s">',
			'after_widget' => '</div></div>',
			'before_title' => '<div class="row"><div class="section-head"><header class="col col-sm-12 centered"><h2>',
			'after_title' => '</h2><hr></header></div></div>'

		));

	register_sidebar(
		array('name'=> 'Contact Page Sidebar',
			'id'=>'krypton-contact-sidebar',
			'description'=> __('Widget area for contact page', 'Krypton'),
			'before_widget' => '<div class="widget %s %s">',
			'after_widget' => '</div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>'

		));

	if (is_plugin_active('woocommerce/woocommerce.php')) {

		register_sidebar(
			array('name'=> 'Shop Sidebar',
				'id'=>'shop-sidebar',
				'description'=> __('Sidebar Widget Area', 'Krypton'),
				'before_widget' => '<div class="widget %s %s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget_title">',
				'after_title' => '</h3>'
			));
		register_sidebar(
			array('name'=> 'Shop Bottom ',
				'id'=>'shop-bottom',
				'description'=> __('Shop Bottom Widget Area. Displayed at shop pages', 'Krypton'),
				'before_widget' => '<div class="col-md-3 col-sm-6"><div class="widget %s %s">',
				'after_widget' => '</div></div>',
				'before_title' => '<h3 class="widget_title">',
				'after_title' => '</h3>'
			));
	}


	add_action('wp_enqueue_scripts', 'dt_enqueue_color_scheme' );
	add_action('wp_enqueue_scripts', 'dtheme_scripts', 999);
	add_action('wp_print_scripts', 'dtheme_register_var', 998);
	add_action('wp_print_scripts', 'detheme_print_inline_style' );
	add_action('wp_footer', 'dtheme_register_mainmenu', 997);
	add_action('wp_enqueue_scripts', 'dtheme_css_style',999 );

  	add_action('wp_footer',create_function('','global $krypton_Scripts;if(count($krypton_Scripts)) print "<script type=\"text/javascript\">\n".@implode("\n",$krypton_Scripts)."\n</script>\n";'),99998);

} 

add_action('after_setup_theme','dtheme_startup');
    // enqueue base scripts and styles

remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

function dtheme_register_mainmenu(){

	global $krypton_config;

	if((is_home() || is_front_page()) && isset($krypton_config['showmenu']) && '1'!==$krypton_config['showmenu']):

	?>
<script type="text/javascript">
$(document).scroll(function () {
    'use strict';
    var y = $(this).scrollTop();
    if (y > 2) {
        $('.home .navbar-main').fadeIn();
    } else {
        $('.home .navbar-main').fadeOut();
    }

});
</script>
<?php 
	else:
?>
<style type="text/css">
.home .navbar-default{display: block;}
</style>
<?php
	endif;
}

function dtheme_register_var(){

	global $krypton_config;

	$color=(!isset($krypton_config['main-color']))?'#1abc9c':$krypton_config['main-color'];

?>
<script type="text/javascript">
var themeUrl="<?php print get_template_directory_uri();?>/";
var themeColor="<?php print $color;?>";
</script>
<?php 
}

function detheme_print_inline_style(){
	global $krypton_config;

	if(isset($krypton_config['sandbox-mode']) && $krypton_config['sandbox-mode']){
  		$customstyle=krypton_style_compile($krypton_config,"",false);

  		print "<style type=\"text/css\">".$customstyle."</style>";
  	}

	if(!empty($krypton_config['dt-banner-height'])){

		$krypton_config['dt-banner-height']=(strpos($krypton_config['dt-banner-height'], "px") || strpos($krypton_config['dt-banner-height'], "%"))?$krypton_config['dt-banner-height']:$krypton_config['dt-banner-height']."px";
		print "<style type=\"text/css\">\n";
		print ".subpage-banner {min-height:".$krypton_config['dt-banner-height'].";height:".$krypton_config['dt-banner-height'].";}\n";
		print "</style>\n";

	}
}

function dtheme_css_style(){

	global $krypton_config;


	wp_enqueue_style( 'stylesheet', get_template_directory_uri() . '/style.css', array(), '', 'all');
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.0' );	
	wp_enqueue_style( 'fontello-font', get_template_directory_uri() . '/css/fontello.css');

	$primaryfont=$krypton_config['primary-font'];

	if(isset($primaryfont['font-family']) && !empty($primaryfont['font-family'])){

		$fontfamily=$primaryfont['font-family'];
		$fontfamily=str_replace(' ','+',$fontfamily);
		$fontvarian=array();

		if (isset($primaryfont['font-options'])) {
			$variants= json_decode($primaryfont['font-options'],true);
			if($variants['variants'] && count($variants['variants'])){
				foreach($variants['variants'] as $vari){
						$fontvarian[$vari['id']]=$vari['id'];
				}
			}
		}

		wp_enqueue_style( $fontfamily, '//fonts.googleapis.com/css?family='.$fontfamily.(count($fontvarian)?":".@implode(',',$fontvarian):""));
	}
	else{
		wp_enqueue_style( 'opensans-font', '//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800');

	}

	$secondaryfont=$krypton_config['secondary-font'];

	if(isset($secondaryfont['font-family']) && !empty($secondaryfont['font-family'])){

		$fontfamily=$secondaryfont['font-family'];
		$fontfamily=str_replace(' ','+',$fontfamily);
		$fontvarian=array();

		if (isset($primaryfont['font-options'])) {
			$variants= json_decode($secondaryfont['font-options'],true);
			if($variants['variants'] && count($variants['variants'])){
				foreach($variants['variants'] as $vari){
						$fontvarian[$vari['id']]=$vari['id'];
				}
			}
		}

		wp_enqueue_style( $fontfamily, '//fonts.googleapis.com/css?family='.$fontfamily.(count($fontvarian)?":".@implode(',',$fontvarian):""));


	}
	else{

		wp_enqueue_style( 'lora-font' , '//fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic');

	}

	wp_enqueue_style( 'styleable-select-style', get_template_directory_uri() . '/css/select-theme-default.css', array(), '0.4.0', 'all' );
	if(is_home() || is_front_page() || (function_exists('is_shop')?is_shop():false)){

		if(function_exists('is_shop') && is_shop()){
			wp_enqueue_style( 'shop-slide', get_template_directory_uri() . '/css/shop_slider.css', array());
		}
		else{
			wp_enqueue_style( 'krypton-slide', get_template_directory_uri() . '/css/slider.css', array());
		}
	}

	wp_enqueue_style( 'krypton-style',get_template_directory_uri() . '/css/krypton.css', array(), '', 'all' );


	// Loads the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'krypton-style-ie', get_template_directory_uri() . '/css/ie9.css', array( 'krypton-style' ));
	wp_style_add_data( 'krypton-style-ie', 'conditional', 'IE 9' );
	wp_enqueue_style( 'custom-theme-style',get_template_directory_uri() . '/css/customstyle.css', array(), '', 'all' );

	wp_enqueue_style( 'child-theme-style',get_stylesheet_directory_uri() . '/css/mystyle.css', array(), '', 'all' );

	add_action('wp_footer',create_function('','global $dt_revealData;if(count($dt_revealData)) { print @implode("\n",$dt_revealData);'
		.'print "<div class=\"md-overlay\"></div>\n";'
		.'print "<script type=\'text/javascript\' src=\''.get_template_directory_uri().'/js/modal_effects.js\'></script>";} print "<div class=\"jquery-media-detect\"></div>";'),99999);


	/* favicon handle */

	if(isset($krypton_config['dt-favicon-image']['url']) && ''!==$krypton_config['dt-favicon-image']['url']){
		$favicon_url=$krypton_config['dt-favicon-image']['url'];
		print "<link rel=\"shortcut icon\" type=\"image/png\" href=\"".esc_url($favicon_url)."\">\n";
	}

}

function dtheme_scripts(){
	global $krypton_config;


  	if(isset($krypton_config['js-code']) && !empty($krypton_config['js-code'])){
  		add_action('wp_footer',create_function('','global $krypton_config;if(isset($krypton_config[\'js-code\']) && !empty($krypton_config[\'js-code\'])) print "<script type=\"text/javascript\">".$krypton_config[\'js-code\']."</script>\n";'),99998);
	}

    wp_enqueue_script( 'modernizr' , get_template_directory_uri() . '/js/modernizr.js', array( ), '2.6.2', false );
    wp_enqueue_script( 'bootstrap' , get_template_directory_uri() . '/js/bootstrap.js', array( 'jquery' ), '3.0', false );
    wp_enqueue_script( 'dt-chart', get_template_directory_uri() . '/js/chart.js', array( 'jquery' ), '1.0', false );
    wp_enqueue_script( 'dt-script' , get_template_directory_uri() . '/js/myscript.js', array( 'jquery' ), '1.0', false );
    wp_enqueue_script( 'edit-comments', get_template_directory_uri() . '/js/comment-reply.min.js', array( 'jquery' ), '1.0', false );
   	wp_enqueue_script( 'uilkit', get_template_directory_uri() . '/js/core.js', array(), '1.0', false );
    wp_enqueue_script( 'ScrollSpy', get_template_directory_uri() . '/js/scrollspy.js', array( 'uilkit' ), '1.0', false );
    wp_enqueue_script( 'styleable-select', get_template_directory_uri() . '/js/select.js', array(), '0.4.0', true );
    wp_enqueue_script( 'styleable-select-exec' , get_template_directory_uri() . '/js/select.init.js', array('styleable-select'), '1.0.0', true );
	wp_enqueue_script( 'sequence', get_template_directory_uri() . '/js/jquery.sequence.js', array( 'jquery' ), '1.0');
}



function dt_enqueue_color_scheme() {
	global $krypton_config;
	if(isset($krypton_config['stylesheet'])){

		$color_scheme=trim($krypton_config['stylesheet']);

		if('default'!==$color_scheme && !empty($color_scheme)){

		    wp_enqueue_style( 'color-scheme',get_template_directory_uri() . '/css/color/'.$color_scheme.'.css', false );
			do_action( 'dt_enqueue_color_scheme_'.$color_scheme, $color_scheme,$krypton_config);
		}

	}

		?>
	<?php

}

add_action( 'wp_print_scripts', 'dt_enqueue_color_scheme' );

require_once( get_template_directory().'/lib/dt_init.php'); // load bootstrap stylesheet and scripts
require_once( get_template_directory().'/lib/custom_functions.php'); // load specific functions
require_once( get_template_directory().'/lib/widgets.php'); // load custom widgets
require_once( get_template_directory().'/lib/shortcodes.php'); // load custom widgets
require_once( get_template_directory().'/lib/updater.php'); // load custom widgets
require_once( get_template_directory().'/lib/migration.php'); // migration from gt3 to detheme_builder
require_once( get_template_directory().'/lib/detheme_demo/one_click.php'); // load detheme one click installer

?>