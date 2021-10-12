<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
if($_POST['db']) {
    $res = mysql_query("SELECT name,model_id,description,keywords,section FROM catalog_items");
    while($row = mysql_fetch_row($res)){
        //$res2 = mysql_query("SELECT id FROM catalog_items2 where linked_item='".$row[0]."'");
        $res2 = mysql_query("SELECT id,alt FROM catalog_items2 where linked_item='".$row[0]."'");   
        $row2 = mysql_fetch_row($res2);
        if ($row2[1]=='alt=""') {
            $imalt=explode(",", $row[3]);  
            mysql_query("UPDATE catalog_items2 SET alt='alt=\"".$imalt[0]."\"' where id=".$row2[0]);  
        }    
        /*   
        if (!$row2) {
        $imalt=explode(",",$row[3]);
        //var_dump($imalt);
        $res3 = mysql_query("INSERT INTO catalog_items2 SET name='".$row[2]."',linked_item='".$row[0]."',keywords='".$row[3]."',model_id=".$row[1].",section=".$row[4].",alt='alt=\"".$imalt[0]."\"'");  
        //echo "INSERT INTO catalog_items2 SET name='".$row[2]."',linked_item='".$row[0]."',keywords='".$row[3]."',model_id=".$row[1].",section=".$row[4].",alt='alt=\"".$imalt[0]."\"'<br>";
        }
        */
    }
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
        
        $description="";
        if ($i >= 2) {

            //echo "<br>".$i;
            //$data[num-col]
            if(strlen($data[1])>1) {
                 $data[1]=str_replace('"', "", $data[1]);
                 $description=iconv("windows-1251", "UTF-8", $data[1]);
                if(strstr($description, ":")) {
                    $description="<b>".substr($description, 0, strpos($description, ":"))."</b>:<br>".substr($description, strpos($description, ":")+1);
                }
                 $description=nl2br($description);
                 $description=str_replace(".", ".<br>", $description);
            } else {
                 $description="";
            }
            
            mysql_query("UPDATE catalog_items2 SET description = '$description' where linked_item = '{$data[0]}'");
            //echo "UPDATE catalog_items2 SET description = '$description' where linked_item = '{$data[0]}'<br />";

        }
        $i++;
    }

}
?>

<br /><br />
<h1>Экспорт описаний из CSV</h1>
CSV файл должен содержать 2 столбца: <br />
1 - идентификатор <br />
2 - описания
<br />
Описания могут содержать сколько угодно строк, но последняя обязательно должна быть "Альтернативные названия"
<br />
Данная операция может потребовать много времени, если вы загружаете большой CSV-файл.
<br /><br />
<form method="post" enctype="multipart/form-data">
    <input type="file" name="frm_csv"> <input type="submit" name="update" class="button" value="Обновить описания">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <!--<input type="submit" name="db" class="button" value="Оптимизировать">-->
</form>
