<?php
//print_r($TEMPLATE);
//var_dump($TEMPLATE);
?>
<h1>Добавление записи</h1>
<form method="post">
        <label for="html"><?=$GLOBALS['dblang_html'][$GLOBALS['DLANG']]?> 
            <textarea id="html" class="forms" type=text name="html" placeholder="<?php echo htmlentities('<div><label for="{name}">{text}</label>{input}</div>')?>"><?=$TEMPLATE['tbl_html']?></textarea></label><br>
        </label>
        <label for="name"><?=$GLOBALS['dblang_name'][$GLOBALS['DLANG']]?>
            <input id="name" class="forms" type=text name="name" value="<?=$TEMPLATE['tbl_name']?>"></label><br>
        <label for="tablename"><?=$GLOBALS['dblang_table'][$GLOBALS['DLANG']]?> 
            <input class="forms" id="tablename" list="tables" name="tablename" value="<?=$TEMPLATE['tbl_tablename']?>">
            <datalist id="tables">
                <?=$TEMPLATE['table_names']?>
            </datalist>
        </label><br>
        <label for="alias"><?=$GLOBALS['dblang_alias'][$GLOBALS['DLANG']]?> <input id="alias" class="forms" type=text name="alias" value="<?=$TEMPLATE['tbl_alias']?>"></label><br>
        <label for="type"><?=$GLOBALS['dblang_enctype'][$GLOBALS['DLANG']]?> 
           <input id="enctype" class="forms" list="enctypes" name="enctype" value="<?=$TEMPLATE['tbl_enctype']?>">
            <datalist id="enctypes">
                <option value=""></option>
                <option value="multipart/form-data"></option>
                <option value="application/x-www-form-urlencoded"></option>
            </datalist> 
            
        </label><br>
        <label for="method"><?=$GLOBALS['dblang_method'][$GLOBALS['DLANG']]?> 
            
            <input id="method" class="forms" list="methods" name="method" value="<?=$TEMPLATE['tbl_method']?>">
            <datalist id="methods">
                <option value="get"></option>
                <option value="post"></option>
            </datalist>
        </label><br>
        <label for="action"><?=$GLOBALS['dblang_action'][$GLOBALS['DLANG']]?> <input id="action" class="forms" type=text name="action" value="<?=$TEMPLATE['tbl_action']?>"></label><br>
        <label for="attributes"><?=$GLOBALS['dblang_attributes'][$GLOBALS['DLANG']]?> <input id="attributes" class="forms" type=text name="attributes" value="<?=$TEMPLATE['tbl_attributes']?>"></label><br>
<input type=submit name="submit" value="Отправить">
<input type='hidden' name='editid' value='<?=TEMPLATE['editid'] ?>'>
</form>

