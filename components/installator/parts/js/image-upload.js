$(document).ready(function(){
    $('#upload').on('click', function() {
        //console.log($(this).data('path'));
        var path=$(this).data('path');
        //return;
        $('#process').show();
        var file_data = $('#sortpicture').prop('files')[0];   
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        form_data.append('path', path);
        $.ajax({
            url: '/ajax/image-upload.php', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(data){
                data = JSON.parse(data);
                //console.log(data);
                let imgpath=data.file;
                let id=imgpath.replace(/\/|\.| /gi, function (x) {
    return '';
  });
                var image = '<div id="div-'+id+'" class="img-item"><span id="del-'+id+'" class="delete-image">x</span><img src="/uploaded/'+path+'/'+data.file+'" width="120"><input type="hidden" name="images[]" value="/uploaded/'+path+'/'+data.file+'"></div>';
                var photoContent = $("#photo-content");
                //photoContent.html('');
                //sleep(100);
                photoContent.append(image);
                $('#process').hide();
                //console.log(data); // display response from the PHP script, if any
            }
        });
    });
    $('#photo-content').on('click','.delete-image',function(){
    //$('.delete-image').on('click',function(){
        let id=$(this).attr('id');
        id = id.replace("del", "div");
        $( "#"+id ).remove();
        //console.log(id);
    })
});
