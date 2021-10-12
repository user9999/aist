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

