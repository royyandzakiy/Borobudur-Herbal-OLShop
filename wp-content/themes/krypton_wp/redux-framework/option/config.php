<?php
if (!function_exists('detheme_redux_init')) :
	function detheme_redux_init() {


	global $wp_filesystem;

	if (empty($wp_filesystem)) {
		require_once(ABSPATH .'/wp-admin/includes/file.php');
		WP_Filesystem();
	}  		

	/**
		ReduxFramework Sample Config File
		For full documentation, please visit: https://github.com/ReduxFramework/ReduxFramework/wiki
	**/


	/**
	 
		Most of your editing will be done in this section.

		Here you can override default values, uncomment args and change their values.
		No $args are required, but they can be overridden if needed.
		
	**/
	$args = array();


	// For use with a tab example below
	$tabs = array();

	ob_start();

	$ct = wp_get_theme();
	$theme_data = $ct;
	$item_name = $theme_data->get('Name'); 
	$tags = $ct->Tags;
	$screenshot = $ct->get_screenshot();
	$class = $screenshot ? 'has-screenshot' : '';

	$customize_title = sprintf( __( 'Customize &#8220;%s&#8221;','redux-framework' ), $ct->display('Name') );

	?>
	<div id="current-theme" class="<?php echo esc_attr( $class ); ?>">
		<?php if ( $screenshot ) : ?>
			<?php if ( current_user_can( 'edit_theme_options' ) ) : ?>
			<a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr( $customize_title ); ?>">
				<img src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
			</a>
			<?php endif; ?>
			<img class="hide-if-customize" src="<?php echo esc_url( $screenshot ); ?>" alt="<?php esc_attr_e( 'Current theme preview' ); ?>" />
		<?php endif; ?>

		<h4>
			<?php echo $ct->display('Name'); ?>
		</h4>

		<div>
			<ul class="theme-info">
				<li><?php printf( __('By %s','redux-framework'), $ct->display('Author') ); ?></li>
				<li><?php printf( __('Version %s','redux-framework'), $ct->display('Version') ); ?></li>
				<li><?php echo '<strong>'.__('Tags', 'redux-framework').':</strong> '; ?><?php printf( $ct->display('Tags') ); ?></li>
			</ul>
			<p class="theme-description"><?php echo $ct->display('Description'); ?></p>
			<?php if ( $ct->parent() ) {
				printf( ' <p class="howto">' . __( 'This <a href="%1$s">child theme</a> requires its parent theme, %2$s.' ) . '</p>',
					__( 'http://codex.wordpress.org/Child_Themes','redux-framework' ),
					$ct->parent()->display( 'Name' ) );
			} ?>
			
		</div>

	</div>

	<?php
	$item_info = ob_get_contents();
	    
	ob_end_clean();

	$sampleHTML = '';
	if( file_exists( dirname(__FILE__).'/info-html.html' )) {
		/** @global WP_Filesystem_Direct $wp_filesystem  */

		global $wp_filesystem;
		if (!empty($wp_filesystem)) {
			$sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__).'/info-html.html');
		}  		
	}

	// BEGIN Sample Config

	// Setting dev mode to true allows you to view the class settings/info in the panel.
	// Default: true
	$args['dev_mode'] = false;

	// Set the icon for the dev mode tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['dev_mode_icon'] = 'info-sign';

	// Set the class for the dev mode tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['dev_mode_icon_class'] = '';

	// Set a custom option name. Don't forget to replace spaces with underscores!
	$args['opt_name'] = 'krypton_config';

	// Setting system info to true allows you to view info useful for debugging.
	// Default: false
	//$args['system_info'] = true;


	// Set the icon for the system info tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: info-sign
	//$args['system_info_icon'] = 'info-sign';

	// Set the class for the system info tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['system_info_icon_class'] = 'icon-large';

	$theme = wp_get_theme();

	$args['display_name'] = $theme->get('Name');
	//$args['database'] = "theme_mods_expanded";
	$args['display_version'] = $theme->get('Version');

	// If you want to use Google Webfonts, you MUST define the api key.
	$args['google_api_key'] = 'AIzaSyAX_2L_UzCDPEnAHTG7zhESRVpMPS4ssII';

	// Define the starting tab for the option panel.
	// Default: '0';
	//$args['last_tab'] = '0';

	// Define the option panel stylesheet. Options are 'standard', 'custom', and 'none'
	// If only minor tweaks are needed, set to 'custom' and override the necessary styles through the included custom.css stylesheet.
	// If replacing the stylesheet, set to 'none' and don't forget to enqueue another stylesheet!
	// Default: 'standard'
	//$args['admin_stylesheet'] = 'standard';

	// Setup custom links in the footer for share icons
	$args['share_icons']['twitter'] = array(
	    'link' => 'http://twitter.com/detheme',
	    'title' => 'Follow me on Twitter', 
	    'img' => DethemeReduxFramework::$_url . 'assets/img/social/Twitter.png'
	);
	$args['share_icons']['facebook'] = array(
	    'link' => 'https://www.facebook.com/detheme',
	    'title' => 'Find me on Facebook', 
	    'img' => DethemeReduxFramework::$_url . 'assets/img/social/Facebook.png'
	);

	// Enable the import/export feature.
	// Default: true
	$args['show_import_export'] = true;

	// Set the icon for the import/export tab.
	// If $args['icon_type'] = 'image', this should be the path to the icon.
	// If $args['icon_type'] = 'iconfont', this should be the icon name.
	// Default: refresh
	//$args['import_icon'] = 'refresh';

	// Set the class for the import/export tab icon.
	// This is ignored unless $args['icon_type'] = 'iconfont'
	// Default: null
	//$args['import_icon_class'] = '';

	/**
	 * Set default icon class for all sections and tabs
	 * @since 3.0.9
	 */
	//$args['default_icon_class'] = '';


	// Set a custom menu icon.
	//$args['menu_icon'] = '';

	// Set a custom title for the options page.
	// Default: Options
	$args['menu_title'] = __('Krypton Options', 'redux-framework');

	// Set a custom page title for the options page.
	// Default: Options
	$args['page_title'] = __('Options', 'redux-framework');

	// Set a custom page slug for options page (wp-admin/themes.php?page=***).
	// Default: redux_options
	$args['page_slug'] = 'redux_options';

	$args['default_show'] = true;
	$args['default_mark'] = '*';

	// Add HTML before the form.
	$args['intro_text'] = $args['menu_title'];


	$sections = array();              

	//Background Patterns Reader
	$sample_patterns_path = DethemeReduxFramework::$_dir . '../sample/patterns/';
	$sample_patterns_url  = DethemeReduxFramework::$_url . '../sample/patterns/';
	$sample_patterns      = array();

	if ( is_dir( $sample_patterns_path ) ) :
		
	  if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) :
	  	$sample_patterns = array();

	    while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

	      if( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
	      	$name = explode(".", $sample_patterns_file);
	      	$name = str_replace('.'.end($name), '', $sample_patterns_file);
	      	$sample_patterns[] = array( 'alt'=>$name,'img' => $sample_patterns_url . $sample_patterns_file );
	      }
	    }
	  endif;
	endif;

	$dt_theme_images  = substr_replace(DethemeReduxFramework::$_url,'images',strpos(DethemeReduxFramework::$_url,'redux-framework'));

	$sections[] = array(
		'title' => __('Homepage Settings', 'redux-framework'),
		'desc' => __('', 'redux-framework'),
		'icon' => 'el-icon-home',
		'fields' => array(	
			array(
				'id'=>'showmenu',
				'type' => 'switch', 
				'title' => __('Always Show Top Menu', 'redux-framework'),
				'subtitle'=> __('Always show top menu on homepage', 'redux-framework'),
				"default" 		=> 0,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				),	
			array(
				'id'=>'showslide',
				'type' => 'switch', 
				'title' => __('Slide Show', 'redux-framework'),
				'subtitle'=> __('Show main slide show on homepage', 'redux-framework'),
				"default" 		=> 1,
				'on' => 'Enabled',
				'off' => 'Disabled',
				),	
			array(
				'id'=>'homeslide',
				'type' => 'slides',
				'title' => __('Slides Options', 'redux-framework'),
				'subtitle'=> __('Unlimited slides with drag and drop sortings.', 'redux-framework'),
				'placeholder' => array(
					'title'=>"This is the title",
					'description'=>"Description here",
					'url'=>"Link",
					'label'=>"Button Label",
				),
				'desc' => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'redux-framework')
			)
			),
		);

	$sections[] = array(
		'icon' => 'el-icon-cogs',
		'title' => __('General Settings', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'layout',
				'type' => 'image_select',
				'compiler'=>true,
				'title' => __('Main Layout', 'redux-framework'), 
				'subtitle' => __('Select main content and sidebar alignment. Choose between 1, 2 or 3 column layout.', 'redux-framework'),
				'options' => array(
						'1' => array('alt' => '1 Column', 'img' => DethemeReduxFramework::$_url.'assets/img/1col.png'),
						'2' => array('alt' => '2 Column Left', 'img' => DethemeReduxFramework::$_url.'assets/img/2cl.png'),
						'3' => array('alt' => '2 Column Right', 'img' => DethemeReduxFramework::$_url.'assets/img/2cr.png')
					),
				'default' => '2'
				),
			array(
				'id'=>'dt-logo-image',
				'type' => 'media', 
				'title' => __('Desktop Logo', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set logo image.', 'redux-framework'),
				'subtitle' => __('Logo for desktop screen. Will be displayed half of its original size (retina)', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/krypton_logo.png'),
				),
			array(
				'id'=>'dt-mobile-logo-image',
				'type' => 'media', 
				'title' => __('Mobile Logo', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set logo image.', 'redux-framework'),
				'subtitle' => __('Logo for mobile screen. Will be displayed half of its original size (retina)', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/krypton_logo.png'),
				),
			array(
				'id'=>'dt-favicon-image',
				'type' => 'media', 
				'title' => __('Favicon Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set favicon image. Upload your image (.png,.ico, .jpg) with size 16x16 pixel', 'redux-framework'),
				'default'=>array('url'=>''),
				),
			array(
				'id'=>'dt-display-header',
				'type' => 'switch', 
				'title' => __('Display header ?', 'redux-framework'),
				'subtitle'=> __('If "On", the header will be displayed. If "Off", the header will be hidden', 'redux-framework'),
				"default" => 1,
				),	
			array(
				'id'=>'dt-banner-height',
				'type' => 'text',
				'title' => __('Banner Height', 'redux-framework'),
				'subtitle'=>__('Adjust the banner height (in pixel)','redux-framework'),
				'class'=>'width_100',
				'default' => '285px'
				),	
			array(
				'id'=>'dt-banner-image',
				'type' => 'media', 
				'title' => __('Default Header Banner Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set default banner image.', 'redux-framework'),
				'subtitle' => __('Upload any media using the WordPress native uploader', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/header_subpage_bg.jpg'),
				),
			array(
				'id'=>'dt-use-default-banner-single-page',
				'type' => 'switch', 
				'title' => __('Use Default Banner Image on Single Post/Page ?', 'redux-framework'),
				'subtitle'=> __('If "On", the below Default Single Page Banner Image will be displayed. If "Off" and the featured image is empty, No banner will be displayed', 'redux-framework'),
				"default" => 1,
				),	
			array(
				'id'=>'dt-banner-single-page',
				'type' => 'media', 
				'title' => __('Default Single Post/Page Banner Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set default banner image for single post/page.', 'redux-framework'),
				'subtitle' => __('Upload any media using the WordPress native uploader', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/banner_single_post.jpg'),
				),
			array(
				'id'=>'dt-content-top-margin',
				'type' => 'text',
				'title' => __('Content Top Margin', 'redux-framework'),
				'subtitle'=>__('Adjust the content top margin (in pixel)','redux-framework'),
				'class'=>'width_100',
				'default' => '80px'
				),	
			array(
				'id'=>'dt-select-modal-effects',
				'type' => 'select',
				'title' => __('Image Gallery Modal Effects Option', 'redux-framework'), 
				'subtitle' => __('', 'redux-framework'),
				'desc' => __('', 'redux-framework'),
				'options'=>array('md-effect-1'=>'Effect 1: Fade in and scale up',
					'md-effect-2'=>'Effect 2: Slide from the right',
					'md-effect-3'=>'Effect 3: Slide from the bottom',
					'md-effect-4'=>'Effect 4: Newspaper',
					'md-effect-5'=>'Effect 5: Fall',
					'md-effect-6'=>'Effect 6: Side fall',
					'md-effect-7'=>'Effect 7: Slide and stick to top',
					'md-effect-8'=>'Effect 8: 3D flip horizontal',
					'md-effect-9'=>'Effect 9: 3D flip vertical',
					'md-effect-10'=>'Effect 10: 3D sign',
					'md-effect-11'=>'Effect 11: Super scaled',
					'md-effect-12'=>'Effect 12: Just me',
					'md-effect-13'=>'Effect 13: 3D slit',
					'md-effect-14'=>'Effect 14: 3D Rotate from bottom',
					'md-effect-15'=>'Effect 15: 3D Rotate in from left (Default)',
					'md-effect-16'=>'Effect 16: Blur',
					'md-effect-17'=>'Effect 17: Slide in from bottom with perspective on container',
					'md-effect-18'=>'Effect 18: Slide from right with perspective on container',
					'md-effect-19'=>'Effect 19: Slip in from the top with perspective on container'),
				),
			array(
				'id'=>'showsearchmenu',
				'type' => 'switch', 
				'title' => __('Search Bar', 'redux-framework'),
				'subtitle'=> __('Search bar on main navigation', 'redux-framework'),
				"default" 		=> 1,
				'on' => __('Show', 'redux-framework'),
				'off' => __('Hide', 'redux-framework')
				),	
			array(
				'id'=>'dt-comment-open',
				'type' => 'switch', 
				'title' => __('Comment Post/Portfolio', 'redux-framework'),
				'subtitle'=> __('If "Off", comment disable for allpage as default ', 'redux-framework'),
				"default" => 1,
				),	
			array(
				'id'=>'dt-404-text',
				'type' => 'textarea',
				'title' => __('404 Error Text', 'redux-framework'), 
				'subtitle' => __('', 'redux-framework'),
				'default' => 'It\'s looking like you may have taken a wrong turn. Don\'t worry...it happens to the most of us.',
				'validate' => 'html'
				),
			array(
				'id'=>'dt-404-image',
				'type' => 'media', 
				'title' => __('404 Error Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set 404 Error Image.', 'redux-framework'),
				'subtitle' => __('Upload any media using the WordPress native uploader', 'redux-framework')
				),
			array(
				'id'=>'dt-contact-form-email',
				'type' => 'text',
				'title' => __('Contact Form Email Destination', 'redux-framework'),
				'subtitle' => __('', 'redux-framework'),
				'desc' => __('', 'redux-framework'),
				'validate' => 'email',
				'msg' => 'custom error message',
				'default' => 'test@test.com'
				)				
		)
	);

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

if (is_plugin_active('woocommerce/woocommerce.php')) {
	$sections[] = array(
		'icon' => 'el-icon-shopping-cart',
		'title' => __('Shop Settings', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'dt-shop-banner-image',
				'type' => 'media', 
				'title' => __('Default Shop Banner Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set default shop banner image.', 'redux-framework'),
				'subtitle' => __('Upload any media using the WordPress native uploader', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/banner_detail_product.jpg'),
				),
			array(
				'id'=>'show-shop-slide',
				'type' => 'switch', 
				'title' => __('Shop Slideshow', 'redux-framework'),
				'subtitle'=> __('Slide show on shop page or other.<br/>To embed shop slideshow on regular page put the shortcode [shopslider]', 'redux-framework'),
				"default" 		=> 0,
				'on' => __('Yes', 'redux-framework'),
				'off' => __('No', 'redux-framework')
				),	
			array(
				'id'=>'shopslide',
				'type' => 'shopslides',
				'title' => __('Slides Options', 'redux-framework'),
				'subtitle'=> __('Unlimited slides with drag and drop sortings.', 'redux-framework'),
				'placeholder' => array(
					'title'=>"This is the title",
					'description'=>"Description here",
					'url'=>"Link",
					'label'=>"Button Label",
				),
				'desc' => __('This field will store all slides values into a multidimensional array to use into a foreach loop.', 'redux-framework')
			),
			array(
				'id'=>'product-price-abbrevi',
				'type' => 'text', 
				'title' => __('Number Prefixes ( price )', 'redux-framework'),
				'subtitle'=> __('Product price will shorten using prefix.', 'redux-framework'),
				'placeholder'=>array(),
				'options' => array(
								'thousand'=>__('Thousands', 'redux-framework'),
							 	'million'=>__('Millions', 'redux-framework'),
							 	'billion'=>__('Billions', 'redux-framework'),
							 	'trillion'=>__('Trillions', 'redux-framework')
				),
				'default' => array(
								'thousand'=>__('K', 'redux-framework'),
							 	'million'=>__('M', 'redux-framework'),
							 	'billion'=>__('B', 'redux-framework'),
							 	'trillion'=>__('T', 'redux-framework')
				)
			)	
		)
	);
}


	$sections[] = array(
		'icon' => 'el-icon-map-marker',
		'title' => __('Map Settings', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'map-address',
				'type' => 'text',
				'title' => __('Address', 'redux-framework'), 
				'subtitle' => __('', 'redux-framework'),
				'default' => 'Jl. Pahlawan no. 10',
				),
			array(
				'id'=>'map-phone',
				'type' => 'text',
				'title' => __('Phone Number', 'redux-framework'), 
				'subtitle' => __('', 'redux-framework'),
				'default' => '+62 7457821',
				),
			array(
				'id'=>'map-email',
				'type' => 'text',
				'title' => __('Email', 'redux-framework'),
				'subtitle' => __('', 'redux-framework'),
				'desc' => __('', 'redux-framework'),
				'validate' => 'email',
				'msg' => 'please enter valid email address',
				'default' => 'support@detheme.com'
				),
			array(
				'id'=>'map-latitude',
				'type' => 'text',
				'title' => __('Google Map Latitude', 'redux-framework'),
				'subtitle' => __('This must be numeric.', 'redux-framework'),
				'desc' => __('', 'redux-framework'),
				'validate' => 'numeric',
				'default' => '0'
				),
			array(
				'id'=>'map-longitude',
				'type' => 'text',
				'title' => __('Google Map Longitude', 'redux-framework'),
				'subtitle' => __('This must be numeric.', 'redux-framework'),
				'desc' => __('', 'redux-framework'),
				'validate' => 'numeric',
				'default' => '0'
				),
			array(
				'id'=>'map-zoom-level',
				'type' => 'select',
				'title' => __('Google Map Zoom Level', 'redux-framework'), 
				'subtitle' => __('', 'redux-framework'),
				'desc' => __('', 'redux-framework'),
				'options' => array('3' => '3','4' => '4','5' => '5','6' => '6','7' => '7','8' => '8','9' => '9','10' => '10','11' => '11','12' => '12','13' => '13','14' => '14','15' => '15','16' => '16','17' => '17','18' => '18','19' => '19','20' => '20','21' => '21'),//Must provide key => value pairs for select options
				'default' => '15'
				),
			array(
				'id'=>'map-circle-number',
				'type' => 'text',
				'title' => __('Number (Circle)', 'redux-framework'), 
				'subtitle' => __('', 'redux-framework'),
				'default' => '27',
				),
			array(
				'id'=>'map-circle-address',
				'type' => 'text',
				'title' => __('Address (Circle)', 'redux-framework'), 
				'subtitle' => __('', 'redux-framework'),
				'default' => 'Jl. Pahlawan',
				),
			array(
				'id'=>'map-circle-city',
				'type' => 'text',
				'title' => __('City (Circle)', 'redux-framework'), 
				'subtitle' => __('', 'redux-framework'),
				'default' => 'Surabaya',
				),
			array(
				'id'=>'map-circle-zipcode',
				'type' => 'text',
				'title' => __('ZIP Code (Circle)', 'redux-framework'), 
				'subtitle' => __('', 'redux-framework'),
				'default' => '60217',
				),
			array(
				'id'=>'map-image',
				'type' => 'media', 
				'title' => __('Map Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set map background image.', 'redux-framework'),
				'subtitle' => __('Upload any media using the WordPress native uploader', 'redux-framework'),
				'default'=>array('url'=>$dt_theme_images.'/aerial_view.jpg'),
				)
		)
	);


	$sections[] = array(
		'icon' => 'el-icon-website',
		'title' => __('Styling Options', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'main-color',
				'type' => 'color_nocheck',
				'output' => array('.site-title'),
				'title' => __('Main Color', 'redux-framework'), 
				'subtitle' => __('Pick a background color for the theme (default: #1abc9c).', 'redux-framework'),
				'default' => '#1abc9c',
				'validate' => 'color',
				),		
			array(
				'id'=>'primary-font',
				'type' => 'typography',
				'title' => __('Primary Font', 'redux-framework'),
				'subtitle' => __('Specify the primary font properties.', 'redux-framework'),
				'font-style'=>false,
				'font-weight'=>false,
				'font-size'=>false,
				'color'=>false,
				'google'=>true,
				'line-height'=>false,
				'default' => array(
					'font-family'=>'Open Sans'
					),
				),
			array(
				'id'=>'secondary-font',
				'type' => 'typography',
				'title' => __('Secondary Font', 'redux-framework'),
				'subtitle' => __('Specify the secondary font properties.', 'redux-framework'),
				'font-style'=>false,
				'font-weight'=>false,
				'font-size'=>false,
				'color'=>false,
				'google'=>true,
				'line-height'=>false,
				'default' => array(
					'font-family'=>'Lora'
					),
				)
		)
	);

	$sections['footer'] = array(
		'title' => __('Footer', 'redux-framework'),
		'icon' => 'el-icon-fork',
		'fields' => array(
			array(
				'id'=>'showfooterarea',
				'type' => 'switch', 
				'title' => __('Footer', 'redux-framework'),
				'subtitle'=> __('Enable or Disable footer', 'redux-framework'),
				"default"=> 1,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')
				),	
			array(
				'id'=>'footer-text',
				'type' => 'editor',
				'title' => __('Footer Text', 'redux-framework'), 
				'subtitle' => __('You can use the following shortcodes in your footer text: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'redux-framework'),
				'default' => '© [current-year] DeTheme, The Awesome Theme. All right reserved.',
				),
			array(
				'id'=>'dt-background-footer',
				'type' => 'media', 
				'title' => __('Footer Background Image', 'redux-framework'),
				'compiler' => true,
				//'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
				'desc'=> __('Set Footer Background Image.', 'redux-framework'),
				'subtitle' => __('Upload any media using the WordPress native uploader', 'redux-framework')
				),
			array(
				'id'=>'showfooterpage',
				'type' => 'switch', 
				'title' => __('Post Footer', 'redux-framework'),
				'subtitle'=> __('Enable or Disable pre and post footer area', 'redux-framework'),
				"default"=> 1,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')
				),	
			array(
				'id'=>'postfooterpage',
				'type' => 'select',
				'title' => __('Post Footer Page', 'redux-framework'), 
				'subtitle'=>__('Select page for the post footer','redux-framework'),
				'data' => 'pages',
				'description'=>'<a class="btn button" href="'.admin_url( 'post-new.php?post_type=page', 'relative' ).'" target="_blank">'.__('Create New Page','redux-framework').'</a>',
			),
			)
		);

	$sections['advance'] = array(
		'icon' => 'el-icon-wrench-alt',
		'title' => __('Advanced Settings', 'redux-framework'),
		'desc' => __('', 'redux-framework'),
		'fields' => array(
			array(
				'id'=>'sandbox-mode',
				'type' => 'switch', 
				'title' => __('Development Mode', 'redux-framework'),
				'subtitle'=> __('Please activate this option during development stage', 'redux-framework'),
				'description'=>__('Few webhosts cached CSS file that causes Theme Option unresponsive','redux-framework'),
				"default"=> 0,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')
				),	
			array(
				'id'=>'disable_automatic_update',
				'type' => 'switch', 
				'title' => __('Automatic Update', 'redux-framework'),
				"default"=> 1,
				'on' => __('On', 'redux-framework'),
				'off' => __('Off', 'redux-framework')
				),	
			array(
				'id'=>'core_automatic_update',
				'type' => 'radio', 
				'title' => __('WP Core Automatic Update', 'redux-framework'),
				"default"=> 'false',
				'options'=>array(
					'true' => __('Enable', 'redux-framework'),
					'minor' => __('Minor Update Only', 'redux-framework'),
					'false' => __('Disable', 'redux-framework')
				)	
				),	
	        array(
				'id'=>'css-code',
				'type' => 'ace_editor',
				'title' => __('CSS Code', 'redux-framework'), 
				'subtitle' => __('Paste your CSS code here.', 'redux-framework'),
				'mode' => 'css',
	            'theme' => 'monokai',
				'desc' => 'Your css code will saving at /css/customstyle.css ',
	            'default' => "body{\nheight: 100%;\n}"
				),
	        array(
				'id'=>'js-code',
				'type' => 'ace_editor',
				'title' => __('JS Code', 'redux-framework'), 
				'subtitle' => __('Paste your JS code here. JS Code loaded on end of page', 'redux-framework'),
				'mode' => 'javascript',
	            'theme' => 'chrome',
				'desc' => 'Be careful!',
	            'default' => "jQuery(document).ready(function(){\n\n});"
				)
	        )
	);
		
	if (function_exists('wp_get_theme')){
	$theme_data = wp_get_theme();
	$theme_uri = $theme_data->get('ThemeURI');
	$description = $theme_data->get('Description');
	$author = $theme_data->get('Author');
	$version = $theme_data->get('Version');
	$tags = $theme_data->get('Tags');
	}else{
	$theme_data = wp_get_theme(trailingslashit(get_stylesheet_directory()).'style.css');
	$theme_uri = $theme_data['URI'];
	$description = $theme_data['Description'];
	$author = $theme_data['Author'];
	$version = $theme_data['Version'];
	$tags = $theme_data['Tags'];
	}	

	$theme_info = '<div class="redux-framework-section-desc">';
	$theme_info .= '<p class="redux-framework-theme-data description theme-uri">'.__('<strong>Theme URL:</strong> ', 'redux-framework').'<a href="'.$theme_uri.'" target="_blank">'.$theme_uri.'</a></p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-author">'.__('<strong>Author:</strong> ', 'redux-framework').$author.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-version">'.__('<strong>Version:</strong> ', 'redux-framework').$version.'</p>';
	$theme_info .= '<p class="redux-framework-theme-data description theme-description">'.$description.'</p>';
	if ( !empty( $tags ) ) {
		$theme_info .= '<p class="redux-framework-theme-data description theme-tags">'.__('<strong>Tags:</strong> ', 'redux-framework').implode(', ', $tags).'</p>';	
	}
	$theme_info .= '</div>';

	global $wp_filesystem;

	if(file_exists(dirname(__FILE__).'/README.md')){
	$sections['theme_docs'] = array(
				'icon' => DethemeReduxFramework::$_url.'assets/img/glyphicons/glyphicons_071_book.png',
				'title' => __('Documentation', 'redux-framework'),
				'fields' => array(
					array(
						'id'=>'17',
						'type' => 'raw',
						'content' => $wp_filesystem->get_contents(dirname(__FILE__).'/README.md')
						),				
				),
				
				);
	}//if

	$sections[] = array(
		'icon' => 'el-icon-info-sign',
		'title' => __('Theme Information & Update', 'redux-framework'),
		'desc' => __('<p class="description">The Awesome Wordpress Theme by detheme</p>', 'redux-framework'),
		'fields' => array(
			array(
				'title' => __('Purchase Number', 'redux-framework'),
				'id'=>'detheme_license',
				'type' => 'text',
				'content' => '',
				'desc' => __('Purchase number from themeforest.net. ex: 24c0d3f0-65e6-48b4-c642-548b04ea1d0c', 'redux-framework'),
				),
			array(
				'id'=>'raw_new_info',
				'type' => 'raw',
				'content' => $item_info,
				),
			),   
		);


	if(file_exists(trailingslashit(dirname(__FILE__)) . 'README.html')) {
	    $tabs['docs'] = array(
			'icon' => 'el-icon-book',
			    'title' => __('Documentation', 'redux-framework'),
	        'content' => nl2br($wp_filesystem->get_contents(trailingslashit(dirname(__FILE__)) . 'README.html'))
	    );
	}

	global $DethemeReduxFramework;
	$DethemeReduxFramework = new DethemeReduxFramework();
	$DethemeReduxFramework->__render($sections, $args, $tabs);

	// END Sample Config
	}
	add_filter('theme_option_name','billio_redux_option_name');
	add_action('init', 'detheme_redux_init');
endif;


function billio_redux_option_name($option_name){
	return "krypton_config";
}

if(!function_exists('darken')){
function darken($colourstr, $procent=0) {
  $colourstr = str_replace('#','',$colourstr);
  $rhex = substr($colourstr,0,2);
  $ghex = substr($colourstr,2,2);
  $bhex = substr($colourstr,4,2);

  $r = hexdec($rhex);
  $g = hexdec($ghex);
  $b = hexdec($bhex);

  $r = max(0,min(255,$r - ($r*$procent/100)));
  $g = max(0,min(255,$g - ($g*$procent/100)));  
  $b = max(0,min(255,$b - ($b*$procent/100)));

  return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
}
}

if(!function_exists('lighten')){
function lighten($colourstr, $procent=0){

  $colourstr = str_replace('#','',$colourstr);
  $rhex = substr($colourstr,0,2);
  $ghex = substr($colourstr,2,2);
  $bhex = substr($colourstr,4,2);

  $r = hexdec($rhex);
  $g = hexdec($ghex);
  $b = hexdec($bhex);

  $r = max(0,min(255,$r + ($r*$procent/100)));
  $g = max(0,min(255,$g + ($g*$procent/100)));  
  $b = max(0,min(255,$b + ($b*$procent/100)));

  return '#'.str_repeat("0", 2-strlen(dechex($r))).dechex($r).str_repeat("0", 2-strlen(dechex($g))).dechex($g).str_repeat("0", 2-strlen(dechex($b))).dechex($b);
}
}


function krypton_style_compile($krypton_option=array(),$css=""){

	if(function_exists('icl_register_string')){
		icl_register_string('detheme', 'footer-text', $krypton_option['footer-text']);
	}


	$main_color=$krypton_option['main-color'];
	$cssline=('#1abc9c'!==$main_color)?get_redux_custom_style($main_color):"";

	$primary_font = $krypton_option['primary-font']['font-family'];

	$cssline.=('Open Sans'!==$primary_font && !empty($primary_font))?get_redux_custom_primary_font($primary_font):"";

	$secondary_font = $krypton_option['secondary-font']['font-family']; 
	$cssline.=('Lora'!==$secondary_font && !empty($secondary_font))?get_redux_custom_secondary_font($secondary_font):"";

	$cssline.=(isset($krypton_option['css-code']) && !empty($krypton_option['css-code']))?"\n/* custom css generate from your custom css code*/\n".$krypton_option['css-code']:"";


	$filename = get_template_directory() . '/css/customstyle.css';
	$notes="/* ================================================ */\n"
				."/* don't touch this style auto generating by system */\n"
				."/* ================================================ */\n";



	if(file_exists($filename) && is_file($filename) && $file = @fopen($filename,"w")){

			if(@fwrite($file,$notes.$cssline)){

			}else{
				$cssline="";
			}

			@fclose($file);

		return $css.$cssline;

	}
	else
	{


		if($file = @fopen($filename,"w")){
			@fwrite($file,$notes.$cssline);
			@fclose($file);

		}
		else{

			$cssline="";
		}

		return $css;
	}

}


function get_redux_custom_style($color='') {

	if(empty($color) && ''!==$color)
		return '';

	ob_start();

	$mainColor=$color;

    @list($r, $g, $b) = sscanf($mainColor, "#%02x%02x%02x");
    $rgbcolor=$r.','.$g.','.$b;
 ?>
 .cn_item:hover {
  background-color: #1abc9c; /* done */
  color: #ffffff;
  -webkit-box-shadow: 0 4px 0 #17a689;
  box-shadow: 0 4px 0 #17a689;
}
/* main color */

	.dt-iconboxes-2:hover .dt-section-icon i.hi-icon,
	.dt-iconboxes-4:hover .dt-section-icon,
	.section-head hr:after,
	.pricing-table .price-4-col .btn-active,.pricing-table .price-3-col .btn-active,
	.pricing-table .featured li.plan-head,
	.blog-single-post .section-comment #dt-comment-form .btn-active,
	body.error404,
	.custom-accordion .panel-heading:hover .btn-accordion,
	.custom-accordion .panel-heading .btn-accordion:hover,
	.bottom_section .dt_widget_featured_posts .featured-row .featured-blog-meta,
	.bottom_section .dt_widget_tabs .nav-tabs a,
	.bottom_section .dt_widget_tabs .nav-tabs,
	.bottom_section .widget_search input[type='submit'] ,
	.bottom_section .widget_product_search input[type='submit'] ,
	.sidebar .widget_search input[type='submit'],
	#commentform #submit,
	.dt-iconboxes-2:hover i,
	.pricing-table .price-4-col ul li.plan-head, .pricing-table .price-3-col ul li.plan-head,
	#featured-filter li.active, #featured-filter li:hover,
	.dt_widget_carousel_recent_posts .owl-controls .owl-page.active span,
	.dt_widget_carousel_recent_posts .owl-controls .owl-page span:hover,
	.md-modal .md-content,.sequence-sub-slider a.button-more:hover,
	.select.select-theme-default .select-options .select-option:hover,
	.select.select-theme-default .select-options .select-option.select-option-highlight,
	.spinner-css .side > .fill,
	.woocommerce nav.woocommerce-pagination ul li span.current, 
	.woocommerce nav.woocommerce-pagination ul li a:hover,
	.dt-category-view .add-to-cart.btn-active, 
	.single-product .detail-product-price,
	.woocommerce .social-share .btn-group a i:hover:before, 
	.woocommerce .woocommerce-message:before, 
	.woocommerce-page .woocommerce-message:before,
	.woocommerce .woocommerce-error:before, 
	.woocommerce-page .woocommerce-error:before,
	.woocommerce .woocommerce-info:before, 
	.woocommerce-page .woocommerce-info:before, 
	.sidebar .widget_product_search input[type='submit'], 
	.woocommerce .widget_price_filter .ui-slider .ui-slider-range, 
	.woocommerce-page .widget_price_filter .ui-slider .ui-slider-range, 
	.chosen-container .chosen-results li.highlighted 
	{ background-color: <?php print $mainColor;?>!important;}


.woocommerce .widget_layered_nav ul li.chosen a, 
.woocommerce-page .widget_layered_nav ul li.chosen a, 
.woocommerce .widget_layered_nav_filters ul li.chosen a, 
.woocommerce-page .widget_layered_nav_filters ul li.chosen a 
{
  background-color: <?php print $mainColor;?>!important;
  border: 1px solid <?php print $mainColor;?>!important;
}

blockquote,
.dt-iconboxes.layout-3 span,
#featured-filter li.active, #featured-filter li:hover,
.form-control:focus,
.select-target.select-theme-default.select-target-focused,
.select-target.select-theme-default.select-target-focused:focus,
.woocommerce .order-review,
.woocommerce form input.input-text:focus, 
.woocommerce-page form input.input-text:focus
{  border-color: <?php print $mainColor;?>!important;}


.chosen-container-active .chosen-single,
.woocommerce-checkout .form-row .chosen-container .chosen-drop, 
.chosen-container-active.chosen-with-drop .chosen-single, 
.chosen-container .chosen-results li.active-result {
  border-color: <?php print $mainColor;?>!important;
  color: <?php print $mainColor;?>!important;
}

.form-control:focus {
	box-shadow: <?php print $mainColor;?>;
}

.dt-iconboxes.layout-3 span:before,
.dt-iconboxes-4:hover .dt-section-icon:after,.dt-iconboxes-4:hover .dt-section-icon:before,
.dt-iconboxes span:hover:after, 
.dt-iconboxes span:hover:before 
{border-top-color: <?php print $mainColor;?> !important;}

.dt-iconboxes span:hover,
.module_dt_promotion .thumbnail-description-text:hover p:first-child:after
{  background-color: <?php print $mainColor;?>;  border-color: <?php print $mainColor;?>;}
.dt-iconboxes.layout-3 span:hover {  background-color: <?php print $mainColor;?>;  border-color:<?php print $mainColor;?>;}
.dt-iconboxes.layout-3 span:hover:after,.dt-iconboxes.layout-3 span:hover:before {  border-top-color: <?php print $mainColor;?>;}

.no-touch .dt-iconboxes-5:hover .hi-icon-effect-5 .hi-icon {
  background-color: <?php print $mainColor;?>;
  border-color: <?php print $mainColor;?>;
}

.paging-nav .btn-arrow:hover {  background-color: <?php print $mainColor;?>;
  -webkit-box-shadow-color: <?php print $mainColor;?>;
  box-shadow-color: <?php print $mainColor;?>;
}
	a {color: <?php print $mainColor;?>;}
	a:hover, a:focus {color: <?php print $mainColor;?>;}
	.sidebar a:hover,
	.sidebar .widget.widget_categories .cat-item a:hover,
	.blog-single-post .share-button .btn:hover i,.blog-single-post .share-button .btn-default:hover i,
	.custom-accordion .panel-heading:hover h4,
	.contact-form-section .form-control:focus,
	.dt-iconboxes-4:hover .dt-section-icon i:hover,
	.breadcrumbs,
	.paging-nav a.btn-arrow,
	.dt-counter,
	.sidebar .widget_recent_entries ul li span,
	.sidebar .widget_recent_comments ul li a,
	.blog-post-teaser-text a,
	.meta-info a,
	.breadcrumbs a,
	.footer-section .description a,
	.footer-section .nav-pills a:hover,
	.bottom_section .dt_widget_tabs .tab-content .meta-info,
	.author,
	.widget_recent_comments ul li a,
	.tagcloud a,
	.paging-text a,
	.comment_item small a,
	.sidebar .widget_categories ul li.cat-item ul.children li.cat-item:hover a,
	body .sidebar .widget_categories ul li.cat-item:hover a,
	.sidebar .widget_archive ul li:hover, .sidebar .widget_archive ul li:hover:before, .sidebar .widget_archive ul li:hover a,
	.sidebar .widget_categories ul li.cat-item:hover, .sidebar .widget_categories ul li.cat-item:hover:before,
	.sidebar .widget_recent_entries ul li:hover, .sidebar .widget_recent_entries ul li:hover:before, .sidebar .widget_recent_entries ul li:hover a,
	.dt-iconboxes.layout-3 span,#mynavbar .current-menu-item > a,#mynavbar .menu-item:hover > a,#mynavbar .current-menu-item > ul > a,#mynavbar .navbar-nav > li.current-menu-parent > a,#mynavbar .navbar-nav li ul.dropdown-menu li.current-menu-item a,
	.navbar-nav li ul.dropdown-menu li a:hover,
	.dt-testimonial .client-profile h4,
	.profile_team .profile .profile-subheading,
	.dt_widget_tabs .tab-content p.comment,
	.paging-inline a,
	body .sidebar .widget_recent_comments ul li:hover:before, 
	body .sidebar .widget_recent_comments ul li:hover a.url,
	body .sidebar .widget_categories ul li.cat-item:hover, 
	body .sidebar .widget_categories ul li.cat-item:hover:before, 
	body .sidebar .widget_categories ul li.cat-item ul.children li.cat-item:hover, 
	body .sidebar .widget_categories ul li.cat-item ul.children li.cat-item:hover a,
	body .sidebar .widget_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover a,
	body .sidebar .widget_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover,
	.widget_archive a:hover,
	.map-info .icon-container,
	.bottom_section .widget_recent_entries ul li span,
	.bottom_section .widget_recent_entries ul li:hover, 
	.bottom_section .widget_recent_entries ul li:hover:before, 
	.bottom_section .widget_recent_entries ul li:hover a,
	.profile_team .profile ul.profile-scocial li a:hover,
	.bottom_section .widget_archive ul li:hover, 
	.bottom_section .widget_archive ul li:hover:before, 
	.bottom_section .widget_archive ul li:hover a,
	.no-touch .dt-iconboxes-4:hover .hi-icon-effect-5 .hi-icon,
	.footer-section .nav-pills a.active, .footer-section .nav-pills .current-menu-item a, 
	.bottom_section .widget_categories ul li.cat-item:hover,
	.bottom_section .widget_categories ul li.cat-item:hover:before, 
	.bottom_section .widget_categories ul li.cat-item:hover a,
	.bottom_section .widget_categories ul li.cat-item ul.children li.cat-item:hover,
	.bottom_section .widget_categories ul li.cat-item ul.children li.cat-item:hover a,
	.bottom_section .widget_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover,
	.bottom_section .widget_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover a,
	.social [class*='icon']:hover,.woocommerce div.product .stock, 
	.woocommerce #content div.product .stock,.woocommerce-page div.product .stock, 
	.woocommerce-page #content div.product .stock, 
	.woocommerce-page .woocommerce-breadcrumb a, 
	.woocommerce .woocommerce-breadcrumb a,  
	.woocommerce-breadcrumb a,.woocommerce .woocommerce-message, 
	.woocommerce-page .woocommerce-message,.woocommerce .woocommerce-error, 
	.woocommerce-page .woocommerce-error,.woocommerce .woocommerce-info, 
	.woocommerce-page .woocommerce-info, .woocommerce .cart-collaterals .cart_totals table td, 
	.woocommerce-page .cart-collaterals .cart_totals table td,
	.woocommerce input[name="coupon_code"]:focus,
	.woocommerce table.shop_table td a:hover, 
	.woocommerce-page table.shop_table td a:hover, 
	.woocommerce input[name="calc_shipping_postcode"]:focus,
	.woocommerce table.shop_table td.product-subtotal, 
	.woocommerce-page table.shop_table td.product-subtotal,
	.woocommerce form input.input-text:focus, 
	.woocommerce-page form input.input-text:focus,.cart-click .icon-shop,
	.cart_list .popup-quality,.cart_list .mini-cart-price,.cart_list .subtotal-price, 
	div.woocommerce table.order_details a, 
	div.woocommerce table.order_details a,.bottom_section .dt_widget_carousel_recent_posts a.post-title:hover,
	.shop-bottom .list-item:hover a,
	.sidebar .widget .product-price,
	.bottom_section .woocommerce.widget_products .product-title a:hover,
	.bottom_section .woocommerce.widget_top_rated_products .product-title a:hover,
	.shop-bottom .product-price ins,
	.bottom_section .woocommerce.widget_products .product-price,
	.bottom_section .woocommerce.widget_top_rated_products .product-price, 
	.bottom_section .widget.widget_product_tag_cloud .tagcloud .tag a:hover,  
	.shop-bottom .widget_product_tag_cloud .tagcloud .tag a:hover, 
	.sidebar .widget.widget_product_tag_cloud .tag a:hover, 
	.bottom_section .widget_product_categories ul li.cat-item:hover,
	.bottom_section .widget_product_categories ul li.cat-item:hover:before, 
	.bottom_section .widget_product_categories ul li.cat-item:hover a, 
	.bottom_section .widget_product_categories ul li.cat-item ul.children li.cat-item:hover,
	.bottom_section .widget_product_categories ul li.cat-item ul.children li.cat-item:hover a, 
	.bottom_section .widget_product_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover,
	.bottom_section .widget_product_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover a, 
	.sidebar .widget_product_categories .cat-item a:hover, 
	.sidebar .widget_product_categories ul li.cat-item:hover,
	.sidebar .widget_product_categories ul li.cat-item:hover:before, 
	.sidebar .widget_product_categories ul li.cat-item:hover a, 
	.sidebar .widget_product_categories ul li.cat-item ul.children li.cat-item:hover,
	.sidebar .widget_product_categories ul li.cat-item ul.children li.cat-item:hover a, 
	.sidebar .widget_product_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover,
	.sidebar .widget_product_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover a, 
	.shop-bottom .widget_product_categories .cat-item a:hover, 
	.shop-bottom .widget_product_categories ul li.cat-item:hover,
	.shop-bottom .widget_product_categories ul li.cat-item:hover:before, 
	.shop-bottom .widget_product_categories ul li.cat-item:hover a, 
	.shop-bottom .widget_product_categories ul li.cat-item ul.children li.cat-item:hover,
	.shop-bottom .widget_product_categories ul li.cat-item ul.children li.cat-item:hover a, 
	.shop-bottom .widget_product_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover,
	.shop-bottom .widget_product_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover a, 
	.shop-bottom .widget_recent_reviews ul.product_list_widget li a:hover, 
	.shop-bottom .widget_archive ul li:hover,
	.shop-bottom .widget_archive ul li:hover:before, 
	.shop-bottom .widget_archive ul li:hover a, 
	.shop-bottom .widget.widget_categories .cat-item a:hover,
	.shop-bottom .widget_categories ul li.cat-item:hover,
	.shop-bottom .widget_categories ul li.cat-item:hover:before, 
	.shop-bottom .widget_categories ul li.cat-item:hover a, 
	.shop-bottom .widget_categories ul li.cat-item ul.children li.cat-item:hover,
	.shop-bottom .widget_categories ul li.cat-item ul.children li.cat-item:hover a, 
	.shop-bottom .widget_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover,
	.shop-bottom .widget_categories ul li.cat-item ul.children li.cat-item ul.children li.cat-item:hover a, 
	.shop-bottom .widget_recent_comments ul li a, 
	.shop-bottom .widget_recent_comments ul li:hover:before, 
	.shop-bottom .widget_recent_comments ul li:hover a.url,
	.shop-bottom .widget_recent_entries ul li span, 
	.shop-bottom .widget_recent_entries ul li:hover,
	.shop-bottom .widget_recent_entries ul li:hover:before, 
	.shop-bottom .widget_recent_entries ul li:hover a, 
	.shop-bottom .widget_tag_cloud .tagcloud .tag a:hover,
	.shop-bottom .dt_widget_tabs .nav-tabs a:hover,
	.shop-bottom .dt_widget_tabs .tab-content .widget-post-title:hover,
	.module_dt_contact_form .form-control:focus, 
	.woocommerce .woocommerce-breadcrumb a
	{color: <?php print $mainColor;?> !important;}
	
	.blog-single-post .section-comment #dt-comment-form .form-control:focus,
	.woocommerce input[name="coupon_code"]:focus, 
	.woocommerce input[name="calc_shipping_postcode"]:focus
	{  border-color: <?php print $mainColor;?>;}

.dot {  background: <?php print $mainColor;?>;}
/* ---- */
.dt-iconboxes.layout-3 span:hover {color:#fff!important;}
.bottom_section .dt_widget_tabs .nav-tabs li.active a, .bottom_section .dt_widget_tabs .nav-tabs li:hover a {
	background-color: #0f161e!important
}

	.sidebar .widget_recent_entries ul li:hover span {color: #2a2929 !important;}
	.bottom_section .widget_recent_entries ul li:hover span {color: #fff !important;}
/* ---- */

#commentform #submit:hover {
  background-color: <?php print darken($mainColor,10);?> !important;
}
.owl-carousel-navigation .btn-owl:hover,.cn_item.selected,.btn-primary,
.paging-nav .btn-arrow:hover,.sequence-sub-slider a.button-more:hover,
.md-modal .md-close:hover,.module_dt_contact_form .btn-send,
.nav-slide a.btn:hover,
.ls-slide .btn-active a,
.cart_list .popup-bottom-info .popup-view-cart:hover
{
	-webkit-box-shadow:0 4px 0 <?php print darken($mainColor,25);?>!important;
	box-shadow:0 4px 0 <?php print darken($mainColor,25);?>!important;
	background-color: <?php print $mainColor;?>!important;
}

.woocommerce a.button, 
.woocommerce button.button, 
.woocommerce input.button, 
.woocommerce #respond input#submit, 
.woocommerce #content input.button, 
.woocommerce-page a.button, 
.woocommerce-page button.button, 
.woocommerce-page input.button, 
.woocommerce-page #respond input#submit, 
.woocommerce-page #content input.button,
.woocommerce a.button.alt, 
.woocommerce button.button.alt, 
.woocommerce input.button.alt, 
.woocommerce #respond input#submit.alt, 
.woocommerce #content input.button.alt, 
.woocommerce-page a.button.alt, 
.woocommerce-page button.button.alt, 
.woocommerce-page input.button.alt, 
.woocommerce-page #respond input#submit.alt, 
.woocommerce-page #content input.button.alt,
.dt-category-view .add-to-cart.btn-active,
.woocommerce .quantity .plus:hover, 
.woocommerce #content .quantity .plus:hover, 
.woocommerce-page .quantity .plus:hover, 
.woocommerce-page #content .quantity .plus:hover,
.woocommerce .quantity .minus:hover, 
.woocommerce #content .quantity .minus:hover, 
.woocommerce-page .quantity .minus:hover, 
.woocommerce-page #content .quantity .minus:hover,
.cart_list .popup-button-proceed,.cart_list .popup-view-cart:hover
.woocommerce-page #content .quantity .minus:hover, 
div.woocommerce .product .btn-active,
.cart_list .popup-bottom-info .popup-button-proceed, 
.shop-bottom .widget_product_search input[type='submit'], 
.shop-bottom .widget_search input[type='submit'],
.portfolio .btn-more:hover, 
.md-modal .md-content.form button.btn-submit
{
	background: none;
	-webkit-box-shadow:0 4px 0 <?php print darken($mainColor,25);?>;
	box-shadow:0 4px 0 <?php print darken($mainColor,25);?>;
	background-color: <?php print $mainColor;?>!important;
}

div.woocommerce .product add-to-cart.btn-active:active,
div.woocommerce .product .btn-active:active 
{
	background: none;
	-webkit-box-shadow:0 0 0 <?php print darken($mainColor,25);?>!important;
	box-shadow:0 0 0 <?php print darken($mainColor,25);?>!important;
	background-color: <?php print $mainColor;?>;
}

.woocommerce a.button:hover, 
.woocommerce button.button:hover, 
.woocommerce input.button:hover, 
.woocommerce #respond input#submit:hover, 
.woocommerce #content input.button:hover, 
.woocommerce-page a.button:hover, 
.woocommerce-page button.button:hover, 
.woocommerce-page input.button:hover, 
.woocommerce-page #respond input#submit:hover, 
.woocommerce-page #content input.button:hover,
.woocommerce a.button.alt:hover, 
.woocommerce button.button.alt:hover, 
.woocommerce input.button.alt:hover, 
.woocommerce #respond input#submit.alt:hover, 
.woocommerce #content input.button.alt:hover, 
.woocommerce-page a.button.alt:hover, 
.woocommerce-page button.button.alt:hover, 
.woocommerce-page input.button.alt:hover, 
.woocommerce-page #respond input#submit.alt:hover, 
.woocommerce-page #content input.button.alt:hover,
.dt-category-view .add-to-cart.btn-active:hover,
.woocommerce .cart-collaterals input.button[name="update_cart"]:hover, 
.cart_list .popup-button-proceed:hover
.woocommerce-page .cart-collaterals input.button[name="update_cart"]:hover, 
div.woocommerce .product .add-to-cart.btn-active:hover,
.cart_list .popup-bottom-info .popup-button-proceed:hover, 
.shop-bottom .widget_product_search input[type='submit']:hover, 
.shop-bottom .widget_search input[type='submit']:hover,
.md-modal .md-content.form button.btn-submit:hover
{
	background: none;
	-webkit-box-shadow:0 4px 0 <?php print darken($mainColor,35);?>!important;
	box-shadow:0 4px 0 <?php print darken($mainColor,35);?>!important;
	background-color: <?php print darken($mainColor,15);?>!important;
}

.woocommerce a.button:active, 
.woocommerce button.button:active, 
.woocommerce input.button:active, 
.woocommerce #respond input#submit:active, 
.woocommerce #content input.button:active, 
.woocommerce-page a.button:active, 
.woocommerce-page button.button:active, 
.woocommerce-page input.button:active, 
.woocommerce-page #respond input#submit:active, 
.woocommerce-page #content input.button:active,
.woocommerce a.button.alt:active, 
.woocommerce button.button.alt:active, 
.woocommerce input.button.alt:active, 
.woocommerce #respond input#submit.alt:active, 
.woocommerce #content input.button.alt:active, 
.woocommerce-page a.button.alt:active, 
.woocommerce-page button.button.alt:active, 
.woocommerce-page input.button.alt:active, 
.woocommerce-page #respond input#submit.alt:active, 
.woocommerce-page #content input.button.alt:active,
.dt-category-view .add-to-cart.btn-active:active,
.woocommerce .cart-collaterals input.button[name="update_cart"]:active, 
.cart_list .popup-button-proceed:active
.woocommerce-page .cart-collaterals input.button[name="update_cart"]:active, 
div.woocommerce .product .add-to-cart.btn-active:active, 
.shop-bottom .widget_product_search input[type='submit']:active,
.md-modal .md-content.form button.btn-submit:active,
.cart_list .popup-bottom-info .popup-button-proceed:active{
	background: none;
	-webkit-box-shadow:0 0 0 <?php print darken($mainColor,35);?>!important;
	box-shadow:0 0 0 <?php print darken($mainColor,35);?>!important;
	background-color: <?php print darken($mainColor,15);?>!important;
}
.cart_list .popup-bottom-info .popup-view-cart:active{
	background: none;
	-webkit-box-shadow:0 0 0 <?php print darken($mainColor,25);?>!important;
	box-shadow:0 0 0 <?php print darken($mainColor,25);?>!important;
	background-color: <?php print $mainColor;?>!important;
}
p.demo_store, 
.woocommerce .widget_price_filter .ui-slider .ui-slider-handle, 
.woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle {
	background: none;
	background-color: <?php print $mainColor;?>!important;
}


.sidebar .widget_search input[type='submit'], 
.bottom_section .widget_search input[type='submit'],
.bottom_section .widget_product_search input[type='submit'],
.custom-accordion .panel-heading .btn-accordion:hover,
.custom-accordion .panel-heading:hover .btn-accordion,
.pricing-table .price-4-col .btn-active,
.pricing-table .price-3-col .btn-active,
#commentform #submit,
.dt-category-view .add-to-cart.btn-active, 
.sidebar .widget_product_search input[type='submit'] 
{
	-webkit-box-shadow:0 4px 0 <?php print darken($mainColor,25);?>;
	box-shadow:0 4px 0 <?php print darken($mainColor,25);?>!important;
}
.sidebar .widget_search input[type='submit']:hover, 
.bottom_section .widget_search input[type='submit']:hover,
.bottom_section .widget_product_search input[type='submit']:hover,
.dt-iconboxes-4:hover,.module_dt_contact_form .btn-send:hover,.cn_item:hover,.btn-primary:hover,
.pricing-table .price-4-col .btn-active:hover,
.pricing-table .price-3-col .btn-active:hover,
.ls-slide .btn-active a:hover, 
.sidebar .widget_product_search input[type='submit']:hover
{
	-webkit-box-shadow:0 4px 0 <?php print darken($mainColor,35);?>!important;
	box-shadow:0 4px 0 <?php print darken($mainColor,35);?>!important;
	background-color: <?php print darken($mainColor,15);?>!important;
}

/*Active Button*/
.sidebar .widget_search input[type='submit']:active, 
.bottom_section .widget_search input[type='submit']:active,
.bottom_section .widget_product_search input[type='submit']:active,
.owl-carousel-navigation .btn-owl:active,
.custom-accordion .panel-heading .btn-accordion:active,
.paging-nav .btn-arrow:active,
.md-modal .md-close:active,
.nav-slide a.btn:active,
#commentform #submit:active,
.module_dt_contact_form .btn-send:active,
.pricing-table .price-4-col .btn-active:active,
.pricing-table .price-3-col .btn-active:active,
.ls-slide .btn-active a:active,
.btn-primary:active,
.cn_item.selected:active,
.cn_item:active, 
.sidebar .widget_product_search input[type='submit']:active
{
	box-shadow : none!important;
	-webkit-box-shadow : none!important;
}

.cart_list a.popup-view-cart:hover,.cart_list a.popup-button-proceed{color:#ffffff!important;}



.pricing-table .price-4-col ul li:nth-child(2n),
.pricing-table .price-3-col ul li:nth-child(2n) { background-color: <?php print lighten($mainColor,15);?>;}

.pricing-table .price-4-col ul,
.pricing-table .price-3-col ul { background-color: <?php print lighten($mainColor,25);?>;}

/*Transparency*/
.portfolio-module .portfolio-item .description,
.dt-featured-posts .description,
.map-image-area .map .circle-address section,
.map-image-area .map .map-info,
.portfolio .portfolio-item .description,
.dt-google-map-section .map .map-info, 
.dt-category-view .product-thumbnail .plus-detail a, 
.woocommerce .product-category .product-thumbnail .plus-detail a, 
div.woocommerce .product .product-thumbnail .plus-detail a
{background-color:rgba(<?php print $rgbcolor;?>, 0.6)!important;}

.paging-nav .paging-disabled .btn-arrow,.paging-nav .paging-disabled a.btn-arrow {
  background-color: #f4f4f4 !important;
  color: #dfdfdf !important;
  -webkit-box-shadow: 0 4px 0 #dfdfdf !important;
  box-shadow: 0 4px 0 #dfdfdf !important;

}

.paging-nav .paging-disabled a {
  color: #e1e1e1 !important; 
}

.paging-nav .paging-disabled .btn-arrow:hover {
  background-color: #f4f4f4 !important;
  color: #dfdfdf !important;
  -webkit-box-shadow: 0 4px 0 #dfdfdf !important;
  box-shadow: 0 4px 0 #dfdfdf !important;
}

.paging-nav .paging-disabled .btn-arrow:hover p,
.paging-nav .paging-disabled .btn-arrow:hover h1,
.paging-nav .paging-disabled .btn-arrow:hover h2,
.paging-nav .paging-disabled .btn-arrow:hover span,
.paging-nav .paging-disabled .btn-arrow:hover i {
  color: #dfdfdf !important;
}

.sidebar .widget_rss ul li a.rsswidget {
	color: <?php print $mainColor;?> !important;
}

.sidebar .widget_rss ul li a.rsswidget:hover {
	color: <?php print darken($mainColor,25);?> !important;
}

.bottom_section .widget_rss ul li a.rsswidget {
	color: <?php print $mainColor;?> !important;
}

.bottom_section .widget_rss ul li a.rsswidget:hover {
	color: <?php print lighten($mainColor,35);?> !important;
}

.sidebar .widget_pages a {
	color: <?php print $mainColor;?> !important;
}

.sidebar .widget_pages a:hover {
	color: <?php print darken($mainColor,25);?> !important;
}

.bottom_section .widget_pages a {
	color: <?php print $mainColor;?> !important;
}

.bottom_section .widget_pages a:hover {
	color: <?php print lighten($mainColor,35);?> !important;
}

.sidebar .widget_meta a {
	color: <?php print $mainColor;?> !important;
}

.sidebar .widget_meta a:hover {
	color: <?php print darken($mainColor,25);?> !important;
}

.bottom_section .widget_meta a {
	color: <?php print $mainColor;?> !important;
}

.sidebar .widget_nav_menu a:hover,
.sidebar .widget_calendar a:hover {
	color: <?php print darken($mainColor,25);?> !important;
}

.bottom_section .widget_meta a:hover, 
.bottom_section .widget_nav_menu a,
.bottom_section .widget_nav_menu a:hover,
.bottom_section .widget_calendar a:hover 
{
	color: <?php print lighten($mainColor,35);?> !important;
}

.sidebar .widget_nav_menu a,
.sidebar .widget_calendar a,
.bottom_section .widget_calendar a,
.module_dt_promotion .thumbnail-description-text:hover
 {
	color: <?php print $mainColor;?> !important;
}

.shop-bottom .list-item:hover img, 
.shop-bottom .widget_recent_reviews ul.product_list_widget li a:hover img {
  outline: 3px solid <?php print $mainColor;?>;
}

.dt-shop-category .thumbnail-container:hover .text-description {
  background-color: rgba(<?php print $rgbcolor;?>, 0.7);
}
<?php
	$cssline=ob_get_contents();
	ob_end_clean();



	return $cssline;

}

function get_redux_custom_primary_font($font_family='') {

	if(empty($font_family) && ''!==$font_family)
		return '';

	ob_start();
?>
	body,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	.h1,
	.h2,
	.h3,
	.h4,
	.h5,
	.h6, 
	.blog-single-post .section-comment #dt-comment-form .btn-active,
	.progress_bars_vertical .progress_number,
	.progress_bars_vertical .progress_title,
	.contact-form-section .btn-send,
	.contact-form-section label.error,
	.contact-form-blog .btn-send, 
	label.error, 
	.checkout-form-blog, 
	.checkout-form-blog .btn-send, 
	.order-review .table, 
	.order-review .payment_methods, 
	.view-cart-sidebar h3, 
	.view-cart-sidebar .table, 
	.view-cart-sidebar .table thead > tr > th, 
	.view-cart-table thead > tr > th, 
	#commentform #submit, 
	.sidebar .widget_recent_comments ul li a, 
	.sidebar .widget_recent_comments ul li a.url, 
	.bottom_section .widget_recent_comments ul li a, 
	.bottom_section .widget_recent_comments ul li a.url, 
	.module_dt_contact_form .btn-send, 
	.module_dt_contact_form label.error, 
	#sequence-shop, 
	#sequence
	{
	  font-family: <?php print $font_family;?>;
	}
<?php
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}

function get_redux_custom_secondary_font($font_family='') {

	if(empty($font_family) && ''!==$font_family)
		return '';

	ob_start();
?>
	blockquote, 
	.widget_rss .rss-date, 
	.blog-single-post .section-comment #dt-comment-form .form-control,
	.dt-shop-season .thumbnail-description-text .text-container p:nth-child(1), 
	.contact-form-section, 
	.contact-form-blog, 
	.dt-testimonial blockquote:before, 
	#recent-post date,
	#recent-post .date, 
	.profile_team .profile .profile-subheading, 
	#commentform .form-control, 
	.sidebar .widget_search input[type='text'], 
	.sidebar .widget_categories select, 
	.sidebar .widget_categories ul li ul.children li.cat-item a, 
	.sidebar .widget_archive select, 
	.sidebar .widget_recent_entries ul li span, 
	.sidebar .widget_recent_comments ul li, 
	.sidebar .dt_widget_carousel_recent_posts date,
	.sidebar .dt_widget_carousel_recent_posts .date, 
	.bottom_section .widget_search input[type='text'], 
	.bottom_section .widget_archive select,
	.bottom_section .widget_categories select, 
	.bottom_section .widget_categories ul li ul.children li.cat-item a, 
	.bottom_section .widget_recent_comments ul li, 
	.bottom_section .widget_recent_entries ul li span,
	.bottom_section .dt_widget_carousel_recent_posts date,
	.bottom_section .dt_widget_carousel_recent_posts .date,
	.module_dt_contact_form,
	.sidebar .widget_product_search input[type="text"],
	.bottom_section .widget_product_search input[type='text'],
	.shop-bottom .widget_product_search input[type='text'],
	.sidebar .widget_product_categories select, 
	.sidebar .widget_product_categories ul li ul.children li.cat-item a, 
	.shop-bottom .widget_product_categories select, 
	.shop-bottom .widget_product_categories ul li ul.children li.cat-item a, 
	.bottom_section .widget_product_categories select, 
	.bottom_section .widget_product_categories ul li ul.children li.cat-item a, 
	#sequence-twitter
	{
	  font-family: <?php print $font_family;?>;
	}
<?php
	$cssline=ob_get_contents();
	ob_end_clean();

	return $cssline;
}

add_action('redux-compiler-krypton_config','krypton_style_compile',2);

function detheme_save_license($config=array()){

	$template=get_template();
	update_option("detheme_license_$template",$config['detheme_license']);
}

add_action( 'redux-saved-krypton_config' ,'detheme_save_license' ); // REMOVE


function krypton_wpml_homeslide($config=array()){

	if(function_exists('icl_register_string') && isset($config['homeslide']) && count($config['homeslide']) 
	&& (!empty($config['homeslide'][0]['title']) || !empty($config['homeslide'][0]['description']) || !empty($config['homeslide'][0]['slidelabel']))
	){

		$slidedata=$config['homeslide'];

		foreach ($slidedata as $index => $slide) {

			if(isset($slide['title']) && $slide['title']!=''){
				icl_register_string('krypton', $slide['title'], $slide['title']);
			}

			if(isset($slide['description']) && $slide['description']!=''){
				icl_register_string('krypton', $slide['description'], $slide['description']);
			}

			if(isset($slide['slidelabel']) && $slide['slidelabel']!=''){
				icl_register_string('krypton', $slide['slidelabel'], $slide['slidelabel']);
			}
		}
	}

}

add_action( 'redux-saved-krypton_config' ,'krypton_wpml_homeslide' ); 

function krypton_wpml_shopslide($config=array()){

	if(function_exists('icl_register_string') && isset($config['shopslide']) && count($config['shopslide']) 
	&& (!empty($config['shopslide'][0]['title']) || !empty($config['shopslide'][0]['text_2']) || !empty($config['shopslide'][0]['text_3']) || !empty($config['shopslide'][0]['text_4']))
	){

		$slidedata=$config['shopslide'];

		foreach ($slidedata as $index => $slide) {

			if(isset($slide['title']) && $slide['title']!=''){
				icl_register_string('krypton', $slide['title'], $slide['title']);
			}

			if(isset($slide['text_2']) && $slide['text_2']!=''){
				icl_register_string('krypton', $slide['text_2'], $slide['text_2']);
			}

			if(isset($slide['text_3']) && $slide['text_3']!=''){
				icl_register_string('krypton', $slide['text_3'], $slide['text_3']);
			}

			if(isset($slide['text_4']) && $slide['text_4']!=''){
				icl_register_string('krypton', $slide['text_4'], $slide['text_4']);
			}

			if(isset($slide['slidelabel']) && $slide['slidelabel']!=''){
				icl_register_string('krypton', $slide['slidelabel'], $slide['slidelabel']);
			}
		}
	}

}

add_action( 'redux-saved-krypton_config' ,'krypton_wpml_shopslide' ); 

if(!function_exists('load_detheme_admin_script')){

	function load_detheme_admin_script(){
		wp_enqueue_script('detheme-admin-script', DethemeReduxFramework::$_url. 'assets/js/dashboard.js',array('jquery'));
	}
}

add_action( 'redux/page/krypton_config/enqueue','load_detheme_admin_script' );

?>