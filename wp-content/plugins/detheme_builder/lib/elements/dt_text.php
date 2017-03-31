<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_text extends DElement{

    function preview($atts, $content = null, $base = ''){

        $content=dt_remove_wpautop($content);
        return $content;

    }

    function render($atts, $content = null, $base = ''){

        global $DEstyle;

        extract( shortcode_atts( array(
            'el_id' => '',
            'el_class'=>'',
            'scroll_delay'=>'300',
            'spy'=>''
        ), $atts , 'dt_text') );

        $css_class=array('dt_text');


        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if(''==$el_id){
            $el_id="dt_text".getCssID().time().rand(11,99);
        }

        $css_style=getCssMargin($atts);

        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

       if('none'!==$spy && !empty($spy)){

            $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $compile.=do_shortcode($content);
        $compile.="</div>";


        if(''!=$css_style){
          $DEstyle[]="#$el_id {".$css_style."}";
        }
        return $compile;

    }
}

class DElement_dt_text_html extends DElement_dt_text{}

add_dt_element('dt_text_html',
  array(
    'title'=>__('Text Editor','detheme_builder'),
    'icon'=>"dashicons-edit",
    'order'=>1,
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
              'heading' => __( 'Text', 'detheme_builder' ),
              'param_name' => 'content',
              'type' => 'textarea_html',
              'default'=>__("I am text block. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.",'detheme_builder')
             ),     
            array( 
            'heading' => __( 'Animation Type', 'detheme_builder' ),
            'param_name' => 'spy',
            'class' => '',
            'value' => 
             array(
                'none'                      => __('Scroll Spy not activated','detheme_builder'),
                'uk-animation-fade'         => __('The element fades in','detheme_builder'),
                'uk-animation-scale-up'     => __('The element scales up','detheme_builder'),
                'uk-animation-scale-down'   => __('The element scales down','detheme_builder'),
                'uk-animation-slide-top'    => __('The element slides in from the top','detheme_builder'),
                'uk-animation-slide-bottom' => __('The element slides in from the bottom','detheme_builder'),
                'uk-animation-slide-left'   => __('The element slides in from the left','detheme_builder'),
                'uk-animation-slide-right'  => __('The element slides in from the right.','detheme_builder'),
             ),        
            'description' => __( 'Scroll spy effects', 'detheme_builder' ),
            'type' => 'dropdown',
             ),     
            array( 
            'heading' => __( 'Animation Delay', 'detheme_builder' ),
            'param_name' => 'scroll_delay',
            'class' => '',
            'default' => '300',
            'description' => __( 'The number of delay the animation effect of the icon. in milisecond', 'detheme_builder' ),
            'type' => 'textfield',
            'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
             ),     
       )
    )
);

?>
