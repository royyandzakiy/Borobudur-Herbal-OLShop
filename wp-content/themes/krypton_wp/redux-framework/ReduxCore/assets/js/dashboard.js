jQuery(document).ready(function($){
	'use strict';
  var 
  $showfooterpage=$('#krypton_config-showfooterpage .cb-enable,#krypton_config-showfooterpage .cb-disable'),
  $footertext=$('#krypton_config-footer-text').closest('.form-table tr'),
  $showfooteimage=$('#krypton_config-dt-background-footer').closest('.form-table tr'),
  $showfooterarea=$('#krypton_config-showfooterarea .cb-enable,#krypton_config-showfooterarea .cb-disable'),
  $postfooterpage=$('#krypton_config-postfooterpage').closest('.form-table tr');

  $showfooterpage.live('click',function(e){

    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $postfooterpage.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){

          $postfooterpage.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
          $postfooterpage.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){

          $postfooterpage.fadeOut('fast');
      }
    }

  });

 $showfooterarea.live('click',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $footertext.fadeIn('fast');
        $showfooteimage.fadeIn('fast');
      }

    }else{
      if($(this).hasClass('selected')){
        $footertext.fadeOut('fast');
        $showfooteimage.fadeOut('fast');
      }
    }

  }).live('change',function(e){
    e.preventDefault();
    if($(this).hasClass('cb-enable')){
      if($(this).hasClass('selected')){
        $footertext.fadeIn('fast');
        $showfooteimage.fadeIn('fast');
      }
    }else{
      if($(this).hasClass('selected')){
        $footertext.fadeOut('fast');
        $showfooteimage.fadeOut('fast');
      }
    }

  });

   $showfooterpage.trigger('change');
   $showfooterarea.trigger('change');
 });
