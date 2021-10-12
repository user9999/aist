<?php if (!defined("ADMIN_SIMPLE_CMS")) { die('Access denied');
}
if($_GET['cmd']=='partner') {
    include_once 'partneryml.php';
}
if(isset($_FILES['frm_csv']) && $_FILES['frm_csv']['error']==0) {
    @unlink("list.csv");
    move_uploaded_file($_FILES['frm_csv']['tmp_name'], 'list.csv');
    $dsync=date('U');
    $file=file_get_contents('list.csv') or print('Ошибка загрузки файла.');
    $file=explode("\r\n", $file);
    $i=0;
    foreach($file as $key=>$value){
        $value=preg_replace("/; /", ";", $value);
        $value=preg_replace("/;\n/", "//", $value);
        $data=preg_split("/;/", $value);
        if($i>=2) {
            mysql_query("update ".$PREFIX."catalog_items set available='".$data[1]."', price='".$data[2]."',msk=".$data[4].",spb=".$data[3].",opt='".$data[5]."' where name='".$data[0]."'");
        }
        $i++;
    }
    $upctime=time();
    $update="<?php\n\$PRICEUPDATE=\"".date("Hч. iмин. j.m.Y", $upctime)."\";\n?>";
    $fp=fopen("inc/update.php", "w+");
    fwrite($fp, $update);
    fclose($fp);
    mysql_query('update '.$PREFIX.'users set upctime='.$upctime);
    include 'components/price/cache.php';
}
?>
<br><br>
<h1>Экспорт цен и количества</h1>
CSV файл должен содержать только шесть столбцов:<br>
- Идентификатор груз-зап<br>
- количество<br>
- Цена<br>
- Количество в Питере<br>
- Количество в Москве<br>
- Оптовая цена<br>
<br>
Данная операция может потребовать много времени, если вы загружаете большой CSV-файл.
<br><br>
<form method=post enctype="multipart/form-data">
<input type=file name=frm_csv> <input type=submit name=update class=button value="Обновить позиции">
</form>
<br>
<a href="?component=price&action=3&cmd=partner">обновить информацию для партнеров</a>