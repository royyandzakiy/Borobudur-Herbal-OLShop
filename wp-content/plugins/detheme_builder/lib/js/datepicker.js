jQuery(document).ready(function ($) {

	try{

		$('.datepicker').each(function(i,el){

			$(el).css('border','solid 5px red');
			$(el).datepicker({
		        dateFormat : 'dd-mm-yy'
	    	}).datepicker( "show" );


		});

		//.datepicker({
		//        dateFormat : 'dd-mm-yy'
    	//});


	}
	catch(err){

	}


});
