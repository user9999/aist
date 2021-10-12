<h1>Редактор изображений</h1>
Данный редактор позволяет управлять изображениями на сайте, помимо изображений каталога. 
Управление изображениями каталога осуществляется непосредственно через каталог.
<br />
<br />
<form method="post">
	<select name="frm_select">
		<?php
		foreach ($arr as $v) {
			?>
			<option <?php if ($path == $v) echo "selected"; ?> value='<?= $v ?>'><?= $v ?></option>
			<?php
		}
		?>
	</select> <input type="submit" value="Открыть изображение" />
</form>

<form method="post" enctype="multipart/form-data">
	<img style="border:1px solid #777;" src="../<?= $path ?>" /><br />
	<br />
	Изображение для замены:<br />
	<input type="file" name="frm_imagereplace" /><br />
	<br />
	Дополнительные атрибуты (*):<br />
	<textarea style="width:400px; height: 30px;" name="frm_tags"><?= $tags ?></textarea><br />
	<input type="submit" value="Сохранить" /> <input type="hidden" name="frm_path" value="<?= $path ?>"<br />
	<br />
	* - дополнительные атрибуты - строка, в которой вы самостоятельно формируете
	атрибуты для изображения, например <i>alt="text" width="250"</i>
</form>
