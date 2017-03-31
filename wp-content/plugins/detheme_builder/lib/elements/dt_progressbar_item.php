<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_progressbar_item extends DElement {

  function render($atts, $content = null, $base="")

  {


       wp_register_script('jquery.appear',get_dt_plugin_dir_url()."js/jquery.appear.js",array());
       wp_register_script('jquery.counto',get_dt_plugin_dir_url()."js/jquery.counto.js",array());
       wp_register_script('dt-chart',get_dt_plugin_dir_url()."js/chart.js",array('jquery.appear','jquery.counto'));
       wp_enqueue_script('dt-chart');

      
      extract( shortcode_atts( array(
          'title'=>'',
          'el_id' => '',
          'el_class'=>'',
      ), $atts ) );

      global $DEstyle;


      if (!isset($compile)) {$compile='';}

      extract(shortcode_atts(array(

          'icon_type' => '',
          'width' => '',
          'title' => '',
          'unit' => '',
          'color'=>'#1abc9c',
          'bg'=>'#ecf0f1',
          'label'=>'',
          'icon_color'=>'',
          'iconbg'=>'',
          'value' => '10',

      ), $atts, 'dt_progressbar_item'));



      $progress_bar='<div class=\'progress_bar\'>
                              <i class="'.$icon_type.'"></i>
                              <div class="progress_info">
                              <h4 class=\'progress_title\'>'.$title.'</h4>
                              <span class=\'progress_number\'><span>'.$value.'</span></span><span class="progres-unit">'.$unit.'</span>
                              </div><div class=\'progress_content_outer\'>
                                  <div data-percentage=\''.$value.'\' data-active="'.$color.'" data-nonactive="'.$bg.'" class=\'progress_content\'></div>
                             </div></div>';


      $css_class=array('progress_bars');

      if(''!=$el_class){
          array_push($css_class, $el_class);
      }

      if(''==$el_id){
          $el_id="dt_progress".getCssID().time().rand(11,99);
      }

      $css_style=getCssMargin($atts);

      $compile="<div ";
      if(''!=$el_id){
          $compile.="id=\"$el_id\" ";
      }

      $compile.="class=\"".@implode(" ",$css_class)."\">";
      if(""!=$css_style){
        $DEstyle[]="#$el_id {".$css_style."}";
      }

      if(""!=$label){
        $DEstyle[]="#$el_id .progress_info * {color:".$label."}";
      }

      if(""!=$icon_color){
        $DEstyle[]="#$el_id i:before,#$el_id i:after,#$el_id i {color:".$icon_color."}";
      }

      if(""!=$iconbg){
        $DEstyle[]="#$el_id i {background-color:".$iconbg."}";
      }

      $compile .= $progress_bar."</div>";

      return $compile;

  }
}

add_dt_element('dt_progressbar_item',
 array( 
    'title' => __( 'Progress Bar Item', 'detheme_builder' ),
    'icon'  =>'dashicons-chart-bar',
    'order'=>14,
    'options' => array(
        array( 
          'heading' => __( 'Extra css Class', 'detheme_builder' ),
          'param_name' => 'el_class',
          'type' => 'textfield',
          'value'=>"",
          ),
        array( 
          'heading' => __( 'Anchor ID', 'detheme_builder' ),
          'param_name' => 'el_id',
          'type' => 'textfield',
          "description" => __("Enter anchor ID without pound '#' sign", "detheme_builder"),
        ),
         array( 
          'heading' => __( 'Margin Top', 'detheme_builder' ),
          'param_name' => 'm_top',
          'param_holder_class'=>'m_top',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Margin Bottom', 'detheme_builder' ),
          'param_name' => 'm_bottom',
          'param_holder_class'=>'m_bottom',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Margin Left', 'detheme_builder' ),
          'param_name' => 'm_left',
          'param_holder_class'=>'m_left',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Margin Right', 'detheme_builder' ),
          'param_name' => 'm_right',
          'param_holder_class'=>'m_right',
          'type' => 'textfield',
        ),
        array(
        'heading' => __( 'Icon', 'detheme_builder' ),
        'param_name' => 'icon_type',
        'class' => '',
        'value'=>'',
        'description' => __( 'Select the icon to be displayed by clicking the icon.', 'detheme_builder' ),
        'type' => 'iconlists'
        ),
        array( 
        'heading' => __( 'Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label'=>true,
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Value', 'detheme_builder' ),
        'param_name' => 'value',
        'admin_label'=>true,
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Units', 'detheme_builder' ),
        'param_name' => 'unit',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Label Color', 'detheme_builder' ),
        'param_name' => 'label',
        'value' => '',
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => __( 'Icon Color', 'detheme_builder' ),
        'param_name' => 'icon_color',
        'value' => '',
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => __( 'Icon Background Color', 'detheme_builder' ),
        'param_name' => 'iconbg',
        'value' => '',
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => __( 'Bar Color', 'detheme_builder' ),
        'param_name' => 'color',
        'value' => '#90d5e5',
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => __( 'Bar Background Color', 'detheme_builder' ),
        'param_name' => 'bg',
        'value' => '',
        'type' => 'colorpicker'
         ),
    )

 ) );
?>