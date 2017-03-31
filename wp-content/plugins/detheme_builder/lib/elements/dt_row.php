<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_row extends DElement{

    function render($atts, $content = null, $base = ''){

      global $DEstyle;

        extract( shortcode_atts( array(
            'el_id' => '',
            'el_class'=>'',
            'image'=>'',
            'font_color'=>'',
            'background_style'=>'',
            'background_video'=>'',
            'background_video_webm'=>'',
            'background_type' =>'image',
            'background_poster'=>'',
            'bg_color'=>'',
            'm_top'=>'',
            'm_bottom'=>'',
            'm_left'=>'',
            'm_right'=>'',
            'p_top'=>'',
            'p_bottom'=>'',
            'p_left'=>'',
            'p_right'=>'',
            'scroll_delay'=>300,
            'spy'=>''
        ), $atts, 'dt_row' ) );

        $css_class=array('dt_row');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if(''==$el_id){
            $el_id="dt_row_".getCssID().time().rand(11,99);
        }

        $css_style=getCssMargin($atts,true);

        $video="";

        if(''!=$bg_color){$css_style['background-color']="background-color:$bg_color";}
        if($background_type=='image' && ''!=$image && $background_image=wp_get_attachment_image_src( $image, 'full' )){

              $css_style['background-image']="background-image:url(".$background_image[0].")!important;";

              switch($background_style){
                  case'cover':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important";
                      break;
                  case'no-repeat':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size:auto !important";
                      break;
                  case'repeat':
                      $css_style['background-position']="background-position: 0 0 !important;background-repeat: repeat !important;background-size:auto !important";
                      break;
                  case'contain':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size: contain!important";
                      break;
                  case 'fixed':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important;background-attachment: fixed !important";
                      break;
              }

        }
        elseif($background_type=='video' && ($background_video!='' || $background_video_webm!='')){

            $source_video=array();

            if($background_video!=''){

              $video_url=wp_get_attachment_url(intval($background_video));
              $videodata=wp_get_attachment_metadata(intval($background_video));

              if(''!=$video_url && $background_type=='video'){

                array_push($css_class,'has-video');

                $videoformat="video/mp4";
                if(is_array($videodata) && $videodata['mime_type']=='video/webm'){
                     $videoformat="video/webm";
                }

                $source_video[]="<source src=\"".esc_url($video_url)."\" type=\"".$videoformat."\" />";
               }
            }

            if($background_video_webm!=''){

              $video_url=wp_get_attachment_url(intval($background_video_webm));
              $videodata=wp_get_attachment_metadata(intval($background_video_webm));

              if(''!=$video_url && $background_type=='video'){

                array_push($css_class,'has-video');

                $videoformat="video/mp4";
                if(is_array($videodata) && $videodata['mime_type']=='video/webm'){
                     $videoformat="video/webm";
                }

                $source_video[]="<source src=\"".esc_url($video_url)."\" type=\"".$videoformat."\" />";
               }
            }

            if(count($source_video)){

              $poster="";

              if($background_poster!='' && $poster_image=wp_get_attachment_image_src( $background_poster, 'full' )){
                if(isset($poster_image[0]) && $poster_image[0]!='') $poster=$poster_image[0];
              }

              $video="<video class=\"video_background\" poster=\"".$poster."\" autoplay loop>\n".@implode("\n", $source_video)."</video>";

            }
        }

        $compile="";

        array_push($css_class,'row');
        $compile.="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

       if('none'!==$spy && !empty($spy)){
            $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $compile.=$video.do_shortcode($content);
        $compile.="</div>";

        if(''!=$font_color){
          $DEstyle[]="#$el_id * {color:$font_color}";
        }

        if(count($css_style)){
          $DEstyle[]="#$el_id {".@implode(";",$css_style)."}";
        }

        return $compile;

    }
}

class DElement_dt_inner_row extends DElement{

    function render($atts, $content = null, $base = ''){


      global $DEstyle;

        extract( shortcode_atts( array(
            'el_id' => '',
            'el_class'=>'',
            'image'=>'',
            'background_style'=>'',
            'bg_color'=>'',
            'font_color'=>'',
            'm_top'=>'',
            'm_bottom'=>'',
            'm_left'=>'',
            'm_right'=>'',
            'p_top'=>'',
            'p_bottom'=>'',
            'p_left'=>'',
            'p_right'=>'',
        ), $atts,'dt_inner_row' ) );

        $css_class=array('row','dt_row');
        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if(''==$el_id){
            $el_id="dt_row_".getCssID().time().rand(11,99);
        }

        $css_style=getCssMargin($atts,true);

        if(''!=$bg_color){$css_style['background-color']="background-color:$bg_color";}
        if(''!=$image && $background_image=wp_get_attachment_image_src( $image, 'full' )){

              $css_style['background-image']="background-image:url(".$background_image[0].")!important;";

              switch($background_style){
                  case'cover':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important";
                      break;
                  case'no-repeat':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size:auto !important";
                      break;
                  case'repeat':
                      $css_style['background-position']="background-position: 0 0 !important;background-repeat: repeat !important;background-size:auto !important";
                      break;
                  case'contain':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size: contain!important";
                      break;
                  case 'fixed':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important;background-attachment: fixed !important";
                      break;
              }

        }

        $compile="";
        $compile.="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }
        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $compile.=do_shortcode($content);
        $compile.="</div>";

        if(''!=$font_color){
          $DEstyle[]="#$el_id * {color:$font_color}";
        }

        if(count($css_style)){
          $DEstyle[]="#$el_id {".@implode(";",$css_style)."}";
        }

        return $compile;
}

}
class DElement_dt_inner_row_1 extends DElement_dt_inner_row{}

class DElement_dt_column extends DElement{

    function render($atts, $content = null, $base = ''){

      global $DEstyle;

        extract( shortcode_atts( array(
            'column'=>12,
            'title'=>'',
            'el_id' => '',
            'el_class'=>'',
            'image'=>'',
            'background_style'=>'',
            'bg_color'=>'',
            'font_color'=>'',
            'p_top'=>'',
            'p_bottom'=>'',
            'p_left'=>'',
            'p_right'=>'',
        ), $atts,'dt_column' ) );

        $css_class=array('dt_column');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if(''==$el_id){
            $el_id="dt_column_".getCssID();
        }

        $css_style=getCssMargin($atts,true);

        if(''!=$bg_color){$css_style['background-color']="background-color:$bg_color";}
        if(''!=$image && $background_image=wp_get_attachment_image_src( $image, 'full' )){

              $css_style['background-image']="background-image:url(".$background_image[0].")!important;";

               switch($background_style){
                  case'cover':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important";
                      break;
                  case'no-repeat':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size:auto !important";
                      break;
                  case'repeat':
                      $css_style['background-position']="background-position: 0 0 !important;background-repeat: repeat !important;background-size:auto !important";
                      break;
                  case'contain':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size: contain!important";
                      break;
                  case 'fixed':
                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important;background-attachment: fixed !important";
                      break;
              }

        }

        $css_column=(in_array($column,array(1,2,3,4,5,6,7,8,9,10,11,12)))?"col-sm-".min($column,12):"column_custom_".$column;
        array_push($css_class,$css_column);

       
        $compile="<div ";
        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }
        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $compile.=do_shortcode($content);
        $compile.="</div>";

        if(''!=$font_color){
          $DEstyle[]="#$el_id * {color:$font_color}";
        }

        if(count($css_style)){
          $DEstyle[]="#$el_id {".@implode(";",$css_style)."}";
        }

        return $compile;

    }
}

class DElement_dt_inner_column extends DElement_dt_column{}
class DElement_dt_inner_column_1 extends DElement_dt_column{}


add_dt_element('dt_row',
  array(
    'title'=>__('Row','detheme_builder'),
    'icon'=>'dashicons-editor-justify',
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
          "type" => "colorpicker",
          "heading" => __('Font Color', 'detheme_builder'),
          "param_name" => "font_color",
          "description" => __("Select font color", "detheme_builder"),
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
          'heading' => __( 'Padding Top', 'detheme_builder' ),
          'param_name' => 'p_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Bottom', 'detheme_builder' ),
          'param_name' => 'p_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Left', 'detheme_builder' ),
          'param_name' => 'p_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Right', 'detheme_builder' ),
          'param_name' => 'p_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
        ),
      array( 
          'heading' => __( 'Background Type', 'detheme_builder' ),
          'param_name' => 'background_type',
          'value' => array('image'=>__( 'Image', 'detheme_builder' ),'video'=>__( 'Video', 'detheme_builder' )),
          'type' => 'radio',
          'default'=>'image'
        ),
        array( 
          'heading' => __( 'Background Image', 'detheme_builder' ),
          'param_name' => 'image',
          'type' => 'image',
          'dependency' => array( 'element' => 'background_type', 'value' => array('image') )   
        ),
        array( 
          'heading' => __( 'Background Video (mp4)', 'detheme_builder' ),
          'param_name' => 'background_video',
          'type' => 'video',
          'params'=>array('mime_type'=>'video/mp4'),
          'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
        ),
       array( 
          'heading' => __( 'Background Video (webm)', 'detheme_builder' ),
          'param_name' => 'background_video_webm',
          'type' => 'video',
          'params'=>array('mime_type'=>'video/webm'),
          'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
       ),
       array( 
          'heading' => __( 'Image Thumb/Poster', 'detheme_builder' ),
          'param_name' => 'background_poster',
          'type' => 'image',
          'dependency' => array( 'element' => 'background_type', 'value' => array('video') )   
       ),
        array( 
          'heading' => __( 'Background Image Style', 'detheme_builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => __("Cover", 'detheme_builder') ,
                'contain' => __('Contain', 'detheme_builder') ,
                'no-repeat' => __('No Repeat', 'detheme_builder') ,
                'repeat'  => __('Repeat', 'detheme_builder') ,
               'fixed'  => __("Fixed", 'detheme_builder') ,
              ),
          'group'=>__('Extended options', 'detheme_builder'),
          'dependency' => array( 'element' => 'background_type', 'value' => array('image') )       
          ),
        array( 
          'heading' => __( 'Background Color', 'detheme_builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker'
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


add_dt_element('dt_inner_row',
  array(
    'title'=>__('Row','detheme_builder'),
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
          "type" => "colorpicker",
          "heading" => __('Font Color', 'detheme_builder'),
          "param_name" => "font_color",
          "description" => __("Select font color", "detheme_builder"),
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
          'heading' => __( 'Padding Top', 'detheme_builder' ),
          'param_name' => 'p_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Bottom', 'detheme_builder' ),
          'param_name' => 'p_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Left', 'detheme_builder' ),
          'param_name' => 'p_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Right', 'detheme_builder' ),
          'param_name' => 'p_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Background Image', 'detheme_builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => __( 'Background Image Style', 'detheme_builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => __("Cover", 'detheme_builder')  ,
                'contain' => __('Contain', 'detheme_builder')  ,
                'no-repeat' => __('No Repeat', 'detheme_builder')  ,
                'repeat'  => __('Repeat', 'detheme_builder')  ,
               'fixed'  => __("Fixed", 'detheme_builder')  ,
              ),
          'group'=>__('Extended options', 'detheme_builder'),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => __( 'Background Color', 'detheme_builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
      )
    )
);

add_dt_element('dt_inner_row_1',
  array(
    'title'=>__('Row','detheme_builder'),
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
          "type" => "colorpicker",
          "heading" => __('Font Color', 'detheme_builder'),
          "param_name" => "font_color",
          "description" => __("Select font color", "detheme_builder"),
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
          'heading' => __( 'Padding Top', 'detheme_builder' ),
          'param_name' => 'p_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Bottom', 'detheme_builder' ),
          'param_name' => 'p_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Left', 'detheme_builder' ),
          'param_name' => 'p_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Right', 'detheme_builder' ),
          'param_name' => 'p_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Background Image', 'detheme_builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => __( 'Background Image Style', 'detheme_builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => __("Cover", 'detheme_builder')  ,
                'contain' => __('Contain', 'detheme_builder')  ,
                'no-repeat' => __('No Repeat', 'detheme_builder')  ,
                'repeat'  => __('Repeat', 'detheme_builder')  ,
               'fixed'  => __("Fixed", 'detheme_builder')  ,
              ),
          'group'=>__('Extended options', 'detheme_builder'),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => __( 'Background Color', 'detheme_builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
       )
    )
);

add_dt_element('dt_column',
  array(
    'title'=>__('Column','detheme_builder'),
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
          "description" => __("If you wish to add anchor id to this column. Anchor id may used as link like href=\"#yourid\"", "detheme_builder"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => __('Font Color', 'detheme_builder'),
          "param_name" => "font_color",
          "description" => __("Select font color", "detheme_builder"),
        ),
        array( 
          'heading' => __( 'Background Image', 'detheme_builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => __( 'Padding Top', 'detheme_builder' ),
          'param_name' => 'p_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Bottom', 'detheme_builder' ),
          'param_name' => 'p_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Left', 'detheme_builder' ),
          'param_name' => 'p_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Right', 'detheme_builder' ),
          'param_name' => 'p_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
        ),         array( 
          'heading' => __( 'Background Image Style', 'detheme_builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => __("Cover", 'detheme_builder')  ,
                'contain' => __('Contain', 'detheme_builder')  ,
                'no-repeat' => __('No Repeat', 'detheme_builder')  ,
                'repeat'  => __('Repeat', 'detheme_builder')  ,
               'fixed'  => __("Fixed", 'detheme_builder')  ,
              ),
          'group'=>__('Extended options', 'detheme_builder'),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => __( 'Background Color', 'detheme_builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
        )
    )
);

add_dt_element('dt_inner_column',
  array(
    'title'=>__('Column','detheme_builder'),
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
          "description" => __("If you wish to add anchor id to this column. Anchor id may used as link like href=\"#yourid\"", "detheme_builder"),
        ),
        array(
          "type" => "colorpicker",
          "heading" => __('Font Color', 'detheme_builder'),
          "param_name" => "font_color",
          "description" => __("Select font color", "detheme_builder"),
        ),
        array( 
          'heading' => __( 'Background Image', 'detheme_builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => __( 'Padding Top', 'detheme_builder' ),
          'param_name' => 'p_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Bottom', 'detheme_builder' ),
          'param_name' => 'p_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Left', 'detheme_builder' ),
          'param_name' => 'p_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Right', 'detheme_builder' ),
          'param_name' => 'p_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
        ),         array( 
          'heading' => __( 'Background Image Style', 'detheme_builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => __("Cover", 'detheme_builder')  ,
                'contain' => __('Contain', 'detheme_builder')  ,
                'no-repeat' => __('No Repeat', 'detheme_builder')  ,
                'repeat'  => __('Repeat', 'detheme_builder')  ,
               'fixed'  => __("Fixed", 'detheme_builder')  ,
              ),
          'group'=>__('Extended options', 'detheme_builder'),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => __( 'Background Color', 'detheme_builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),
       )
    )
);

add_dt_element('dt_inner_column_1',
  array(
    'title'=>__('Column','detheme_builder'),
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
          "description" => __("If you wish to add anchor id to this column. Anchor id may used as link like href=\"#yourid\"", "detheme_builder"),
        ),
        array( 
          'heading' => __( 'Padding Top', 'detheme_builder' ),
          'param_name' => 'p_top',
          'param_holder_class'=>'p_top',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Bottom', 'detheme_builder' ),
          'param_name' => 'p_bottom',
          'param_holder_class'=>'p_bottom',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Left', 'detheme_builder' ),
          'param_name' => 'p_left',
          'param_holder_class'=>'p_left',
          'type' => 'textfield',
        ),
        array( 
          'heading' => __( 'Padding Right', 'detheme_builder' ),
          'param_name' => 'p_right',
          'param_holder_class'=>'p_right',
          'type' => 'textfield',
        ),
        array(
          "type" => "colorpicker",
          "heading" => __('Font Color', 'detheme_builder'),
          "param_name" => "font_color",
          "description" => __("Select font color", "detheme_builder"),
        ),
        array( 
          'heading' => __( 'Background Image', 'detheme_builder' ),
          'param_name' => 'image',
          'type' => 'image',
        ),
        array( 
          'heading' => __( 'Background Image Style', 'detheme_builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => __("Cover", 'detheme_builder')  ,
                'contain' => __('Contain', 'detheme_builder')  ,
                'no-repeat' => __('No Repeat', 'detheme_builder')  ,
                'repeat'  => __('Repeat', 'detheme_builder')  ,
               'fixed'  => __("Fixed", 'detheme_builder')  ,
              ),
          'group'=>__('Extended options', 'detheme_builder'),
          'dependency' => array( 'element' => 'image', 'not_empty' => true )       
          ),
        array( 
          'heading' => __( 'Background Color', 'detheme_builder' ),
          'param_name' => 'bg_color',
          'type' => 'colorpicker',
        ),       )
    )
);
?>
