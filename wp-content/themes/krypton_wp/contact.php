<?php
defined('ABSPATH') or die();

/**
 * Template Name: Contact
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

global $krypton_config;

get_header();

global $wp_query,$paged;

$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['krypton-contact-sidebar']) && count($sidebars['krypton-contact-sidebar'])){
	$sidebar='krypton-contact-sidebar';
}
elseif(isset($sidebars['sidebar-3']) && !isset($sidebars['krypton-contact-sidebar']) && count($sidebars['sidebar-3'])){
	$sidebar='sidebar-3';
}

$sidebar_position = get_post_meta( get_the_ID(), 'sidebar_position', true );
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

?>

<div <?php post_class(); ?>>
<div class="blog-single-post contact <?php echo $class_sidebar;?>">
	<section class="subpage-banner contact-banner">
		<div class="container">
			<div class="row header-group">
				<div class="col-sm-8 col-sm-12">
					<h1><?php echo get_the_title();?></h1>
<?php if(!empty($subtitle)):?>
					<p><?php echo esc_html($subtitle);?></p>
<?php endif;?>
				</div>
				<div class="col-xs-4 hidden-xs breadcrumb-grid<?php print (empty($subtitle))?" nosubtitle":"";?>">
					<?php if (function_exists('dimox_breadcrumbs')) dimox_breadcrumbs(); ?>
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
				if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();

						the_content();

					endwhile;

				else :
					// If no content, include the "No posts found" template.
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
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .blog-single-post -->
</div>
<?php
get_footer();
?>