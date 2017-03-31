<?php
defined('ABSPATH') or die();

/**
 * Template Name: Woocommerce Page Fullwidth
 *
 * Used for single page.
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 */

global $krypton_config;

$shop="";
if(function_exists('is_shop'))
	$shop='shop';
get_header($shop);

?>
<?php
				if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();

						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						the_content();

					endwhile;

				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
?>
<?php
get_footer($shop);
?>