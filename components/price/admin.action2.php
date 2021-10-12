<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
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
    $r=mysql_query("SELECT name FROM catalog_items where special!=''");
    while($rn=mysql_fetch_row($r)){
        $names[]=$rn[0];
    }
    foreach ($file as $key => $value) {
        //for ($i = 0; $data = fgetcsv($f, 1000, ";"); $i++) {
        $value = preg_replace("/; /", ";", $value);    
        $value = preg_replace("/;\n/", "//", $value);//%->/
        $data = preg_split("/;/", $value);
        if ($i >= 2) {
            //$data[num-col]
            $brand = trim($data[2]);
            $model = trim($data[3]);
            
            if ($brand && $model) {
                //get brand_id
                $res = mysql_query("SELECT id FROM catalog_brands WHERE name = '{$brand}'");
                if ($row = mysql_fetch_row($res)) {
                    $brand_id = $row[0];
                } else {
                    mysql_query("INSERT INTO catalog_brands SET `name` = '$brand'");
                    $brand_id = mysql_insert_id();
                }
                
                //get model id
                $res = mysql_query("SELECT id FROM catalog_models WHERE name = '{$model}' AND brand_id = $brand_id");
                if ($row = mysql_fetch_row($res)) {
                    $model_id = $row[0];
                } else {
                    mysql_query("INSERT INTO catalog_models SET `name` = '$model', `brand_id` = '$brand_id'");
                    $model_id = mysql_insert_id();
                }
                for ($i = 1; $i <= 15; $i++) {
                    $data[$i] = iconv("windows-1251", "utf-8", $data[$i]);
                }

                $data[7] = ereg_replace("[^0-9A-Za-zА-Яа-я \/\.-]", "", $data[7]);
                $data[7] = str_replace("//", ";", $data[7]);//%-/
                $data[7] = str_replace("; ", ";", $data[7]);
                $data[8] = ereg_replace("[^0-9\/]", "", $data[8]);
                $data[8] = str_replace("//", ";", $data[8]);//%-/
                //$data[8]=$data[8].$data[9];
                $data[100] = 1;
                //if (!$data[9]) $data[9] = 100;
                if (!$data[10]) { $data[10] = 100;
                }
                if (!$data[11]) { $data[11] = "";
                }
                if (!$data[12]) { $data[12] = "";
                }
                if (!$data[13]) { $data[13] = $META_KEYWORDS;
                }
                
                if(trim($data[14])=="Кузовные запчасти") {
                    $data[14]=2;
                } elseif(trim($data[14])=="Оптика") {
                    $data[14]=1;                
                } elseif(trim($data[14])=="Аксессуары") {
                    $data[14]=3;                    
                } else {
                    $data[14]=0;                
                }
                $data[5] = trim($data[5]);
                //$res = mysql_query("SELECT COUNT(*) FROM catalog_items WHERE name = '" . trim($data[1]) . "'");// AND country = '{$data[5]}' AND brand_id = $brand_id AND model_id = $model_id");
                $rs = mysql_query("SELECT id FROM catalog_items WHERE name = '" . trim($data[1]) . "'");
                $rows =(mysql_num_rows($rs)>0)?1:0;
                if ($rows == 0) {
                    //echo 'ins<hr>';
                    mysql_query(
                        "INSERT INTO catalog_items SET oem = '" . trim($data[0]) . "', name = '" . trim($data[1]) . "', " .
                        "brand_id = $brand_id, model_id = $model_id, description = '{$data[4]}', model_variants = '{$data[7]}', " .
                        "oem_variants = '{$data[8]}', available = '{$data[9]}', price = '" . ((float) $data[10]) . "', " .
                        "waitingfor = '" . trim($data[11]) . "', " .//"quantity = '" . ((int) $data[10]) . "', 
                        "special = '" . trim($data[12]) . "',keywords='".$data[13]."', syncdate = '" . $dsync . "',  " .
                        "section=".$data[14].", country = '{$data[5]}', provider='{$data[15]}',nova='new'"
                    );
                    //////////////                            
                    $ropt = mysql_query("SELECT id FROM catalog_items2 where linked_item='".trim($data[1]) ."'");  
                      $rwopt = mysql_fetch_row($ropt);
                    if (!$rwopt) {
                        $imalt=explode(",", $data[13]);
                        mysql_query("INSERT INTO catalog_items2 SET name='{$data[4]}',linked_item='" . trim($data[1]) . "',keywords='".$data[13]."',model_id=".$model_id.",section=".$data[14].",alt='alt=\"".$imalt[0]."\"'");  
                    }            
                    //////////////                            
                                
                } else {
                      $qna="";
                    if(trim($data[12])!="" and !in_array(trim($data[1]), $names)) {
                        $qna=",nova='new'";
                    }
                    mysql_query(
                        "UPDATE catalog_items SET oem = '" . trim($data[0]) . "', name = '" . trim($data[1]) . "', " .
                                "brand_id = $brand_id, model_id = $model_id, description = '{$data[4]}', model_variants = '{$data[7]}', " .
                                "oem_variants = '{$data[8]}', available = '{$data[9]}', price = '" . ((float) $data[10]) . "', " .
                                "waitingfor = '" . trim($data[11]) . "', " .//"quantity = '" . ((int) $data[10]) . "',
                                "special = '" . trim($data[12]) . "', keywords='".$data[13]."', syncdate = '" . $dsync . "', provider='{$data[15]}'$qna WHERE " .
                                "name = '" . trim($data[1]) . "'"
                    );// AND country = '{$data[5]}' AND brand_id = $brand_id AND model_id = $model_id");

                    ////////////////////////
                    $ropt = mysql_query("SELECT id FROM catalog_items2 where linked_item='".trim($data[1]) ."'");  
                      $rwopt = mysql_fetch_row($ropt);
                    if (!$rwopt) {
                        $imalt=explode(",", $data[13]);
                        mysql_query("INSERT INTO catalog_items2 SET name='{$data[4]}',linked_item='" . trim($data[1]) . "',keywords='".$data[13]."',model_id=".$model_id.",section=".$data[14].",alt='alt=\"".$imalt[0]."\"'");  
                    }    
                    ////////////////
                }

            }
        }
        $i++;
    }
    if($_POST['update']) {
        mysql_query("DELETE FROM catalog_items WHERE syncdate != '" . $dsync . "'");
    }
    $upctime=time();
    $update="<?php\n\$PRICEUPDATE=\"".date("Hч. iмин. j.m.Y", $upctime)."\";\n?>";
    $fp=fopen("inc/update.php", "w+");
    fwrite($fp, $update);
    fclose($fp);
    include_once "components/price/cache.php";
}
?>

<br /><br />
<h1>Экспорт CSV</h1>
Здесь вы можете выбрать CSV-файл, который будет загружен в базу данных. Обратите внимание, что будет осуществлена загрузка данных только для добавленных брендов. Важно, что все уже имеющиеся записи для загружаемого бренда будут удалены.
<br />
Данная операция может потребовать много времени, если вы загружаете большой CSV-файл.
<br /><br />
<form method="post" enctype="multipart/form-data">
    <input type="file" name="frm_csv" accept=".csv"> <input type="submit" name="update" class="button" value="Обновить позиции">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <!--<input type="submit" name="db" class="button" value="Оптимизировать">-->
</form>
<br>
<a href="http://gruz-zap.ru/admin/?component=news&cmd=send" style="display:block;margin-left:7px;">Опубликовать и разослать</a>

