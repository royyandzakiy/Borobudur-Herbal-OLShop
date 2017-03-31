<?php
defined('ABSPATH') or die();

/**
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 */

global $krypton_config,$paged,$rowid;


$post_per_page=3;

$rowid=array();

$navigations=array();

function filterRow($k){
	global $rowid;

	if(in_array($k->ID,$rowid))
		return false; 
	
	array_push($rowid,$k->ID);
	
	return $k;
}

$posts=array();


$args = array(
  'orderby' => 'name',
  'show_count' => 0,
  'pad_counts' => 0,
  'hierarchical' => 0,
  'taxonomy' => 'portcat',
  'title_li' => ''
);


$categories=get_categories($args);

$navbar="";

if($categories && count($categories)){

	$navbar.='<nav id="featured-work-navbar" class="navbar navbar-default" role="navigation">
	<div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#dt-featured-filter">
      <span class="sr-only">'.__('Toggle navigation','Krypton').'</span>
      <span class="icon-bars"></span>
      <span class="icon-bars"></span>
      <span class="icon-bars"></span>
    </button>
  </div>
 <div class="collapse navbar-collapse" id="dt-featured-filter">
	<ul id="featured-filter" data-isotope="portfolios" class="dt-featured-filter nav navbar-nav">
	<li class="active"><a href="#" data-filter="*" class="active">'.__('All Project','Krypton').'</a></li>';

			foreach($categories as $menuObj){

				$navbar.='<li><a href="#" data-filter=".'.$menuObj->slug.'">'.$menuObj->name.'</a></li>';

				$queryargs = array(
		                'post_type' => 'port',
						'no_found_rows' => false,
						'posts_per_page'=>$post_per_page,
						'portcat'=>$menuObj->slug
					);

				$queryargs['post__not_in']=$rowid;
	
				$query = new WP_Query( $queryargs );	
				$max_page=$query->max_num_pages;

				$query->posts=array_filter($query->posts,'filterRow');


				if ( $query->have_posts() ) :

				while ( $query->have_posts() ) : 
				
						$query->the_post();
						
						ob_start();

						get_template_part( 'content', 'portfolio');
						
						$posts[]=ob_get_contents();
						ob_end_clean();

						
				endwhile;
				
				if($max_page > 1 ):
				
					array_push($navigations,$menuObj->slug);
					endif; 
				endif;

			wp_reset_query();

			}

	$navbar.='</ul></div></nav>';

}

if(count($posts)):?>

<section class="portfolio">
	<div class="container">
<div class="row" >
<?php print $navbar;?>
</div>
</div>
<div class="row" >
	<div class="container">
	<div id="portfolios" class="portfolio-container col-4 col-xs-12">
<?php 	if(count($posts)):
			
			print @implode("",$posts);
		
		endif;
		
		
		if(count($navigations) && count($posts)):
			
			foreach($navigations as $navigation){


				$queryargs = array(
		                'post_type' => 'port',
						'no_found_rows' => false,
						'posts_per_page'=>$post_per_page,
						'portcat'=>$navigation
					);

				$queryargs['post__not_in']=$rowid;
	
				$query = new WP_Query( $queryargs );		

				$max_page=$query->max_num_pages;

			if($query->have_posts()):

			print '<article class="portfolio-item more-post '.$navigation.'"><a class="btn-more" href="'.get_term_link( $navigation, 'portcat' ).'?&page=1&in='.@implode(',',$rowid).'">
					+</a> '.__('Load More','Krypton').'</article>'."\n";
	
				endif;
			}
			wp_reset_query();
		
		endif;
?>
</div></div>
</div>
</section>
<?php endif;
?>