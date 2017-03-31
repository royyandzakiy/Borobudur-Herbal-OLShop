<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_pricetable_item extends DElement {

     function render($atts, $content = null, $base = ''){

       extract(shortcode_atts(array(
            'block_link' => '',
            'get_it_now_caption' => '',
            'most_popular' => '',
            'block_price' => "",
            'block_name' => "",
            'block_subtitle' => "",
            'block_symbol' => "",
            'price_colum' => "1",
            'spy'=>'none',
            'scroll_delay'=>300,
            'body_back_color'=>'',
            'header_back_color'=>'',
            'evencell_back_color'=>'',
            'oddcell_back_color'=>'',
            'identifier'=>''
        ), $atts ,'dt_pricetable_item'));

       $block_text=preg_replace(array('/<\/?p\>/','/<br \/?\>/'),"", $content);
       $price_features = @explode("\n", $block_text);

       $colomCss="";

        switch($price_colum){
            case '3':
                    $colomCss="price-3-col ";
                break;
            case '4':
                    $colomCss="price-4-col ";
                break;
            case '1':
                    $colomCss="price-3-col ";
            case '2':
                    $colomCss="price-3-col ";
                break;
            default:
                break;
        }


        $compile = '';

        $scollspy="";


        if('none'!==$spy && !empty($spy)){
            $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\''.(($scroll_delay)?', delay:'.$scroll_delay:"").'}"';
        }


        $block_price=@explode('.',$block_price);
        if (isset($block_price[1])) {
            $price=$block_price[0]."<span class=\"after-price\">".$block_price[1]."</span>";    
        } else {
            $price=$block_price[0]."<span class=\"after-price\"></span>";
        }


        $compile.='<div id="'.$identifier.'" class="'.$colomCss.(('yes'==$most_popular)?" featured":"").'"'.$scollspy.'>
                <ul class="plan">
                    '.(!empty($block_name)?'
                    <li class="hover-tip">
                        <p class="hover-tip-text"'.($header_back_color!==''?' style="background-color:'.$header_back_color.'"':"").'>'.$block_name.'</p>
                    </li>':'').'
                    <li class="plan-head"'.($body_back_color!==''?' style="background-color:'.$body_back_color.'!important;"':"").'>
                        <div class="plan-price">'.(!empty($block_symbol)?"<span>$block_symbol</span>":"").(!empty($block_price)?$price:"").'</div>
                        <div class="plan-title"><span>'.$block_subtitle.'</span></div>                        
                    </li>';
        if(count($price_features)):

            $i=0;

            foreach($price_features as $feature):

                if($feature=='') continue;
                  $color=($i%2==0)?(($oddcell_back_color!='')?" style=\"background-color:".$oddcell_back_color."\"":""):(($evencell_back_color!='')?" style=\"background-color:".$evencell_back_color."\"":"");
                  $compile.='<li'.$color.'>'.$feature.'</li>';
                  $i++;

            endforeach;
        
        endif;            
        
        if(!empty($get_it_now_caption)){
            $compile.='<li class="plan-action"'.($body_back_color!==''?' style="background-color:'.$body_back_color.'!important;"':"").'>
                        <a href="'.$block_link.'" class="btn-active">'.$get_it_now_caption.'</a>
                    </li>';
        }

        $compile.='</ul></div>';
        

        return $compile;
    }
}



class DElement_dt_pricetable extends DElement {

    function render($atts, $content = null, $base = '') {




        $regexshortcodes=
        '\\['                              // Opening bracket
        . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
        . "(dt_pricetable_item)"                     // 2: Shortcode name
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

    global $DEstyle;

    extract( shortcode_atts( array(
        'title'=>'',
        'table_column'=>'3',
        'body_back_color'=>'',
        'header_back_color'=>'',
        'evencell_back_color'=>'',
        'oddcell_back_color'=>'',
        'el_id'=>'',
        'el_class'=>''
    ), $atts ,'dt_pricetable') );

    wp_enqueue_style( 'detheme-builder');

    $css_style=getCssMargin($atts);

    if(''==$el_id && ""!=$css_style){
        $el_id="pricing-table-".getCssID().time().rand(11,99);
    }



    $content=preg_replace('/\[dt_pricetable_item/','[dt_pricetable_item price_colum="'.$table_column.'" body_back_color="'.$body_back_color.'" header_back_color="'.$header_back_color.'" evencell_back_color="'.$evencell_back_color.'" oddcell_back_color="'.$oddcell_back_color.'"', $content);

    $compile="<div ";
    if(''!=$el_id){
        $compile.="id=\"$el_id\" ";
    }

    $compile.=((""!=$el_class)?"class=\"".$el_class."\"":"").">";
    $compile.= '<div class="dt-pricing-table '.$table_column.'-column" data-column="'.$table_column.'">'.do_shortcode($content).'</div>';
    $compile.="</div>";

    if(""!=$css_style){
      $DEstyle[]="#$el_id {".$css_style."}";
    }


    return $compile;

    }
}

add_dt_element('dt_pricetable_item',
 array( 
    'title' => __( 'Price Item', 'detheme_builder' ),
    'as_child' => 'dt_pricetable',
    'options' => array(
        array( 
        'heading' => __( 'Most popular', 'detheme_builder' ),
        'param_name' => 'most_popular',
        'value' => array('yes'=>__('Yes','detheme_builder'),'no'=>__('No','detheme_builder')),
        'type' => 'radio',
        'default'=>'no'
         ),
        array( 
        'heading' => __( 'Package Name', 'detheme_builder' ),
        'param_name' => 'block_name',
        'admin_label' => true,
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Price Unit', 'detheme_builder' ),
        'param_name' => 'block_subtitle',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Currency Symbol', 'detheme_builder' ),
        'param_name' => 'block_symbol',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Price', 'detheme_builder' ),
        'param_name' => 'block_price',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Package Detail', 'detheme_builder' ),
        'param_name' => 'content',
        'value' => '',
        'description' => __( 'Type package detail in single line (without breakline/enter). Each breakline is automatically detected as new detail item', 'detheme_builder' ),
        'type' => 'textarea'
         ),
        array( 
        'heading' => __( '"Button" Link', 'detheme_builder' ),
        'param_name' => 'block_link',
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( '"Button" Text', 'detheme_builder' ),
        'param_name' => 'get_it_now_caption',
        'value' => '',
        'type' => 'textfield'
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


add_dt_element('dt_pricetable',
 array( 
    'title' => __( 'Pricing Table', 'detheme_builder' ),
    'icon'  => 'dashicons-awards',
    'as_parent' => 'dt_pricetable_item',
    'order'=>17,
    'options' => array(
        array( 
        'heading' => __( 'Module Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'value' => __( 'Pricing Table', 'detheme_builder' ),
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
        'heading' => __( 'Number of Price Column', 'detheme_builder' ),
        'param_name' => 'table_column',
        'value'=>array(
            '3' => __('Three','detheme_builder'),
            '4' => __('Four','detheme_builder'),
            ),
        'type' => 'dropdown',
        'default'=>'3'
         ),
        array( 
        'heading' => __( 'Header Background Color', 'detheme_builder' ),
        'param_name' => 'header_back_color',
        'param_holder_class'=>'header-background-color',
        'value' => "",
        'default' => "",
        'type' => 'colorpicker',
        "group" => __('Advanced', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Body Background Color', 'detheme_builder' ),
        'param_name' => 'body_back_color',
        'param_holder_class'=>'body-background-color',
        'value' => "",
        'default' => "",
        'type' => 'colorpicker',
        "group" => __('Advanced', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Odd Rows Background Color', 'detheme_builder' ),
        'param_name' => 'oddcell_back_color',
        'param_holder_class'=>'oddcell-background-color',
        'value' => "",
        'default' => "",
        'type' => 'colorpicker',
        "group" => __('Advanced', 'detheme_builder')
         ),
        array( 
        'heading' => __( 'Even Rows Background Color', 'detheme_builder' ),
        'param_name' => 'evencell_back_color',
        'param_holder_class'=>'evencell-background-color',
        'value' => "",
        'default' => "",
        'type' => 'colorpicker',
        "group" => __('Advanced', 'detheme_builder')
         ),
    )
 ) );


?>
