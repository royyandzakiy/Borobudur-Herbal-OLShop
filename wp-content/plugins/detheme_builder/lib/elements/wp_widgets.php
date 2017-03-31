<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

/* WordPress widget */

class DElement_wp_search extends DElement {


    function render($atts, $content = null, $base = '') {

      global $DEstyle;

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'wp_search'));


    $class=array('wp_search');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id){
            $el_id="wp_search_".getCssID();
     }
     
     if(''!=$css_style){
           $DEstyle[]="#$el_id {".$css_style."}";
      }


      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Search', $atts, array() );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_dt_element('wp_search',
   array( 
    'title' => "WP "._x( 'Search', 'Search widget' ),
    'icon'  => 'dashicons-wordpress-alt',
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
        'heading' => __('Title','detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'class' => '',
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
     )
);

class DElement_wp_pages extends DElement {


    function render($atts, $content = null, $base = '') {

      global $DEstyle;

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'wp_pages'));


    $class=array('wp_pages');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id){
            $el_id="wp_pages_".getCssID();
     }
     
     if(''!=$css_style){
           $DEstyle[]="#$el_id {".$css_style."}";
      }


      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Pages', $atts, array() );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_dt_element('wp_pages',
   array( 
    'title' => "WP ".__( 'Pages'),
    'description' => __( 'A list of your site&#8217;s Pages.'),
    'icon'  => 'dashicons-wordpress-alt',
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
        'heading' => __('Title','detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ), 
        array( 
        'heading' => __('Sort by','detheme_builder' ),
        'param_name' => 'sortby',
        'class' => '',
        'value' => array(
          'post_title'  => __('Page title'),
          'menu_order'  => __('Page order'),
          'ID'  => __( 'Page ID' )
          ),
        'type' => 'dropdown'
         ), 
        array( 
        'heading' => __('Exclude','detheme_builder' ),
        'param_name' => 'exclude',
        'class' => '',
        'value' => '',
        'description'=>__( 'Page IDs, separated by commas.' ),
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
     )
);

class DElement_widget_archive extends DElement {


    function render($atts, $content = null, $base = '') {

      global $DEstyle;

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'widget_archive'));


    $class=array('widget_archive');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id){
            $el_id="widget_archive_".getCssID();
     }
     
     if(''!=$css_style){
           $DEstyle[]="#$el_id {".$css_style."}";
      }


      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Archives', $atts, array() );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_dt_element('widget_archive',
   array( 
    'title' => "WP ".__('Archives'),
    'description' => __( "A monthly archive of your site&#8217;s Posts." ),
    'icon'  => 'dashicons-wordpress-alt',
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
        'heading' => __('Title','detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ), 
        array( 
        'heading' => __('Display as dropdown','detheme_builder' ),
        'param_name' => 'dropdown',
        'class' => '',
        'value' => '',
        'type' => 'check'
         ), 
        array( 
        'heading' => __('Show post counts' ),
        'param_name' => 'count',
        'class' => '',
        'value' => '',
        'type' => 'check'
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
     )
);

class DElement_widget_meta extends DElement {


    function render($atts, $content = null, $base = '') {

      global $DEstyle;

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'widget_meta'));


    $class=array('widget_meta');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id){
            $el_id="widget_meta_".getCssID();
     }
     
     if(''!=$css_style){
           $DEstyle[]="#$el_id {".$css_style."}";
      }


      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Meta', $atts, array() );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_dt_element('widget_meta',
   array( 
    'title' => "WP ".__('Meta'),
    'description' => __( "Login, RSS, &amp; WordPress.org links." ),
    'icon'  => 'dashicons-wordpress-alt',
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
        'heading' => __('Title','detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'class' => '',
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
     )
);

class DElement_widget_calendar extends DElement {


    function render($atts, $content = null, $base = '') {

      global $DEstyle;

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'scroll_delay'=>300

      ), $atts , 'widget_calendar'));


    $class=array('widget_calendar');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id){
            $el_id="widget_calendar_".getCssID();
     }
     
     if(''!=$css_style){
           $DEstyle[]="#$el_id {".$css_style."}";
      }


      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Calendar', $atts, array() );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_dt_element('widget_calendar',
   array( 
    'title' => "WP ".__('Calendar'),
    'description' => __( "A calendar of your site&#8217;s Posts." ),
    'icon'  => 'dashicons-wordpress-alt',
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
        'heading' => __('Title','detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'class' => '',
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
     )
);

class DElement_wp_categories extends DElement {


    function render($atts, $content = null, $base = '') {

      global $DEstyle;

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'count'=>'',
        'hierarchical'=>'',
        'dropdown'=>'',
        'scroll_delay'=>300

      ), $atts , 'widget_categories'));


    $class=array('widget_categories');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id){
            $el_id="widget_categories_".getCssID();
     }
     
     if(''!=$css_style){
           $DEstyle[]="#$el_id {".$css_style."}";
      }


      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Categories', $atts, array() );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_dt_element('wp_categories',
   array( 
    'title' => "WP ".__( 'Categories'),
    'description' => __( 'A list or dropdown of categories.'),
    'icon'  => 'dashicons-wordpress-alt',
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
        'heading' => __('Title','detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ), 
        array( 
        'heading' => __('Display as dropdown','detheme_builder' ),
        'param_name' => 'dropdown',
        'class' => '',
        'value' => '',
        'type' => 'check'
         ), 
        array( 
        'heading' => __('Show post counts' ),
        'param_name' => 'count',
        'class' => '',
        'value' => '',
        'type' => 'check'
         ), 
        array( 
        'heading' => __('Show hierarchy' ),
        'param_name' => 'hierarchical',
        'class' => '',
        'value' => '',
        'type' => 'check'
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
     )
);

class DElement_wp_recent_post extends DElement {


    function render($atts, $content = null, $base = '') {

      global $DEstyle;

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'number'=>'',
        'show_date'=>'',
        'scroll_delay'=>300

      ), $atts , 'widget_recent_posts'));


    $class=array('widget_recent_posts');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id){
            $el_id="widget_recent_posts_".getCssID();
     }
     
     if(''!=$css_style){
           $DEstyle[]="#$el_id {".$css_style."}";
      }


      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Recent_Posts', $atts, array('widget_id'=>$el_id) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_dt_element('wp_recent_post',
   array( 
    'title' => "WP ".__( 'Recent Posts'),
    'description' => __( 'Your site&#8217;s most recent Posts.'),
    'icon'  => 'dashicons-wordpress-alt',
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
        'heading' => __('Title','detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ), 
        array( 
        'heading' => __('Number of posts to show:' ),
        'param_name' => 'number',
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ), 
        array( 
        'heading' => __('Display post date?' ),
        'param_name' => 'show_date',
        'class' => '',
        'value' => '',
        'type' => 'check'
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
     )
);

class DElement_wp_recent_comment extends DElement {


    function render($atts, $content = null, $base = '') {

      global $DEstyle;

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'number'=>'',
        'scroll_delay'=>300

      ), $atts , 'widget_recent_comments'));


    $class=array('widget_recent_comments');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id){
            $el_id="widget_recent_comments_".getCssID();
     }
     
     if(''!=$css_style){
           $DEstyle[]="#$el_id {".$css_style."}";
      }


      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Recent_Comments', $atts, array('widget_id'=>$el_id) );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}


add_dt_element('wp_recent_comment',
   array( 
    'title' => "WP ".__( 'Recent Comments'),
    'description' => __( 'Your site&#8217;s most recent comments.'),
    'icon'  => 'dashicons-wordpress-alt',
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
        'heading' => __('Title','detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ), 
        array( 
        'heading' => __('Number of comments to show:' ),
        'param_name' => 'number',
        'class' => '',
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
     )
);

class DElement_wp_tag_cloud extends DElement {


    function render($atts, $content = null, $base = '') {

      global $DEstyle;

     extract(shortcode_atts(array(
        'el_class'=>'',
        'el_id'=>'',
        'title'=>'',
        'spy'=>'none',
        'taxonomy'=>'',
        'scroll_delay'=>300

      ), $atts , 'tag_cloud'));


    $class=array('tag_cloud');

    if(''!=$el_class){
         array_push($class, $el_class);
     }

     $css_style=getCssMargin($atts);

     if(''==$el_id){
            $el_id="tag_cloud_".getCssID();
     }
     
     if(''!=$css_style){
           $DEstyle[]="#$el_id {".$css_style."}";
      }


      $scollspy="";
      if('none'!==$spy && !empty($spy)){

         $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
      }

      $compile="<div id=\"".$el_id."\" class=\"".@implode(" ",$class)."\"".$scollspy.">";

      ob_start();

      the_widget( 'WP_Widget_Tag_Cloud', $atts, array() );
      $compile .= ob_get_clean();

      $compile.="</div>";


     return  $compile;

    }
}

add_dt_element('wp_tag_cloud',
   array( 
    'title' => "WP ".__( 'Tag Cloud'),
    'description' => __( 'A cloud of your most used tags.'),
    'icon'  => 'dashicons-wordpress-alt',
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
        'heading' => __('Title','detheme_builder' ),
        'param_name' => 'title',
        'admin_label' => true,
        'class' => '',
        'value' => '',
        'type' => 'textfield'
         ), 
        array( 
        'heading' => __('Taxonomy:' ),
        'param_name' => 'taxonomy',
        'class' => '',
        'value' => '',
        'type' => 'taxonomy'
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
     )
);
?>
