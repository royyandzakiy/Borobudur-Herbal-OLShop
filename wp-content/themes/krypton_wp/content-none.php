<?php
/**
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 3.0
 * @version 3.0
 */
?>
<div class="row">
	<div class="col-xs-12">
		<h1 class="page-title"><?php _e( 'Nothing Found', 'Krypton' ); ?></h1>
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'Krypton' ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'Krypton' ); ?></p>
			<?php get_search_form(); ?>

		<?php else : ?>

			<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'Krypton' ); ?></p>
			<?php get_search_form(); ?>

		<?php endif; ?>
	</div>
</div>