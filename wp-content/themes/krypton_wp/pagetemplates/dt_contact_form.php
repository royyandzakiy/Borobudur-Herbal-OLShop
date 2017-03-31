<?php
/**
 * @package WordPress
 * @subpackage Krypton
 * @since Krypton 3.0.0
 * @version 3.0.0
 */
defined('ABSPATH') or die();
?>
<div class="row">
	<div class="col-xs-12">
		<form class="form-inline dt-contact-form" role="form" id="dt-contact-form" action="">

			<div class="row">
				<div class="form-group col-xs-12 col-sm-4">
					<input type="text" class="form-control" name="inputFullname" id="inputFullname" placeholder="<?php _e('full name','Krypton');?>" required>
				</div>
				<div class="form-group col-xs-12 col-sm-4">
					<input type="email" class="form-control"  name="inputEmail" id="inputEmail" placeholder="<?php _e('email address','Krypton');?>" required>
				</div>
				<div class="form-group col-xs-12 col-sm-4">
					<input type="text" class="form-control" name="inputPhone" id="inputPhone" placeholder="<?php _e('phone number','Krypton');?>">
				</div>
			</div>
			
			<div class="row">
				<div class="form-group col-xs-12">
					<textarea class="form-control" rows="3" name="inputMessage" id="inputMessage" placeholder="<?php _e('your message','Krypton');?>" required></textarea>
				</div>
			</div>

			<div class="row">
				<div class="form-group col-xs-12">
					<input id="num1" class="sum form-control" type="text" name="num1" value="<?php print rand(1,4);?>" readonly="readonly" />
					+
					<input id="num2" class="sum form-control" type="text" name="num2" value="<?php print rand(5,9);?>" readonly="readonly" />
					=
					<input id="captcha" class="captcha form-control" type="text" name="captcha" maxlength="2" />
					<span><?php _e('(Are you human, or spambot?)','Krypton');?></span>

					<div class="captchaerror fail"><div class="icon-attention"><?php _e('Captcha Value is not correct','Krypton');?>'</div></div>
				</div>
			</div>

			<div class="row">
				<div class="dt-form-info col-sm-6">
					<p><?php _e('we will respond your message in 24 hours of working day','Krypton');?></p>
				</div>
				<div class="form-group col-xs-12 col-sm-6">
					<button type="submit" class="btn-send"><?php _e('Send Message','Krypton');?></button>	
					<div class="sendemail success"><div class="icon-ok-5"><?php _e('Email sent !','Krypton');?></div></div>
					<div class="sendemail fail"><div class="icon-attention"><?php _e('Failed to send Email !','Krypton');?></div></div>
				</div>
			</div>
			<input type="hidden" name="hiddenURL" id="ajaxURL" value="<?php echo admin_url( 'admin-ajax.php' );?>">
		</form>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
'use strict';
   $("#dt-contact-form").validate({
        rules: {
            inputFullname: "required",
            inputEmail: {
                required: true,
                email: true
            },
            inputMessage: "required",
            captcha: {
                required: true,
                captcha: true
            }
        },
        messages: {
            inputFullname: "<?php _e('Please enter your full name','Krypton');?>",
            inputMessage: "<?php _e('Please enter a message','Krypton');?>",
            inputEmail: "<?php _e('Please enter a valid email address','Krypton');?>",
            captcha: "<?php _e('Please enter correct answer','Krypton');?>"
        }
    });
});
</script>