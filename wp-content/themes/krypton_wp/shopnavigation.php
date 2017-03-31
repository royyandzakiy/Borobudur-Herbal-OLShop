<?php 
defined('ABSPATH') or die();

global $krypton_config,$woocommerce,$dt_revealData;

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

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="row">
			<div class="col col-sm-12">
				<div class="navbar-header visible-xs">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#mynavbar">
						<span class="sr-only"><?php _e('Toggle navigation','Krypton');?></span>
						<span class="icon-bars"></span>
						<span class="icon-bars"></span>
						<span class="icon-bars"></span>
					</button>
					<?php if(!empty($krypton_config['dt-mobile-logo-image']['url'])):?>
						<a class="navbar-brand" href="<?php echo home_url();?>"><img class="halfsize navbar-brand-mobile" src="<?php print $krypton_config['dt-mobile-logo-image']['url'];?>" alt=""></a>
					<?php elseif(!empty($krypton_config['dt-logo-image']['url'])):?>
					<a class="navbar-brand" href="<?php echo home_url();?>"><img class="halfsize navbar-brand-mobile" src="<?php print $krypton_config['dt-logo-image']['url'];?>" alt=""></a>
						<?php endif;?>
				</div>
				<div class="collapse navbar-collapse" id="mynavbar">
						<?php 
						if(!empty($krypton_config['dt-logo-image']['url'])):
							print '<a class="hidden-xs navbar-brand-desktop" href="'.home_url().'"><img class="img-responsive halfsize" src="'.$krypton_config['dt-logo-image']['url'].'" alt=""></a>';
						endif;

						print $menu; 
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
								<?php if(!is_user_logged_in()):?>
								<li class="hidden-mobile">
									<a href="#" class="md-trigger" data-modal="login-modal" onClick="return false;"><?php _e( 'Login', 'woocommerce' ); ?></a>
								</li>
							<?php else:?>
								<li class="hidden-mobile">
									<a href="<?php echo wp_logout_url( get_permalink() ); ?>" title="Logout"><?php _e( 'Logout', 'woocommerce' ); ?></a>
								</li>

						<?php endif;?>
<?php 	

if ( function_exists('WC') && sizeof( WC()->cart->get_cart() ) > 0 ) : ?>
								<li class="hidden-mobile">
									<a class="cart-click">Cart / <span class="cart_amounts"><?php echo apply_filters('detheme_woocommerce_cart_subtotal',WC()->cart); ?></span></a>
								</li>
								<li class="hidden-mobile bag">
									<a href="#" class="cart-click">
										<i class="icon-shop">
											<span><?php echo WC()->cart->get_cart_contents_count(); ?></span>
										</i>
									</a>
								</li>
<?php else:?>
								<li class="hidden-mobile">
									<a class="cart-click">Cart / <span class="cart_amounts">0</span></a>
								</li>
								<li class="hidden-mobile bag">
									<a href="#" class="cart-click">
										<i class="icon-shop">
											<span>0</span>
										</i>
									</a>
								</li>

<?php endif;?>							
</ul>
						</form>
					</div>
					<!-- popup -->
				<div class="cart-popup hide-me-first">	
					<div class="widget_shopping_cart_content"></div>
				</div>	

					<!-- end popup -->

				</div>
			</div>
		</div>
	</div>
</nav>

<?php 



if(!is_user_logged_in()):
$dt_revealData[]=krypton_woocommerce_login_form(
		array(
			'message'  => "",
			'redirect' => get_permalink()
		),
		true
	);

endif;?>
