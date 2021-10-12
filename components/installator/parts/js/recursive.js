$(function () {
    var tr_id;
    var menu_id;
    $('.form').on('click','#addRow',function(){
        tr_id=$('#form-table tr:last').data("id");
        tr_id++;
        //console.log(tr_id);
        $('#form-table tr:last').after('<tr data-id="'+tr_id+'"><td><span class="close">&#10060;</span><input type="text" name="text['+tr_id+']" value=""></td><td>'+
                '<input  id="type'+tr_id+'" list="types'+tr_id+'" name="type['+tr_id+']" value="">'+
                '<datalist id="types'+tr_id+'">'+
                '<option value="input.text">input.text</option>'+
                '<option value="input.button">input.button</option>'+
                '<option value="input.checkbox">input.checkbox</option>'+
                '<option value="input.color">input.color</option>'+
                '<option value="input.date">input.date</option>'+
                '<option value="input.datetime-local">input.datetime-local</option>'+
                '<option value="input.email">input.email</option>'+
                '<option value="input.file">input.file</option>'+
                '<option value="input.hidden">input.hidden</option>'+
                '<option value="input.image">input.image</option>'+
                '<option value="input.month">input.month</option>'+
                '<option value="input.number">input.number</option>'+
                '<option value="input.password">input.password</option>'+
                '<option value="input.radio">input.radio</option>'+
                '<option value="input.range">input.range</option>'+
                '<option value="input.reset">input.reset</option>'+
                '<option value="input.search">input.search</option>'+
                '<option value="input.submit">input.submit</option>'+
                '<option value="input.tel">input.tel</option>'+
                '<option value="input.time">input.time</option>'+
                '<option value="input.url">input.url</option>'+
                '<option value="input.week">input.week</option>'+
                '<option value="input.datalist">input.datalist</option>'+
                '<option value="select">select</option>'+
                '<option value="select.multiple">select.multiple</option>'+
                '<option value="textarea">textarea</option>'+
                '<option value="button">button</option></datalist></td>'+
    '<td><input type="text" name="name['+tr_id+']" value=""></td>'+
    '<td><input type="text" name="attributes['+tr_id+']" value=""></td>'+
    '<td><input type="text" name="placeholder['+tr_id+']" value=""></td>'+
    '<td><input type="text" name="value['+tr_id+']" value=""></td>'+
    '<td><input type="checkbox" name="required['+tr_id+']" value="required"></td>'+
    '<td><input type="text" name="check_function['+tr_id+']" value=""></td>'+
    '<td><input type="text" name="make_function['+tr_id+']" value=""></td>'+
    '<td><input type="text" name="position['+tr_id+']" value=""></td></tr>');//<tr></tr>
        
    });
    
    
    
    $(".form").on('click','.close', function(){
        //console.log($(this));
        $(this).parent().parent().remove();
    });
    
    $("table.recursive tr").each(function() {
        trclass=$( this ).attr('class');
        n = trclass.indexOf("parent_");
        ws=trclass.substr(n+7);
        $("tr#tr_"+ws+" td:first-child").attr('class','closed');
        tr_id=$( this ).attr('id');
        level=trclass.substr(0, 9);
        if(level!='tr_level0'){
            $( this ).css("display","none");

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
    $("table.recursive tr").bind('click', openclose);
    $("table.recursive tr td.noclick").bind('click',function(event){
        event.stopPropagation();
    });
    
    /*
    let flag = new Map();
    $("table.recursive tr").click(function() {
        tr_id=$( this ).attr('id');
        id=tr_id.replace("tr_", "");
        if(flag.get(id)=='opened'){
             $(this).find("td:first-child").attr('class','closed');//html('opened');
             $( this ).siblings('[class $= "parent_'+id+'"]').each(function(){
                 //console.log($( this ).attr('id'));
                 ntr_id=$( this ).attr('id');
                 nid=ntr_id.replace("tr_", "");
                 console.log(flag.get(nid),nid);
                 if(flag.get(nid)=='opened'){
                     $(this).find("td:first-child").attr('class','closed');
                     $( this ).siblings('[class $= "parent_'+nid+'"]').hide(300);
                     flag.set(nid,'closed');
                 }
             });
             $( this ).siblings('[class $= "parent_'+id+'"]').hide(300);
            flag.set(id,'closed');
        }else{
            $(this).find("td:first-child").attr('class','opened');
            $( this ).siblings('[class $= "parent_'+id+'"]').show(1000);
            flag.set(id,'opened');
        }
        //trclass=$( this ).attr('class');
       // n = trclass.indexOf("parent_");
       // ws=trclass.substr(n+7);
       // if($("tr#tr_"+ws+" td:first-child").attr('class')=='closed'){
            
        //}
    });
     * *
     */
});
     