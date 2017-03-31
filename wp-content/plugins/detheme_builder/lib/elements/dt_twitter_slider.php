<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_twitter_slider extends DElement {

    function render($atts, $content = null, $base=""){

        global $dt_el_id;

        wp_enqueue_script('dt-chart');

        if (!isset($compile)) {$compile='';}

        if(!isset($dt_el_id)){$dt_el_id=0;}

        $dt_el_id++;

        extract(shortcode_atts(array(

            'twitteraccount' => 'detheme_builder',
            'numberoftweets' => 4,
            'dateformat'=>'%b. %d, %Y',
            'twittertemplate' => '{{date}}<br />{{tweet}}',
            'isautoplay'=>1,
            'el_id'=>'',
            'el_class'=>'',
            'transitionthreshold'=>500

        ), $atts ,'dt_twitter_slider'));

            $twittertemplate=preg_replace('/\n/', '', trim($twittertemplate));

            if(!is_admin()){

                wp_enqueue_script( 'tweetie', get_dt_plugin_dir_url(). 'lib/twitter_slider/tweetie.js', array( 'jquery' ), '1.0', false);
                wp_enqueue_style('owl.carousel');
                wp_enqueue_script('owl.carousel');

            }

            $compile.='<div id="dt_twitter_'.$dt_el_id.'" class="dt-twitter-slider"></div>';
            $compile.='<script type="text/javascript">';
            $compile.='jQuery(document).ready(function($) {
                    \'use strict\';
                    
                    $(\'#dt_twitter_'.$dt_el_id.'\').twittie({
                        element_id: \'dt_twitter_slider_'.$dt_el_id.'\',
                        username: \''.$twitteraccount.'\',
                        count: '.$numberoftweets.',
                        hideReplies: false,
                        dateFormat: \''.$dateformat.'\',
                        template: \''.$twittertemplate.'\',
                        apiPath: \''. get_dt_plugin_dir_url(). 'lib/twitter_slider/api/tweet.php\'
                    },function(){
                        $(\'#dt_twitter_slider_'.$dt_el_id.'\').owlCarousel({
                            items       : 1, //10 items above 1000px browser width
                            itemsDesktop    : [1000,1], //5 items between 1000px and 901px
                            itemsDesktopSmall : [900,1], // 3 items betweem 900px and 601px
                            itemsTablet : [600,1], //2 items between 600 and 0;
                            itemsMobile : false, // itemsMobile disabled - inherit from itemsTablet option
                            pagination  : true,
                            autoPlay    : ' . ($isautoplay?"true":"false") . ',
                            slideSpeed  : 200,
                            paginationSpeed  : ' . $transitionthreshold . '
                        });
                    });
                });</script>'."\n";

        return $compile;


    }
}

add_dt_element('dt_twitter_slider',
 array( 
    'title' => __('DT Twitter Slider','detheme_builder'),
    'icon'  => "dashicons-twitter",
    'order'=>21,
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
        'heading' => __( 'Twitter Account','detheme_builder' ),
        'param_name' => 'twitteraccount',
        'value' => '',
        'type' => 'textfield',
        'default'=>'detheme_builder'
         ),
        array( 
        'heading' => __( 'Number of tweets to show','detheme_builder' ),
        'param_name' => 'numberoftweets',
        'value' => '',
        'type' => 'textfield',
        'default'=>4
         ),
        array( 
        'heading' => __( 'Date Format','detheme_builder' ),
        'param_name' => 'dateformat',
        'description'=>__('%d : day, %m: month in number, %b: textual month abbreviation, %B: textual month, %y: 2 digit year, %Y: 4 digit year','detheme_builder'),
        'value' => '',
        'type' => 'textfield',
        'default'=>'%b. %d, %Y'
         ),
        array( 
        'heading' => __( 'Template','detheme_builder' ),
        'param_name' => 'twittertemplate',
        'value' => '',
        'default'=>'{{date}}<br />{{tweet}}',
        'type' => 'textarea',
        'description'=>__('{{date}}: Post Date, {{tweet}}: tweet text','detheme_builder')
         ),
        array( 
        'heading' => __( 'Auto Play','detheme_builder' ),
        'param_name' => 'isautoplay',
        'description' => __( 'Set Autoplay', 'detheme_builder' ),
        'class' => '',
        'default'=>'1',
        'value'=>array(
            '1' => __('Yes','detheme_builder') ,
            '0' => __('No','detheme_builder') 
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => __( 'Transition Threshold (msec)','detheme_builder' ),
        'param_name' => 'transitionthreshold',
        'class' => '',
        'default' => '500',
        'description' => __( 'Slide speed (in millisecond). The lower value the faster slides', 'detheme_builder' ),
        'type' => 'textfield'
         ),         
        )
 ) );

?>
