var stime= new Date;
var dump;
$( document ).ready(function() {

   /*
    page=$(".mainbody").html();
    html =  $.parseHTML(page),
    nodeNames = [];
    //console.log(html);
    $.each( html, function( i, el ) {
        //$(this).css({'display':'none'});
        //console.log($(this));
        nodeNames[ i ] = el.nodeName;
        if(el.nodeName!='#text'){
            
        }
    });
    */
    //console.log(nodeNames);//JSON.stringify(sections)
    var etime = new Date;
    loadtime=etime-stime;
    dout='';
    if(dump){
        dump=dump.replace(":[","<br>dumps=[");
        dout="<br>file="+dump;
    }
    mobile="<a href='/?mobile=1'>Мобильная версия</a>";
    $('body').append('<div class="wrapper"><div class="footer"><div class="panel">Время загрузки: '+loadtime+'ms; '+mobile+' '+dout+' </div></div></div>');
    
});

