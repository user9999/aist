<?php if (!defined("ADMIN_SIMPLE_CMS")) { die('Access denied');
} 
if($_POST['db']) {
    $res = mysql_query('SELECT name,model_id,description,keywords,section FROM ".$PREFIX."catalog_items');
    while($row = mysql_fetch_row($res)){
        $res2 = mysql_query("SELECT id,alt FROM ".$PREFIX."catalog_items2 where linked_item='".$row[0]."'");   
        $row2 = mysql_fetch_row($res2);
        if ($row2[1]=='alt=""') {
            $imalt=explode(",", $row[3]);  
            mysql_query("UPDATE ".$PREFIX."catalog_items2 SET alt='alt=\"".$imalt[0]."\"' where id=".$row2[0]);  
        }    
    }
}
if (isset($_FILES['frm_csv']) && $_FILES['frm_csv']['error'] == 0) {
    @unlink("list.csv");
    move_uploaded_file($_FILES['frm_csv']['tmp_name'], "list.csv");
    $dsync = date('U');
    $file = file_get_contents("list.csv") or print("Ошибка загрузки файла.");
    $file = explode("\r\n", $file);
    $i=0;
    foreach ($file as $key => $value) {
        $value = preg_replace("/; /", ";", $value);    
        $value = preg_replace("/;\n/", "//", $value);
        $data = preg_split("/;/", $value);
        $description="";
        if ($i >= 2) {
            $data[1]=str_replace('"', "", $data[1]);
            $description=iconv("windows-1251", "UTF-8", $data[1]);
            $description="<b>".substr($description, 0, strpos($description, ":"))."</b>:<br>".substr($description, strpos($description, ":")+1);
            $d=substr($description, strrpos($description, "\n")+1);
            $d1=substr($description, 0, strrpos($description, "\n")+1);
            if(strpos($d, 'Можно найти по запросам:')!==false) {
                $altnames=substr($d, strpos($d, ":")+1);
                $altnames=explode(",", $altnames);
                $naltnames=array();
                foreach($altnames as $num=>$value){
                        $naltnames[]=" <b>".trim($value)."</b>";
                }
                $alttit=substr($d, 0, strpos($d, ":")+1);
                $naltnames=implode(",", $naltnames);
                $description=$d1.$alttit.$naltnames;
            }
            $description=nl2br($description);
            $description=str_replace(".", ".<br>", $description);
            mysql_query("UPDATE ".$PREFIX."catalog_items2 SET description = '$description' where linked_item = '{$data[0]}'");
        }
        $i++;
    }

}
?>
<br><br>
<h1>Экспорт описаний из CSV</h1>
CSV файл должен содержать 2 столбца: <br>
1 - идентификатор груз-зап <br>
2 - описания
<br>
Описания могут содержать сколько угодно строк, но последняя обязательно должна быть "Альтернативные названия"
<br>
Данная операция может потребовать много времени, если вы загружаете большой CSV-файл.
<br><br>
<form method=post enctype="multipart/form-data">
    <input type=file name=frm_csv> <input type=submit name=update class=button value="Обновить описания">
</form>