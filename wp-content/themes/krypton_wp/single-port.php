<?php
defined('ABSPATH') or die();

/**
 * The portfolio template
 *
 * Used for single post.
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 */

global $krypton_config,$post;

get_header();?>

<?php 


$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['krypton-sidebar']) && count($sidebars['krypton-sidebar'])){
	$sidebar='krypton-sidebar';
}
elseif(isset($sidebars['sidebar-1']) && !isset($sidebars['krypton-sidebar']) && count($sidebars['sidebar-1'])){
	$sidebar='sidebar-1';
}


$sidebar_position = get_post_meta( get_the_ID(), 'sidebar_position', true );

if(!isset($sidebar_position) || empty($sidebar_position) || $sidebar_position=='default'){

	switch ($krypton_config['layout']) {
		case 1:
			$sidebar_position = "nosidebar";
			break;
		case 2:
			$sidebar_position = "sidebar-left";
			break;
		case 3:
			$sidebar_position = "sidebar-right";
			break;
		default:
			$sidebar_position = "sidebar-left";
	}


}

if(!$sidebar){
	$sidebar_position = "nosidebar";
}


set_query_var('sidebar',$sidebar);
$class_sidebar = $sidebar_position;

?>
<div  <?php post_class(); ?>>
<div class="blog-single-post <?php echo $class_sidebar;?>">
<section class="subpage-banner blog-classic-banner">
		<div class="container">
			<div class="row header-group">
				<div class="col-sm-8 col-sm-12">
				</div>
				<div class="col-xs-4 hidden-xs">
				</div>		
			</div>
		</div>	
	</section>	
	<div class="container">
		<div class="row">

<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
<?php	} else { ?>
			<div class="col-sm-8<?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?>">
<?php	} ?>
<?php
	//Update number of post views 

$commentopen=(isset($krypton_config))?$krypton_config['dt-comment-open']:true;

while ( have_posts() ) : 
the_post();

$hideSocial = get_post_meta( $post->ID, 'show_social', true );
$hideComment = get_post_meta( $post->ID, 'show_comment', true );

dt_set_post_views(get_the_ID()); 

	$terms = get_the_terms(get_the_ID(), 'portcat' );
	$out=array();
	if ( !empty( $terms ) ) {
      

      foreach ( $terms as $term ) {

        $out[] ='<a href="'
        .    get_term_link( $term->slug, 'portcat' ) .'">'
        .    $term->name
        . "</a>\n";
      }

     }

$content=do_shortcode(get_the_content());
//$content=get_the_content();

global $carouselGallery;
?>

				<div class="row">
					<div class="col-sm-12 portfolio-content">
						<?php 
							if(isset($carouselGallery) && !empty($carouselGallery)){
								print $carouselGallery;
							}
						?>
						<!-- carousel -->		
						<h2 class="portfolio-title"><?php the_title();?></h2>
						<div class="row meta-info">
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-clock-circled"></i><?php print get_the_date( 'j F Y', '', '', true); ?></span></div>
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-comment"></i><?php comments_number(); ?></span></div>
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-eye-5"></i><?php echo dt_get_post_views(get_the_ID()); ?></span></div>
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-tags"></i><?php print (count($out)) ?implode("<br/>",$out):"";?></span></div>
						</div>
						<div class="portfolio-description"><?php print nl2br($content); ?></div>
					<?php if('yes'!==$hideComment && $commentopen):
							?>
						<hr/>
						<div class="comment-count">
							<?php comments_number(); ?>
						</div>
						<?php 
						print (get_comments_number())?"<hr/>":"";
						endif;?>	
					</div>

				</div>



				<?php if ( $commentopen && comments_open()) :?>
				<div class="row">
					<div class="row section-comment">
					<?php comments_template('/comments.php', true); ?>
					</div>
				</div>
				<?php endif;

				endwhile;?>
				<!-- Section Comment -->

			</div><!-- Article Post -->


<?php if ('sidebar-right'==$sidebar_position) { ?>
			<div class="col-sm-4 sidebar">
				<?php get_sidebar(); ?>
			</div>
<?php }
	elseif ($sidebar_position=='sidebar-left') { ?>
			<div class="col-sm-4 sidebar col-sm-pull-8">
				<?php get_sidebar(); ?>
			</div>
<?php }?>

		</div><!-- .row -->

	</div><!-- .container -->

</div><!-- .blog-single-post -->
</div>


<?php

get_footer();

?>