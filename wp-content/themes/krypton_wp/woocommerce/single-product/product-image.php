<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product;
global $krypton_config, $dt_revealData;

?>

	<?php
		if ( has_post_thumbnail() ) {
            wp_register_script( 'owl.carousel', get_template_directory_uri() . '/js/owl.carousel.js', array( 'jquery' ), '', false );
            wp_enqueue_script( 'owl.carousel');

			$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
			$image       		= get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title' => $image_title
				) );
			$attachment_count   = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
				$attachment_ids = $product->get_gallery_attachment_ids();
				echo "<div id=\"owl_large_thumbnail\" class=\"owl-carousel\">";
				$i = 0;
				$loop = 0;
				foreach ( $attachment_ids as $attachment_id ) {
					$classes = array( 'zoom' );

					$image_link = wp_get_attachment_url( $attachment_id );

					if ( ! $image_link )
						continue;

					$itemprop 	 = ($i==0) ? 'itemprop="image"' : '';
					$image       = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_thumbnail' ) );
					$image_class = esc_attr( implode( ' ', $classes ) );
					$image_title = esc_attr( get_the_title( $attachment_id ) );

					echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<div class="item"><a class="md-trigger" href="%s" data-modal="modal_product_%s" onclick="return false;"><span '.$itemprop.'><img class="img-responsive big-thumbnail" src="%s" alt="%s"></span></a></div>', $image_link, $attachment_id, $image_link, $image_title), $attachment_id, $post->ID, $image_class );

					$md_effect = '';
				    if ($krypton_config['dt-select-modal-effects']=='') { 
				    	$md_effect = 'md-effect-15';
				    } else {
				    	$md_effect = $krypton_config['dt-select-modal-effects'];
				    } 

				    $output_popup = '<div id="modal_product_'.$attachment_id.'" class="popup-gallery md-modal '.$md_effect.'">
				        <div class="md-content">
				          <img src="'. $image_link .'" class="img-responsive" alt="'.$image_title.'"/>';

				    //the_post_thumbnail();
				    //$image_caption = get_post(get_post_thumbnail_id())->post_excerpt;
				    $image_attachment = get_post($attachment_id);
				    $image_caption = $image_attachment->post_content;

				    //$image_caption = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);

				    //$image_metadata = wp_get_attachment_metadata($attachment_id);
				    //$image_caption = $image_metadata['image_meta']['caption'];
				    if(!empty($image_caption)):
				    	$captiontag = 'dd';
				    	$output_popup.='<div class="md-description">'."
				            <{$captiontag} class='wp-caption-text gallery-caption-modal'>
				        " . wptexturize($image_caption) . "
				        </{$captiontag}>".'
				          </div>';
				    endif;

				    $output_popup.='<button class="button md-close right btn-cross"><i class="icon-cancel"></i></button>
				        </div>
				      </div>'."\n";

				    array_push($dt_revealData, $output_popup);
				    $i++;
				    $loop++;
				}
				echo "</div>";
			} else {
				$gallery = '';
				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img class="img-responsive big-thumbnail" src="%s" alt="%s">', $image_link, $image_title), $post->ID );
			}


			//echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );

		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" class="img-responsive big-thumbnail" />', wc_placeholder_img_src() ), $post->ID );
		}
	?>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>
