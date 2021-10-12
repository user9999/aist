<?php
//print_r($TEMPLATE);
?>
<h1><?=$TEMPLATE['form']['name']?></h1>
<!--
<form method="post">
    <label for="form_id"><?=$GLOBALS['dblang_form_id'][$DLANG]?> 
        <input id="form_id" class="forms" type=text name="form_id" value="<?=$tbl_form_id?>">
    </label><br>
    <label for="text"><?=$GLOBALS['dblang_text'][$DLANG]?> 
        <textarea id="text" name="text"><?=$tbl_text?></textarea>
    </label><br>
    <label for="type"><?=$GLOBALS['dblang_type'][$DLANG]?> 
        <input id="type" class="forms" type=text name="type" value="<?=$tbl_type?>">
    </label><br>
    <label for="name"><?=$GLOBALS['dblang_name'][$DLANG]?> 
        <input id="name" class="forms" type=text name="name" value="<?=$tbl_name?>">
    </label><br>
    <label for="attributes"><?=$GLOBALS['dblang_attributes'][$DLANG]?> 
        <input id="attributes" class="forms" type=text name="attributes" value="<?=$tbl_attributes?>">
    </label><br>
    <label for="placeholder"><?=$GLOBALS['dblang_placeholder'][$DLANG]?> 
        <input id="placeholder" class="forms" type=text name="placeholder" value="<?=$tbl_placeholder?>">
    </label><br>
    <label for="value"><?=$GLOBALS['dblang_value'][$DLANG]?> 
        <input id="value" class="forms" type=text name="value" value="<?=$tbl_value?>">
    </label><br>
    <label for="required"><?=$GLOBALS['dblang_required'][$DLANG]?> 
        <input id="required" class="forms" type=text name="required" value="<?=$tbl_required?>">
    </label><br>
    <label for="check_function"><?=$GLOBALS['dblang_check_function'][$DLANG]?> 
        <input id="check_function" class="forms" type=text name="check_function" value="<?=$tbl_check_function?>">
    </label><br>
    <label for="make_function"><?=$GLOBALS['dblang_make_function'][$DLANG]?> 
        <input id="make_function" class="forms" type=text name="make_function" value="<?=$tbl_make_function?>">
    </label><br>
<input type=submit name="submit" value="Отправить">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
-->


<form class="form" method="post">
    <input type='hidden' name='form_id' value='<?=$TEMPLATE['form_id']?>'>
<table id='form-table' class="admin menu form-table table-striped responsive-utilities jambo_table bulk_action">
    <tr class='caption'>
    <td>Надпись</td>
    <td>Тип поля</td>
    <td>Имя переменной<br>(поле в таблице)</td>
    <td>Атрибуты</td>
    <td>Плейсхолдер</td>
    <td>Значение по умолчанию</td>
    <td>required</td>
    <td>Функция проверки поля</td>
    <td>Функция создания поля</td>
    <td>Порядок</td>
</tr>
<?php
$i=0;
   foreach($TEMPLATE['table_fields'] as $field){
?>
<tr data-id="<?=$i?>">
    <td><span class='close'>&#10060;</span><input type='text' name='text[<?=$i?>]' value='<?=$field['text']?>'></td>
    <td>
        <input  id="type<?=$i?>" list="types<?=$i?>" name="type[<?=$i?>]" value="<?=$field['type']?>">
        <datalist id="types<?=$i?>">
        
                <option value="input.text">input.text</option>
                <option value="input.button">input.button</option>
                <option value="input.checkbox">input.checkbox</option>
                <option value="input.color">input.color</option>
                <option value="input.date">input.date</option>
                <option value="input.datetime-local">input.datetime-local</option>
                <option value="input.email">input.email</option>
                <!--<option value="input.file">input.file</option>-->
                <option value="input.hidden">input.hidden</option>
                <option value="input.image">input.image</option>
                <option value="input.month">input.month</option>
                <option value="input.number">input.number</option>
                <option value="input.password">input.password</option>
                <option value="input.radio">input.radio</option>
                <option value="input.range">input.range</option>
                <option value="input.reset">input.reset</option>
                <option value="input.search">input.search</option>
                <option value="input.submit">input.submit</option>
                <option value="input.tel">input.tel</option>
                <option value="input.time">input.time</option>
                <option value="input.url">input.url</option>
                <option value="input.week">input.week</option>
                <option value="input.datalist">input.datalist</option>
                <option value="select">select</option>
                <option value="select.multiple">select.multiple</option>
                <option value="textarea">textarea</option>
                <option value="button">button</option>
        </datalist>
    </td>
    <td>
        <input type='text' name='name[<?=$i?>]' value='<?=$field['name']?>' required>
    </td>
    <td><input type='text' name='attributes[<?=$i?>]' value='<?=htmlentities($field['attributes'],ENT_QUOTES)?>'></td>
    <td><input type='text' name='placeholder[<?=$i?>]' value='<?=$field['placeholder']?>'></td>
    <td><input type='text' name='value[<?=$i?>]' value='<?=$field['value']?>'></td>
    <td><input type='checkbox' name='required[<?=$i?>]' value='required' <?=($field['required']!='')?'checked':'';?>></td>
    <td><input type='text' name='check_function[<?=$i?>]' value='<?=$field['check_function']?>'></td>
    <td><textarea name='make_function[<?=$i?>]'><?=$field['make_function']?></textarea></td>
    <td><input type='text' name='position[<?=$i?>]' value='<?=$field['position']?>'></td>
</tr>
<?php
$i++;
   } 
?>
<tr data-id="<?=$i?>">
    <td><span class='close'>&#10060;</span><input type='text' name='text[<?=$i?>]' value=''></td>
    <td>
    <input  id="type<?=$i?>" list="types<?=$i?>" name="type[<?=$i?>]" value="">
        <datalist id="types<?=$i?>">
                <option value="input.text">input.text</option>
                <option value="input.button">input.button</option>
                <option value="input.checkbox">input.checkbox</option>
                <option value="input.color">input.color</option>
                <option value="input.date">input.date</option>
                <option value="input.datetime-local">input.datetime-local</option>
                <option value="input.email">input.email</option>
                <!--<option value="input.file">input.file</option>-->
                <option value="input.hidden">input.hidden</option>
                <option value="input.image">input.image</option>
                <option value="input.month">input.month</option>
                <option value="input.number">input.number</option>
                <option value="input.password">input.password</option>
                <option value="input.radio">input.radio</option>
                <option value="input.range">input.range</option>
                <option value="input.reset">input.reset</option>
                <option value="input.search">input.search</option>
                <option value="input.submit">input.submit</option>
                <option value="input.tel">input.tel</option>
                <option value="input.time">input.time</option>
                <option value="input.url">input.url</option>
                <option value="input.week">input.week</option>
                <option value="input.datalist">input.datalist</option>
                <option value="select">select</option>
                <option value="select.multiple">select.multiple</option>
                <option value="textarea">textarea</option>
                <option value="button">button</option>
        </datalist>
    </td>
    <td><input type='text' name='name[<?=$i?>]' value=''></td>
    <td><input type='text' name='attributes[<?=$i?>]' value=''></td>
    <td><input type='text' name='placeholder[<?=$i?>]' value=''></td>
    <td><input type='text' name='value[<?=$i?>]' value=''></td>
    <td><input type='checkbox' name='required[<?=$i?>]' value='required'></td>
    <td><input type='text' name='check_function[<?=$i?>]' value=''></td>
    <td><input type='text' name='make_function[<?=$i?>]' value=''></td>
    <td><input type='text' name='position[<?=$i?>]' value=''></td>
</tr>
<tr data-id="<?=($i+1)?>"></tr>
</table>
    <span id="addRow" href="#">Добавить элемент</span>
    <br>
<input type=submit name="submit" value="Отправить">
<input type='hidden' name='editid' value='<?= $editid ?>'>
</form>
<fieldset><legend>Результат для &lt;&lt;<?=$TEMPLATE['form']['name']?>&gt;&gt;</legend>
    <h2>Вызов формы</h2>
    <code> displayForm(<?=$TEMPLATE['form_id']?>);</code><br><br><br>
<?php displayForm($TEMPLATE['form_id'])?>
    <br><h2>HTML-код</h2>
    <textarea class="code">
<?php echo htmlentities(displayForm($TEMPLATE['form_id'],false))?>        
    </textarea>
</fieldset>




