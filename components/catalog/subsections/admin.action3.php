<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 

//delete static page
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM catalog_items2 WHERE id='{$_GET['del']}'");
    header("Location: ?component=catalog&action=3"); 
}

//edit static page
if (isset($_GET['edit'])) {
    $res = mysql_query("SELECT * FROM catalog_items2 WHERE id='{$_GET['edit']}'");
    if ($row = mysql_fetch_row($res)) {
        $tbl_name = $row[1];
        $tbl_description = $row[2];
        $tbl_characteristics = $row[3];
        $tbl_specification = $row[4];
        $tbl_linked_item = $row[5];
        $tbl_keywords = $row[6];
        $tbl_section = $row[7];
        $tbl_tags = $row[8];
        $editid = $row[0];
    }
}

//add new static page
if (isset($_POST['frm_name']) && isset($_POST['frm_item_id'])) {
    //var_dump($_POST);
    //die();
    $frm_name = htmlspecialchars($_POST['frm_name']);
    $frm_description = mysql_real_escape_string($_POST['frm_description']);//mysql_escape_string
    $frm_characteristics = mysql_real_escape_string($_POST['frm_characteristics']);
    $frm_specification = mysql_real_escape_string($_POST['frm_specification']);
    $frm_linked_item =$_POST['frm_item_id'];// ereg_replace("[^0-9]", "", $_POST['frm_item_id']);
    $frm_keywords = htmlspecialchars($_POST['frm_keywords']);
    $frm_tags = mysql_real_escape_string($_POST['frm_tags']);
    
    if (strlen($frm_name) >= 2 && $frm_linked_item) {
        if (!$_POST['editid']) {
            mysql_query("INSERT INTO catalog_items2 SET name = '$frm_name', description = '$frm_description', characteristics = '$frm_characteristics', specification = '$frm_specification', linked_item = '$frm_linked_item', keywords = '$frm_keywords', alt = '$frm_tags'");
            $id = mysql_insert_id();
        } else {
            mysql_query("UPDATE catalog_items2 SET name = '$frm_name', description = '$frm_description', characteristics = '$frm_characteristics', specification = '$frm_specification', linked_item = '$frm_linked_item', keywords = '$frm_keywords', alt = '$frm_tags' WHERE id={$_POST['editid']}");
            $id = (int) $_POST['editid'];
        }
        
        //add image
        if (isset($_FILES['frm_img']) && $_FILES['frm_img']['error'] == 0) {
            echo 1;
            //check extension
            $type = "";
            if ($_FILES['frm_img']['type'] == 'image/jpeg') {
                $type = "jpeg";
            } elseif ($_FILES['frm_img']['type'] == 'image/png') {
                $type = "png";
            } elseif ($_FILES['frm_img']['type'] == 'image/gif') {
                $type = "gif";
            }
            
            if ($type) {
                //delete everything
                @unlink("uploaded/$id.jpeg");
                @unlink("uploaded/$id.png");
                @unlink("uploaded/$id.gif");
                
                //lets rock
                list($width, $height) = getimagesize($_FILES['frm_img']['tmp_name']);
                
                //check width & height
                /*
                if ($width >= $height) {
                $newwidth = $GLOBALS['IMAGE_MAXSIZE'];
                $newheight = ($newwidth * $height) / $width;
                } else {
                $newheight = $GLOBALS['IMAGE_MAXSIZE'];
                $newwidth = ($newheight * $width) / $height;
                }
                */
                ///////////            
                $x_ratio = $width / $IMAGE_MAXSIZE;
                $y_ratio = $height / $IMAGE_HMAXSIZE;
                if($x_ratio>$y_ratio) {
                        $newheight=floor($height/$x_ratio);//$IMAGE_HMAXSIZE;
                        $newwidth=$IMAGE_MAXSIZE;//$width/$x_ratio;
                        $xcoord=0;
                        $ycoord=floor(($IMAGE_HMAXSIZE-$newheight)/2);

                } else {
                    $newheight=$IMAGE_HMAXSIZE;
                    $newwidth=floor($width/$y_ratio);
                    $xcoord=floor(($IMAGE_MAXSIZE-$newwidth)/2);
                    $ycoord=0;        
                }
                
                
                ////////////////                
                $func = "imagecreatefrom" . $type;
                $source = $func($_FILES['frm_img']['tmp_name']);
                $dest = imagecreatetruecolor($IMAGE_MAXSIZE, $IMAGE_HMAXSIZE);//imagecreatetruecolor($newwidth, $newheight);
                
                          imagefill($dest, 0, 0, $RGB);
                
                imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
    
                ////////////text
                /*
                $str="http://gruz-zap.ru";
                $size = 5; // размер шрифта 
                $x_text = $newwidth-imagefontwidth($size)*strlen($str)-10; 
                $y_text = $newheight-imagefontheight($size)-15; 

                // определяем каким цветом на каком фоне выводить текст 
                $white = imagecolorallocate($dest, 255, 255, 255); 
                $black = imagecolorallocate($dest, 0, 0, 0); 
                $gray = imagecolorallocate($dest, 127, 127, 127); 
                if (imagecolorat($dest,$x_text,$y_text)>$gray) $color = $black; 
                if (imagecolorat($dest,$x_text,$y_text)<$gray) $color = $white; 

                // выводим текст 
                imagestring($dest, $size, $x_text-1, $y_text-1, $str,$white-$color); 
                imagestring($dest, $size, $x_text+1, $y_text+1, $str,$white-$color); 
                imagestring($dest, $size, $x_text+1, $y_text-1, $str,$white-$color); 
                imagestring($dest, $size, $x_text-1, $y_text+1, $str,$white-$color); 

                imagestring($dest, $size, $x_text-1, $y_text,   $str,$white-$color); 
                imagestring($dest, $size, $x_text+1, $y_text,   $str,$white-$color); 
                imagestring($dest, $size, $x_text,   $y_text-1, $str,$white-$color); 
                imagestring($dest, $size, $x_text,   $y_text+1, $str,$white-$color); 
                */
                ///////////    image
                $imerge=imagecreatefromgif('img/vz330.gif');
                imagecopymerge($dest, $imerge, 0, 10, 0, 0, 330, 330, 50);
                /////////////    
    
                
                $func = "image" . $type;
                $func($dest, "uploaded/$id.$type");

                
                //do small img
                //delete everything
                @unlink("uploaded/small_$id.jpeg");
                @unlink("uploaded/small_$id.png");
                @unlink("uploaded/small_$id.gif");
                
                if ($width >= $height) {
                    $newwidth = $GLOBALS['IMAGE2_MAXSIZE'];
                    $newheight = ($newwidth * $height) / $width;
                } else {
                    $newheight = $GLOBALS['IMAGE2_MAXSIZE'];
                    $newwidth = ($newheight * $width) / $height;
                }
                
                $func = "imagecreatefrom" . $type;
                //echo "herecreate";
                //$source = $func($_FILES['frm_img']['tmp_name']);
                $dest = imagecreatetruecolor($newwidth, $newheight);
                imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            
                $func = "image" . $type;
                $func($dest, "uploaded/small_$id.$type");
                
                
                //do big img
                @unlink("uploaded/big_$id.jpeg");
                @unlink("uploaded/big_$id.png");
                @unlink("uploaded/big_$id.gif");
                /*
                if ($width >= $height) {
                    $newwidth = $GLOBALS['IMAGE3_MAXSIZE'];
                    $newheight = ($newwidth * $height) / $width;
                } else {
                    $newheight = $GLOBALS['IMAGE3_MAXSIZE'];
                    $newwidth = ($newheight * $width) / $height;
                }
                */
                
                $x_ratio = $width / $IMAGE3_MAXSIZE;
                $y_ratio = $height / $IMAGE3_HMAXSIZE;
                if($x_ratio>$y_ratio) {
                    $newheight=floor($height/$x_ratio);//$IMAGE_HMAXSIZE;
                    $newwidth=$IMAGE3_MAXSIZE;//$width/$x_ratio;
                    $xcoord=0;
                    $ycoord=floor(($IMAGE3_HMAXSIZE-$newheight)/2);

                } else {
                    $newheight=$IMAGE3_HMAXSIZE;
                    $newwidth=floor($width/$y_ratio);
                    $xcoord=floor(($IMAGE3_MAXSIZE-$newwidth)/2);
                    $ycoord=0;        
                }        
                $func = "imagecreatefrom" . $type;
                //$source = $func($_FILES['frm_img']['tmp_name']);
                $dest = imagecreatetruecolor($IMAGE3_MAXSIZE, $IMAGE3_HMAXSIZE);
                
                imagefill($dest, 0, 0, $RGB);
                                          
                imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
                
                
                $imerge=imagecreatefromgif('img/vz.gif');
                imagecopymerge($dest, $imerge, 0, 0, 0, 0, 600, 600, 50);
                
                $func = "image" . $type;
                $func($dest, "uploaded/big_$id.$type");
                
            }
        }
        
        header("Location: ?component=catalog&action=3");
    } else { echo "<br /><br /><b>Ошибка.</b> Минимальная длина названия - 2 символа";
    }
}
?>
<br /><br />
<h1>Управление позициями каталога</h1>
<form method="post" enctype="multipart/form-data">
    <table width="100%">
        <tr>
            <td width="150">Наименование:</td><td><input class="textbox" name="frm_name" type="text" style="width: 100%;" value="<?php echo $tbl_name ?>"></td>
        </tr>
        <tr>
            <td colspan="2"><br><b>Описание</b><textarea name="frm_description" class="ckeditor" id="editor_ck"><?php echo $tbl_description ?></textarea></td>
        </tr>
        <tr>
            <td colspan="2"><br><b>Характеристики</b> (кратко) на сайте справа<textarea name="frm_characteristics" class="ckeditor" id="editor_ck1"><?php echo $tbl_characteristics ?></textarea></td>
        </tr>
        <tr>
            <td colspan="2"><br><b>Характеристики</b> (подробно) на сайте по центру<textarea name="frm_specification" class="ckeditor" id="editor_ck2"><?php echo $tbl_specification ?></textarea></td>
        </tr>
        <tr>
            <td width="150"><b>Связано с:</b></td>
            <td>
                <select name="frm_item_id">
                    <option></option>
                    <?php
                    $model = "";
                    $brand = "";
                    $res = mysql_query(
                        "SELECT a.id, a.oem, a.name, a.description, b.name AS bname, c.name AS mname 
					FROM catalog_items AS a, catalog_sections AS b, catalog_subsections AS c
					WHERE a.subsection_id = c.id AND a.section_id = b.id ORDER BY b.name, c.name"
                    );
                    while ($row = mysql_fetch_row($res)) {
                        if ($brand != $row[4]) {
                            $brand = $row[4];
                            echo "<option disabled style='background-color:#444; color:#fff;'>$brand</option>";
                        }
                        
                        if ($model != $row[5]) {
                            $model = $row[5];
                            echo "<option disabled style='background-color:#777; color:#fff;'>&nbsp; $model</option>";
                            
                        }
                        echo "<option ";
                        if ($tbl_linked_item == $row[2]) { echo "selected ";
                        }
                        echo "value='{$row[2]}'>&nbsp; &nbsp; " . $row[1] . " - " . $row[2] . " ({$row[3]})" . "</option>";
                    } 
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td width="150">Изображение:</td><td><input class="textbox" name="frm_img" type="file" style="width: 100%;">
            <?php
            if ($editid) {
                $fl = "";
                if (file_exists("uploaded/$editid.jpeg")) { $fl = "uploaded/$editid.jpeg";
                }
                if (file_exists("uploaded/$editid.png")) { $fl = "uploaded/$editid.png";
                }
                if (file_exists("uploaded/$editid.gif")) { $fl = "uploaded/$editid.gif";
                }
                    
                if ($fl) {
                    echo "Изображение уже добавлено (<a target='_blank' href='" . $GLOBALS['PATH'] . "/$fl'>просмотреть</a>), но вы можете выбрать новое для замены.";
                }
            }
            ?>
            Обратите внимание! Возможные форматы изображений - JPG, GIF, PNG.
            </td>
        </tr>
        <tr>
            <td width="150">Доп. атрибуты (*):</td><td><textarea style="width:400px; height: 30px;" name="frm_tags"><?php echo $tbl_tags ?></textarea></td>
        </tr>
        <tr>
            <td width="150">Ключевые слова (мета):</td><td><input class="textbox" name="frm_keywords" type="text" style="width: 100%;" value="<?php echo $tbl_keywords ?>"></td>
        </tr>
        <tr> 
            <td colspan="2" align="right"><input type='hidden' name='editid' value='<?php echo $editid ?>'><input type="submit" class="button" value="Сохранить"></td>
        </tr>
    </table>
</form>
* - дополнительные атрибуты - строка, в которой вы самостоятельно формируете
    атрибуты для изображения, например <i>alt="text" width="250"</i>
<br />
<br />
<br />
<h1>Существующие позиции каталога</h1>
<?php
$res = mysql_query("SELECT * FROM catalog_items2");
//$res = mysql_query("SELECT a.id,a.name,a.model,a.description,b.name FROM catalog_items2 as a,catalog_brands as b where a.brand_id=b.id");
$num = 0;
while ($row = mysql_fetch_row($res)) {
    $num++;
    echo $row[5]." - ".$row[1] . " <a href='?component=catalog&action=3&edit={$row[0]}'>[редактировать]</a> <a href='?component=catalog&action=3&del={$row[0]}'>[удалить]</a><br />";
}
if ($num == 0) { echo "Пожалуйста, сначала добавьте хотя бы одну позицию";
}
?>
