//alert(site);
arr = $('#specCase').val().split('#');
gutFiles = arr[0];
wayFile = arr[1];
divSuff = arr[2];

$(function(){

    var ul = $('#upload ul');

    $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

	var fAdd = 0, fProg = 0; 
    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({

        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {


            // Выводим сообщение о допустимых типах файлов
            /// Проверка на расширение файла ////
            ext='';
            parts = data.files[0]['name'].split('.');
            if (parts.length > 1) ext = parts.pop();

            if(gutFiles.toUpperCase().indexOf(ext.toUpperCase()) == -1){
                alert('Можно загрузить только файлы с расширениями: '+gutFiles.toUpperCase());  
                return;            
            }

            // Проверка на Объём файла
            if(data.files[0]['size']>4010000) {
            //alert("Объём Файла не должен превышать 1 Мб."); return; 
            alert('Объём Файла не должен превышать 4 Мб.'); 
  
                return;       
            }
fAdd++;  
            // Выводим сообщение о проверке заполненности формы

            
            var tpl = $('<li class="working"><input type="text" value="0" data-width="48" data-height="48"'+
                ' data-fgColor="#0788a5" data-readOnly="1" data-bgColor="#3e4043" /><p></p><span></span></li>');

            // Append the file name and file size
            tpl.find('p').text(data.files[0].name)
                         .append('<i>' + formatFileSize(data.files[0].size) + '</i>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Initialize the knob plugin
            tpl.find('input').knob();

            // Listen for clicks on the cancel icon
            tpl.find('span').click(function(){

                if(tpl.hasClass('working')){
                    jqXHR.abort();
                }

                tpl.fadeOut(function(){
                    tpl.remove();
                });

            });

            // Automatically upload the file once it is added to the queue
            //var jqXHR = data.submit();     
            
            
            var jqXHR = data.submit().success(function(result, textStatus, jqXHR) {
                var json = JSON.parse(result);
                var status = json['status'];
                  //if (status == 'success') alert(JSON.parse(result)+' -- '+textStatus+' -- '+jqXHR);
                if (status == 'error') {
                    data.context.addClass('error');
                }
             
                setTimeout(function() {
                    //data.context.fadeOut('slow');
                }, 500); //2000
            });      
            
            },
            
        progress: function(e, data){

            // Calculate the completion percentage of the upload
            var progress = parseInt(data.loaded / data.total * 100, 10);

            // Update the hidden input field and trigger a change
            // so that the jQuery knob plugin knows to update the dial
            data.context.find('input').val(progress).change();

            if(progress == 100){
                fProg++;
                
                if(fAdd == fProg){
                  
                  setTimeout(function() { 
                    //alert('Файлы успешно загружены');
                    if(!site || site==0) window.location.reload(); 
                    if(site==1){
                      alert('Успешно загружено!');
                      viewGalereyaInsert(wayFile,divSuff);
                    }
                  }, 500);

                }
                  
			         	//fAdd == fProg && window.location.reload();
                data.context.removeClass('working');
            }
        },

        fail:function(e, data){
            // Something has gone wrong!
            fAdd--;
            data.context.addClass('error');
        }

    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }

});




function viewGalereyaInsert(way,divSuff){
/*  $.ajax({
      type: "POST",
      url: "modules/upload/ajax-view-galereya.php",
      data: "&way=" + way,
      success : function(text){
          if (text == "success"){
              $('#insGalAjax').html(response);
          } else {
              //showErrorToast(text);
          }
        }
  });
*/




  try {
    lsXmlHttp=new XMLHttpRequest();
  } catch (e) {
    try { lsXmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    } catch (e) {
      try { lsXmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
      } catch (e) {
        alert("Your browser does not support AJAX!");
        return false;
      }
    }
  }
  lsXmlHttp.onreadystatechange=function() {
    var response;
    if(lsXmlHttp.readyState==1){
      //showErrorToast('Удаление группы сообщений');
    }
    if(lsXmlHttp.readyState==4){
      clearTimeout(timeout1);
      clearTimeout(timeout2);
    
      var timeout1 = setTimeout(function(){
        response = lsXmlHttp.responseText;
      },500);

      var timeout2 = setTimeout(function(){
       if(response){
          $('#insGalAjax'+divSuff).html(response);
        } else {
          window.location.reload(); 
        }
      },500);
    }
  }
  lsXmlHttp.open("GET","modules/upload/ajax-view-galereya.php?way="+way, true); 
  lsXmlHttp.send(null);
}



let fields = document.querySelectorAll('.field__file');
Array.prototype.forEach.call(fields, function (input) {
  let label = input.nextElementSibling,
    labelVal = label.querySelector('.field__file-fake').innerText;

  input.addEventListener('change', function (e) {
    let countFiles = '';
    if (this.files && this.files.length >= 1)
      countFiles = this.files.length;

    if (countFiles)
      label.querySelector('.field__file-fake').innerText = 'Выбрано файлов: ' + countFiles;
    else
      label.querySelector('.field__file-fake').innerText = labelVal;
  });
});






















