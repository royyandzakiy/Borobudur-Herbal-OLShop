<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_partner_item extends DElement {

    function preview($atts, $content = null){

       extract(shortcode_atts(array(
            'title' => '',
            'image_url' => '',
            'website' => '',
        ), $atts ,'dt_partner_item'));

        $compile="";


        if(!empty($image_url)){
            $image = wp_get_attachment_image_src($image_url,'thumbnail',false); 
            $image_url=$image[0];
        }


        $compile.="<img src=\"".$image_url."\" alt=\"".$title."\"/>";

       return $compile;
    }


    function render($atts, $content = null, $base = ''){

       extract(shortcode_atts(array(
            'title' => '',
            'image_url' => '',
            'website' => '',
        ), $atts ,'dt_partner_item'));

        $compile="";


        if(!empty($image_url)){
            $image = wp_get_attachment_image_src($image_url,'full',false); 
            $image_url=$image[0];
        }


        $compile.=(''!=$website?"<a href=\"".$website."\">":"")."<img src=\"".$image_url."\" alt=\"".$title."\"/>".(''!=$website?"</a>":"");

       return $compile;

    }
}

class DElement_dt_partner extends DElement {

        function render($atts, $content = null, $base = '') {

        $regexshortcodes=
        '\\['                              // Opening bracket
        . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
        . "(dt_partner_item)"                     // 2: Shortcode name
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
            'spy'=>'none',
            'scroll_delay'=>300,
            'column'=>'4',
            'el_class'=>'',
            'el_id'=>''
        ), $atts ,'dt_partner') );


        if(!is_array($matches) || !count($matches))
                return "";

        $css_class=array('dt-partner');

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

        $spydly=0;
        $scollspy="";

         $class='partner-item ';

        switch ($column) {
              case 2:
                    $class.='col-md-6 col-sm-6 col-xs-6';
                break;
              case 3:
                    $class.='col-md-4 col-sm-6 col-xs-6';
                break;
              case 4:
                    $class.='col-lg-3 col-md-4 col-sm-6 col-xs-6';
                break;
              case 6:
                    $class.='col-lg-2 col-md-3 col-sm-6 col-xs-6';
                break;
              case 1:
              default:
                    $class.='col-sm-12';
                break;
        }

        foreach ($matches as $partneritem) {

            $spydly=$spydly+(int)$scroll_delay;

           if('none'!==$spy && !empty($spy)){

                $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
            }

           $compile.='<div class="border-right '.$class.'" '.$scollspy.'>'.do_shortcode($partneritem[0]).'</div>';

        }


         if(count($matches) % $column){
           $compile.=str_repeat("<div class=\"dummy ".$class."\"></div>",$column - (count($matches) % $column));
         }


        $compile.="</div>";

        return "<!--- start partner -->".$compile."<!--- end partner -->";

    }
}

add_dt_element('dt_partner_item',
 array( 
    'title' => __( 'Partner Item', 'detheme_builder' ),
    'as_child' => 'dt_partner',
    'options' => array(
        array( 
        'heading' => __( 'Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label'=>true,
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Image/Logo', 'detheme_builder' ),
        'param_name' => 'image_url',
        'class' => '',
        'value' => '',
        'type' => 'image'
         ),
        array( 
        'heading' => __( 'Website', 'detheme_builder' ),
        'param_name' => 'website',
        'value' => '',
        'type' => 'textfield'
         )
    )

 ) );

add_dt_element('dt_partner',
 array( 
    'title' => __( 'Partner', 'detheme_builder' ),
    'icon'  =>'dashicons-businessman',
    'as_parent' => 'dt_partner_item',
    'order'=>18,
    'options' => array(
        array( 
        'heading' => __( 'Module Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'value' => __( 'Partner', 'detheme_builder' ),
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
        'heading' => __( 'Number of Columns', 'detheme_builder' ),
        'param_name' => 'column',
        'description' => __( 'Number of columns on screen larger than 1200px screen resolution', 'detheme_builder' ),
        'class' => '',
        'value'=>array(
            '1' => __('One Column','detheme_builder') ,
            '2' => __('Two Columns','detheme_builder') ,
            '3' => __('Three Columns','detheme_builder') ,
            '4' => __('Four Columns','detheme_builder') ,
            '6' => __('Six Columns','detheme_builder') 
            ),
        'type' => 'dropdown',
        'default'=>'4'
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
?>
