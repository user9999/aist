<?php
// Создаем подключение к серверу
require_once "../inc/configuration.php";
require_once "../inc/gallery.config.php";
require_once "../inc/functions.php";

//$db = mysql_connect ("servername","user","password"); 
// Выбираем БД
//mysql_select_db ("dbname",$db);

// Все загруженные файлы помещаются в эту папку
$uploaddir = $HOSTPATH.'/uploaded/gallery/source/';
// Вытаскиваем необходимые данные
$file = $_POST['value'];
$name = $_POST['name'];
// Получаем расширение файла
$getMime = explode('.', $name);
$mime = array_pop($getMime);
$mime = strtolower($mime);
$title=implode(".", $getMime);
// Выделим данные
$data = explode(',', $file);


// Декодируем данные, закодированные алгоритмом MIME base64
$encodedData = str_replace(' ', '+', $data[1]);
$decodedData = base64_decode($encodedData);

// Вы можете использовать данное имя файла, или создать произвольное имя.
// Мы будем создавать произвольное имя!
$randomName = substr_replace(sha1(microtime(true)), '', 12).'.'.$mime;

// Создаем изображение на сервере
if(file_put_contents($uploaddir.$randomName, $decodedData)) {
    // Записываем данные изображения в БД
    $type = "";
    if ($mime == 'jpeg' || $mime  == 'jpg' || $mime  == 'pjpeg') {
        $type = "jpeg";
    } elseif ($mime == 'png' || $mime == 'x-png') {
        $type = "png";
    } elseif ($mime == 'gif') {
        $type = "gif";
    }
    if ($type) {
        $imgname=$randomName;
        //lets rock
        list($width, $height) = getimagesize($uploaddir.$randomName);
        /*
        //echo $width." ".$height."<br>";
        $x_ratio = $width / $GAL_WIDTH;
        $y_ratio = $height / $GAL_HEIGHT;
        if($x_ratio>$y_ratio){
        $newheight=floor($height/$x_ratio);
        $newwidth=$GAL_WIDTH;
        $xcoord=0;
        $ycoord=floor(($GAL_HEIGHT-$newheight)/2);
        } else {
        $newheight=$GAL_HEIGHT;
        $newwidth=floor($width/$y_ratio);
        $xcoord=floor(($GAL_WIDTH-$newwidth)/2);
        $ycoord=0;        
        }
        //echo $newwidth." ".$newheight."<br>";
        $func = "imagecreatefrom" . $type;
        $source = $func($uploaddir.$randomName);
        $dest = imagecreatetruecolor($GAL_WIDTH, $GAL_HEIGHT);
        imagefill($dest, 0, 0, $FRGB);
        imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
        $imgname=$randomName;
        //echo $imgname;
        $func = "image" . $type;
        $func($dest, $HOSTPATH."/uploaded/gallery/$imgname");
        //echo $HOSTPATH."/uploaded/gallery/$imgname"."<br>";
        //echo "<a href='' onclick='window.open(\"".$HOSTPATH."/uploaded/gallery/".$imgname.".".$type."\",\"img\")'>посмотреть</a>";
        */
        /////////////////small

        $x_ratio = $width / $SGAL_WIDTH;
        $y_ratio = $height / $SGAL_HEIGHT;
        if($x_ratio>$y_ratio) {
            $newheight=floor($height/$x_ratio);
            $newwidth=$SGAL_WIDTH;
            $xcoord=0;
            $ycoord=floor(($SGAL_HEIGHT-$newheight)/2);
        } else {
            $newheight=$SGAL_HEIGHT;
            $newwidth=floor($width/$y_ratio);
            $xcoord=floor(($SGAL_WIDTH-$newwidth)/2);
            $ycoord=0;        
        }

        //echo $width." ".$height."<br>";
        $func = "imagecreatefrom" . $type;
        //$source = $func($_FILES['frm_img']['tmp_name']);
        $source = $func($uploaddir.$randomName);
        $dest = imagecreatetruecolor($SGAL_WIDTH, $SGAL_HEIGHT);
        imagefill($dest, 0, 0, $SGRGB);
        imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
        //if($GAL_WATERMARK){
        //$imerge=imagecreatefromgif('uploaded/watermark/gallery.gif');
        //imagecopymerge($dest,$imerge,0,0,0,0,$SGAL_WIDTH,$SGAL_HEIGHT,50);
        //}
        //$imgname=time();
        //echo $imgname;
        $func = "image" . $type;
        $func($dest, $HOSTPATH."/uploaded/gallery/small_$imgname");    
        //echo " <a href='' onclick='window.open(\"".$GLOBALS['PATH']."/uploaded/front/small_".$imgname.".".$type."\",\"img\")'>small</a>";
                
                
                

        $x_ratio = $width / $GAL_WIDTH;
        $y_ratio = $height / $GAL_HEIGHT;
        if($x_ratio>$y_ratio) {
            $newheight=floor($height/$x_ratio);//$IMAGE_HMAXSIZE;
            $newwidth=$GAL_WIDTH;//$width/$x_ratio;
            $xcoord=0;
            $ycoord=floor(($GAL_HEIGHT-$newheight)/2);

        } else {
            $newheight=$GAL_HEIGHT;
            $newwidth=floor($width/$y_ratio);
            $xcoord=floor(($GAL_WIDTH-$newwidth)/2);
            $ycoord=0;        
        }        
        $func = "imagecreatefrom" . $type;
        $dest = imagecreatetruecolor($GAL_WIDTH, $GAL_HEIGHT);
        imagefill($dest, 0, 0, $GRGB);
        imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
        if($GAL_WATERMARK) {    

             $imerge=imagecreatefromgif($HOSTPATH.'/uploaded/watermark/gallery.gif');
             imagecopymerge($dest, $imerge, 0, 0, 0, 0, $GAL_WIDTH, $GAL_HEIGHT, $GALL_TRANSPARENCY);
        }
            $func = "image" . $type;
            $func($dest, $HOSTPATH."/uploaded/gallery/$imgname");
                
                
                
                
                
                $title=($_POST['title'])?mysql_real_escape_string($_POST['title']):"";
                //mysql_query("INSERT INTO frontpage SET name='$imgname.$type', title='".$title."',url='".$_POST['url']."',type='image'");
    }



    
    //@unlink($uploaddir.$randomName);
    $time=time();
    $n=$getMime[0];//str_replace($type,"",$_POST['name']);
    mysql_query("INSERT INTO ".$GLOBALS['PREFIX']."gallery (link,title,date,display) VALUES ('$randomName','".$n."',$time,1)");
                    //$fp=fopen('tmp.txt',"a+");
    //fwrite($fp,"\r\nINSERT INTO ".$GLOBALS['PREFIX']."gallery (link,title,date,display) VALUES ('$randomName','".$n."',$time,1)");
    //fclose($fp);
    //$fp=fopen('tmp.txt',"a+");
    //fwrite($fp,"INSERT INTO gallery (link,date) VALUES ('$randomName',$time);\r\n");
    //fclose($fp);
    echo $randomName.":загружен успешно";
}
else {
    // Показать сообщение об ошибке, если что-то пойдет не так.
    echo "Что-то пошло не так. Убедитесь, что файл не поврежден!";
}
?>
