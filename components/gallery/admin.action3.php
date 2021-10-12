<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
function make_watermark()
{
    global $GAL_WIDTH;
    global $GAL_HEIGHT;
    global $HOSTPATH;
    list($width, $height) = getimagesize($HOSTPATH."/uploaded/watermark/source/watermark.gif");
    $x_ratio = $width / $GAL_WIDTH;
    $y_ratio = $height / $GAL_HEIGHT;
    if($x_ratio>$y_ratio) {
        $newheight=floor($height/$x_ratio);//$GAL_HEIGHT;
        $newwidth=$GAL_WIDTH;//$width/$x_ratio;
        $xcoord=0;
        $ycoord=floor(($GAL_HEIGHT-$newheight)/2);

    } else {
        $newheight=$GAL_HEIGHT;
        $newwidth=floor($width/$y_ratio);
        $xcoord=floor(($GAL_WIDTH-$newwidth)/2);
        $ycoord=0;        
    }
    
    
    $func = "imagecreatefromgif";
    $source = $func($HOSTPATH."/uploaded/watermark/source/watermark.gif");
    $dest = imagecreatetruecolor($GAL_WIDTH, $GAL_HEIGHT);
    $black = ImageColorAllocate($dest, 0, 0, 0); // черный цвет
    imagecolortransparent($dest, $black); // теперь черный прозрачен
    ImageFill($dest, 0, 0, $black); 
    //imagesavealpha($dest, true);
    //$transPng=imagecolorallocatealpha($dest,0,0,0,127);    
    //imagefill($dest, 0, 0, $transPng);
    //imagefill($dest, 0, 0, $RGB);
    imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
    $func = "imagegif";
    $func($dest, $HOSTPATH."/uploaded/watermark/gallery.gif");
    //imagepng($dest, $HOSTPATH."/uploaded/watermark/gallery.png");
}
if(file_exists($HOSTPATH."/inc/gallery.config.php")) {
    include_once $HOSTPATH."/inc/gallery.config.php";
}
if($_POST['set']) {
    $GAL_WATERMARK=($_POST['GAL_WATERMARK'])?1:0;
    $settings="<?php
\$GAL_WIDTH = ".$_POST['GAL_WIDTH'].";
\$GAL_HEIGHT = ".$_POST['GAL_HEIGHT'].";
\$SGAL_WIDTH = ".$_POST['SGAL_WIDTH'].";
\$SGAL_HEIGHT = ".$_POST['SGAL_HEIGHT'].";
\$GRGB=0x".strtoupper($_POST['GRGB']).";
\$SGRGB=0x".strtoupper($_POST['SGRGB']).";
\$GAL_WATERMARK = ".$GAL_WATERMARK.";
\$GALL_TRANSPARENCY = ".$_POST['GALL_TRANSPARENCY'].";
?>
";
    //var_dump($settings);
    //die();

    $fp=fopen($HOSTPATH."/inc/gallery.config.php", "w");
    fwrite($fp, $settings);
    fclose($fp);

    if(file_exists($HOSTPATH."/uploaded/watermark/gallery.gif")) {
        list($width, $height) = getimagesize($HOSTPATH."/uploaded/watermark/gallery.gif");
        if($width!=$GAL_WIDTH || $height!=$GAL_HEIGHT) {
            unlink($HOSTPATH."/uploaded/watermark/gallery.gif");
            make_watermark();
        }
    } else {
        make_watermark();
    }
    //die();
    header("Location: ?component=gallery&action=3");
}
$checked=($GAL_WATERMARK)?"checked":"";
?>
<form method="post">
<table style="width:760px"><caption>Настройки галереи</caption>
<tr><td>Ширина картинки картинки галереи</td><td><input name="GAL_WIDTH" type="text" style="width: 80%;" value="<?php echo $GAL_WIDTH; ?>">px</td></tr>
<tr><td>Высота картинки картинки галереи</td><td><input name="GAL_HEIGHT" type="text" style="width: 80%;" value="<?php echo $GAL_HEIGHT; ?>">px</td></tr>
<tr><td>Ширина превью картинки галереи</td><td><input name="SGAL_WIDTH" type="text" style="width: 80%;" value="<?php echo $SGAL_WIDTH; ?>">px</td></tr>
<tr><td>Высота превью картинки галереи</td><td><input name="SGAL_HEIGHT" type="text" style="width: 80%;" value="<?php echo $SGAL_HEIGHT; ?>">px</td></tr>
<tr><td>Цвет полей картинки</td><td>#<input name="GRGB" type="text" style="width: 80%;" value="<?php echo strtoupper(str_pad(dechex($GRGB), 6, "0", STR_PAD_LEFT));  ?>"></td></tr>
<tr><td>Цвет полей картинки превью</td><td>#<input name="SGRGB" type="text" style="width: 80%;" value="<?php echo strtoupper(str_pad(dechex($SGRGB), 6, "0", STR_PAD_LEFT));  ?>"></td></tr>
<tr><td>Водяной знак</td><td><input name="GAL_WATERMARK" type=checkbox value="1"<?php echo $checked?>></td></tr>
<tr><td>Прозрачность водяного знака (0-100)</td><td><input name="GALL_TRANSPARENCY" type="text" style="width: 80%;" value="<?php echo $GALL_TRANSPARENCY; ?>"></td></tr>
<tr><td></td><td><input class="button" type="submit" name="set" value="Отправить"></td></tr>

</table>
</form>
