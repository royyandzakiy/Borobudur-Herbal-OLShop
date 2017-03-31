<?php
/**
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
 * @version     1.3.6
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_countdown extends DElement {

  function render($atts, $content = null ,$base=""){

      global $DEstyle;


     extract(shortcode_atts(array(

          'year'=>'',
          'month'=>'',
          'date'=>'',
          'time'=>date('H:s',current_time( 'timestamp', 0 )),
          'url'=>'',
          'countdown_type'=>'fixed',
          'countdown_box_color'=>'',
          'countdown_text_color'=>'',
          'countdown_label_color'=>'',
          'dot_color'=>'',
          'el_id'=>'',
          'countdown_box_size'=>'',
          'relative_time'=>0,
          'cookie_lifetime'=>1,
          'el_class'=>''

      ), $atts ,'dt_countdown'));

      if(!stripos($time, ":")){
          $time.=":00";
      }

      $message=str_replace(array("\n","\t"),array("",""), do_shortcode($content));

      $current_offset = get_option('gmt_offset');
      $dt_el_id=getCssID();

     if($countdown_type=='evergreen'){
          $dateTo = "+".intval($relative_time)." minutes";

          $page_id=get_the_ID();
          $cookie_name='countdown_page'.$page_id."el".$dt_el_id;

          if(isset($_COOKIE[$cookie_name])){
              $timeCurrent=$_COOKIE[$cookie_name];
          }
          else{
              $timeCurrent=time();
              print '<script type="text/javascript">document.cookie="'.$cookie_name.'='.$timeCurrent.'; expires='.date('r',strtotime(intval($cookie_lifetime).' hours')).'; path=/";</script>';
          }
     }
     else{
         $dateTo = "$month $date $year $time";
         $timeCurrent = (!empty($current_offset))?time()+($current_offset*3600):time();
     }



     $timeTo= strtotime( $dateTo );

      $css_class=array('dt-countdown');
      if(''!=$el_class){
          array_push($css_class, $el_class);
      }

      if($countdown_box_size=='small' || $countdown_box_size=='medium'){
          array_push($css_class, 'dt-countdown-'.$countdown_box_size);
      }

      if(''==$el_id){
          $el_id="dt_ct".$dt_el_id.time().rand(11,99);
      }

      $css_style=getCssMargin($atts);


     $compile="";

      if($countdown_type=='evergreen'){
           $until=($relative_time * 60) - (time() - $timeCurrent);
      }
      else{
          $until=$timeTo-$timeCurrent;
      }


     if( $until < 1 ){

      if(!empty($url)){

          $compile.='<meta http-equiv="refresh" content="5;URL='.$url.'" />';
      }



      $compile.="<div ";
      if(''!=$el_id){ $compile.="id=\"$el_id\" ";}
      $compile.="class=\"".@implode(" ",$css_class)."\">";
      $compile.='<div id="countdown_'.$el_id.'" class="countdown">'.$message.'</div></div>';

     }
     else{


       $suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

      wp_register_style('jquery.countdown',get_dt_plugin_dir_url()."css/jquery.countdown.css",array(),false);
      wp_enqueue_style('jquery.countdown');

      wp_register_script('jquery.plugin',get_dt_plugin_dir_url()."js/jquery.plugin".$suffix.".js",array('jquery'));
      wp_enqueue_script('jquery.plugin');
      wp_register_script('jquery.countdown',get_dt_plugin_dir_url()."js/jquery.countdown".$suffix.".js",array('jquery.plugin'));
      wp_enqueue_script('jquery.countdown');


      $compile.="<script type=\"text/javascript\">".'jQuery(document).ready(function($) {'.
              '\'use strict\';'.
              '$(\'#countdown_'.$el_id.'\').countdown({until: +'.$until.
                  ((!empty($message) && empty($url))?",expiryText:'".$message."'":"").
                  ((!empty($url))?",expiryUrl:'".esc_url($url)."'":"").'}); '.
              '});</script>';


     $compile.="<div ";
     if(''!=$el_id){ $compile.="id=\"$el_id\" ";}
     $compile.="class=\"".@implode(" ",$css_class)."\">";

     $compile.='<div id="countdown_'.$el_id.'" class="countdown"></div></div>';

         if(!empty($countdown_box_color)){
              $DEstyle[]='#countdown_'.$el_id.' .countdown-amount{border-color: '.$countdown_box_color.';}';
          }

          if(!empty($countdown_text_color)){
              $DEstyle[]='#countdown_'.$el_id.' .countdown-amount{color: '.$countdown_text_color.';}';
          }
          if(!empty($countdown_label_color)){
              $DEstyle[]='#countdown_'.$el_id.' .countdown-period{color: '.$countdown_label_color.';}';
          }

      }

     if(count($css_style)){
            $DEstyle[]="#$el_id {".$css_style."}";
     }

     return $compile;

  }

}

add_dt_element('dt_countdown',
     array( 
    'title' => __( 'Countdown Timer', 'detheme_builder' ),
    'icon' =>'dashicons-clock',
    'order'=>20,
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
        'heading' => __( 'Box Size', 'detheme_builder' ),
        'param_name' => 'countdown_box_size',
        'value' => array(
          'default'=>__('Default','detheme_builder'),
          'medium'=>__('Medium','detheme_builder'),
          'small'=>__('Small','detheme_builder'),
          ),
        'default' => "default",
        'type' => 'radio',
         ),
        array( 
        'heading' => __( 'Countdown Box Color', 'detheme_builder' ),
        'param_name' => 'countdown_box_color',
        'param_holder_class'=>'countdown-box-color',
        'value' => "",
        'default' => "#f16338",
        'type' => 'colorpicker',
         ),
        array( 
        'heading' => __( 'Countdown Text Color', 'detheme_builder' ),
        'param_name' => 'countdown_text_color',
        'param_holder_class'=>'countdown-text-color',
        'value' => "",
        'default' => "",
        'type' => 'colorpicker',
         ),
        array( 
        'heading' => __( 'Countdown Label Color', 'detheme_builder' ),
        'param_name' => 'countdown_label_color',
        'param_holder_class'=>'countdown-label-color',
        'value' => "",
        'default' => "",
        'type' => 'colorpicker',
         ),
        array( 
        'heading' => __( 'Countdown Type', 'detheme_builder' ),
        'param_name' => 'countdown_type',
        'admin_label'=>false,
        'value' => array('fixed'=>__('Fixed Date','detheme_builder'),'evergreen'=>__('Evergreen','detheme_builder')),
        'default' => "fixed",
        'type' => 'radio',
         ),
         array( 
        'heading' => __( 'Relative Time (minutes)','detheme_builder' ),
        'param_name' => 'relative_time',
        'description' => __( 'Relative time from 1st page visit in minutes', 'detheme_builder' ),
        'class' => '',
        'default'=>0,
        'type' => 'textfield',
        'dependency' => array('element' => 'countdown_type','value' => 'evergreen')
         ),     
         array( 
        'heading' => __( 'Cookie Lifetime (Hours)','detheme_builder' ),
        'param_name' => 'cookie_lifetime',
        'description' => __( 'How long cookie store 1st page visit', 'detheme_builder' ),
        'class' => '',
        'default'=>1,
        'type' => 'textfield',
        'dependency' => array('element' => 'countdown_type','value' => 'evergreen')
         ),     
        array( 
        'heading' => __( 'Time','detheme_builder' ),
        'param_name' => 'time',
        'description' => sprintf(__( 'Time format hour:minute. example: %s', 'detheme_builder' ),date('H:s',current_time( 'timestamp', 0 ))),
        'class' => '',
        'default'=>date('H:s',current_time( 'timestamp', 0 )),
        'type' => 'textfield',
        'dependency' => array('element' => 'countdown_type','value' => 'fixed')
         ),     
         array( 
        'heading' => __( 'Day','detheme_builder'),
        'param_name' => 'date',
        'description' => sprintf(__( 'Fill with the day of the event. example: %s', 'detheme_builder' ),date('d',current_time( 'timestamp', 0 ))),
        'class' => '',
        'default'=>date('d',current_time( 'timestamp', 0 )),
        'type' => 'textfield',
        'dependency' => array('element' => 'countdown_type','value' => 'fixed')
         ),     
         array( 
        'heading' => __( 'Month','detheme_builder' ),
        'param_name' => 'month',
        'description' => __( 'Choose the month of the event', 'detheme_builder' ),
        'class' => '',
        'default'=>date('F',current_time( 'timestamp', 0 )),
        'value'=>array(
            'January'   => __('January'),
            'February'  => __('February'),
            'March'     => __('March'),
            'April'     => __('April'),
            'May'       => __('May'),
            'June'      => __('June'),
            'July'      => __('July'),
            'August'    => __('August'),
            'September' => __('September'),
            'October'   => __('October'),
            'November'  => __('November'),
            'December'  => __('December')
            ),
        'type' => 'dropdown',
        'dependency' => array('element' => 'countdown_type','value' => 'fixed')
         ),     
         array( 
        'heading' => __( 'Year','detheme_builder' ),
        'param_name' => 'year',
        'description' => sprintf(__( 'Fill with the year of the event. example: %d', 'detheme_builder' ),date('Y',current_time( 'timestamp', 0 ))),
        'class' => '',
        'default'=>date('Y',current_time( 'timestamp', 0 )),
        'type' => 'textfield',
        'dependency' => array('element' => 'countdown_type','value' => 'fixed')
         ),     
        array( 
        'heading' => __( 'On Complete Countdown Message', 'detheme_builder' ),
        'param_name' => 'content',
        'value' => '',
        'description' => __( 'The content will show after countdown expired. Simple html allowed', 'detheme_builder' ),
        'type' => 'textarea_html'
         ),
        array( 
        'heading' => __( 'Redirect Url after countdown is completed', 'detheme_builder' ),
        'param_name' => 'url',
        'description' => __( 'If countdown expired, the page will be redirected to this url', 'detheme_builder' ),
        'value' => '',
        'type' => 'textfield'
         )
    )

 ) );
?>
