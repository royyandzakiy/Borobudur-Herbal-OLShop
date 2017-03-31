<?php
defined('ABSPATH') or die();

/**
 * The template for displaying Category pages
 *
 * @package Krypton
 */

get_header(); 

global $wp_query,$paged;


$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['krypton-sidebar']) && count($sidebars['krypton-sidebar'])){
	$sidebar='krypton-sidebar';
}
elseif(isset($sidebars['sidebar-1']) && count($sidebars['sidebar-1'])){
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
					<h1><?php _e( 'Category', 'Krypton' ); ?></h1>
					<p><?php print single_cat_title( '', false );?></p>
				</div>
				<div class="col-xs-4 hidden-xs breadcrumb-grid">
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

			<?php if ( have_posts() ) : ?>

			<header class="archive-header">
				<h1 class="archive-title"><?php printf( __( 'Category Archives: %s', 'Krypton' ), single_cat_title( '', false ) ); ?></h1>

				<?php if ( category_description() ) : // Show an optional category description ?>
				<div class="archive-meta"><?php echo category_description(); ?></div>
				<?php endif; ?>
			</header>

			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>



			<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
			<?php endif; ?>	


<!-- Pagination -->
<div class="row">
			<div class="paging-nav col-xs-10 col-xs-offset-2">
							<span class="float-left <?php echo ($wp_query->max_num_pages > 1 && $paged < $wp_query->max_num_pages )?"":"paging-disabled";?>">
								<span class="paging-inline">
									<a <?php print ($wp_query->max_num_pages > 1 && $paged < $wp_query->max_num_pages )?'href="'.next_posts($wp_query->max_num_pages,false).'"':"";?> class="btn-arrow">
										<i class="icon-left-open-big"></i>
									</a> 
								</span>
								<span class="paging-text paging-inline">
									<a <?php print ($wp_query->max_num_pages > 1 && $paged < $wp_query->max_num_pages )?'href="'.next_posts($wp_query->max_num_pages,false).'"':"";?>><?php _e('Older Post','Krypton');?></a>
								</span>
							</span>
							<span class="float-right <?php echo ($paged > 1)?"":"paging-disabled";?>">
			
								<span class="paging-text paging-inline">
									<a <?php print ($paged > 1)?'href="'.previous_posts(false).'"':"";?>><?php _e('Newer Post','Krypton');?></a>
								</span> 
								<span class="btn-arrow paging-inline">
									<a <?php print ($paged > 1)?'href="'.previous_posts(false).'"':"";?>><i class="icon-right-open-big"></i></a>
								</span>
							</span>
		</div>
</div>




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
<?php get_footer(); ?>