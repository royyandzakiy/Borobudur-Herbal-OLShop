<?php
defined('ABSPATH') or die();

/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 * @version 3.0
 */

?>

			<div <?php post_class(); ?>>
				<div class="row post_row"> 

					<div class="col-sm-2">	
						<?php 
							$avatar_url = get_avatar_url(get_the_author_meta( 'ID' ),array('size'=>85 )); 
							if (isset($avatar_url)) {

						?>					
						<img src="<?php echo esc_url($avatar_url); ?>" class="author-avatar img-circle img-responsive" alt="<?php print esc_attr(get_the_author_meta( 'nicename' ));?>">
						<?php 
							} 
						?>											

					</div>

					<div class="col-sm-10 blog-post-teaser">											
						<?php 
							$thumb_id=get_post_thumbnail_id($post->ID);
							$featured_image = wp_get_attachment_image_src($thumb_id,'full',false); 

							if (isset($featured_image[0])) {
								$alt_image = get_post_meta($thumb_id, '_wp_attachment_image_alt', true);
						?>											

						<img src="<?php echo esc_url($featured_image[0]); ?>" alt="<?php print esc_attr($alt_image);?>" class="blog-post-teaser-image img-responsive">

						<?php 
							} 
						?>											

						<h2 class="blog-post-title">

							<a href="<?php the_permalink(); ?>"><?php the_title();?></a>

						</h2>

						<div class="blog-post-teaser-text">
							<?php the_excerpt(); ?> 
							<?php the_tags(); ?>
							<?php wp_link_pages(); ?>

						</div>

						<div class="row meta-info">
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-clock-circled"></i><?php echo get_the_date( 'j F Y', '', '', true); ?></span></div>
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-comment"></i><?php comments_number(__('No Comments','Krypton'),__('1 Comment','Krypton'),__('% Comments','Krypton')); ?></span></div>
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-eye-5"></i><?php echo dt_get_post_views(get_the_ID()); ?></span></div>
							<?php if (has_category()) { ?>
							<div class="col-sm-6 col-md-3 info"><span><i class="icon-tags"></i><?php the_category("<br />"); ?></span></div>
							<?php }  ?>
						</div>

					</div>

				</div>
			</div>