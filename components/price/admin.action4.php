<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 

if (isset($_FILES['frm_csv']) && $_FILES['frm_csv']['error'] == 0) {
    @unlink("list.csv");
    move_uploaded_file($_FILES['frm_csv']['tmp_name'], "list.csv");
    
    $dsync = date('U');
    //work with uploaded file
    //$f = fopen("list.csv", "rt") or print("Ошибка загрузки файла.");
    $file = file_get_contents("list.csv") or print("Ошибка загрузки файла.");
    $file = explode("\r\n", $file);
    $i=0;
    foreach ($file as $key => $value) {
        //for ($i = 0; $data = fgetcsv($f, 1000, ";"); $i++) {
        $value = preg_replace("/; /", ";", $value);    
        $value = preg_replace("/;\n/", "//", $value);//%->/
        $data = preg_split("/;/", $value);
        if ($i >= 2) {
            mysql_query("update catalog_items set available='".$data[1]."', price='".$data[2]."',msk=".$data[4].",spb=".$data[3]." where name='".$data[0]."'");
        }
        $i++;
    }
    $upctime=time();
    $update="<?php\n\$PRICEUPDATE=\"".date("Hч. iмин. j.m.Y", $upctime)."\";\n?>";
    $fp=fopen("inc/update.php", "w+");
    fwrite($fp, $update);
    fclose($fp);
    mysql_query("update users set upctime=$upctime");
    include_once "components/price/cache.php";
}
?>

<br /><br />
<h1>Экспорт цен и количества</h1>
CSV файл должен содержать только пять столбцов:<br />
- Уникальный идентификатор<br />
- количество<br />
- Цена<br />
- Количество в Питере<br />
- Количество в Москве<br />
<br />
Данная операция может потребовать много времени, если вы загружаете большой CSV-файл.
<br /><br />
<form method="post" enctype="multipart/form-data">
    <input type="file" name="frm_csv"> <input type="submit" name="update" class="button" value="Обновить позиции">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <!--<input type="submit" name="db" class="button" value="Оптимизировать">-->
</form>
