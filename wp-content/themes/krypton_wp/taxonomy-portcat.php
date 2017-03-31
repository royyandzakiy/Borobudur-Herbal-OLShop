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

global $krypton_config,$paged,$wp_query;

$type='';
if(isset($_GET['in'])){
	set_query_var('post__not_in',trim($_GET['in']));


}

if(isset($_GET['type'])){
	$type=2;
}

$paged=get_query_var( 'page' );

$post_not_in=get_query_var('post__not_in');

if ( !$paged ){
		$paged = 1;
}

$nextpage = intval($paged) + 1;
	

get_header();
?>
	<div class="container">
	<div id="portfolios" class="portfolio-4col col-xs-12">

<?php

				$post_per_page=3;


				$queryargs = array(
		                'post_type' => 'port',
						'no_found_rows' => false,
						'posts_per_page'=>$post_per_page,
						'paged'=>$paged,
						'post__not_in'=>@explode(',',$post_not_in),
                		'portcat' =>get_query_var( 'portcat' )
					);

	
				$query = new WP_Query( $queryargs );		

				$max_page=$query->max_num_pages;

				if ( $query->have_posts() ) :
				while ( $query->have_posts() ) : 
				
						$query->the_post();
						get_template_part( 'content', 'portfolio'.$type);
						
				endwhile;

				if($nextpage <= $max_page ){

				print '<article class="portfolio-item more-post '.get_query_var( 'portcat' ).'"><a class="btn-more" href="'.get_term_link( get_query_var( 'portcat' ), 'portcat' ).'?&page='.$nextpage.'&'.(($type)?"type=".$type."&":"").'in='.$post_not_in.'">
					+</a> '.__('Load More','Krypton').'</article>';
				
				}
				
				endif;
?>
</div></div>
<?php
get_footer();
?>