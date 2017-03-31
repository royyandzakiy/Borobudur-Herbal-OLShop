<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_image extends DElement{

    function preview($atts, $content = null){

      $atts['size']='thumbnail';
      $atts['el_id']=$atts['el_class']=$atts['el_class']=$atts['m_top']=$atts['m_bottom']=$atts['m_left']=$atts['m_right']="";

      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = ''){

        extract( shortcode_atts( array(
            'border' => '',
            'align'=>'',
            'image'=>'',
            'size'=>'full',
            'url'=>'',
            'target'=>'',
            'el_id' => '',
            'el_class'=>'',
            'image_style'=>'',
            'spy'=>'',
            'scroll_delay'=>300
        ), $atts,'dt_image' ) );

        global $DEstyle;


        $css_class=array('dt_image');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getCssMargin($atts);

        if(''==$el_id){
            $el_id="dt_image".getCssID();
        }

        $image_id = $image;


        if(!$image=get_image_size($image,$size))
            return "";

        $image_alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);

        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        if('none'!==$spy && !empty($spy)){
            $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";

        $link=($url!='')?"<a href=\"".esc_url($url)."\" target=\"".$target."\">":"";
        $link_end=($url!='')?"</a>":"";

        $compile.="<div class=\"image-align-".$align."\">";
        if($image_style=='diamond'){
            $compile.="<div class=\"ketupat0\"".($image[1]?" style=\"width:".($image[1] -($image[1]*10/100) )."px;height:".($image[1] -($image[1]*10/100) )."px\"":"").">".
            "<div class=\"ketupat1\" ".(''!=$border?" style=\"border:$border solid\"":"").">".
            "<div class=\"ketupat2\">".$link."<img class=\"img-responsive ".(''!=$image_style?"style-".$image_style:"")."\" src=\"".esc_url($image[0])."\" alt=\"".esc_attr($image_alt_text)."\"/>".$link_end."</div></div></div>";
        }
        else{
            $compile.=$link."<img ".(''!=$border?"style=\"border:$border solid\"":"")." class=\"img-responsive ".(''!=$image_style?"style-".$image_style:"")."\" src=\"".esc_url($image[0])."\" alt=\"".esc_attr($image_alt_text)."\"/>".$link_end;
        }
        $compile.="</div>";
        $compile.="</div>";



        if(''!=$css_style){
          $DEstyle[]="#$el_id {".$css_style."}";
        }

        return $compile;
    }
}

add_dt_element('dt_image',
  array(
    'title'=>__('Image','detheme_builder'),
    'icon '=>'dashicons-format-image',
    'order'=>3,
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
        'heading' => __( 'Image', 'detheme_builder' ),
        'param_name' => 'image',
        'type' => 'image'
         ),
        array( 
        'heading' => __( 'Image Align', 'detheme_builder' ),
        'param_name' => 'align',
        'type' => 'dropdown',
        'value'=>array(
            'left'  => __('Align Left','detheme_builder'),
            'right' => __('Align Right','detheme_builder'),
            'center'  => __('Align Center','detheme_builder'),
            )

        ),
        array( 
        'heading' => __( 'Image Size', 'detheme_builder' ),
        'param_name' => 'size',
        'type' => 'textfield',
        'value'=>"",
        'description' => __( 'Enter image size. Example: thumbnail, small, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x200 (Width x Height).', 'detheme_builder' )

        ),
        array( 
        'heading' => __( 'Image Style', 'detheme_builder' ),
        'param_name' => 'image_style',
        'type' => 'dropdown',
        'value'=>array(
            'default'  => __('Default','detheme_builder'),
            'rounded' => __('Rounded','detheme_builder'),
            'circle'  => __('Circle','detheme_builder'),
            'diamond' => __('Diamond','detheme_builder'),
            )
        ),
        array( 
        'heading' => __( 'Border Color', 'detheme_builder' ),
        'param_name' => 'border',
        'type' => 'colorpicker',
        'value'=>""
        ),

        array( 
          'heading' => __( 'Image Link', 'detheme_builder' ),
          'param_name' => 'url',
          'type' => 'textfield',
          ),
        array( 
          'heading' => __( 'Link Target', 'detheme_builder' ),
          'param_name' => 'target',
          'type' => 'dropdown',
          'value'=>array(
              '_self' => __('Self','detheme_builder'),
              '_blank'  => __('Blank','detheme_builder')
            )
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
