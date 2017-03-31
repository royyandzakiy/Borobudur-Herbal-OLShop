<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_section_separator extends DElement {

    function render($atts, $content = null, $base = ''){

      global $DEstyle;

        extract( shortcode_atts( array(
        'separator' => '5',
        'separatorcolor' => 'none',
        'backgroundcolor' => 'none',
        'el_id'=>'',
        'el_class'=>''
        ), $atts,'dt_section_separator' ) );

        if ($backgroundcolor!='' and $backgroundcolor!='none') {
            $backgroundcolor = "#".preg_replace('/#/', '',$backgroundcolor);
        }

        if ($separatorcolor!='' and $separatorcolor!='none') {
            $separatorcolor = '#' .preg_replace('/#/', '',$separatorcolor);
        }

        $css_class=array('section-separator');


       if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getCssMargin($atts);

       if(''==$el_id){
            $el_id="separator-".getCssID();
        }

         $compile="<section ";
        if(''!=$el_id){
              $compile.="id=\"$el_id\" ";
        }

        $compile.='class="'.@implode(" ",$css_class).'"';

        switch ($separator) {
          case 1:
            $compile .= 
                    ' style="background-color:'.$backgroundcolor.'; height: 100px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="smallTriangleColorUp2">
                            <path d="M46 101 L50 25 L54 101 Z" fill="'.$separatorcolor.'" />
                        </svg>
                    </section>';
            break;
          case 2:
            $compile .= 
                    ' style="background-color:'.$backgroundcolor.'; height: 100px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="smallTriangleColorDown2">
                            <path d="M46 -1 L50 75 L54 -1 Z" fill="'.$separatorcolor.'" />
                        </svg>
                    </section>';
            break;
          case 3:
            $compile .= 
                    ' style="background-color:'.$backgroundcolor.'; height: 100px; position: relative; text-align: center;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" fill="'.$separatorcolor.'" />
                        </svg>
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" style="position: absolute; top: 0; left: 0;">
                            <path d="M0 50 L100 50 L100 100 L0 100 Z" fill="'.$separatorcolor.'" />
                        </svg>
                    </section>';
            break;
          case 4:
            $compile .= 
                    ' style="background:'.$backgroundcolor.'; height: 100px; position: relative; text-align: center;">
                        <svg preserveAspectRatio="none" viewBox="0 1 100 100" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" style="position: absolute; top: -50%; left: 0;">
                            <path d="M0 50 L100 50 L100 100 L0 100 Z" fill="'.$separatorcolor.'" />
                        </svg>
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100" version="1.1" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="50" cy="50" r="50" fill="'.$separatorcolor.'" />
                        </svg>
                    </section>';
            break;
          case 5:
            $compile .= 
                    ' style="background-color:'.$backgroundcolor.'; height: 100px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="bigTriangleDown">
                            <path d="M0 -1 L50 99 L100 -1 Z" fill="'.$separatorcolor.'" />
                        </svg>
                    </section>';
            break;
          case 6:
            $compile .= 
                    ' style="background-color:'.$backgroundcolor.'; height: 100px;">
                        <svg preserveAspectRatio="none" viewBox="0 0 100 100" height="100" width="100%" version="1.1" xmlns="http://www.w3.org/2000/svg" id="bigTriangleUp">
                            <path d="M0 101 L50 1 L100 101 Z" fill="'.$separatorcolor.'" />
                        </svg>
                    </section>';
            break;
          default:
            $compile = '';
            break;
        }


      if(""!=$css_style){
        $DEstyle[]="#$el_id {".$css_style."}";
      }


      return $compile ;
    }

}

add_dt_element('dt_section_separator',
 array( 
    'title' => __( 'Section Separator', 'detheme_builder' ),
    'icon'  =>'dashicons-editor-insertmore',
    'base' => 'dt_section_separator',
    'order'=>11,
    'class' => '',
    'options' => array(  
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
        'heading' => __( 'Separator Type', 'detheme_builder' ),
        'param_name' => 'separator',
        'class' => '',
        'param_holder_class'=>'section-heading-style',
        'type' => 'select_layout',
         'value'=>array(
            '1'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/separator_1.jpg" alt="'.__('Type 1','detheme_builder').'" />',
            '2'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/separator_2.jpg" alt="'.__('Type 2','detheme_builder').'"/>',
            '3'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/separator_3.jpg" alt="'.__('Type 3','detheme_builder').'"/>',
            '4'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/separator_4.jpg" alt="'.__('Type 4','detheme_builder').'"/>',
            '5'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/separator_5.jpg" alt="'.__('Type 5','detheme_builder').'"/>',
            '6'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/separator_6.jpg" alt="'.__('Type 6','detheme_builder').'"/>'
            )
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
        'heading' => __( 'Separator Color', 'detheme_builder' ),
        'param_name' => 'separatorcolor',
        'value' => '',
        'type' => 'colorpicker',
         ),
         array( 
        'heading' => __( 'Background Color', 'detheme_builder' ),
        'param_name' => 'backgroundcolor',
        'value' => '',
        'type' => 'colorpicker'
         )
    )
 ) 
);
?>
