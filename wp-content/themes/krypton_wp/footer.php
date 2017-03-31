<?php
defined('ABSPATH') or die();

/**
 * footer area
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 * @version 3.0
 */


global $krypton_config;

do_action('before_footer_section');

if(isset($krypton_config['showfooterarea']) && $krypton_config['showfooterarea'] || !isset($krypton_config['showfooterarea'])){
	get_footer('footerarea');
}
do_action('after_footer_section');
?>
<?php wp_footer(); ?>
</body>
</html>