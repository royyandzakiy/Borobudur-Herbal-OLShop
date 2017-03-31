jQuery(document).ready(function ($) {

	$(document).on('loaded',function(e){

		if($('.carousel-preview').length){

	    	var carouselPreview=$('.carousel-preview');

	   		$('input[name=pagination_size]').on('change',function(){
	   			$('.owl-page span',carouselPreview).css({'width':$(this).val()+'px','height':$(this).val()+'px'});
	   		}).trigger('change');

	   		$('[name=pagination_color]').wpColorPicker({
		        change:function(event,ui){
					$('.owl-page span',carouselPreview).css({'background-color':ui.color.toString()});
		        }
	    	}).on('change',function(){
	    		$('.owl-page span',carouselPreview).css({'background-color':$(this).val()});
	    	}).trigger('change');

	    	$('select[name=pagination_type]').live('change',function(){
	    		if($(this).val()=='bullet'){
	    			carouselPreview.closest('.field-wrap').show();
	    		}
	    		else{
	    			carouselPreview.closest('.field-wrap').hide();
	    		}
	    	}).trigger('change');

		 }

		if($('.optin-form').length){
	    	$('.optin-form').each(function(){

	    		var $form_preview=$(this),$button_preview=$('.optin_button_preview',$form_preview);

	    		$('[name="button_text"]').change(function(){
	    			$button_preview.text($(this).val());
	    		}).keyup(function(){
	    			$button_preview.text($(this).val());
	    		}).trigger('change');


	    		$('[name="name_label"]').change(function(){
	    			$('.dt_name',$form_preview).attr('placeholder',$(this).val());
	    		}).keyup(function(){
	    			$('.dt_name',$form_preview).attr('placeholder',$(this).val());
	    		}).trigger('change');

	    		$('[name="email_label"]').change(function(){
	    			$('.dt_email',$form_preview).attr('placeholder',$(this).val());
	    		}).keyup(function(){
	    			$('.dt_email',$form_preview).attr('placeholder',$(this).val());
	    		}).trigger('change');


	    		$('input[name="layout"]').on('change',function(){

					var formtype=$(this).val(),
					fieldname=$('input[name="dt_name"]').closest('.form-group'),
					container=$('[role=form]',$form_preview),
					element_margin=$('input[name=element_margin]').val();

					switch(formtype) {
					    case 'vertical_email':
						   		 $('input',$form_preview).css({'margin-bottom':element_margin+'px','margin-right':'0px'});
					    		container.removeClass('form-inline');
					    		fieldname.hide();
					        break;
					    case 'horizontal':
					    		container.addClass('form-inline');
					    		fieldname.show();
						   		 $('input',$form_preview).css({'margin-right':element_margin+'px','margin-bottom':'0px','width':'auto'});
					        break;
					    case 'horizontal_email':
					    		container.addClass('form-inline');
					    		fieldname.hide();
						   		 $('input',$form_preview).css({'margin-right':element_margin+'px','margin-bottom':'0px','width':'auto'});
					        break;
					    case 'vertical':
					    default:
						   		 $('input',$form_preview).css({'margin-bottom':element_margin+'px','margin-right':'0px'});
					    		container.removeClass('form-inline');
					    		fieldname.show();

					} 

				}).trigger('change');


	    		$('input[name=vertical_padding]').on('change',function(){

	    			$('input,button',$form_preview).css({'height':$(this).val()+'px'});

	    		}).trigger('change');


	    		$('input[name=horizontal_padding]').on('change',function(){
	    			$button_preview.css({'padding-left':$(this).val()+'px','padding-right':$(this).val()+'px'});
	    		}).trigger('change');


	    		$('input[name=input_horizontal_padding]').on('change',function(){
	    			$('input',$form_preview).css({'padding-left':$(this).val()+'px','padding-right':$(this).val()+'px'});
	    		}).trigger('change');


				$('input[name=button_align]').on('change',function(){
					$('.form-group',$form_preview).css('text-align',$(this).val());
				}).trigger('change');

				$('input[name=label_align]').on('change',function(){
					$('input',$form_preview).css('text-align',$(this).val());
				}).trigger('change');


				$('select[name=button_font]').on('change',function(){
					$button_preview.css('font-family',$(this).val());
				}).trigger('change');

	    		$('input[name=input_radius]').on('change',function(){
	    			$('input',$form_preview).css('border-radius',$(this).val()+'px');
	    		}).trigger('change');


	    		$('input[name=button_radius]').on('change',function(){
	    			$button_preview.css('border-radius',$(this).val()+'px');
	    		}).trigger('change');

	    		$('input[name=font_size]').on('change',function(){
	    			$button_preview.css('font-size',$(this).val()+'px');
	    		}).trigger('change');

	    		$('input[name=expanded][type=checkbox]').on('change',function(){

					if($(this).prop('checked')){
						$button_preview.css('width','100%');
					}
					else{
						$button_preview.css('width','auto');
					}
				}).trigger('change');

	    		$('input[name=gradient][type=checkbox]').on('change',function(){

					var gradient_color=$('input[name=gradient_color_to]').val();
					var colorbtn=$('input[name=button_color]').val();

					if($(this).prop('checked')){
						$button_preview.css({'background':'linear-gradient('+colorbtn+','+gradient_color+')'});
						$('.gradient-color-to.optin-preview').show();
					}
					else{
						$('.gradient-color-to.optin-preview').hide();
						$button_preview.css({'background':colorbtn});
					}

				}).trigger('change');

				$('input[name=button_text_color]').on('change',function(){
						$button_preview.css({'color':$(this).val()});
	    		})
	    		.wpColorPicker({
					change:function(event,ui){
						$button_preview.css({'color':ui.color.toString()});
					},
					clear:function(event, ui) {
						$button_preview.css({'color':'#ffffff'});
        			}
	    		}).trigger('change');

				$('input[name=button_color]').on('change',function(){
					if($('input[name=gradient][type=checkbox]').prop('checked')){
						var gradient_color=$('input[name=gradient_color_to]').val();
						$button_preview.css({'background':'linear-gradient('+$(this).val()+','+gradient_color+')'});
					}
					else{

						$button_preview.css({'background':$(this).val()});
					}
	    		})
	    		.wpColorPicker({
					change:function(event,ui){
						if($('input[name=gradient][type=checkbox]').prop('checked')){
							var gradient_color=$('input[name=gradient_color_to]').val();
							$button_preview.css({'background':'linear-gradient('+ui.color.toString()+','+gradient_color+')'});
						}
						else{

							$button_preview.css({'background':ui.color.toString()});
						}
					},
					clear:function(event, ui) {

						if($('input[name=gradient][type=checkbox]').prop('checked')){
							var gradient_color=$('input[name=gradient_color_to]').val();
							$button_preview.css({'background':'linear-gradient(#444444,'+gradient_color+')'});
						}
						else{

							$button_preview.css({'background':'#444444'});
						}

						
        			}
	    		})
	    		.trigger('change');

				$('input[name=gradient_color_to]').on('change',function(){
					if($('input[name=gradient][type=checkbox]').prop('checked')){
						var colorbtn=$('input[name=button_color]').val();
						$button_preview.css({'background':'linear-gradient('+colorbtn+','+$(this).val()+')'});
					}

	    		})
	    		.wpColorPicker({
					change:function(event,ui){
						var colorbtn=$('input[name=button_color]').val();
						if($('input[name=gradient][type=checkbox]').prop('checked')){
							$button_preview.css({'background':'linear-gradient('+colorbtn+','+ui.color.toString()+')'});
						}
						else{
							$button_preview.css({'background':colorbtn});
						}
					},
					clear:function(event, ui) {

						var colorbtn=$('input[name=button_color]').val();

						if($('input[name=gradient][type=checkbox]').prop('checked')){
							$button_preview.css({'background':'linear-gradient('+colorbtn+',#444444)'});
						}
						else{
							$button_preview.css({'background':colorbtn});
						}
        			}
	    		})
				.trigger('change');


				$('input[name=element_margin]').on('change',function(){

					var formtype=$('.select_optin_layout [name="layout"]').val();

					switch(formtype) {
					    case 'horizontal_email':
					    case 'horizontal':
					   		 $('input',$form_preview).css({'margin-right':$(this).val()+'px','width':'auto'});
					        break;
					    case 'vertical_email':
					    case 'vertical':
					   		 $('input',$form_preview).css('margin-bottom',$(this).val()+'px');
					    default:


					} 
				}).trigger('change');


	    	});
    	}

    	if($('.setting-element-section_header input[name=layout_type]').length){
    		$('.setting-element-section_header input[name=layout_type]').on('change',function(){

				var layout_type=$(this).val(),separator_position=$(this).closest('.setting-element-section_header').find('select[name=separator_position]');

				if(layout_type=='section-heading-polkadot-two-bottom'
				|| layout_type=='section-heading-thick-border'
				|| layout_type=='section-heading-thin-border'
				|| layout_type=='section-heading-double-border-bottom'
				|| layout_type=='section-heading-thin-border-top-bottom'
				){
					separator_position.closest('.field-wrap').show();

				}
				else{
					separator_position.closest('.field-wrap').hide();
				}

			}).trigger('change');

    	}

    	if($('[name=icon_size]').length){
    		var icon_size=$('[name=icon_size]');
    		var icon_prev=$('.dt-iconlist .icon-selection-preview i');

    		if(icon_prev.length){
	    		icon_size.on('change',function(){
	    			icon_prev.css('font-size',$(this).val()+'px');
	    		})
	    		.trigger('change');
    		}


    	}

    	if($('[name=pagination]').length){

    		var paginationSelect=$('[name=pagination]');
    		var pagination_type=$('[name=pagination_type]');
    		var pagination_image=$('[name=pagination_image]');

    		paginationSelect.on('change',function(){
    			if($(this).val()==1){
    				if(pagination_type.val()=='image'){
	   					pagination_image.closest('.field-wrap').show();
    				}
    				else{
	   					pagination_image.closest('.field-wrap').hide();
    				}
    			}
    			else{
   					pagination_image.closest('.field-wrap').hide();
    			}
    		}).trigger('change');
    	}
	});

});
