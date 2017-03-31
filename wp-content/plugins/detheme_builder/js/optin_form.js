jQuery(document).ready(function ($) {
    'use strict';

    if($('.optin-form').length){

        $('.optin-form').each(function(){
            var $optin=$(this),$form=$('.optin-content form',$optin);

            $form.submit(function(event) {
                event.preventDefault();
            });

            $('.form_connector_submit',$form).click(function(){

                var name = $('.dt_name',$form).val(),email = $('.dt_email',$form).val(),mailListCode=$(".optin_code",$optin);

                var datas = {
                    action: 'dt_frontend_submit_connector',
                    name: name,
                    email: email,
                    url: $(".optin_code",$optin).find("form").attr("action")
                };


                $.ajax({ 
                    data: datas,
                    type: 'post',
                    url: ajaxurl,
                    async:false,
                    success: function(data) {

                       var findName = $(mailListCode).find("input[name*=name], input[name*=NAME], input[name*=Name]").not("input[type=hidden]").val(name);
                       var findEmail = $(mailListCode).find("input[name*=email], input[name*=EMAIL], input[type=email], input[name=eMail]").not("input[type=hidden]").val(email);
                       $(mailListCode).find("input[type=submit], button, input[name=submit]").trigger('click');

                    }
                });


            });

        });



    }
});