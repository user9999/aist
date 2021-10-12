<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
//delete static page



$num = 0;

if (isset($_GET['del'])) {
    mysql_query("DELETE FROM catalog_sections WHERE id='{$_GET['del']}'");
    header("Location: ?component=catalog"); 
}
$tbl_showmenu = 1;
//edit static page
if (isset($_GET['edit'])) {
    $res = mysql_query("SELECT * FROM catalog_sections WHERE id='{$_GET['edit']}'");
    if ($row = mysql_fetch_row($res)) {
        $tbl_name = $row[1];
        $tbl_altname = $row[2];

        $tbl_parent=$row[4];
        $tbl_keywords=$row[5];
        $tbl_description=$row[6];
        $tbl_info=$row[7];
        
        $tbl_showmenu = $row[8];
        $tbl_position = $row[9];
        $editid = $row[0];
    }
}
//add new static page
if (isset($_POST['frm_name'])) {

    $frm_name=$_POST["frm_name"];
    $frm_parent=$_POST['frm_parent'];

    $frm_altname=$_POST['frm_altname'];
    $frm_keywords=$_POST['frm_keywords'];
    $frm_description=$_POST['frm_description'];
    $frm_info=$_POST['frm_info'];
    $frm_position=$_POST['frm_position'];
    $frm_showmenu=($_POST['frm_catalog'])?$_POST['frm_catalog']:1;
    //$frm_parent=($frm_showmenu==2)?$_POST['frm_parent2']:$frm_parent;
    $qimage="";
    if($_FILES['frm_image']['error'] == 0) {
        //var_dump($_FILES['frm_image']);
        //die();
    
    
    
    
    
        $MODEL_MAXWIDTH=170;
        $MODEL_MAXHEIGHT=170;
        $type=preg_match("!\.jpe?g$!is", $_FILES['frm_image']['name'], $match)?"jpeg":"";
        $type=preg_match("!\.gif$!is", $_FILES['frm_image']['name'], $match)?"gif":$type;
        $type=preg_match("!\.png$!is", $_FILES['frm_image']['name'], $match)?"png":$type;
        
        $ext=preg_match("!\.jpe?g$!is", $_FILES['frm_image']['name'], $match)?"jpg":"";
        $ext=preg_match("!\.gif$!is", $_FILES['frm_image']['name'], $match)?"gif":$ext;
        $ext=preg_match("!\.png$!is", $_FILES['frm_image']['name'], $match)?"png":$ext;

        //var_dump($_FILES["tmp_name"]);
        move_uploaded_file($_FILES['frm_image']['tmp_name'], $HOSTPATH."/uploaded/menu/tmp/".$frm_altname.".".$ext);
        list($width, $height) = getimagesize($HOSTPATH."/uploaded/menu/tmp/".$frm_altname.".".$ext);
        //echo $width."<br>";echo $height."<br>";
        $x_ratio = $width / $MODEL_MAXWIDTH;
        $y_ratio = $height / $MODEL_MAXHEIGHT;
        //echo $x_ratio."<br>";echo $y_ratio."<br>";    
        if($x_ratio>$y_ratio) {
            $newheight=floor($height/$x_ratio);//$IMAGE_HMAXSIZE;
            $newwidth=$MODEL_MAXWIDTH;
        } else {
            $newheight=$MODEL_MAXHEIGHT;
            $newwidth=floor($width/$y_ratio);
        }
        //echo $newwidth."<br>";echo $newheight."<br>";        
        //die();
        

        $func = "imagecreatefrom" . $type;
        //$func = "imagecreatefrom" . $type;
        $source = $func($HOSTPATH."/uploaded/menu/tmp/".$frm_altname.".".$ext);
        $dest = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        $func = "image" . $type;
        $func($dest, $HOSTPATH."/uploaded/menu/".$frm_altname.".".$ext);        

        @unlink($HOSTPATH."/uploaded/menu/tmp/".$frm_altname.".".$ext);
            
        //move_uploaded_file($_FILES['frm_image']['tmp_name'], $HOSTPATH."/uploaded/menu/".$frm_altname.".".$ext);
        $qimage=",img='/uploaded/menu/".$frm_altname.".".$ext."'";
        
        
        
    }
    if($frm_parent==0) {
        $level=1;
    } else {
        $res=mysql_query("select level from catalog_sections where id=".$frm_parent." limit 1");
        $row = mysql_fetch_row($res);
        $parent_level=$row[0];
        $level=$parent_level+1;
    }

    //if ($_POST['frm_showmenu']) $frm_showmenu = 1;
    
    if (strlen($frm_name) >= 3) {

        if (!$_POST['editid']) {
            //var_dump();
            //die("!!!!!!!!!!!edit");
            mysql_query("INSERT INTO catalog_sections SET name='$frm_name',altname='$frm_altname',level=$level,parent=$frm_parent, keywords='$frm_keywords',description='$frm_keywords',info='$frm_info',showmenu='$frm_showmenu',position='$frm_position'".$qimage);
        } else {
            mysql_query("UPDATE catalog_sections SET name='$frm_name',altname='$frm_altname',level=$level,parent=$frm_parent, keywords='$frm_keywords',description='$frm_keywords',info='$frm_info',showmenu='$frm_showmenu',position='$frm_position'".$qimage." WHERE id={$_POST['editid']}");
            //echo  "UPDATE catalog_sections SET name='$frm_name',altname='$frm_altname',level=$level,parent=$frm_parent, keywords='$frm_keywords',description='$frm_keywords',info='$frm_info',showmenu='$frm_showmenu',position='$frm_position'".$qimage." WHERE id={$_POST['editid']}";
            //die();
        }
        header("Location: ?component=catalog");
    } else { echo "<b>Ошибка.</b> Минимальная длина названия - 3 символа";
    }
}


/////////////////////
$sections=array();
///1
$res = mysql_query("SELECT MAX(level) FROM catalog_sections where showmenu=1");
$row=mysql_fetch_row($res);
if($row[0]!==null) {//mysql_num_rows($res)>0
    //$row=mysql_fetch_row($res);
    $max=$row[0];
    //echo $max."---";
    $t="";
    for($i=1;$i<=$max;$i++){
        $t.="t$i.level AS level$i,t$i.id AS id$i,t$i.name AS name$i,t$i.altname AS alias$i,";
        if($i>1) {
            $join.=" LEFT JOIN catalog_sections AS t$i ON t$i.parent = t".($i-1).".id";
        }
    }
    $t=substr($t, 0, -1);
    $query="SELECT ".$t." FROM catalog_sections as t1".$join." where t1.parent=0 and t1.showmenu=1";
    $res = mysql_query($query);
    //echo $query."<br>";
    //$cols=4;
    $options='';
    $ar=array();
    while($row=mysql_fetch_row($res)){
        $str="---";$val1='';
        if($row[0]==1) {
            foreach($row as $num=>$val){
        
                if($val==null) {
                    break;
                }

                if($num%4==0) {
                    $otst=str_repeat($str, $val);
                    $level=$val;
                }
                if($num%4==1) {
                    $flag=0;
                    if(!in_array($val, $ar)) {
                         $selected=($val==$tbl_parent)?"selected":"";
                         $options.="<option class=level$level value=$val $selected>";
                         $link="<a href='?component=catalog&action=1&edit=$val'>[редактировать]</a> <a href='?component=catalog&action=1&del=$val'>[удалить]</a>";
                         $ar[]=$val;
                         $flag=1;
                    }
                }
                if($num%4==2) {
                    if($flag==1) {
                        $options.=$otst.$val."</option>\n";
                        $title=mb_substr($val, 0, 40, 'UTF-8')."..";//$val;//
                    }
                }
                if($num%4==3) {
                    $val1.=$val."/";
                    if($flag==1) {
                        //$val1.=$val."/";
                        $valr=substr($val1, 0, -1);
                        $sections[1].="<div class=clear><div class='sec_title'>".$otst.$title. "</div> <div class='alias'>" .$val. "</div><div class='priceid'>$valr</div><div class=links>".$link."</div></div>";
                        //$val1=$val."/";
                        //$val1='';
                    } else {
                        //$val1.=$val."/";
                    }
                }

            }
            //echo count($row)."<br>";
        }
        //$id1=$row[1];
    }
}
//2
/*
$res = mysql_query("SELECT MAX(level) FROM catalog_sections where showmenu=2");
$row=mysql_fetch_row($res);
if($row[0]!==NULL){
//$row=mysql_fetch_row($res);
$max=($row[0])?$row[0]:1;
//echo $max."---";
$t="";$join='';
for($i=1;$i<=$max;$i++){
    $t.="t$i.level AS level$i,t$i.id AS id$i,t$i.name AS name$i,t$i.altname AS alias$i,";
    if($i>1){
        $join.=" LEFT JOIN catalog_sections AS t$i ON t$i.parent = t".($i-1).".id";
    }
}
$t=substr($t,0,-1);
$query="SELECT ".$t." FROM catalog_sections as t1".$join." where t1.parent=0 and t1.showmenu=2";
$res = mysql_query($query);
//echo $query;
//$cols=4;
$options2='';

while($row=mysql_fetch_row($res)){
    $str="---";
    if($row[0]==1){
        foreach($row as $num=>$val){
            if($val==NULL){
                break;
            }

            if($num%4==0){
                $otst=str_repeat($str, $val);
                $level=$val;
            }
            if($num%4==1){
                $flag=0;
                if(!in_array($val,$ar)){
                    $selected=($val==$tbl_parent)?"selected":"";
                    $options2.="<option class=level$level value=$val $selected>";
                    $link="<a href='?component=catalog&action=6&edit=$val'>[редактировать]</a> <a href='?component=catalog&action=6&del=$val'>[удалить]</a>";
                    $ar[]=$val;
                    $flag=1;
                }
            }
            if($num%4==2){
                if($flag==1){
                    $options2.=$otst.$val."</option>\n";
                    $title=mb_substr($val,0,40,'UTF-8')."..";//$val;
                }
            }
            if($num%4==3){
                if($flag==1){
                    $sections[2].=$otst.$title. " (алиас - " .$val. ")".$link."<br />";
                }
            }

        }
        //echo count($row)."<br>";
    }
    //$id1=$row[1];
}
}
//2 end
*/
//$row[1] . " (в каталоге - " . $row[2] . ")"    . " <a href='?component=catalog&action=6&edit={$row[0]}'>[редактировать]</a> <a href='?component=catalog&action=6&del={$row[0]}'>[удалить]</a><br />";

/*
SELECT t1.name AS lev1, t2.name as lev2, t3.name as lev3, t4.name as lev4
FROM category AS t1
LEFT JOIN category AS t2 ON t2.parent = t1.category_id
LEFT JOIN category AS t3 ON t3.parent = t2.category_id
LEFT JOIN category AS t4 ON t4.parent = t3.category_id
WHERE t1.name = 'ELECTRONICS';
*/
//echo $query;
//die();

if($tbl_showmenu==1) {
    $catalog2="<option value=2>Каталог 2 (Продукция)</option>
<option value=1 selected>Каталог 1</option>";
} else {
    $catalog2="<option value=2 selected>Каталог 2 (Продукция)</option>
<option value=1>Каталог 1</option>";
}

?>
<br><br>
<h1>Управление разделами каталога</h1>
<form method="post" enctype="multipart/form-data">
<table width="100%">
<tr>
<td width="130"><b>Родитель:</b></td><td>
<!--
<select name=frm_catalog>
<?php echo $catalog2;?>

</select>
-->
<select name=frm_parent>
<option value=0>корень</option>
<?php echo $options; ?>
</select>
<!--
<select name=frm_parent2>
<option value=0>корень</option>
<?php echo $options2; ?>
</select>
-->

</td>
</tr>
<tr>
<td width="130"><b>Название:</b></td><td><input class="textbox" name="frm_name" type="text" style="width: 100%;" value="<?php echo $tbl_name ?>" required></td>
</tr>
<tr>
<td><b>Алиас:</b></td><td><input class="textbox" name="frm_altname" type="text" style="width: 100%;" value="<?php echo $tbl_altname ?>" required></td>
</tr>
<tr>
<td><b>Ключевые:</b></td><td><input class="textbox" name="frm_keywords" type="text" style="width: 100%;" value="<?php echo $tbl_keywords ?>"></td>
</tr>
<tr>
<td><b>Описание (description):</b></td><td><input class="textbox" name="frm_description" type="text" style="width: 100%;" value="<?php echo $tbl_description ?>"></td>
</tr>
<tr>
<td><b>Изображение:</b></td><td><input name="frm_image" type="file"></td>
</tr>
        <tr>
            <td colspan="2"><textarea name="frm_info" class="ckeditor" id="editor_ck"><?php echo $tbl_info ?></textarea></td>
        </tr>
<tr>
<td><b>Порядок:</b></td><td><input class="textbox" name="frm_position" type="text" style="width: 10%;" value="<?php echo $tbl_position ?>"></td>
</tr>
<tr>
<td>Показывать в меню:</td><td><input type="checkbox" name="frm_showmenu" <?php if ($tbl_showmenu) { echo "checked";
                                                                          } ?>></td>
</tr>
<tr> 
<td colspan="2" align="right"><input type='hidden' name='editid' value='<?php echo $editid ?>'><input type="submit" class="button" value="Сохранить"></td>
</tr>
</table>
    <script type="text/javascript">//<![CDATA[
    window.CKEDITOR_BASEPATH='inc/ckeditor/';
    //]]></script>
    <script type="text/javascript" src="inc/ckeditor/ckeditor.js?t=B1GG4Z6"></script>
    <script type="text/javascript">//<![CDATA[
    CKEDITOR.replace('editor_ck', { "filebrowserBrowseUrl": "\/inc\/ckfinder\/ckfinder.html", "filebrowserImageBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Images", "filebrowserFlashBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Flash", "filebrowserUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files", "filebrowserImageUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images", "filebrowserFlashUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash" });
    //]]></script>
</form>
<!--
Обратите внимание на следующие особенности - альтернативное название не является обязательным, но если оно задано, то используется для отображения в каталоге. Обычное же название (полученное из прайс-листа в формате CSV) используется для синхронизации БД и CSV, а также для формирования ссылок.
-->
<br>
<br>
<div style='width:100%;float:left'>
<h1>Существующие разделы 1</h1>
<?php

if ($sections[1] == '') {
    echo "Разделы не добавлены";
} else {
    echo "<div class='clear stitle'><div class='sec_title'>Название</div> <div class='alias'>Алиас</div><div class='priceid'>ID раздела</div><div class=links>Действия</div></div>";
    echo $sections[1];
}
?>
</div>
<!--
<div style='width:49%;float:left'>
<h1>Существующие разделы 2 (продукция)</h1>
<?php

if ($sections[2] == '') {
    echo "Разделы не добавлены";
} else {
    echo $sections[2];
}
?>
</div>-->
<script>
$( document ).ready(function() {
    $( ".clear" ).mouseover(function() {
        $(this).css('background-color', '#ccc');
    });
    $( ".clear" ).mouseout(function() {
        $(this).css('background-color', '#fff');
    });
});

</script>
