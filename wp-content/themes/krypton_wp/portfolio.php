<?php
defined('ABSPATH') or die();

/**
 * Template Name: Portfolio Template (Deprecated)
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

global $krypton_config;

get_header();


$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['krypton-sidebar']) && count($sidebars['krypton-sidebar'])){
	$sidebar='krypton-sidebar';
}
elseif(isset($sidebars['sidebar-1']) && !isset($sidebars['krypton-sidebar']) && count($sidebars['sidebar-1'])){
	$sidebar='sidebar-1';
}


$sidebar_position = get_post_meta( get_the_ID(), 'sidebar_position', true );
$portfolioCol = get_post_meta( get_the_ID(), 'portfoliocolumn', true );
$portfoliotype = get_post_meta( get_the_ID(), 'portfoliotype', true );
$subtitle = get_post_meta( get_the_ID(), 'subtitle', true );

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
set_query_var('column',$portfolioCol);
?>


<div class="blog_classic <?php echo $class_sidebar;?>">
	<section class="subpage-banner blog-classic-banner">
		<div class="container">
			<div class="row header-group">
				<div class="col-sm-8 col-sm-12">
					<h1><?php echo get_the_title();?></h1>
<?php if(!empty($subtitle)):?>
					<p><?php echo esc_html($subtitle);?></p>
<?php endif;?>				</div>
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

					switch($portfoliotype){
						case "2":
									switch($portfolioCol){
										case '3':
										case '5':
											locate_template( 'pagetemplates/portfolio-'.$portfolioCol.'column-desc.php',true);
										break;
										case '4':
										default:
											locate_template(  'pagetemplates/portfolio-4column-desc.php',true);
										break;
									}
							break;
						default:
								switch($portfolioCol){
									case '3':
									case '5':
										locate_template( 'pagetemplates/portfolio-'.$portfolioCol.'column.php',true);
									break;
									case '4':
									default:
										locate_template(  'pagetemplates/portfolio-4column.php',true);
									break;
								}
							break;
					}

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