<?php
/*
 * @package     WordPress
 * @subpackage  DT Page Builder
 * @author      support@omnipress.co
 * @version     1.3.2
 * @since       1.0.0
*/
defined('DTPB_BASENAME') or die();


if (is_plugin_active('omnipress-portfolio/omnipress_port.php') || is_plugin_active('omnitheme-portfolio/omnitheme_port.php') || is_plugin_active('detheme-portfolio/detheme_port.php') || post_type_exists( 'port' ) || is_plugin_active('detheme_gt3/gt3_builder.php')) {

    class DElement_dt_portfolio extends DElement {

        function render($atts, $content = null, $base=""){

        extract(shortcode_atts(array(

            'portfolio_cat' => '',
            'portfolio_num' => 10,
            'speed'=>800,
            'autoplay'=>'0',
            'spy'=>'none',
            'scroll_delay'=>300,
            'layout'=>1,
            'el_id'=>'',
            'el_class'=>'',
            'scroll_page'=>'',
            'interval'=>1000,

        ), $atts, 'dt_portfolio'));

        $queryargs = array(
                'post_type' => 'port',
                'no_found_rows' => false,
                'meta_key' => '_thumbnail_id',
                'posts_per_page'=>$portfolio_num,
                'compile'=>'',
                'script'=>''
            );

        if(!empty($portfolio_cat)){

                $queryargs['tax_query']=array(
                                array(
                                    'taxonomy' => 'portcat',
                                    'field' => 'id',
                                    'terms' =>$portfolio_cat
                                )
                            );
        }

        $query = new WP_Query( $queryargs );    
        $compile="";

        if ( $query->have_posts() ) :


            $spydly=0;
            $portspty=0;


            wp_enqueue_style('owl.carousel');
            wp_enqueue_script('owl.carousel');


            $css_style=getCssMargin($atts);

            if(''==$el_id && ""!=$css_style){
                $el_id="dt_portfolio-".getCssID().time().rand(11,99);
            }


            $widgetID=sanitize_key($el_id."_carousel");

            $modal_effect = apply_filters('dt_portfolio_modal_effect','md-effect-15');

            $compile="<div ";

            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            $compile.='class="dt-portfolio-container portfolio-type-'.(($layout=='2')?"text":"image").'">
            <div class="owl-carousel-navigation prev-button">
               <a class="btn btn-owl prev btn-color-secondary skin-dark">'.__('<i class="icon-left-open-big"></i>','detheme_builder').'</a>
            </div>
            <div class="owl-carousel" id="'.$widgetID.'">';

                    while ( $query->have_posts() ) : 
                    
                        $query->the_post();
                        
                        $terms = get_the_terms(get_the_ID(), 'portcat' );
                        $term_lists=array();

                        if ( !empty( $terms ) ) {
          
                              foreach ( $terms as $term ) {
                                $cssitem[] =sanitize_html_class($term->slug, $term->term_id);
                                $term_lists[]="<a href=\"".get_term_link( $term)."\">".$term->name."</a>";
                              }

                        }

                        $imageId=get_post_thumbnail_id(get_the_ID());
                        $featured_image  = get_post( $imageId );

                        if (isset($featured_image->guid)) {
                            $imgurl = aq_resize($featured_image->guid, 0, 300,true);

                            $spydly=$spydly+(int)$scroll_delay;

                            $scollspy="";

                           if('none'!==$spy && !empty($spy) && $portspty < 5){

                                $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
                            }

                            $compile.='<div class="portfolio-item" '.$scollspy.'>';


                            if('1'==$layout){

                               $compile.='<div class="post-image-container">'.((isset($imgurl) && !empty($imgurl))?'<div class="post-image">
                                        <img src="'.esc_url($imgurl).'" alt="'.get_the_title().'" /></div>':'').'
                                    <div class="imgcontrol tertier_color_bg_transparent">
                                        <div class="portfolio-termlist">'.(count($term_lists)?@implode(', ',$term_lists):"").'</div>
                                        <div class="portfolio-title">'.get_the_title().'</div>
                                        <div class="imgbuttons">
                                            <a class="btn icon-link secondary_color_button " href="'.get_the_permalink().'"></a>
                                        </div>
                                    </div>
                                </div>';
                            

                            }
                            else{

                               $compile.='<div class="post-image-container">'.((isset($imgurl) && !empty($imgurl))?'<div class="post-image">
                                        <img src="'.esc_url($imgurl).'" alt="'.get_the_title().'" /></div>':'').'
                                    <div class="imgcontrol tertier_color_bg_transparent">
                                        <div class="imgbuttons">
                                            <a class="btn icon-link secondary_color_button " href="'.get_the_permalink().'"></a>
                                        </div>
                                    </div>
                                </div>';

                                $compile.='<div class="portfolio-description">';
                                $compile.='<div class="portfolio-termlist">'.(count($term_lists)?@implode(', ',$term_lists):"").'</div>';
                                $compile.='<div class="portfolio-title">'.get_the_title().'</div>';
                                $compile.='<div class="portfolio-excerpt"><p>'.get_the_excerpt().'</p>';
                                $compile.='<a href="'.get_the_permalink().'" class="read_more" title="'.esc_attr(sprintf(__( 'Detail to %s', 'detheme_builder' ), the_title_attribute(array('echo'=>false)))).'">'.__('Read more', 'detheme_builder').'<i class="icon-right-dir"></i></a>';
                                $compile.='</div></div>';

                            }

                            $compile.='</div>';


                            $portspty++;




                          }
                    endwhile;

             $compile.="</div>
                         <div class=\"owl-carousel-navigation next-button\">
                           <a class=\"btn btn-owl next btn-color-secondary skin-dark\">".__('<i class="icon-right-open-big"></i>','detheme_builder')."</a>
            </div></div>";

            $script='<script type="text/javascript">'."\n".'jQuery(document).ready(function($) {
                \'use strict\';'."\n".'
                var '.$widgetID.' = jQuery("#'.$widgetID.'");
                try{
               '.$widgetID.'.owlCarousel({
                    items       : 5, 
                    pagination  : false,'.($autoplay?'autoPlay:'.($speed+$interval).',':'')."
                    slideSpeed  : ".$speed.",paginationSpeed  : ".$speed.",rewindSpeed  : ".$speed.",";
          if($scroll_page=='1'){
                    $script.="scrollPerPage  : true,";

          }

              $script.='});'."\n".'
        '.$widgetID.'.closest(\'.dt-portfolio-container\').find(".next").click(function(){
            '.$widgetID.'.trigger(\'owl.next\');
          });
        '.$widgetID.'.closest(\'.dt-portfolio-container\').find(".prev").click(function(){
            '.$widgetID.'.trigger(\'owl.prev\');
          });';

             $script.='}
                catch(err){}
            });</script>';

         $compile.=$script;   

        if(''!=$css_style){
            global $DEstyle;
            $DEstyle[]="#$el_id {".$css_style."}";
        }

        endif;
        wp_reset_query();


        return $compile;
      }

    }

  add_dt_element('dt_portfolio',
    array( 
    'title' => __( 'Portfolio Image', 'detheme_builder' ),
    'icon'  => 'dashicons-schedule',
    'order'=>10,
    'class' => '',
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
        'heading' => __( 'Category', 'detheme_builder' ),
        'param_name' => 'portfolio_cat',
        'value' => '',
        'type' => 'portfolio_categories'
         ),
        array( 
        'heading' => __( 'Number of Posts to be displayed', 'detheme_builder' ),
        'param_name' => 'portfolio_num',
        'value' => '10',
        'type' => 'textfield'
         ),
        array( 
        'heading' => __( 'Slide Speed', 'detheme_builder' ),
        'param_name' => 'speed',
        'class' => '',
        'value' => '800',
        'description' => __( 'Slide speed (in millisecond). The lower value the faster slides', 'detheme_builder' ),
        'type' => 'textfield'
         ),         
        array( 
        'heading' => __( 'Scroll Per Page', 'detheme_builder' ),
        'param_name' => 'scroll_page',
        'class' => '',
        'default'=>0,
        'value'=>array(
            '1'=>__('Yes','detheme_builder'),
            '0'=>__('No','detheme_builder')
            ),
        'type' => 'radio',
         ),
        array( 
        'heading' => __( 'Autoplay', 'detheme_builder' ),
        'param_name' => 'autoplay',
        'description' => __( 'Set Autoplay', 'detheme_builder' ),
        'class' => '',
        'default'=>'0',
        'value'=>array(
            '1' => __('Yes','detheme_builder') ,
            '0' => __('No','detheme_builder') 
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
        'value' => '300',
        'description' => __( 'The number of delay the animation effect of the icon. in milisecond', 'detheme_builder' ),
        'type' => 'textfield',
        'dependency' => array( 'element' => 'spy', 'value' => array( 'uk-animation-fade', 'uk-animation-scale-up', 'uk-animation-scale-down', 'uk-animation-slide-top', 'uk-animation-slide-bottom', 'uk-animation-slide-left', 'uk-animation-slide-right') )       
         ),     
        )
 ) );

    function get_portfolio_categories($settings, $value ) {

       $dependency = create_dependency_param( $settings );

       $output="";
        $args = array(
          'orderby' => 'name',
          'show_count' => 0,
          'pad_counts' => 0,
          'hierarchical' => 0,
          'taxonomy' => 'portcat',
          'title_li' => ''
        );


        $categories=get_categories($args);


    $output .= '<select name="'.$settings['param_name'].'" class="'.$settings['param_name'].' '.$settings['type'].' ">';
    $output .= '<option value="">'.__('All Categories','detheme_builder').'</option>';

    if(count($categories)):

    foreach ( $categories as $category ) {

        $selected = '';
        if ($value!=='' && $category->term_id === $value) {
            $selected = ' selected="selected"';
        }
        $output .= '<option value="'.$category->term_id.'"'.$selected.'>'.$category->name.'</option>';
    }

    endif;

    $output .= '</select>';

    print $output;
    }

    add_dt_field_type( 'portfolio_categories', 'get_portfolio_categories');
}

?>
