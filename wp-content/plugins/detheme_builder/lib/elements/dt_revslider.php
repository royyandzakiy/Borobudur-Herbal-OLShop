<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

if ( is_plugin_active( 'revslider/revslider.php' ) ) {

add_action('init','revslider_element');   

function revslider_element(){

  global $wpdb;
  

  $query="SELECT id, title, alias FROM " . $wpdb->prefix . "revslider_sliders ORDER BY id ASC LIMIT 999";

  $results = $wpdb->get_results($query);


  $slides = array();
  if ( $results ) {
    foreach ( $results as $slider ) {

      $slides[$slider->title] = $slider->alias;
    }
  } else {
    $slides[__( 'No sliders found', 'detheme_builder' )] = 0;
  }

  add_dt_element('rev_slider_shortcode', 
    array(
      'title' => __( 'Revolution Slider', 'detheme_builder' ),
      'description' => __( 'Place Revolution slider', 'detheme_builder' ),
      "options" => array(
        array(
          'type' => 'textfield',
          'heading' => __( 'Widget title', 'detheme_builder' ),
          'admin_label' => true,
          'param_name' => 'title',
          'description' => __( 'Enter text which will be used as widget title. Leave blank if no title is needed.', 'detheme_builder' )
        ),
        array(
          'type' => 'dropdown',
          'heading' => __( 'Revolution Slider', 'detheme_builder' ),
          'param_name' => 'alias',
          'value' => $slides,
          'description' => __( 'Select your Revolution Slider.', 'detheme_builder' )
        ),
        array(
          'type' => 'textfield',
          'heading' => __( 'Extra class name', 'detheme_builder' ),
          'param_name' => 'el_class',
          'description' => __( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'detheme_builder' )
        )
      )
    ) 
  );


  function rev_slider_render_shortcode($output,$content,$atts){

    extract( shortcode_atts( array(
      'alias' => '',
      'title'=>'',
      'el_class'=>''
    ), $atts ,'rev_slider'));

    $output="<div class=\"rev_slider_wrapper".(''!=$el_class?" ".$el_class:"")."\">";
    $output.=do_shortcode("[rev_slider ".$alias."]");
    $output.="</div>";

    return $output;
  }


  function rev_slider_preview_shortcode($output,$content,$atts){

    extract( shortcode_atts( array(
      'alias' => '',
      'title'=>'',
      'el_class'=>''
    ), $atts , 'rev_slider'));

    $output=__( 'Revolution Slider', 'detheme_builder' )."<br/>";
    $output.=__( 'Slide', 'detheme_builder' )." :".$alias;

    return $output;
  }

  add_dt_element_render('rev_slider_shortcode','rev_slider_render_shortcode');
  add_dt_element_preview('rev_slider_shortcode','rev_slider_preview_shortcode');

} 
}

?>
