<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_responsivetab_item extends DElement {

    function render($atts, $content = null, $base = '') {

         extract( shortcode_atts( array(
            'title'=>'',
            'active'=>false,
            'id'=>'tabid_'
        ), $atts ,'dt_responsivetab_item') );


        $compile='<li'.(($active)?" class=\"active\"":"").'>
                        <a href="#'.$id.'">'.$title.'</a>
                  </li>';

        return $compile;

    }
} 

class DElement_dt_responsivetab extends DElement {

    function render($atts, $content = null, $base = '') {


        if(!has_shortcode($content,'dt_responsivetab_item'))
            return "";

        $regexshortcodes=
        '\\['                              // Opening bracket
        . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
        . "(dt_responsivetab_item)"                     // 2: Shortcode name
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
        wp_register_script( 'bootstrap-responsivetab', get_dt_plugin_dir_url() . 'js/responsive-tabs.js', array(), '1.0', false );
        wp_enqueue_script( 'bootstrap-responsivetab');
        wp_enqueue_style('bootstrap-tabs',get_dt_plugin_dir_url()."css/bootstrap_vertical_tab.css",array());


        extract( shortcode_atts( array(
            'spy'=>'none',
            'scroll_delay'=>300,
            'el_id'=>'',
            'el_class'=>'',
            'desktop_screen'=>'',
            'medium_screen'=>'',
            'small_screen'=>'',
            'xsmall_screen'=>'',

        ), $atts ,'dt_responsivetab' ) );

        $scrollspy="";

        $spydly=$scroll_delay;

        if('none'!==$spy && !empty($spy)){
                    $scrollspy=' data-uk-scrollspy="{cls:\''.$spy.'\',delay:'.intval($spydly).'}"';
        }

        $cn_list=array();
        $cn_preview=array();
        $cn_accordeon=array();

        $dt_tabid=getCssID();
        $itemnumber=0;


        foreach ($matches as $slideitem) {

            $slideitem[3].=($itemnumber==0)?" active=\"1\"":"";
            $slideitem[3].=" id=\"tabid_".$dt_tabid.'_'.$itemnumber."\"";

            $cn_item=do_shortcode("[dt_responsivetab_item ".$slideitem[3]."]".$slideitem[5]."[/dt_responsivetab_item]");

            $cn_preview_item='<div id="tabid_'.$dt_tabid.'_'.$itemnumber.'" class="tab-pane'.(($itemnumber==0)?" in active":"").'">'.do_shortcode($slideitem[5]).'</div>';

            array_push($cn_list, $cn_item);
            array_push($cn_preview, $cn_preview_item);

            $itemnumber++;

        }


        $css_class=array('dt_responsive_tab');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getCssMargin($atts);

        if(''==$el_id && ""!=$css_style){
            $el_id="dt_tab_wrapper".getCssID();

        }

        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        if(''!=$css_style){

          global $DEstyle;
          $DEstyle[]="#$el_id {".$css_style."}";
    
        }

        $compile.="class=\"".@implode(" ",$css_class)."\"".$scrollspy.">";


        $compile.='<ul id="tabid_'.$dt_tabid.'" class="nav nav-tabs responsive">'.@implode("\n",$cn_list).'
          </ul>'."\n".'<div class="tab-content responsive">
                    '.@implode("\n",$cn_preview).'</div>'."\n";
            
        $compile.='</div>';

        if($desktop_screen=='accordeon'){
          array_push($cn_accordeon,"'lg'");
        }

        if($medium_screen=='accordeon'){
          array_push($cn_accordeon,"'md'");
        }

        if($small_screen=='accordeon'){
          array_push($cn_accordeon,"'sm'");
        }

        if($xsmall_screen=='accordeon'){
          array_push($cn_accordeon,"'xs'");
        }
$compile.='<script type="text/javascript">
jQuery(document).ready(function($){
  $( \'#tabid_'.$dt_tabid.' a\' ).click( function ( e ) {
        e.preventDefault();
        $( this ).tab( \'show\' );
  } );';

if(count($cn_accordeon)){
$compile.='fakewaffle.responsiveTabs( $( \'#tabid_'.$dt_tabid.'\' ),['.@implode(',', $cn_accordeon).'] );';
}
$compile.='});
</script>';

  
        return $compile;
    }

}

add_dt_element('dt_responsivetab',
 array( 
    'title' => __( 'Responsive Tab', 'detheme_builder' ),
    'icon'  =>'dashicons-index-card',
    'as_parent' => 'dt_responsivetab_item',
    'order'=>8,
    'options' => array(
        array( 
        'heading' => __( 'Module Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'value' => __( 'Responsive Tab', 'detheme_builder' ),
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
        'heading' => __( 'Large Screen', 'detheme_builder' ),
        'param_name' => 'desktop_screen',
        'description' => __( 'screen width more than 992px', 'detheme_builder' ),
        'class' => '',
        'value'=>array(
            'tab'   => __('Tab','detheme_builder') ,
            'accordeon' => __('Accordion','detheme_builder') ,
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => __( 'Medium Screen', 'detheme_builder' ),
        'param_name' => 'medium_screen',
        'description' => __( 'screen width between 992px and 768px', 'detheme_builder' ),
        'class' => '',
        'value'=>array(
            'tab'   => __('Tab','detheme_builder') ,
            'accordeon' => __('Accordion','detheme_builder') ,
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => __( 'Tablet Screen', 'detheme_builder' ),
        'param_name' => 'small_screen',
        'description' => __( 'screen width between 768px and 480px', 'detheme_builder' ),
        'class' => '',
        'value'=>array(
            'tab'   => __('Tab','detheme_builder') ,
            'accordeon' => __('Accordion','detheme_builder') ,
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => __( 'Mobile Screen', 'detheme_builder' ),
        'param_name' => 'xsmall_screen',
        'description' => __( 'screen width below 480px', 'detheme_builder' ),
        'class' => '',
        'value'=>array(
            'tab'   => __('Tab','detheme_builder') ,
            'accordeon' => __('Accordion','detheme_builder') ,
            ),
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


add_dt_element('dt_responsivetab_item',
 array( 
    'title' => __( 'Tab Item', 'detheme_builder' ),
    'as_child' => 'dt_responsivetab',
    'options' => array(
        array( 
        'heading' => __( 'Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'value' => '',
        'type' => 'textfield'
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
