$(document).ready(function(){


$('.configurator-plitka').click(function() {
//////////////// СТИЛЕВОЕ ВЫДЕЛЕНИЕ ПЛИТОК /////////////////
  var par = $(this).parents();
  var parClass = par.attr('class');

  if($(this).hasClass("is_active")){
    $('.'+parClass).find('.configurator-plitka').removeClass('is_active');
    $('.'+parClass).children('input').attr('value','');
  } else {
    $('.'+parClass).find('.configurator-plitka').removeClass('is_active');
    $(this).toggleClass('is_active'); 
    $('.'+parClass).children('input').attr('value',$(this).attr('data-id'));
  }
//////////////// СТИЛЕВОЕ ВЫДЕЛЕНИЕ ПЛИТОК /////////////////  


/////////////////// МАТЕМАТИКА С ЦЕНАМИ ////////////////////
  var priceAct = Number($('.'+parClass).find('.configurator-plitka.is_active').attr('data-price'));
    if(!priceAct) priceAct=0;
  
  var childPlitka = $('.'+parClass).find('.configurator-plitka');  
    for (var i = 0; i < childPlitka.length; i++) {
      if(childPlitka.eq(i).hasClass("is_active") && priceAct){
          childPlitka.eq(i).children('.plitka-price').html(Number(childPlitka.eq(i).attr('data-price')));
      } else {
          var priceTmp = Number(childPlitka.eq(i).attr('data-price'));
          priceTmp = priceTmp - priceAct;
            if(priceTmp > 0) priceTmp='+'+priceTmp; 
          childPlitka.eq(i).children('.plitka-price').html(priceTmp);
      }
    }
/////////////////// МАТЕМАТИКА С ЦЕНАМИ ////////////////////


//////////////// ИТОГОВОЕ ЗНАЧЕНИЕ ЦЕНЫ /////////////////
  var summAll=0;
  var priceAct_arr = $('.configurator-all').find('.configurator-plitka.is_active');
    for (var i = 0; i < priceAct_arr.length; i++) {
      summAll = summAll + Number(priceAct_arr.eq(i).attr('data-price'));
    }
  $('.configurator-sum-all').attr('data-price-all',summAll);
  $('.configurator-sum-all').html(summAll);  
//////////////// ИТОГОВОЕ ЗНАЧЕНИЕ ЦЕНЫ /////////////////   
});




});
