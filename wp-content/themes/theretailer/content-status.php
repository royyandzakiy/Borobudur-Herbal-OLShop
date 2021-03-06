<?php
/**
 * @package theretailer
 * @since theretailer 1.0
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	
    <div class="entry-content">
		<?php global $more; $more = 0; the_content(__( 'Continue reading &raquo;', 'theretailer' )); ?>
        <div class="clr"></div>
		<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'theretailer' ), 'after' => '</div>' ) ); ?>
	</div><!-- .entry-content -->
    
    <footer class="entry-meta">
		
		<?php //if (  is_single() && (isset($theretailer_theme_options['sharing_options_blog'])) && ($theretailer_theme_options['sharing_options_blog'] == "1" ) ) : ?>
			<div class="box-share-container post-share-container">
				<a class="trigger-share-list" href="#"><i class="fa fa-share-alt"></i><?php _e( 'Share this post', 'theretailer' )?></a>
				<div class="box-share-list">
				
					<?php
						//Get the Thumbnail URL
						$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), false, '' );
					?>
					
					<div class="box-share-list-inner">
						<a href="//www.facebook.com/sharer.php?u=<?php the_permalink(); ?>" class="box-share-link" target="_blank"><i class="fa fa-facebook"></i><span>Facebook</span></a>
						<a href="//twitter.com/share?url=<?php the_permalink(); ?>" class="box-share-link" target="_blank"><i class="fa fa-twitter"></i><span>Twitter</span></a>
						<a href="//plus.google.com/share?url=<?php the_permalink(); ?>" class="box-share-link" target="_blank"><i class="fa fa-google-plus"></i><span>Google</span></a>
						<a href="//pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url($src[0]) ?>&amp;description=<?php echo urlencode(get_the_title()); ?>" class="box-share-link" target="_blank"><i class="fa fa-pinterest"></i><span>Pinterest</span></a>
					</div><!--.box-share-list-inner-->
					
				</div><!--.box-share-list-->
			</div>
		<?php //endif; ?>
		
		<span class="date-meta"><i class="fa fa-calendar-o"></i>&nbsp;&nbsp;<?php _e( 'Status on', 'theretailer' )?> <a href="<?php echo esc_url( get_permalink() ); ?>" title="<?php echo esc_attr( get_the_time() ); ?>" rel="bookmark" class="entry-date"><time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time></a></span>

		<?php //edit_post_link( __( 'Edit', 'theretailer' ), '<span class="edit-link">', '</span>' ); ?>
	</footer><!-- .entry-meta -->    
    
</article><!-- #post-<?php the_ID(); ?> -->
