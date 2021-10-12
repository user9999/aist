$(function () {
$("#resp_menu").click(function(){
    if($("div.adminmenu.recursive").hasClass( "responsive" )===false){
        $(".adminmenu.recursive").addClass( "responsive" );
    }else{
        $(".adminmenu.recursive.responsive").removeClass( "responsive" );
    }
    
});
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
let flag = new Map();
function openclose(){
    //console.log($(this).attr('name'));
    
    if((typeof arguments[0])!=='object'){
        id=arguments[0];
        mythis=arguments[1];
    }else{
        tr_id=$( this ).attr('id');
        id=tr_id.replace("tr_", "");
        mythis=$(this);
    }
    if(flag.get(id)=='opened'){
        mythis.find("td:first-child").attr('class','closed');//html('opened');
        mythis.siblings('[class $= "parent_'+id+'"]').hide(300);
        flag.set(id,'closed');
        mythis.siblings('[class $= "parent_'+id+'"]').each(function(){
             ntr_id=$( this ).attr('id');
             nid=ntr_id.replace("tr_", "");
             if(flag.get(nid)=='opened'){
                 openclose(nid,$(this));
             }
        });
    }else{
        $(this).find("td:first-child").attr('class','opened');
        $( this ).siblings('[class $= "parent_'+id+'"]').show(1000);
        flag.set(id,'opened');
    }

}
});