<?php
defined('ABSPATH') or die();

/**
 * The default template for displaying content
 *
 * Used for single page.
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 */

global $krypton_config,$post;


$woocommerce="";

$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['krypton-sidebar']) && count($sidebars['krypton-sidebar'])){
	$sidebar='krypton-sidebar';
}
elseif(isset($sidebars['sidebar-1']) && !isset($sidebars['krypton-sidebar']) && count($sidebars['sidebar-1'])){
	$sidebar='sidebar-1';
}


if (is_plugin_active('woocommerce/woocommerce.php') && (is_woocommerce()  || is_checkout() || is_cart() || is_account_page() || is_store_notice_showing())):
	$woocommerce="shop";
	if(isset($sidebars['shop-sidebar']) && count($sidebars['shop-sidebar'])){
		$sidebar='shop-sidebar';
	}
endif;

get_header($woocommerce);?>
<?php 

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

$commentopen=(isset($krypton_config))?$krypton_config['dt-comment-open']:true;



?>
<div <?php post_class(); ?>>
<div class="blog-single-post <?php echo $class_sidebar;?>">
	<section class="subpage-banner"></section>
	<div class="container">
		<div class="row">
<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
<?php	} else { ?>
			<div class="col-sm-8<?php print ($sidebar_position=='sidebar-left')?" col-sm-push-4":"";?>">
<?php	} ?>
<?php 
while ( have_posts() ) : 


the_post();

$hideSocial = get_post_meta( get_the_ID(), 'show_social', true );
$hideComment = get_post_meta( get_the_ID(), 'show_comment', true );

?>				<div class="row">
					<div class="col-sm-12">
						<h2 class="post-title"><?php the_title();?></h2>
						<div class="post-article">
						<?php 
						the_content();
						 ?></div><!-- post article -->
						<?php if('yes'!==$hideSocial && 'shop'!==$woocommerce):?>
						<hr>
						<div class="social-share">
							<div class="row">
								<div class="col-xs-6 share-text"><?php _e('Share','Krypton');?></div>
								<div class="col-xs-6 share-button">
									<div class="btn-group">
										<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="btn btn-default" target="_blank"><i class="icon-facebook"></i></a>
										<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="btn btn-default" target="_blank"><i class="icon-gplus"></i></a>
										<a href="https://twitter.com/intent/tweet?text=<?php print get_the_title();?>&amp;url=<?php the_permalink(); ?>" class="btn btn-default" target="_blank"><i class="icon-twitter"></i></a>
										<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php print get_the_title();?>&amp;=<?php print strip_tags(get_the_excerpt()); ?>&amp;source=<?php the_permalink(); ?>" class="btn btn-default" target="_blank"><i class="icon-linkedin"></i></a>
										<a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;description=<?php print strip_tags(get_the_excerpt()); ?>&amp;media=" class="btn btn-default" target="_blank"><i class="icon-pinterest"></i></a>
									</div>									
								</div>
							</div>
						</div>	
						<?php endif;?>
				<?php 

			if('yes'!==$hideComment && $commentopen  && 'shop'!==$woocommerce):?>
						<hr>
						<div class="comment-count">
							<?php comments_number(__('No Comments','Krypton'),__('1 Comment','Krypton'),__('% Comments','Krypton')); ?>
						</div>						
				<?php endif;?>	
					</div>
				</div>
				<?php if($commentopen && comments_open()  && 'shop'!==$woocommerce):?>

				<div class="row section-comment">
				<?php comments_template('/comments.php', true); ?>
				</div><!-- Section Comment -->
				<?php endif;?>	
			</div><!-- Article Post -->
<?php endwhile; ?>

<?php if ('sidebar-right'==$sidebar_position) { ?>
			<div class="col-sm-4 sidebar">
				<?php get_sidebar($woocommerce); ?>
			</div>
<?php }
	elseif ($sidebar_position=='sidebar-left') { ?>
			<div class="col-sm-4 sidebar col-sm-pull-8">
				<?php get_sidebar($woocommerce); ?>
			</div>
<?php }?>
		</div><!-- .row -->
	</div><!-- .container -->
</div><!-- .blog-single-post -->
</div>
<?php
get_footer();
?>