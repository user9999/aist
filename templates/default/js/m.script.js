$(function () {
  $(".adminmenu.recursive ul li").each(function(){
    if($(this).children().length==3){
        //console.log($(this).children().length);
        $(this).children("span").attr('class', 'closed');//addClass('closed');
    }
    if($(this).has( "ul" )){
        
        //console.log($(this).children());
    }
    
  });
  $("ul.menu.recursive li").on('click','span',function(){//span.closed
    console.log("click");
    status=$(this).attr("class");
    
    //console.log($(this).attr("class"));//$(this).parent().parent().attr('id');
    if(status=='closed'){
        $(this).parent().children('ul').show('slow');
        $(this).attr('class', 'opened');
    }else if(status=='opened'){
        $(this).parent().children('ul').hide('slow');
        $(this).attr('class', 'closed');
    }
    //$(this).parent().children('ul').show('slow');
    //ul_id=$(this).parent().parent().attr('id');
    //menu_id[ul_id]='opened';
    //console.log($(this).parent().parent().attr('id'));
    //$(this).attr('class', 'opened');
    //console.log($(this).parent().children());//.children("ul")
});
/*
$("span.opened").on('click','span',function(){//span.opened"
    console.log($(this).parent().parent().attr('id'));
    $(this).parent().children('ul').hide('slow');
    $(this).attr('class', 'closed');
})
*/

});


