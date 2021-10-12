$(function () {
  $(".adminmenu.recursive ul li").each(function(){
    if($(this).children().length==3){
        //console.log($(this).children().length);
        $(this).children("span").attr('class', 'closed');//addClass('closed');
    }
    if($(this).has( "ul" )){

    }
    
  });
  $("ul.menu.recursive li").on('click','span',function(){//span.closed
    console.log("click");
    status=$(this).attr("class");

    if(status=='closed'){
        $(this).parent().children('ul').show('slow');
        $(this).attr('class', 'opened');
    }else if(status=='opened'){
        $(this).parent().children('ul').hide('slow');
        $(this).attr('class', 'closed');
    }
});
});


