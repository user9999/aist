<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 

if (!isset($_GET['id'])) { header("Location: " . $GLOBALS['PATH'] . "/404");
}
$arcquery=($_GET['stat']=='archive')?"AND b.waitingfor='архив'":"AND b.waitingfor!='архив'";
$id = mysql_real_escape_string($_GET['id']);

if (strpos($id, "item-") === false && strpos($id, "model-") === false && strpos($id, "section-") === false && strpos($id, "price-") === false) {
    //category
    $res = mysql_query("SELECT id, name, altname FROM catalog_brands WHERE LOWER(`name`) = '$id'");
    if ($row = mysql_fetch_row($res)) {
        if ($row[2]) { $row[1] = $row[2];
        }
        
        set_title($row[1]);
        render_to_template("components/catalog/template.modelsHeader.php", array('title' => $row[1]));
        
        $res2 = mysql_query("SELECT name, image, id FROM catalog_models WHERE brand_id = " . $row[0] . " ORDER BY position");//name
        while ($row2 = mysql_fetch_row($res2)) {
            render_to_template("components/catalog/template.models.php", array('name' => $row2[0], 'image' => $row2[1], 'id' => $row2[2]));
        }

        render_to_template("components/catalog/template.modelsFooter.php", array());
        
    } else { header("Location: " . $GLOBALS['PATH'] . "/404");
    }
    
} elseif (strpos($id, "model-") !== false) {
    //category model
    $idpos = (int) substr($id, 6);
    $res = mysql_query("SELECT a.id, a.name, a.altname, a.showimg, b.name as bname, b.altname as baltname FROM catalog_models AS a, catalog_brands AS b WHERE a.id = '$idpos' AND a.brand_id = b.id");
    if ($row = mysql_fetch_row($res)) {
        if ($row[2]) { $row[1] = $row[2];
        }
        $s = strtolower($row[4]);
        $brandname=$row[4];
        if ($row[5]) { $row[4] = $row[5];
        }
        set_title($row[4] . " " . $row[1]);
        render_to_template("components/catalog/template.userHeader.php", array('title' => "<a href='{$GLOBALS[PATH]}/catalog/$s'>" . $row[4] . "</a> " . $row[1], 'showimg' => $row[3], 'city'=>$_SESSION['actype'][3],'update'=>$_SESSION['update']));
        //get all items from this position
        //authuser
        if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
            $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, e.price, b.quantity,    b.waitingfor, b.description, b.special, b.available, b.country, b.msk, b.spb FROM catalog_items AS b, catalog_models AS c, `price_".$_SESSION['userid']."` AS e WHERE b.model_id = c.id AND b.name=e.name $arcquery AND (b.model_id = " . $idpos . " OR b.model_variants LIKE '%{$row[1]}%') ORDER BY b.description");

        } else {
            $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,    b.waitingfor, b.description, b.special, b.available, b.country, b.msk, b.spb FROM catalog_items AS b, catalog_models AS c WHERE b.model_id = c.id $arcquery AND (b.model_id = " . $idpos . " OR b.model_variants LIKE '%{$row[1]}%') ORDER BY b.description");
        }
        $s = 0;
        while ($row2 = mysql_fetch_row($res2)) {
            $s++;
            if ($row2[4]) { $row2[3] = $row2[4];
            }
            
            $sid = 0;
            $res3 = mysql_query("SELECT * FROM catalog_items2 WHERE linked_item = '{$row2[1]}'");
            if ($r3 = mysql_fetch_row($res3)) {
                $row2[1] = $r3[1];
                $sid = $r3[0];
            }
            //var_dump($row2[9]);
            //скидка 
            $row2[5]=($_SESSION['userid'] && $_SESSION['percent']>0 && $_SESSION['actype'][0]!=1 && $row2[9]=='')?floor($row2[5]*(100-$_SESSION['percent'])/100):$row2[5];
            //скидка
            //валюта
            if($_SESSION['actype'][0]==1 && $_SESSION['actype'][6]==1 && $_COOKIE['currency']=='rub') {
                $res4=mysql_query("select euro,dollar,currency,ratio from currency where id=1");
                $row4=mysql_fetch_array($res4);
                $row2[5]=floor($row4[$row4['currency']]*$row4['ratio']*$row2[5]);
            }
            //валюта
            if($row2[10]>0) {
                $av=0;
            } elseif($row2[7]!="" && $row2[7]!=0) {
                $av=2;
            } else {
                $av=1;
            }
            $msk=($row2[12]>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row2[12];
            $spb=($row2[13]>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row2[13];
            $city=$_SESSION['actype'][3];
            render_to_template("components/catalog/template.user.table.php", array('ftitle' => $row[1], 'btitle' => $row[4], 'id' => $row2[0], 'name' => $row2[1], 'oem' => $row2[2], 'model' => $row2[3], 'price' => $row2[5], 'quantity' => $row2[6], 'description' => $row2[8], 'av' => $av, 'country' => $row2[11], 'sid' => $sid, 'showimg' => $row[3], 'action' => $row2[9], 'city'=>$city, 'msk' => $msk, 'spb' => $spb,'pageid'=>$brandname));
        }
        if ($s == 0) { echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        }
        
        render_to_template("components/catalog/template.tableFooter.php", array());
    } else { header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} elseif (strpos($id, "section-") !== false) {
    //section
    $idpos = (int) substr($id, 8);
    $sections = array("", "Оптика", "Кузовные запчасти", "Аксессуары"); 

    if (array_key_exists($idpos, $sections)) {
        set_title($sections[$idpos]);
        render_to_template("components/catalog/template.userHeader.php", array('title' => $sections[$idpos], 'tt' => 1, 'showimg' => 1, 'city'=>$_SESSION['actype'][3],'update'=>$_SESSION['update']));
        //get all items from this position
        //$res2 = mysql_query("SELECT a.id, a.oem, a.name, a.description, b.name AS brand, a.price, a.quantity, b.altname AS altbrand 6 FROM catalog_items AS a, 8 catalog_models AS b WHERE a.brand_id = {$row[0]} AND b.id = a.model_id");
        if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
            $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, e.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname, b.msk, b.spb FROM catalog_items AS b, catalog_models AS c, catalog_brands AS d, `price_".$_SESSION['userid']."` AS e  WHERE b.model_id = c.id AND b.brand_id = d.id AND b.name=e.name $arcquery AND b.section = " . $idpos . " ORDER BY d.name,c.name,b.description");
        } else {
            $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname, b.msk, b.spb FROM catalog_items AS b, catalog_models AS c, catalog_brands AS d WHERE b.model_id = c.id AND b.brand_id = d.id $arcquery AND b.section = " . $idpos . " ORDER BY d.name,c.name,b.description");
        }
        //echo "SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname, b.msk, b.spb FROM catalog_items AS b, catalog_models AS c, catalog_brands AS d WHERE b.model_id = c.id AND b.brand_id = d.id AND b.section = " . $idpos . " ORDER BY d.name,c.name,b.description";
        $s = 0;
        while ($row2 = mysql_fetch_row($res2)) {
            $s++;
            if ($row2[4]) { $row2[3] = $row2[4];
            }
            
            //скидка 
            $row2[5]=($_SESSION['userid'] && $_SESSION['percent']>0 && $_SESSION['actype'][0]!=1 && $row2[9]=='')?floor($row2[5]*(100-$_SESSION['percent'])/100):$row2[5];
            //скидка
            //валюта
            if($_SESSION['actype'][0]==1 && $_SESSION['actype'][6]==1 && $_COOKIE['currency']=='rub') {
                $res4=mysql_query("select euro,dollar,currency,ratio from currency where id=1");
                $row4=mysql_fetch_array($res4);
                $row2[5]=floor($row4[$row4['currency']]*$row4['ratio']*$row2[5]);
            }
            //валюта
            $sid = 0;
            $res3 = mysql_query("SELECT * FROM catalog_items2 WHERE linked_item = '{$row2[1]}'");
            if ($r3 = mysql_fetch_row($res3)) {
                $row2[1] = $r3[1];
                $sid = $r3[0];
            }
            if($row2[10]>0) {
                $av=0;
            } elseif($row2[7]!="" && $row2[7]!=0) {
                $av=2;
            } else {
                $av=1;
            }    
            $city=$_SESSION['actype'][3];
            $msk=($row2[12]>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row2[12];
            $spb=($row2[13]>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row2[13];
            render_to_template("components/catalog/template.user.table.php", array('id' => $row2[0], 'name' => $row2[1], 'btitle' => $row2[11],'ftitle' => $row2[3], 'oem' => $row2[2], 'model' => $row2[3], 'price' => $row2[5], 'quantity' => $row2[6], 'description' => $row2[8], 'av' => $av, 'country' => $row2[12],'sid' => $sid, 'mlinks'=>1, 'action' => $row2[9], 'showimg' => 1,'city'=>$city, 'msk' => $msk, 'spb' => $spb));
        }
        if ($s == 0) { echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        }
        
        render_to_template("components/catalog/template.tableFooter.php", array());
    } else { header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} elseif (strpos($id, "item-") !== false) {
    //item
    $idpos = (int) substr($id, 5);
    include_once "inc/users.configuration.php";
    $active=time()-($RESERVE*60*60);
    
    //$res = mysql_query("SELECT a.*, b.name as model, b.altname as altmodel, c.name as brand, c.altname as altbrand FROM catalog_items AS a, catalog_models AS b, catalog_brands AS c WHERE a.id = $idpos AND a.model_id = b.id AND a.brand_id = c.id");

    $res = mysql_query("SELECT a.id as aid, a.name as aname, a.description as adescription, a.alt, a.keywords as akeywords, b.*, c.name as model, c.altname as altmodel, d.name as brand, d.altname as altbrand FROM catalog_items2 AS a, catalog_items AS b, catalog_models AS c, catalog_brands AS d WHERE  a.linked_item = b.name AND b.model_id = c.id AND c.brand_id = d.id AND a.id = {$idpos}");

    if ($row = mysql_fetch_array($res)) {
        $res2=mysql_query("SELECT amount,user_id,add_date from reserved where  add_date>".$active." and gruz_id='".$row['name']."'");//user_id='".$_SESSION['userid']."' and  limit 1
        $row['resamount']=0;
        while($row2=mysql_fetch_row($res2)){
            //echo "SELECT amount from reserved where user_id='".$_SESSION['userid']."' and add_date>".$active." and gruz_id='".$row['name']."'";
            if($row2[1]==$_SESSION['userid']) {
                 $row['amount']=$row2[0];
            }
            $resamnt+=$row2[0];
        }
        if($_SESSION['actype'][4]==1) {
            $row['resamount']=$resamnt;
        }
        //echo "==".$row2[0];
        //скидка 

      
        $row['price']=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1 && $row['special']=='')?floor($row['price']*(100-$_SESSION['percent'])/100):$row['price'];
        //скидка 

      
        if($row['special']!='') {
            $row['special_price']=$row['price'];
            $spec=preg_replace('/[^0-9]/', '', $row['special']);
            $row['price']=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?floor($spec*(100-$_SESSION['percent'])/100):$spec;
   
        }
    
        
        
        if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
            $res3 = mysql_query("SELECT price from `price_".$_SESSION['userid']."` where name='".$row['name']."' limit 1");
            $row3 = mysql_fetch_array($res3);
            if($row3[0]) {
                $row['price']=$row3[0];
            } else {
                $useritem=1;
            }
        }
    

    
    
        //валюта
        if($_SESSION['actype'][0]==1 && $_SESSION['actype'][6]==1 && $_COOKIE['currency']=='rub') {
            $res4=mysql_query("select euro,dollar,currency,ratio from currency where id=1");
            $row4=mysql_fetch_array($res4);
            $row['price']=floor($row4[$row4['currency']]*$row4['ratio']*$row['price']);
        }
        //валюта
        $row['useritem']=$useritem;
        $row['city']=$_SESSION['actype'][3];
        set_title($row[1]);
        set_meta($row['akeywords'], $row['aname'] . " - " . $row['description']);
            //var_dump($row);
        $row['RESERVE']=$RESERVE;
        $row['msk']=($row['msk']>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row['msk'];
        $row['spb']=($row['spb']>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row['spb'];
        render_to_template("components/catalog/template.userItem.php", $row);
        
        $v = explode(";", $row['oem_variants']);
        $v[] = $row['oem'];
        $qs = "AND (1 = 0 ";//1 = 0
        foreach ($v as $k) {
            if ($k) {
                $qs .= "OR b.oem = '$k' ";
                $qs .= "OR b.oem_variants LIKE '%$k%' ";
            }
        }
        $qs .= ")";
        
        //show similar
        $similar_arr = array();
        
        
                $res2 = mysql_query(
                    "SELECT b.id AS bid, b.name AS bname, a.id, a.name AS position_name, b.oem, b.msk, b.spb, c.name AS modelname, 
							c.altname AS altmodelname, c.showimg, b.price, b.quantity, b.description,b.waitingfor, d.name AS brandname, d.altname AS 
							altbrandname, b.av, b.country FROM catalog_models AS c, catalog_brands AS d, catalog_items AS b 
							LEFT JOIN catalog_items2 AS a ON b.name = a.linked_item 
							WHERE b.model_id = c.id AND b.brand_id = d.id AND b.id != {$row['id']} 
							$qs 
							ORDER BY RAND() LIMIT 3"
                );//AND b.quantity != 0
        
        

        while ($row2 = mysql_fetch_array($res2)) {
            if ($row2[3]) { $row2[1] = $row2[3];
            }
            if ($row2[15]) { $row2[14] = $row2[15];
            }
            if ($row2[8]) { $row2[7] = $row2[8];//($row2[6]) $row2[5] = $row2[6];
            }
            
            if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
            
                 $res3=mysql_query("select price from `price_".$_SESSION['userid']."` where name='{$row2['bname']}' limit 1");
                 //echo "select price from `price_".$_SESSION['userid']."` where name='{$row2['bname']}' limit 1";
                 $row3 = mysql_fetch_array($res3);
                 $row2['price']=$row3['price'];
            }
            $row2['price']=($_SESSION['userid'] && $_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?floor($row2['price']*(100-$_SESSION['percent'])/100):$row2['price'];
            $row2['city'] = $_SESSION['actype'][3];            
            $similar_arr[] = $row2;

        }    

        render_to_template("components/catalog/template.userSimilar.php", $similar_arr);            
        
    } else { header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} else {
    //item
    $idpos = (int) substr($id, 6);
    
    $res = mysql_query("SELECT a.*, b.name AS brand, c.name AS model, b.altname AS altbrand, c.altname AS altmodel FROM catalog_items AS a, catalog_brands AS b, catalog_models AS c WHERE a.id = {$idpos} AND a.brand_id = b.id AND a.model_id = c.id");
    if ($row = mysql_fetch_array($res)) {
        set_title($row['name']);
        set_meta($row['description'], $row['aname'] . " - " . $row['description']);
        render_to_template("components/catalog/template.showPrice.php", $row);
        
        $v = explode(";", $row['oem_variants']);
        $v[] = $row['oem'];
        $qs = "AND (1 = 0 ";//1 = 0
        foreach ($v as $k) {
            if ($k) {
                $qs .= "OR b.oem = '$k' ";
                $qs .= "OR b.oem_variants LIKE '%$k%' ";
            }
        }
        $qs .= ")";
        
        //show similar
        $similar_arr = array();
        $res2 = mysql_query(
            "SELECT b.id AS bid, b.name AS bname, a.id, a.name AS position_name, b.oem, c.name AS modelname, 
							c.altname AS altmodelname, b.price, b.quantity, b.description, d.name AS brandname, d.altname AS 
							altbrandname, b.av, b.country FROM catalog_models AS c, catalog_brands AS d, catalog_items AS b
							LEFT JOIN catalog_items2 AS a ON b.name = a.linked_item 
							WHERE b.model_id = c.id AND b.brand_id = d.id AND b.id != {$row['id']} 
							$qs 
							ORDER BY RAND() LIMIT 3"
        );//AND b.quantity != 0
                            
        while ($row2 = mysql_fetch_array($res2)) {
            if ($row2[3]) { $row2[1] = $row2[3];
            }
            if ($row2[6]) { $row2[5] = $row2[6];
            }
            $similar_arr[] = $row2;
        }    
        render_to_template("components/catalog/template.showSimilar.php", $similar_arr);            
        
    } else { header("Location: " . $GLOBALS['PATH'] . "/404");
    }
}
?>


