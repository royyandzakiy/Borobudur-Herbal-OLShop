$(document).ready(function(){



	'use strict';



	var initSubSlider=function () {

		if($('.sequence-sub-slider').length){



			$('.sequence-sub-slider').each(function () {



					var options = {

						autoPlay: false,

						nextButton: true,

						prevButton: true,

						preloader: true,

						navigationSkip: true,

						animateStartingFrameIn: true,

						autoPlayDelay:1000,

						pauseOnHover : false,

						transitionThreshold:2000,

						reverseAnimationsWhenNavigatingBackwards : false,	

						preventDelayWhenReversingAnimations : true			

					};





					try{

						var sequence = $(this).sequence(options).data("sequence");

					}

					catch(err){}





			});

		}



	};



	initSubSlider();

});