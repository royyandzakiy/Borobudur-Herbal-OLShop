<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();

class DElement_dt_post extends DElement{

    function render($atts, $content = null, $base = ''){


        extract( shortcode_atts( array(
            'el_id' => '',
            'el_class'=>'',
            'spy'=>'',
            'scroll_delay'=>300,
            'perpage'=>'-1',
            'layout'=>'',
            'columns'=>'',
            'desktop_column'=>'',
            'mobile_column'=>'',
            'medium_column'=>'',
            'small_column'=>'',
            'gutter'=>0,
            'cat'=>'',
            'orderby'=>'',
            'order'=>'',
        ), $atts,'dt_post' ) );

        global $DEstyle;


        $css_class=array('dt_post');

        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getCssMargin($atts);

        if(''==$el_id && ""!=$css_style){
            $el_id="dt_post".getCssID();
        }

        $query_args=array( 
          'posts_per_page' => $perpage,
          'post_type' => 'post',
          'no_found_rows' => false,
          'post_status' => 'publish',
          'ignore_sticky_posts' => true);

        if($orderby!=''){
           $query_args['orderby']=in_array(strtolower($orderby),array('date','title','id','modified','author','comment_count','rand'))?strtolower($orderby):'date';
        }

        if(strtolower($order)!='' && in_array(strtolower($order), array('asc','desc'))){
          $query_args['order']=strtoupper($order);
        }

        if($cat!=''){
          $query_args['cat']=$cat;
        }

        wp_enqueue_script( 'isotope.pkgd' , untrailingslashit(get_dt_plugin_dir_url()).'/js/isotope.pkgd.min.js', array( ), '2.0.0', false );
        wp_enqueue_script( 'detheme-post-grid' , untrailingslashit(get_dt_plugin_dir_url()).'/js/post_grid.js', array( ), '2.0.0', false );

       $compile="<div ";
          if(''!=$el_id){
              $compile.="id=\"$el_id\" ";
          }

          $compile.="class=\"".@implode(" ",$css_class)."\" data-isotope=\"".$layout."\"".
          " data-gutter=\"".intval($gutter)."\"".
          " data-column=\"".intval($columns)."\"".
          " data-column-lg=\"".intval($desktop_column)."\"".
          " data-column-md=\"".intval($medium_column)."\"".
          " data-column-sm=\"".intval($small_column)."\"".
          " data-column-xs=\"".intval($mobile_column)."\"".
          "><div class=\"grid-container\">";

          $spydly=0;

          $query = new WP_Query($query_args);

          if ($query->have_posts()) :

            while ( $query->have_posts() ) :

           $query->the_post();

           $post=$query->post;
           $post->post_format = get_post_format();

           $scollspy="";

            if('none'!==$spy && !empty($spy)){

                $spydly=$spydly+(int)$scroll_delay;
                $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
            }

           ob_start();
            ?>

            <div class="isotope-item"<?php print $scollspy;?>>
                    <div class="isotope-inner <?php print $post->post_format;?>">
                        <?php 

                        if(!get_template_part( 'content', get_post_format())){
                          get_template_part( 'template-parts/content', get_post_format());
                        }
                        ?>
                    </div>
            </div>
<?php     
            $compile.=ob_get_contents();
            ob_end_clean();

            endwhile;

          endif;

          wp_reset_postdata();

          $compile.="</div></div>";

          if(""!=$css_style){
            $DEstyle[]="#$el_id {".$css_style."}";
          }

        return $compile;
    }
}

add_dt_element('dt_post',
  array(
    'title'=>__( 'Posts Grid','detheme_builder' ),
    'description' => __( 'Show posts in grid view', 'detheme_builder' ),
    'order'=>9,
    'icon'  => 'dashicons-screenoptions',
    'options'=>array(
      
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
                    'heading' => __( 'Category', 'detheme_builder' ),
                    'param_name' => 'cat',
                    'type' => 'categories',
                  ),
                  array( 
                    'heading' => __( 'Order By', 'detheme_builder' ),
                    'param_name' => 'orderby',
                    'type' => 'dropdown',
                    'value'=>array(
                      'id'  => __('ID','detheme_builder'),
                      'date'  => __('Date','detheme_builder'),
                      'modified'  => __('Modified Date','detheme_builder'),
                      'title' => __('Title','detheme_builder'),
                      'author'  => __('Author','detheme_builder'),
                      'comment_count' => __('Comment Count','detheme_builder'),
                      'rand'  => __('Random','detheme_builder'),
                      ),
                    'default'=>'date'
                  ),
                  array( 
                    'heading' => __( 'Order', 'detheme_builder' ),
                    'param_name' => 'order',
                    'type' => 'radio',
                    'value'=>array(
                      'asc'=>__('Ascending','detheme_builder'),
                      'desc'=>__('Descending','detheme_builder'),
                      ),
                    'default'=>'asc'
                  ),
                  array( 
                    'heading' => __( 'Total items', 'detheme_builder' ),
                    'param_name' => 'perpage',
                    'type' => 'textfield',
                    "description" => __("Set max limit for items in grid or enter -1 to display all.", "detheme_builder"),
                  ),
                  array(
                    'type' => 'dropdown',
                    'heading' => __( 'Layout mode', 'detheme_builder' ),
                    'param_name' => 'layout',
                    'value' => array(
                      'fitRows' => __( 'Fit rows', 'detheme_builder' ),
                      'masonry' => __( 'Masonry', 'detheme_builder' )
                    )
                  ),
                  array( 
                    'heading' => __( 'Gutter', 'detheme_builder' ),
                    'param_name' => 'gutter',
                    'type' => 'textfield',
                    "description" => __("Set column space", "detheme_builder"),
                  ),
                  array(
                    'type' => 'dropdown',
                    'heading' => __( 'Column', 'detheme_builder' ),
                    'param_name' => 'columns',
                    'value' => array( 6,5, 4, 3, 2, 1 ),
                    'default' => 3,
                  ),
                  array( 
                  'heading' => __( 'Desktop Column', 'detheme_builder' ),
                  'param_name' => 'desktop_column',
                  'description' => __( 'items between 992px and 1200px', 'detheme_builder' ),
                  'class' => '',
                  'value' => array( 6,5, 4, 3, 2, 1 ),
                  'type' => 'dropdown',
                  'default' => 3,
                   ),     
                  array( 
                  'heading' => __( 'Desktop Small Column', 'detheme_builder' ),
                  'param_name' => 'medium_column',
                  'description' => __( 'items between 992px and 768px', 'detheme_builder' ),
                  'class' => '',
                  'value' => array( 6,5, 4, 3, 2, 1 ),
                  'type' => 'dropdown',
                  'default' => 3,
                   ),     
                  array( 
                  'heading' => __( 'Tablet Column', 'detheme_builder' ),
                  'param_name' => 'small_column',
                  'description' => __( 'items between 768px and 480px', 'detheme_builder' ),
                  'class' => '',
                  'value' => array( 6,5, 4, 3, 2, 1 ),
                  'type' => 'dropdown',
                  'default' => 2,
                   ),     
                  array( 
                  'heading' => __( 'Mobile Column', 'detheme_builder' ),
                  'param_name' => 'mobile_column',
                  'description' => __( 'items below 480px', 'detheme_builder' ),
                  'class' => '',
                  'value' => array( 6,5, 4, 3, 2, 1 ),
                  'type' => 'dropdown',
                  'default' => 1,
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
