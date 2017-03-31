<?php
defined('ABSPATH') or die();

function year_shortcode() {
	$year = date('Y');
	return $year;
}

add_shortcode('current-year', 'year_shortcode');

function site_title_shortcode() {
	$result = get_bloginfo('name');
	return $result;
}

add_shortcode('site-title', 'site_title_shortcode');

function site_tagline_shortcode() {
	$result = get_bloginfo('description');
	return $result;
}

add_shortcode('site-tagline', 'site_tagline_shortcode');

function site_url_shortcode($atts) {
	extract( shortcode_atts( array(
		'title' => home_url(),
		'target' => '',
		'class' => '',
	), $atts, 'site-url' ) );

	$result = '<a href="'.home_url().'" title="'.esc_attr($title).'" target="'.esc_attr($target).'" class="'.sanitize_html_class($class).'">'.$title.'</a>';
	return $result;
}

add_shortcode('site-url', 'site_url_shortcode');

function wp_url_shortcode($atts) {
	extract( shortcode_atts( array(
		'title' => site_url(),
		'target' => '',
		'class' => '',
	), $atts, 'wp-url' ) );

	$result = '<a href="'.site_url().'" title="'.esc_attr($title).'" target="'.esc_attr($target).'" class="'.sanitize_html_class($class).'">'.$title.'</a>';
	return $result;
}

add_shortcode('wp-url', 'wp_url_shortcode');

function theme_url_shortcode($atts) {
	extract( shortcode_atts( array(
		'title' => get_template_directory_uri(),
		'target' => '',
		'class' => '',
	), $atts, 'theme-url' ) );

	$result = '<a href="'.get_template_directory_uri().'" title="'.esc_attr($title).'" target="'.esc_attr($target).'" class="'.sanitize_html_class($class).'">'.$title.'</a>';
	return $result;
}

add_shortcode('theme-url', 'theme_url_shortcode');

function login_url_shortcode($atts) {
	extract( shortcode_atts( array(
		'title' => wp_login_url(),
		'target' => '',
		'class' => '',
	), $atts, 'login-url' ) );

	$result = '<a href="'.wp_login_url().'" title="'.esc_attr($title).'" target="'.esc_attr($target).'" class="'.sanitize_html_class($class).'">'.$title.'</a>';
	return $result;
}

add_shortcode('login-url', 'login_url_shortcode');

function logout_url_shortcode($atts) {
	extract( shortcode_atts( array(
		'title' => wp_logout_url(),
		'target' => '',
		'class' => '',
	), $atts, 'logout-url' ) );

	$result = '<a href="'.wp_logout_url().'" title="'.esc_attr($title).'" target="'.esc_attr($target).'" class="'.sanitize_html_class($class).'">'.$title.'</a>';
	return $result;
}
add_shortcode('logout-url', 'logout_url_shortcode');

/* woocommerce handle                                 		*/
/* this feature available when woocommerce plugin activated */
/*															*/

if (is_plugin_active('woocommerce/woocommerce.php')) {

function krypton_featured_products($atts, $content = null){

		global $woocommerce_loop,$dt_featured,$krypton_Scripts;;

        if(!isset($dt_featured)){

            $dt_featured=1;

        }

        else{

            $dt_featured++;

        }


		extract( shortcode_atts( array(
			'per_page' 	=> '12',
			'columns' 	=> '4',
			'orderby' 	=> 'date',
			'order' 	=> 'desc'
		), $atts ) );

		$args = array(
			'post_type'				=> 'product',
			'post_status' 			=> 'publish',
			'ignore_sticky_posts'	=> 1,
			'posts_per_page' 		=> $per_page,
			'orderby' 				=> $orderby,
			'order' 				=> $order,
			'meta_query'			=> array(
				array(
					'key' 		=> '_visibility',
					'value' 	=> array('catalog', 'visible'),
					'compare'	=> 'IN'
				),
				array(
					'key' 		=> '_featured',
					'value' 	=> 'yes'
				)
			)
		);

		if(!in_array($columns,array(1,2,3,4,6))){
			$columns=3;
		}

		$products = new WP_Query( apply_filters( 'woocommerce_shortcode_products_query', $args, $atts ) );

		$widgetID="featured".$dt_featured;
		$woocommerce_loop['columns'] = 1;

		if ( $products->have_posts() ) :

            wp_register_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array( 'jquery' ), '', false );
            wp_enqueue_script( 'owl.carousel');


	          $compile='<div class="dt-featured-product">
               <div class="row"><div id="'.$widgetID.'" class="shop-items">';

			while ( $products->have_posts() ) : $products->the_post(); 

					ob_start();
					wc_get_template_part( 'content', 'product' );
					$wooitem=ob_get_contents();
					ob_end_clean();
					$compile.=$wooitem;

				endwhile; // end of the loop.



			wp_reset_postdata();

            $compile.='</div></div></div>';

            $script='jQuery(document).ready(function($) {
            \'use strict\';
            var '.$widgetID.' = $("#'.$widgetID.'.shop-items");
		    var navigation=$(\'<div></div>\').addClass(\'owl-carousel-navigation\'),
	        prevBtn=$(\'<a></a>\').addClass(\'btn btn-owl\'),
	        nextBtn=prevBtn.clone();
	        navigation.append(prevBtn.addClass(\'prev\'),nextBtn.addClass(\'next\'));
	        '.$widgetID.'.parent().append(navigation);

            try{
           '.$widgetID.'.owlCarousel({
                items       : '.$columns.', itemsDesktop    : [1200,'.max(min('3',$columns-1),1).'], itemsDesktopSmall : [1023,'.max(min('2',$columns-1),1).'], itemsTablet : [768,'.max(min('2',$columns-1),1).'], itemsMobile : [600,1], pagination  : false, slideSpeed  : 400});
            nextBtn.click(function(){
                '.$widgetID.'.trigger(\'owl.next\');
              });
            prevBtn.click(function(){
                '.$widgetID.'.trigger(\'owl.prev\');
              });
            '.$widgetID.'.owlCarousel(\'reload\');
            }
            catch(err){}

            });';

        array_push($krypton_Scripts,$script);

		return '<div class="container woocommerce">' . $compile . '</div>';
		endif;
		wp_reset_postdata();

		return "";
}

function krypton_product_categories($atts, $content = null){

		global $woocommerce_loop,$dt_featured,$krypton_Scripts;;

        if(!isset($dt_featured)){

            $dt_featured=1;

        }

        else{

            $dt_featured++;

        }

		extract( shortcode_atts( array(
			'number'     => null,
			'orderby'    => 'name',
			'order'      => 'ASC',
			'columns' 	 => '4',
			'hide_empty' => 1,
			'parent'     => ''
		), $atts ) );

		if ( isset( $atts[ 'ids' ] ) ) {
			$ids = explode( ',', $atts[ 'ids' ] );
			$ids = array_map( 'trim', $ids );
		} else {
			$ids = array();
		}

		$hide_empty = ( $hide_empty == true || $hide_empty == 1 ) ? 1 : 0;

		// get terms and workaround WP bug with parents/pad counts
		$args = array(
			'orderby'    => $orderby,
			'order'      => $order,
			'hide_empty' => $hide_empty,
			'include'    => $ids,
			'pad_counts' => true,
			'child_of'   => $parent
		);

		$product_categories = get_terms( 'product_cat', $args );

		if ( $parent !== "" ) {
			$product_categories = wp_list_filter( $product_categories, array( 'parent' => $parent ) );
		}

		if ( $hide_empty ) {
			foreach ( $product_categories as $key => $category ) {
				if ( $category->count == 0 ) {
					unset( $product_categories[ $key ] );
				}
			}
		}

		if ( $number ) {
			$product_categories = array_slice( $product_categories, 0, $number );
		}

		$widgetID="featured".$dt_featured;
		$woocommerce_loop['columns'] = 1;
		$compile='';


		$woocommerce_loop['loop'] = $woocommerce_loop['column'] = '';

		if ( $product_categories ) {


            wp_register_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array( 'jquery' ), '', false );
            wp_enqueue_script( 'owl.carousel');


	        $compile='<div class="dt-shop-category">
               <div class="row"><div id="'.$widgetID.'" class="shop-items">';


			foreach ( $product_categories as $category ) {

					ob_start();
					wc_get_template( 'content-product_cat_carousel.php', array(
					'category' => $category
				) );

					$wooitem=ob_get_contents();
					ob_end_clean();
					$compile.=$wooitem;


			}

			woocommerce_reset_loop();

	        $compile.='</div></div></div>';

            $script='jQuery(document).ready(function($) {
            \'use strict\';
            var '.$widgetID.' = $("#'.$widgetID.'.shop-items");
		    var navigation=$(\'<div></div>\').addClass(\'owl-carousel-navigation\'),
	        prevBtn=$(\'<a></a>\').addClass(\'btn btn-owl\'),
	        nextBtn=prevBtn.clone();
	        navigation.append(prevBtn.addClass(\'prev\'),nextBtn.addClass(\'next\'));
	        '.$widgetID.'.parent().append(navigation);

            try{
           '.$widgetID.'.owlCarousel({
                items       : '.$columns.', itemsDesktop    : [1200,'.max(min('3',$columns-1),1).'], itemsDesktopSmall : [1023,'.max(min('2',$columns-1),1).'], itemsTablet : [768,'.max(min('2',$columns-1),1).'], itemsMobile : [600,1], pagination  : false, slideSpeed  : 400});
            nextBtn.click(function(){
                '.$widgetID.'.trigger(\'owl.next\');
              });
            prevBtn.click(function(){
                '.$widgetID.'.trigger(\'owl.prev\');
              });
            '.$widgetID.'.owlCarousel(\'reload\');
            }
            catch(err){}

            });';

        array_push($krypton_Scripts,$script);

		return '<div class="container woocommerce">' . $compile . '</div>';

		}

		woocommerce_reset_loop();

		return '';

}

function remove_do_shortcode($content){

	add_shortcode('featured_products', 'krypton_featured_products');
	add_shortcode('product_categories', 'krypton_product_categories');
	return $content;
}

add_filter('the_content', 'remove_do_shortcode', 1); 

}

function load_shop_slider(){
	global $krypton_config;
	$krypton_config['show-shop-slide']=true;


	if (!is_plugin_active('woocommerce/woocommerce.php')) 
	return "";

	wp_enqueue_style( 'shop-slide', get_template_directory_uri() . '/css/shop_slider.css', array());
	ob_start();
	locate_template( 'shopslide.php',true);
	$content=ob_get_contents();
	ob_end_clean();

	return $content;
}

add_shortcode('shopslider','load_shop_slider');

if (is_plugin_active('detheme_builder/detheme_builder.php')) {


	add_action('init','krypton_dt_builder_addon');   


	function krypton_dt_builder_addon(){


		function krypton_dt_progressbar_item_shortcode($output,$content="",$atts=array()){

	      global $DEstyle;

	        extract( shortcode_atts( array(
	          'el_id' => '',
	          'el_class'=>'',
 		      'icon_type' => '',
	          'width' => '',
	          'title' => '',
	          'unit' => '',
	          'color'=>'#1abc9c',
	          'bg'=>'#ecf0f1',
	          'label'=>'',
	          'icon_color'=>'',
	          'iconbg'=>'',
	          'value' => '10',
	        ), $atts,'dt_progressbar_item' ) );

	        $css_class=array('progress_bars');

	        if(''!=$el_class){
	            array_push($css_class, $el_class);
	        }

	        if(''==$el_id){
	            $el_id="progress-bar".getCssID();
	        }

	       $css_style=getCssMargin($atts);

		    $compile="<div ";
	        if(''!=$el_id){
	              $compile.="id=\"$el_id\" ";
	        }

	         $compile.='class="'.@implode(" ",$css_class).'">';

 			$compile.='<div class="progress_bar"><div class=\'progress_title\'><h4>'.$title.'</h4></div>
                            <span class=\'progress_number\'><span>'.$value.'</span>'.$unit.'</span> 
                            <div class=\'progress_content_outer\'>
                                <div data-percentage=\''.esc_attr($value).'\' data-active="'.esc_attr($color).'" data-nonactive="'.esc_attr($bg).'" class=\'progress_content\'></div>
                            </div>
                       </div>';

	        $compile.="</div>";

	        if(''!=$css_style){
	          $DEstyle[]="#$el_id {".$css_style."}";
	        }

		    if(""!=$label){
		       $DEstyle[]="#$el_id .progress_title * {color:".$label."}";
		    }

	        return $compile;

		}


		remove_dt_element_option('dt_progressbar_item','icon_type');
		remove_dt_element_option('dt_progressbar_item','icon_color');
		remove_dt_element_option('dt_progressbar_item','iconbg');

		add_dt_element_render('dt_progressbar_item','krypton_dt_progressbar_item_shortcode');


		function krypton_dt_circlebar_item_shortcode($output,$content="",$atts=array()){
	      global $DEstyle;

	        extract( shortcode_atts( array(
	          'el_id' => '',
	          'el_class'=>'',
	          'unit' => '',
	          'title' => '',
	          'item_number'=>'1',
	          'value' => '10',
	          'size'=>'',
	          'color'=>'#19bd9b',
	          'bg'=>'',
	          'el_id'=>'',
	          'el_class'=>'',
	          'label_color'=>'',
	          'unit_color'=>''
	        ), $atts,'dt_circlebar_item' ) );

	        $css_class=array('pie_chart_holder','normal');

	        if(''!=$el_class){
	            array_push($css_class, $el_class);
	        }

	        if(''==$el_id){
	            $el_id="progress-bar".getCssID();
	        }

	       $css_style=getCssMargin($atts);

		    $compile="<div ";
	        if(''!=$el_id){
	              $compile.="id=\"$el_id\" ";
	        }

	         $compile.='class="'.@implode(" ",$css_class).'">';

             $compile.='<canvas class="doughnutChart" data-noactive="'.esc_attr($bg).'" data-active="'.esc_attr($color).'" data-percent=\''.esc_attr($value).'\'></canvas>
                            <div class=\'pie_chart_text\'>
                                <span class=\'tocounter\'>'.$value.'</span>
                                <h4>'.$title.'</h4>
                            </div>';

	        $compile.="</div>";

	        if(''!=$css_style){
	          $DEstyle[]="#$el_id {".$css_style."}";
	        }

		    if(""!=$label_color){
		      $DEstyle[]="#$el_id h4 {color:".$label_color."}";
		    }

	        if(""!=$unit_color){
	          $DEstyle[]="#$el_id .tocounter {color:".$unit_color."}";
	        }

	        return $compile;


		}

		add_dt_element_render('dt_circlebar_item','krypton_dt_circlebar_item_shortcode');

		remove_dt_element_option('dt_circlebar_item','unit');
		remove_dt_element_option('dt_circlebar_item','size');


        add_dt_element_option('dt_row',
        array( 
          'heading' => __( 'Background Image Style', 'detheme_builder' ),
          'param_name' => 'background_style',
          'type' => 'dropdown',
          'value'=>array(
                'cover' => __("Cover", 'detheme_builder') ,
                'contain' => __('Contain', 'detheme_builder') ,
                'no-repeat' => __('No Repeat', 'detheme_builder') ,
                'repeat'  => __('Repeat', 'detheme_builder') ,
	            'fixed'  => __("Fixed", 'detheme_builder') ,
                'parallax'  => __('Parallax', 'Krypton') ,
              ),
          'group'=>__('Extended options', 'detheme_builder'),
          'dependency' => array( 'element' => 'background_type', 'value' => array('image') )       
          ));

	    add_dt_element_option( 'dt_row', array( 
	          'heading' => __( 'Expand section width', 'Krypton' ),
	          'param_name' => 'expanded',
	          'class' => '',
	          'value' => array("3"=>__('Default','Krypton'),"1"=>__('Expand Column','Krypton'),"2"=>__('Expand Background','Krypton')),
	          'description' => __( 'Make section "out of the box".', 'Krypton' ),
	          'type' => 'radio',
	          'default'=>"3"
	    ),'background_style');


	      function krypton_dt_row_shortcode($output,$content,$atts){


	      global $DEstyle;

	        extract( shortcode_atts( array(
	            'el_id' => '',
	            'el_class'=>'',
	            'image'=>'',
	            'background_style'=>'',
	            'background_video'=>'',
	            'background_video_webm'=>'',
	            'background_type' =>'image',
	            'background_poster'=>'',
	            'bg_color'=>'',
	            'm_top'=>'',
	            'm_bottom'=>'',
	            'm_left'=>'',
	            'm_right'=>'',
	            'p_top'=>'',
	            'p_bottom'=>'',
	            'p_left'=>'',
	            'p_right'=>'',
	            'expanded'=>'3',
	            'font_color'=>'',
	            'scroll_delay'=>300,
	            'spy'=>''
	        ), $atts,'dt_row' ) );

	        $css_class=array();

	        if(''!=$el_class){
	            array_push($css_class, $el_class);
	        }

	        if(''==$el_id){
	            $el_id="dt_row_".getCssID();
	        }

	       $css_style=getCssMargin($atts,true);

	       $parallax=$video="";

	        if(''!=$bg_color){$css_style['background-color']="background-color:$bg_color";}
	        if($background_type=='image' && ''!=$image && $background_image=wp_get_attachment_image_src( $image, 'full' )){

	              $css_style['background-image']="background-image:url(".esc_url($background_image[0]).")!important;";

	              switch($background_style){
	                  case'parallax':
	                      $parallax=" data-speed=\"2\" data-type=\"background\" ";
	                      $css_style['background-position']="background-position: 0% 0%; background-repeat: no-repeat; background-size: cover";
	                      break;
	                  case'cover':
	                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important";
	                      break;
	                  case'no-repeat':
	                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size:auto !important";
	                      break;
	                  case'repeat':
	                      $css_style['background-position']="background-position: 0 0 !important;background-repeat: repeat !important;background-size:auto !important";
	                      break;
	                  case'contain':
	                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important;background-size: contain!important";
	                      break;
	                  case 'fixed':
	                      $css_style['background-position']="background-position: center !important; background-repeat: no-repeat !important; background-size: cover!important;background-attachment: fixed !important";
	                      break;
	                  default:
	                      $parallax="";
	                      break;
	              }

	        }
	        elseif($background_type=='video' && ($background_video!='' || $background_video_webm!='')){

	            $source_video=array();

	            if($background_video!=''){

	              $video_url=wp_get_attachment_url(intval($background_video));
	              $videodata=wp_get_attachment_metadata(intval($background_video));

	              if(''!=$video_url  && isset($videodata['mime_type'])){

	                $videoformat="video/mp4";
	                if(is_array($videodata) && $videodata['mime_type']=='video/webm'){
	                     $videoformat="video/webm";
	                }

	                $source_video[]="<source src=\"".esc_url($video_url)."\" type=\"".$videoformat."\" />";
	             }
	            }

	            if($background_video_webm!='' && isset($videodata['mime_type'])){

	              $video_url=wp_get_attachment_url(intval($background_video_webm));
	              $videodata=wp_get_attachment_metadata(intval($background_video_webm));

	              if(''!=$video_url && $background_type=='video'){

	                $videoformat="video/mp4";
	                if(is_array($videodata) &&  $videodata['mime_type']=='video/webm'){
	                     $videoformat="video/webm";
	                }

	                $source_video[]="<source src=\"".esc_url($video_url)."\" type=\"".$videoformat."\" />";
	               }
	            }

	            if(count($source_video)){

	              $poster="";

	              if($background_poster!='' && $poster_image=wp_get_attachment_image_src( $background_poster, 'full' )){
	                if(isset($poster_image[0]) && $poster_image[0]!='') $poster=$poster_image[0];

	                  $DEstyle[]="#$el_id video {background:url('".esc_url($poster_image[0])."') no-repeat 0% 0% ;background-size: cover}";
	              }

	             array_push($css_class,'has-video');
	             $video="<video class=\"video_background\" poster=\"".esc_attr($poster)."\" autoplay loop>\n".@implode("\n", $source_video)."</video>";

	            }
	        }


	        $templateName=get_page_template_slug();
	        $boxed=false;
	        if( in_array($templateName,array('squeezeboxed.php','squeeze.php','fullwidth.php','woocommerce-page-full.php')) || 'nosidebar'==get_query_var('sidebar')){
	          $boxed=true;
	        }

	        $compile="";

	        array_push($css_class,'clearfix','dt_row');

	        switch($expanded){
	            case "1":
	                      $compile.="<div ";

	                      if(''!=$el_id){
	                          $compile.="id=\"$el_id\" ";
	                      }

	                      if('none'!==$spy && !empty($spy)){
	                          $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}"';
	                      }

	                      $compile.="class=\"".@implode(" ",$css_class)."\"".$parallax.">";
	                      $compile.=$video.do_shortcode($content);
	                      $compile.="</div>";
	              break;
	            case "2":
	                      $compile.="<div ";

	                      if(''!=$el_id){
	                          $compile.="id=\"$el_id\" ";
	                      }
	                        
	                      if('none'!==$spy && !empty($spy)){
	                          $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}"';
	                      }


	                      $compile.="class=\"".@implode(" ",$css_class)."\"".$parallax.">";
	                      $compile.=($boxed)?"<div class=\"container\">".$video."<div class=\"row\">":"";  
	                      $compile.=do_shortcode($content);
	                      $compile.=($boxed)?"</div></div>":""; 
	                      $compile.="</div>";

	              break;
	            default:

	                    $compile.=($boxed)?"<div class=\"row\"><div class=\"container\">":"";  
	                    $compile.="<div ";

	                    if(''!=$el_id){
	                        $compile.="id=\"$el_id\" ";
	                    }

	                    if('none'!==$spy && !empty($spy)){
	                        $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}"';
	                    }
	                    $compile.="class=\"".@implode(" ",$css_class)."\"".$parallax.">";
	                    $compile.=$video.do_shortcode($content);
	                    $compile.="</div>";
	                    $compile.=($boxed)?"</div></div>":""; 

	            break;

	        }

	        if(''!=$font_color){
	          $DEstyle[]="#$el_id {color:$font_color}";
	        }


	        if(count($css_style)){
	          $DEstyle[]="#$el_id {".@implode(";",$css_style)."}";
	        }

	        return $compile;

	      }

	    add_dt_element_render('dt_row','krypton_dt_row_shortcode');

		add_dt_element_option('section_header',
		   array( 
	        'heading' => __( 'Layout type', 'detheme_builder' ),
	        'param_name' => 'layout_type',
	        'class' => '',
	        'param_holder_class'=>'section-heading-style',
	        'type' => 'select_layout',
	         'value'=>array(
	            'section-heading-border'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_01.png" alt="'.__('Type 1: Borderer','detheme_builder').'" />',
	            'section-heading-border-top-bottom' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_02.png" alt="'.__('Type 2: Border Top-Bottom','detheme_builder').'"/>' ,
	            'section-heading-polkadot-two-bottom' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_03.png" alt="'.__('Type 3: Two Bottom Polkadot','detheme_builder').'"/>' ,
	            'section-heading-colorblock'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_06.png" alt="'.__('Type 4: Color Background','detheme_builder').'"/>' ,
	            'section-heading-point-bottom'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_07.png" alt="'.__('Type 5: ','detheme_builder').'"/>' ,
	            'section-heading-thick-border'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_08.png" alt="'.__('Type 6: ','detheme_builder').'"/>' ,
	            'section-heading-thin-border' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_11.png" alt="'.__('Type 7: ','detheme_builder').'"/>' ,
	            'section-heading-polkadot-left-right' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_14.png" alt="'.__('Type 8: ','detheme_builder').'"/>' ,
	            'section-heading-polkadot-top'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_15.png" alt="'.__('Type 9: ','detheme_builder').'"/>' ,
	            'section-heading-polkadot-bottom' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_16.png" alt="'.__('Type 10: ','detheme_builder').'"/>' ,
	            'section-heading-double-border-bottom'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_17.png" alt="'.__('Type 11: ','detheme_builder').'"/>' ,
	            'section-heading-thin-border-top-bottom'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_18.png" alt="'.__('Type 12: ','detheme_builder').'"/>' ,
	            'section-heading-swirl' => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_19.png" alt="'.__('Type 13: ','detheme_builder').'"/>' ,
	            'section-heading-wave'  => '<img src="'.get_dt_plugin_dir_url().'lib/images/section_heading_20.png" alt="'.__('Type 14: ','detheme_builder').'"/>' ,
	            'section-heading-krypton'	=> '<img src="'.get_template_directory_uri().'/lib/images/section_heading_krypton.jpg" alt="'.__('Type 15: Krypton','Krypton').'"/>',
	            ),
	        'dependency' => array( 'element' => 'use_decoration', 'value' => array('1')),        
	         )
		);


		add_dt_element_option('section_header',
		   array( 
	        'heading' => __( 'Sub Heading', 'detheme_builder' ),
	        'param_name' => 'after_heading',
	        'class' => '',
	        'type' => 'textfield',
	        'dependency' => array( 'element' => 'select_layout', 'value' => array('section-heading-krypton')),        
	         ),'main_heading'
		);

		add_dt_element_option('section_header',
		   array( 
	        'heading' => __( 'Pre Heading', 'detheme_builder' ),
	        'param_name' => 'pre_heading',
	        'class' => '',
	        'type' => 'textfield',
	        'dependency' => array( 'element' => 'select_layout', 'value' => array('section-heading-krypton')),        
	         ),'main_heading'
		);


		function krypton_section_header_shortcode($output,$content,$atts){

        wp_enqueue_style('detheme-builder');

        global $DEstyle;

        extract(shortcode_atts(array(
            'layout_type'=>'section-heading-border',
            'separator_position'=>'',
            'use_decoration'=>false,
            'separator_color'=>'',
            'main_heading' => '',
            'text_align'=>'center',
            'after_heading'=>'',
            'pre_heading'=>'',
            'color'=>'',
            'el_id'=>'',
            'el_class'=>'',
            'font_weight'=>'',
            'font_style'=>'',
            'font_size'=>'default',
            'custom_font_size'=>'',
            'separator_color'=>'',
            'spy'=>'',
            'scroll_delay'=>300,
        ), $atts,'section_header'));

        $css_class=array('dt-section-head',$text_align);
        $heading_style=array();


        if(''!=$el_class){
            array_push($css_class, $el_class);
        }

        $css_style=getCssMargin($atts);

        if(''==$el_id){
            $el_id="dt-section-head-".getCssID();
        }

        if('default'!==$font_size){
          array_push($css_class," size-".$font_size);
        }

        $compile="<div ";
        if(''!=$el_id){
              $compile.="id=\"$el_id\" ";
        }

        if('none'!==$spy && !empty($spy)){
            $compile.='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.(int)$scroll_delay.'}" ';
        }


        if(!empty($color)){
            $heading_style['color']="color:".$color;
        }


        if(!empty($font_weight) && $font_weight!='default'){
            $heading_style['font-weight']="font-weight:".$font_weight;
        }

        if(!empty($font_style) && $font_style!='default'){
            $heading_style['font-style']="font-style:".$font_style;
        }

        if(!empty($custom_font_size) && $font_size=='custom'){
            $custom_font_size=(preg_match('/(px|pt)$/', $custom_font_size))?$custom_font_size:$custom_font_size."px";
            $heading_style['font-size']="font-size:".$custom_font_size;
        }

        if($use_decoration){

            $decoration_position=$decor_heading="";

            if($layout_type=='section-heading-polkadot-two-bottom'){
                $decoration_position="polka-".$separator_position;
            }
            elseif($layout_type=='section-heading-thick-border'){
                $decoration_position="thick-".$separator_position;
            }
            elseif($layout_type=='section-heading-thin-border'){
                $decoration_position="thin-".$separator_position;
            }
            elseif($layout_type=='section-heading-double-border-bottom'){
                $decoration_position="double-border-bottom-".$separator_position;
            }
            elseif($layout_type=='section-heading-thin-border-top-bottom'){
                $decoration_position="top-bottom-".$separator_position;
            }


           if(!empty($separator_color)){
                $heading_style['border-color']="border-color:".$separator_color;

                switch ($layout_type) {
                    case 'section-heading-border-top-bottom':
                    case 'section-heading-thin-border-top-bottom':
                    case 'section-heading-thick-border':
                    case 'section-heading-thin-border':
                    case 'section-heading-double-border-bottom':
                    case 'section-heading-swirl':
                        $DEstyle[]="#".$el_id." h2:after,#".$el_id." h2:before{background-color:".$separator_color.";}";
                        break;
                    case 'section-heading-colorblock':
                        $DEstyle[]="#".$el_id." h2{background-color:".$separator_color.";}";
                        break;
                    case 'section-heading-point-bottom':
                        $DEstyle[]="#".$el_id." h2:before{border-top-color:".$separator_color.";}";
                        break;
                    case 'section-heading-krypton':
                        $DEstyle[]="#".$el_id." hr:after{background-color:".$separator_color.";}";
                        break;
                    default:
                        break;
                }

            }

            if($layout_type=='section-heading-swirl' || $layout_type=='section-heading-wave'){
              array_push($css_class,$layout_type);
            }

            if('section-heading-polkadot-left-right'==$layout_type){
              array_push($css_class,"hide-overflow");
            }

            if($layout_type=='section-heading-swirl'){
                $decor_heading.='<svg viewBox="0 0 '.(($text_align=='left')?"104":($text_align=='right'?"24":"64")).' 22"'.($separator_color!=''?" style=\"color:".$separator_color."\"":"").'>
                <use xlink:href="'.get_dt_plugin_dir_url().'images/source.svg#swirl"></use>
            </svg>';
            }elseif($layout_type=='section-heading-wave'){
                $decor_heading.='<svg viewBox="0 0 '.(($text_align=='left')?"126":($text_align=='right'?"2":"64")).' 30"'.($separator_color!=''?" style=\"color:".$separator_color."\"":"").'>
                <use xlink:href="'.get_dt_plugin_dir_url().'images/source.svg#wave"></use>
            </svg>';
            }
            elseif($layout_type=='section-heading-krypton'){
            	$decor_heading="<hr/>";
            }


             $compile.='class="'.@implode(" ",$css_class).'">';


            $compile.='<div class="dt-section-container">'.($pre_heading!=''?'<p>'.$pre_heading.'</p>':'').
            '<h2 class="section-main-title '.$layout_type.' '.$decoration_position.'"'.(count($heading_style)?" style=\"".@implode(";",$heading_style)."\"":"").'>
                '.$main_heading.'
            </h2>'.$decor_heading.'
            </div>'.($after_heading!=''?'<p class="descriptionText">'.$after_heading.'</p>':'').'</div>';


        }
        else{

          $compile.='class="'.@implode(" ",$css_class).'">
              <div>'.
                  ((!empty($main_heading))?'<h2'.(count($heading_style)?" style=\"".@implode(";",$heading_style)."\"":"").' class="section-main-title">'.$main_heading.'</h2>':'').
          '</div></div>';  

        }

        if(""!=$css_style){
          $DEstyle[]="#$el_id {".$css_style."}";
        }

        return $compile;
		}

		add_dt_element_render('section_header','krypton_section_header_shortcode');

		function krypton_dt_verticaltab_shortcode($output,$content,$atts){

			if(!has_shortcode($content,'dt_verticaltab_item'))
            return "";

	        $regexshortcodes=
	        '\\['                              // Opening bracket
	        . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
	        . "(dt_verticaltab_item)"                     // 2: Shortcode name
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
	            'nav_position' => 'left',
	            'spy'=>'none',
	            'scroll_delay'=>300,
	            'el_id'=>'',
	            'el_class'=>''

	        ), $atts ,'dt_verticaltab' ) );

			$css_style=getCssMargin($atts);

		    if(''==$el_id){
                $el_id="vsliderid_".getCssID();
            }

            $css_class=array('dt_vertical','cn_wrapper','row');

            if(''!=$el_class){
               array_push($css_class, $el_class);
            }

	         $leftspy="";
	         $rightspy="";
	         $spydly=$scroll_delay;
	         $itemnumber=0;

	        if('none'!==$spy && !empty($spy)){
	            switch($spy){
	                case 'uk-animation-slide-left':
	                        $leftspy='data-uk-scrollspy="{cls:\''.$spy.'\',delay:'.($spydly+600).'}"';
	                        $rightspy='data-uk-scrollspy="{cls:\'uk-animation-slide-right\',delay:'.$spydly.'}"';
	                    break;
	                case 'uk-animation-slide-right':
	                       $leftspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.($spydly+600).'}"';
	                       $rightspy='data-uk-scrollspy="{cls:\'uk-animation-slide-left\',delay:'.$spydly.'}"';
	                    break;
	                default:
	                    $leftspy='data-uk-scrollspy="{cls:\''.$spy.'\',delay:'.$spydly.'}"';
	                    $rightspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
	                    break;
	            }
	        }

	        $cn_list=array();
	        $cn_preview=array();

	        foreach ($matches as $slideitem) {


	        	$slide_args=wp_parse_args(shortcode_parse_atts($slideitem[3]),array(
		            'title'=>'',
		            'sub_title'=>'',
		            'link'=>'',
		            'icon_type'=>'',
	        		));

                $cn_item="\n".'<div class="cn_item'.(($itemnumber==0)?" selected":"").'">
                    <div class="row">
                        <div class="col col-sm-2 vs_icon">
                            <i class="'.sanitize_html_class($slide_args['icon_type']).'"></i>
                        </div>
                        <div class="col col-sm-10 vs_text">
                            <h2 class="vs_title">'.$slide_args['title'].'</h2>
                            <p class="vs_description">'.$slide_args['sub_title'].'</p>
                        </div>
                    </div>
                </div>';


            $cn_preview_item='<div class="cn_content"'.(($itemnumber==0)?" style=\"top:0;\" ".$rightspy:"").'>'.$slideitem[5].'<div class="vs-text-preview visible-sm visible-xs">
                    <h2 class="vs_title">'.$slide_args['title'].'</h2>
                    <p class="vs_description">'.$slide_args['sub_title'].'</p>                    
                </div>
            </div>';


	            array_push($cn_list, $cn_item);
	            array_push($cn_preview, $cn_preview_item);

	            $itemnumber++;

	        }

	        $compile="<div ";
            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            $compile.="class=\"".@implode(" ",$css_class)."\">";


		    $compile.='<div class="cn_list col col-xs-4'.($nav_position=='right'?" col-xs-push-8":"").'" '.$leftspy.'>
		            <div class="cn_page" style="display:block;">
		                '.@implode("\n",$cn_list).'
		            </div>
		    </div>'."\n".'
		        <div class="cn_preview col col-xs-8'.($nav_position=='right'?" col-xs-pull-4":"").'">
		            '.@implode("\n",$cn_preview).'
		        </div>'."\n".'</div>';


            if(""!=$css_style){
              $DEstyle[]="#$el_id {".$css_style."}";
            }

			return $compile;

		}
	
		add_dt_element_render('dt_verticaltab','krypton_dt_verticaltab_shortcode');


		remove_dt_element_option('dt_pricetable','body_back_color');
		remove_dt_element_option('dt_pricetable','header_back_color');
		remove_dt_element_option('dt_pricetable','evencell_back_color');
		remove_dt_element_option('dt_pricetable','oddcell_back_color');


		add_dt_element('dt_accordion',
		 array( 
		    'title' => __( 'Accordion', 'Krypton' ),
		    'as_parent' => 'dt_accordion_item',
		    'icon'	=>'dashicons-id',
		    'options' => array(
		        array( 
		        'heading' => __( 'Module Title', 'detheme_builder' ),
		        'param_name' => 'title',
		        'admin_label' => true,
		        'value' => __( 'Accordion', 'Krypton' ),
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
		        )
		      )
			) 
		);

		add_dt_element('dt_accordion_item',
		 array( 
		    'title' => __( 'Tab Item', 'detheme_builder' ),
		    'as_child' => 'dt_accordion',
		    'options' => array(
		        array( 
		        'heading' => __( 'Expanded', 'Krypton' ),
		        'param_name' => 'title',
		        'value' => '',
		        'type' => 'textfield'
		         ),
		        array( 
		        'heading' => __( 'Title', 'detheme_builder' ),
		        'param_name' => 'expanded_state',
		        'value' => array('yes'=>__('Yes','detheme_builder'),'no'=>__('No','detheme_builder')),
		        'type' => 'radio'
		         ),
		        array( 
		        'heading' => __( 'Content', 'detheme_builder' ),
		        'param_name' => 'content',
		        'class' => '',
		        'value' => '',
		        'type' => 'textarea_html'
		         )
		        )
		 ) );


		function krypton_dt_accordion_shortcode($output,$content,$atts){

			global $DEstyle;

			extract( shortcode_atts( array(
	            'el_id'=>'',
	            'el_class'=>''

	        ), $atts ,'dt_accordion' ) );


		    $css_style=getCssMargin($atts);

		    if(''==$el_id){
                $el_id="accordion_".getCssID();
            }

            $css_class=array('dt-accordion','panel-group','custom-accordion');

            if(''!=$el_class){
               array_push($css_class, $el_class);
            }


           $compile="<div ";
            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            $compile.="class=\"".@implode(" ",$css_class)."\">";

		    $content=preg_replace('/\[dt_accordion_item/','[dt_accordion_item parent_id="'.$el_id.'"', $content);

		    $compile.=do_shortcode($content).'</div>';   


            if(""!=$css_style){
              $DEstyle[]="#$el_id {".$css_style."}";
            }

		    return $compile;


		}


		add_dt_element_render('dt_accordion','krypton_dt_accordion_shortcode');

		function krypton_dt_accordion_item_shortcode($output,$content,$atts){
			extract(shortcode_atts(array(
		        'title' => '',
		        'expanded_state' => '',
		        'parent_id'=>''
		    ), $atts));

		    $dt_accordion_item=getCssID();

  
		   $compile='<div class="panel panel-default">
		                        <div class="panel-heading">
		                          <h4 class="panel-title">'.$title.'</h4>
		                          <a class="btn-accordion" data-toggle="collapse" data-parent="#'.$parent_id.'" href="#collapse'.$dt_accordion_item.'"><span>'.(($expanded_state=='yes')?"-":"+").'</span></a>
		                        </div>
		                        <div id="collapse'.$dt_accordion_item.'" class="panel-collapse collapse'.(($expanded_state=='yes')?" in":"").'">
		                          <div class="panel-body">'.wp_specialchars_decode($content,'double').'</div>
		                        </div>
		                 </div>';

		    return $compile;

		}


		add_dt_element_render('dt_accordion_item','krypton_dt_accordion_item_shortcode');

		add_dt_element('dt_subslider',
		 array( 
		    'title' => __( 'Sub Slider', 'Krypton' ),
		    'icon'	=>'dashicons-image-flip-horizontal',
		    'as_parent' => 'dt_subslider_item',
		    'options' => array(
		        array( 
		        'heading' => __( 'Module Title', 'detheme_builder' ),
		        'param_name' => 'title',
		        'value' => __( 'Sub Slider', 'Krypton' ),
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
		          "type" => "colorpicker",
		          "heading" => __('Font Color', 'detheme_builder'),
		          "param_name" => "font_color",
		          "description" => __("Select font color", "detheme_builder"),
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
		        )
		      )
			) 
		);

		add_dt_element('dt_subslider_item',
		 array( 
		    'title' => __( 'Slide Item', 'Krypton' ),
		    'as_child' => 'dt_subslider',
		    'options' => array(
		        array( 
		        'heading' => __( 'Slide Image', 'Krypton' ),
		        'param_name' => 'slider_image',
		        'value' => '',
		        'type' => 'image'
		         ),
		        array( 
		        'heading' => __( 'Title', 'Krypton' ),
		        'param_name' => 'title',
		        'value' => '',
		        'type' => 'textfield'
		         ),
		        array( 
		        'heading' => __( 'Sub Title', 'Krypton' ),
		        'param_name' => 'sub_title',
		        'value' => '',
		        'type' => 'textfield'
		         ),
		        array( 
		        'heading' => __( 'Content', 'detheme_builder' ),
		        'param_name' => 'content',
		        'class' => '',
		        'value' => '',
		        'type' => 'textarea_html'
		         ),
		        array( 
		        'heading' => __( 'Link', 'Krypton' ),
		        'param_name' => 'link',
		        'value' => '',
		        'type' => 'textfield'
		         ),
		        array( 
		        'heading' => __( 'Link Label', 'Krypton' ),
		        'param_name' => 'linklabel',
		        'value' => '',
		        'type' => 'textfield'
		         ),
		        array( 
		        'heading' => __( 'Link Target', 'Krypton' ),
		        'param_name' => 'linktarget',
		        'value' => array('_blank'	=> __('Blank'),'_self'	=> __('Self')),
		        'type' => 'dropdown'
		         ),
		        )
		 ) );


		function krypton_dt_subslider_shortcode($output,$content,$atts){

			if(!has_shortcode($content,'dt_subslider_item'))
            return "";

	        $regexshortcodes=
	        '\\['                              // Opening bracket
	        . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
	        . "(dt_subslider_item)"                     // 2: Shortcode name
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
	            'font_color' => '',
	            'el_id'=>'',
	            'el_class'=>''

	        ), $atts ,'dt_subslider' ) );

	        wp_enqueue_script( 'sequence', get_template_directory_uri() . '/js/jquery.sequence.js', array( 'jquery' ), '1.0');
	        wp_enqueue_script( 'dt-subslider', get_template_directory_uri() . '/js/dt_subslider.js', array( 'jquery' ), '1.0');
	        wp_enqueue_style( 'subslider', get_template_directory_uri(). '/css/sub_slider.css', array());  


			$css_style=getCssMargin($atts,true);

			if($font_color!=''){

				$css_style['color']="color:".$font_color.";";
			}

		    if(''==$el_id){
                $el_id="sequence_".getCssID();
            }

            $css_class=array('sequence-sub-slider');

            if(''!=$el_class){
               array_push($css_class, $el_class);
            }

		    $compile="<div ";
            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            $compile.="class=\"".@implode(" ",$css_class)."\">";
            $compile.='<span class="sequence-prev"><i class="icon-left-open-big"></i></span>
                    <span class="sequence-next"><i class="icon-right-open-big"></i></span><ul class="sequence-canvas">';

			$i=0;

             foreach ($matches as $subslider_item) {

             	$slide_args=wp_parse_args(shortcode_parse_atts($subslider_item[3]),array(
		            'title'=>'',
		            'sub_title'=>'',
		            'link'=>'',
		            'slider_image'=>'',
		            'linklabel'=>'',
		            'linktarget'=>'',
	        		));


	           $sliderImage=wp_get_attachment_image_src($slide_args['slider_image'],'full',false);

               $compile.='<li'.(('1'==$i)?' class="animate-in"':'').'>
                            <div class="row">';

                if($sliderImage){

                	$alt_image = get_post_meta($slide_args['slider_image'], '_wp_attachment_image_alt', true);

                    $compile.='<div class="col col-sm-5 col-sm-offset-1 col-xs-12 slide-image-container">
                                  <img class="img-responsive absolute-pos slide-image" src="'.esc_url($sliderImage[0]).'" alt="'.esc_attr($alt_image).'">
                    	        </div>';
                }
                $compile.='<div class="col '.($sliderImage?"col-sm-5":"col-sm-10 col-sm-offset-1").' col-xs-12">
                                    <div class="slide-panel absolute-pos">
                                        <section>'.
                                        (''!=$slide_args['sub_title']?'<p>'.strip_tags($slide_args['sub_title']).'</p>':"").
                                        (''!=$slide_args['title']?'<h2>'.$slide_args['title'].'</h2>':"").'
                                        </section>
                                        <hr>
                                        <div class="slide-description-text">'.$subslider_item[5].'</div>
                                        '.((!empty($slide_args['linklabel']))?
                                        '<div class="slide-readmore">
                                            <a '.((!empty($slide_args['link']))?' href="'.esc_url($slide_args['link']).'" target="'.esc_attr($slide_args['linktarget']).'"':"").'class="button-more">'.$slide_args['linklabel'].'</a>
                                        </div>'
                                        :"").'
                                    </div>
                                </div>
                            </div>
                        </li><!-- Frame '.$i.' -->';

            
            $i++;

             }


		    $compile.='</ul></div>';   


            if(count($css_style)){
              $DEstyle[]="#$el_id {".@implode(";",$css_style)."}";
            }


			return $compile;

		}


		add_dt_element_render('dt_subslider','krypton_dt_subslider_shortcode');


		class DElement_Field_sidebars extends DElement_Field{

		  function render($option=array(),$value=null){

		   $fieldname=$option['param_name'];
		   $fieldid=sanitize_html_class($fieldname);
		   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);

		   $dependency=create_dependency_param($option);
		   $sidebars=krypton_get_registered_sidebars();

		    $compile="<select id=\"".$fieldid."\" class=\"param_value select-option".$css."\" name=\"".$fieldname."\"".$dependency.">";



		    if(is_array($sidebars) && count($sidebars)){
		       foreach ($sidebars as $key => $label) {

		          if ( is_numeric( $key ) && !is_assoc_array($sidebars)) {
		            $key = $label;
		          }

		          $compile.="<option value=\"".$key."\"".($key==$value && ''!=$value?" selected=\"selected\"":"").">".$label."</option>";
		      }
		    }
		    $compile.="</select>";
		    return $compile;
		  }

		}


		add_dt_element('dt_widget',
		 array( 
		    'title' => __( 'Widget Area', 'Krypton' ),
		    'icon'	=> 'dashicons-images-alt',
		    'options' => array(
		        array( 
		        'heading' => __( 'Module Title', 'detheme_builder' ),
		        'param_name' => 'title',
		        'value' => __( 'Widget Area', 'Krypton' ),
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
		          'heading' => __( 'Select Widget Area', 'detheme_builder' ),
		          'param_name' => 'position',
		          'type' => 'sidebars',
		        )

		      )
		 ) );

		function krypton_dt_widget_shortcode($output,$content="",$atts=array()){

 			extract( shortcode_atts( array(
	            'position' => '',
	            'el_id'=>'',
	            'el_class'=>''

	        ), $atts ,'dt_widget' ) );

	        global $DEstyle;

		    $css_style=getCssMargin($atts);

		    if(''==$el_id){
                $el_id="wid".getCssID();
            }

            $css_class=array('dt-widget-area');

            if(''!=$el_class){
               array_push($css_class, $el_class);
            }


           $compile="<div ";
            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            $compile.="class=\"".@implode(" ",$css_class)."\">";

            if(is_active_sidebar($position)){

            	ob_start();
		        dynamic_sidebar($position);
        		$compile.= ob_get_clean();

            }
		    $compile.='</div>';   

            if(""!=$css_style){
              $DEstyle[]="#$el_id {".$css_style."}";
            }

			return $compile;
		}

		add_dt_element_render('dt_widget','krypton_dt_widget_shortcode');

		class DElement_Field_woocategories extends DElement_Field{

		  function render($option=array(),$value=null){

		   $fieldname=$option['param_name'];
		   $fieldid=sanitize_html_class($fieldname);
		   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);


		     $output='<div class="checkbox-options '.$css.'">';
		     $array_value=@explode(",",trim($value));

		     $dependency=create_dependency_param($option);

		     $terms_woocategories = get_terms('product_cat', array('taxonomy' => 'Category'));


			    if(is_array($terms_woocategories) && count($terms_woocategories)){

 				      $output.='<input type="checkbox" name="'.$fieldname.'_option" class="all-option checkbox-option" '.((!count($array_value) || in_array('all',$array_value))?'checked="checked"':'').'value="all" />'.__('All Categories','Krypton');


				      foreach ($terms_woocategories as $cat) {
				          $output.=' <input type="checkbox" name="'.$fieldname.'_option" class="checkbox-option" '.((in_array($cat->term_id,$array_value))?'checked="checked"':'').'value="'.$cat->term_id.'" /> '.$cat->name;
				      }
			    }

		      $output.='<input type="hidden" name="'.$fieldname.'" class="param_value checkbox-input-value" value="'.$value.'" '.$dependency.'/>';
		      $output.='</div>';
		      return  $output;

		  }

		}

		if (is_plugin_active('woocommerce/woocommerce.php')) {

			add_dt_element('dt_wooproduct',
			 array( 
			    'title' => __( 'Woocommerce Product', 'Krypton' ),
			    'icon'	=> 'dashicons-cart',
			    'options' => array(
			        array( 
			        'heading' => __( 'Module Title', 'detheme_builder' ),
			        'param_name' => 'title',
			        'value' => __( 'Woocommerce Product', 'Krypton' ),
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
			          'heading' => __( 'Num Item', 'Krypton' ),
			          'param_name' => 'posts_per_page',
			          'type' => 'textfield',
			        ),
			        array( 
			          'heading' => __( 'View type', 'Krypton' ),
			          'param_name' => 'view_type',
			          'type' => 'dropdown',
			          'value'=>array(2=> __('2 Columns','Krypton'),3=> __('3 Columns','Krypton'),4=> __('4 Columns','Krypton'))
			        ),
			        array( 
			          'heading' => __( 'Filter', 'Krypton' ),
			          'param_name' => 'filter',
			          'type' => 'radio',
			          'default'=>'off',
			          'value'=>array('on'=>__('Show','Krypton'),'off'=>__('Hidden','Krypton'))
			        ),
			        array( 
			          'heading' => __( 'All Category Label', 'Krypton' ),
			          'param_name' => 'all_label',
			          'type' => 'textfield',
			          'default'=>__('All Category','Krypton'),
			          'value'=>'',
			          'dependency'=>array('element' => 'filter','value' =>array('on'))
			        ),
			        array( 
			          'heading' => __( 'Categories', 'Krypton' ),
			          'param_name' => 'selected_categories',
			          'type' => 'woocategories',
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

			function krypton_dt_wooproduct_shortcode($output,$content="",$atts=array()){

	 			extract( shortcode_atts( array(
			        'posts_per_page' => get_option('posts_per_page'),
			        'view_type' => '4',
			        'filter' => 'on',
			        'all_label'=>__('All Category','Krypton'),
			        'selected_categories' => '',
			        'spy'=>'none',
			        'scroll_delay'=>300,
		            'el_id'=>'',
		            'el_class'=>''

		        ), $atts ,'dt_wooproduct' ) );

		        global $DEstyle;

			    $css_style=getCssMargin($atts);

			    if(''==$el_id){
	                $el_id="dt-wooproduct".getCssID();
	            }

	            $css_class=array('woocommerce-module',"col-".$view_type);

	            if(''!=$el_class){
	               array_push($css_class, $el_class);
	            }


			    $post_type_terms = array();
			    if (strlen($selected_categories) > 0 && $selected_categories!='all') {

			        $post_type_terms = @explode(",", $selected_categories);
			    }


			    $wooargs = array(
			        'post_type' => 'product',
			        'order' => 'DESC',
			        'posts_per_page' => intval($posts_per_page),
			    );


			    if (count($post_type_terms) > 0) {
			        $wooargs['tax_query'] = array(
			            array(
			                'taxonomy' => 'product_cat',
			                'field' => 'id',
			                'terms' => $post_type_terms
			            )
			        );
			    }

			    $woo_products=$temsAvailable=array();
		        $spydly=0;


				$wp_query_in_shortcodes = new WP_Query();
			    $wp_query_in_shortcodes->query($wooargs);


	           $compile="<div ";
	            if(''!=$el_id){
	                $compile.="id=\"$el_id\" ";
	            }

	            $compile.="class=\"".@implode(" ",$css_class)."\">";

	            if($wp_query_in_shortcodes->have_posts()):

	            	while ($wp_query_in_shortcodes->have_posts()) : 
	            		$wp_query_in_shortcodes->the_post();


					    $scollspy=$echoallterm="";
					    if('none'!==$spy && !empty($spy)){
					        $spydly=$spydly+(int)$scroll_delay;
					        $scollspy=' data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
					    }

					    if ($filter == "on") {

					        $new_term_list = get_the_terms(get_the_id(), "product_cat");

					        if (is_array($new_term_list)) {
						        $echoallterm = array();

					            foreach ($new_term_list as $term) {
					                $echoallterm[$term->term_id]= strtolower($term->slug);
					                $temsAvailable[$term->term_id]=$term;

					            }

					            $echoallterm=" ".@implode(" ", $echoallterm);
					        }


					    }


	            		$contentcompile = '<div id="product-'.get_the_ID().'" class="masonry-item'.$echoallterm.'"><div'.$scollspy.'>';
					    ob_start();
					    wc_get_template_part( 'content', 'product_masonry' );
					    $wooitem=ob_get_contents();
					    ob_end_clean();
					    $contentcompile.=$wooitem;

	    				$contentcompile .='</div></div>';

	    				array_push($woo_products,$contentcompile);

	            	endwhile;

	            endif;

	            wp_reset_query();


				if ($filter == "on" && count($temsAvailable)) {
				    
				    $compile.='<div class="row" >
				    <nav id="featured-navbar" class="navbar navbar-default" role="navigation">
				        <div class="navbar-header">
				        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#dt-featured-filter">
				          <span class="sr-only">'.__('Toggle navigation','Krypton').'</span>
				          <span class="icon-bars"></span>
				          <span class="icon-bars"></span>
				          <span class="icon-bars"></span>
				        </button>
				      </div>
				     <div class="collapse navbar-collapse" id="dt-featured-filter">
				        <ul id="featured-filter" class="dt-featured-filter nav navbar-nav">
				            <li class="active"><a href="#" data-filter="*" class="active">'.$all_label.'</a></li>';
				    if(count($temsAvailable)){

				        foreach ($temsAvailable as $key => $value) {

				            $compile.='<li><a href="'.add_query_arg("slug", $value->term_id).'" data-filter=".'.$value->slug.'">'.$value->name.'</a></li>';
				         }

				    }
				    $compile.='</ul>
				    </div>  
				    </nav>  
				    </div>';

				}
			    if(count($woo_products)):
			            $compile.='<div class="row"><div class="container"><div class="woocommerce woocommerce-module-items">'.@implode("",$woo_products).'</div></div></div>';
			    endif;


			    $compile.='</div>';   

	            if(""!=$css_style){
	              $DEstyle[]="#$el_id {".$css_style."}";
	            }

				return $compile;

			}

			add_dt_element_render('dt_wooproduct','krypton_dt_wooproduct_shortcode');
		}

		add_dt_element('dt_promotion',
		 array( 
		    'title' => __( 'Promotion Box', 'Krypton' ),
		    'icon'	=> 'dashicons-tag',
		    'options' => array(
		        array( 
		        'heading' => __( 'Module Title', 'detheme_builder' ),
		        'param_name' => 'title',
		        'value' => __( 'Promotion Box', 'Krypton' ),
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
		          'heading' => __( 'Background Image', 'Krypton' ),
		          'param_name' => 'bg_image',
		          'type' => 'image',
		        ),
		        array( 
		          'heading' => __( 'Button Label', 'Krypton' ),
		          'param_name' => 'button_label',
		          'type' => 'textfield',
		        ),
		        array( 
		          'heading' => __( 'Button Link', 'Krypton' ),
		          'param_name' => 'button_link',
		          'type' => 'textfield',
		        ),
		        array( 
		          'heading' => __( 'Promotion Text', 'Krypton' ),
		          'param_name' => 'content',
		          'type' => 'textarea',
		        ),
		      )
		 ) );

		function krypton_dt_promotion_shortcode($output,$content="",$atts=array()){

 			extract( shortcode_atts( array(
		        'bg_image' => '',
		        'button_label' => '',
		        'button_link' => '',
	            'el_id'=>'',
	            'el_class'=>''

	        ), $atts ,'dt_promotion' ) );

	        global $DEstyle;


	        $sliderImage=wp_get_attachment_image_src($bg_image,'full',false);

		    $css_style=getCssMargin($atts);

		    if(''==$el_id){
                $el_id="dt-promotion".getCssID();
            }

            $css_class=array('module_dt_promotion');

            if(''!=$el_class){
               array_push($css_class, $el_class);
            }


           $compile="<div ";
            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            $compile.="class=\"".@implode(" ",$css_class)."\">";

			 $compile.='<div class="boxed">';
			 if($sliderImage){
	           	$alt_image = get_post_meta($bg_image, '_wp_attachment_image_alt', true);
                $compile.='<img class="img-responsive" src="'.esc_url($sliderImage[0]).'" alt="'.esc_attr($alt_image).'">';
             }
             $compile.='<div class="thumbnail-description-text">
                    <div class="text-container">'.$content.(!empty($button_label)?
                        "<div class='btn-cta'>
                            <a href='".(!empty($button_link)?esc_url($button_link):"#")."'>".__($button_label)."</a>
                        </div>":"").'
                    </div>
                </div>
            	</div>';

		    $compile.='</div>';   

            if(""!=$css_style){
              $DEstyle[]="#$el_id {".$css_style."}";
            }

            return $compile;


		}


		add_dt_element_render('dt_promotion','krypton_dt_promotion_shortcode');

		add_dt_element('dt_contact_form',
		 array( 
		    'title' => __( 'Contact Form', 'Krypton' ),
		    'icon'	=> 'dashicons-email',
		    'options' => array(
		        array( 
		        'heading' => __( 'Module Title', 'detheme_builder' ),
		        'param_name' => 'title',
		        'value' => __( 'Contact Form', 'Krypton' ),
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
		          "type" => "colorpicker",
		          "heading" => __('Font Color', 'detheme_builder'),
		          "param_name" => "font_color",
		          "description" => __("Select font color", "detheme_builder"),
		        )
		      )
		 ) );

		function krypton_dt_contact_form_shortcode($output,$content="",$atts=array()){
 			extract( shortcode_atts( array(
		        'font_color' => '',
	            'el_id'=>'',
	            'el_class'=>''

	        ), $atts ,'dt_contact_form' ) );

	        global $DEstyle;

		    $css_style=getCssMargin($atts,true);

		    if(''!=$font_color){
		    	$css_style['color']="color:".$font_color;

		    }

		    if(''==$el_id){
                $el_id="dt-contact-form".getCssID();
            }

            $css_class=array('module_dt_contact_form');

            if(''!=$el_class){
               array_push($css_class, $el_class);
            }


           $compile="<div ";
            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            $compile.="class=\"".@implode(" ",$css_class)."\">";

            ob_start();
			locate_template('pagetemplates/dt_contact_form.php',true);
			$compile.=ob_get_clean();

		    $compile.='</div>';   

            if(count($css_style)){
              $DEstyle[]="#$el_id {".@implode(";",$css_style)."}";
            }

            return $compile;

		}

		add_dt_element_render('dt_contact_form','krypton_dt_contact_form_shortcode');


		add_dt_element('krypton_map',
		 array( 
		    'title' => __( 'Krypton Map', 'Krypton' ),
		    'icon'	=> 'dashicons-admin-site',
		    'options' => array(
		        array( 
		        'heading' => __( 'Module Title', 'detheme_builder' ),
		        'param_name' => 'title',
		        'value' => __( 'Krypton Map', 'Krypton' ),
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
		          "type" => "dropdown",
		          "heading" => __('Map type', 'Krypton'),
		          "param_name" => "map_type",
		          "value"=>array('Static Image'=>__('Static Image','Krypton'),'Parallax Image'=>__('Parallax Image','Krypton'),'Fixed Image'=>__('Fixed Image','Krypton'),'Google Map'=>__('Google Map','Krypton')),
		          "description" => __("Select map type", "Krypton"),
		        )
		      )
		 ) );

		function krypton_map_shortcode($output,$content="",$atts=array()){

 			extract( shortcode_atts( array(
	            'el_id'=>'',
	            'el_class'=>'',
	            'map_type'=>'Google Map'

	        ), $atts ,'krypton_map' ) );

	        global $DEstyle,$krypton_config;

		    $css_style=getCssMargin($atts);

		    if(''==$el_id){
                $el_id="krypton-map".getCssID();
            }

            $css_class=array('module_dt_contact_form');

            if(''!=$el_class){
               array_push($css_class, $el_class);
            }


           $compile="<div ";
            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            $compile.="class=\"".@implode(" ",$css_class)."\">";


			if (strtolower($map_type)=='static image') {
				$compile .= '
					<section class="map-image-area">
						<div class="map">
							<div class="circle-address" data-uk-scrollspy="{cls:\'uk-animation-fade\', delay:600}">
								<section>
									<h1>'.$krypton_config['map-circle-number'].'</h1> 
									'.$krypton_config['map-circle-address'].'
									<hr>
									'.$krypton_config['map-circle-city'].'<br>
									'.$krypton_config['map-circle-zipcode'].'
								</section>
							</div>
							<div class="map-info hidden-xs">
									<div class="container">
										<div class="row">
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-location-3"></i>
												</div>
												<address class="address">
													'.$krypton_config['map-address'].'
												</address>
											</div>
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-phone"></i>
												</div>
												<div class="phone">
													'.$krypton_config['map-phone'].'
												</div>						
											</div>
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-mail-1"></i>
												</div>							
												<div class="email">
													<a href="mailto:'.sanitize_email($krypton_config['map-email']).'">'.sanitize_email($krypton_config['map-email']).'</a>
												</div>								
											</div>
										</div>
									</div>
							</div>
						</div>	
					</section>';
			} elseif (strtolower($map_type)=='parallax image') {
				$compile .= '
					<section class="map-image-area" data-type="background" data-speed="3">
						<div class="map">
							<div class="circle-address" data-uk-scrollspy="{cls:\'uk-animation-fade\', delay:600}">
								<section>
									<h1>'.$krypton_config['map-circle-number'].'</h1> 
									'.$krypton_config['map-circle-address'].'
									<hr>
									'.$krypton_config['map-circle-city'].'<br>
									'.$krypton_config['map-circle-zipcode'].'
								</section>
							</div>
							<div class="map-info hidden-xs">
									<div class="container">
										<div class="row">
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-location-3"></i>
												</div>
												<address class="address">
													'.$krypton_config['map-address'].'
												</address>
											</div>
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-phone"></i>
												</div>
												<div class="phone">
													'.$krypton_config['map-phone'].'
												</div>						
											</div>
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-mail-1"></i>
												</div>							
												<div class="email">
													<a href="mailto:'.sanitize_email($krypton_config['map-email']).'">'.sanitize_email($krypton_config['map-email']).'</a>
												</div>								
											</div>
										</div>
									</div>
							</div>
						</div>	
					</section>';
			} elseif (strtolower($map_type)=='fixed image') {
				$compile .= '
					<section class="map-image-area background_fixed">
						<div class="map">
							<div class="circle-address" data-uk-scrollspy="{cls:\'uk-animation-fade\', delay:600}">
								<section>
									<h1>'.$krypton_config['map-circle-number'].'</h1> 
									'.$krypton_config['map-circle-address'].'
									<hr>
									'.$krypton_config['map-circle-city'].'<br>
									'.$krypton_config['map-circle-zipcode'].'
								</section>
							</div>
							<div class="map-info hidden-xs">
									<div class="container">
										<div class="row">
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-location-3"></i>
												</div>
												<address class="address">
													'.$krypton_config['map-address'].'
												</address>
											</div>
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-phone"></i>
												</div>
												<div class="phone">
													'.$krypton_config['map-phone'].'
												</div>						
											</div>
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-mail-1"></i>
												</div>							
												<div class="email">
													<a href="mailto:'.sanitize_email($krypton_config['map-email']).'">'.sanitize_email($krypton_config['map-email']).'</a>
												</div>								
											</div>
										</div>
									</div>
							</div>
						</div>	
					</section>';
			} else { 
		        wp_enqueue_script('gmap',"https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyAXXCx5pSNgkEifSuRdoPvaJ2K7bhdhwRg",array('jquery'));
			    wp_enqueue_script( 'google-map', get_template_directory_uri() . '/js/google_map.js', array( 'jquery','google-map-apis' ), '1.0', true );

				$compile .= '
					<section class="dt-google-map-section">
						<div id="map" data-latitude="'.esc_attr($krypton_config['map-latitude']).'" data-longitude="'.esc_attr($krypton_config['map-longitude']).'" data-marker-url="'. get_template_directory_uri() .'/images/map_marker.png" data-zoom="'.esc_attr($krypton_config['map-zoom-level']).'"></div>
						<div class="map">
							<div class="map-info hidden-xs">
									<div class="container">
										<div class="row">
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-location-3"></i>
												</div>
												<address class="address">
													'.$krypton_config['map-address'].'
												</address>
											</div>
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-phone"></i>
												</div>
												<div class="phone">
													'.$krypton_config['map-phone'].'
												</div>						
											</div>
											<div class="col col-sm-4">
												<div class="icon-container">
													<i class="icon-mail-1"></i>
												</div>							
												<div class="email">
													<a href="mailto:'.sanitize_email($krypton_config['map-email']).'">'.$krypton_config['map-email'].'</a>
												</div>								
											</div>
										</div>
									</div>
							</div>
						</div>	
					</section>';
			} 

		    $compile.='</div>';   

            if(count($css_style)){
              $DEstyle[]="#$el_id {".@implode(";",$css_style)."}";
            }

            return $compile;
		}

		add_dt_element_render('krypton_map','krypton_map_shortcode');

		add_dt_element('dt_linechart',
		 array( 
		    'title' => __( 'Line Chart', 'Krypton' ),
		    'icon'	=> 'dashicons-chart-line',
		    'as_parent' => 'dt_linechart_item',
		    'options' => array(
		        array( 
		        'heading' => __( 'Module Title', 'detheme_builder' ),
		        'param_name' => 'title',
		        'value' => __( 'Line Chart', 'Krypton' ),
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
		          'heading' => __( 'Line Size', 'Krypton' ),
		          'param_name' => 'size',
		          'default'=>6,
		          'type' => 'textfield',
		        ),
		        array(
		          "type" => "colorpicker",
		          "heading" => __('Line Color', 'Krypton'),
		          "param_name" => "color",
		        ),
		        array( 
		          'heading' => __( 'Show Label', 'Krypton' ),
		          'param_name' => 'show_label',
		          'type' => 'radio',
		          'value'=>array("1" => __("Yes","detheme_builder"), "0" => __("No",'detheme_builder'))
		        ),
		        array(
		          "type" => "colorpicker",
		          "heading" => __('Label Color', 'Krypton'),
		          "param_name" => "lblcolor",
		          'dependency' => array( 'element' => 'show_label', 'value' => array('1') )       
		        ),
		        array(
		          "type" => "dropdown",
		          "value"=>array(6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12',14=>'14',16=>'16',18=>'18',24=>'24',27=>'27'),
		          "heading" => __('Label Font Size', 'Krypton'),
		          "param_name" => "lblfsize",
		          "default"=>18,
		          'dependency' => array( 'element' => 'show_label', 'value' => array('1') )       

		        ),
		      )
			) 
		);

		add_dt_element('dt_linechart_item',
		 array( 
		    'title' => __( 'Line', 'Krypton' ),
		    'as_child' => 'dt_linechart',
		    'options' => array(
		        array( 
		        'heading' => __( 'Label', 'Krypton' ),
		        'param_name' => 'content',
		        'class' => '',
		        'value' => '',
		        'type' => 'textfield'
		         ),
		        array( 
		        'heading' => __( 'Value', 'Krypton' ),
		        'param_name' => 'value',
		        'value' => '',
		        'type' => 'textfield'
		         ),
		        )
		 ) );


		function krypton_dt_linechart_shortcode($output,$content="",$atts=array()){


			if(!has_shortcode($content,'dt_linechart_item'))
            return "";

	        $regexshortcodes=
	        '\\['                              // Opening bracket
	        . '(\\[?)'                           // 1: Optional second opening bracket for escaping shortcodes: [[tag]]
	        . "(dt_linechart_item)"                     // 2: Shortcode name
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

		    extract(shortcode_atts(array(

		        'color'=>'',
		        'size'=>'',
		        'show_label'=>1,
		        'lblcolor'=>'',
		        'lblfsize'=>'',
		        'el_id'=>'',
		        'el_class'=>''

		    ), $atts,'dt_linechart'));


	        global $DEstyle;

		    $css_style=getCssMargin($atts);

		    if(''==$el_id){
                $el_id="dt-line-cart".getCssID();
            }

            $css_class=array();

            if(''!=$el_class){
               array_push($css_class, $el_class);
            }

			$diagram_data=array();
            $diagram_label=array();

            foreach ($matches as $line) {

            	$line_args=wp_parse_args(shortcode_parse_atts($line[3]),array(
		            'value'=>'',
	        		));

            		array_push($diagram_data, trim($line_args['value']));
            		array_push($diagram_label, trim(strip_tags($line[5])));
            }

           $compile="<div ";
            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            $compile.="class=\"".@implode(" ",$css_class)."\">";

		    $compile.="<canvas ".(($color)?" data-color=\"".trim($color)."\"":"").
		    (($size)?" data-size=\"".(int)trim($size)."\"":"").
		    (($diagram_data)?" data-source=\"".@implode(",",($diagram_data))."\"":"").
		    (($diagram_label)?" data-label=\"".@implode("||",$diagram_label)."\"":"").
		    (($show_label)?" data-showlabel=\"1\"":"").
		    (($lblcolor)?" data-lblcolor=\"".$lblcolor."\"":"").
		    (($lblfsize)?" data-lblfsize=\"".(int)trim($lblfsize)."\"":"")." class=\"lineChart\"></canvas>";

		    $compile.='</div>';   

            if(''!=$css_style){
              $DEstyle[]="#$el_id {".$css_style."}";
            }



		    return  $compile;



		}

		add_dt_element_render('dt_linechart','krypton_dt_linechart_shortcode');



		function krypton_dt_team_custom_item_shortcode($output,$content="",$atts=array()){
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
		    ), $atts,'dt_team_custom_item'));


	        global $DEstyle;

		    $css_style=getCssMargin($atts);

		    if(''==$el_id){
                $el_id="module_dt_team".getCssID();
            }

            $css_class=array('profile_team');

            if(''!=$el_class){
               array_push($css_class, $el_class);
            }

           $compile="<div ";
            if(''!=$el_id){
                $compile.="id=\"$el_id\" ";
            }

            $compile.="class=\"".@implode(" ",$css_class)."\">";

            $scollspy="";

	        if('none'!==$spy && !empty($spy)){
	            $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$scroll_delay.'}"';
	        }


			$featured_image = wp_get_attachment_image_src($image_url, 'full', false);
			$alt_image = get_post_meta($image_url, '_wp_attachment_image_alt', true);

	        $compile.='<div class="profile" '.$scollspy.'>
	                <figure>
	                    <div class="top-image">
	                        <img src="'.esc_url($featured_image[0]).'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>
	                    </div>
	                    <figcaption>'.
	                    ($title!=''?'<h3><span class="profile-heading">'.$title.'</span></h3>':"").
	                    ($sub_title!=''?'<span class="profile-subheading">'.$sub_title.'</span>':"").
	                    (!empty($text)?'<p>'.$text.'</p>':"");

	        if ($social_link=='show'){

	        	$socicons=array(
	        		'twitter'=>'icon-twitter',
	        		'linkedin'=>'icon-linkedin',
	        		'gplus'=>'icon-gplus',
	        		'facebook'=>'icon-facebook',
	        		'email'=>'icon-mail-alt',
	        		'pinterest'=>'icon-pinterest',
	        		'website'=>'icon-globe'
	        		);
	        
	            $compile.='<ul class="profile-scocial">';

	            foreach ($socicons as $key => $icon) {
	                if ($$key!= ''){
	                        $compile .= '<li><a href="'.esc_url(($key=='email')?"mailto:".$$key:$$key).'" class="teamlink" title="'.esc_attr($key).'" ><i class="'.$icon.'"></i></a></li>';  
	                }                    
	            }

	            $compile.="</ul>";
	        }
                                
         $compile.='<div class="figcap"></div>
                    </figcaption>
                </figure>
            </div>';


		    $compile.='</div>';   

            if(''!=$css_style){
              $DEstyle[]="#$el_id {".$css_style."}";
            }

		    return  $compile;
		}

		add_dt_element_render('dt_team_custom_item','krypton_dt_team_custom_item_shortcode');


		class DElement_Field_team_members extends DElement_Field{

		  function render($option=array(),$value=null){

		   $fieldname=$option['param_name'];
		   $fieldid=sanitize_html_class($fieldname);
		   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);


		     $output='<div class="checkbox-options '.$css.'">';
		     $array_value=@explode(",",trim($value));

		     $dependency=create_dependency_param($option);

		     $args = array(
				        'post_type' => 'team',
				        'post_status' => 'publish',
				        'posts_per_page' => -1,
				    );

	         $wp_query_cpt_posts = new WP_Query($args);

		    if($wp_query_cpt_posts->have_posts()){

				  $output.='<input type="checkbox" name="'.$fieldname.'_option" class="all-option checkbox-option" '.((!count($array_value) || in_array('all',$array_value))?'checked="checked"':'').'value="all" />'.__('All Team','Krypton');
			      while($wp_query_cpt_posts->have_posts()) : 
			      	$wp_query_cpt_posts->the_post();
			        $output.=' <input type="checkbox" name="'.$fieldname.'_option" class="checkbox-option" '.((in_array(get_the_ID(),$array_value))?'checked="checked"':'').'value="'.get_the_ID().'" /> '.get_the_title();
			      endwhile;
		    }

			  wp_reset_query();

		      $output.='<input type="hidden" name="'.$fieldname.'" class="param_value checkbox-input-value" value="'.$value.'" '.$dependency.'/>';
		      $output.='</div>';
		      return  $output;

		  }

		}

		if (is_plugin_active('detheme-team/detheme_team.php') || post_type_exists( 'team' )) {

			add_dt_element('dt_team',
			 array( 
			    'title' => __( 'Team Block', 'Krypton' ),
			    'icon'	=> 'dashicons-id-alt',
			    'options' => array(
			        array( 
			        'heading' => __( 'Module Title', 'detheme_builder' ),
			        'param_name' => 'title',
			        'value' => __( 'Team Block', 'Krypton' ),
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
			          'heading' => __( 'Select team members', 'Krypton' ),
			          'param_name' => 'cpt_ids',
			          'type' => 'team_members',
			        ),
			        array( 
			          'heading' => __( 'Items Count', 'Krypton' ),
			          'param_name' => 'items_per_page',
			          'default'=>6,
			          'type' => 'textfield',
			        ),
			        array( 
			          'heading' => __( 'Items per line', 'Krypton' ),
			          'param_name' => 'items_per_line',
			          'default'=>3,
			          'type' => 'textfield',
			        ),
			        array(
			          "type" => "radio",
			          "heading" => __('Order type', 'Krypton'),
			          "param_name" => "order",
			          "default"=>'asc',
			          'value' => array( 'asc' => __('Ascending','Krypton'), 'desc' => __('Descending','Krypton') )       
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
				) 
			);


			function krypton_dt_team_shortcode($output,$content="",$atts=array()){

			    extract(shortcode_atts(array(
	                'spy'=>'none',
	                'scroll_delay'=>300,
	                'el_id'=>'',
	                'el_class'=>'',
			        'order' => 'asc',
			        'cpt_ids' => '0',
			        'items_per_line' => 1,
			        'items_per_page'=>0,
			    ), $atts,'dt_team'));


		        global $DEstyle;

			    $css_style=getCssMargin($atts);

			    if(''==$el_id){
	                $el_id="module_dt_team".getCssID();
	            }

	            $css_class=array('profile_team');

	            if(''!=$el_class){
	               array_push($css_class, $el_class);
	            }

	           $compile="<div ";
	            if(''!=$el_id){
	                $compile.="id=\"$el_id\" ";
	            }

	            $compile.="class=\"".@implode(" ",$css_class)."\"><div class=\"row\">";
	            $scollspy="";


			    $wp_query = new WP_Query();

		        $args = array(
		            'post_type' => 'team',
		            'order' => strtoupper($order)
		        );

			    if (strlen($cpt_ids) > 0 && $cpt_ids !== "0" && $cpt_ids!='all') {
			        $cpt_ids = @explode(",", $cpt_ids);
			    }

			    if (is_array($cpt_ids) && count($cpt_ids) > 0) {
			        $args['post__in'] = $cpt_ids;
			    } 

			    if($items_per_page){
			        $args['posts_per_page']=$items_per_page;
			    }

			    $colclass="col-xs-12";

			    switch($items_per_line){
			        case '4':
			            $colclass="col-lg-3 col-md-4 col-sm-6 col-xs-12";
			            break;
			        case '3':
			            $colclass="col-md-4 col-sm-6 col-xs-12";
			            break;
			        case '2':
			            $colclass="col-sm-6 col-xs-12";
			            break;
			        default:
			            $colclass="col-xs-12";
			            break;
			    }

			    $spydly=$scroll_delay;



			    $wp_query->query($args);

			    if($wp_query->have_posts()){
			    	 while ($wp_query->have_posts()) : $wp_query->the_post();

			         $pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);
				     $position = $pagebuilder['page_settings']['team']['position'];

			    	 $image_url=get_post_thumbnail_id(get_the_ID());

		   	         if('none'!==$spy && !empty($spy)){
		            	 $spydly+=(int)$scroll_delay;
	        		}

			    	 $shortcode="[dt_team_custom_item ".
			    	 	($image_url?"image_url=\"".$image_url."\"":"").
			    	 	($spy!='none'?" spy=\"".$spy."\" scroll_delay=\"".$spydly."\"":"")." title=\"".esc_attr(get_the_title())."\" sub_title=\"".esc_attr($position)."\" text=\"".esc_attr(get_the_content())."\" social_link=\"show\" el_class=\"".$colclass."\"";

						if (isset($pagebuilder['page_settings']['icons']) && is_array($pagebuilder['page_settings']['icons']) && count($pagebuilder['page_settings']['icons'])){
							foreach ($pagebuilder['page_settings']['icons'] as $key => $value) {

								if ($value['link'] !== ''){
									$shortcode.=" ".($key=='google'?"gplus":$key)."=\"".$value['link']."\"";

								}
							}
						}

			    	 $shortcode.="][/dt_team_custom_item]";

			    	 $compile.=do_shortcode($shortcode);
			    	endwhile;
			    }

			    wp_reset_query();


			    $compile.='</div></div>';   

	            if(''!=$css_style){
	              $DEstyle[]="#$el_id {".$css_style."}";
	            }

			    return  $compile;

			}

			add_dt_element_render('dt_team','krypton_dt_team_shortcode');

		}/* end team */



		/* carousel navigation */

		function krypton_dt_carousel_navigation_btn($out){
			return array("<span class=\"btn btn-owl prev\"></span>","<span class=\"btn btn-owl next\"></span>");
		}

		add_filter('dt_carousel_navigation_btn','krypton_dt_carousel_navigation_btn');


		/* testimonials */
		if (is_plugin_active('detheme-team/detheme_testimoni.php') || post_type_exists( 'testimonials' )) {

			class DElement_Field_testimonial_members extends DElement_Field{

			  function render($option=array(),$value=null){

			   $fieldname=$option['param_name'];
			   $fieldid=sanitize_html_class($fieldname);
			   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);


			     $output='<div class="checkbox-options '.$css.'">';
			     $array_value=@explode(",",trim($value));

			     $dependency=create_dependency_param($option);

			     $args = array(
					        'post_type' => 'testimonials',
					        'post_status' => 'publish',
					        'posts_per_page' => -1,
					    );

		         $wp_query_cpt_posts = new WP_Query($args);

			    if($wp_query_cpt_posts->have_posts()){

					  $output.='<input type="checkbox" name="'.$fieldname.'_option" class="all-option checkbox-option" '.((!count($array_value) || in_array('all',$array_value))?'checked="checked"':'').'value="all" />'.__('All Testimonials','Krypton');
				      while($wp_query_cpt_posts->have_posts()) : 
				      	$wp_query_cpt_posts->the_post();
				        $output.=' <input type="checkbox" name="'.$fieldname.'_option" class="checkbox-option" '.((in_array(get_the_ID(),$array_value))?'checked="checked"':'').'value="'.get_the_ID().'" /> '.get_the_title();
				      endwhile;
			    }

				  wp_reset_query();

			      $output.='<input type="hidden" name="'.$fieldname.'" class="param_value checkbox-input-value" value="'.$value.'" '.$dependency.'/>';
			      $output.='</div>';
			      return  $output;

			  }

			}

			add_dt_element('dt_testimonial',
			 array( 
			    'title' => __( 'Testimonials', 'Krypton' ),
			    'icon'	=> 'dashicons-testimonial',
			    'options' => array(
			        array( 
			        'heading' => __( 'Module Title', 'detheme_builder' ),
			        'param_name' => 'title',
			        'value' => __( 'Testimonials', 'Krypton' ),
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
			          'heading' => __( 'Select testimonial', 'Krypton' ),
			          'param_name' => 'cpt_ids',
			          'type' => 'testimonial_members',
			        ),
			        array(
			          "type" => "radio",
			          "heading" => __('Sorting type', 'Krypton'),
			          "param_name" => "order",
			          "default"=>'new',
			          'value' => array( 'new' => __('New','Krypton'), 'random' => __('Random','Krypton') )       
			        ),
			        array( 
			          'heading' => __( 'Slide Speed', 'Krypton' ),
			          'param_name' => 'slide_speed',
			          'type' => 'textfield',
			          'default'=>400
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
				) 
			);


			function krypton_dt_testimonial_shortcode($output,$content="",$atts=array()){

			    extract(shortcode_atts(array(
	                'spy'=>'none',
	                'scroll_delay'=>300,
	                'el_id'=>'',
	                'el_class'=>'',
			        'sorting_type' => 'new',
			        'cpt_ids' => '0',
			        'slide_speed' => 400,
			    ), $atts,'dt_testimonial'));



			    $wp_query = new WP_Query();

			    switch ($sorting_type) {
			        case "new":
			            $sort_type = "post_date";
			            break;
			        case "random":
			            $sort_type = "rand";
			            break;
			    }

		        $args = array(
		            'post_type' => 'testimonials',
		            'orderby' => $sort_type
		        );

			    if (strlen($cpt_ids) > 0 && $cpt_ids !== "0" && $cpt_ids!='all') {
			        $cpt_ids = @explode(",", $cpt_ids);
			    }

			    if (is_array($cpt_ids) && count($cpt_ids) > 0) {
			        $args['post__in'] = $cpt_ids;
			    } 

			    $carousel_code="[dt_carousel pagination=\"1\" spy=\"$spy\" el_id=\"$el_id\" scroll_delay=\"$scroll_delay\" pagination_type=\"navigation\" ".
			    "el_class=\"".(empty($el_class)?"dt-testimonial":$el_class." dt-testimonial")."\" speed=\"$slide_speed\"]";




			    $wp_query->query($args);

			    if($wp_query->have_posts()){
			    	 while ($wp_query->have_posts()) : $wp_query->the_post();

						$pagebuilder = get_post_meta(get_the_ID(), "pagebuilder", true);
			            $testimonials_author = $pagebuilder['page_settings']['testimonials']['testimonials_author'];
			            $testimonials_company = $pagebuilder['page_settings']['testimonials']['company'];
			            $thumbnail_id=get_post_thumbnail_id( get_the_ID());
			            $featured_image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
			            $alt_image = get_post_meta($thumbnail_id, '_wp_attachment_image_alt', true);


			            if(strlen($testimonials_company) > 0) {
			                $coma=", ";
			            } else {
			                $coma="";
			            }

			    	 $carousel_code.="[dt_inner_row]";
			    	 $carousel_code.='<div class="testimoni col-lg-12">
	                    <div class="client-say">
	                        <blockquote>
	                            '.get_the_content().'
	                        </blockquote>   
	                    </div>'.((strlen($featured_image[0])>0)?'<div class="client-avatar">
	                        <img src="'.aq_resize($featured_image[0], 100, 100, true, true, true).'" alt="'.esc_attr($alt_image).'"/>
	                    </div>':'').'
	                    <div class="client-profile">
	                        <h4>'.$testimonials_author.'</h4>                    
	                        <span class="client-name">'.$testimonials_company.'</span>
	                    </div>
	                    <span class="date">'.mysql2date('d M Y',get_the_date()).'</span>
	                </div>';

		 		     $carousel_code.="[/dt_inner_row]";

			    	endwhile;
			    }

			    wp_reset_query();

			    $carousel_code.="[/dt_carousel]";

			    return do_shortcode($carousel_code);

			}

			add_dt_element_render('dt_testimonial','krypton_dt_testimonial_shortcode');
		}

		/* portfolio */

		if (is_plugin_active('detheme-port/detheme_port.php') || post_type_exists( 'port' )) {

			remove_dt_element_option('dt_portfolio','speed');
			remove_dt_element_option('dt_portfolio','scroll_page');
			remove_dt_element_option('dt_portfolio','autoplay');
			remove_dt_element_option('dt_portfolio','interval');


			class DElement_Field_krypton_portfolio_categories extends DElement_Field{

			  function render($option=array(),$value=null){

			   $fieldname=$option['param_name'];
			   $fieldid=sanitize_html_class($fieldname);
			   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);


			     $output='<div class="checkbox-options '.$css.'">';
			     $array_value=@explode(",",trim($value));

			     $dependency=create_dependency_param($option);

		        $args = array(
		          'orderby' => 'name',
		          'show_count' => 0,
		          'pad_counts' => 0,
		          'hierarchical' => 0,
		          'taxonomy' => 'portcat',
		          'title_li' => ''
		        );


		        $categories=get_categories($args);

			    if(count($categories)){

					  $output.='<input type="checkbox" name="'.$fieldname.'_option" class="all-option checkbox-option" '.((!count($array_value) || in_array('all',$array_value))?'checked="checked"':'').'value="all" />'.__('All','Krypton');
				      foreach ( $categories as $category ) {

				        $output.=' <input type="checkbox" name="'.$fieldname.'_option" class="checkbox-option" '.((in_array($category->term_id,$array_value))?'checked="checked"':'').'value="'.$category->term_id.'" /> '.$category->name;
				      }
			    }


			      $output.='<input type="hidden" name="'.$fieldname.'" class="param_value checkbox-input-value" value="'.$value.'" '.$dependency.'/>';
			      $output.='</div>';
			      return  $output;

			  }

			}

			 add_dt_element_option( 'dt_portfolio', array( 
		        'heading' => __( 'Column', 'Krypton' ),
		        'param_name' => 'column',
		        'class' => '',
		        'value'=>array(
		            '2'	=> __('Two Columns','Krypton') ,
		            '3'	=> __('Three Columns','Krypton') ,
		            '4'	=> __('Four Columns','Krypton') ,
		            ),
		        'type' => 'dropdown',
		        'default'=>'4',
		     ),'portfolio_num');   


		     add_dt_element_option( 'dt_portfolio', array( 
		        'heading' => __( 'Show Filter', 'Krypton' ),
		        'param_name' => 'show_filter',
		        'class' => '',
		        'value'=>array(
		            'on'=>__('Yes','Krypton'),
		            'off'=>__('No','Krypton')
		            ),
		        'type' => 'radio',
		        'default'=>'on',
		     ),'column');   


		     add_dt_element_option( 'dt_portfolio', array( 
		        'heading' => __( 'Category', 'detheme_builder' ),
		        'param_name' => 'portfolio_cat',
		        'value' => '',
		        'type' => 'krypton_portfolio_categories'
		     ),true);   

		     function krypton_dt_portfolio_shortcode($output,$content="",$atts=array()){
			    extract(shortcode_atts(array(
	                'spy'=>'none',
	                'portfolio_num'=>get_option('posts_per_page'),
	                'scroll_delay'=>300,
	                'el_id'=>'',
	                'show_filter'=>'on',
	                'el_class'=>'',
		            'portfolio_cat' => '',
		            'column' => 4,
		            'layout'=>1,
			    ), $atts,'dt_portfolio'));

		        global $DEstyle,$scollspy;

			    $css_style=getCssMargin($atts);

			    if(''==$el_id){
	                $el_id="portfolio-module".getCssID();
	            }

	            $css_class=array('portfolio-module',"col-".intval($column));

	            if(''!=$el_class){
	               array_push($css_class, $el_class);
	            }

	           $compile="<div ";
	            if(''!=$el_id){
	                $compile.="id=\"$el_id\" ";
	            }
	            $compile.="class=\"".@implode(" ",$css_class)."\">";


			    $args = array(
			        'post_type' => 'port',
			        'order' => 'DESC',
			        'paged' => 1,
			        'posts_per_page' => $portfolio_num,
			    );

			    if (strlen($portfolio_cat) > 0 && $portfolio_cat!='all') {

			    	$args['tax_query'] = array(
			            array(
			                'taxonomy' => 'portcat',
			                'field' => 'id',
			                'terms' => @explode(",", trim($portfolio_cat))
			            )
			        );

			    }

			    $temsAvailable=array();
			    $posts=array();
			    $i = 1;
			    $spydly=0;



			    $scollspy="";

			    $wp_query = new WP_Query($args);

			    if($wp_query->have_posts()):

				    while ($wp_query->have_posts()) : $wp_query->the_post();


					    if('none'!==$spy && !empty($spy)){

					        $spydly=$spydly+(int)$scroll_delay;

					        $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';

					    }

						if ($show_filter != "off") {
					        $new_term_list = get_the_terms(get_the_id(), "portcat");
					        if (is_array($new_term_list)) {
					            foreach ($new_term_list as $term) {
					                $temsAvailable[$term->term_id]=$term;

					            }
					        }
					    }

						ob_start();

						get_template_part( 'content', 'portfolio3');
						
						$posts[]=ob_get_clean();

					endwhile;
				endif;
				wp_reset_query();


			    if(count($posts)):


				if ($show_filter != "off") {
				    
				    $compile.='<div class="row" >
				    <nav id="featured-work-navbar" class="navbar navbar-default" role="navigation">
				        <div class="navbar-header">
				        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#dt-featured-filter">
				          <span class="sr-only">'.__('Toggle navigation','Krypton').'</span>
				          <span class="icon-bars"></span>
				          <span class="icon-bars"></span>
				          <span class="icon-bars"></span>
				        </button>
				      </div>
				     <div class="collapse navbar-collapse" id="dt-featured-filter">
				        <ul id="featured-filter" class="dt-portfolio-filter nav navbar-nav">
				            <li class="active"><a href="#" data-filter="*" class="active">'.__('All Category','Krypton').'</a></li>';
				    if(count($temsAvailable)){

				        foreach ($temsAvailable as $key => $value) {

				            $compile.='<li><a href="'.esc_url(add_query_arg("slug", $value->term_id)).'" data-filter=".'.esc_attr($value->slug).'">'.$value->name.'</a></li>';
				         }

				    }

				    $compile.='</ul>
				    </div>  
				    </nav>  
				    </div>';

				}


			            $compile.='<div class="portfolio-module-items">'.@implode("",$posts).'</div>';
			    endif;


			    $compile.='</div>';   

	            if(''!=$css_style){
	              $DEstyle[]="#$el_id {".$css_style."}";
	            }

			    return  $compile;
		     }

		     add_dt_element_render('dt_portfolio','krypton_dt_portfolio_shortcode');

		}

		/* dt twitter slider */

		add_dt_element_option('dt_twitter_slider',array(
		        'heading' => __( 'Text Color', 'Krypton' ),
		        'param_name' => 'color_text',
		        'class' => '',
		        'type' => 'colorpicker',
		        'default'=>'',
		 ));

		function krypton_dt_twitter_slider_shortcode($output,$content="",$atts=array()){
			
				extract( shortcode_atts( array(
			        'twitteraccount' => 'envato',
			        'numberoftweets' => 10,
			        'dateformat' => '%b. %d, %Y',
			        'twittertemplate' => '{{tweet}} {{date}}',
			        'isautoplay' => 'true',
			        'color_text'=>'',
		            'el_id'=>'',
		            'el_class'=>'',
			        'transitionthreshold' => '200' 
				), $atts,'dt_twitter_slider' ) );

		        global $DEstyle;


			    wp_enqueue_script( 'tweetie', get_template_directory_uri() . '/js/tweetie.js', array( 'jquery' ), '1.0', false);
			    wp_enqueue_style( 'twitter_slider',get_template_directory_uri() . '/css/twitter_slider.css', array(), '', 'all' );

			    $css_style=getCssMargin($atts);

			    if(''==$el_id){
	                $el_id="dt-twitter".getCssID();
	            }

	            $css_class=array('module_dt_twitter_slider');

	            if(''!=$el_class){
	               array_push($css_class, $el_class);
	            }

	           $compile="<div ";
	            if(''!=$el_id){
	                $compile.="id=\"$el_id\" ";
	            }
	            $compile.="class=\"".@implode(" ",$css_class)."\">";

	            $sequence_id="sequence".preg_replace('/[\-]/','',$el_id);


			    $compile .= '<div class="col col-xs-2 col-sm-1 container-icon">
                    <a href="https://twitter.com/'.$twitteraccount.'" target="_blank"><i class="icon-twitter"></i></a>
                </div>
                <div class="col col-xs-10 col-sm-11">
                    <div id="'.$sequence_id.'" class="sequence-twitter"></div>  
                </div>

        <script type="text/javascript">
            jQuery(document).ready(function($){
                $(\'#'.$sequence_id.'\').twittie({
                    username: \''.$twitteraccount.'\',
                    count: '.$numberoftweets.',
                    hideReplies: false,
                    dateFormat: \''.$dateformat.'\',
                    template: \''.$twittertemplate.'\',
                    apiPath: \''.DTPB_DIR_URL.'lib/twitter_slider/api/tweet.php\'
                },function(){
                    $(\'#'.$sequence_id.'\').append(\'<span class="sequence-prev"><i class="icon-left-open-big"></i></span><span class="sequence-next"><i class="icon-right-open-big"></i></span>\');

                    // Twitter Slider
                    var options'.$sequence_id.' = {
                        autoPlay: '.$isautoplay.',
                        nextButton: true,
                        prevButton: true,
                        preloader: false,
                        navigationSkip: true,
                        animateStartingFrameIn: '.$isautoplay.',
                        autoPlayDelay: 3000,
                        pauseOnHover : true,
                        transitionThreshold:'.$transitionthreshold.'
                    };

                    var $'.$sequence_id.' = $("#'.$sequence_id.'").sequence(options'.$sequence_id.').data("sequence");
                    $'.$sequence_id.'.afterLoaded = function(){$(".sequence-prev, .sequence-next").fadeIn(100);}

                    if ($(document).width()<=480) {
                        $("#'.$sequence_id.' .sequence-prev, #'.$sequence_id.' .sequence-next").hide();
                    }

                    $(document).resize(function() {
                        if ($(document).width()<=480) {
                            $("#'.$sequence_id.' .sequence-prev, #'.$sequence_id.' .sequence-next").hide();
                        }
                    });
                });
            });
        </script>';



			    $compile.='</div>';   

			    if($color_text!=''){
	              $DEstyle[]="#$sequence_id {color:".$color_text."}";
			    }
	            if(''!=$css_style){
	              $DEstyle[]="#$el_id {".$css_style."}";
	            }

			    return  $compile;

		}

	    add_dt_element_render('dt_twitter_slider','krypton_dt_twitter_slider_shortcode');


	    /* post carousel */


		class DElement_Field_post_categories extends DElement_Field{

		  function render($option=array(),$value=null){

		   $fieldname=$option['param_name'];
		   $fieldid=sanitize_html_class($fieldname);
		   $css=isset($option['class'])&& ''!=$option['class']?" ".(is_array($option['class'])?@implode(" ",$option['class']):$option['class']):"";//sanitize_html_class($fieldname);


		     $output='<div class="checkbox-options '.$css.'">';
		     $array_value=@explode(",",trim($value));

		     $dependency=create_dependency_param($option);

	        $args = array(
	          'orderby' => 'name',
	          'show_count' => 0,
	          'pad_counts' => 0,
	          'hierarchical' => 0,
	          'title_li' => ''
	        );


	        $categories=get_categories($args);

		    if(count($categories)){

				  $output.='<input type="checkbox" name="'.$fieldname.'_option" class="all-option checkbox-option" '.((!count($array_value) || in_array('all',$array_value))?'checked="checked"':'').'value="all" />'.__('All','Krypton');
			      foreach ( $categories as $category ) {

			        $output.=' <input type="checkbox" name="'.$fieldname.'_option" class="checkbox-option" '.((in_array($category->term_id,$array_value))?'checked="checked"':'').'value="'.$category->term_id.'" /> '.$category->name;
			      }
		    }


		      $output.='<input type="hidden" name="'.$fieldname.'" class="param_value checkbox-input-value" value="'.$value.'" '.$dependency.'/>';
		      $output.='</div>';
		      return  $output;

		  }

		}
		add_dt_element('post_carousel',
		 array( 
		    'title' => __( 'Featured Post', 'Krypton' ),
		    'icon'	=> 'dashicons-feedback',
		    'options' => array(
		        array( 
		        'heading' => __( 'Module Title', 'detheme_builder' ),
		        'param_name' => 'title',
		        'value' => __( 'Featured Post', 'Krypton' ),
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
		          'heading' => __( 'Number of posts', 'Krypton' ),
		          'param_name' => 'number_of_posts',
		          'type' => 'textfield',
		        ),
		        array(
		        'heading' => __( 'Column', 'Krypton' ),
		        'param_name' => 'col',
		        'class' => '',
		        'value'=>array(
		            '1'	=> __('One Column','Krypton') ,
		            '2'	=> __('Two Columns','Krypton') ,
		            '3'	=> __('Three Columns','Krypton') ,
		            '4'	=> __('Four Columns','Krypton') ,
		            ),
		        'type' => 'dropdown',
		        'default'=>'4',
	        	),

		        array(
		        'heading' => __( 'Catehories', 'Krypton' ),
		        'param_name' => 'category',
		        'class' => '',
		        'type' => 'post_categories',
	        	),
		        array(
		          "type" => "radio",
		          "heading" => __('Sorting type', 'Krypton'),
		          "param_name" => "order",
		          "default"=>'new',
		          'value' => array( 'new' => __('New','Krypton'), 'random' => __('Random','Krypton') )       
		        ),
		        array(
		          "type" => "radio",
		          "heading" => __('Layout Type', 'Krypton'),
		          "param_name" => "type",
		          "default"=>'1',
		          'value' => array( '1' => __('Type 1: Show author avatar','Krypton'), '2' => __('Type 2: No author avatar','Krypton') )       
		        ),
		        array( 
		          'heading' => __( 'Slide Speed', 'Krypton' ),
		          'param_name' => 'speed',
		          'type' => 'textfield',
		          'default'=>400
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

		function krypton_post_carousel_shortcode($output,$content="",$atts=array()){
				extract( shortcode_atts( array(
	                'number_of_posts' => 12,
	                'category'=>0,
	                'sorting_type'=>'new',
	                'show_text'=>'no',
	                'col'=>3,
	                'speed'=>400,
	                'type'=>0,
	                'spy'=>'none',
	                'scroll_delay'=>300,
		            'el_id'=>'',
		            'el_class'=>'',
				), $atts,'post_carousel' ) );

		        global $DEstyle,$krypton_Scripts,$dt_revealData;


			    $css_style=getCssMargin($atts);

			    if(''==$el_id){
	                $el_id="featured".getCssID();
	            }

	            $css_class=array();

	            if(''!=$el_class){
	               array_push($css_class, $el_class);
	            }

	           $compile="<div ";
	            if(''!=$el_id){
	                $compile.="id=\"$el_id\" ";
	            }
	            $compile.="class=\"".@implode(" ",$css_class)."\">";

	            $widgetID="carousel".preg_replace('/[\-]/','', $el_id);


	            switch ($sorting_type) {
	                case "new":
	                    $sort_type = "post_date";
	                    break;
	                case "random":
	                    $sort_type = "rand";
	                    break;
	            }

	            

	            $args = array(
	                'posts_per_page' => $number_of_posts,
	                'post_type' => 'post',
	                'post_status' => 'publish',
	                'cat' => $category,
	                'featured'=>true,
	                'meta_key'=>'_thumbnail_id',
	                'orderby' => $sort_type,
	                'order' => 'DESC'

	            );


		         $query = new WP_Query();
		         $query->query($args);

		         if($query->have_posts()):

			            wp_register_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array( 'jquery' ), '', false );
			            wp_enqueue_script( 'owl.carousel');

				      if($type==2){
				            if($col > 2){?>
			<style>
				@media (min-width: 1024px) and (max-width: 1200px) {
				    #<?php print $widgetID;?> .owl-slide {
				    max-width: 300px;
				    margin: 40px 20px;
				  }
				}
				</style>
				            <?php
				            }


				            $compile.='<div id="'.$widgetID.'" class="dt-featured-posts owl-carousel">';


				            $thumbSize=1200/$col;
				            if($query->have_posts()):
				            $i=0;
				            $spydly=0;
				             while ($query->have_posts()) : 
				                     $query->the_post();   
				                     $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'single-post-thumbnail');
				                     $featured_image_url = aq_resize($featured_image[0], $thumbSize, $thumbSize, true, true, true);
				                     $alt_image = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

				                     $post=get_post();
   				                     $post_excerpt = ((strlen($post->post_excerpt) > 0) ? smarty_modifier_truncate($post->post_excerpt, 100, "") : smarty_modifier_truncate(strip_tags(get_the_content()), 100, ""));


				                    if (strlen($featured_image[0]) > 0) {

				                            $full_image_url = $featured_image[0];

				                            $excerpt=($post_excerpt)?'<div class="md-description"><p>'.$post_excerpt.'</p></div>':"";
				                            $modalContent = '<div id="'.$widgetID.'-'.get_the_ID().'" class="popup-gallery md-modal md-effect-15">
				                                            <div class="md-content">
				                                                <img src="'.esc_url($featured_image[0]).'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>
				                                                '.$excerpt.'
				                                                <button class="button md-close right btn-cross"><i class="icon-cancel"></i></button>
				                                           </div></div>';

				                           array_push($dt_revealData,$modalContent);

				                     } else {

				                            $modalContent = '';

				                     }


				                    $scollspy="";

				                    if('none'!==$spy && !empty($spy) && $i < $col){

				                        $spydly=$spydly+(int)$scroll_delay;
				                        $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
				                    }

				                    $compile.='<div class="owl-slide col-sd-12" '.$scollspy.'>
				                        <div class="top-image">
				                        <img src="'.esc_url($featured_image_url).'" alt="'.esc_attr($alt_image).'"/>
				                        </div>
				                        <div class="description">
				                                <div class="slide-content">
				                                <h4>'.get_the_title().'</h4>
				                                </div>
				                        <div class="nav-slide"><a href="'.get_permalink().'" class="btn icon-link"></a><a onClick="return false;" data-modal="'.$widgetID.'-'.get_the_ID().'" class="md-trigger btn icon-zoom-in"></a></div>
				                        </div>
				                        </div>';

				                $i++;

				            endwhile;  

				            endif;

				             wp_reset_postdata();


				            $compile.='</div><div class="owl-carousel-navigation">
				                       <a class="btn btn-owl prev"></a>
				                       <a class="btn btn-owl next"></a></div>';

				           $script='jQuery(document).ready(function($) {
				            \'use strict\';
				            var '.$widgetID.' = $("#'.$widgetID.'");
				            try{
				           '.$widgetID.'.owlCarousel({
				                items       : '.$col.', //10 items above 1000px browser width
				                itemsDesktop    : [1200,3], //5 items between 1000px and 901px
				                itemsDesktopSmall : [1023,2], // 3 items betweem 900px and 601px
				                itemsTablet : [768,2], //2 items between 600 and 0;
				                itemsMobile : [600,1], // itemsMobile disabled - inherit from itemsTablet option
				                pagination  : false,
				                slideSpeed  : '.$speed.'
				            });
				            '.$widgetID.'.parent().find(".next").click(function(){
				                '.$widgetID.'.trigger(\'owl.next\');
				              });
				            '.$widgetID.'.parent().find(".prev").click(function(){
				                '.$widgetID.'.trigger(\'owl.prev\');
				              });
				            '.$widgetID.'.owlCarousel(\'reload\');

				            $(".owl-slide",'.$widgetID.')
				                .each(function(){
				                        this.slide = $(this).find(\'.top-image img\');
				                        this.slide.height($(this).width());
				                        $(this).height($(this).width());
				                        this.desc = $(this).find(\'.description\').height(this.slide.height());
				                })
				                .hover(function(){
				                        this.desc.animate({\'margin-top\':-this.slide.height()});
				                },function(){
				                        this.desc.animate({\'margin-top\':\'0px\'});
				                });
				           }
				            catch(err){}
				            });';


				        array_push($krypton_Scripts,$script);

				        }

				        else{

				            $compile.='<div id="'.$widgetID.'" class="dt-blog-posts owl-carousel">';

				            $thumbSize=1200/$col;
				             if($query->have_posts()):

				            $i=0;
				            $spydly=0;


				             while ($query->have_posts()) : 
				                    $query->the_post();   

				                    $featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'single-post-thumbnail');
				                    $featured_image_url = aq_resize($featured_image[0], $thumbSize, $thumbSize, true, true, true);
				                    $alt_image = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

				                    $post=get_post();
  				                    $post_excerpt = ((strlen($post->post_excerpt) > 0) ? smarty_modifier_truncate($post->post_excerpt, 100, "") : smarty_modifier_truncate(strip_tags(get_the_content()), 100, ""));
				                    $avatar_url = get_avatar_url(get_the_author_meta( 'ID' ),array('size'=>85 ));
				                    $scollspy="";
				                    if('none'!==$spy && !empty($spy) && $i < $col){
				                        $spydly=$spydly+(int)$scroll_delay;
				                        $scollspy='data-uk-scrollspy="{cls:\''.$spy.'\', delay:'.$spydly.'}"';
				                    }
									
									$countview=0;

									$countview = get_post_meta(get_the_ID(), 'post_views_count', true);
									if($countview==''){
										delete_post_meta(get_the_ID(), 'post_views_count');
										add_post_meta(get_the_ID(), 'post_views_count', '0');
									}

				                    $compile.='

				                    <div class="col-sd-12" '.$scollspy.'>
				                        <div class="owl-slide">
				                            <figure>
				                                <div class="top-image">
				                                <img src="'.esc_url($featured_image_url).'" alt="'.esc_attr($alt_image).'"/>
				                                </div>
				                                <div class="thumb-image">
				                                    <img src="'.esc_url($avatar_url).'" alt="'.esc_attr(get_the_author_meta( 'nickname' ) ).'"/>
				                                </div>
				                                <figcaption>
				                                    <div class="description">
				                                    <a href="'.get_permalink().'" class="post-title">'.strtoupper(get_the_title()).'</a>
				                                    '.$post_excerpt.'
				                                     </div>   
				                                </figcaption>
				                            </figure>
				                            <div class="mini-panel">
				                                <div class="col-sm-4 col-md-4 col-xs-4"><i class="icon-clock-8"></i>'.get_the_date('d M').'</div>
				                                <div class="col-sm-4 col-md-4 col-xs-4"><i class="icon-chat-inv"></i>'.get_comments_number(get_the_ID()).'</div>
				                                <div class="col-sm-4 col-md-4 col-xs-4"><i class="icon-eye-5"></i>'.$countview.'</div>
				                            </div>
				                        </div>
				                    </div>';

				                    $i++;

				            endwhile;  

				            endif;

				             wp_reset_postdata();

				            $compile.='</div><div class="owl-carousel-navigation">
				                       <a class="btn btn-owl prev"></a>
				                       <a class="btn btn-owl next"></a></div>';

				            $script='jQuery(document).ready(function($) {
				            \'use strict\';
				            var '.$widgetID.' = $("#'.$widgetID.'");
				            try{
				           '.$widgetID.'.owlCarousel({
				                items       : '.$col.', itemsDesktop    : [1200,3], itemsDesktopSmall : [1023,2], itemsTablet : [768,2], itemsMobile : [600,1], pagination  : false, slideSpeed  : '.$speed.'});
				            '.$widgetID.'.parent().find(".next").click(function(){
				                '.$widgetID.'.trigger(\'owl.next\');
				              });
				            '.$widgetID.'.parent().find(".prev").click(function(){
				                '.$widgetID.'.trigger(\'owl.prev\');
				              });
				            '.$widgetID.'.owlCarousel(\'reload\');
				            }
				            catch(err){}

				            });';

				        array_push($krypton_Scripts,$script);

				        }  

		         endif;

			    $compile.='</div>';   

	            if(''!=$css_style){
	              $DEstyle[]="#$el_id {".$css_style."}";
	            }

			    return  $compile;


		}


		add_dt_element_render('post_carousel','krypton_post_carousel_shortcode');

	}

}

function krypton_get_registered_sidebars(){
	 global $wp_registered_sidebars;

        $sidebarsOption=array();

        if(count($wp_registered_sidebars)){

            foreach($wp_registered_sidebars as $sidebar){

                $sidebarsOption[$sidebar['id']]=$sidebar['name'];


            }
        }

        return $sidebarsOption;
}
?>