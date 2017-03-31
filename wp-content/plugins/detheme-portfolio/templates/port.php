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
 * @subpackage detheme
 * @since detheme 1.0
 */

get_header(); 
$sidebars=wp_get_sidebars_widgets();
$sidebar=false;

if(isset($sidebars['mnemonic-sidebar']) && count($sidebars['mnemonic-sidebar'])){
	$sidebar='mnemonic-sidebar';
}

$sidebar_position = get_post_meta( get_the_ID(), '_sidebar_position', true );

if(!isset($sidebar_position) || empty($sidebar_position) || $sidebar_position=='default'){

	switch ($mnemonic_config['layout']) {
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


<div  <?php post_class('blog single-post'.$class_sidebar); ?>>
<div class="container">
		<div class="row">
	<?php if ($sidebar_position=='nosidebar') { ?>
			<div class="col-sm-12">
<?php	} else { ?>
			<div class="col-sm-9<?php print ($sidebar_position=='sidebar-left')?" col-sm-push-3":"";?>">
<?php	} ?>
<?php

$commentopen=(isset($mnemonic_config))?$mnemonic_config['dt-comment-open']:true;

while ( have_posts() ) : 
the_post();

$hideSocial = get_post_meta( $post->ID, 'show_social', true );
$hideComment = get_post_meta( $post->ID, 'show_comment', true );
dt_set_post_views(get_the_ID()); 

?>
				<div class="row">
					<div class="col-sm-2">
						<?php 
							$avatar_url = get_avatar_url(get_avatar( get_the_author_meta( 'ID' ), 85 )); 
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
										<a href="https://twitter.com/intent/tweet?text=<?php the_title();?>&amp;url=<?php the_permalink(); ?>" class="btn btn-default" target="_blank"><i class="icon-twitter"></i></a>
										<a href="https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php the_permalink(); ?>&amp;title=<?php the_title();?>&amp;summary=<?php the_excerpt(); ?>&amp;source=<?php the_permalink(); ?>" class="btn btn-default" target="_blank"><i class="icon-linkedin"></i></a>
										<a href="https://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;description=<?php the_excerpt(); ?>&amp;media=" class="btn btn-default" target="_blank"><i class="icon-pinterest"></i></a>
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
				<?php if(comments_open()):?>

				<div class="row section-comment">

				<?php comments_template('/comments.php', true); ?>

				</div>
			<?php endif;?><!-- Section Comment -->
			<?php endwhile;?>

			</div><!-- Article Post -->

<?php if ('sidebar-right'==$sidebar_position) { ?>
			<div class="col-sm-3 sidebar">
				<?php get_sidebar(); ?>
			</div>
<?php }
	elseif ($sidebar_position=='sidebar-left') { ?>
			<div class="col-sm-3 sidebar col-sm-pull-9">
				<?php get_sidebar(); ?>
			</div>
<?php }?>
	

		</div><!-- .row -->

	</div><!-- .container -->

</div>
<?php
get_footer();
?>