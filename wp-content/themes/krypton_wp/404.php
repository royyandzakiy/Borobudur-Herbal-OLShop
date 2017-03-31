<?php
defined('ABSPATH') or die();

/**
 * 404 Error template file
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 * @version 3.0
 */

global $krypton_config;

get_header();?>

 	<div class="centered">
 		<p class="biggest"><?php _e('Oops!','Krypton');?></p>
 		<p class="big"><?php _e('Error 404','Krypton');?></p>
 		<p class="message"><?php echo $krypton_config['dt-404-text']; ?></p>
 		<div class="button">
 			<a href="<?php echo home_url(); ?>" class="btn-back"><?php _e('Back to Homepage','Krypton');?></a>
 		</div>
 	</div>
<?php wp_footer(); ?>
</body>
</html>