<?php
defined('ABSPATH') or die();

/**
 *
 * this part from portfolio layout
 *
 * @package WordPress
 * @subpackage Krypton
 * @version 3.0
 * @since Krypton 3.0
 */
global $dt_revealData,$scollspy;
$terms = get_the_terms(get_the_ID(), 'portcat' );
$cssitem=array();


if(!$imgorientation = get_post_meta( get_the_ID(), 'post_box_size', true )){
	$imgorientation="square";

}

$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full',false); 
$alt_image = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

if($featured_image){
	$image=aq_resize($featured_image[0], 320, 320, true, true, true);

}

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
	<div class="top-image"<?php print $scollspy;?>>
	<?php if (isset($image) && !empty($image)) { ?>
	<a href="<?php the_permalink(); ?>"><img class="img-responsive" src="<?php echo esc_url($image); ?>" alt="<?php print esc_attr($alt_image);?>" /></a>
	<?php }?>
	</div>
	<div class="description">
                    <div class="slide-content">
                    <h4><?php print get_the_title();?></h4>
                    </div>
                <div class="nav-slide"><a href="<?php the_permalink();?>" class="btn icon-link"></a><a onClick="return false;" data-modal="modal_portfolio_<?php print get_the_ID();?>" class="md-trigger btn icon-zoom-in"></a></div>
    </div>
</article>