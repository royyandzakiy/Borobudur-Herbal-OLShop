<?php
defined('ABSPATH') or die();
/* 
 * Plugin Name: DT Page Builder
 * Plugin URI: http://djavaweb.com/detheme-builder
 * Description: Drag and Drop page layout in minute.
 * Version: 1.3.7
 * Author: Djavaweb
 * Author URI: http://djavaweb.com
 * Domain Path: /languages/
 * Text Domain: detheme_builder
 */

class detheme_Builder{

	private $editor = null;
	private $elements = array();

	function __construct() {


        define('DTPB_BASENAME',dirname(plugin_basename(__FILE__)));
        define('DTPB_DIR',plugin_dir_path(__FILE__));

        define('DTPB_INSTALLED',1);

        load_plugin_textdomain('detheme_builder', false, DTPB_BASENAME. '/languages/');

        if(!function_exists('is_plugin_active')){
      		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
      	}

		require_once ( DTPB_DIR.'lib/class-elements.php');
		require_once ( DTPB_DIR.'lib/helpers.php');
		require_once ( DTPB_DIR.'lib/default-elements.php');
		require_once ( DTPB_DIR.'lib/class-editor.php');

        /* deprecated */
        /* will remove latter */
        define('DTPB_DIR_URL',get_dt_plugin_dir_url()); 


		add_action('init', array($this,'init'));
	}

	public function init(){

		global $DElements,$DEstyle,$DEreveal;

		if(!is_object($DElements))
			$DElements=DElements::getInstance();

		$this->elements=$DElements;

		$elements=get_dt_elements();

		add_action('admin_init',array($this, 'get_builder'),999);
        add_action('wp_enqueue_scripts', array($this,'load_front_css_style' ));
		add_action('wp_footer',create_function('','global $DEstyle,$DEreveal;if(count($DEstyle)){print "\n<style type=\"text/css\">\n".@implode("\n",$DEstyle)."\n</style>\n";}'),99999);
		add_action('wp_head',array($this,'load_custom_css'),999);
	    add_action('admin_menu', array($this,'register_submenu_page'));
	    add_action( 'network_admin_menu', array( &$this, 'register_submenu_page' ) );
		add_filter('the_content',array($this,'removeWPautop'),12); // after do_shortcode
		add_action('webfonts-font-loaded',array($this,'load_webfont_front'));

	}

    function register_submenu_page(){

		if ( is_plugin_active_for_network('detheme_builder/detheme_builder.php') && is_network_admin() ) {

			add_submenu_page('settings.php', __( 'DT Page Builder', 'detheme_builder' ),
				__('DT Page Builder', 'detheme_builder'),
				'manage_options',
				'detheme_builder',
				array( $this, 'detheme_builder_setting_page' ) );
		} else {

			add_submenu_page('options-general.php', __( 'DT Page Builder', 'detheme_builder' ),
				__('DT Page Builder', 'detheme_builder'),
				'manage_options',
				'detheme_builder',
				array( $this, 'detheme_builder_setting_page' ) );
		}

    }

    function save_setting(){


    	if(wp_verify_nonce( isset($_POST['detheme_builder-setting'])?$_POST['detheme_builder-setting']:"", 'detheme_builder-setting')){

         	$builderposttype=(isset($_POST['builderposttype']))?$_POST['builderposttype']:'';
            update_option('detheme_builder_settings',$builderposttype);
	    }

    }

    function detheme_builder_setting_page(){

    $this->save_setting();


    $builder_settings=get_option('detheme_builder_settings',array('page'));
    if(empty($builder_settings)) $builder_settings=array();

    $args = array( 'page' => 'detheme_builder');

    $url = add_query_arg( $args, admin_url( 'options-general.php' ));

	$post_types = get_post_types( array() );
	$post_types_list = array();
	foreach ( $post_types as $post_type ) {
		if ( in_array($post_type,
			apply_filters('detheme_builder_post_type',array('revision','nav_menu_item','attachment','wpcf7_contact_form',
				'shop_coupon','shop_order','product_variation','shop_order_refund','shop_webhook'))))
			continue;

			$label = ucfirst( $post_type );
			$post_types_list[$post_type] = $label;
	}
?>
<div class="detheme_builder-panel">
<h2><?php printf(__('%s Settings', 'detheme_builder'),__( 'DT Page Builder', 'detheme_builder' ));?></h2>
<form method="post" action="<?php print $url;?>">
<?php wp_nonce_field( 'detheme_builder-setting','detheme_builder-setting');?>
<table class="form-table">
<tbody>
<tr>
<th scope="row"><label for="post-type"><?php _e('Post types','detheme_builder');?></label></th>
<td>
<?php foreach ($post_types_list as $post_type => $label) {?>
<input name="builderposttype[]" type="checkbox" value="<?php print $post_type;?>" <?php print in_array($post_type,$builder_settings)?"checked=\"checked\"":"";?> /> <?php print $label;?><br/>
<?php } ?>
</td>
</tr>
</tbody></table>


<p class="submit"><input name="submit" id="submit" class="button button-primary" value="<?php _e('Save Changes');?>" type="submit"></p></form>
</div>
<?php
    }


	function load_custom_css(){
		if ( ! is_singular() ) return;
		$page_id = get_the_ID();
		if ( $page_id ) {
			$custom_css = get_post_meta( $page_id, '_dtbuilder_custom_css', true );
			if ( ! empty( $custom_css ) ) {
				print "<style type=\"text/css\">\n";
				print $custom_css."\n";
				print "</style>\n";
			}
		}
	}
	
	function load_webfont_front(){

	  	wp_enqueue_style( 'fontello-font', get_dt_plugin_dir_url(). '/webicons/webfonts.css');
	}

    function load_front_css_style(){

        wp_register_style('webfonts-font',get_dt_plugin_dir_url()."webicons/webfonts.css");
        wp_register_style('detheme-builder',get_dt_plugin_dir_url()."css/plugin_style.css",array('webfonts-font'));

	    wp_enqueue_style('icon_picker-font',get_dt_plugin_dir_url()."lib/css/fontello.css");

        wp_register_style('scroll-spy',get_dt_plugin_dir_url()."css/scroll_spy.css",array('scroll-spy-ie'));
        wp_register_style( 'scroll-spy-ie', get_dt_plugin_dir_url(). '/css/scroll_spy_ie9.css', array());
        wp_register_style('owl.carousel',get_dt_plugin_dir_url()."css/owl_carousel.css",array());
        wp_style_add_data( 'scroll-spy-ie', 'conditional', 'IE 9' );


        wp_register_script( 'uilkit', get_dt_plugin_dir_url() . 'js/uilkit.js', array(), '1.0', true );
        wp_register_script('ScrollSpy',get_dt_plugin_dir_url()."js/scrollspy.js",array( 'uilkit' ), '1.0', true );
        wp_register_script( 'owl.carousel', get_dt_plugin_dir_url() . 'js/owl.carousel.js', array('jquery'), '1.3.3', false );


        wp_enqueue_style( 'detheme-builder');

        wp_enqueue_style('scroll-spy');
        wp_enqueue_script('ScrollSpy');

    }

	public function getElements(){

		return $this->elements;
	} 

	public function prepareElement(){

		
	} 

	public function get_builder(){

		$editor = new dt_Builder_Editor();
		$this->editor=$editor;
		$this->editor->render();
		add_action('wp_ajax_detheme_builder_setting',array($this,'get_module_builder'));
		add_action('wp_ajax_detheme_save_setting',array($this,'get_save_builder'));
		add_action('wp_ajax_detheme_add_shortcode',array($this,'get_add_shortcode'));
	}

	public function get_save_builder(){

		$tag=(isset($_POST['tag']) && ''!=$_POST['tag'])?$_POST['tag']:false;
		$shortcode_settings=(isset($_POST['shortcode']))?$_POST['shortcode']:"";

		$elements=get_dt_elements();

		if(!isset($elements[$tag]))
			die(0);



		$shortcode=$elements[$tag];
		$shortcode_string=$shortcode->getShortcodeString($shortcode_settings);

		$shortcode_tag=$shortcode->extractShortcodeString($shortcode_string);

		$output="<div class=\"shorcode_tag\">";
		$output.="[".$shortcode_tag[2].$shortcode_tag[3]."]";
		$output.="</div>";
		$output.="<div class=\"shorcode_content\">";
		$output.=$shortcode_tag[5];
		$output.="</div>";
		$output.="<div class=\"shorcode_preview\">";
		$output.=$shortcode->preview_admin();
		$output.="</div>";

		print $output;


		die();
	}

	public function get_add_shortcode(){

		$shortcode=(isset($_POST['shortcode']))?$_POST['shortcode']:"";
		$content=$shortcode;

		$elements=get_dt_elements();

		foreach ($elements as $tag => $element) {
	       $regexshortcodes=$element->getRegex();
	       $content= preg_replace_callback( '/' . $regexshortcodes . '/s',array( $element, 'do_shortcode_tag' ), $content );

	    }

	    if($content==$shortcode){
	      $content='[dt_text_html]'.$shortcode.'[/dt_text_html]';
	      foreach ($elements as $tag => $element) {
	         $regexshortcodes=$element->getRegex();
	         $content= preg_replace_callback( '/' . $regexshortcodes . '/s',array( $element, 'do_shortcode_tag' ), $content );
	      }

	    }
	    print $content;

		die();

	}

	public function get_module_builder(){

		$tag=(isset($_POST['tag']) && ''!=$_POST['tag'])?$_POST['tag']:false;
		$shortcode_string=(isset($_POST['shortcode']))?$_POST['shortcode']:"";

		$elements=get_dt_elements();

		if(!isset($elements[$tag]))
			die(0);

	
		$shortcode=$elements[$tag];

		$shortcode->setShortcodeString($shortcode_string);


		$shortcode->getSettingForm(true);
		die();

	}

	public function removeWPautop( $content) {

		if ( $content ) {

			$s = array(
				'/' . preg_quote( '</div>', '/' ) . '[\s\n\f]*' . preg_quote( '</p>', '/' ) . '/i',
				'/' . preg_quote( '<p>', '/' ) . '[\s\n\f]*' . preg_quote( '<div ', '/' ) . '/i',
				'/' . preg_quote( '<p>', '/' ) . '[\s\n\f]*' . preg_quote( '<section ', '/' ) . '/i',
				'/' . preg_quote( '</section>', '/' ) . '[\s\n\f]*' . preg_quote( '</p>', '/' ) . '/i'
			);
			$r = array( "</div>", "<div ", "<section ", "</section>" );
			$content = preg_replace( $s, $r, $content );


		}

		return $content;
	}
}

$buider= new detheme_Builder();