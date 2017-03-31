<?php 
defined('ABSPATH') or die();
/**
 *
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 1.0
 * @version 3.0.0
 */

global $krypton_config;

	$menuParams=array(
            	'theme_location' => 'primary',
            	'menu'=>'',
            	'echo' => false,
            	'container_class'=>'left-cell',
            	'menu_class'=>'nav navbar-nav',
            	'container'=>'div',
				'before' => '',
            	'after' => '',
            	'fallback_cb'=>false,
            	'walker' => new dtmenu_walker()
				);

	$menu=wp_nav_menu($menuParams);

	if(!$menu){

		$menuParams['theme_location']='';
		$menuParams['walker']='';
		$menuParams['fallback_cb']='wp_page_menu';

		$menu=dt_page_menu($menuParams);
	}

?>

<nav class="navbar navbar-default navbar-main navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="row">
			<div class="col col-sm-12">
				<div class="navbar-header visible-xs visible-sm">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mynavbar">
						<span class="sr-only"><?php _e('Toggle navigation','Krypton');?></span>
						<span class="icon-bars"></span>
						<span class="icon-bars"></span>
						<span class="icon-bars"></span>
					</button>
					<?php 

					$logo_alt_image="";

					if(!empty($krypton_config['dt-mobile-logo-image']['url'])):

					$logo_alt_image =isset($krypton_config['dt-mobile-logo-image']['id'])?get_post_meta($krypton_config['dt-mobile-logo-image']['id'], '_wp_attachment_image_alt', true):"";

					?>
						<a class="navbar-brand" href="<?php echo home_url();?>"><img class="halfsize navbar-brand-mobile" src="<?php print esc_url($krypton_config['dt-mobile-logo-image']['url']);?>" alt="<?php print esc_attr($logo_alt_image);?>"></a>
					<?php elseif(!empty($krypton_config['dt-logo-image']['url'])):
					$logo_alt_image =isset($krypton_config['dt-logo-image']['id']) ? get_post_meta($krypton_config['dt-logo-image']['id'], '_wp_attachment_image_alt', true):"";
					?>
					<a class="navbar-brand" href="<?php echo home_url();?>"><img class="halfsize navbar-brand-mobile" src="<?php print esc_url($krypton_config['dt-logo-image']['url']);?>" alt="<?php print esc_attr($logo_alt_image);?>"></a>
						<?php endif;?>
				</div>


				<div class="collapse navbar-collapse" id="mynavbar">

						<?php 
						if(!empty($krypton_config['dt-logo-image']['url'])):
							print '<a class="hidden-xs hidden-sm navbar-brand-desktop" href="'.home_url().'"><img class="img-responsive halfsize" src="'.esc_url($krypton_config['dt-logo-image']['url']).'" alt="'.esc_attr($logo_alt_image).'"></a>';
						endif;


						print $menu; 
						if((isset($krypton_config['showsearchmenu']) && $krypton_config['showsearchmenu']) || !isset($krypton_config['showsearchmenu'])):

						?>
					<div class="right-cell">
						<form class="navbar-form navbar-right searchform" id="menusearchform" method="get" action="<?php echo home_url( '/' ); ?>" role="search">
							<ul>
								<li>
									<div class="popup_form hide-me-first">
											<input type="text" class="form-control" id="sm" name="s" placeholder="<?php _e('Search','Krypton');?>">
									</div>
									<a class="search_btn"><i class="icon-search"></i></a>								
								</li>
							</ul>
						</form>
					</div>
<?php endif;?>
				</div>
			</div>
		</div>
	</div>
</nav>