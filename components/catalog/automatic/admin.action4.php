<?php
if($_POST['massfoto']) {
    if(glob("uploaded/source/*.*")) {
        foreach(glob("uploaded/source/*.*") as $curfoto){
            $cf=$curfoto;$id="";
    
            $curfoto=str_replace("uploaded/source/", "", $curfoto);
            $curfoto=str_replace(".JPEG", "", $curfoto);
            $curfoto=str_replace(".jpeg", "", $curfoto);
            $curfoto=str_replace(".JPG", "", $curfoto);
            $curfoto=str_replace(".jpg", "", $curfoto);
            $curfoto=str_replace(".gif", "", $curfoto);
            $curfoto=str_replace(".png", "", $curfoto);
            $curfoto=str_replace(".GIF", "", $curfoto);
            $curfoto=str_replace(".PNG", "", $curfoto);
    
            $type=preg_match("!\.jpe?g$!is", $cf, $match)?"jpeg":"";
            $type=preg_match("!\.gif$!is", $cf, $match)?"gif":$type;
            $type=preg_match("!\.png$!is", $cf, $match)?"png":$type;
        
        
            $res=mysql_query("select id from ".$PREFIX."catalog_items where name='".$curfoto."' limit 1");
            $row = mysql_fetch_row($res);
            if($row[0]) {
                $id =$row[0];
            } else {
                $id=false;
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
                $func = "imagecreatefrom" . $type;
                $source = $func($cf);
                $dest = imagecreatetruecolor($IMAGE_MAXSIZE, $IMAGE_HMAXSIZE);//imagecreatetruecolor($newwidth, $newheight);
                imagefill($dest, 0, 0, $RGB);
                imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
                if($_POST['normal']==1) {        
                    $imerge=imagecreatefromgif('uploaded/watermark/normal.gif');
                    imagecopymerge($dest, $imerge, 0, 10, 0, 0, $IMAGE_MAXSIZE, $IMAGE_HMAXSIZE, 50);
                }
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
                $cf=str_replace("uploaded/source/", "", $cf);
                echo $cf." - ok!<br />";
            } else {
                echo "<span style=\"color:red\">".$cf." - нет в базе либо неверный тип файла</span><br />";
            }
        }
    }
    if(glob("uploaded/source2/*.*")) {
        foreach(glob("uploaded/source2/*.*") as $curfoto){
            //echo "<br><b>".$curfoto."</b><br>";
            $cf=$curfoto;
            //$curfoto=str_replace("uploaded/source2/","",$curfoto);
            //$curfoto=str_replace(".jpeg","",$curfoto);
            //$curfoto=str_replace(".jpg","",$curfoto);
            //$curfoto=str_replace(".gif","",$curfoto);
            //$curfoto=str_replace(".png","",$curfoto);

            $curfotoid=preg_replace("!^uploaded/source2/([^_]+)_([^\.]+)\.[a-zA-Z]+$!", "$1", $curfoto);
            $curfotoadd=preg_replace("!^uploaded/source2/([^_]+)_([^\.]+)\.[a-zA-Z]+$!", "$2", $curfoto);
            $type=preg_match("!\.jpe?g$!", $cf, $match)?"jpeg":"";
            $type=preg_match("!\.gif$!", $cf, $match)?"gif":$type;
            $type=preg_match("!\.png$!", $cf, $match)?"png":$type;
        
            //echo "<br>".$curfotoid." = ".$curfotoadd."<br>";
        
            $res=mysql_query("select id from ".$PREFIX."catalog_items2 where linked_item='".$curfotoid."' limit 1");
            //echo "select id from catalog_items2 where linked_item='".$curfotoid."' limit 1";
            $row = mysql_fetch_row($res);
            //echo "<br>----------".$row[0];
            if($type!="" && $row[0]) {
                  $id =$row[0];
                if(file_exists("uploaded/big_".$id."_".$curfotoadd.".".$type)) {
                    unlink("uploaded/big_".$id."_".$curfotoadd.".".$type);
                }
                //echo "<br>----------".$id;
                /*
                if(glob("uploaded/big_".$id."_*.*")){
                foreach(glob("uploaded/big_".$id."_*.*") as $img){
                if(unlink($img)){
                echo "<br> deleting ".$img." -ok!<br>";
                } else {
                echo "<br> <span style=\"color:red\">error:deleting ".$img." -ok!</span><br>";
                }
                }
                }
                */
                //echo "<br>----------".$cf;
                list($width, $height) = getimagesize($cf);
                //echo "<br>w ".$width." - h ".$height."</br>";
                $x_ratio = $width / $IMAGE3_MAXSIZE;
                $y_ratio = $height / $IMAGE3_HMAXSIZE;
                //echo "<br>x ".$x_ratio." - y ".$y_ratio."</br>";
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
                //echo "<br>nw ".$newwidth." - nh ".$newheight." :  c ".$ycoord."</br>";
                $func = "imagecreatefrom" . $type;

                $source = $func($cf);
                //echo "<br>----------".$func."(".$cf.")<br>";
                $dest = imagecreatetruecolor($IMAGE3_MAXSIZE, $IMAGE3_HMAXSIZE);
                imagefill($dest, 0, 0, $RGB);
                imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
                if($_POST['big']==1) {    
                    $imerge=imagecreatefromgif('uploaded/watermark/big.gif');
                    imagecopymerge($dest, $imerge, 0, 0, 0, 0, $IMAGE3_MAXSIZE, $IMAGE3_HMAXSIZE, 50);
                }
                $func = "image" . $type;
                $func($dest, "uploaded/big_".$id."_".$curfotoadd.".".$type);
                //unlink($cf);
                $cf=str_replace("uploaded/source2/", "", $cf);
                echo $cf." - ok! - <a href='http://technostolica.ru/uploaded/big_".$id."_".$curfotoadd.".".$type."'>uploaded/big_".$id."_".$curfotoadd.".".$type."</a><br />";

            } else {
                          echo "<span style=\"color:red\">".$cf." - нет в базе либо неверный тип файла</span><br />";
            }
            
            
            
        }
    
    }
}

?>
<br /><br />
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
<form method="post"><?php echo $w?><input type="submit" name="massfoto" value="Обработать загруженные фото" class="button" style="cursor:pointer" /></form>
    <?php
} else {
    echo "загрузите фото в папку uploaded/source/, другие фото той же позиции в папку uploaded/source2/
	<p>Фото должны быть вида: внутренний-id.jpg</p>
<p>Дополнительные фото должны быть вида: внутренний-id_идентификатор.jpg. Идентификатор может содержать цифры и буквы латинского алфавита</p>";
}
?>
