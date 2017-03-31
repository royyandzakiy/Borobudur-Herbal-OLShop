<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_verticaltab_item extends DElement {

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'title'=>'',
            'sub_title'=>'',
            'link'=>'',
            'icon_type'=>'',
            'active'=>false,
            'id'=>'vstabid_'
        ), $atts ,'dt_verticaltab_item') );


        $compile='<li id="tab_'.$id.'"'.(($active)?" class=\"active\"":"").'>
                        <div class="vt_text">
                            <h2 class="vt_title"><a href="#'.$id.'" data-toggle="tab">'.$title.'</a></h2>
                            <p class="vt_description">'.$sub_title.'</p>
                        </div>
                        <div class="vt_icon">
                        <a href="#'.$id.'" data-toggle="tab"><i class="'.$icon_type.'"></i></a>
                        </div>
                        </li>';

        return $compile;

    }
} 

class DElement_dt_verticaltab extends DElement {

    function render($atts, $content = null, $base = '') {


        if(!has_shortcode($content,'dt_verticaltab_item'))
            return "";

        $regexshortcodes=
        '\\['                              // Opening bracket
        . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
        . "(dt_verticaltab_item)"                     // 2: Shortcode name
        . '(?![\\w-])'                       // Not followed by word character or hyphen
        . '('                                // 3: Unroll the loop: Inside the opening shortcode tag
        .     '[^\\]\\/]*'                   // Not a closing bracket or forward slash
        .     '(?:'
        .         '\\/(?!\\])'               // A forward slash not followed by a closing bracket
        .         '[^\\]\\/]*'               // Not a closing bracket or forward slash
        .     ')*?'
        . ')'
        . '(?:'
        .     '(\\/)'                        // 4: Self closing tag ...
        .     '\\]'                          // ... and closing bracket
        . '|'
        .     '\\]'                          // Closing bracket
        .     '(?:'
        .         '('                        // 5: Unroll the loop: Optionally, anything between the opening and closing shortcode tags
        .             '[^\\[]*+'             // Not an opening bracket
        .             '(?:'
        .                 '\\[(?!\\/\\2\\])' // An opening bracket not followed by the closing shortcode tag
        .                 '[^\\[]*+'         // Not an opening bracket
        .             ')*+'
        .         ')'
        .         '\\[\\/\\2\\]'             // Closing shortcode tag
        .     ')?'
        . ')'
        . '(\\]?)';                          // 6: Optional second closing brocket for escaping shortcodes: [[tag]]


        if(!preg_match_all( '/' . $regexshortcodes . '/s', $content, $matches, PREG_SET_ORDER ))
                return "";

        wp_enqueue_script( 'bootstrap' , get_dt_plugin_dir_url().'js/bootstrap.js', array( 'jquery' ), '3.0', false );
        wp_register_script( 'bootstrap-tabcollapse', get_dt_plugin_dir_url() . 'js/bootstrap-tabcollapse.js', array(), '1.0', false );
        wp_enqueue_script( 'bootstrap-tabcollapse');
        wp_enqueue_style('bootstrap-tabs',get_dt_plugin_dir_url()."css/bootstrap_vertical_tab.css",array());


        extract( shortcode_atts( array(
            'nav_position' => 'left',
            'spy'=>'none',
            'scroll_delay'=>300,
            'el_id'=>'',
            'el_class'=>''

        ), $atts ,'dt_verticaltab' ) );

         $leftspy="";
         $rightspy="";
         $spydly=$scroll_delay;

        if('none'!==$spy && !empty($spy)){
            switch($spy){
                case 'uk-animation-slide-left':
                        $leftspy='data-uk-scrollspy="{cls:\''.$spy.'\',delay:'.($spydly+600).'}"';
                        $rightspy='data-uk-scrollspy="{cls:\'uk-animation-slide-right\',delay:'.$spydly.'}"';
                    break;
                case 'uk-animation-slide-right':
                       $leftspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.($spydly+600).'}"';
                       $rightspy='data-uk-scrollspy="{cls:\'uk-animation-slide-left\',delay:'.$spydly.'}"';
                    break;
                default:
                    $leftspy='data-uk-scrollspy="{cls:\''.$spy.'\',delay:'.$spydly.'}"';
                    $rightspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
                    break;
            }
        }

        $cn_list=array();
        $cn_preview=array();

        $dt_vsliderid=getCssID();
        $itemnumber=0;


        foreach ($matches as $slideitem) {

            $slideitem[3].=($itemnumber==0)?" active=\"1\"":"";
            $slideitem[3].=" id=\"vstabid_".$dt_vsliderid.'_'.$itemnumber."\"";

            $cn_item=do_shortcode("[dt_verticaltab_item ".$slideitem[3]."]".$slideitem[5]."[/dt_verticaltab_item]");
            $cn_preview_item='<div id="vstabid_'.$dt_vsliderid.'_'.$itemnumber.'" class="tab-pane fade'.(($itemnumber==0)?" in active":"").'">'.do_shortcode($slideitem[5]).'</div>';

            array_push($cn_list, $cn_item);
            array_push($cn_preview, $cn_preview_item);

            $itemnumber++;

        }

        $css_class=array('dt_vertical_tab');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getCssMargin($atts);

        if(''==$el_id && ""!=$css_style){
            $el_id="dt_tab_wrapper".getCssID().time().rand(11,99);

        }

        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        if(''!=$css_style){

          global $DEstyle;
          $DEstyle[]="#$el_id {".$css_style."}";
    
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";


        $compile.='<ul id="vstabid_'.$dt_vsliderid.'" class="nav nav-tabs vertical-nav-tab tab-'.$nav_position.'" '.$leftspy.'>'.@implode("\n",$cn_list).'
          </ul>'."\n".'<div class="tab-content vertical-tab-content tab-'.$nav_position.'" '.$rightspy.'>
                    '.@implode("\n",$cn_preview).'</div>'."\n";
            
        $compile.='</div>';

$compile.='<script type="text/javascript">
jQuery(document).ready(function($){
        $(\'#vstabid_'.$dt_vsliderid.'\').tabCollapse();
});
</script>';

  
        return $compile;




    }

}

add_dt_element('dt_verticaltab',
 array( 
    'title' => __( 'Vertical Tab', 'detheme_builder' ),
    'as_parent' => 'dt_verticaltab_item',
    'icon'=>'dashicons-image-flip-vertical',
    'order'=>7,
    'options' => array(
        array( 
        'heading' => __( 'Module Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'value' => __( 'Vertical Tab', 'detheme_builder' ),
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
        'heading' => __( 'Navigation Position', 'detheme_builder' ),
        'param_name' => 'nav_position',
        'class' => '',
        'value'=>array(
            'left'  => __('Left','detheme_builder') ,
            'right' => __('Right','detheme_builder') 
            ),
        'description' => __( 'Navigation position', 'detheme_builder' ),
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
 ) );


add_dt_element('dt_verticaltab_item',
 array( 
    'title' => __( 'Tab Item', 'detheme_builder' ),
    'as_child' => 'dt_verticaltab',
    'options' => array(
        array(
        'heading' => __( 'Icon', 'detheme_builder' ),
        'param_name' => 'icon_type',
        'class' => '',
        'value'=>'',
        'description' => __( 'Select the icon to be displayed by clicking the icon.', 'detheme_builder' ),
        'type' => 'iconlists'
        ),
        array( 
        'heading' => __( 'Main Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Sub Title', 'detheme_builder' ),
        'param_name' => 'sub_title',
        'admin_label' => true,
        'value' => '',
        'type' => 'textarea'
         ),
        array( 
        'heading' => __( 'Content', 'detheme_builder' ),
        'param_name' => 'content',
        'class' => '',
        'value' => '',
        'type' => 'textarea_html'
         )
        )
 ) );

?>
