$(document).ready(function(){
    $(".show_input").click(function(){
        if($('#'+this.id+'_val').css('display') == 'none'){
            $('#'+this.id+'_val').show();
            $('#'+this.id+'_val').prop('required',true);
        }else{
            $('#'+this.id+'_val').removeAttr('required');
            $('#'+this.id+'_val').hide();
        }
    });
    $(".mainform.hidden").focusout(function(){
        //alert(this.value);
        let values = [];
        $(".mainform.hidden").each(function(){
            if(this.value!=''){
            values.push(this.value);
            }
        });
        let error='';
        values.forEach(function(item, index){
            //console.log('out',item, index);
            values.forEach(function(it, ind){
                if(ind!=index && item==it){
                    error=item;
                }
                
            });
        });
        if(error!=''){
            alert('URL должны отличаться: '+error);
        }
        //console.log(values);
    });
});