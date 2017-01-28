!function ($) {

  /** Set up initial load and load on option updates (.pl-trigger will fire this) */
  $( '.pl-sn-offcanvas' ).on('template_ready', function(){

    $.plOffcanvas.init( $(this) )

  })

  /** A JS object to encapsulate functions related to the section */
  $.plOffcanvas = {

    init: function( section ){

      var that       = this

      $('.menu-slide').on('click', function(e){
        e.stopPropagation();
      });

      $('.menu-close, .menu-ham, .menu-overlay').on('click', function(){
        $('html').toggleClass('menu-open');
      });
    }

    }
  }

/** end of jQuery wrapper */
