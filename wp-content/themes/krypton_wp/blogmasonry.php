<?php
defined('ABSPATH') or die();

/**
 * Template Name: Blog Masonry
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

$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['krypton-sidebar']) && count($sidebars['krypton-sidebar'])){
	$sidebar='krypton-sidebar';
}
elseif(isset($sidebars['sidebar-1']) && !isset($sidebars['krypton-sidebar']) && count($sidebars['sidebar-1'])){
	$sidebar='sidebar-1';
}


$sidebar_position = get_post_meta( get_the_ID(), 'sidebar_position', true );
$coloumn = get_post_meta( get_the_ID(), 'masonrycolumn', true );
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

if($sidebar_position!=='nosidebar'){
	$coloumn=2;
}

set_query_var('sidebar',$sidebar);
set_query_var('column',$coloumn);
$class_sidebar = $sidebar_position;
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
<?php
global $query,$posts_per_page,$paged;


$paged =is_front_page()?((get_query_var('page')) ? get_query_var('page') : 1):$paged;

if ( have_posts() ) :

			the_content();



            $query = new WP_Query();

            $args = array(
                'post_type' => 'post',
                'order' => 'DESC',
                'paged' => $paged,
                'meta_key'=>'_thumbnail_id',
                'posts_per_page' => $posts_per_page,
            );

            $query->query($args);
?>
<section class="recent_blog_post col-md-12">
	<div class="row" >
		<div class="container">
			<div id="blog-masonry" class="blog-masonry col-<?php print (int)$coloumn;?>">
			<?php while ($query->have_posts()) : 
				$query->the_post();


				get_template_part( 'content', 'blog');

				endwhile;

				wp_reset_query();?>
			</div>
		<hr />
		<div class="row">
			<div class="paging-nav col-xs-12">
							<span class="float-left <?php echo ($query->max_num_pages > 1 && $paged < $query->max_num_pages )?"":"paging-disabled";?>">
								<span class="paging-inline">
									<a <?php print ($query->max_num_pages > 1 && $paged < $query->max_num_pages )?'href="'.next_posts($query->max_num_pages,false).'"':"";?> class="btn-arrow">
										<i class="icon-left-open-big"></i>
									</a> 
								</span>
								<span class="paging-text paging-inline">
									<a <?php print ($query->max_num_pages > 1 && $paged < $query->max_num_pages )?'href="'.next_posts($query->max_num_pages,false).'"':"";?>><?php _e('Older Post','Krypton');?></a>
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
	</div>
</section>


<?php
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
	
		</div>			
	</div>
</div>
<?php
get_footer();
?>