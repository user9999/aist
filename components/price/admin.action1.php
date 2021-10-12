<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 

//delete static page
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM ".$PREFIX."catalog_items WHERE id='{$_GET['del']}'");
    header("Location: ?component=price&action=1"); 
}

//edit static page
if (isset($_GET['edit'])) {
    $res = mysql_query("SELECT * ".$PREFIX."FROM catalog_items WHERE id='{$_GET['edit']}'");
    if ($row = mysql_fetch_row($res)) {
        $tbl_oem = $row[1];
        $tbl_name = $row[2];
        $tbl_brand_id = $row[3];
        $tbl_model_id = $row[4];
        $tbl_description = $row[5];
        $tbl_model_variants = $row[6];
        $tbl_oem_variants = $row[7];
        $tbl_available = $row[8];
        $tbl_price = $row[9];
        $tbl_quantity = $row[10];
        $tbl_waitingfor = $row[11];
        $tbl_special = $row[12];
        $tbl_keywords = $row[13];
        $tbl_section = $row[15];
        $tbl_av = $row[16];
        $editid = $row[0];
    }
}

//add new static page
if (isset($_POST['frm_name']) && isset($_POST['frm_oem'])) {
    $query = "";
    foreach ($_POST as $k => $v) {
        $k = preg_replace("/[^a-z0-9_]/", "", $k);
        $v = htmlspecialchars($v);
        if ($k == "frm_price" || $k == "frm_quantity" || $k == "frm_model_id") {
            $v = (float) $v;
        }
        $$k = $v;
        if ($k != 'editid') { $query .= "`" . str_replace("frm_", "", $k) . "` = '$v', ";
        }
    }
    
    //get model id
    $res = mysql_query("SELECT brand_id FROM ".$PREFIX."catalog_models WHERE id = $frm_model_id");
    if ($row = mysql_fetch_row($res)) {
        $query .= ' `brand_id` = ' . $row[0];
    }

    if (strlen($frm_name) >= 2 && strlen($frm_oem) >= 2) {
        if (!$_POST['editid']) {
            mysql_query("INSERT INTO ".$PREFIX."catalog_items SET $query");
            echo "INSERT INTO ".$PREFIX."catalog_items SET $query";
        } else {
            mysql_query("UPDATE ".$PREFIX."catalog_items SET $query WHERE id={$_POST['editid']}");
        }
        header("Location: ?component=price&action=1");
    } else { echo "<br /><br /><b>Ошибка.</b> Минимальная длина названия и OEM - 2 символа";
    }
}
?>

<br /><br />
<h1>Управление позициями прайс-листа</h1>
<form method="post">
    <table width="100%">
        <tr>
            <td width="130">Штрих-код:</td><td><input class="textbox" name="frm_oem" type="text" style="width: 200px;" value="<?php echo $tbl_oem ?>"></td>
        </tr>
        <tr>
            <td width="130">Свой id:</td><td><input class="textbox" name="frm_name" type="text" style="width: 100%;" value="<?php echo $tbl_name ?>"></td>
        </tr>
        <tr>
            <td width="130">Модель:</td><td>
                <select name="frm_model_id">
                    <?php
                    $res = mysql_query("SELECT * FROM ".$PREFIX."catalog_brands ORDER BY name");
                    while ($row = mysql_fetch_row($res)) {
                        echo "<option disabled>{$row[1]}</option>";
                        $res2 = mysql_query("SELECT * FROM ".$PREFIX."catalog_models WHERE brand_id = {$row[0]} ORDER BY name");
                        while ($row2 = mysql_fetch_row($res2)) {
                            echo "<option ";
                            if ($tbl_model_id == $row2[0]) { echo "selected ";
                            }
                            echo "value='{$row2[0]}'>&nbsp; {$row2[2]}</option>";
                        }
                    } 
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="130">Наименование:</td><td><input class="textbox" name="frm_description" type="text" style="width: 100%;" value="<?php echo $tbl_description ?>"></td>
        </tr>
        <tr>
            <td width="130">Модель /варианты/:</td><td><input class="textbox" name="frm_model_variants" type="text" style="width: 300px;" value="<?php echo $tbl_model_variants ?>"></td>
        </tr>
        <tr>
            <td width="130">Штрих-код /варианты/:</td><td><input class="textbox" name="frm_oem_variants" type="text" style="width: 300px;" value="<?php echo $tbl_oem_variants ?>"></td>
        </tr>
        <tr>
            <td width="130">Наличие на складе:</td><td><input class="textbox" name="frm_available" type="text" style="width: 300px;" value="<?php echo $tbl_available ?>"></td>
        </tr>
        <tr>
            <td width="130">Цена, руб:</td><td><input class="textbox" name="frm_price" type="text" style="width: 300px;" value="<?php echo $tbl_price ?>"></td>
        </tr>
        <!--<tr>
            <td width="130">Заказ, шт:</td><td><input class="textbox" name="frm_quantity" type="text" style="width: 300px;" value="<?php echo $tbl_quantity ?>"></td>
        </tr>-->
        <tr>
            <td width="130">Ожидаем товар:</td><td><input class="textbox" name="frm_waitingfor" type="text" style="width: 300px;" value="<?php echo $tbl_waitingfor ?>"></td>
        </tr>
        <tr>
            <td width="130">Акции:</td><td><input class="textbox" name="frm_special" type="text" style="width: 100%;" value="<?php echo $tbl_special ?>"></td>
        </tr>
        <tr>
            <td width="130">Ключевые слова (мета):</td><td><input class="textbox" name="frm_keywords" type="text" style="width: 100%;" value="<?php echo $tbl_keywords ?>"></td>
        </tr>
        <tr>
            <td width="150">Раздел:</td><td>
                <select name="frm_section">
                    <?php 
                    $sections = array("", "Опт", "Розница", "прочее"); 
                    
                    foreach ($sections as $k => $section) {
                        echo "<option ";
                        if ($tbl_section == $k) { echo "selected ";
                        }
                        echo "value='$k'>" . $section . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="150">Наличие:</td><td>
                <select name="frm_av">
                    <?php 
                    $sections = array("В наличии", "Отсутствует", "Под заказ"); 
                    
                    foreach ($sections as $k => $section) {
                        echo "<option ";
                        if ($tbl_av == $k) { echo "selected ";
                        }
                        echo "value='$k'>" . $section . "</option>";
                    }
                    ?>
                </select>
            </td>
        </tr>
        <tr> 
            <td colspan="2" align="right"><input type='hidden' name='editid' value='<?php echo $editid ?>'><input type="submit" class="button" value="Сохранить"></td>
        </tr>
    </table>
</form>
<br />
<br />
<h1>Существующие позиции прайс-листа</h1>
<?php
$res = mysql_query("SELECT * FROM ".$PREFIX."catalog_items");
$num = 0;
while ($row = mysql_fetch_row($res)) {
    $num++;
    echo $row[1] . " - " . $row[2] . " ({$row[5]})" . " <a href='?component=price&action=1&edit={$row[0]}'>[редактировать]</a> <a href='?component=price&action=1&del={$row[0]}'>[удалить]</a><br />";
}
if ($num == 0) { echo "Пожалуйста, сначала добавьте хотя бы один бренд";
}
?>
