<?php
if($_POST['massfoto']) {
    if(glob("uploaded/characteristics/*.*")) {
    
        foreach(glob("uploaded/characteristics/*.*") as $char){
             $output="<table class=characteristic>";
             $fid=str_replace("uploaded/characteristics/", "", $char);
             $tid=str_replace(".csv", "", $fid);
             //echo $tid;
             $file = file_get_contents($char) or print("Ошибка загрузки файла.");
             $file = explode("\r\n", $file);
            foreach ($file as $key => $value) {
                $value = preg_replace("/; /", ";", $value);    
                $value = preg_replace("/;\n/", "//", $value);//%->/
                $data = preg_split("/;/", $value);
                for ($i = 1; $i <= 3; $i++) {
                     $data[$i] = iconv("windows-1251", "utf-8", $data[$i]);
                }
                $characters = trim($data[2]);
                $val = trim($data[3]);
                //var_dump($characters);echo "<br><hr>";
                if($characters!='0' && $characters!='') {
                    //echo $characters."<br>";
                    $output.="<tr><td>$characters</td><td>$val</td></tr>";
                }
            }

            $output.="</table>";
            $res=mysql_query("select id from catalog_items2 where linked_item='{$tid}' limit 1");
            if(mysql_num_rows($res)==1) {
                mysql_query("update catalog_items2 set characteristics='{$output}' where linked_item='{$tid}'");
                unlink($char);
            } else {
                echo "<br>".$fid." - товар не найден";
            }
        }
        echo "<br> Обработано!";
    }
    
}

?>
<br /><br />
<h1>Обработка Характеристик</h1>
<?php
if(glob("uploaded/characteristics/*.*")) {
    ?>
<form method="post"><input type="submit" name="massfoto" value="Обработать файлы" class="button" style="cursor:pointer" /></form>
    <?php
} else {
    echo "загрузите файлы csv в папку uploaded/characteristics/
	<p>Файлы должны быть вида: внутренний-id.csv</p>
";
}
//echo $output;
?>
