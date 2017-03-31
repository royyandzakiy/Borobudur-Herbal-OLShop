<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();


class DElement_dt_timeline_sep extends DElement {


    function render($atts, $content = null, $base = ''){

         extract(shortcode_atts(array(
            'text' => ''
        ), $atts ,'dt_timeline_sep'));

        return do_shortcode($text);
    }

}

class DElement_dt_timeline_item extends DElement {

    function preview($atts, $content = null){


      return $this->render($atts, $content);

    }

    function render($atts, $content = null, $base = ''){

        extract(shortcode_atts(array(
            'title' => '',
            'text' => '',
            'icon_type'=>'',
            'icon_box'=>'square'
        ), $atts ,'dt_timeline_item'));

        if($content=="<br />\n") $content="";

        $text=(empty($content) && !empty($text))?$text:$content;

        $compile='<div class="center-line '.$icon_box.'"><i class="'.$icon_type.'"></i></div>
                <div class="content-line">'.(($title!=='')?'<h2>'.$title.'</h2>':"").((!empty($text))?'<div class="content-text">'.do_shortcode($text).'</div>':'').'</div>';
        return $compile;
    }
}



class DElement_dt_timeline extends DElement {

    function render($atts, $content = null, $base = '') {


        $regexshortcodes=
        '\\['                              // Opening bracket
        . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
        . "(dt_timeline_item|dt_timeline_sep)"                     // 2: Shortcode name
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


        extract( shortcode_atts( array(
            'el_id' => '',
            'el_class'=>'',
            'spy'=>'none',
            'scroll_delay'=>300,
        ), $atts ,'dt_timeline') );


         global $DEstyle;

        if(!is_array($matches) || !count($matches))
                return "";

        $css_class=array('dt-timeline');
        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        if(''==$el_id){
            $el_id="dt_timeline".getCssID().time().rand(11,99);
        }

        $css_style=getCssMargin($atts);
   
        $compile="<div ";

        if(''!=$el_id){
            $compile.="id=\"$el_id\" ";
        }

        $compile.="class=\"".@implode(" ",$css_class)."\">";
        $compile.='<div class="liner">';

        $spydly=0;
        $scollspy="";

        foreach ($matches as $timelineitem) {

            $spydly=$spydly+(int)$scroll_delay;

            if('none'!==$spy && !empty($spy)){

                    $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
            }

            if($timelineitem[2]=='dt_timeline_item'):

                $param=shortcode_atts(array(
                'title' => '',
                'text' => '',
                'icon_type'=>'',
                'position'=>'left'
                ), shortcode_parse_atts($timelineitem[3]),'dt_timeline_item');

                $timelineitemcontent='<div class="time-item '.$param['position'].'" '.$scollspy.'>'.do_shortcode($timelineitem[0]).'</div>';

            else:
                $timelineitemcontent='<div class="time-separator" '.$scollspy.'>'.do_shortcode($timelineitem[0]).'</div>';
            endif;

           $compile.=$timelineitemcontent;

        }

        $compile.="</div></div>";

   
        if(""!=$css_style){
          $DEstyle[]="#$el_id {".$css_style."}";
        }

        return "<!--- start timeline -->".$compile."<!--- end timeline -->";

    }
}

add_dt_element('dt_timeline',
 array( 
    'title' => __( 'Timeline', 'detheme_builder' ),
    'as_parent' => array( 'dt_timeline_item','dt_timeline_sep'),
    'icon'  => 'dashicons-flag',
    'order'=>16,
    'options' => array(
        array( 
        'heading' => __( 'Module Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'value' => __( 'Timeline', 'detheme_builder' ),
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
        'dependency' => array( 'element' => 'spy', 'value' => array('uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
    )

 ) );


add_dt_element('dt_timeline_item',
    array( 
    'title' => __( 'Timeline Item', 'detheme_builder' ),
    'as_child' => 'dt_timeline',
    'options' => array(
        array( 
        'heading' => __( 'Layout type', 'detheme_builder' ),
        'param_name' => 'position',
        'param_holder_class'=>'item-position',
        'admin_label'=>true,
        'value' => array(
            'left'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/timeline-left.png" alt="'.__( 'Left', 'detheme_builder' ).'" />' ,
            'right' => '<img src="'.get_dt_plugin_dir_url().'lib/images/timeline-right.png" alt="'.__( 'Right', 'detheme_builder' ).'"/>' ,
            ),
        'type' => 'select_layout',
        'default'=>'left'
         ),
        array(
        'heading' => __( 'Icon Box Style', 'detheme_builder' ),
        'param_name' => 'icon_box',
        'class' => '',
        'value'=>array(
            'square'=>__('Square','detheme_builder'),
            'circle'=>__('Circle','detheme_builder'),
            ),
        'default'=>'square',
        'type' => 'radio'
        ),
        array(
        'heading' => __( 'Icon', 'detheme_builder' ),
        'param_name' => 'icon_type',
        'class' => '',
        'value'=>'',
        'description' => __( 'Select the icon to be displayed by clicking the icon.', 'detheme_builder' ),
        'type' => 'iconlists'
        ),
        array( 
        'heading' => __( 'Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label'=>true,
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Text', 'detheme_builder' ),
        'param_name' => 'content',
        'value' => '',
        'type' => 'textarea_html'
         ),
    )

 ) );


add_dt_element('dt_timeline_sep',
 array( 
    'title' => __( 'Timeline Separator', 'detheme_builder' ),
    'as_child' => 'dt_timeline',
    'options' => array(
        array( 
        'heading' => __( 'Content', 'detheme_builder' ),
        'param_name' => 'text',
        'admin_label' => true,
        'value' => '',
        'type' => 'textarea'
         ),
    )

 ) );
?>
