$(document).ready(function(){

        'use strict';
        var options = {
            autoPlay: true,
            nextButton: true,
            prevButton: true,
            navigationSkip: true,
            animateStartingFrameIn: true,
            autoPlayDelay:3000,
            pauseOnHover : false,
            transitionThreshold:1500,
            preloader: true,
            preloadTheseImages: /*[
                "http://localhost/wp-krypton/wp-content/themes/krypton/images/main_slide/home_banner1.jpg",
                "http://localhost/wp-krypton/wp-content/themes/krypton/images/main_slide/home_banner2.jpg",
                "http://localhost/wp-krypton/wp-content/themes/krypton/images/main_slide/home_banner3.jpg",
                "http://localhost/wp-krypton/wp-content/themes/krypton/images/main_slide/home_banner4.jpg"
            ]*/
            ,
            reverseAnimationsWhenNavigatingBackwards : false,   
            preventDelayWhenReversingAnimations : true
        };
        try{
            var sequence = $("#sequence").sequence(options).data("sequence");
        }
        catch(err){alert(err);}    
});