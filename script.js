jQuery(function(){

  menuToggle();

});

function menuToggle(){
  jQuery('.menu-slide').on('click', function(e){
    e.stopPropagation();
  });

  jQuery('.menu-close, .menu-ham, .menu-overlay').on('click', function(){
    jQuery('html').toggleClass('menu-open');
  });
}


/** end of jQuery wrapper */
