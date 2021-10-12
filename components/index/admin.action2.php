<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
?>

<?php
if($_POST['frontpg']??'') {
    $imgname='';$type='';
    $img='';
    if (isset($_FILES['frm_img']) && $_FILES['frm_img']['error'] == 0) {
        //check extension
        $type = "";
        if ($_FILES['frm_img']['type'] == 'image/jpeg' || $_FILES['frm_img']['type'] == 'image/pjpeg') {
            $type = "jpeg";
        } elseif ($_FILES['frm_img']['type'] == 'image/png') {
            $type = "png";
        } elseif ($_FILES['frm_img']['type'] == 'image/gif') {
            $type = "gif";
        }
        if ($type) {
            //lets rock
            list($width, $height) = getimagesize($_FILES['frm_img']['tmp_name']);
        
            $x_ratio = $width / $LINKIMG_WIDTH;
            $y_ratio = $height / $LINKIMG_HEIGHT;
            if($x_ratio>$y_ratio) {
                $newheight=floor($height/$x_ratio);
                $newwidth=$LINKIMG_WIDTH;
                $xcoord=0;
                $ycoord=floor(($LINKIMG_HEIGHT-$newheight)/2);
            } else {
                $newheight=$LINKIMG_HEIGHT;
                $newwidth=floor($width/$y_ratio);
                $xcoord=floor(($LINKIMG_WIDTH-$newwidth)/2);
                $ycoord=0;        
            }
                
            $func = "imagecreatefrom" . $type;
            $source = $func($_FILES['frm_img']['tmp_name']);
            $dest = imagecreatetruecolor($LINKIMG_WIDTH, $LINKIMG_HEIGHT);
            imagefill($dest, 0, 0, $FRGB);
            imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
            $imgname=time();
            $func = "image" . $type;
            $func($dest, "uploaded/front/$imgname.$type");

                
            /////////////////small

            $x_ratio = $width / $FRIMG2_WIDTH;
            $y_ratio = $height / $FRIMG2_HEIGHT;
            if($x_ratio>$y_ratio) {
                $newheight=floor($height/$x_ratio);
                $newwidth=$FRIMG2_WIDTH;
                $xcoord=0;
                $ycoord=floor(($FRIMG2_HEIGHT-$newheight)/2);
            } else {
                $newheight=$FRIMG2_HEIGHT;
                $newwidth=floor($width/$y_ratio);
                $xcoord=floor(($FRIMG2_WIDTH-$newwidth)/2);
                $ycoord=0;        
            }
                
            $func = "imagecreatefrom" . $type;
            $dest = imagecreatetruecolor($FRIMG2_WIDTH, $FRIMG2_HEIGHT);
            imagefill($dest, 0, 0, $FRGB);
            imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
            $func = "image" . $type;
            $func($dest, "uploaded/front/small_$imgname.$type");
        }
        $img=$imgname.".".$type;
    }
    
    $title=($_POST['title'])?mysql_real_escape_string($_POST['title']):"";
    $description=($_POST['description'])?mysql_real_escape_string($_POST['description']):"";
    $section=($_POST['section']=='action')?'action':"new";
    mysql_query("INSERT INTO ".$PREFIX."frontpage SET name='$img', title='".$title."',url='".$_POST['url']."',description='".$description."',type='".$_POST['type']."',section='".$section."'");echo mysql_error();
    //mydump("INSERT INTO frontpage SET name='$imgname.$type', title='".$title."',url='".$_POST['url']."',description='".$description."',type='".$_POST['type']."'");



}
if($_POST['del']??'') {
    $res=mysql_query('select name from '.$PREFIX.'frontpage where id='.$_POST['del']);
    $row=mysql_fetch_row($res);
    mysql_query("delete from ".$PREFIX."frontpage where id=".$_POST['del']);
    if(file_exists($HOSTPATH."/uploaded/front/".$row[0])) {
        unlink($HOSTPATH."/uploaded/front/".$row[0]);
        unlink($HOSTPATH."/uploaded/front/small_".$row[0]);
    }
}
if($_POST['change']??false) {
    foreach($_POST['position'] as $name=>$value){
        $display=($_POST['display'][$name]==1)?1:0;
        $url=$_POST['url'][$name];
        $description=($_POST['description'][$name])?mysql_real_escape_string($_POST['description'][$name]):"";
        //mydump($_POST['description']);mydump($description);
        mysql_query("update ".$PREFIX."frontpage set position=$value, display=$display,url='".$url."',description='".$description."' where id=$name");
        mydump("update frontpage set position=$value, display=$display,url='".$url."',description='".$description."' where id=$name");
    }

}
$res = mysql_query("SELECT id,name,title,position,display,url,description,type,section from ".$PREFIX."frontpage where type!='image' ORDER BY section,position");
$front="<form method=\"post\"><table><tr><td>Изображение</td><td>Название</td><td>Порядок</td><td>Отображать</td><td>Удаление</td></tr>";
$x='';
if($res) {
    if(mysql_num_rows($res)) {
        while ($row = mysql_fetch_row($res)) {
            if($x!=$row[8]) {
                $title=str_replace(array('new','action'), array('Новинки','Акции'), $row[8]);
                $front.='<tr class=st><td colspan=5>'.$title.'</td></tr>';
                $x=$row[8];
            }
            $src='';$title=$row[2];$description=$row[6];
            if($row[1]!='' && file_exists($HOSTPATH."/uploaded/front/small_".$row[1])) {
                $src=$PATH."/uploaded/front/small_".$row[1];
            }
    
            if($row[1]=='' && $row[7]=='product') {
                //var_dump($row[0]);
                $parts=explode('/', $row[5]);
                $item=array_pop($parts);
        
                $iparts=explode("-", $item);
                $im_id=array_pop($iparts); //echo "dfgdf";
                //var_dump($im_id);
                if(file_exists($HOSTPATH."/uploaded/small_{$im_id}.png")) {  $src = $PATH."/uploaded/small_".$im_id.".png";
                }
                if (file_exists($HOSTPATH."/uploaded/small_{$im_id}.jpeg")) { $src = $PATH."/uploaded/small_".$im_id.".jpeg";
                }
                if (file_exists($HOSTPATH."/uploaded/small_{$im_id}.gif")) { $src = $PATH."/uploaded/small_".$im_id.".gif";
                }

            }
            if($row[1]=='' && $row[7]=='section') {
                $parts=explode('/', $row[5]);
                $im_id=array_pop($parts);
                if(file_exists($HOSTPATH."/uploaded/menu/{$im_id}.png")) {  $src = $PATH."/uploaded/menu/".$im_id.".png";
                }
                if (file_exists($HOSTPATH."/uploaded/menu/{$im_id}.jpeg")) { $src = $PATH."/uploaded/menu/".$im_id.".jpeg";
                }
                if (file_exists($HOSTPATH."/uploaded/menu/{$im_id}.gif")) { $src = $PATH."/uploaded/menu/".$im_id.".gif";
                }
            }
            if($src=='') {
                $src='/images/no_image.png';
            }
            $check=($row[4]==1)?" checked":"";
            $front.="<tr style='vertical-align:top'><td rowspan=\"2\"><img src='".$src."' alt='' /></td><td><b>".$row[2]."</b></td><td><input type='text' name='position[".$row[0]."]' value='".$row[3]."' size='2' /></td><td><input type='checkbox' name='display[".$row[0]."]' value='1'$check /></td><td><input style='font-size:0;border:0;cursor:pointer;width:20px;height:20px;background:url(".$PATH."/img/del.gif) no-repeat' type='submit' name='del' value='$row[0]' /></td></tr><tr><td colspan=\"4\"><textarea style=\"width:100%\" name='description[".$row[0]."]'>$row[6]</textarea><br>URL: <input type='text' name='url[".$row[0]."]' value='".$row[5]."' size='35' /></td></tr>";
        }
    }
}
$front.="<tr><td></td><td></td><td><input class='button2' type='submit' name='change' value='Изменить' /></td><td></td><td></td></tr></table></form>";

?>
<form method="post" enctype="multipart/form-data">
<table style="width:560px"><caption>Формирование ссылок на главной странице</caption>
<tr><td>Название</td><td><input name="title" type="text" style="width: 100%;"></td></tr>
<tr><td>Описание</td><td><textarea name="description" style="width: 100%;"></textarea></td></tr>
<tr><td>Раздел</td><td>
<select name=section>
<option value=action>Акции</option>
<option value=new>Новинки</option>
</select>
</td></tr>
<tr><td>Тип ссылки</td><td>
<select name=type>
<option value=slink>Ссылка</option>
<option value=section>Раздел</option>
<option value=product>Товар</option>
</select>
</td></tr>
<tr><td>Ссылка</td><td><input name="url" type="text" style="width: 100%;"></td></tr>
<tr><td>Выбрать изображение не менее <?php echo $GLOBALS['LINKIMG_WIDTH']; ?>x<?php echo $GLOBALS['LINKIMG_HEIGHT']; ?></td><td><input class="textbox" name="frm_img" type="file" style="width:220px;"></td></tr>
<tr><td></td><td><input class="button" type="submit" name="frontpg" value="Отправить"></td></tr>

</table>
</form>
<?php
echo $front;
?>