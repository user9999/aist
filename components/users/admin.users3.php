<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
if($_POST['price']) {
    include_once "inc/mail.system.templates.php";
    $remusers="<?php\r\n\$users2remember=array(";
    $replacearray=array('{:sitetitle:}','{:url:}','{:password:}','{:username:}','{:userid:}','{:usermail:}','{:userpercent:}','{:usermoney:}','{:useramount:}','{:userdata:}','{:actions:}');
    foreach($_POST['user'] as $num=>$value){
        if($_POST['remember']==1) {
            $remusers.="'".$num."',";
        }
        $csv[0]="OEM;ID;Марка;Модель;Наименование;Производитель;Модель /варианты/;OEM /варианты/;Наличие;Цена,руб;Акции;Заказ;\r\n";
        $csv[0].=";;;;;;;;\r\n";
        $res=mysql_query("select * from ".$PREFIX."users where id='".$num."' limit 1");
        $row=mysql_fetch_array($res);
    
        $newvalues=array($PAGE_TITLE,$PATH,'',$row['name'],$row['id'],$row['email'],$row['percent'],$row['money'],$row['amount'],$row['udata'],'');
        $ltitle=str_replace($replacearray, $newvalues, $mailsystemtemplates['price'][0]);
        $mess=str_replace($replacearray, $newvalues, $mailsystemtemplates['price'][1]);
    
        $res1=mysql_query("select a.*,b.oem,b.name as gruzname,b.description,b.model_variants,b.oem_variants,b.available,b.price as allprice,b.special,b.country,c.name as brandname,c.altname as altbrandname,d.name as modelname,d.altname as altmodelname from `".$PREFIX."price_".$row[0]."` AS a,".$PREFIX."catalog_items as b,".$PREFIX."catalog_brands as c, ".$PREFIX."catalog_models as d where a.name=b.name AND b.brand_id=c.id AND b.model_id=d.id order by c.name,d.name,b.description");
        //echo "select a.*,b.oem,b.description,b.available,b.price as allprice,b.special,b.country,c.name as brandname,c.altname as altbrandname,d.name as modelname,d.altname as altmodelname from `price_".$row[0]."` AS a,catalog_items as b,catalog_brands as c, catalog_models as d where a.name=b.name AND b.brand_id=c.id AND b.model_id=d.id order by c.name,d.name,b.description";
        //die();
        while($row1=mysql_fetch_array($res1)){
            $brand=($row1['altbrandname'])?$row1['altbrandname']:$row1['brandname'];
            $model=($row1['altmodelname'])?$row1['altmodelname']:$row1['modelname'];
            $price=($row1['price'])?$row1['price']:$row1['allprice'];
            $amount=($row1['available']>5)?"более 5":$row1['available'];
            $model_variants='"'.str_replace(";", ";\n", $row1['model_variants']).'"';
            $oem_variants='"'.str_replace(";", ";\n", $row1['oem_variants']).'"';
            $csv[0].=$row1['oem'].";".$row1['gruzname'].";".$brand.";".$model.";".$row1['description'].";".$row1['country'].";".$model_variants.";".$oem_variants.";".$amount.";".$price.";".$row1['special'].";;\r\n";
        }
        $csv[0].=";;;;;;;;\r\n";
        $csv[0].=";;;;;".$SITE_TITLE.";".$PATH.";;\r\n";
        $csv[0]=iconv("utf-8", "windows-1251", $csv[0]);
      
        $csvsize=mb_strlen($csv[0], '8bit');
        //echo $num.".csv fs=".filesize($num.".csv").", str=".$csvsize."<br>";
        //echo $num." => ".$value."<br>";

        $doing=multi_attach_mail($row['email'], $csv, $ADMIN_EMAIL, "price.csv", $csvsize, $ltitle, $mess);
        //echo $doing;
    }
    $remusers=substr($remusers, 0, -1).");\r\n?>";
    if($_POST['remember']==1) {
        $fp=fopen("inc/rememberusers.php", "w+");
        fwrite($fp, $remusers);
        fclose($fp);
    }

}
if (isset($_FILES['frm_csv']) && $_FILES['frm_csv']['error'] == 0 && $_GET['id']) {
    $updtime=time();
    @unlink("list.csv");
    move_uploaded_file($_FILES['frm_csv']['tmp_name'], "list.csv");

    $file = file_get_contents("list.csv") or print("Ошибка загрузки файла.");
    $file = explode("\r\n", $file);
    $i=0;
    foreach ($file as $key => $value) {

        $value = preg_replace("/; /", ";", $value);    
        $value = preg_replace("/;\n/", "//", $value);//%->/
        $data = preg_split("/;/", $value);
        if ($i >= 2) {
            $res3=mysql_query("select price from ".$PREFIX."price_".$_GET['id']." where name='".$data[0]."' limit 1");
      
            if(mysql_num_rows($res3)==1) {
                //echo $i."<br>";
                mysql_query("update ".$PREFIX."price_".$_GET['id']." set price='".$data[1]."' where name='".$data[0]."'");
                mysql_query("update ".$PREFIX."users set updtime=$updtime where id='".$_GET['id']."'");
            } else {
                mysql_query("insert into ".$PREFIX."price_".$_GET['id']." set name='".$data[0]."',price='".$data[1]."'");  
                mysql_query("update ".$PREFIX."users set updtime=$updtime where id='".$_GET['id']."'");   
            }

        }
        $i++;
    }

} elseif(isset($_FILES['frm_csv']) && $_FILES['frm_csv']['error'] == 0) {
    $updtime=time();
    @unlink("list.csv");
    move_uploaded_file($_FILES['frm_csv']['tmp_name'], "list.csv");

    $file = file_get_contents("list.csv") or print("Ошибка загрузки файла.");
    $file = explode("\r\n", $file);
    $i=0;//$flag=0;
    foreach ($file as $key => $value) {
        $value = preg_replace("/; /", ";", $value);    
        $value = preg_replace("/;\n/", "//", $value);//%->/
        $data = preg_split("/;/", $value);
        //$j=0;
        
        if($i==0) {
            for($j=0;$j<count($data);$j++){
                if($j>0) {
                    $flag[$j]=0;
                    $company=iconv("windows-1251", "utf-8", $data[$j]);
                    $uid=translitIt($company);
                    $tables[$j]=$PREFIX."price_".$uid;
                    mysql_query("Show tables from $DATABASE_NAME like '".$tables[$j]."'");
                    if(mysql_num_rows($res)==0) {
                        $query="CREATE TABLE `".$tables[$j]."` (`name` varchar(255) NOT NULL,`price` text NOT NULL, PRIMARY KEY (`name`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";
                        mysql_query($query); 
                        mysql_query("INSERT INTO ".$PREFIX."users SET id='$uid', company='".$company."', actype='100',updtime=$updtime");

                    }
                }
            }
        }
        if($i>2) {
        
        
        
        
            for($j=1;$j<count($data);$j++){
                if($data[$j]!="") {
                    if($flag[$j]==0) {
                         //echo "delete from `".$tables[$j]."`<br>";
                           mysql_query("delete from `".$tables[$j]."`");
                           $flag[$j]=1;
                    }
                    //echo "INSERT INTO `$tables[$j]` set name='".iconv("windows-1251","utf-8",$data[0])."', price='".$data[$j]."'";
                    mysql_query("INSERT INTO `$tables[$j]` set name='".iconv("windows-1251", "utf-8", $data[0])."', price='".$data[$j]."'");
          
                    //echo "INSERT INTO $tables[$j] set name='".iconv("windows-1251","utf-8",$data[0])."', price='".$data[$j]."'";
                    //die();
                }
            }
        }
        $i++;
    }
    //var_dump($tables);
    //die();

    
}
if($_GET['id']) {
    $res2=mysql_query("select * from ".$PREFIX."users where id='".$_GET['id']."' limit 1");
    $row2=mysql_fetch_row($res2);
    $row2[2]=($row2[3])?$row2[3]:$row2[2];
    if(strlen($row2[1])>6) {
        echo "<br /><br /><h3 style=\"font-weight:bold\">Прайс-лист для ".$row2[2]."</h3><br />";
        ?>
CSV файл должен содержать только два столбца:<br />
- Уникальны идентификатор<br />
- Цена<br />
<br />
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="frm_csv"> <input type="submit" name="update" class="button" value="Обновить Прайс-лист">
</form>
        <?php
    }
} else {
    echo "<br /><br /><h3 style=\"font-weight:bold\">Общий прайс-лист</h3><br />";
    ?>
Первым столбцом CSV файла должен быть уникальный ID<br />

<br />
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="frm_csv"> <input type="submit" name="update" class="button" value="Обновить Прайс-лист">
</form>
    <?php
}

$tb="<br /><br /><form method=\"post\"><table width=50%><caption style=\"font-weight:bold\">Заливка индивидуальных прайс-листов</caption>";
$res=mysql_query("Show tables from $DATABASE_NAME like '".$PREFIX."price_%'");
if(file_exists("inc/rememberusers.php")) {
    include_once "inc/rememberusers.php";
}
while($row=mysql_fetch_row($res)){
    $userid=str_replace("price_", "", $row[0]);
    $res1=mysql_query("select * from users where id='".$userid."' limit 1");
    $row1=mysql_fetch_row($res1);
    $row1[2]=($row1[3])?$row1[3]:$row1[2];
    $checked=(in_array($userid, $users2remember))?"checked ":"";
    $tb.="<tr><td><input type=\"checkbox\" name=\"user[".$userid."]\" value=\"1\"$checked /></td><td>$row1[2]</td><td><a href=\"/admin/?component=users&action=3&id=".$userid."\">Залить</a></td><tr>";
}
$tb.="<tr><td></td><td><input type=\"submit\" name=\"price\" value=\"Разослать прайс-листы\" class=\"button\" /></td><td>Запомнить <input type=\"checkbox\" name=\"remember\" value=\"1\" /></td></tr></table></form>";
echo $tb;
?>
