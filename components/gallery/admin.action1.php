<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
?>

<?php
$script="
<script src=\"/templates/admin.blank/javascript.js\"></script>
";
$css="<link rel=\"stylesheet\" type=\"text/css\" href=\"/templates/admin.blank/upload.css\">
";
set_script($script);
set_css($css);
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
    //die($type);
    if ($type) {
        //lets rock
        list($width, $height) = getimagesize($_FILES['frm_img']['tmp_name']);
        
        $x_ratio = $width / $FRIMG_WIDTH;
        $y_ratio = $height / $FRIMG_HEIGHT;
        if($x_ratio>$y_ratio) {
            $newheight=floor($height/$x_ratio);
            $newwidth=$FRIMG_WIDTH;
            $xcoord=0;
            $ycoord=floor(($FRIMG_HEIGHT-$newheight)/2);
        } else {
            $newheight=$FRIMG_HEIGHT;
            $newwidth=floor($width/$y_ratio);
            $xcoord=floor(($FRIMG_WIDTH-$newwidth)/2);
            $ycoord=0;        
        }
                
        $func = "imagecreatefrom" . $type;
        $source = $func($_FILES['frm_img']['tmp_name']);
        $dest = imagecreatetruecolor($FRIMG_WIDTH, $FRIMG_HEIGHT);
        imagefill($dest, 0, 0, $FRGB);
        imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
        $imgname=time();
        echo $imgname;
        $func = "image" . $type;
        $func($dest, "uploaded/gallery/$imgname.$type");
        echo "<a href='' onclick='window.open(\"".$GLOBALS['PATH']."/uploaded/gallery/".$imgname.".".$type."\",\"img\")'>посмотреть</a>";
                
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
        //$source = $func($_FILES['frm_img']['tmp_name']);
        $dest = imagecreatetruecolor($FRIMG2_WIDTH, $FRIMG2_HEIGHT);
        imagefill($dest, 0, 0, $FRGB);
        imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
        //$imgname=time();
        //echo $imgname;
        $func = "image" . $type;
        $func($dest, "uploaded/gallery/small_$imgname.$type");    
        echo " <a href='' onclick='window.open(\"".$GLOBALS['PATH']."/uploaded/front/small_".$imgname.".".$type."\",\"img\")'>small</a>";
        $title=($_POST['title'])?mysql_real_escape_string($_POST['title']):"";
        //mysql_query("INSERT INTO ".$PREFIX."frontpage SET name='$imgname.$type', title='".$title."',url='".$_POST['url']."',type='image'");
        mysql_query("INSERT INTO ".$PREFIX."gallery SET link='$imgname.$type', title='".$title."'");
    }
}

if($_POST['del']) {
    //mysql_query("delete from ".$PREFIX."frontpage where name='".$_POST['del']."'");
    mysql_query("delete from ".$PREFIX."gallery where title='".$_POST['del']."'");
    unlink("uploaded/gallery/".$_POST['del']);
    unlink("uploaded/gallery/small_".$_POST['del']);
}
if($_POST['change']) {
    foreach($_POST['position'] as $name=>$value){
        $display=($_POST['display'][$name]==1)?1:0;
        $url=$_POST['url'][$name];
        //mysql_query("update ".$PREFIX."frontpage set position=$value, display=$display,url='".$url."' where name='$name'");
        mysql_query("update ".$PREFIX."gallery set position=$value, display=$display where title='$name'");
    }

}

?>
<div id="drop-files" ondragover="return false">
        <p>Перетащите изображение сюда</p>
        <form id="frm">
            <input type="file" id="uploadbtn" multiple />
        </form>
    </div>
    <!-- Область предпросмотра -->
    <div id="uploaded-holder"> 
        <div id="dropped-files">
            <!-- Кнопки загрузить и удалить, а также количество файлов -->
            <div id="upload-button">
                <center>
                    <span>0 Файлов</span>
                    <a href="#" class="upload">Загрузить</a>
                    <a href="#" class="delete">Удалить</a>
                    <!-- Прогресс бар загрузки -->
                    <div id="loading">
                        <div id="loading-bar">
                            <div class="loading-color"></div>
                        </div>
                        <div id="loading-content"></div>
                    </div>
                </center>
            </div>  
        </div>
    </div>
    <!-- Список загруженных файлов -->
    <div id="file-name-holder">
        <ul id="uploaded-files">
            <h1>Загруженные файлы</h1>
        </ul>
    </div>