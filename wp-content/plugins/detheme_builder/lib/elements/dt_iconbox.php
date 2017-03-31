<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_iconbox extends DElement{

    function render($atts, $content = null, $base="") {

                global $DEstyle;

                wp_register_script('jquery.appear',get_dt_plugin_dir_url()."js/jquery.appear.js",array());
                wp_register_script('jquery.counto',get_dt_plugin_dir_url()."js/jquery.counto.js",array());
                wp_register_script('dt-iconbox',get_dt_plugin_dir_url()."js/dt_iconbox.js",array('jquery.appear','jquery.counto'));

                wp_enqueue_script('dt-iconbox');

                if (!isset($compile)) {$compile='';}

                extract( shortcode_atts( array(
                    'el_class'=>'',
                    'el_id'=>'',
                    'iconbox_heading' => '',
                    'color_heading'=>'',
                    'button_link' => '',
                    'button_text' => '',
                    'icon_type' => '',
                    'layout_type'=>'1',
                    'target' => '_blank',
                    'iconbox_text'=>'',
                    'link' => '',
                    'iconbox_number'=>100,
                    'spy'=>'none',
                    'icon_size'=>'',
                    'icon_color'=>'',
                    'iconbg'=>'',
                    'scroll_delay'=>300
                ), $atts,'dt_iconbox' ) );

                $content=(empty($content) && !empty($iconbox_text))?$iconbox_text:$content;

                $iconbox_number=(int)$iconbox_number;
                $color_heading=(!empty($color_heading))?" style=\"color:".$color_heading."\"":"";


                 $scollspy="";

                if(''==$el_id){
                    $el_id="module_dt_iconboxes_".getCssID();
                }

                $css_class=array('module_dt_iconboxes');

                if(''!=$el_class){
                   array_push($css_class, $el_class);
                }

                $css_style=getCssMargin($atts);

                if('none'!==$spy && !empty($spy)){

                    $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}"';

                }

                switch($layout_type){
                    case '2':
                        $output='<div class="dt-iconboxes-2 layout-'.$layout_type.'" '. $scollspy.'>
                            <div class="dt-section-icon hi-icon-wrap hi-icon-effect-5 hi-icon-effect-5a">'.((strlen($link)>0) ?"<a target='".$target."' href='".$link."'>":"").'<i class="hi-icon '.$icon_type.'"></i>'.((strlen($link)>0) ?"</a>":"").'</div>
                            <h4'.$color_heading.'>'.$iconbox_heading.'</h4>'.'<div class="dt-iconboxes-text">'.                 
                            ((!empty($content))?do_shortcode($content):"").'</div>
                            </div>';

                        if($icon_color!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes-2 i {color:".$icon_color.";}";
                        }
                        if($iconbg!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes-2:hover i {background-color:".$iconbg."!important;color: #ffffff;}";
                        }

                        break;
                    case '3':
                        $output='<div class="dt-iconboxes layout-'.$layout_type.'" '. $scollspy.'>
                            <span class="boxes">'.((strlen($link)>0) ?"<a target='".$target."' href='".$link."'>":"").'<i class="'.$icon_type.'"></i>'.((strlen($link)>0) ?"</a>":"").'</span>
                            <h3 class="dt-counter">'.$iconbox_number.'</h3>
                            <h4'.$color_heading.'>'.$iconbox_heading.'</h4><div class="dt-iconboxes-text">
                            '.((!empty($content))?do_shortcode($content):"").'</div></div>';

                        if($icon_color!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes span.boxes,#$el_id .dt-iconboxes h3 {color:".$icon_color."!important;}";
                        }
                        if($iconbg!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes.layout-3 span:hover {background-color:".$iconbg."!important;color:#fff!important;}";
                           $DEstyle[]="#$el_id .dt-iconboxes.layout-3 span:hover:after,#$el_id .dt-iconboxes.layout-3 span:hover:before{border-top-color:".$iconbg."!important;}";
                        }

                        break;
                    case '4':
                        $output='<div '. $scollspy.'><div class="dt-iconboxes-4 layout-'.$layout_type.'">
                            <div class="dt-section-icon hi-icon-wrap hi-icon-effect-5 hi-icon-effect-5d">'.((strlen($link)>0) ?"<a target='".$target."' href='".$link."'>":"").'<i class="hi-icon '.$icon_type.'"></i>'.((strlen($link)>0) ?"</a>":"").'</div>
                            <h4'.$color_heading.'>'.$iconbox_heading.'</h4>'.                 
                            '<div class="dt-iconboxes-text">'.((!empty($content))?do_shortcode($content):"").'</div>'.'
                            </div></div>';

                        if($icon_color!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes-4 i {color:".$icon_color."!important;}";
                        }
                        if($iconbg!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes-4,#$el_id .dt-iconboxes-4:hover .dt-section-icon {background-color:".$iconbg."!important;}";
                           $DEstyle[]="#$el_id .dt-iconboxes-4:hover {background-color: ".darken($iconbg,20)."!important;}";
                           $DEstyle[]="#$el_id .dt-iconboxes-4:hover .dt-section-icon:after,#$el_id .dt-iconboxes-4:hover .dt-section-icon:before {border-top-color: ".$iconbg."!important;}";
                        }

                        break;
                    case '5':
                        $output='<div class="dt-iconboxes-5 layout-'.$layout_type.'" '. $scollspy.'>
                            <div class="dt-section-icon hi-icon-wrap hi-icon-effect-5 hi-icon-effect-5a">'.((strlen($link)>0) ?"<a target='".$target."' href='".$link."'>":"").'<i class="hi-icon '.$icon_type.'"></i>'.((strlen($link)>0) ?"</a>":"").'</div>
                            <h4'.$color_heading.'>'.$iconbox_heading.'</h4>'.                 
                            '<div class="dt-iconboxes-text">'.((!empty($content))?do_shortcode($content):"").'</div>'.'
                            </div>';

                        if($icon_color!=''){
                          $DEstyle[]="#$el_id .dt-iconboxes-5 .dt-section-icon {color:".$icon_color."!important;}";
                        }
                        if($iconbg!=''){
                           $DEstyle[]=".no-touch #$el_id .dt-iconboxes-5:hover .hi-icon-effect-5 .hi-icon {background-color:".$iconbg."!important;border-color:".$iconbg."!important;}";
                        }
                        break;
                    case '6':
                        $output='<div class="dt-iconboxes layout-'.$layout_type.'" '. $scollspy.'>
                            '.((strlen($link)>0) ?"<a target='".$target."' href='".$link."'>":"").'<i class="'.$icon_type.'"></i>'.((strlen($link)>0) ?"</a>":"").'
                            <h4'.$color_heading.'>'.$iconbox_heading.'</h4><div class="dt-iconboxes-text">
                            '.((!empty($content))?do_shortcode($content):"").'</div></div>';

                        if($icon_color!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes i {color:".$icon_color."!important;}";
                        }
                        if($iconbg!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes.layout-6:hover {background-color:".$iconbg."!important;}";
                        }

                        break;
                    case '7':
                    case '8':
                        $output='<div class="dt-iconboxes layout-'.$layout_type.'" '. $scollspy.'>
                            '.((strlen($link)>0) ?"<a target='".$target."' href='".$link."'>":"").'<i class="'.$icon_type.'"></i>'.((strlen($link)>0) ?"</a>":"").'
                            <div class="text-box"><h4'.$color_heading.'>'.$iconbox_heading.'</h4>
                            '.((!empty($content))?do_shortcode($content):"").'</div></div>';

                        if($icon_color!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes i {color:".$icon_color."!important;}";
                        }

                        break;
                    default:
                        $output='<div class="dt-iconboxes layout-'.$layout_type.'" '. $scollspy.'>
                            <span class="boxes">'.((strlen($link)>0) ?"<a target='".$target."' href='".$link."'>":"").'<i class="'.$icon_type.'"></i>'.((strlen($link)>0) ?"</a>":"").'</span>
                            <h4'.$color_heading.'>'.$iconbox_heading.'</h4><div class="dt-iconboxes-text">'.
                            ((!empty($content))?do_shortcode($content):"").'</div>
                        </div>';

                        if($icon_color!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes span.boxes {color:".$icon_color.";}";
                           $DEstyle[]="#$el_id .dt-iconboxes span.boxes:hover {color:#ffffff;}";
                        }
                        if($iconbg!=''){
                           $DEstyle[]="#$el_id .dt-iconboxes span.boxes:hover {background-color:".$iconbg."!important;border-color: ".$iconbg.";}";
                           $DEstyle[]="#$el_id .dt-iconboxes span.boxes:hover:after,#$el_id .dt-iconboxes span.boxes:hover:before{border-top: 11px solid ".$iconbg."!important;}";
                        }

                        break;
                }

               $compile="<div ";
                if(''!=$el_id){
                    $compile.="id=\"$el_id\" ";
                }

                $compile.="class=\"".@implode(" ",$css_class)."\">";
                $compile.=$output."</div>";

                if(""!=$css_style){
                  $DEstyle[]="#$el_id {".$css_style."}";
                }

                if($icon_size!=''){
                   $DEstyle[]="#$el_id i {font-size:".$icon_size."px;}";
                }


                return $compile;
    }
}

add_dt_element('dt_iconbox',
  array(
    'title'=>__( 'Icon Box', 'detheme_builder' ),
    'description' => __( 'Icon box description here', 'detheme_builder' ),
    'icon'=>'dashicons-exerpt-view',
    'order'=>5,
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
                    'heading' => __( 'Icon', 'detheme_builder' ),
                    'param_name' => 'icon_type',
                    'class' => '',
                    'value'=>'',
                    'description' => __( 'Select the icon to be displayed by clicking the icon.', 'detheme_builder' ),
                    'type' => 'iconlists',
                    'default'=>'fontellopicker-picture'
                     ),     
                    array( 
                    'heading' => __( 'Icon Size', 'detheme_builder' ),
                    'param_name' => 'icon_size',
                    'class' => '',
                    'type' => 'slider_value',
                    'default' => "10",
                    'params'=>array('min'=>10,'max'=>'100','step'=>1),
                     ),     
                    array( 
                    'heading' => __( 'Layout type', 'detheme_builder' ),
                    'param_name' => 'layout_type',
                    'class' => '',
                    'param_holder_class'=>'icon-style-label',
                    'type' => 'select_layout',
                     'value'=>array(
                        '1' => '<img src="'.get_dt_plugin_dir_url().'lib/images/layout-1.png" alt="'.__('Type 1: Squared Border Icon','detheme_builder').'" />',
                        '2' => '<img src="'.get_dt_plugin_dir_url().'lib/images/layout-2.png" alt="'.__('Type 2: Circled Border Icon','detheme_builder').'"/>',
                        '3' => '<img src="'.get_dt_plugin_dir_url().'lib/images/layout-3.png" alt="'.__('Type 3: Squared Border Icon with Counter','detheme_builder').'"/>',
                        '4' => '<img src="'.get_dt_plugin_dir_url().'lib/images/layout-4.png" alt="'.__('Type 4: Squared Border Box','detheme_builder').'"/>',
                        '5' => '<img src="'.get_dt_plugin_dir_url().'lib/images/layout-5.png" alt="'.__('Type 5: Circled Border and Transparent Icon','detheme_builder').'"/>',
                        '6' => '<img src="'.get_dt_plugin_dir_url().'lib/images/layout-6.png" alt="'.__('Type 6: Squared Box With Hover Color','detheme_builder').'"/>',
                        '7' => '<img src="'.get_dt_plugin_dir_url().'lib/images/layout-7.png" alt="'.__('Type 7: Circled boxes Icon On Left','detheme_builder').'"/>',
                        '8' => '<img src="'.get_dt_plugin_dir_url().'lib/images/layout-8.png" alt="'.__('Type 8: Circled boxes Icon On Right','detheme_builder').'"/>'
                        ),
                    'default'=>'1',
                    'description' => __( 'Choose the icon layout you want to use.', 'detheme_builder' ),
                     ),     
                    array( 
                    'heading' => __( 'Iconbox heading', 'detheme_builder' ),
                    'param_name' => 'iconbox_heading',
                    'class' => '',
                    'value' => '',
                    'type' => 'textfield',
                     ),         
                    array( 
                    'heading' => __( 'Iconbox Heading Color', 'detheme_builder' ),
                    'param_name' => 'color_heading',
                    'class' => '',
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
                    'heading' => __( 'Iconbox Color', 'detheme_builder' ),
                    'param_name' => 'iconbg',
                    'value' => '',
                    'type' => 'colorpicker',
                    'dependency' => array( 'element' => 'layout_type', 'value' => array( '1', '2', '3', '4', '5', '6') )       
                     ),
                    array( 
                    'heading' => __( 'Iconbox Counter Number', 'detheme_builder' ),
                    'param_name' => 'iconbox_number',
                    'class' => '',
                    'value' => '',
                    'description' => __( 'A value will count-up.', 'detheme_builder' ),
                    'type' => 'textfield',
                    'dependency' => array( 'element' => 'layout_type', 'value' => array('3') )
                     ),         
                    array( 
                    'heading' => __( 'Iconbox text', 'detheme_builder' ),
                    'param_name' => 'content',
                    'class' => '',
                    'value' => '',
                    'type' => 'textarea_html'
                     ),         
                    array( 
                    'heading' => __( 'Link', 'detheme_builder' ),
                    'param_name' => 'link',
                    'class' => '',
                    'value' => '',
                    'type' => 'textfield',
                     ),         
                    array( 
                    'heading' => __( 'Target', 'detheme_builder' ),
                    'param_name' => 'target',
                    'class' => '',
                    'value' => array("_blank" => __("Blank",'detheme_builder'), "_self" => __("Self","detheme_builder") ),
                    'description' => __( 'Link Target', 'detheme_builder' ),
                    'type' => 'dropdown',
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


function dt_iconbox_preview($output,$content,$atts){
  extract( shortcode_atts( array(
                'icon_type' => '',
                'layout_type'=>'1',
  ), $atts,'dt_iconbox' ) );

  $values=array(
                '1'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/layout-1.png" alt="'.__('Type 1: Squared Border Icon','detheme_builder').'" />',
                '2'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/layout-2.png" alt="'.__('Type 2: Circled Border Icon','detheme_builder').'"/>',
                '3'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/layout-3.png" alt="'.__('Type 3: Squared Border Icon with Counter','detheme_builder').'"/>',
                '4'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/layout-4.png" alt="'.__('Type 4: Squared Border Box','detheme_builder').'"/>',
                '5'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/layout-5.png" alt="'.__('Type 5: Circled Border and Transparent Icon','detheme_builder').'"/>',
                '6'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/layout-6.png" alt="'.__('Type 6: Squared Box With Hover Color','detheme_builder').'"/>',
                '7'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/layout-7.png" alt="'.__('Type 7: Circled boxes Icon On Left','detheme_builder').'"/>',
                '8'=>'<img src="'.get_dt_plugin_dir_url().'lib/images/layout-8.png" alt="'.__('Type 8: Circled boxes Icon On Right','detheme_builder').'"/>'
           );

  $output="";
  $output.=__( 'Icon', 'detheme_builder' ).": <i class=\"".$icon_type."\"></i><br/>";
  $output.=$values[$layout_type];


  return $output;
}

add_dt_element_preview('dt_iconbox','dt_iconbox_preview');


?>
