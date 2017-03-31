<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_section_header extends DElement {

    function preview($atts, $content = null, $base = ''){

      $atts['font_size']=(isset($atts['font_size']) && $atts['font_size']!='custom')?$atts['font_size']:"default";

      wp_register_style('webfonts-font',get_dt_plugin_dir_url()."webicons/webfonts.css");
      wp_register_style('detheme-builder',get_dt_plugin_dir_url()."css/plugin_style.css",array('webfonts-font'));

      return $this->render($atts, $content);

    }

    function render($atts, $content = null, $base = ''){

        wp_enqueue_style('detheme-builder');

        global $DEstyle;


        extract(shortcode_atts(array(
            'layout_type'=>'section-heading-border',
            'separator_position'=>'',
            'use_decoration'=>false,
            'separator_color'=>'',
            'main_heading' => '',
            'text_align'=>'center',
            'color'=>'',
            'el_id'=>'',
            'el_class'=>'',
            'font_weight'=>'',
            'font_style'=>'',
            'font_size'=>'default',
            'custom_font_size'=>'',
            'separator_color'=>'',
            'spy'=>'',
            'scroll_delay'=>300,
        ), $atts,'section_header'));

        $css_class=array('dt-section-head',$text_align);
        $heading_style=array();


        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getCssMargin($atts);

        if(''==$el_id){
            $el_id="dt-section-head-".getCssID();
        }

        if('default'!==$font_size){
          array_push($css_class," size-".$font_size);
        }

        $compile="<div ";
        if(''!=$el_id){
              $compile.="id=\"$el_id\" ";
        }

        if('none'!==$spy && !empty($spy)){
            $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
        }


        if(!empty($color)){
            $heading_style['color']="color:".$color;
        }


        if(!empty($font_weight) && $font_weight!='default'){
            $heading_style['font-weight']="font-weight:".$font_weight;
        }

        if(!empty($font_style) && $font_style!='default'){
            $heading_style['font-style']="font-style:".$font_style;
        }

        if(!empty($custom_font_size) && $font_size=='custom'){
            $custom_font_size=(preg_match('/(px|pt)$/', $custom_font_size))?$custom_font_size:$custom_font_size."px";
            $heading_style['font-size']="font-size:".$custom_font_size;
        }

        if($use_decoration){

            $decoration_position=$after_heading="";

            if($layout_type=='section-heading-polkadot-two-bottom'){
                $decoration_position="polka-".$separator_position;
            }
            elseif($layout_type=='section-heading-thick-border'){
                $decoration_position="thick-".$separator_position;
            }
            elseif($layout_type=='section-heading-thin-border'){
                $decoration_position="thin-".$separator_position;
            }
            elseif($layout_type=='section-heading-double-border-bottom'){
                $decoration_position="double-border-bottom-".$separator_position;
            }
            elseif($layout_type=='section-heading-thin-border-top-bottom'){
                $decoration_position="top-bottom-".$separator_position;
            }

           if(!empty($separator_color)){
                $heading_style['border-color']="border-color:".$separator_color;

                switch ($layout_type) {
                    case 'section-heading-border-top-bottom':
                    case 'section-heading-thin-border-top-bottom':
                    case 'section-heading-thick-border':
                    case 'section-heading-thin-border':
                    case 'section-heading-double-border-bottom':
                    case 'section-heading-swirl':
                        $DEstyle[]="#".$el_id." h2:after,#".$el_id." h2:before{background-color:".$separator_color.";}";
                        break;
                    case 'section-heading-colorblock':
                        $DEstyle[]="#".$el_id." h2{background-color:".$separator_color.";}";
                        break;
                    case 'section-heading-point-bottom':
                        $DEstyle[]="#".$el_id." h2:before{border-top-color:".$separator_color.";}";
                        break;
                    default:
                        break;
                }

            }

            if($layout_type=='section-heading-swirl' || $layout_type=='section-heading-wave'){
              array_push($css_class,$layout_type);
            }

            if('section-heading-polkadot-left-right'==$layout_type){
              array_push($css_class,"hide-overflow");
            }

            if($layout_type=='section-heading-swirl'){
                $after_heading.='<svg viewBox="0 0 '.(($text_align=='left')?"104":($text_align=='right'?"24":"64")).' 22"'.($separator_color!=''?" style=\"color:".$separator_color."\"":"").'>
                <use xlink:href="'.get_dt_plugin_dir_url().'images/source.svg#swirl"></use>
            </svg>';
            }elseif($layout_type=='section-heading-wave'){
                $after_heading.='<svg viewBox="0 0 '.(($text_align=='left')?"126":($text_align=='right'?"2":"64")).' 30"'.($separator_color!=''?" style=\"color:".$separator_color."\"":"").'>
                <use xlink:href="'.get_dt_plugin_dir_url().'images/source.svg#wave"></use>
            </svg>';
            }


             $compile.='class="'.@implode(" ",$css_class).'">';


            $compile.='<div class="dt-section-container"><h2 class="section-main-title '.$layout_type.' '.$decoration_position.'"'.(count($heading_style)?" style=\"".@implode(";",$heading_style)."\"":"").'>
                '.$main_heading.'
            </h2>'.$after_heading.'
            </div></div>';

        }
        else{



          $compile.='class="'.@implode(" ",$css_class).'">
              <div>'.
                  ((!empty($main_heading))?'<h2'.(count($heading_style)?" style=\"".@implode(";",$heading_style)."\"":"").' class="section-main-title">'.$main_heading.'</h2>':'').
          '</div></div>';  

        }

        if(""!=$css_style){
          $DEstyle[]="#$el_id {".$css_style."}";
        }
        return $compile;
    }
}

add_dt_element('section_header',
 array( 
    'title' => __( 'Section Heading', 'detheme_builder' ),
    'base' => 'section_header',
    'icon'=>'dashicons-editor-textcolor',
    'order'=>2,
    'class' => '',
    'options' => array(  
        array( 
        'heading' => __( 'Text Heading', 'detheme_builder' ),
        'param_name' => 'main_heading',
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ),         
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
              'heading' => __( 'Separator', 'detheme_builder' ),
              'param_name' => 'use_decoration',
              'type' => 'radio',
              'value'=>array(
                    '1'=>__("Yes", 'detheme_builder'),
                    '0'=>__("No", 'detheme_builder'),
                  ),
              'default' => 1       
          ),
         array( 
        'heading' => __( 'Layout type', 'detheme_builder' ),
        'param_name' => 'layout_type',
        'class' => '',
        'param_holder_class'=>'section-heading-style',
        'type' => 'select_layout',
         'value'=>array(
            'section-heading-border'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_01.png" alt="'.__('Type 1: Borderer','detheme_builder').'" />',
            'section-heading-border-top-bottom' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_02.png" alt="'.__('Type 2: Border Top-Bottom','detheme_builder').'"/>' ,
            'section-heading-polkadot-two-bottom' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_03.png" alt="'.__('Type 3: Two Bottom Polkadot','detheme_builder').'"/>' ,
            'section-heading-colorblock'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_06.png" alt="'.__('Type 4: Color Background','detheme_builder').'"/>' ,
            'section-heading-point-bottom'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_07.png" alt="'.__('Type 5: ','detheme_builder').'"/>' ,
            'section-heading-thick-border'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_08.png" alt="'.__('Type 6: ','detheme_builder').'"/>' ,
            'section-heading-thin-border' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_11.png" alt="'.__('Type 7: ','detheme_builder').'"/>' ,
            'section-heading-polkadot-left-right' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_14.png" alt="'.__('Type 8: ','detheme_builder').'"/>' ,
            'section-heading-polkadot-top'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_15.png" alt="'.__('Type 9: ','detheme_builder').'"/>' ,
            'section-heading-polkadot-bottom' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_16.png" alt="'.__('Type 10: ','detheme_builder').'"/>' ,
            'section-heading-double-border-bottom'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_17.png" alt="'.__('Type 11: ','detheme_builder').'"/>' ,
            'section-heading-thin-border-top-bottom'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_18.png" alt="'.__('Type 12: ','detheme_builder').'"/>' ,
            'section-heading-swirl' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_19.png" alt="'.__('Type 13: ','detheme_builder').'"/>' ,
            'section-heading-wave'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_20.png" alt="'.__('Type 14: ','detheme_builder').'"/>' ,
            ),
        'dependency' => array( 'element' => 'use_decoration', 'value' => array('1')),        
         ),
         array( 
        'heading' => __( 'Separator Position', 'detheme_builder' ),
        'param_name' => 'separator_position',
        'class' => '',
        'value' => array('center'=>__('Center','detheme_builder') ,'left'=>__('Left','detheme_builder') ,'right'=>__('Right','detheme_builder') ),
        'type' => 'dropdown',
        'default'=>'center',
        'dependency' => array( 'element' => 'use_decoration', 'value' => array('1')),        
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
        'heading' => __( 'Text Alignment', 'detheme_builder' ),
        'param_name' => 'text_align',
        'class' => '',
        'value' => array('center'=>__('Center','detheme_builder') ,'left'=>__('Left','detheme_builder') ,'right'=>__('Right','detheme_builder') ),
        'type' => 'dropdown',
        'default'=>'center'
         ),         
        array( 
        'heading' => __( 'Font Size', 'detheme_builder' ),
        'param_name' => 'font_size',
        'default' => "default",
        'value'=>array(
              'xlarge'  => __('Extra Large','detheme_builder'),
              'large' => __('Large','detheme_builder'),
              'default' => __('Default','detheme_builder'),
              'small' => __('Small','detheme_builder'),
              'exsmall' => __('Extra small','detheme_builder'),
              'custom'  => __( 'Custom Size', 'detheme_builder' )
              ),
        'type' => 'dropdown'
         ),
        array( 
        'heading' => __( 'Custom Font Size', 'detheme_builder' ),
        'param_name' => 'custom_font_size',
        'value' => '',
        'type' => 'textfield',
        'dependency' => array( 'element' => 'font_size', 'value' => array( 'custom') )       
         ),         
        array( 
        'heading' => __( 'Font Style', 'detheme_builder' ),
        'param_name' => 'font_style',
        'default' => "default",
        'value'=>array(
              'italic'  => __('Italic','detheme_builder'),
              'oblique' => __('Oblique','detheme_builder'),
              'default' => __('Default','detheme_builder'),
              'normal'  => __('Normal','detheme_builder'),
              ),
        'type' => 'dropdown'
         ),
        array( 
        'heading' => __( 'Font Weight', 'detheme_builder' ),
        'param_name' => 'font_weight',
        'default' => "default",
        'value'=>array(
              'bold'  => __('Bold','detheme_builder'),
              'bolder'  => __('Bolder','detheme_builder'),
              'normal'  => __('Normal','detheme_builder'),
              'lighter' => __('lighter','detheme_builder'),
              '100'=>'100',
              '200'=>'200',
              '300'=>'300',
              '400'=>'400',
              '500'=>'500',
              '600'=>'600',
              '700'=>'700',
              '800'=>'800',
              '900'=>'900',
              'default' => __('Default','detheme_builder'),
              ),
        'type' => 'dropdown'
         ),
         array( 
        'heading' => __( 'Text Color', 'detheme_builder' ),
        'param_name' => 'color',
        'value' => '',
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => __( 'Separator Color', 'detheme_builder' ),
        'param_name' => 'separator_color',
        'value' => '',
        'type' => 'colorpicker',
        'dependency' => array( 'element' => 'use_decoration', 'value' => array('1')),        
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
