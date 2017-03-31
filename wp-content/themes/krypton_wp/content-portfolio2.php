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
		case 'square':
		default:
			$image=aq_resize($featured_image[0], 285, 285, true, true, true);
			$imgorientation='square';
			break;
	}
}

$cssitem[]=str_replace(' ',"-",$imgorientation);
$out=array();
if ( !empty( $terms ) ) {
      
      foreach ( $terms as $term ) {
        $cssitem[] =sanitize_html_class($term->slug, $term->term_id);
        $out[] ='<li><a href="'
        .    get_term_link( $term->slug, 'portcat' ) .'">'
        .    $term->name
        . "</a></li>\n";
      }

}

?>

<article id="port-<?php print get_the_ID();?>" <?php post_class('portfolio-item '.@implode(' ',$cssitem),get_the_ID()); ?>>
	<div class="top-image">
	<?php if (isset($image) && !empty($image)) { 
		$alt_image = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);

?>
	<a href="<?php the_permalink();?>">
		<img class="img-responsive" src="<?php echo esc_url($image); ?>" alt="<?php print esc_attr($alt_image);?>" />
	</a>
	<?php }?>

	</div>
	<div class="description">
		<a href="<?php the_permalink();?>" class="portfolio-link-detail"><?php print wp_trim_chars(get_the_title(),25);?></a>
		<ul class="portfilio-meta">
			<li><?php print get_the_date( 'M j, Y', '', '', true); ?></li>
			<?php print (count($out)) ?implode("\n",$out):"";?>
		</ul>
		<div class="portfolio-description"><?php 
		print get_the_excerpt();?>
		</div>
	</div>
</article>
