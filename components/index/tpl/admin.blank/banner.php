<div class="x_content">
<form method="post" enctype="multipart/form-data">
<table style="width:560px"><caption>Загрузка изображений к главной странице</caption>
<tr><td>Название или описание изображения</td><td><input name="title" type="text" style="width: 100%;"></td></tr>
<tr><td>Ссылка</td><td><input name="url" type="text" style="width: 100%;"></td></tr>
<tr><td>Выбрать изображение не менее <?php echo $GLOBALS['FRIMG_WIDTH']; ?>x<?php echo $GLOBALS['FRIMG_HEIGHT']; ?></td><td><input class="textbox" name="frm_img" type="file" style="width:220px;"></td></tr>
<tr><td></td><td><input class="button2" type="submit" name="frontpg" value="Отправить"></td></tr>

</table>
</form>
</div>