<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();


$fonts=@explode(";","Droid Sans;Open Sans;Tangerine;Josefin Slab;Arvo;Lato;Vollkorn;Abril Fatface;Ubuntu;PT Sans;PT Serif;Old Standard TT");
foreach ($fonts as $value) {

    $value=trim($value);
    $font_formats[$value]=$value;
}
@ksort($font_formats);
$font_formats= array_merge(array(__('Default','detheme_builder')=>''),$font_formats);

class DElement_dt_optin_form extends DElement{

  function render($atts, $content = null, $base=""){


     extract(shortcode_atts(array(

          'title'=>'',
          'sub_title'=>'',
          'value'=>'',
          'footer_text'=>'',
          'layout'=>'',
          'button'=>'button1',
          'button_text'=>__('Submit','detheme_builder'),
          'button_text_color'=>'',
          'button_color'=>'',
          'font_size'=>'',
          'vertical_padding'=>'',
          'horizontal_padding'=>'',
          'button_radius'=>'',
          'email_label'=>__( 'Email Label', 'detheme_builder' ),
          'name_label'=>__('Your name','detheme_builder'),
          'button_font'=>'',
          'expanded'=>0,
          'button_align'=>'left',
          'label_align'=>'left',
          'input_radius'=>'',
          'input_vertical_padding'=>'',
          'input_horizontal_padding'=>'',
          'element_margin'=>'',
          'gradient'=>false,
          'gradient_color_to'=>'',
          'el_id'=>'',
          'el_class'=>''
      ), $atts, 'dt_optin_form'));

     wp_register_script( 'optin', get_dt_plugin_dir_url() . 'js/optin_form.js', array('jquery'), '', false );
     wp_enqueue_script('optin');

     global $DEstyle;

    $code="";
    $compile="";

    $excss=getCssID("optin_form_");


      $buttoncss=$buttonHovercss=$inputcss=array();

      if(!empty($button_text_color)){
          $buttoncss[]="color:".$button_text_color;
      }
      if(!empty($button_color)){

          if($gradient && !empty($gradient_color_to)){

              $buttoncss[]="background:-webkit-linear-gradient(".$button_color.",".$gradient_color_to.")";
              $buttoncss[]="background:-moz-linear-gradient(".$button_color.",".$gradient_color_to.")";
              $buttoncss[]="background:-ms-linear-gradient(".$button_color.",".$gradient_color_to.")";
              $buttoncss[]="background:-o-linear-gradient(".$button_color.",".$gradient_color_to.")";
              $buttoncss[]="background:linear-gradient(".$button_color.",".$gradient_color_to.")";
          }
          else{
              $buttoncss[]="background-color:".$button_color;
          }

          $buttonHovercss[]="background-color:".darken($button_color,5);

      }
      if(!empty($font_size)){
          $buttoncss[]="font-size:".$font_size."px";
      }

      if(!empty($horizontal_padding)){
          $buttoncss[]="padding-left:".$horizontal_padding."px";
          $buttoncss[]="padding-right:".$horizontal_padding."px";
      }
      if(!empty($vertical_padding)){
          $buttoncss[]="height:".$vertical_padding."px";
          $inputcss[]="height:".$vertical_padding."px";
      }
      if($expanded){
          $buttoncss[]="width:100%";
      }

      if(!empty($button_radius)){
          $buttoncss[]="border-radius:".$button_radius."px";
      }

      if(!empty($button_font)){

          $font = 'http://fonts.googleapis.com/css?family=Droid+Sans%7COpen+Sans%7CTangerine%7CJosefin+Slab%7CArvo%7CLato%7CVollkorn%7CAbril+Fatface%7CUbuntu%7CPT+Sans%7CPT+Serif%7COld+Standard+TT';
          wp_enqueue_style('google-font', $font); 

          $buttoncss[]="font-family:".$button_font;
      }

      if(!empty($element_margin)){
         $element_margin=( preg_match('/horizontal/', $layout)?"padding-right:".$element_margin."px !important":"margin-bottom:".$element_margin."px !important");
      }

      if(!empty($input_horizontal_padding)){
          $inputcss[]="padding-left:".$input_horizontal_padding."px";
          $inputcss[]="padding-right:".$input_horizontal_padding."px";
      }

      if(!empty($label_align)){
          $inputcss[]="text-align:".$label_align;
      }

      if(!empty($input_radius)){
          $inputcss[]="border-radius:".$input_radius."px";
      }


        $formcode='<form role="form" class="'.$layout.( preg_match('/horizontal/', $layout)?" form-inline":"").'" id="dt_optin_form_'.$excss.'">';
        $formcode.=($layout=='vertical_email' || $layout=='horizontal_email')?"":"<div class=\"form-group field-wrap\">";
        $formcode.='<input type="'.(($layout=='vertical_email' || $layout=='horizontal_email')?"hidden":"text").'" class="dt_name form-control" name="dt_name" placeholder="'.$name_label.'" />';
        $formcode.=($layout=='vertical_email' || $layout=='horizontal_email')?"":"</div>";
        $formcode.='<div class="form-group field-wrap"><input type="text" class="dt_email form-control" name="dt_email"  placeholder="'.$email_label.'" /></div>';
        $formcode.='<div class="form-group button-wrap" style="text-align:'.$button_align.'"><button class="form_connector_submit" type="submit" value="'.$button_text.'" >'.$button_text.'</button></div>';
        $formcode.='</form>';


        if(count($inputcss)){
            $DEstyle[]=".".$excss." input,.".$excss." input.dt_name,.".$excss." input.dt_email{".@implode(";",$inputcss)."}";
       }
        if(count($buttonHovercss)){
            $DEstyle[]=".".$excss." .form_connector_submit:hover{".@implode(";",$buttonHovercss)."}";
        }

        if(!empty($element_margin)){
            $DEstyle[]=".".$excss." .field-wrap{".$element_margin."}";
        }

        $DEstyle[]=".".$excss." .form_connector_submit{".@implode(";",$buttoncss)."}";

        $css_class=array('optin-form',$excss,$button);


        $css_style=getCssMargin($atts);

          if(''!=$el_class){
             array_push($css_class, $el_class);
          }

          if(''==$el_id && ""!=$css_style){
              $el_id="optin_wrapper".getCssID().time().rand(11,99);

          }

          $compile="<div ";

          if(''!=$el_id){
              $compile.="id=\"$el_id\" ";
          }

          if(''!=$css_style){
            $DEstyle[]="#$el_id {".$css_style."}";
      
          }

          $compile.="class=\"".@implode(" ",$css_class)."\">";
           if(!empty($title)){ 
          $compile.='<h2 class="optin-heading">'.$title.'</h2>';
          }

          if(!empty($sub_title)){ 
          $compile.='<div class="optin-subheading">'.$sub_title.'</div>';
          } 

     $compile.='<div class="optin-content">'.$formcode.'</div>';

          if(!empty($footer_text)){ 
          $compile.='<div class="optin-footer">'.$footer_text.'</div>';
          } 

     $compile.='<div class="optin_code" >'.html_entity_decode($content).'</div>';
     $compile.="</div>";
     $compile.='<script type="text/javascript">var ajaxurl = \''.admin_url('admin-ajax.php').'\';</script>';

     return $compile;

  }
}

add_dt_element('dt_optin_form',
    array( 
    'title' => __( 'Optin Form', 'detheme_builder' ),
    'icon'  => 'dashicons-index-card',
    'order'=>22,
    'options' => array(
        array( 
            'heading' => __( 'Label', 'detheme_builder' ),
            'param_name' => 'label',
            'type' => 'textfield',
            'admin_label'=>true,
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
        'heading' => __( 'Optin Code', 'detheme_builder' ),
        'param_name' => 'content',
        'description' => __( 'put your optin form code here', 'detheme_builder' ),
        'value' => '',
        'css'=>'optin-code',
        'type' => 'textarea',
         ),
        array( 
        'heading' => __( 'Choose Layout', 'detheme_builder' ),
        'param_name' => 'layout',
        'class' => 'select_optin_layout',
        'type' => 'select_layout',
         'value'=>array(
            'vertical'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/optin-1.gif" alt="" />',
            'vertical_email'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/optin-3.gif" alt=""/>',
            'horizontal_email'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/optin-2.gif" alt=""/>',
            'horizontal'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/optin-4.gif" alt=""/>'
            ),
        'default'=>'vertical',
        'description' => __( 'Choose the icon layout you want to use.', 'detheme_builder' ),
         ), 
        array( 
        'heading' => __( 'Form Preview', 'detheme_builder' ),
        'param_name' => 'button_preview',
        'value' => "",
        'param_holder_class'=>'preview-optin-form optin-preview',
        'type' => 'button_preview',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Name Label', 'detheme_builder' ),
        'param_name' => 'name_label',
        'default' => __('Your name','detheme_builder'),
        'param_holder_class'=>'name-optin-form optin-preview',
        'type' => 'textfield',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Email Label', 'detheme_builder' ),
        'param_name' => 'email_label',
        'param_holder_class'=>'email-optin-form optin-preview',
        'default' => __('Your email','detheme_builder'),
        'type' => 'textfield',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Button Text', 'detheme_builder' ),
        'param_name' => 'button_text',
        'param_holder_class'=>'button-optin-form optin-preview',
        'default' => __('Submit Button','detheme_builder'),
        'type' => 'textfield',
        "group" => __('Form Preview', 'detheme_builder'),
         ),
        array( 
        'heading' => __( 'Button Font Type', 'detheme_builder' ),
        'param_name' => 'button_font',
        'param_holder_class'=>'font-optin-form optin-preview',
        'value' => $font_formats,
        'type' => 'dropdown',
        "group" => __('Form Preview', 'detheme_builder'),
         ),
        array( 
        'heading' => __( 'Button Text Color', 'detheme_builder' ),
        'param_name' => 'button_text_color',
        'param_holder_class'=>'button-text-color optin-preview',
        'value' => "",
        'default' => "#fff",
        'type' => 'colorpicker',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Button Font Size', 'detheme_builder' ),
        'param_name' => 'font_size',
        'param_holder_class'=>'font-size-selector optin-preview',
        'default' => "12",
        'type' => 'slider_value',
        'params'=>array('min'=>12,'max'=>'50','step'=>1),
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Element Height', 'detheme_builder' ),
        'param_name' => 'vertical_padding',
        'param_holder_class'=>'vertical-padding optin-preview',
        'default' => "40",
        'type' => 'slider_value',
        'params'=>array('min'=>18,'max'=>'100','step'=>1),
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Button Width', 'detheme_builder' ),
        'param_name' => 'horizontal_padding',
        'param_holder_class'=>'horizontal-padding optin-preview',
        'default' => "16",
        'params'=>array('min'=>0,'max'=>'50','step'=>1),
        'type' => 'slider_value',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Button Border Radius', 'detheme_builder' ),
        'param_name' => 'button_radius',
        'param_holder_class'=>'border-radius optin-preview',
        'default' => "0",
        'params'=>array('min'=>0,'max'=>'50','step'=>1),
        'type' => 'slider_value',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Inputbox Radius', 'detheme_builder' ),
        'param_name' => 'input_radius',
        'param_holder_class'=>'input-radius optin-preview',
        'default' => "0",
        'params'=>array('min'=>0,'max'=>'50','step'=>1),
        'type' => 'slider_value',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Inputbox Padding Horizontal', 'detheme_builder' ),
        'param_name' => 'input_horizontal_padding',
        'param_holder_class'=>'input-horizontal-padding optin-preview',
        'default' => "15",
        'params'=>array('min'=>15,'max'=>'50','step'=>1),
        'type' => 'slider_value',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Element Margin', 'detheme_builder' ),
        'param_name' => 'element_margin',
        'param_holder_class'=>'element-margin optin-preview',
        'default' => "10",
        'params'=>array('min'=>0,'max'=>'50','step'=>1),
        'type' => 'slider_value',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Full Width Button', 'detheme_builder' ),
        'param_name' => 'expanded',
        'param_holder_class'=>'expanded-button optin-preview',
        'value' => '',
        'type' => 'check',
        'group'=>__('Form Preview', 'detheme_builder')
        ),
        array( 
        'heading' => __( 'Button Align', 'detheme_builder' ),
        'param_name' => 'button_align',
        'param_holder_class'=>'button-align optin-preview',
        'value' => array('left'=>__( 'Left', 'detheme_builder' ),'center'=>__( 'Center', 'detheme_builder' ),'right'=>__( 'Right', 'detheme_builder' )),
        'type' => 'radio',
        'default'=>'left',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Label Align', 'detheme_builder' ),
        'param_name' => 'label_align',
        'param_holder_class'=>'label-align optin-preview',
        'value' => array('left'=>__( 'Left', 'detheme_builder' ),'center'=>__( 'Center', 'detheme_builder' ),'right'=>__( 'Right', 'detheme_builder' )),
        'type' => 'radio',
        'default'=>'left',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Button Color', 'detheme_builder' ),
        'param_name' => 'button_color',
        'param_holder_class'=>'button-color optin-preview',
        'value' => "",
        'default' => "#444444",
        'type' => 'colorpicker',
        "group" => __('Form Preview', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Button Gradient Color', 'detheme_builder' ),
        'param_name' => 'gradient',
        'param_holder_class'=>'gradient-color optin-preview',
        'value' => '',
        'type' => 'check',
        'group'=>__('Form Preview', 'detheme_builder')
        ),
        array( 
        'heading' => '',
        'param_name' => 'gradient_color_to',
        'param_holder_class'=>'gradient-color-to optin-preview',
        'value' => "",
        'default' => "#fff",
        'type' => 'colorpicker',
        "group" => __('Form Preview', 'detheme_builder')
         ),
      )

 ) );

function get_button_preview($settings, $value){

    $output='<div class="optin-form">
    <div role="form">
    <div class="form-group"><input disabled="disabled" type="text" class="form-control dt_name" name="dt_name"  placeholder="'.__('Your name','detheme_builder').'" /></div>
    <div class="form-group"><input disabled="disabled" type="text" class="form-control dt_email" name="dt_email"  placeholder="'.__('Your email','detheme_builder').'" /></div>
    <div class="form-group"><button class="btn optin_button_preview">'.__( 'Button Text Color', 'detheme_builder' ).'</button></div>
    </div>
    </div>';

    print $output;
}

add_dt_field_type('button_preview','get_button_preview');


?>
