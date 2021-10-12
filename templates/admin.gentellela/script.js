$(function () {
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
    
    let flag = new Map();
    function openclose(){
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
     