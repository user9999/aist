<h1>Редактор шаблонов</h1>
Данный редактор позволяет управлять исходным кодом шаблонов 
и связанных с ними файлами.
<br />
<br />
<form method="post">
	<select name="frm_select">
		<?php
		foreach ($arr as $v) {
			$k = explode(" ", $v);
			$key = $k[0];
			?>
			<option <?php if ($path == $key) echo "selected"; ?> value='<?= $key ?>'><?= $v ?></option>
			<?php
		}
		?>
	</select> <input type="submit" value="Открыть файл для редактирования" />
</form>

<form method="post">
	<textarea name="frm_text" style="width: 100%; height: 600px;"><?= $fcontents ?></textarea>
	<input type="submit" value="Сохранить файл" /> <input type="hidden" name="frm_path" value="<?= $path ?>" />
</form>
