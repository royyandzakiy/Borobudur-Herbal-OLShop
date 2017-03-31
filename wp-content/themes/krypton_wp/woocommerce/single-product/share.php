<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<div class="btn-group">
	<a class="btn btn-default" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" target="_blank"><i class="icon-facebook"></i></a>
	<a class="btn btn-default" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" target="_blank"><i class="icon-gplus"></i></a>
	<a class="btn btn-default" href="https://twitter.com/intent/tweet?text=<?php the_title();?>&amp;url=<?php the_permalink(); ?>" target="_blank"><i class="icon-twitter"></i></a>
	<a class="btn btn-default" href="mailto:enteryour@addresshere.com?subject=<?php the_title(); ?>&amp;body=Check%20this%20out:%20<?php the_permalink(); ?>" target="_blank"><i class="icon-email"></i></a>


	<a data-tip="Email to a Friend" class="icon icon_email tip-top" href="mailto:enteryour@addresshere.com?subject=Wicked%20SS%20O-Neck%20Selected%20Homme&amp;body=Check%20this%20out:%20http://flatsome.uxthemes.com/shop/wicked-ss-o-neck-selected-homme/"><span class="icon-envelop"></span></a>
</div>
<?php do_action( 'woocommerce_share' ); // Sharing plugins can hook into here ?>