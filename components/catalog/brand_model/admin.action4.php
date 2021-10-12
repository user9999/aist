<?php
if($_POST['massfoto']) {
    if(glob("uploaded/source/*.*")) {
        foreach(glob("uploaded/source/*.*") as $curfoto){
            $cf=$curfoto;$id="";
            $curfoto=str_replace("uploaded/source/", "", $curfoto);
            $curfoto=str_replace(".jpeg", "", $curfoto);
            $curfoto=str_replace(".jpg", "", $curfoto);
            $curfoto=str_replace(".gif", "", $curfoto);
            $curfoto=str_replace(".png", "", $curfoto);
            $curfoto=str_replace("daf_", "", $curfoto);
            $curfoto=str_replace("man_", "", $curfoto);
            $curfoto=str_replace("mb_", "", $curfoto);
            $curfoto=str_replace("renault_", "", $curfoto);    
            $curfoto=str_replace("volvo_", "", $curfoto);
            $curfoto=str_replace("scania_", "", $curfoto);
            $curfoto=str_replace("iveco_", "", $curfoto);
            $curfoto=str_replace("@", "/", $curfoto);
            //die($curfoto);
            $type=preg_match("!\.jpe?g$!", $cf, $match)?"jpeg":"";
            $type=preg_match("!\.gif$!", $cf, $match)?"gif":$type;
            $type=preg_match("!\.png$!", $cf, $match)?"png":$type;
            $res=mysql_query("select id from ".$PREFIX."catalog_items2 where linked_item='".$curfoto."' limit 1");
            $row = mysql_fetch_row($res);
            if($row[0]) {
                $id =$row[0];
            } else {
                $res2=mysql_query("select model_id,description,keywords,section from ".$PREFIX."catalog_items where name='".$curfoto."' limit 1");
                $row2 = mysql_fetch_row($res2);
                $alt=explode(",", $row2[2]);
                mysql_query("insert into ".$PREFIX."catalog_items2 set name='".$row2[1]."',linked_item='".$curfoto."',keywords='".$row2[2]."',model_id=".$row2[0].",section=".$row2[3].",alt='alt=\"".$alt[0]."\"'");
                $id = mysql_insert_id();
            }
            if ($type && $id) {
                //delete everything
                @unlink("uploaded/$id.jpeg");
                @unlink("uploaded/$id.png");
                @unlink("uploaded/$id.gif");
                //lets rock
                list($width, $height) = getimagesize($cf);    
                $x_ratio = $width / $IMAGE_MAXSIZE;
                $y_ratio = $height / $IMAGE_HMAXSIZE;
                if($x_ratio>$y_ratio) {
                    $newheight=floor($height/$x_ratio);
                    $newwidth=$IMAGE_MAXSIZE;
                    $xcoord=0;
                    $ycoord=floor(($IMAGE_HMAXSIZE-$newheight)/2);
                } else {
                    $newheight=$IMAGE_HMAXSIZE;
                    $newwidth=floor($width/$y_ratio);
                    $xcoord=floor(($IMAGE_MAXSIZE-$newwidth)/2);
                    $ycoord=0;        
                }
                $func = "imagecreatefrom" . $type;
                $source = $func($cf);
                $dest = imagecreatetruecolor($IMAGE_MAXSIZE, $IMAGE_HMAXSIZE);
                imagefill($dest, 0, 0, $RGB);
                imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
                if($_POST['normal']==1) {        
                    $imerge=imagecreatefromgif('uploaded/watermark/normal.gif');
                    imagecopymerge($dest, $imerge, 0, 10, 0, 0, $IMAGE_MAXSIZE, $IMAGE_HMAXSIZE, 50);
                }    
                $func = "image" . $type;
                $func($dest, "uploaded/$id.$type");
                //do small img
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
                $dest = imagecreatetruecolor($newwidth, $newheight);
                imagecopyresampled($dest, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            
                if($_POST['small']==1) {        
                    $imerge=imagecreatefromgif('uploaded/watermark/small.gif');
                    imagecopymerge($dest, $imerge, 0, 10, 0, 0, $newwidth, $newheight, 50);
                }

                $func = "image" . $type;
                $func($dest, "uploaded/small_$id.$type");
                //do big img
                @unlink("uploaded/big_$id.jpeg");
                @unlink("uploaded/big_$id.png");
                @unlink("uploaded/big_$id.gif");
                $x_ratio = $width / $IMAGE3_MAXSIZE;
                $y_ratio = $height / $IMAGE3_HMAXSIZE;
                if($x_ratio>$y_ratio) {
                    $newheight=floor($height/$x_ratio);
                    $newwidth=$IMAGE3_MAXSIZE;
                    $xcoord=0;
                    $ycoord=floor(($IMAGE3_HMAXSIZE-$newheight)/2);
                } else {
                    $newheight=$IMAGE3_HMAXSIZE;
                    $newwidth=floor($width/$y_ratio);
                    $xcoord=floor(($IMAGE3_MAXSIZE-$newwidth)/2);
                    $ycoord=0;        
                }        
                $func = "imagecreatefrom" . $type;
                $dest = imagecreatetruecolor($IMAGE3_MAXSIZE, $IMAGE3_HMAXSIZE);
                imagefill($dest, 0, 0, $RGB);
                imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
                if($_POST['big']==1) {    
                    $imerge=imagecreatefromgif('uploaded/watermark/big.gif');
                    imagecopymerge($dest, $imerge, 0, 0, 0, 0, $IMAGE3_MAXSIZE, $IMAGE3_HMAXSIZE, 50);
                }
                $func = "image" . $type;
                $func($dest, "uploaded/big_$id.$type");
                unlink($cf);
                $cf=str_replace('uploaded/source/', '', $cf);
                echo $cf.' - ok!<br>';
            } else {
                echo '<span style="color:red">'.$cf.' - нет в базе либо неверный тип файла</span><br>';
            }
        }
    }
    if(glob("uploaded/source2/*.*")) {
        foreach(glob("uploaded/source2/*.*") as $curfoto){
            $cf=$curfoto;
            $curfoto=str_replace("daf_", "", $curfoto);
            $curfoto=str_replace("man_", "", $curfoto);
            $curfoto=str_replace("mb_", "", $curfoto);
            $curfoto=str_replace("renault_", "", $curfoto);    
            $curfoto=str_replace("volvo_", "", $curfoto);
            $curfoto=str_replace("scania_", "", $curfoto);
            $curfoto=str_replace("iveco_", "", $curfoto);
            $curfoto=str_replace("@", "/", $curfoto);
            $curfotoid=preg_replace("!^uploaded/source2/([^_]+)_([^\.]+)\.[a-zA-Z]+$!", "$1", $curfoto);
            $curfotoadd=preg_replace("!^uploaded/source2/([^_]+)_([^\.]+)\.[a-zA-Z]+$!", "$2", $curfoto);
            $type=preg_match("!\.jpe?g$!", $cf, $match)?"jpeg":"";
            $type=preg_match("!\.gif$!", $cf, $match)?"gif":$type;
            $type=preg_match("!\.png$!", $cf, $match)?"png":$type;
            $res=mysql_query("select id from ".$PREFIX."catalog_items2 where linked_item='".$curfotoid."' limit 1");
            $row = mysql_fetch_row($res);
            if($type!="" && $row[0]) {
                  $id =$row[0];
                if(glob("uploaded/big_".$id."_*.*")) {
                    foreach(glob("uploaded/big_".$id."_*.*") as $img){
                        if(unlink($img)) {
                            echo '<br> deleting '.$img.' -ok!<br>';
                        } else {
                            echo '<br> <span style="color:red">error:deleting '.$img.' -ok!</span><br>';
                        }
                    }
                }
                list($width, $height) = getimagesize($cf);
                $x_ratio = $width / $IMAGE3_MAXSIZE;
                $y_ratio = $height / $IMAGE3_HMAXSIZE;
                if($x_ratio>$y_ratio) {
                    $newheight=floor($height/$x_ratio);
                    $newwidth=$IMAGE3_MAXSIZE;
                    $xcoord=0;
                    $ycoord=floor(($IMAGE3_HMAXSIZE-$newheight)/2);
                } else {
                    $newheight=$IMAGE3_HMAXSIZE;
                    $newwidth=floor($width/$y_ratio);
                    $xcoord=floor(($IMAGE3_MAXSIZE-$newwidth)/2);
                    $ycoord=0;        
                }        
                $func = "imagecreatefrom" . $type;
                $source = $func($cf);
                $dest = imagecreatetruecolor($IMAGE3_MAXSIZE, $IMAGE3_HMAXSIZE);
                imagefill($dest, 0, 0, $RGB);
                imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
                if($_POST['big']==1) {    
                    $imerge=imagecreatefromgif('uploaded/watermark/big.gif');
                    imagecopymerge($dest, $imerge, 0, 0, 0, 0, $IMAGE3_MAXSIZE, $IMAGE3_HMAXSIZE, 50);
                }
                $func = "image" . $type;
                $func($dest, 'uploaded/big_'.$id.'_'.$curfotoadd.'.'.$type);
                unlink($cf);
                $cf=str_replace('uploaded/source2/', '', $cf);
                echo $cf.' - ok!<br>';
            } else {
                          echo '<span style="color:red">'.$cf.' - нет в базе либо неверный тип файла</span><br>';
            }
        }
    }
}
?>
<br><br>
<h1>Обработка фото</h1>
<?php
if($WATERMARK) {
    $w="<label for=\"small\">Водяной знак</label><input id=small type=checkbox name=small value=1>
	<label for=\"normal\">Водяной знак</label><input id=normal type=checkbox name=normal value=1 checked>
	<label for=\"big\">Водяной знак</label><input id=big type=checkbox name=big value=1 checked>
	<br>";
}
if(glob("uploaded/source/*.*") || glob("uploaded/source2/*.*")) {
    ?>
<form method=post><?php echo $w?><input type=submit name=massfoto value="Обработать загруженные фото" class=button style="cursor:pointer" /></form>
    <?php
} else {
    echo "загрузите фото в папку uploaded/source/, обратные стороны деталей в папку uploaded/source2/
	<p>Фото должны быть вида: марка_gruz-id.jpg</p>
	<p>/ в названии фотографии должен быть заменен на @</p>
<p>Дополнительные фото должны быть вида: марка_gruz-id_идентификатор.jpg. Идентификатор может содержать цифры и буквы латинского алфавита</p>";
}
?>
