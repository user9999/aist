$(function () {
  // ===========
  // фикс. шапка
  $(window).scroll(function () {
    if ( $('.acenter').length ) {
      var t = $(this),
        top = t.scrollTop(),
        left = t.scrollLeft();
      if( top > 100 ) $('.acenter').addClass('fixed');
      else $('.acenter').removeClass('fixed');
    }
    if ( $('#nav').length ) {
      var t = $(this),
        top = t.scrollTop(),
        left = t.scrollLeft();
      if( top > 400 ) $('#nav').addClass('fixed1');
      else $('#nav').removeClass('fixed1');
    }
    if ( $('#logo').length ) {
      var t = $(this),
        top = t.scrollTop(),
        left = t.scrollLeft();
      if( top > 80 ) $('#logo').addClass('lfixed');
      else $('#logo').removeClass('lfixed');
    }
  });
  // ===


});
