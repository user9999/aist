$( document ).ready(function() {
    $('#select').on('change', function() {
        if(this.value!='n1_tpl15_folder'){
            $('.template').show();
        }else{
            $('.template').hide();
        }
    });
});


