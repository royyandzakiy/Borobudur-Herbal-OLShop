<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_team_custom_item extends DElement{

    function render($atts, $content = null, $base=''){

          global $DEstyle;

           wp_enqueue_style('detheme-builder');

            if (!isset($compile)) {$compile='';}

            extract(shortcode_atts(array(
                'title' => '',
                'sub_title' => '',
                'text' => '',
                'layout_type'=>'fix',
                'image_url'=>'',
                'facebook'=>'',
                'twitter'=>'',
                'gplus'=>'',
                'pinterest'=>'',
                'linkedin'=>'',
                'website'=>'',
                'email'=>'',
                'social_link'=>'show',
                'spy'=>'none',
                'scroll_delay'=>300,
                'el_id'=>'',
                'el_class'=>'',
                'color'=>'',
                'titlecolor'=>'',
                'separator_color'=>'',
                'subtitlecolor'=>''
            ), $atts, 'dt_team_custom_item'));

            $scollspy="";
            if('none'!==$spy && !empty($spy)){
                $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';

            }

            $social_lists="<ul class=\"profile-scocial\">".
                (($facebook)?"<li><a href=\"".$facebook."\" target=\"_blank\"><i class=\"fontelloicon-facebook-squared\"></i></a></li>":"").
                (($twitter)?"<li><a href=\"".$twitter."\" target=\"_blank\"><i class=\"fontelloicon-twitter-squared\"></i></a></li>":"").
                (($gplus)?"<li><a href=\"".$gplus."\" target=\"_blank\"><i class=\"fontelloicon-gplus-squared\"></i></a></li>":"").
                (($linkedin)?"<li><a href=\"".$linkedin."\" target=\"_blank\"><i class=\"fontelloicon-linkedin-5\"></i></a></li>":"").
                (($pinterest)?"<li><a href=\"".$pinterest."\" target=\"_blank\"><i class=\"fontelloicon-pinterest-squared\"></i></a></li>":"").
                (($website)?"<li><a href=\"".$website."\" target=\"_blank\"><i class=\"fontelloicon-globe\"></i></a></li>":"").
                (($email)?"<li><a href=mailto:".$email." target=\"_blank\"><i class=\"fontelloicon-mail-alt\"></i></a></li>":"").
                "</ul>";


            if('fix'==$layout_type){


                if(!empty($image_url)){
                    $image = wp_get_attachment_image_src($image_url,'full',false); 
                    $image_url=$image[0];
                }

                $custom_team='<div class="left-item"><img src="'.$image_url.'" alt="" /></div>
                <div class="right-item"><h2 class="profile-title">'.$title.'</h2><hr/><h3 class="profile-position">'.$sub_title.'</h3>
                '.(!empty($text)?'<div class="text">'.$text.'</div>':"").('show'==$social_link?$social_lists:"").'
                </div>';

            }
            else{

                if(!empty($image_url)){
                    $image = wp_get_attachment_image_src($image_url,'full',false); 
                    $image_url=$image[0];
                }

            $custom_team='<div class="profile">
                    <figure>
                        <div class="top-image">
                            <img src="'.$image_url .'" class="img-responsive" alt=""/>
                        </div>
                        <figcaption>
                            <h3><span class="profile-heading">'.$title.'</span></h3>
                            <span class="profile-subheading">'.$sub_title.'</span>
                            '.(!empty($text)?'<p>'.$text.'</p>':"");

             $custom_team.= $social_lists.'<div class="figcap"></div>
                        </figcaption>
                    </figure>
                </div>';


            }

        $css_class=array('dt_team_custom_item',$layout_type,'clearfix');
        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getCssMargin($atts);

        if(''==$el_id){
            $el_id="dt-custom-team".getCssID();
        }


        $compile="<div ";
          if(''!=$el_id){
              $compile.="id=\"$el_id\" ";
          }

        if(""!=$css_style){
          $DEstyle[]="#$el_id {".$css_style."}";
        }

        if(""!=$titlecolor){
          $DEstyle[]="#$el_id .profile-title {color:".$titlecolor."}";
        }

        if(""!=$separator_color){
          $DEstyle[]="#$el_id hr:after {background-color:".$separator_color."}";
        }

        if(""!=$subtitlecolor){
          $DEstyle[]="#$el_id .profile-position {color:".$subtitlecolor." !important;}";
        }

        if(""!=$color){
          $DEstyle[]="#$el_id .text,#$el_id .profile-scocial i {color:".$color."}";
        }

        $compile.='class="'.@implode(" ",$css_class).'" '.$scollspy.'>';
        $compile.=$custom_team;
        $compile.='</div>';


        return  $compile;

    }

}

add_dt_element('dt_team_custom_item',
 array( 
    'title' => __( 'Custom Team Item', 'detheme_builder' ),
    'icon'  =>'dashicons-id',
    'order'=>19,
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
        'heading' => __( 'Main Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label'=>true,
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Sub Title', 'detheme_builder' ),
        'param_name' => 'sub_title',
        'admin_label'=>true,
        'value' => '',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Description', 'detheme_builder' ),
        'param_name' => 'text',
        'value' => '',
        'type' => 'textarea'
         ),
        array( 
        'heading' => __( 'Image', 'detheme_builder' ),
        'param_name' => 'image_url',
        'class' => '',
        'value' => '',
        'type' => 'image'
         ),
         array( 
        'heading' => __( 'Title Color', 'detheme_builder' ),
        'param_name' => 'titlecolor',
        'value' => '',
        'type' => 'colorpicker'
         ),
         array( 
        'heading' => __( 'Sub Title Color', 'detheme_builder' ),
        'param_name' => 'subtitlecolor',
        'value' => '',
        'type' => 'colorpicker'
         ),
        array( 
        'heading' => __( 'Separator Color', 'detheme_builder' ),
        'param_name' => 'separator_color',
        'value' => '',
        'type' => 'colorpicker',
        'dependency' => array( 'element' => 'use_decoration', 'value' => array('1')),        
         ),
        array( 
        'heading' => __( 'Social Link', 'detheme_builder' ),
        'param_name' => 'social_link',
        'value'=>array('show'=> __('Show','detheme_builder'),'hide'=> __('Hidden','detheme_builder')),
        'type' => 'dropdown'
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
        'heading' => __('Website','detheme_builder'),
        'param_name' => 'website',
        'class' => 'fontelloicon-globe',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
         ),
        array( 
        'heading' => __('Email','detheme_builder'),
        'param_name' => 'email',
        'class' => 'fontelloicon-mail-alt',
        'value' => '',
        'type' => 'iconfield',
        'dependency' => array( 'element' => 'social_link','value'=>array('show'))       
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
