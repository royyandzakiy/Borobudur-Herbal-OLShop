<?php
defined('ABSPATH') or die();

/**
 *
 * this part from portfolio layout
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 * @version 3.0
 */
global $dt_revealData;
$terms = get_the_terms(get_the_ID(), 'portcat' );
$cssitem=array();


if(!$imgorientation = get_post_meta( get_the_ID(), 'post_box_size', true )){
	$imgorientation="square";

}

$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full',false); 

if($featured_image){
	switch ($imgorientation) {
		case 'landscape':
			$image=aq_resize($featured_image[0], 590, 285, true, true, true);
			break;
		case 'portrait':
			$image=aq_resize($featured_image[0], 285, 590, true, true, true);
			break;
		case 'big square':
			$image=aq_resize($featured_image[0], 590, 590, true, true, true);
			break;
		case 'square':
		default:
			$image=aq_resize($featured_image[0], 285, 285, true, true, true);
			break;
	}
}

$alt_image = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

$cssitem[]=str_replace(' ',"-",$imgorientation);
if ( !empty( $terms ) ) {
      
      foreach ( $terms as $term ) {
        $cssitem[] =sanitize_html_class($term->slug, $term->term_id);
      }

}

$modalcontent='<div id="modal_portfolio_'.get_the_ID().'" class="popup-gallery md-modal md-effect-15">
	<div class="md-content">'.($featured_image?'<img src="'.esc_url($featured_image[0]).'" class="img-responsive" alt="'.esc_attr($alt_image).'"/>':"").'		
		<div class="md-description">'.get_the_excerpt().'</div>
		<button class="button md-close right btn-cross"><i class="icon-cancel"></i></button>
	</div>
</div>';

array_push($dt_revealData,$modalcontent);
?>
<article id="port-<?php print get_the_ID();?>" <?php post_class('portfolio-item hover-this '.@implode(' ',$cssitem),get_the_ID()); ?>>
	<div class="top-image">
	<?php if (isset($image) && !empty($image)) { ?>
	<a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo esc_url($image); ?>" alt="<?php print esc_attr($alt_image);?>" /></a>
	<?php }?>
	</div>
	<div class="description">
		<div class="nav-slide"><a onClick="return false;" data-modal="modal_portfolio_<?php print get_the_ID();?>" class="md-trigger btn icon-zoom-in"></a><a href="<?php the_permalink(); ?>" class="btn icon-link"></a></div>
	</div>
</article>