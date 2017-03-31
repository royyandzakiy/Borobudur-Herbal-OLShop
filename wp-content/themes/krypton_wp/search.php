<?php
defined('ABSPATH') or die();

/**
 * The template for displaying Search Results pages
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 * @version 3.0
 */

global $krypton_config;

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


<div class="blog_classic <?php echo $class_sidebar;?>">
	<section class="subpage-banner blog-classic-banner">
		<div class="container">
			<div class="row header-group">
				<div class="col-sm-8 col-sm-12">
					<h1><?php echo get_bloginfo('name');?></h1>
					<p><?php echo get_bloginfo('description');?></p>
				</div>
				<div class="col-xs-4 hidden-xs">
					<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
				</div>		
			</div>
		</div>	
	</section>	
	<div class="container blog_classic_posts">
		<div class="row">
<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
<?php	} else { ?>
			<div class="col-sm-8<?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?>">
<?php	} ?>

			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( 'Search Results for: %s', 'Krypton' ), get_search_query() ); ?></h1></h1>
			</header>
<?php
				if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();

						get_template_part( 'content', get_post_format() );

					endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
?>
				<!-- Pagination -->
				<div class="row">
					<div class="paging-nav col-xs-10 col-xs-offset-2">
						<span class="float-left">
							<span class="paging-text paging-inline">
								<?php previous_posts_link('<span class="btn-arrow paging-inline"><i class="icon-left-open-big"></i></span> '.__('Previous','Krypton')); ?>
							</span>
						</span>
						<span class="float-right">
							<span class="paging-text paging-inline">				
								<?php next_posts_link(__('Next','Krypton').' <span class="btn-arrow paging-inline"><i class="icon-right-open-big"></i></span>'); ?>
							</span> 
						</span>
					</div>
				</div>
				<!-- /Pagination -->
				
			</div>


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
		
		</div>			
	</div>
</div>
<?php
get_footer();
?>