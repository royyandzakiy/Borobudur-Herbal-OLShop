if (typeof(window.$) === 'undefined') { window.$ = jQuery; } 
jQuery(document).ready(function($) {
    'use strict';
    function initCnSlider() {
    "use strict";
        if ($('.dt_vertical').length) {
            $('.dt_vertical').each(function () {
                var $cn_list    = $('.cn_list',$(this));
                var $pages      = $cn_list.find('.cn_page');
                //how many pages
                var cnt_pages   = $pages.length;
                //the default page is the first one
                var page        = 1;
                //list of news (left items)
                var $items      = $cn_list.find('.cn_item');
                //the current item being viewed (right side)
                var $cn_preview = $('.cn_preview',$(this));
                //index of the item being viewed. 
                //the default is the first one
                var current     = 1;

                $items.each(function(i){
                        var $item = $(this),itemnum=$items.length,cn_height=$item.outerHeight(true),cn_preview=cn_height*itemnum;
                        $item.data('idx',i+1);
                        $item.bind('click',function(){
                            var $this       = $(this);
                            $cn_list.find('.selected').removeClass('selected');
                            $this.addClass('selected');
                            var idx         = $(this).data('idx');
                            var $current    = $cn_preview.find('.cn_content:nth-child('+current+')');
                            var $next       = $cn_preview.find('.cn_content:nth-child('+idx+')');
                            
                           if(idx > current){
                                $current.stop().animate({'top':-cn_preview+'px'},900,'swing',function(){
                                    $(this).css({'top':cn_preview+'px'});
                                });
                                $next.css({'top':cn_preview+'px'}).stop().animate({'top':'0'},900,'swing');
                            }
                            else if(idx < current){
                                $current.stop().animate({'top':cn_preview+'px'},900,'swing',function(){
                                    $(this).css({'top':cn_preview+'px'});
                                });
                                $next.css({'top':-cn_preview+'px'}).stop().animate({'top':'0'},900,'swing');
                            }
                            current = idx;
                        });
                    });

           });
        }
    };

    initCnSlider();

    function adjustIconboxes(){

        'use strict';
        $('.module_dt_iconboxes').each(function () {
            var iconbox=$(this),moduleid=iconbox.attr('id');
            if($('.dt-iconboxes span',iconbox)){
                var icon=$('.dt-iconboxes span',iconbox);
                var parnt=icon.parent(),color=icon.css("background-color");
                if('undefined'!==color && ('transparent'==color || 'rgba(0, 0, 0, 0)'==color) )
                {
                    for (var i=0;i<10;i++){
                        
                        var parnt2=$(parnt).parent();

                        color=parnt2.css("background-color");
                        parnt=parnt2;

                       if('transparent'!==color && 'rgba(0, 0, 0, 0)'!==color.toString() && 'undefined'!==color)
                            break;
                    }

               if('transparent'!==color.toString() && 'rgba(0, 0, 0, 0)'!==color.toString() && 'undefined'!==color ){
                    var style='';
                    style+='#'+moduleid+' .dt-iconboxes span:after{border-top-color:'+color+' !important;}';
                    style+='#'+moduleid+' .dt-iconboxes span:hover:after{border-top-color:'+themeColor+' !important;}';
                   $('<style/>', {text: style}).appendTo('body');
                }
               }
            }
       });
        //dt-iconboxes span
    }
   adjustIconboxes();
   $('div:has(.shop-slider)').css('height','100%');
});


jQuery(document).ready(function($){
    // Search Popup
    var searchbox = $('.popup_form');
    $(searchbox).hide();

    $( ".search_btn" ).click(function() {
        $( ".cart-popup" ).fadeOut("fast", "swing");
        $('.md-modal').removeClass('md-show');
        $( ".popup_form" ).fadeToggle( "fast", "swing" );
        return false;
    });

    // Cart Popup
    var cartbox = $('.cart-popup');
    $(cartbox).hide();
    $( ".cart-click" ).click(function() {



        if($(window).width() >480 ){
            $( ".popup_form" ).fadeOut("fast", "swing");
            $('.md-modal').removeClass('md-show');
            $( ".cart-popup" ).fadeToggle( "fast", "swing" );
            return false;

        }
    });


    $('body').on('added_to_cart',function(){

        var cartTotal=$('body').find('.total .amount:first'),catItemCount=$('.total:first').data('items');
        $('.cart_amounts').html(cartTotal);
        $('.icon-shop span').html(catItemCount);
    }).click(function(event){

        if (!$(event.target).is(".cart-popup,.cart-popup *,.popup_form, .popup_form *")) {
            $( ".cart-popup,.popup_form" ).fadeOut("fast", "swing");
        }
    });


    $(".btn-cta").bind("click", function() {
    $('html, body').animate({scrollTop: $(".scroll-target").offset().top - 68}, 1500, 'swing'); //68px is the navbar width
    });
    // Half Logo Size

    $('.halfsize').each(function(){


        var img = new Image(),logo=$(this);
        img.onload = function() {

            logo.width(this.width * 0.5);

        }
        img.src = $(this).attr('src');

        
      $(this).fadeIn();
    });

});


// BS3 subMenu on hover
jQuery(document).ready(function() {
    dtsetSlideBG();
});

jQuery(window).resize(function(){    

    'use strict';

    if ($(".jquery-media-detect").css("display") == "block" ){
        $("ul.nav li.dropdown").hover(function() {
            $(".dropdown-menu", this).fadeIn();
        }, function() {
            $(".dropdown-menu", this).fadeOut("fast")
        })
    }

    // Full Screen Slider
    dtsetSlideBG();
});

function dtsetSlideBG() {
    $('.slide-bg').css({
        marginLeft: - ($(window).width() - $('.slide-frame').outerWidth())/2,
        height: ($(window).height()),
        width : ($(window).width()) + 200
    }); 
}

/* --- Counter Functions--- */

function dtDoCounter($this,$to) {

    "use strict";
    $j($this).css('opacity', '1');
    $j($this).countTo({
        from: 0,
        to: $to,
        speed: 1500,
        refreshInterval: 50
    })
}



function dtCounter() {

    "use strict";
    if ($j('.dt-counter').length) {
        $j('.dt-counter').each(function () {
            $j(this).appear(function () {
                var $countTo = $j(this).text();
                if ($(window).width()>480) {
                    dtDoCounter($j(this),$countTo);
                }
            }, {
                accX: 0,
                accY: -100
            })
        })
    }
}



/* --- Parallax Background Function--- */

function dtParallax() {

    "use strict";
    var $window = $(window);
    var minwidthparallax = 768;

    $('section[data-type="background"]').each(function(){
        var $bgobj = $(this); // assigning the object
   

        $window.scroll(function() {
            if ($(this).width()>minwidthparallax) {
                var position=$bgobj.position();
                var yPos = (($(document).scrollTop() - position.top) / $bgobj.data('speed'));

               // Put together our final background position
                var coords = '50% '+ yPos + 'px';
                // Move the background

                $bgobj.css({ backgroundPosition: coords });
            }
        }); 
    });    


    $('div[data-type="background"]').each(function(){
        var $bgobj = $(this); // assigning the object
        $window.scroll(function() {

           if ($(this).width()>minwidthparallax) {
                var position=$bgobj.position();
                var yPos = (($(document).scrollTop() - position.top) / $bgobj.data('speed'));
                // Put together our final background position
                var coords = '50% '+ yPos + 'px';
   

                // Move the background
                $bgobj.css({ backgroundPosition: coords });
            }
        }); 
    });    
}



jQuery(document).ready(function($){

    "use strict";
    dtParallax();
    dtCounter();

    // validate contact form 
    $("#dt-checkout-form").validate({
        rules: {
            billing_country: "required",
            billing_first_name: "required",
            billing_last_name: "required",
            billing_address_1: "required",
            billing_postcode: "required",
            billing_city: "required",
            billing_email: {
                required: true,
                email: true
            },
            billing_phone: "required",
            shipping_country: "required",
            shipping_first_name: "required",
            shipping_last_name: "required",
            shipping_address_1: "required",
            shipping_postcode: "required",
            shipping_city: "required"
        },
        messages: {
            billing_country: "Please select your Country",
            billing_first_name: "Please enter your First Name",
            billing_last_name: "Please enter your Last Name",
            billing_address_1: "Please enter your Address",
            billing_postcode: "Please enter your Post Code",
            billing_city: "Please enter your Town/City",
            billing_email: "Please enter a valid email address",
            billing_phone: "Please enter your Phone Number",
            shipping_country: "Please select your Country",
            shipping_first_name: "Please enter your First Name",
            shipping_last_name: "Please enter your Last Name",
            shipping_address_1: "Please enter your Address",
            shipping_postcode: "Please enter your Post Code",
            shipping_city: "Please enter your Town/City"

        }

    });

    //Checkout Page
    $("#shiptobilling-checkbox").change(function() {
        $("#shipping_address").toggle();
    });

    $("#payment_method_cheque").change(function() {
        $(".payment_box").each(function(){
            $(this).hide();
        });
        $("#payment_box_cheque").toggle();
    });

    $("#payment_method_paypal").change(function() {
        $(".payment_box").each(function(){
            $(this).hide();
        });
        $("#payment_box_paypal").toggle();
    });

    $("#payment_method_visa").change(function() {
        $(".payment_box").each(function(){
            $(this).hide();
        });
        $("#payment_box_visa").toggle();
    });

    $("#payment_method_mastercard").change(function() {
        $(".payment_box").each(function(){
            $(this).hide();
        });
        $("#payment_box_mastercard").toggle();
    });

    
    $("#num1").val(Math.floor((Math.random()*10)));
    $("#num2").val(Math.floor((Math.random()*10)));
}); 


/* Form Validation */

$.validator.addMethod('captcha',

  function(value) {
    $result = ( parseInt($('#num1').val()) + parseInt($('#num2').val()) == parseInt($('#captcha').val()) ) ;
    $('#spambot').fadeOut('fast');
        return $result;
    },
        'Incorrect value, please try again.'
    );


jQuery(document).ready(function($){
    $('#dt-contact-form').submit(function(e){

        "use strict";
        e.preventDefault();
        if ($("#dt-contact-form").valid()) {
            var ajaxurl = $('#dt-contact-form #ajaxURL').val();
            var data = {
                'type': 'POST',
                'action': 'contact_action',
                'inputFullname': $('#inputFullname').val(),
                'inputEmail': $('#inputEmail').val(),
                'inputPhone': $('#inputPhone').val(),
                'inputMessage': $('#inputMessage').val(),
                'num1': $('#num1').val(),
                'num2': $('#num2').val(),
                'captcha': $('#captcha').val()
            }

            // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
            $.post(ajaxurl, data, function(response) {
                if (response) {
                    $('.sendemail.success').fadeIn(1000);
                    $('#dt-contact-form').each(function(){
                        this.reset();
                    });
                } else {
                    $('.sendemail.fail').fadeIn(1000);
                }
            });
        }

    });
});


function isValidCaptcha(num1,num2,captcha) {

    $result = ( parseInt(num1) + parseInt(num2) == parseInt(captcha) ) ;

    if (!$result) {
        $('.captchaerror.fail').fadeIn(1000);
    } else {
        $('.captchaerror.fail').fadeOut(1000);
    }
    return $result;
}

  // modified Isotope methods for gutters in masonry

  $.Isotope.prototype._getMasonryGutterColumns = function() {
    var gutter = this.options.masonry && this.options.masonry.gutterWidth || 0;
    var containerWidth = this.element.width();
    this.masonry.columnWidth = this.options.masonry && this.options.masonry.columnWidth ||
    // or use the size of the first item
    this.$filteredAtoms.outerWidth(true) ||
    // if there's no items, use size of container
    containerWidth;
    this.masonry.columnWidth += gutter;
    this.masonry.cols = Math.floor( ( containerWidth + gutter ) / this.masonry.columnWidth );
    this.masonry.cols = Math.max( this.masonry.cols, 1 );
  };

  $.Isotope.prototype._masonryReset = function() {
    // layout-specific props
    this.masonry = {};
    // FIXME shouldn't have to call this again
    this._getMasonryGutterColumns();
    var i = this.masonry.cols;
    this.masonry.colYs = [];
    while (i--) {
      this.masonry.colYs.push( 0 );
    }
};



  $.Isotope.prototype._masonryResizeChanged = function() {
    var prevSegments = this.masonry.cols;
    // update cols/rows
    this._getMasonryGutterColumns();
    // return if updated cols/rows is not equal to previous
    return ( this.masonry.cols !== prevSegments );
  };

jQuery(document).ready(function($) {

    'use strict';

    // dt portfolio module

    if ($('.portfolio-module').length) {
        $('.portfolio-module').each(function(){

            var module=$(this);
            var getMasonry=function(mod){

                var $modcontainer=$('.portfolio-module-items',mod),modwidth=mod.outerWidth(true),masonryCol=mod.hasClass('col-4')?4 : mod.hasClass('col-3')?3:2;


                    if($(window).width() >= 992 && $(window).width() < 1024){

                        masonryCol=mod.hasClass('col-5')?4:mod.hasClass('col-4')?3:mod.hasClass('col-3')?2:2;

                    }else if($(window).width() >= 768 && $(window).width() < 992){
                        masonryCol=mod.hasClass('col-5')?3:mod.hasClass('col-4')?3:mod.hasClass('col-3')?2:2;

                    }else if($(window).width() >= 480 && $(window).width() < 768){
                        
                        masonryCol=2;

                    }else if($(window).width() < 480){
                        masonryCol=1;   
                    }

                    masonryCol=(modwidth-(40*(masonryCol - 1)))/masonryCol;

                    $(".portfolio-item",$modcontainer)

                    .each(function(){
                            this.slide = $(this).find('.top-image img');
                            this.slide.height(masonryCol);
                            $(this).width(masonryCol).height(masonryCol);
                            this.desc = $(this).find('.description').height(masonryCol);

                            this.animated=false;

                            $(this).hover(function(){
                                this.desc.animate({'margin-top':-this.slide.height()});
                            },function(){
                                this.desc.animate({'margin-top':'0px'});
                            });

                    });

                try{
                        $modcontainer.isotope({
                              itemSelector: '.portfolio-item',
                              resizable: false, 
                              layoutMode: 'masonry',
                              masonry: { 
                                  columnWidth: masonryCol,
                                  gutterWidth: 40
                              }

                        });

                        var filter=jQuery('.dt-portfolio-filter a',mod);

                        if(filter.length && $('.portfolio-item',$modcontainer).length){
                                        filter.click(function(e){

                                        var selector = $(this).data('filter');

                                        if(selector!==undefined){
                                                e.preventDefault();
                                                        if(selector=='*'){
                                                                $modcontainer.isotope( {filter:selector}).isotope('reloadItems');
                                                        }else{
                                                            $modcontainer.isotope( {filter:selector} );
                                                        }                           
                                        }
                                        $(this).parents('ul').find('a,li').removeClass('active');
                                        $(this).addClass('active').parent().addClass('active');
                                        return false;
                                    });
                            }
                    }
                    catch(err){
                    }
            }
            getMasonry(module);

            $(window).smartresize(function(){
                getMasonry(module);
            })
        });
    }

    if ($('.portfolio').length) {
        $('.portfolio').each(function(){

            'use strict';

            var portfolio=$(this);

            var getPortMasonry=function(mod){
                'use strict';
                var $container=$('.portfolio-container',mod),modwidth=$container.outerWidth(true),masonryCol=$container.hasClass('col-5')?5 : $container.hasClass('col-4')?4:$container.hasClass('col-3')?3:2;

                    if($(window).width() >= 992 && $(window).width() < 1024){

                        masonryCol=$container.hasClass('col-5')?4:$container.hasClass('col-4')?3:$container.hasClass('col-3')?2:2;

                    }else if($(window).width() >= 768 && $(window).width() < 992){
                        masonryCol=$container.hasClass('col-5')?3:$container.hasClass('col-4')?3:$container.hasClass('col-3')?2:2;

                    }else if($(window).width() >= 480 && $(window).width() < 768){
                        
                        masonryCol=2;

                    }else if($(window).width() < 480){
                        masonryCol=1;   
                    }


                    masonryCol=(modwidth-(20*(masonryCol - 1)))/masonryCol;

                    $(".portfolio-item",$container)
                            .each(function(){
                                if(mod.is('.portfolio-with-desc')){
                                        if($(window).width() < 480){
                                            $(this).width(masonryCol);
                                            $(this).find('img').width($(this).width());
                                        }
                                        else{

                                            if($(this).is('.landscape')){
                                                $(this).width(((masonryCol*2)+20));
                                            }
                                            else{

                                                $(this).width(masonryCol);
                                            }
                                            $(this).find('img').width($(this).width()).height(masonryCol);

                                        }
                                }
                                    else{
                                
                                        if($(window).width() < 480){
                                            if($(this).is('.big-square')){
                                                $(this).width(masonryCol).height(masonryCol);
                                            }
                                            else if($(this).is('.landscape')){
                                                $(this).width(masonryCol);
                                            }
                                            else if($(this).is('.portrait')){
                                                $(this).width(masonryCol).height(masonryCol);
                                            }
                                            else{
                                                $(this).width(masonryCol).height(masonryCol);
                                            }
                                        }
                                        else{
                                            if($(this).is('.big-square')){
                                                $(this).width(((masonryCol*2)+20)).height(((masonryCol*2)+20));
                                            }
                                            else if($(this).is('.landscape')){
                                                $(this).height(masonryCol).width(((masonryCol*2)+20));
                                            }
                                            else if($(this).is('.portrait')){
                                                $(this).width(masonryCol).height(((masonryCol*2)+20));
                                            }
                                            else{
                                                $(this).width(masonryCol).height(masonryCol);
                                            }
                                        }
                                    }
                        });

                    var reloadMore=function($el){
                        'use strict';
                        

                        $(".portfolio-item.hover-this",$el)
                            .each(function(){
                                    this.slide = $(this);
                                    this.slide.find('.top-image').height(this.slide.height());
                                    this.desc   = $(this).find('.description').height(this.slide.height());

                            })
                            .hover(function(){
//                                    alert(this.desc.css("marginTop"));
                                    this.desc.animate({'margin-top':-this.slide.height()});
                            },function(){
                                    this.desc.animate({'margin-top':'0px'});
                            });


                            jQuery('.portfolio-item.more-post',$el).unbind('click').click(function(e){
                                    e.preventDefault();
                                    var scriptUrl=jQuery(this).find('a').attr('href'),hashChanged=true,removeItem = jQuery(this);
                                    $el.isotope('remove', removeItem);


                                    $.ajax({
                                        url: scriptUrl+'&t='+$.now(),
                                        type: 'get',
                                        dataType: 'html',
                                        async: false,
                                        success: function(html) {

                                            var filtered=jQuery(html).find('.portfolio-item');  

                                            filtered.each(function(i,el){

                                                if($(portfolio).is('.portfolio-with-desc')){

                                                            if($(window).width() < 480){
                                                                $(el).width(masonryCol);
                                                                $(el).find('img').width($(el).width());
                                                            }
                                                            else{
                                                                if($(el).is('.landscape')){
                                                                    $(el).width(((masonryCol*2)+20));
                                                                }
                                                                else{
                                                                    $(el).width(masonryCol);
                                                                }
                                                                $(el).find('img').width($(el).width()).height(masonryCol);
                                                            }
                                                }
                                                else{
                                                    if($(window).width() < 480){
                                                        if($(el).is('.big-square')){
                                                            $(el).width(masonryCol).height(masonryCol);
                                                        }
                                                        else if($(el).is('.landscape')){
                                                            $(el).width(masonryCol);
                                                        }
                                                        else if($(el).is('.portrait')){
                                                            $(el).width(masonryCol).height(masonryCol);
                                                        }
                                                        else{
                                                            $(el).width(masonryCol).height(masonryCol);
                                                        }
                                                    }
                                                    else{
                                                        if($(el).is('.big-square')){
                                                            $(el).width(((masonryCol*2)+20)).height(((masonryCol*2)+20));
                                                        }
                                                        else if($(el).is('.landscape')){
                                                            $(el).height(masonryCol).width(((masonryCol*2)+20));
                                                        }
                                                        else if($(el).is('.portrait')){
                                                            $(el).width(masonryCol).height(((masonryCol*2)+20));
                                                        }
                                                        else{
                                                            $(el).width(masonryCol).height(masonryCol);
                                                        }
                                                    }
                                                }

                                                $el.isotope('insert',$(el));

                                            });

                                            jQuery('.popup-gallery',jQuery('<div>'+html+'</div>')).each(function(i,el){

                                                $(el).insertBefore('.md-overlay');
                                                
                                            });


                                            initModal();
                                            reloadMore($el);
                                            hashChanged=false;

                                        } 

                                     });
                            });
                        },
                        initModal=function () {
                        var overlay = document.querySelector( '.md-overlay' );
                        [].slice.call( document.querySelectorAll( '.md-trigger' ) ).forEach( function( el, i ) {
                            var modal = document.querySelector( '#' + el.getAttribute( 'data-modal' ) ),
                                close = modal.querySelector( '.md-close' );
                            function removeModal( hasPerspective ) {
                                classie.remove( modal, 'md-show' );
                                if( hasPerspective ) {
                                    classie.remove( document.documentElement, 'md-perspective' );
                                }
                            }
                            function removeModalHandler() {
                                removeModal( classie.has( el, 'md-setperspective' ) ); 
                            }
                            el.addEventListener( 'click', function( ev ) {
                                classie.add( modal, 'md-show' );
                                overlay.removeEventListener( 'click', removeModalHandler );
                                overlay.addEventListener( 'click', removeModalHandler );
                                if( classie.has( el, 'md-setperspective' ) ) {
                                    setTimeout( function() {
                                        classie.add( document.documentElement, 'md-perspective' );
                                    }, 25 );
                                }
                            });
                            close.addEventListener( 'click', function( ev ) {
                                ev.stopPropagation();
                                removeModalHandler();
                            });
                        });
                    };

                    try{

                        $container.isotope({
                              itemSelector: '.portfolio-item',
                              resizable: false, 
                              layoutMode: 'masonry',
                              masonry: { 
                                columnWidth: masonryCol,
                                gutterWidth:20  
                              },
                              getSortData : {
                                group : function ( $elem ) {
                                  return $elem.attr('group');
                                },
                                
                                random: function ($elem) {
                                    if($elem.hasClass('ignore-shuffle')) {
                                         return -1;   
                                    }
                                    else if($elem.hasClass('more-post')){
                                        return 1; 
                                    }
                                       return Math.random();
                                    }
                                },
                              sortBy:'random',
                              filter:'*:not(.more-post)'
                        }); 

                        var filter=jQuery('.dt-featured-filter a',mod);

                        if(filter.length && $('.portfolio-item',$container).length){

                                    filter.click(function(e){
                                    var selector = $(this).data('filter');
                                    if(selector!==undefined){
                                            e.preventDefault();
                                                    if(selector=='*'){
                                                            $container.isotope( {filter:'*:not(.more-post)'}).isotope('reloadItems');
                                                    }else{
                                                        $container.isotope({filter:selector});
                                                    }                           
                                    }
                                    $(this).parents('ul').find('a,li').removeClass('active');
                                    $(this).addClass('active').parent().addClass('active');
                                    return false;

                                });
                        }

                        reloadMore($container);                 
                    }
                    catch(err){}
            }

            getPortMasonry(portfolio);

            $(window).smartresize(function(){
                getPortMasonry(portfolio);
            })
        });
    }


    /* dt woocommerce product */

    if ($('.woocommerce-module').length) {
        $('.woocommerce-module').each(function(){

            var module=$(this);
            var getWooMasonry=function(mod){

                var $modcontainer=$('.woocommerce-module-items',mod),modwidth=mod.outerWidth(true),masonryCol=mod.hasClass('col-4')?4 : mod.hasClass('col-3')?3:2,cellheight=200;
                    masonryCol=(modwidth-(40*(masonryCol - 1)))/masonryCol;

                    $(".masonry-item",$modcontainer)
                    .each(function(){
                       $(this).width(masonryCol);
                    });


                    var productImage=$(".masonry-item .product-thumbnail img",mod),loaded=[];

                    if(productImage.length){

                        productImage.each(function(index){
                            var im = $(this).attr('src');
                            if(im!=''){
                                var img = new Image();
                                img.src = im;

                                loaded[index]=false;

                                img.onload = function() {
                                                if (img.complete) {
                                                   loaded[index]=true;
                                                   startWooMasonry();
                                                }
                                };


                            }
                        });

                    }
                    else{
                        startWooMasonry();
                    }

                    function startWooMasonry(){

                        var st=true;

                        for (var i = 0; i < loaded.length; i++) {
                            if(loaded[i]==false) st=false;
                        } 

                        if(st){
                           try{
                                $modcontainer.isotope({
                                      itemSelector: '.masonry-item',
                                      resizable: false, 
                                      layoutMode: 'masonry',
                                      masonry: { 
                                      columnWidth: masonryCol,
                                      gutterWidth: 40
                                      }
                                });

                                var filter=jQuery('.dt-featured-filter a',mod);
                                if(filter.length && $('.masonry-item',$modcontainer).length){
                                                filter.click(function(e){
                                                var selector = $(this).data('filter');

                                                if(selector!==undefined){
                                                        e.preventDefault();
                                                                if(selector=='*'){
                                                                        $modcontainer.isotope( {filter:selector}).isotope('reloadItems');
                                                                }else{
                                                                    $modcontainer.isotope( {filter:selector} );
                                                                }                           

                                                }
                                                $(this).parents('ul').find('a,li').removeClass('active');
                                                $(this).addClass('active').parent().addClass('active');
                                                return false;
                                            });
                                }

                            }
                            catch(err){
                            }
                        }
                    }
            }
            getWooMasonry(module);

            $(window).smartresize(function(){
                getWooMasonry(module);
            })
        });
    }

/*
    var itemheight=0;

    $('.shop-bottom .list-item').each(function(index,e){
        itemheight=Math.max($(e).outerHeight(),itemheight);
    }).height(itemheight);
*/

    /* bog masonry 2, 3 , 4 & 5 col */ 

    if ($('.blog-masonry').length) {
        $('.blog-masonry').each(function(){
            'use strict';

            var blog=$(this);
            var getBlogMasonry=function($mod){
                'use strict';

                var masonryCol=$mod.hasClass('col-5')?5 : $mod.hasClass('col-4')?4:$mod.hasClass('col-3')?3:2;

                if($(window).width() >= 768 && $(window).width() < 1024){
                    masonryCol=$mod.hasClass('col-5')?4:$mod.hasClass('col-4')?3:$mod.hasClass('col-3')?2:2;

                }else if($(window).width() >= 480 && $(window).width() < 768){
                    masonryCol=2;
                }else if($(window).width() < 480){
                    masonryCol=1;
                }

                var colWidth=($mod.outerWidth(true)-(40*(masonryCol - 1)))/masonryCol;

                $(".masonry-item",$mod)
                .each(function(){
                        $(this).width(colWidth);
                });

                var topImage=$(".masonry-item .top-image img",$mod),loaded=[];

                if(topImage.length){

                    topImage.each(function(index){
                        var im = $(this).attr('src');
                        if(im!=''){
                            var img = new Image();
                            img.src = im;

                            loaded[index]=false;

                            img.onload = function() {
                                            if (img.complete) {
                                               loaded[index]=true;
                                               startMasonry();
                                            }
                            };


                        }
                    });

                }
                else{
                    startMasonry();
                }

                function startMasonry(){

                    var st=true;

                    for (var i = 0; i < loaded.length; i++) {
                        if(loaded[i]==false) st=false;
                    } 

                    if(st){
                       try{
                            $mod.isotope({
                                  itemSelector: '.masonry-item',
                                  resizable: false, 
                                  layoutMode: 'masonry',
                                  masonry: { 
                                  columnWidth: colWidth,
                                  gutterWidth: 40
                                  }
                            });
                        }
                        catch(err){
                        }
                    }


                }
            };



            getBlogMasonry(blog);

                $(window).smartresize(function(){
                    'use strict';
                    getBlogMasonry(blog);
                });

            });
    }

    /* shop detail */

    if($("#owl_large_thumbnail").length){

        $("#owl_large_thumbnail").owlCarousel({
            navigation : false, // Show next and prev buttons
            slideSpeed : 300,
            paginationSpeed : 400,
            singleItem:true,
            pagination:false
        });

        //alert($("#owl_large_thumbnail"));

        var owl = $("#owl_large_thumbnail").data('owlCarousel');

        var thumbsProduct=$('.single-product .small-thumbnails');
            thumbsProduct.children().removeClass('col-xs-3').addClass('col-xs-12');
            var navigation=$('<div></div>').addClass('owl-carousel-navigation'),
            prevBtn=$('<a></a>').addClass('btn btn-owl'),
            nextBtn=prevBtn.clone();
            navigation.append(prevBtn.addClass('prev'),nextBtn.addClass('next'));
            thumbsProduct.parent().append(navigation);
            try{
                thumbsProduct.owlCarousel({
                    items       : 4, //10 items above 1000px browser width
                    itemsDesktop    : [1200,3], //5 items between 1000px and 901px
                    itemsDesktopSmall : [992,3], // 3 items betweem 900px and 601px
                    itemsTablet : [768,4], //2 items between 600 and 0;
                    itemsMobile : [480,3], // itemsMobile disabled - inherit from itemsTablet option
                    pagination  : false,
                    slideSpeed  : 400
                });
                prevBtn.click(function(){
                    thumbsProduct.trigger('owl.prev');
                });
                nextBtn.click(function(){
                    thumbsProduct.trigger('owl.next');
                });
            }
            catch(err){}

        if(thumbsProduct.children().length > 0) {
            var thumbsProductItem=$('.single-product .small-thumbnails .owl-item img');
            thumbsProductItem.each(function(index) {
                $(this).click(function(){
                    owl.goTo(index);
                });
            });
        }

    } /* end if */

    $(window).smartresize();
    $(window).resize();
    $(document).scroll();
});