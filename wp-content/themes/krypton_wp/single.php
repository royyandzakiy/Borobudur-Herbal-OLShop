<?php
defined('ABSPATH') or die();

/**
 * The default template for displaying content
 *
 * Used for single post.
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

	<section class="subpage-banner"></section>

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

?>
				<div class="row">
					<div class="col-sm-2">
						<?php 
							$avatar_url = get_avatar_url(get_the_author_meta( 'ID' ),array('size'=>85 )); 
							if (isset($avatar_url)) {
						?>					
						<img src="<?php echo $avatar_url; ?>" class="author-avatar img-circle img-responsive" alt="Avatar">						
						<?php 
							} //if (isset($avatar_url))
						?>											

					</div>					

					<div class="col-sm-10">

						<h2 class="post-title"><?php the_title();?></h2>
						<div class="row meta-info">
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-clock-circled"></i><?php the_date( 'j F Y', '', '', true); ?></span></div>
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-comment"></i><?php comments_number(__('No Comments','Krypton'),__('1 Comment','Krypton'),__('% Comments','Krypton')); ?></span></div>
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-eye-5"></i><?php echo dt_get_post_views(get_the_ID()); ?></span></div>
							<?php if (has_category()) { ?>
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-tags"></i><?php the_category("<br />"); ?></span></div>
							<?php } //if (has_category()) ?>
						</div>

						<div class="post-article"><?php the_content(); ?></div><!-- post article -->

						<hr>
						<?php if('yes'!==$hideSocial):?>

						<div class="social-share">
							<div class="row">
								<div class="col-xs-6 share-text"><?php _e('Share','Krypton');?></div>
								<div class="col-xs-6 share-button">
									<div class="btn-group">
										<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="btn btn-default" target="_blank"><i class="icon-facebook"></i></a>
										<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="btn btn-default" target="_blank"><i class="icon-gplus"></i></a>
										<a href="https://twitter.com/intent/tweet?text=<?php print get_the_title();?>&amp;url=<?php the_permalink(); ?>" class="btn btn-default" target="_blank"><i class="icon-twitter"></i></a>
										<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php print get_the_title();?>&amp;summary=<?php print strip_tags(get_the_excerpt()); ?>&amp;source=<?php the_permalink(); ?>" class="btn btn-default" target="_blank"><i class="icon-linkedin"></i></a>
										<a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;description=<?php print strip_tags(get_the_excerpt()); ?>&amp;media=" class="btn btn-default" target="_blank"><i class="icon-pinterest"></i></a>
									</div>									
								</div>
							</div>
						</div>	
						<hr>
						<?php 
						endif;

						if('yes'!==$hideComment && $commentopen):
							?>
						<div class="comment-count">
							<?php comments_number(__('No Comments','Krypton'),__('1 Comment','Krypton'),__('% Comments','Krypton')); ?>
						</div>
						<hr>
						<?php endif;?>						
					</div>
				
				</div>
				<?php if($commentopen && comments_open()):?>

				<div class="row section-comment">

				<?php comments_template('/comments.php', true); ?>

				</div>
			<?php endif;?><!-- Section Comment -->
			<?php endwhile;?>

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