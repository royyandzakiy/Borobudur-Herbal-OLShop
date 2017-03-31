<?php
defined('ABSPATH') or die();

/**
 *
 * this part from portfolio layout
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 * @version 3.0
 */

$featured_image = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()),'full',false); 

$column=get_query_var('column');

switch ($column) {
		case '5':
		case '4':
		case '3':
			$image=aq_resize($featured_image[0], 1080/(int)$column, 816/(int)$column, true, true, true);
			break;
		default:
			$image=aq_resize($featured_image[0], 1080/(int)$column, 816/(int)$column, true, true, true);
			break;
	}
$avatar_url = get_avatar_url(get_the_author_meta( 'ID' ), array('size'=>100 ));
?>
<div id="blog_<?php the_ID();?>" <?php post_class('masonry-item',get_the_ID()); ?>>
	<figure>
		<?php if($featured_image):
		$alt_image = get_post_meta(get_post_thumbnail_id(get_the_ID()), '_wp_attachment_image_alt', true);
		?>
		<div class="top-image">
			<img src="<?php echo esc_url($image); ?>" alt="<?php print esc_attr($alt_image);?>"/>
		</div>
	<?php endif;?>
		<div class="thumb-image">
			<img src="<?php print esc_url($avatar_url);?>" alt="<?php print esc_attr(get_the_author_meta( 'nickname' ));?>"/>
		</div>
		<figcaption>
			<div class="description">
				<a href="<?php the_permalink();?>" class="post-title"><h4><?php the_title();?></h4></a>
				<?php the_excerpt();?>
			</div>
		</figcaption>
	</figure>
	<div class="mini-panel">
		<div class="col-sm-4 col-md-4 col-xs-4"><i class="icon-clock-8"></i><?php print get_the_date( 'j M', '', '', true); ?></div>
		<div class="col-sm-4 col-md-4 col-xs-4"><i class="icon-chat-inv"></i><?php echo(get_comments_number())?get_comments_number():'0'; ?></div>
		<div class="col-sm-4 col-md-4 col-xs-4"><i class="icon-eye-5"></i><?php echo dt_get_post_view_number(get_the_ID()); ?></div>
	</div>
</div>