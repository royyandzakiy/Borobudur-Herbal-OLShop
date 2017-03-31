<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();


/* social icon */

class DElement_dt_social extends DElement {

    function preview($atts, $content = null) {
      return $this->render($atts, $content);
    }

    function render($atts, $content = null, $base = '') {

      global $DEstyle;

     extract(shortcode_atts(array(
        'facebook'=>'',
        'twitter'=>'',
        'gplus'=>'',
        'pinterest'=>'',
        'linkedin'=>'',
        'color'=>'',
        'shape'=>'circle',
        'size'=>'medium',
        'bg_color'=>'',
        'align'=>'center',
        'el_class'=>'',
        'el_id'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'dt_social'));


    $class=array('dt-social',"shape-".$shape,"size-".$size,"align-".$align);

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id){
            $el_id="social_".getCssID();
     }
     
     if(''!=$css_style){
           $DEstyle[]="#$el_id {".$css_style."}";
      }

      if(''!=$color){
           $DEstyle[]="#$el_id li a{color:".$color.";}";
      }
      if(''!=$bg_color){
           $DEstyle[]="#$el_id li{background-color:".$bg_color.";}";
      }

      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<ul id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">".
      (($facebook)?"<li><a href=\"".$facebook."\" target=\"_blank\"><i class=\"fontelloicon-facebook-1\"></i></a></li>":"").
      (($twitter)?"<li><a href=\"".$twitter."\" target=\"_blank\"><i class=\"fontelloicon-twitter-1\"></i></a></li>":"").
      (($gplus)?"<li><a href=\"".$gplus."\" target=\"_blank\"><i class=\"fontelloicon-gplus\"></i></a></li>":"").
      (($linkedin)?"<li><a href=\"".$linkedin."\" target=\"_blank\"><i class=\"fontelloicon-linkedin-1\"></i></a></li>":"").
      (($pinterest)?"<li><a href=\"".$pinterest."\" target=\"_blank\"><i class=\"fontelloicon-pinterest\"></i></a></li>":"").
      "</ul>";


     return  $compile;

    }
}

add_dt_element('dt_social',
   array( 
    'title' => __( 'Social Box', 'detheme_builder' ),
    'icon'  =>'dashicons-groups',
    'order'=>13,
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
        'heading' => 'Facebook',
        'param_name' => 'facebook',
        'class' => 'fontelloicon-facebook',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => 'Twitter',
        'param_name' => 'twitter',
        'class' => 'fontelloicon-twitter-5',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => 'Google Plus',
        'param_name' => 'gplus',
        'class' => 'fontelloicon-gplus',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => 'Pinterest',
        'param_name' => 'pinterest',
        'class' => 'fontelloicon-pinterest-2',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => 'Linkedin',
        'param_name' => 'linkedin',
        'class' => 'fontelloicon-linkedin-5',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
         array( 
            'heading' => __( 'Size', 'detheme_builder' ),
            'param_name' => 'size',
            'value' => array(
              'small'=>__('Small','detheme_builder'),
              'medium'=>__('Medium','detheme_builder'),
              'large'=>__('Large','detheme_builder'),
              ),
            'default'=>'medium',
            'type' => 'radio',
          ),     

         array( 
            'heading' => __( 'Shape', 'detheme_builder' ),
            'param_name' => 'shape',
            'value' => array(
                      'square'=>__('Square','detheme_builder'),
                      'circle'=>__('Circle','detheme_builder'),
                      "rounded"=>__("Rounded",'detheme_builder'),
              ),
            'default'=>'square',
            'type' => 'radio',
          ),     
        array( 
            'heading' => __( 'Align', 'detheme_builder' ),
            'param_name' => 'align',
            'value' => array('left'=>__( 'Left', 'detheme_builder' ),'center'=>__( 'Center', 'detheme_builder' ),'right'=>__( 'Right', 'detheme_builder' )),
            'type' => 'radio',
            'default'=>'center'
         ),
        array( 
        'heading' => __( 'Color', 'detheme_builder' ),
        'param_name' => 'color',
        'class' => '',
        'value' => '',
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => __( 'Background Color', 'detheme_builder' ),
        'param_name' => 'bg_color',
        'class' => '',
        'value' => '',
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



?>
