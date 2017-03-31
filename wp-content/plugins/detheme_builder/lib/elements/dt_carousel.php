<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_carousel extends DElement {

    function render($atts, $content = null, $base = '') {
        extract( shortcode_atts( array(
            'spy'=>'none',
            'scroll_delay'=>300,
            'pagination' => 1,
            'speed'=>800,
            'column'=>1,
            'desktop_column'=>1,
            'small_column'=>1,
            'tablet_column'=>1,
            'mobile_column'=>1,
            'pagination_type'=>'bullet',
            'pagination_image'=>null,
            'pagination_icon'=>null,
            'pagination_color'=>'',
            'pagination_size'=>'',
            'autoplay'=>0,
            'el_class'=>'',
            'el_id'=>'',
            'interval'=>1000,
        ), $atts ,'dt_carousel') );


       $pattern = get_shortcode_regex();

        if(!preg_match_all( '/' . $pattern . '/s', $content, $matches, PREG_SET_ORDER ))
            return "";

        wp_enqueue_style('owl.carousel');
        wp_enqueue_script('owl.carousel');

        $widgetID=getCssID("dt_carousel");

        $spydly=0;
        $i=0;
        $paginationthumb=array();

        $css_style=getCssMargin($atts);
        if(''==$el_id && ''!=$css_style){

            $el_id="carousel".getCssID().time().rand(11,99);
        }

        $css_class=array('owl-carousel-container');
        if(''!=$el_class){
            array_push($css_class, $el_class);
        }


    $compile="<div ";
    if(''!=$el_id){
        $compile.="id=\"$el_id\" ";
    }

    $compile.=" class=\"".@implode(" ",$css_class)."\">";

    if(""!=$css_style){
      global $DEstyle;
      $DEstyle[]="#$el_id {".$css_style."}";
    }

        $compile.='<div class="owl-carousel" id="'.$widgetID.'">';

        if($pagination_image){
            $pagination_thumb=@explode(',',$pagination_image);
        }
        if($pagination_icon){
            $pagination_icons=@explode(',',$pagination_icon);
        }

        foreach ($matches as $key => $matche) {


             $scollspy="";

            if('none'!==$spy && !empty($spy) && $i < $column){

                $spydly=$spydly+(int)$scroll_delay;
                $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
            }

            $compile.='<div class="owl-slide"'.$scollspy.'>'.do_shortcode($matche[0]).'</div>';
            $i++;

            if($pagination_type!=='bullet' && $pagination_type!=='navigation' && $pagination){

                 $thumb="";
                if($pagination_type=='image' && !empty($pagination_thumb[$key])){

                    if(!empty($pagination_thumb[$key])){

                        $image = wp_get_attachment_image_src($pagination_thumb[$key]); 

                        $thumb="<img src=\"".$image[0]."\" alt=\"\">";

                    }
                }
                elseif($pagination_type=='icon' && !empty($pagination_icons[$key])){
                    $thumb="<i class=\"".$pagination_icons[$key]."\" ></i>";
                }
                else{

                    $thumb="<span class=\"default-owl-page\">".($key+1)."</span>";

                }

                $paginationthumb[$key]="<span class=\"owl-page\">".$thumb."</span>";
            }
        }

        $compile.='</div>';

        if($pagination && $pagination_type=='bullet' && ($pagination_color!='' || $pagination_size!='')){

            $compile.="<style type=\"text/css\">#$widgetID .owl-page span{".($pagination_color!=''?"background-color:$pagination_color;border-color:$pagination_color":"").($pagination_size!=''?";width:".$pagination_size."px;height:".$pagination_size."px;border-radius:50%":"")."}</style>";
        }

        if($pagination && $pagination_type=='navigation'){

            $paginationthumb=apply_filters("dt_carousel_navigation_btn",array("<span class=\"btn-owl prev\">".__('Prev','detheme_builder')."</span>","<span class=\"btn-owl next\">".__('Next','detheme_builder')."</span>"));
        }



        if(count($paginationthumb)){

            $compile.='<div class="owl-custom-pagination">'.@implode(' ',$paginationthumb).'</div>';

        }

        $compile.='</div>';

        $script='<script type="text/javascript">'."\n".'jQuery(document).ready(function($) {
            \'use strict\';'."\n".'
            var '.$widgetID.' = jQuery("#'.$widgetID.'");
            try{
           '.$widgetID.'.owlCarousel({
                items       : '.$column.', 
                itemsDesktop    : [1200,'.$desktop_column.'], 
                itemsDesktopSmall : [1023,'.$small_column.'], // 3 items betweem 900px and 601px
                itemsTablet : [768,'.$tablet_column.'], //2 items between 600 and 0;
                itemsMobile : [600,'.$mobile_column.'], // itemsMobile disabled - inherit from itemsTablet option
                pagination  : '.(($pagination && $pagination_type=='bullet')?"true":"false").",".($autoplay?'autoPlay:'.($speed+$interval).',':'')."
                slideSpeed  : ".$speed.",paginationSpeed  : ".$speed.",rewindSpeed  : ".$speed.",";
      if(count($paginationthumb) && $pagination_type!=='bullet' && $pagination_type!=='navigation'){
                $script.='afterInit:function(el){
                  var $base=el,perpage=this.options.items,btn,currentBtn=1;
                  btn=Math.ceil(this.itemsAmount/perpage);
                  currentBtn=$(this.$owlItems[this.currentItem]).data("owl-roundPages");

                  $(\'.owl-custom-pagination .owl-page\',$base.parent()).each(function(i,el){

                          if(i >= btn ){$(el).hide();}  else{ $(el).show();}

                          if(i === currentBtn - 1 ){
                            $(this).closest(\'.owl-custom-pagination\').find(\'.owl-page\').removeClass(\'active\');
                            $(this).addClass(\'active\');
                          }
                          $(el).click(function(){
                              $(\'.owl-custom-pagination .owl-page\',$base.parent()).removeClass(\'active\');
                              $(this).addClass(\'active\');
                              $base.trigger(\'owl.goTo\',(i*perpage));
                          });
                     });
                },
                afterUpdate:function(el){
                  var $base=el,perpage=this.options.items,btn,currentBtn=1;
                  btn=Math.ceil(this.itemsAmount/perpage);

                  currentBtn=$(this.$owlItems[this.currentItem]).data("owl-roundPages");

                  $(\'.owl-custom-pagination .owl-page\',$base.parent()).each(function(i,el){

                          if(i >= btn ){$(el).hide();}  else{ $(el).show();}

                          if(i === currentBtn - 1 ){
                            $(this).closest(\'.owl-custom-pagination\').find(\'.owl-page\').removeClass(\'active\');
                            $(this).addClass(\'active\');
                          }

                          $(el).click(function(){
                              $(\'.owl-custom-pagination .owl-page\',$base.parent()).removeClass(\'active\');
                              $(this).addClass(\'active\');
                              $base.trigger(\'owl.goTo\',(i*perpage));
                          });
                     });
                }';

}
else if(count($paginationthumb) && $pagination_type=='navigation'){

                $script.='afterInit:function(el){
                  var $base=el;
                  $(\'.owl-custom-pagination .next\',$base.parent()).click(function(){
                    $base.trigger(\'owl.next\');
                  });
                  $(\'.owl-custom-pagination .prev\',$base.parent()).click(function(){
                    $base.trigger(\'owl.prev\');
                  });

                }';

}

          $script.='});';
         $script.='}
            catch(err){}
        });</script>';

        return $compile.$script;
    }
}


add_dt_element('dt_carousel',
    array( 
    'title' => __( 'Carousel', 'detheme_builder' ),
    'icon'=>'dashicons-image-flip-horizontal',
    'order'=>6,
    'is_container'=>true,
    'options' => array(
        array( 
        'heading' => __( 'Module Title', 'detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
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
        'heading' => __( 'Slide Speed', 'detheme_builder' ),
        'param_name' => 'speed',
        'class' => '',
        'default' => '800',
        'description' => __( 'Slide speed (in millisecond). The lower value the faster slides', 'detheme_builder' ),
        'type' => 'textfield'
         ),         
        array( 
        'heading' => __( 'Autoplay', 'detheme_builder' ),
        'param_name' => 'autoplay',
        'description' => __( 'Set Autoplay', 'detheme_builder' ),
        'class' => '',
        'default'=>'0',
        'value'=>array(
            '1' =>__('Yes','detheme_builder'),
            '0' =>__('No','detheme_builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => __( 'Slide Interval', 'detheme_builder' ),
        'param_name' => 'interval',
        'class' => '',
        'default' => '1000',
        'description' => __( 'Slide Interval (in millisecond)', 'detheme_builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'autoplay', 'value' => array( '1') )       
         ),         
        array( 
        'heading' => __( 'Pagination', 'detheme_builder' ),
        'param_name' => 'pagination',
        'description' => __( 'Pagination Setting', 'detheme_builder' ),
        'class' => '',
        'default'=>'1',
        'value'=>array(
            '1' => __('Show','detheme_builder'),
            '0' => __('Hidden','detheme_builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => __( 'Pagination Type', 'detheme_builder' ),
        'param_name' => 'pagination_type',
        'class' => '',
        'default'=>'bullet',
        'value'=>array(
            'bullet'  => __('Standard','detheme_builder'),
            'image' =>__('Custom Image','detheme_builder'),
            'icon'  => __('Custom Icon','detheme_builder'),
            'navigation'  => __('Navigation Button','detheme_builder') 
            ),
        'type' => 'dropdown',
        'dependency' => array( 'element' => 'pagination', 'value' => array( '1') )       
         ),     
        array( 
        'heading' => __( 'Color', 'detheme_builder' ),
        'param_name' => 'pagination_color',
        'value' => '',
        'type' => 'colorpicker',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'bullet') )       
         ),
        array( 
        'heading' => __( 'Pagination Preview', 'detheme_builder' ),
        'param_name' => 'pagination_to_preview',
        'value' => '',
        'type' => 'carousel_preview',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'bullet') )       
         ),
        array( 
        'heading' => __( 'Size', 'detheme_builder' ),
        'param_name' => 'pagination_size',
        'params' => array('min'=>12,'max'=>50,'step'=>1),
        'type' => 'slider_value',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'bullet') )       
         ),
        array( 
        'heading' => __( 'Pagination Image', 'detheme_builder' ),
        'param_name' => 'pagination_image',
        'class' => '',
        'value' => '',
        'type' => 'images',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'image') )       
         ),
        array(
        'heading' => __( 'Pagination Icon', 'detheme_builder' ),
        'param_name' => 'pagination_icon',
        'class' => '',
        'value'=>'',
        'description' => __( 'The icon you want as pagination', 'detheme_builder' ),
        'type' => 'iconlists_multi',
        'dependency' => array( 'element' => 'pagination_type', 'value' => array( 'icon') )       
        ),
        array( 
        'heading' => __( 'Number of Columns', 'detheme_builder' ),
        'param_name' => 'column',
        'description' => __( 'Number of columns on screen larger than 1200px screen resolution', 'detheme_builder' ),
        'class' => '',
        'value'=>array(
            '1' => __('One Column','detheme_builder'),
            '2' => __('Two Columns','detheme_builder'),
            '3' => __('Three Columns','detheme_builder'),
            '4' => __('Four Columns','detheme_builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => __( 'Desktop Column', 'detheme_builder' ),
        'param_name' => 'desktop_column',
        'description' => __( 'items between 1200px and 1023px', 'detheme_builder' ),
        'class' => '',
        'value'=>array(
            '1' => __('One Column','detheme_builder'),
            '2' => __('Two Columns','detheme_builder'),
            '3' => __('Three Columns','detheme_builder'),
            '4' => __('Four Columns','detheme_builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => __( 'Desktop Small Column', 'detheme_builder' ),
        'param_name' => 'small_column',
        'description' => __( 'items between 1024px and 768px', 'detheme_builder' ),
        'class' => '',
        'value'=>array(
            '1' => __('One Column','detheme_builder'),
            '2' => __('Two Columns','detheme_builder'),
            '3' => __('Three Columns','detheme_builder'),
            '4' => __('Four Columns','detheme_builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => __( 'Tablet Column', 'detheme_builder' ),
        'param_name' => 'tablet_column',
        'description' => __( 'items between 768px and 600px', 'detheme_builder' ),
        'class' => '',
        'value'=>array(
            '1' => __('One Column','detheme_builder'),
            '2' => __('Two Columns','detheme_builder'),
            '3' => __('Three Columns','detheme_builder'),
            '4' => __('Four Columns','detheme_builder')
            ),
        'type' => 'dropdown',
         ),     
        array( 
        'heading' => __( 'Mobile Column', 'detheme_builder' ),
        'param_name' => 'mobile_column',
        'description' => __( 'items below 600px', 'detheme_builder' ),
        'class' => '',
        'value'=>array(
            '1' => __('One Column','detheme_builder'),
            '2' => __('Two Columns','detheme_builder'),
            '3' => __('Three Columns','detheme_builder'),
            '4' => __('Four Columns','detheme_builder')
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


?>
