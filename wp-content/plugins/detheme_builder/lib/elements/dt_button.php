<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();


class DElement_dt_button_cta extends DElement {

    function preview($atts, $content = null) {

      $atts['url']="";

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = '') {

    extract( shortcode_atts( array(
      'url' => '',
      'target' => '',
      'size' => '',
      'style' => 'ghost',
      'skin' => '',
      'el_class'=>'',
      'text'=>'',
      'el_id'=>''
    ), $atts ,'dt_button_cta'));

    $result="";
    $content= ($text=='' && $content!='')?dt_remove_autop($content):$text;

    $class=array('btn');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id && ""!=$css_style){
            $el_id="button".getCssID().time().rand(11,99);

     }

     if(''!=$css_style){
          global $DEstyle;
           $DEstyle[]="#$el_id {".$css_style."}";
      }

    if(!empty($ico)) $class[]=$ico;
    if(!empty($size)) $class[]=$size;
    if(!empty($style)) $class[]="btn-".$style;
    if(!empty($skin)) $class[]="skin-".$skin;

    if(count($class)){
      $result = '<a '.(''!=$el_id?"id=\"".$el_id."\" ":"").(!empty($url)?"href=\"".$url."\"":"").'class="'.@implode(" ",$class).'" target="'.$target.'">'.$content.'</a>';
    }

    return $result;

    }
}

add_dt_element('dt_button_cta',
  array(
    'title'=>__('Button','detheme_builder'),
    'icon'=>'dashicons-megaphone',
    'order'=>4,
    'options'=>array(
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
          'heading' => __('Button Text','detheme_builder'),
          'param_name' => 'text',
          'admin_label'=>true,
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Button URL', 'detheme_builder' ),
          'param_name' => 'url',
          'type' => 'textfield',
          ),
        array( 
          'heading' => __( 'Button skin', 'detheme_builder' ),
          'param_name' => 'skin',
          'type' => 'radio',
          'value'=>array('dark'=>__('Dark (default)'),'light'=>__('Light','detheme_builder')),
          'default'=>'dark'
        ),
        array( 
          'heading' => __( 'Button style', 'detheme_builder' ),
          'param_name' => 'style',
          'value'=>array(
                    'color-primary'=>__('Primary','detheme_builder'),
                    'color-secondary'=>__('Secondary','detheme_builder'),
                    'success'=>__('Success','detheme_builder'),
                    'info'=>__('Info','detheme_builder'),
                    'warning'=>__('Warning','detheme_builder'),
                    'danger'=>__('Danger','detheme_builder'),
                    'ghost'=>__('Ghost Button','detheme_builder'),
                    'link'=>__('Link','detheme_builder'),
            ),
          'type' => 'dropdown',
          'default'=>'ghost'
        ),
         array( 
          'heading' => __( 'Button size', 'detheme_builder' ),
          'param_name' => 'size',
          'type' => 'dropdown',
          'value' => array(
                    'btn-lg'=>__('Large','detheme_builder'),
                    'btn-default'=>__('Default','detheme_builder'),
                    'btn-sm'=>__('Small','detheme_builder'),
                    'btn-xs'=>__('Extra small','detheme_builder')

          ),
        ),
        array( 
          'heading' => __( 'Button Target', 'detheme_builder' ),
          'param_name' => 'target',
          'type' => 'dropdown',
          'value'=>array(
              '_self'=>__('Self','detheme_builder'),
              '_blank'=>__('Blank','detheme_builder')
            )
        ),
        )
    )
);
?>
