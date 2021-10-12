<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
}
if (!isset($_GET['id'])) {
    header("HTTP/1.0 404 Not Found");
    header("Location: " . $GLOBALS['PATH'] . "/404");
}

if((strpos($_GET['id'], "item-")!==false && (strlen($_GET['b'])<2 || strlen($_GET['t'])<2)) || strpos($_GET['id'], "price-")!==false) {
    header("HTTP/1.0 404 Not Found");
    include "components/404/template.404.php";
    $PAGE_BODY = ob_get_contents();
    ob_clean();
    if (file_exists("templates/$TEMPLATE/$component.template.php")) {
        include "templates/$TEMPLATE/$component.template.php";
    } else {
        include "templates/$TEMPLATE/template.php";
    }
    die();
}
$rusmodels=Array();
$brnds=Array();$mdls=Array();$rusbrnds=Array();$brurls=Array();$mdurls=Array();
$resb=mysql_query("SELECT name,altname,rusname FROM ".$PREFIX."catalog_brands WHERE name!=''");
while($rowb=mysql_fetch_row($resb)){
    $brnd=($rowb[1])?$rowb[1]:$rowb[0];
    $brnds[]=$brnd;
    $rusbrnds[$brnd]=$rowb[2];
    $brurls[$brnd]=$rowb[0];
}
$resm=mysql_query("SELECT id,name,altname,rusname FROM ".$PREFIX."catalog_models WHERE name!=''");
while($rowm=mysql_fetch_row($resm)){
    $mdl=($rowm[2])?$rowm[2]:$rowm[1];
    $mdls[]=$mdl;
    $mdurls[$mdl]=$rowm[0];
    if($rowm[3]!="") {
        $rusmodels[$mdl]=$rowm[3];
    }
}
$arcquery=($_GET['stat']=='archive')?"AND b.waitingfor='архив'":"AND b.waitingfor!='архив'";
$id=mysql_real_escape_string($_GET['id']);
if(strpos($id, "item-")===false && strpos($id, "model-")===false && strpos($id, "section-")===false && strpos($id, "price-")===false && strpos($id, "plastic")===false && strpos($id, "catalog")===false && strpos($id, "bamper")===false && strpos($id, "wings")===false && strpos($id, "cowl")===false && strpos($id, "grille")===false && strpos($id, "step")===false) {
    //category

    $res = mysql_query("SELECT id,name,altname FROM ".$PREFIX."catalog_brands WHERE LOWER(`name`)='$id'");
    if($row=mysql_fetch_row($res)) {
        $res3=mysql_query("SELECT keywords,meta_description FROM ".$PREFIX."static WHERE path='$id' limit 1");
        $row3=mysql_fetch_row($res3);
        if($row[2]) { $row[1]=$row[2];
        }
        set_title("Запчасти ".$row[1]);
        set_meta($row3[0], $row3[1]);
        render_to_template("components/catalog/template.modelsHeader.php", array('title'=>$row[1]));
        $res2=mysql_query("SELECT name, image, id FROM ".$PREFIX."catalog_models WHERE brand_id=".$row[0]." ORDER BY position");
        while($row2=mysql_fetch_row($res2)){
            render_to_template("components/catalog/template.models.php", array('name'=>$row2[0],'image'=>$row2[1],'id'=>$row2[2]));
        }
        render_to_template("components/catalog/template.modelsFooter.php", array());
    } else {
        header("HTTP/1.0 404 Not Found");
        header("Location: ".$GLOBALS['PATH']."/404");
    }
} elseif(strpos($id, "catalog")!==false) {
    set_title("Каталог запчастей");
    render_to_template("components/catalog/template.modelsHeader.php", array('tt'=>1,'title'=>'Каталог'));
    $res=mysql_query('select id,name,altname from ".$PREFIX."catalog_brands where showmenu=1 order by position');
    while($row=mysql_fetch_row($res)){
        $name=($row[2])?$row[2]:$row[1];
        $img=(file_exists('img/icons/'.$row[0].'.jpg'))?'img/icons/'.$row[0].'.jpg':'/img/icons/default.jpg';
        render_to_template("components/catalog/template.brands.php", array('name'=>$name,'image'=>$img,'id'=>$row[1]));
    }  
    render_to_template("components/catalog/template.modelsFooter.php", array());
} elseif(strpos($id, "model-")!==false) {
    //die( "here");

    if(file_exists("inc/country_order.php")) {
        //$country_order=array("Тайвань","Россия","Китай");
        include "inc/country_order.php";
        if($country_order) {
            $qco=",CASE b.country ";
            foreach($country_order as $cntry=>$num){
                $qco.="WHEN '$cntry' THEN $num ";
            }
            $qco.="ELSE 99 END";
        } else {
            $qco="";
        }
        //echo $qco;
        //category model
    }


    $idpos= (int) substr($id, 6);
    $res=mysql_query("SELECT a.id,a.name,a.altname,a.showimg,b.name as bname,b.altname as baltname FROM ".$PREFIX."catalog_models AS a, ".$PREFIX."catalog_brands AS b WHERE a.id = '$idpos' AND a.brand_id = b.id");
    if($row=mysql_fetch_array($res)) {
        if($row[2]) { $row[1]=$row[2];
        }
        $s=strtolower($row[4]);
        if($row[5]) { $row[4]=$row[5];
        }
        set_title("Запчасти к ".$row[4]." ".$row[1], 0);
        set_meta("запчасти ".$row[4]." ".$row[1].", бампер ".$row[4].", бампер ".$row[4]." ".$row[1].", капот ".$row[4].", капот ".$row[4]." ".$row[1].", фара ".$row[4].", крыло ".$row[4].", решетка радиатора ".$row[4].",подножка ".$row[4].", продолжение двери ".$row[4].", угол кабины ".$row[4], "Кузовные запчасти к ".$row[4]." ".$row[1].": бампера, капоты, фары, крылья, подножки");
        $row['title']="Кузовные запчасти к ".$row[4]." ".$row[1];
        render_to_template("components/catalog/template.tableHeader.php", $row);
        //$res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.country,a.description as material FROM catalog_items2 AS a,catalog_items AS b, catalog_models AS c WHERE a.linked_item=b.name and b.model_id = c.id $arcquery AND (b.model_id = " . $idpos . " OR b.model_variants LIKE '%{$row[1]}%') ORDER BY b.description,b.oem,b.country DESC");//CASE id WHEN 1 THEN 1WHEN 4 THEN 2 WHEN 2 THEN 3 ELSE 99 END
        $res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname, b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.country,a.description as material FROM ".$PREFIX."catalog_items2 AS a,".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c WHERE a.linked_item=b.name and b.model_id = c.id $arcquery AND (b.model_id = " . $idpos . " OR b.model_variants LIKE '%{$row[1]}%') ORDER BY b.description,b.oem $qco");

        $s = 0;
        $pre=0;$prerow2=array();
        //$pos=0;
        $flag=0;
        
        while($row2=mysql_fetch_row($res2)){
            //последнее вхождение подумать
        
            if(($row2[2] && $prerow2[2] && $prerow2[2]!=$row2[2]) || $row2[2]=='') {//oem  не равны

                 $s++;
                if($prerow2[4]) { $prerow2[3]=$prerow2[4];
                }
                $sid=0;
                $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item='{$prerow2[1]}'");
            
            
                if($r3=mysql_fetch_row($res3)) {
                    $prerow2[1]=$r3[1];
                    $sid=$r3[0];
                }
                if($prerow2[10]>0) {
                    $av=0;
                } elseif($prerow2[7]!="" && $prerow2[7]!=0) {
                    $av=2;
                } else {
                    $av=1;
                }
                //$last=($flag==1)?1:0;
                //$last=($pos)?1:0;
                //$cur=0;
            
                if($flag==1) {
                    $ftitle[]=$row[1];
                    $btitle[]= $row[4];
                    $detid[]=$prerow2[0];
                    $name[]=$prerow2[1];
                    $oem[]=$prerow2[2];
                    $model[]=$prerow2[3];
                    $price[]=$prerow2[5];
                    //$nextprice=$row2[5];
                    $quantity[]=$prerow2[6];
                    $description[]=$prerow2[8];
                    $avar[]=$av;
                    $country[]=$prerow2[11];
                    $asid[]=$sid;
                    $showimg[]=$row[3];
                    $action[]=$prerow2[9];
                    //$flag=0;
                    //$last=$last;
                    $material[]=$prerow2[12];
                } else {
                    $ftitle=$row[1];
                    $btitle= $row[4];
                    $detid=$prerow2[0];
                    $name=$prerow2[1];
                    $oem=$prerow2[2];
                    $model=$prerow2[3];
                    $price=$prerow2[5];
                    //$nextprice=$row2[5];
                    $quantity=$prerow2[6];
                    $description=$prerow2[8];
                    $av=$av;
                    $country=$prerow2[11];
                    $asid=$sid;
                    $showimg=$row[3];
                    $action=$prerow2[9];
                    //$flag=0;
                    //$last=$last;
                    $material=$prerow2[12];
                }
                //$prerow2[5]=($prerow2[5]!=$row2[5])?$prerow2[5]." - ".$row2[5]:$row2[5];
                render_to_template("components/catalog/template.tableIn.php", array('tabindex'=>$s,'ftitle'=>$ftitle,'btitle'=> $btitle,'id'=>$detid,'name'=>$name,'oem'=>$oem,'model'=>$model,'price'=>$price,'quantity'=>$quantity,'description'=>$description,'av'=>$avar,'country'=>$country,'sid'=>$asid,'showimg'=>$showimg,'action'=>$action,'material'=>$material));
                $flag=0;
                //$pos=0;
                unset($ftitle);
                unset($btitle);
                unset($detid);
                unset($name);
                unset($oem);
                unset($model);
                unset($price);
                //$nextprice=$row2[5];
                unset($quantity);
                unset($description);
                unset($avar);
                unset($country);
                unset($asid);
                unset($showimg);
                unset($action);
                //$flag=0;
                //$last=$last;
                unset($material);
            } elseif($prerow2[2]) {
                //$pos=1;
                //$last=0;
                $flag=1;
                //$cur++;
                //echo $prerow2[2]." ".$flag." last- ".$last;
                if($prerow2[4]) { $prerow2[3]=$prerow2[4];
                }
                $sid=0;
                $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item='{$prerow2[1]}'");
                if($r3=mysql_fetch_row($res3)) {
                    $prerow2[1]=$r3[1];
                    $sid=$r3[0];
                }
                if($prerow2[10]>0) {
                    $av=0;
                } elseif($prerow2[7]!="" && $prerow2[7]!=0) {
                    $av=2;
                } else {
                    $av=1;
                }

                $ftitle[]=$row[1];
                $btitle[]= $row[4];
                $detid[]=$prerow2[0];
                $name[]=$prerow2[1];
                $oem[]=$prerow2[2];
                $model[]=$prerow2[3];
                $price[]=$prerow2[5];
                //$nextprice=$row2[5];
                $quantity[]=$prerow2[6];
                $description[]=$prerow2[8];
                $avar[]=$av;
                $country[]=$prerow2[11];
                $asid[]=$sid;
                $showimg[]=$row[3];
                $action[]=$prerow2[9];
                //$flag=0;
                //$last=$last;
                $material[]=$prerow2[12];
                //render_to_template("components/catalog/template.tableIn.php",array('tabindex'=>$s,'ftitle'=>$ftitle,'btitle'=> $btitle,'id'=>$detid,'name'=>$name,'oem'=>$oem,'model'=>$model,'price'=>$price,'quantity'=>$quantity,'description'=>$description,'av'=>$avar,'country'=>$country,'sid'=>$asid,'showimg'=>$showimg,'action'=>$action,'material'=>$material));

            }
            /*
            if($pre!=$row2[2]){//начало
        
            $s++;
            if($row2[4]) $row2[3]=$row2[4];
            $sid=0;
            $res3=mysql_query("SELECT * FROM catalog_items2 WHERE linked_item='{$row2[1]}'");
            if($r3=mysql_fetch_row($res3)){
            $row2[1]=$r3[1];
            $sid=$r3[0];
            }
            if($row2[10]>0){
            $av=0;
            } elseif($row2[7]!="" && $row2[7]!=0){
            $av=2;
            } else {
            $av=1;
            }
            render_to_template("components/catalog/template.tableIn.php",array('tabindex'=>$s,'ftitle'=>$row[1],'btitle'=> $row[4],'id'=>$row2[0],'name'=>$row2[1],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[11],'sid'=>$sid,'showimg'=>$row[3],'action'=>$row2[9]));
            //unset($row2[0]);
            //unset($row2[5]);
            //unset($row2[6]);
            //unset($av);
            //unset($row2[11]);
            //unset($row2[9]);
            } else {
            $row2[0][]=$row2[0];
            $row2[5][]=$row2[5];
            $row2[6][]=$row2[6];
            $av[]=$av;
            $row2[11][]=$row2[11];
            $row2[9][]=$row2[9];
            }//Конец
            */
            $pre=$row2[2];
            $prerow2=$row2;
        }
        //$last=0;
        //$flag=0;
        //var_dump($row2[2]);
        //die();
        //$last=($flag==1)?1:0;
        //$flag=0;
        //echo "last:".$last." - ".$flag;
        if($prerow2[4]) { $prerow2[3]=$prerow2[4];
        }
        $sid=0;
        $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item='{$prerow2[1]}'");
        if($r3=mysql_fetch_row($res3)) {
            $prerow2[1]=$r3[1];
            $sid=$r3[0];
        }
        if($prerow2[10]>0) {
            $av=0;
        } elseif($prerow2[7]!="" && $prerow2[7]!=0) {
            $av=2;
        } else {
            $av=1;
        }
        if($flag==1) {
            $ftitle[]=$row[1];
            $btitle[]= $row[4];
            $detid[]=$prerow2[0];
            $name[]=$prerow2[1];
            $oem[]=$prerow2[2];
            $model[]=$prerow2[3];
            $price[]=$prerow2[5];
            //$nextprice=$row2[5];
            $quantity[]=$prerow2[6];
            $description[]=$prerow2[8];
            $avar[]=$av;
            $country[]=$prerow2[11];
            $asid[]=$sid;
            $showimg[]=$row[3];
            $action[]=$prerow2[9];
            //$flag=0;
            //$last=$last;
            $material[]=$prerow2[12];
        } else {
            $ftitle=$row[1];
            $btitle= $row[4];
            $detid=$prerow2[0];
            $name=$prerow2[1];
            $oem=$prerow2[2];
            $model=$prerow2[3];
            $price=$prerow2[5];
            //$nextprice=$row2[5];
            $quantity=$prerow2[6];
            $description=$prerow2[8];
            $av=$av;
            $country=$prerow2[11];
            $asid=$sid;
            $showimg=$row[3];
            $action=$prerow2[9];
            //$flag=0;
            //$last=$last;
            $material=$prerow2[12];
        }
            //$prerow2[5]=($prerow2[5]!=$row2[5])?$prerow2[5]." - ".$row2[5]:$row2[5];
            render_to_template("components/catalog/template.tableIn.php", array('tabindex'=>$s,'ftitle'=>$ftitle,'btitle'=> $btitle,'id'=>$detid,'name'=>$name,'oem'=>$oem,'model'=>$model,'price'=>$price,'quantity'=>$quantity,'description'=>$description,'av'=>$avar,'country'=>$country,'sid'=>$asid,'showimg'=>$showimg,'action'=>$action,'material'=>$material));
        $flag=0;

        if($s==0) { echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        }
        render_to_template("components/catalog/template.tableFooter.php", array());
    } else {
        header("HTTP/1.0 404 Not Found");
        header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} elseif(strpos($id, "section-")!==false) {
    $idpos = (int) substr($id, 8);
    $sections=array("", "Оптика и зеркала", "Кузовные запчасти", "Аксессуары"); 
    $descs=array("", "Оптика и зеркала", "Кузовные запчасти", "Аксессуары");
    $keys=array("", "оптика", "Кузовные запчасти", "аксессуары");
    if(array_key_exists($idpos, $sections)) {
        set_title($sections[$idpos]);
        set_meta($keys[$idpos].", запчасти для европейских грузовиков, автозапчасти для грузовых иномарок, грузовые запчасти", "Custom-Truck - ".$descs[$idpos]);
        render_to_template("components/catalog/template.tableHeader2.php", array('title'=>$sections[$idpos],'tt'=>1,'showimg'=>1));
        $page=(preg_match("!^[0-9]+$!is", $_GET['p'], $match))?$_GET['p']:"";
        if(file_exists("cache/$id/page".$page.".php")) {
            //cache
            if($_GET['stat']=='archive') {
                include_once "cache/$id/archpage".$page.".php";
            } else {
                include_once "cache/$id/page".$page.".php";
            }
            $s=1;
        } else {
            //загрузка из базы
            $res2 = mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname,b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,d.name,b.country AS brandname FROM ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c, ".$PREFIX."catalog_brands AS d WHERE b.model_id = c.id AND b.brand_id = d.id $arcquery AND b.section = " . $idpos . " ORDER BY d.name,c.name,b.description");
            $s=0;
            while($row2=mysql_fetch_row($res2)){
                $s++;
                if ($row2[4]) { $row2[3]=$row2[4];
                }
                $sid=0;
                $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item='{$row2[1]}'");
                if($r3=mysql_fetch_row($res3)) {
                    $row2[1]=$r3[1];
                    $sid=$r3[0];
                }
                if($row2[10]>0) {
                    $av=0;
                } elseif($row2[7]!="" && $row2[7]!=0) {
                    $av=2;
                } else {
                    $av=1;
                }    
                render_to_template("components/catalog/template.tableIn1.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1));
            }
        }
        if($s == 0) { echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        }
        render_to_template("components/catalog/template.tableFooter.php", array());
    } else {
        header("HTTP/1.0 404 Not Found");
        header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} elseif(strpos($id, "item-")!== false) {
    $idpos = (int) substr($id, 5);
    $res = mysql_query("SELECT a.id as aid,a.name as aname,a.description as adescription,a.alt,a.keywords as akeywords, b.*,c.id as modid,c.name as model,c.altname as altmodel,d.name as brand,d.altname as altbrand FROM ".$PREFIX."catalog_items2 AS a, ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c, ".$PREFIX."catalog_brands AS d WHERE a.linked_item=b.name AND b.model_id=c.id AND c.brand_id=d.id AND a.id={$idpos}");
    if ($row = mysql_fetch_array($res)) {
        $trep = array(", правое",", переднее",", левое",", заднее",", левый ",", правый",", переднее/заднее",", левая", ", правая","U");
        $tit=str_replace($trep, "", $row[1]);
        $getbr=urldecode($_GET['b']);
        $getmd=urldecode($_GET['t']);
  
        if($row['model']!=$_GET['t'] && strpos($row['model_variants'], $_GET['t'])===false) {
            //echo $row['model'];
            //echo strpos($row['model'],",");
            //$urlmodel=substr($row['model'],0,strpos($row['model'],","));//die($urlmodel);
            $urlmodel=urlencode($row['model']);
            header("Location: " . $GLOBALS['PATH'] . "/catalog/item-$idpos&b={$row['brand']}&t=$urlmodel");
        }
  
        $br=(in_array($getbr, $brnds))?$getbr:$row['brand'];
        $md=(in_array($getmd, $mdls))?$getmd:$row['model'];
        $row['br']=$br;
        $row['md']=$md;
        $row['urls']=$brurls;
        $row['murls']=$mdurls;
        $row['rusbrand']=$rusbrnds[$br];
        $u=array_flip($brurls);
        set_title($tit." ".$u[$br]." ".$md.", ".$row['country'], 0);
        $row['model']=($row['altmodel'])?$row['altmodel']:$row['model'];
        $row['brand']=($row['altbrand'])?$row['altbrand']:$row['brand'];
        $brs=explode(" ", $br);
        $mds=explode(" ", $md);
        if(array_key_exists($md, $rusmodels)) {
            $rmdls=explode(" ", $rusmodels[$md]);
            $rmdl=$rusmodels[$md];
        } else {
            $rmdl=$md;
            $rmdls=$mds;
        }
        $row['rusmodel']=$rmdl;
        $keywords=str_replace("{brand}", $br, $row['keywords']);
        $keywords=str_replace("{brand1}", $brs[0], $keywords);        
        $keywords=str_replace("{model}", $md, $keywords);    
        $keywords=str_replace("{model1}", $mds[0], $keywords);
        $keywords=str_replace("{model2}", $mds[0]." ".$mds[1], $keywords);
        $keywords=str_replace("{rusbrand}", mb_strtolower($rusbrnds[$br], "UTF-8"), $keywords);
        $keywords=str_replace("{rusmodel}", mb_strtolower($rmdl, "UTF-8"), $keywords);
        $keywords=str_replace("{rusmodel1}", mb_strtolower($rmdls[0], "UTF-8"), $keywords);
        if(preg_match_all("!\{[a-z0-9-_]+,[^\{]+\}!is", $keywords, $match)) {
            $brk=Array("{","}");
            $mtch=str_replace($brk, "", $match[0][0]);
            $mtch=explode(",", $mtch);
            foreach($mtch as $d1=>$d2){
                if(stristr($_GET['t'], $d2)) {
                    $keywords=str_replace($match[0], $d2, $keywords);
                    break;
                }
            }
        }
        set_meta($keywords, "Запчасти ".$u[$br].". ".$row['description']." ".$u[$br]." ".$md.", ".$row['country']);
        render_to_template("components/catalog/template.showItem.php", $row);
        $v=explode(";", $row['oem_variants']);
        $v[]=$row['oem'];
        $qs="AND (1 = 0 ";
        foreach($v as $k){
            if($k) {
                $qs.="OR b.oem = '$k' ";
                $qs.="OR b.oem_variants LIKE '%$k%' ";
            }
        }
        $qs.=")";
        //show similar
        $similar_arr = array();
        $res2 = mysql_query(
            "SELECT b.id AS bid,b.name AS bname,a.id,a.name AS position_name,b.oem,c.name AS modelname,
							c.altname AS altmodelname,c.showimg,b.price,b.quantity,b.description,b.waitingfor,d.name AS brandname,d.altname AS altbrandname,b.av,b.country FROM ".$PREFIX."catalog_models AS c, ".$PREFIX."catalog_brands AS d, ".$PREFIX."catalog_items AS b LEFT JOIN ".$PREFIX."catalog_items2 AS a ON b.name=a.linked_item WHERE b.model_id=c.id AND b.brand_id=d.id AND b.id!= {$row['id']} 
							$qs 
							ORDER BY RAND() LIMIT 3"
        );

        while($row2 = mysql_fetch_array($res2)){
            if($row2[3]) { $row2[1] = $row2[3];
            }
            if($row2[6]) { $row2[5] = $row2[6];
            }
            $similar_arr[]=$row2;
        }
        render_to_template("components/catalog/template.showSimilar.php", $similar_arr);            
    } else {
        header("HTTP/1.0 404 Not Found");
        header("Location: " . $GLOBALS['PATH'] . "/404");
    }
} elseif(strpos($id, "bamper")!==false) {

    set_title('Бампера');
    //$models=array("man","volvo","mercedes","scania","renault","iveco");
    //$modelsru=array("man","volvo","mercedes","scania","renault","iveco");
    //$brnds
    $keys="";
    foreach($brnds as $brand){
        if($brand!="Секция") {
            $keys.="бампер ".strtolower($brand).", ";
            $keysru.="бампер ".$rusbrnds[$brand].", ";
            $meta.="бампер ".$brand.", ";
        }
    }
    $meta=substr($meta, 0, -2);
    $keys.=substr($keysru, 0, -2);
    set_meta($keys, "Бамперы: ".$meta);
    render_to_template("components/catalog/template.tableHeader2.php", array('title'=>'','tt'=>1,'showimg'=>1));
    $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname FROM ".$PREFIX."catalog_items2 as a,".$PREFIX."catalog_items AS b,".$PREFIX."catalog_models AS c,".$PREFIX."catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id AND a.description like '%бампер%' ORDER BY b.description");//c.name,b.description
    $s=0;
    while($row2=mysql_fetch_row($res2)){
        $s++;
        if ($row2[4]) { $row2[3]=$row2[4];
        }
        $sid=0;
        $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item = '{$row2[1]}'");
        if($r3=mysql_fetch_row($res3)) {
            $row2[1]=$r3[1];
            $sid=$r3[0];
        }
        if($row2[10]>0) {
            $av=0;
        } elseif($row2[7]!="" && $row2[7]!=0) {
            $av=2;
        } else {
            $av=1;
        }    
            render_to_template("components/catalog/template.tableIn1.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1));
    }  
    render_to_template("components/catalog/template.tableFooter.php", array());

} elseif(strpos($id, "wings")!==false) {
    set_title('Крылья');
    $keys="";
    foreach($brnds as $brand){
        if($brand!="Секция") {
            $keys.="крыло ".strtolower($brand).", ";
            $keysru.="крыло ".$rusbrnds[$brand].", ";
            $meta.="крыло ".$brand.", ";
        }
    }
    $meta=substr($meta, 0, -2);
    $keys.=substr($keysru, 0, -2);
    set_meta($keys, "Крылья: ".$meta);
    render_to_template("components/catalog/template.tableHeader2.php", array('title'=>'','tt'=>1,'showimg'=>1));
    $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname FROM ".$PREFIX."catalog_items2 as a,".$PREFIX."catalog_items AS b,".$PREFIX."catalog_models AS c,".$PREFIX."catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id AND a.description like '%крыл%' ORDER BY b.description");//c.name,b.description
    $s=0;
    while($row2=mysql_fetch_row($res2)){
        $s++;
        if ($row2[4]) { $row2[3]=$row2[4];
        }
        $sid=0;
        $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item = '{$row2[1]}'");
        if($r3=mysql_fetch_row($res3)) {
            $row2[1]=$r3[1];
            $sid=$r3[0];
        }
        if($row2[10]>0) {
            $av=0;
        } elseif($row2[7]!="" && $row2[7]!=0) {
            $av=2;
        } else {
            $av=1;
        }    
            render_to_template("components/catalog/template.tableIn1.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1));
    }  
    render_to_template("components/catalog/template.tableFooter.php", array());
} elseif(strpos($id, "cowl")!==false) {//капот
    set_title('Капоты');
    $keys="";
    foreach($brnds as $brand){
        if($brand!="Секция") {
            $keys.="капот ".strtolower($brand).", ";
            $keysru.="капот ".$rusbrnds[$brand].", ";
            $meta.="капот ".$brand.", ";
        }
    }
    $meta=substr($meta, 0, -2);
    $keys.=substr($keysru, 0, -2);
    set_meta($keys, "Капоты: ".$meta);
    render_to_template("components/catalog/template.tableHeader2.php", array('title'=>'','tt'=>1,'showimg'=>1));
    $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname FROM ".$PREFIX."catalog_items2 as a,".$PREFIX."catalog_items AS b,".$PREFIX."catalog_models AS c,".$PREFIX."catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id AND a.description like '%капот%' ORDER BY b.description");//c.name,b.description
    $s=0;
    while($row2=mysql_fetch_row($res2)){
        $s++;
        if ($row2[4]) { $row2[3]=$row2[4];
        }
        $sid=0;
        $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item = '{$row2[1]}'");
        if($r3=mysql_fetch_row($res3)) {
            $row2[1]=$r3[1];
            $sid=$r3[0];
        }
        if($row2[10]>0) {
            $av=0;
        } elseif($row2[7]!="" && $row2[7]!=0) {
            $av=2;
        } else {
            $av=1;
        }    
            render_to_template("components/catalog/template.tableIn1.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1));
    }  
    render_to_template("components/catalog/template.tableFooter.php", array());
} elseif(strpos($id, "step")!==false) {//подножка
    set_title('Подножки');
    $keys="";
    foreach($brnds as $brand){
        if($brand!="Секция") {
            $keys.="подножка ".strtolower($brand).", ";
            $keysru.="подножка ".$rusbrnds[$brand].", ";
            $meta.="подножка ".$brand.", ";
        }
    }
    $meta=substr($meta, 0, -2);
    $keys.=substr($keysru, 0, -2);
    set_meta($keys, "Подножки: ".$meta);
    render_to_template("components/catalog/template.tableHeader2.php", array('title'=>'','tt'=>1,'showimg'=>1));
    $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname FROM ".$PREFIX."catalog_items2 as a,".$PREFIX."catalog_items AS b,".$PREFIX."catalog_models AS c,".$PREFIX."catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id AND a.description like '%подножк%' ORDER BY b.description");//c.name,b.description
    $s=0;
    while($row2=mysql_fetch_row($res2)){
        $s++;
        if ($row2[4]) { $row2[3]=$row2[4];
        }
        $sid=0;
        $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item = '{$row2[1]}'");
        if($r3=mysql_fetch_row($res3)) {
            $row2[1]=$r3[1];
            $sid=$r3[0];
        }
        if($row2[10]>0) {
            $av=0;
        } elseif($row2[7]!="" && $row2[7]!=0) {
            $av=2;
        } else {
            $av=1;
        }    
            render_to_template("components/catalog/template.tableIn1.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1));
    }  
    render_to_template("components/catalog/template.tableFooter.php", array());
} elseif(strpos($id, "grille")!==false) {//капот
    set_title('Решетки');
    $keys="";
    foreach($brnds as $brand){
        if($brand!="Секция") {
            $keys.="решетка ".strtolower($brand).", ";
            $keysru.="решетка ".$rusbrnds[$brand].", ";
            $meta.="решетка ".$brand.", ";
        }
    }
    $meta=substr($meta, 0, -2);
    $keys.=substr($keysru, 0, -2);
    set_meta($keys, "Решетки: ".$meta);
    render_to_template("components/catalog/template.tableHeader2.php", array('title'=>'','tt'=>1,'showimg'=>1));
    $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname FROM ".$PREFIX."catalog_items2 as a,".$PREFIX."catalog_items AS b,".$PREFIX."catalog_models AS c,".$PREFIX."catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id AND a.description like '%решетк%' ORDER BY b.description");//c.name,b.description
    $s=0;
    while($row2=mysql_fetch_row($res2)){
        $s++;
        if ($row2[4]) { $row2[3]=$row2[4];
        }
        $sid=0;
        $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item = '{$row2[1]}'");
        if($r3=mysql_fetch_row($res3)) {
            $row2[1]=$r3[1];
            $sid=$r3[0];
        }
        if($row2[10]>0) {
            $av=0;
        } elseif($row2[7]!="" && $row2[7]!=0) {
            $av=2;
        } else {
            $av=1;
        }    
            render_to_template("components/catalog/template.tableIn1.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1));
    }  
    render_to_template("components/catalog/template.tableFooter.php", array());
} elseif(strpos($id, "plastic")!==false) {
    if($id=="plastic") {
        $res3=mysql_query("SELECT keywords,meta_description FROM ".$PREFIX."static WHERE path='$id' limit 1");
        $row3=mysql_fetch_row($res3);
        $res = mysql_query("SELECT id,name,altname FROM ".$PREFIX."catalog_brands WHERE showmenu=1 order by position");
        set_title("Автопластик. Пластик Daf, пластик Iveco, пластик Man, пластик Renault, пластик Scania, пластик Mercedes, пластик Volvo");
        set_meta($row3[0], $row3[1]);
        render_to_template("components/catalog/template.modelsHeader.php", array('tt'=>'','title'=>"Автопластик"));
        while($row=mysql_fetch_row($res)){
            $pid=strtolower($row[1]);
            if(file_exists("img/plastic/".$pid.".jpg")) {
                $img="img/plastic/".$pid.".jpg";
            } else {
                $img="img/nofoto.jpg";
            }
         
            $name=($row[2])?$row[2]:$row[1];
            render_to_template("components/catalog/template.models.php", array('name'=>'Пластик '.$name,'image'=>$img,'id'=>$pid));//?
        }
        render_to_template("components/catalog/template.modelsFooter.php", array());
 
    } else {
        $idpos=substr($id, 8);
         //загрузка из базы
        $models=Array("daf"=>"DAF","m-b"=>"Mercedes","iveco"=>"Iveco","scania"=>"Scania","man"=>"Man","volvo"=>"Volvo","renault"=>"Renault");
        set_title('Пластик '.$models[$idpos]);
        set_meta('Пластик '.$models[$idpos], 'Кузовные запчасти, пластик '.$models[$idpos]);
        render_to_template("components/catalog/template.tableHeader2.php", array('title'=>'','tt'=>1,'showimg'=>1,'bname'=>$models[$idpos]));
        $res2 = mysql_query("SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname FROM ".$PREFIX."catalog_items2 as a,".$PREFIX."catalog_items AS b,".$PREFIX."catalog_models AS c,".$PREFIX."catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id AND d.name='$idpos' AND (a.description like '%пластик%' OR a.description like '%поли%') ORDER BY b.description");//c.name,b.description
        //echo "SELECT b.id, b.name AS position_name, b.oem, c.name AS modelname, c.altname AS altmodelname, b.price, b.quantity,  b.waitingfor,   b.description, b.special, b.available, d.name, b.country AS brandname FROM catalog_items2 as a,catalog_items AS b,catalog_models AS c,catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id AND d.name=$idpos AND a.description like '%пластик%' ORDER BY c.name,b.description";
 
        $s=0;
        while($row2=mysql_fetch_row($res2)){
            $s++;
            if ($row2[4]) { $row2[3]=$row2[4];
            }
            $sid=0;
            $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item = '{$row2[1]}'");
            if($r3=mysql_fetch_row($res3)) {
                $row2[1]=$r3[1];
                $sid=$r3[0];
            }
            if($row2[10]>0) {
                $av=0;
            } elseif($row2[7]!="" && $row2[7]!=0) {
                $av=2;
            } else {
                $av=1;
            }    
            render_to_template("components/catalog/template.tableIn1.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1));
        }  
        render_to_template("components/catalog/template.tableFooter.php", array());
    }

} else {
    header("HTTP/1.0 404 Not Found");
    header("Location: " . $GLOBALS['PATH']."/404");
}
?>