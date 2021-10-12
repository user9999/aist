    <link href="modules/upload/css/style_upload.css" rel="stylesheet" />
    <!--<script type="text/javascript" src="modules/upload/js/jquery.min.js"></script>-->
<?php
$suff=explode('#', strtolower($specCase));
?>
<div style="width:50%;float:left;padding:10px;">
<form id="upload" method="post" action="modules/upload/uploadFiles.php" enctype="multipart/form-data">
<input type="hidden" name="specCase" id="specCase" value="<?=$specCase;?>" />
<!--       <div id="drop">
			  Перетащите сюда файл<br><a>Обзор</a> 
				<input type="file" name="upl" multiple />
				<label for="input__file">Добавить</label>
<!-- 			</div> -->

<div class="field__wrapper">
   <input type="file" name="upl" id="upl" class="field field__file" multiple>
   <label class="field__file-wrapper" for="upl">
     <div class="field__file-fake">Файл не выбран</div>
     <div class="field__file-button">Выбрать</div>
   </label>
</div>

<ul>
	<!-- The file uploads will be shown here -->
</ul>
</form>
</div>
<div style="width:50%;float:left;padding:10px;">
<?php
  $prPrint='<div id="insGalAjax'.$suff[2].'">';
  $files = scandir($_SERVER['DOCUMENT_ROOT'].'/uploaded/'.$way);

  foreach ($files as $value) {
      $delImg = '<font style="float:left;">x</font>';
      if ($value != '.' && $value != '..') {
          $prPrint.='<img alt="" src="uploaded/'.$way.'/'.$value.'" alt="" title="" style="float:left;width:50px;">'.$delImg;
      }
  }

$prPrint.='<div style="clear:both;"></div>';
echo $prPrint;
?>
</div>




    <script src="modules/upload/js/jquery.knob.js"></script>
    <script src="modules/upload/js/jquery.ui.widget.js"></script>
    <script src="modules/upload/js/jquery.iframe-transport.js"></script>
    <script src="modules/upload/js/jquery.fileupload.js"></script>
    <script>site=1;</script>
    <script src="modules/upload/js/script.js"></script>
