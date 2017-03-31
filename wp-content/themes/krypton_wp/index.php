<?php
defined('ABSPATH') or die();

/**
 * The main template file
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
 * @version 3.0
 */

global $krypton_config,$wp_query,$paged,$posts_per_page;

get_header();?>
<?php 

$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['krypton-sidebar']) && count($sidebars['krypton-sidebar'])){
	$sidebar='krypton-sidebar';
}
elseif(isset($sidebars['sidebar-1']) &&  !isset($sidebars['krypton-sidebar']) && count($sidebars['sidebar-1'])){
	$sidebar='sidebar-1';
}

$blog_page_id = get_option( 'page_for_posts' );
$queried_object_id = get_queried_object_id();
$is_blog_page = false;

if ($blog_page_id==$queried_object_id) { // kalo di page yg di set sbg posts page
	$title = get_the_title($blog_page_id);
	$subtitle = get_post_meta($blog_page_id, 'subtitle', true );
	$is_blog_page = true;
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
<?php if ($is_blog_page) : ?>
					<h1><?php echo $title;?></h1>
					<?php if(!empty($subtitle)):?>
					<p><?php echo esc_html($subtitle);?></p>
					<?php endif;?>				
<?php else : ?>
					<h1><?php echo get_bloginfo('name');?></h1>
					<p><?php echo get_bloginfo('description');?></p>
<?php endif; ?>
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
<?php
				if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();

						get_template_part( 'content', get_post_format() );

					endwhile;?>
<!-- Pagination -->

<div class="row">
			<div class="paging-nav col-xs-12">
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
<?php
				else :
						get_template_part( 'content', 'none' );

				endif;

?>
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