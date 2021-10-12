<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) {
    die("Access denied");
}

if ($_POST['massfoto']) {
    if (glob("uploaded/farms/source/*.*")) {
        foreach (glob("uploaded/farms/source/*.*") as $curfoto) {
            $cf=$curfoto;
            $id="";
            $curfoto=str_replace("uploaded/farms/source/", "", $curfoto);
            $curfoto=str_replace(".jpeg", "", $curfoto);
            $curfoto=str_replace(".jpg", "", $curfoto);
            $curfoto=str_replace(".gif", "", $curfoto);
            $curfoto=str_replace(".png", "", $curfoto);
            $curfoto=str_replace(".JPEG", "", $curfoto);
            $curfoto=str_replace(".JPG", "", $curfoto);
            $curfoto=str_replace(".GIF", "", $curfoto);
            $curfoto=str_replace(".PNG", "", $curfoto);
            //$curfoto=str_replace("daf_","",$curfoto);
            //$curfoto=str_replace("man_","",$curfoto);
            //$curfoto=str_replace("mb_","",$curfoto);
            //$curfoto=str_replace("renault_","",$curfoto);
            //$curfoto=str_replace("volvo_","",$curfoto);
            //$curfoto=str_replace("scania_","",$curfoto);
            //$curfoto=str_replace("iveco_","",$curfoto);
        
            $type=preg_match("!\.jpe?g$!is", $cf, $match)?"jpeg":"";
            $type=preg_match("!\.gif$!is", $cf, $match)?"gif":$type;
            $type=preg_match("!\.png$!is", $cf, $match)?"png":$type;
        
        
            if ($type && $curfoto) {
                //delete everything
                @unlink("uploaded/farms/$curfoto.jpeg");
                @unlink("uploaded/farms/$curfoto.png");
                @unlink("uploaded/farms/$curfoto.gif");
                //lets rock
                list($width, $height) = getimagesize($cf);
                $x_ratio = $width / $IMAGE_MAXSIZE;
                $y_ratio = $height / $IMAGE_HMAXSIZE;
                if ($x_ratio>$y_ratio) {
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
                $imerge=imagecreatefromgif('img/vz330.gif');
                imagecopymerge($dest, $imerge, 0, 10, 0, 0, 330, 330, 50);
                $func = "image" . $type;
                $func($dest, "uploaded/farms/$curfoto.$type");
                //do small img
                //delete everything
                @unlink("uploaded/farms/small_$curfoto.jpeg");
                @unlink("uploaded/farms/small_$curfoto.png");
                @unlink("uploaded/farms/small_$curfoto.gif");
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
                $func = "image" . $type;
                $func($dest, "uploaded/farms/small_$curfoto.$type");
                //do big img
                @unlink("uploaded/farms/big_$curfoto.jpeg");
                @unlink("uploaded/farms/big_$curfoto.png");
                @unlink("uploaded/farms/big_$curfoto.gif");
                $x_ratio = $width / $IMAGE3_MAXSIZE;
                $y_ratio = $height / $IMAGE3_HMAXSIZE;
                if ($x_ratio>$y_ratio) {
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
                $imerge=imagecreatefromgif('img/vz.gif');
                imagecopymerge($dest, $imerge, 0, 0, 0, 0, 750, 750, 50);
                $func = "image" . $type;
                $func($dest, "uploaded/farms/big_$curfoto.$type");
                unlink($cf);
                $cf=str_replace("uploaded/farms/source/", "", $cf);
                echo $cf." - ok!<br />";
            } else {
                echo "<span style=\"color:red\">".$cf." - нет в базе либо неверный тип файла</span><br />";
            }
        }
    }
    if (glob("uploaded/farms/source2/*.*")) {
        foreach (glob("uploaded/source2/*.*") as $curfoto) {
            //echo "<br><b>".$curfoto."</b><br>";
            $cf=$curfoto;
            //$curfoto=str_replace("uploaded/source2/","",$curfoto);
            //$curfoto=str_replace(".jpeg","",$curfoto);
            //$curfoto=str_replace(".jpg","",$curfoto);
            //$curfoto=str_replace(".gif","",$curfoto);
            //$curfoto=str_replace(".png","",$curfoto);
            $curfoto=str_replace("daf_", "", $curfoto);
            $curfoto=str_replace("man_", "", $curfoto);
            $curfoto=str_replace("mb_", "", $curfoto);
            $curfoto=str_replace("renault_", "", $curfoto);
            $curfoto=str_replace("volvo_", "", $curfoto);
            $curfoto=str_replace("scania_", "", $curfoto);
            $curfoto=str_replace("iveco_", "", $curfoto);
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
            if ($type!="" && $row[0]) {
                $id =$row[0];
                //echo "<br>----------".$id;
                if (glob("uploaded/big_".$id."_*.*")) {
                    foreach (glob("uploaded/big_".$id."_*.*") as $img) {
                        if (unlink($img)) {
                            echo "<br> deleting ".$img." -ok!<br>";
                        } else {
                            echo "<br> <span style=\"color:red\">error:deleting ".$img." -ok!</span><br>";
                        }
                    }
                }
      
                //echo "<br>----------".$cf;
                list($width, $height) = getimagesize($cf);
                //echo "<br>w ".$width." - h ".$height."</br>";
                $x_ratio = $width / $IMAGE3_MAXSIZE;
                $y_ratio = $height / $IMAGE3_HMAXSIZE;
                //echo "<br>x ".$x_ratio." - y ".$y_ratio."</br>";
                if ($x_ratio>$y_ratio) {
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
                $imerge=imagecreatefromgif('img/vz.gif');
                imagecopymerge($dest, $imerge, 0, 0, 0, 0, 600, 600, 50);
                $func = "image" . $type;
                $func($dest, "uploaded/big_".$id."_".$curfotoadd.".".$type);
                unlink($cf);
                $cf=str_replace("uploaded/source2/", "", $cf);
                echo $cf." - ok!<br />";
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
if (glob("uploaded/farms/source/*.*") || glob("uploaded/farms/source2/*.*")) {
    ?>
<form method="post"><input type="submit" name="massfoto" value="Обработать загруженные фото" class="button" style="cursor:pointer" /></form>
    <?php
} else {
        echo "загрузите фото в папку uploaded/farms/source/
	<p>Фото должны быть вида: id-статьи_число.jpg</p>";
    }
?>
