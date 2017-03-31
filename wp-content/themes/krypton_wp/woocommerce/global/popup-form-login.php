<?php
/**
 * Login form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( is_user_logged_in() ) 
	return;
?>
<div id="login-modal" class="popup-gallery md-modal md-effect-1">
<form role="form" id="login-form" method="post" action="">

	<div class="md-content form">
	<?php do_action( 'woocommerce_login_form_start' ); ?>
		<h1><?php _e( 'Login', 'woocommerce' ); ?></h1>
		<div class="row form-body">
		<div class="col-xs-12">
				<div class="form-group">
				    <label><?php _e( 'Username or email', 'woocommerce' ); ?></label>
				    <input type="text" class="form-control" name="username" id="username"  required>
				</div>
				<div class="form-group">
				    <label><?php _e( 'Password', 'woocommerce' ); ?></label>
				    <input type="password" class="form-control" name="password" id="password">
				</div>
				<div class="row">
					<div class="dt-form-info col-xs-12 col-sm-8">
								<label for="rememberme" class="inline">
			<input name="rememberme" type="checkbox" id="rememberme" value="forever" /> <?php _e( 'Remember me', 'woocommerce' ); ?>
		</label>

					    <label>
					      <a href="<?php echo esc_url( wc_lostpassword_url() ); ?>"><?php _e( 'Lost your password?', 'woocommerce' ); ?></a>
					    </label>
					</div>
	<?php do_action( 'woocommerce_login_form' ); ?>

					<div class="form-group col-xs-12 col-sm-4">
						<button type="submit" class="btn-submit"><?php _e( 'Login', 'woocommerce' ); ?></button>	
						<?php wp_nonce_field( 'woocommerce-login' ); ?>
						<input type="hidden" name="redirect" value="<?php echo esc_url( $redirect ) ?>" />
						<input type="hidden" name="login" value="<?php _e( 'Login', 'woocommerce' ); ?>" />

					</div>
				</div>
		</div>
	</div>

		<a href="#" class="md-close right"><i class="icon-cancel"></i></a>
	</div>
	<?php do_action( 'woocommerce_login_form_end' ); ?>

</form>
</div>
