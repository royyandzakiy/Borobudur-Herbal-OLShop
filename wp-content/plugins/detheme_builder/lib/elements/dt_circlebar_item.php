<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_circlebar_item extends DElement {

  function render($atts, $content = null, $base=""){

      wp_register_script('jquery.appear',get_dt_plugin_dir_url()."js/jquery.appear.js",array());
      wp_register_script('jquery.counto',get_dt_plugin_dir_url()."js/jquery.counto.js",array());
      wp_register_script('dt-chart',get_dt_plugin_dir_url()."js/chart.js",array('jquery.appear','jquery.counto'));


      wp_enqueue_script('dt-chart');

      if (!isset($compile)) {$compile='';}



      extract(shortcode_atts(array(
          'unit' => '',
          'title' => '',
          'item_number'=>'1',
          'value' => '10',
          'size'=>'',
          'color'=>'#19bd9b',
          'bg'=>'',
          'el_id'=>'',
          'el_class'=>'',
          'label_color'=>'',
          'unit_color'=>''

      ), $atts ,'dt_circlebar_item'));

       global $DEstyle;

   
      $css_style=getCssMargin($atts);

      if(''==$el_id){
          $el_id="circlebar".getCssID();
      }

      $compile="<div ";
      if(''!=$el_id){
          $compile.="id=\"$el_id\" ";
      }

      $compile.=(''!=$el_class)?"class=\"".$el_class."\"":"";
      $compile.=">";

      if(""!=$css_style){
        $DEstyle[]="#$el_id {".$css_style."}";
      }
   
      if(""!=$label_color){
        $DEstyle[]="#$el_id .pie-title {color:".$label_color."}";
      }

      if(""!=$unit_color){
        $DEstyle[]="#$el_id .tocounter,#$el_id .tocounter-unit {color:".$unit_color."}";
      }

      $compile.='<div class="dt_circlebar">
                      <div class=\'pie_chart_holder normal\'>
                              <canvas class="doughnutChart" data-noactive="'.$bg.'" data-size="'.$size.'" data-unit="'.$unit.'" data-active="'.$color.'" data-percent=\''.$value.'\'></canvas>
                      </div>
                      <h4 class="pie-title">'.$title.'</h4>
                      <div class="pie-description"></div>
                  </div></div>';

      return $compile;



  }

}

add_dt_element('dt_circlebar_item',
 array( 
    'title' => __( 'Circle Bar', 'detheme_builder' ),
    'icon'=>'dashicons-marker',
    'show_on_create' => true,
    'order'=>15,
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
        'heading' => __( 'Bar Width', 'detheme_builder' ),
        'param_name' => 'size',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Label Color', 'detheme_builder' ),
        'param_name' => 'label_color',
        'value' => '',
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => __( 'Unit Color', 'detheme_builder' ),
        'param_name' => 'unit_color',
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
        'heading' => __( 'Background Color', 'detheme_builder' ),
        'param_name' => 'bg',
        'value' => '',
        'type' => 'colorpicker'
         ),
    )

 ) );


?>
