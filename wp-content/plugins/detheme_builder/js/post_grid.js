(function( window, $, undefined ){

  'use strict';

  var $event = $.event,
      dispatchMethod = $.event.handle ? 'handle' : 'dispatch',
      resizeTimeout;

  $event.special.smartresize = {
    setup: function() {
      $(this).bind( "resize", $event.special.smartresize.handler );
    },
    teardown: function() {
      $(this).unbind( "resize", $event.special.smartresize.handler );
    },
    handler: function( event, execAsap ) {
      // Save the context
      var context = this,
          args = arguments;

      // set correct event type
      event.type = "smartresize";


      if ( resizeTimeout ) { clearTimeout( resizeTimeout ); }
      resizeTimeout = setTimeout(function() {
        $event[ dispatchMethod ].apply( context, args );
      }, execAsap === "execAsap"? 0 : 100 );
    }
  };

  $.fn.smartresize = function( fn ) {
    return fn ? this.bind( "smartresize", fn ) : this.trigger( "smartresize", ["execAsap"] );
  };

})( window, jQuery );

( function( window ) {

function fitRowsDefinition( LayoutMode ) {

  var omnifitRows = LayoutMode.create('fitRows');

  omnifitRows.prototype._resetLayout = function() {
    this.x = 0;
    this.y = 0;
    this.maxY = 0;
  };

  omnifitRows.prototype._getItemLayoutPosition = function( item ) {
    item.getSize();

   // if this element cannot fit in the current row
    if ( this.x !== 0 && item.size.outerWidth + this.x > this.isotope.size.innerWidth ) {
      this.x = 0;
      this.y = this.maxY;
    }
    else if(typeof this.options.gutter!='undefined' && this.x !== 0 && item.size.outerWidth + this.x < this.isotope.size.innerWidth){
      this.x += this.options.gutter;
    }

    var position = {
      x: this.x,
      y: this.y
    };

    this.maxY = Math.max( this.maxY, this.y + item.size.outerHeight );
    this.x += item.size.outerWidth;

    return position;
  };

  omnifitRows.prototype._getContainerSize = function() {
    return { height: this.maxY };
  };

  return omnifitRows;


}

if ( typeof define === 'function' && define.amd ) {
  // AMD
  define( 'isotope/js/layout-modes/omnifitRows',[
      '../layout-mode'
    ],
    fitRowsDefinition );
} else {
  // browser global
  fitRowsDefinition(
    window.Isotope.LayoutMode
  );
}

})( window );


jQuery(document).ready(function($){
    "use strict";

     if ($('[data-isotope]').length) {
        $('[data-isotope]').each(function(i,el){

          var $post=$(el),$grid=$post.find(".grid-container"),gutter=$post.data('gutter')?$post.data('gutter'):0,
          type=$post.data('isotope')?$post.data('isotope'):'masonry',gridcolumn=$post.data('column')?$post.data('column'):3,
          lgcolumn=$post.data('column-lg')?$post.data('column-lg'):gridcolumn,mgcolumn=$post.data('column-md')?$post.data('column-md'):gridcolumn,
          smcolumn=$post.data('column-sm')?$post.data('column-sm'):gridcolumn,xscolumn=$post.data('column-xs')?$post.data('column-xs'):gridcolumn,
          masonryCol,modwidth;

          var getPostMasonry=function(){

              if(!$grid.length || !$post.find(".isotope-item").length)
                return;

                modwidth=$grid.innerWidth();

                var column=gridcolumn;

                if($(window).width() >= 992 && $(window).width() < 1200){
                  column=lgcolumn;
                }else if($(window).width() >= 768 && $(window).width() < 992){
                  column=mgcolumn;

                }else if($(window).width() >= 480 && $(window).width() < 768){
                        
                  column=smcolumn;

                }else if($(window).width() < 480){
                  column=xscolumn;
                }

                masonryCol=Math.floor((modwidth-(gutter*(column - 1)))/column) - (column - 1)*0.25;

               $grid.find('.isotope-item').width(masonryCol);

               $grid.isotope({
                    itemSelector: '.isotope-item',
                    layoutMode:type=='masonry'?'masonry':'fitRows',
                    masonry: { 
                      columnWidth: masonryCol,
                      gutter:gutter
                    },
                    fitRows:{
                      gutter:gutter
                    }
                 }); 

          };
      getPostMasonry();

      $(window).smartresize(function(){
         getPostMasonry();
      });


    });
  } 
});