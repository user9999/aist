$( document ).ready(function() {
   $('.required').on('focus',function(){
       let ids=new Array();
       $(this).removeClass('error');
   });
   $('input[type="submit"]').on('click',function(){
       var vals='';
       let ids=new Array();
       var id=$(this).attr('id');
       console.log("form#form_"+id+" .required");
       $.each($("form#form_"+id+" .required"), function (index, value) {
           //console.log($(this).attr('id'));
            if(!$(this).val()){
               vals += 'false';
               ids.push($(this).attr('id'));
            }
        });
        event.preventDefault();
        if(vals==''){
            $.ajax({
                type: "POST",
                url: "/ajax/request.php",
                data: $('form#form_'+id).serialize(),
                success: function(data){
                    $("#"+id+"_result").html(data);
                    console.log("result",data );
                },
                error: function(){
                    alert("failure");
                }
            });
        }else{
            console.log(ids);
            $.each($("form#form_"+id+" .required"), function (index, value) {
                if(ids.indexOf($(this).val()!==false)){
                    $(this).addClass('error');
                }
            });
            $("form#form_"+id+" .modal_result").html('Заполните Все необходимые поля!');
        }
   });
});