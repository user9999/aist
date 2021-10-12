<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
if (!isset($_GET['id'])) { header("Location: " . $GLOBALS['PATH'] . "/404");
}
$arcquery=($_GET['stat']=='archive')?"AND b.waitingfor='архив'":"AND b.waitingfor!='архив'";
$id = mysql_real_escape_string($_GET['id']);
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
if(strpos($id, "item-")===false && strpos($id, "model-")===false && strpos($id, "section-")===false && strpos($id, "price-")===false && strpos($id, "plastic")===false && strpos($id, "waitingfor")===false) {
    //category
    $res=mysql_query("SELECT id,name,altname FROM ".$PREFIX."catalog_brands WHERE LOWER(`name`)='$id'");
    if($row=mysql_fetch_row($res)) {
        if($row[2]) { $row[1]=$row[2];
        }
        set_title($row[1]);
        render_to_template("components/catalog/template.modelsHeader.php", array('title'=>$row[1]));
        $res2=mysql_query("SELECT name, image, id FROM ".$PREFIX."catalog_models WHERE brand_id = " . $row[0] . " ORDER BY position");//name
        while($row2=mysql_fetch_row($res2)){
            render_to_template("components/catalog/template.models.php", array('name' => $row2[0], 'image' => $row2[1], 'id' => $row2[2]));
        }
        render_to_template("components/catalog/template.modelsFooter.php", array());
    }else { header("Location: ".$GLOBALS['PATH']."/404");
    }
} elseif(strpos($id, "model-")!==false) {
    //category model
    $idpos=(int)substr($id, 6);
    $res=mysql_query("SELECT a.id,a.name,a.altname,a.showimg,b.name as bname,b.altname as baltname FROM ".$PREFIX."catalog_models AS a, ".$PREFIX."catalog_brands AS b WHERE a.id = '$idpos' AND a.brand_id = b.id");
    if($row=mysql_fetch_row($res)) {
        if($row[2]) { $row[1]=$row[2];
        }
        $s=strtolower($row[4]);
        $brandname=$row[4];
        if ($row[5]) { $row[4]=$row[5];
        }
        set_title($row[4]." ".$row[1]);
        render_to_template("components/catalog/template.userHeader.php", array('title'=>"<a href='{$GLOBALS[PATH]}/catalog/$s'>".$row[4]."</a> ".$row[1],'showimg'=>$row[3],'city'=>$_SESSION['actype'][3],'update'=>$_SESSION['update']));
        //get all items from this position
        //authuser
        if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
            $ufl=0;
            $res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname,e.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.section,b.country,b.msk,b.spb FROM ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c, `".$PREFIX."price_".$_SESSION['userid']."` AS e WHERE b.model_id = c.id AND b.name=e.name $arcquery AND (b.model_id = " . $idpos . " OR b.model_variants LIKE '%{$row[1]}%') ORDER BY b.description");
        } else {
            $ufl=1;
            $res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname,b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,b.section,b.country,b.msk,b.spb,b.opt FROM ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c WHERE b.model_id = c.id $arcquery AND (b.model_id = " . $idpos . " OR b.model_variants LIKE '%{$row[1]}%') ORDER BY b.description");
        }
        
        //сделать: Price - акционная цена special- старая розн цена, opt - старая оптовая цена, $price =$opt ///($special)?$price:$opt;
        
        $s=0;
        while($row2=mysql_fetch_row($res2)){
            $s++;
            if($row2[4]) { $row2[3]=$row2[4];
            }
            $sid=0;
            $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item='{$row2[1]}'");
            if($r3=mysql_fetch_row($res3)) {
                $row2[1]=$r3[1];
                $sid=$r3[0];
            }
            //скидка 
            if($ufl==1) {
                //$row2[5]=($row2[9])?preg_replace('/[^0-9]/','',$row2[9]):$row2[5];
                //$row2[5]=($row2[9])?$row2[15]:$row2[5];
                $row2[5]=$row2[15];
            }
            //$row2[5]=($row2[9])?preg_replace('/[^0-9]/','',$row2[9]):$row2[5];
            if($_SESSION['userid'] && $_SESSION['trend_purc'][$row2[12]."_".$row2[11]]!=='0' && $_SESSION['trend_purc'][$row2[12]."_".$row2[11]]!==null && $_SESSION['actype'][2]==1) {
                $row2[5]=(ceil($row2[5]*(100-$_SESSION['trend_purc'][$row2[12]."_".$row2[11]])/1000))*10;
        
            } else {
                $row2[5]=($_SESSION['userid'] && $_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?(ceil($row2[5]*(100-$_SESSION['percent'])/1000))*10:(ceil($row2[5]/10))*10;
        
            }

            //скидка
            //валюта
            if($_SESSION['actype'][6]==1 && $_COOKIE['currency']!='rub') {//$_SESSION['actype'][0]==1 && 
                $row2[5]=price($row2[5]);
            }
            echo "<!--".$_SESSION['actype'][0]." ".$_SESSION['actype'][6].$_COOKIE['currency']." test-->";
            //валюта
            if($row2[10]>0) {
                $av=0;
            } elseif($row2[7]!="" && $row2[7]!=0) {
                $av=2;
            } else {
                $av=1;
            }
            $msk=($row2[13]>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row2[13];
            $spb=($row2[14]>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row2[14];
            $city=$_SESSION['actype'][3];
            render_to_template("components/catalog/template.user.table.php", array('ftitle'=>$row[1],'btitle'=>$row[4],'id'=>$row2[0],'name'=>$row2[1],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'showimg'=>$row[3],'action'=>$row2[9],'city'=>$city,'msk'=>$msk,'spb'=>$spb,'pageid'=>$brandname));
        }
        if($s==0) { echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        }
        render_to_template("components/catalog/template.tableFooter.php", array());
    }else { header("Location: ".$GLOBALS['PATH']."/404");
    }
} elseif(strpos($id, "section-")!==false) {
    //section
    $idpos=(int)substr($id, 8);
    $sections=array("","Оптика","Кузовные запчасти","Аксессуары"); 
    if(array_key_exists($idpos, $sections)) {
        set_title($sections[$idpos]);
        render_to_template("components/catalog/template.userHeader.php", array('title'=>$sections[$idpos],'tt'=>1,'showimg'=>1,'city'=>$_SESSION['actype'][3],'update'=>$_SESSION['update']));
        if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
            $ufl=0;
            $res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname,e.price,b.quantity,b.waitingfor,b.description,b.special,b.available,d.name,b.country AS brandname,b.msk,b.spb FROM ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c, ".$PREFIX."catalog_brands AS d, `".$PREFIX."price_".$_SESSION['userid']."` AS e  WHERE b.model_id = c.id AND b.brand_id = d.id AND b.name=e.name $arcquery AND b.section = " . $idpos . " ORDER BY d.name,c.name,b.description");
        } else {
            $ufl=1;
            $res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname,b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,d.name,b.country AS brandname,b.msk,b.spb,b.opt FROM ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c, ".$PREFIX."catalog_brands AS d WHERE b.model_id = c.id AND b.brand_id = d.id $arcquery AND b.section = " . $idpos . " ORDER BY d.name,c.name,b.description");
        }
        $s=0;
        while($row2=mysql_fetch_row($res2)){
            $s++;
            //echo $row2[5]." - ";
            if($ufl==1) {
                 $row2[5]=$row2[15];
            }
            //echo $row2[5]."- ";
            if($row2[4]) { $row2[3]=$row2[4];
            }
            //скидка 
            $row2[5]=($_SESSION['userid'] && $_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?(ceil($row2[5]*(100-$_SESSION['percent'])/1000))*10:(ceil($row2[5]/10))*10;
            //скидка
            //валюта
            //echo $row2[5]."<br>";
            if($_SESSION['actype'][6]==1 && $_COOKIE['currency']!='rub') {
                $row2[5]=price($row2[5]);
            }
            //валюта
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
            $city=$_SESSION['actype'][3];
            $msk=($row2[12]>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row2[12];
            $spb=($row2[13]>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row2[13];
            render_to_template("components/catalog/template.user.table.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1,'city'=>$city,'msk'=>$msk,'spb'=>$spb));
        }
        if($s==0) { echo "<tr><td colspan=8>Не найдено ни одной позиции</td></tr>";
        }
        render_to_template("components/catalog/template.tableFooter.php", array());
    }else { header("Location: ".$GLOBALS['PATH']."/404");
    }
} elseif(strpos($id, "item-")!==false) {//сделать: Price - акционная цена special- старая розн цена, opt - старая оптовая цена, $price =$opt ///($special)?$price:$opt;
    $idpos=(int)substr($id, 5);
    include_once "inc/users.configuration.php";
    $active=time()-($RESERVE*60*60);
    $res=mysql_query("SELECT a.id as aid,a.name as aname,a.description as adescription,a.alt,a.keywords as akeywords,b.*,c.name as model,c.altname as altmodel,d.name as brand,d.altname as altbrand FROM ".$PREFIX."catalog_items2 AS a, ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c, ".$PREFIX."catalog_brands AS d WHERE  a.linked_item = b.name AND b.model_id = c.id AND c.brand_id = d.id AND a.id = {$idpos}");
    if ($row = mysql_fetch_array($res)) {
        $res2=mysql_query("SELECT amount,user_id,add_date from ".$PREFIX."reserved where  add_date>".$active." and gruz_id='".$row['name']."'");//user_id='".$_SESSION['userid']."' and  limit 1
        $row['resamount']=0;
        while($row2=mysql_fetch_row($res2)){
            if($row2[1]==$_SESSION['userid']) {
                 $row['amount']=$row2[0];
            }
            $resamnt+=$row2[0];
        }
        if($_SESSION['actype'][4]==1) {
            $row['resamount']=$resamnt;
        }
        //скидка 
        //$price=$row['opt'];

        //$price=(ceil($row['opt']/10))*10;

        //$row['price']=($row['special'])?preg_replace('/[^0-9]/', '', $row['special']):$row['opt'];

        $price=$row['price'];
        $row['price']=$row['opt'];
        //echo $row['price']."<br>"; 
        if($_SESSION['userid'] && $_SESSION['trend_purc'][$row['country']."_".$row['section']]!=='0' && $_SESSION['trend_purc'][$row['country']."_".$row['section']]!==null && $_SESSION['actype'][2]==1 && $row['special']=='') {
            $row['price']=(ceil($row['opt']*(100-$_SESSION['trend_purc'][$row['country']."_".$row['section']])/1000))*10;
        } else {
            $row['price']=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1 && $row['special']=='')?(ceil($row['opt']*(100-$_SESSION['percent'])/1000))*10:(ceil($row['opt']/10))*10;
        }
    
        //echo $row['price']."<br>"; 
    
        //скидка 
        if($row['special']!='') {
            //$row['special_price']=$price;
            $row['special_price']=$price;
      
            //$spec=preg_replace('/[^0-9]/', '', $row['special']);
      
      
      
            if($_SESSION['userid'] && $_SESSION['trend_purc'][$row['country']."_".$row['section']]!=='0' && $_SESSION['trend_purc'][$row['country']."_".$row['section']]!==null && $_SESSION['actype'][2]==1) {
                $row['price']=(ceil($row['opt']*(100-$_SESSION['trend_purc'][$row['country']."_".$row['section']])/1000))*10;
            } else {
                $row['price']=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?(ceil($row['opt']*(100-$_SESSION['percent'])/1000))*10:(ceil($row['opt']/10))*10;
            }
        }
           //echo $row['price']."<br>"; 
        if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
            $res3 = mysql_query("SELECT price from `".$PREFIX."price_".$_SESSION['userid']."` where name='".$row['name']."' limit 1");
            $row3 = mysql_fetch_array($res3);
            if($row3[0]) {
                $row['price']=$row3[0];
            } else {
                $useritem=1;
            }
        }
        //echo $row['price']."<br>"; 
        //валюта
        if($_SESSION['actype'][6]==1 && $_COOKIE['currency']!='rub') {
            $row['price']=price($row['price']);
        }
        //echo $row['price']."<br>"; 
        //валюта
        $row['useritem']=$useritem;
        $row['city']=$_SESSION['actype'][3];
        ///new
        $trep = array(", правое",", переднее",", левое",", заднее",", левый ",", правый",", переднее/заднее",", левая", ", правая","U");
        $tit=str_replace($trep, "", $row[1]);
        $getbr=urldecode($_GET['b']);
        $getmd=urldecode($_GET['t']);
        $br=(in_array($getbr, $brnds))?$getbr:$row['brand'];
        $md=(in_array($getmd, $mdls))?$getmd:$row['model'];
        $row['br']=$br;
        $row['md']=$md;
        $row['urls']=$brurls;
        $row['murls']=$mdurls;
        $row['rusbrand']=$rusbrnds[$br];
        set_title($tit." ".$br." ".$md, 0);
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
        set_meta($keywords, "Запчасти ".$br.". ".$row['description']." ".$br." ".$md);
        $row['RESERVE']=$RESERVE;
        $row['msk']=($row['msk']>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row['msk'];
        $row['spb']=($row['spb']>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$row['spb'];
        render_to_template("components/catalog/template.userItem.php", $row);
        $v=explode(";", $row['oem_variants']);
        $v[]=$row['oem'];
        $qs="AND (1 = 0 ";
        foreach($v as $k){
            if($k) {
                $qs.="OR b.oem='$k'";
                $qs.="OR b.oem_variants LIKE '%$k%'";
            }
        }
        $qs.=")";
        //show similar
        $similar_arr=array();
                $res2=mysql_query(
                    "SELECT b.id AS bid,b.name AS bname,a.id,a.name AS position_name,b.oem,b.msk,b.spb,c.name AS modelname, 
							c.altname AS altmodelname,c.showimg,b.opt as price,b.quantity,b.description,b.waitingfor,d.name AS brandname,d.altname AS 
							altbrandname,b.av,b.section,b.country FROM ".$PREFIX."catalog_models AS c,".$PREFIX."catalog_brands AS d,".$PREFIX."catalog_items AS b 
							LEFT JOIN ".$PREFIX."catalog_items2 AS a ON b.name=a.linked_item 
							WHERE b.model_id=c.id AND b.brand_id=d.id AND b.id!={$row['id']} 
							$qs 
							ORDER BY RAND() LIMIT 3"
                );
        while($row2=mysql_fetch_array($res2)){
            if($row2[3]) { $row2[1]=$row2[3];
            }
            if($row2[15]) { $row2[14]=$row2[15];
            }
            if($row2[8]) { $row2[7]=$row2[8];
            }
            if($_SESSION['actype'][0]==1) {
                 $res3=mysql_query("select price from `".$PREFIX."price_".$_SESSION['userid']."` where name='{$row2['bname']}' limit 1");
                 $row3 = mysql_fetch_array($res3);
                 $row2['price']=$row3['price'];
        
            } elseif($_SESSION['actype'][0]!=1 && $_SESSION['trend_purc'][$row2['country']."_".$row2['section']]!=='0' && $_SESSION['trend_purc'][$row2['country']."_".$row2['section']]!==null && $_SESSION['actype'][2]==1) {
                 $row2['price']=(ceil($row2['price']*(100-$_SESSION['trend_purc'][$row2['country']."_".$row2['section']])/1000))*10;
            } elseif($_SESSION['userid'] && $_SESSION['percent']>0 && $_SESSION['actype'][0]!=1) {
                 $row2['price']=(ceil($row2['price']*(100-$_SESSION['percent'])/1000))*10;
            }
            $row2['city']=$_SESSION['actype'][3];            
            $similar_arr[]=$row2;
        }    
        render_to_template("components/catalog/template.userSimilar.php", $similar_arr);            
    }else { header("Location: ".$GLOBALS['PATH']."/404");
    }
} elseif(strpos($id, "plastic")!==false) {
    ////////////////////////////////////////////////////plastic
    if($id=="plastic") {//готово цены=opt
        $res3=mysql_query("SELECT keywords,meta_description FROM ".$PREFIX."static WHERE path='$id' limit 1");
        $row3=mysql_fetch_row($res3);
        $res = mysql_query("SELECT id,name,altname FROM ".$PREFIX."catalog_brands WHERE showmenu=1 order by position");
        set_title("Автопластик. Пластик Daf, пластик Iveco, пластик Man, пластик Renault, пластик Scania, пластик Mercedes, пластик Volvo");
        set_meta($row3[0], $row3[1]);
        render_to_template("components/catalog/template.modelsHeader.php", array('tt'=>'','title'=>"Автопластик",'update'=>$_SESSION['update']));
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
        render_to_template("components/catalog/template.userHeader.php", array('title'=>'','tt'=>1,'showimg'=>1,'bname'=>$models[$idpos],'update'=>$_SESSION['update']));


        $res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname,b.price,b.quantity,b.waitingfor,b.description,b.special,b.available,d.name,b.section,b.country AS brandname,b.opt FROM ".$PREFIX."catalog_items2 as a,".$PREFIX."catalog_items AS b,".$PREFIX."catalog_models AS c,".$PREFIX."catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id AND d.name='$idpos' AND (a.description like '%пластик%' OR a.description like '%поли%') ORDER BY b.description");


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
            $price=$row2[5];
            $row2[5]=$row2[14];
            //$row2[5]=($row2[9])?preg_replace('/[^0-9]/', '', $row2[9]):$row2[5];

            if($_SESSION['userid'] && $_SESSION['trend_purc'][$row2[13]."_".$row2[12]]!=='0' && $_SESSION['trend_purc'][$row2[13]."_".$row2[12]]!==null && $_SESSION['actype'][2]==1) {
                $row2[5]=(ceil($row2[5]*(100-$_SESSION['trend_purc'][$row2[13]."_".$row2[12]])/1000))*10;
            } else {
                $row2[5]=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?(ceil($row2[5]*(100-$_SESSION['percent'])/1000))*10:(ceil($row2[5]/10))*10;
            }
            //скидка 

            if($row2[9]!='') {
                $row['special_price']=$price;
                $spec=$row2[14];
                //$spec=preg_replace('/[^0-9]/', '', $row2[9]);
                if($_SESSION['userid'] && $_SESSION['trend_purc'][$row2[13]."_".$row2[12]]!=='0' && $_SESSION['trend_purc'][$row2[13]."_".$row2[12]]!==null && $_SESSION['actype'][2]==1) {
                    $row2[5]=(ceil($row2[5]*(100-$_SESSION['trend_purc'][$row2[13]."_".$row2[12]])/1000))*10;
                } else {
                    $row2[5]=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?(ceil($spec*(100-$_SESSION['percent'])/1000))*10:(ceil($spec/10))*10;
                }
            }


            if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
                $res3=mysql_query("SELECT price from `".$PREFIX."price_".$_SESSION['userid']."` where name='".$row2[1]."' limit 1");
                $row3=mysql_fetch_array($res3);
                if($row3[0]) {
                    $row2[5]=$row3[0];
                } else {
                    $useritem=1;
                }
            }
            //валюта
            if($_SESSION['actype'][6]==1 && $_COOKIE['currency']!='rub') {
                $row2[5]=price($row2[5]);
            }
            //валюта
            render_to_template("components/catalog/template.user.table.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[12],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1));
        }  
        render_to_template("components/catalog/template.tableFooter.php", array());
    }
    ////////////////////////////////////////////////////plastic end
} elseif(strpos($id, "waitingfor")!==false) {
    set_title('Ожидается приход');
    set_meta('Ожидается приход', 'Кузовные запчасти, приход ');
    render_to_template("components/catalog/template.waitHeader.php", array('title'=>'','tt'=>1,'showimg'=>1,'bname'=>$models[$idpos],'update'=>$_SESSION['update']));
    $res2=mysql_query("SELECT b.id,b.name AS position_name,b.oem,c.name AS modelname,c.altname AS altmodelname,b.opt as price,b.quantity,b.waitingfor,b.description,b.special,b.available,d.name,b.section,b.country AS brandname FROM ".$PREFIX."catalog_items2 as a,".$PREFIX."catalog_items AS b,".$PREFIX."catalog_models AS c,".$PREFIX."catalog_brands AS d WHERE a.linked_item=b.name and b.model_id = c.id AND b.brand_id = d.id and b.waitingfor!='' and b.waitingfor!='архив' and b.waitingfor!='prihod' ORDER BY b.description");
    $s=0;
    while($row2=mysql_fetch_row($res2)){
        $s++;
        $gruz_id=$row2[1];
        if ($row2[4]) { $row2[3]=$row2[4];
        }
        $sid=0;
        $res3=mysql_query("SELECT * FROM ".$PREFIX."catalog_items2 WHERE linked_item='{$row2[1]}'");
        if($r3=mysql_fetch_row($res3)) {
            $row2[1]=$r3[1];
            $sid=$r3[0];
        }
        $av=$row2[7];
        $price=$row2[5];
        //$row2[5]=($row2[9])?preg_replace('/[^0-9]/', '', $row2[9]):$row2[5];

        if($_SESSION['userid'] && $_SESSION['trend_purc'][$row2[13]."_".$row2[12]]!=='0' && $_SESSION['trend_purc'][$row2[13]."_".$row2[12]]!==null && $_SESSION['actype'][2]==1 && $row2[9]=='') {
            $row2[5]=(ceil($row2[5]*(100-$_SESSION['trend_purc'][$row2[13]."_".$row2[12]])/1000))*10;
        } else {
            $row2[5]=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1 && $row2[9]=='')?(ceil($row2[5]*(100-$_SESSION['percent'])/1000))*10:(ceil($row2[5]/10))*10;
        }
        //скидка 
        if($row2[9]!='') {
            $row['special_price']=$price;
            $spec=preg_replace('/[^0-9]/', '', $row2[9]);
            if($_SESSION['userid'] && $_SESSION['trend_purc'][$row2[13]."_".$row2[12]]!=='0' && $_SESSION['trend_purc'][$row2[13]."_".$row2[12]]!==null && $_SESSION['actype'][2]==1) {
                $row2[5]=(ceil($row2[5]*(100-$_SESSION['trend_purc'][$row2[13]."_".$row2[12]])/1000))*10;
            } else {
                $row2[5]=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?(ceil($spec*(100-$_SESSION['percent'])/1000))*10:$spec;
            }
        }
        if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
            $res3=mysql_query("SELECT price from `".$PREFIX."price_".$_SESSION['userid']."` where name='".$row2[1]."' limit 1");
            $row3=mysql_fetch_array($res3);
            if($row3[0]) {
                $row2[5]=$row3[0];
            } else {
                $useritem=1;
            }
        }
        //валюта
        if($_SESSION['actype'][6]==1 && $_COOKIE['currency']!='rub') {
            $row2[5]=price($row2[5]);
        }
        //валюта
        render_to_template("components/catalog/template.wait.table.php", array('id'=>$row2[0],'name'=>$row2[1],'btitle'=>$row2[11],'ftitle'=>$row2[3],'oem'=>$row2[2],'model'=>$row2[3],'price'=>$row2[5],'quantity'=>$row2[6],'description'=>$row2[8],'av'=>$av,'country'=>$row2[13],'sid'=>$sid,'mlinks'=>1,'action'=>$row2[9],'showimg'=>1,'gruz_id'=>$gruz_id));
    }
    render_to_template("components/catalog/template.tableFooter.php", array());
} else {//уже лишнее
    //item
    $idpos=(int)substr($id, 6);
    $res=mysql_query("SELECT a.*,b.name AS brand,c.name AS model,b.altname AS altbrand,c.altname AS altmodel FROM ".$PREFIX."catalog_items AS a,".$PREFIX."catalog_brands AS b,".$PREFIX."catalog_models AS c WHERE a.id = {$idpos} AND a.brand_id = b.id AND a.model_id = c.id");
    if ($row=mysql_fetch_array($res)) {
        set_title($row['name']);
        set_meta($row['description'], $row['aname']." - ".$row['description']);
        $row['price']=$row['opt'];
        render_to_template("components/catalog/template.showPrice.php", $row);
        $v=explode(";", $row['oem_variants']);
        $v[]=$row['oem'];
        $qs="AND (1 = 0 ";
        foreach($v as $k){
            if($k) {
                $qs.="OR b.oem='$k'";
                $qs.="OR b.oem_variants LIKE '%$k%'";
            }
        }
        $qs.=")";
        //show similar
        $similar_arr=array();
        $res2=mysql_query(
            "SELECT b.id AS bid,b.name AS bname,a.id,a.name AS position_name,b.oem,c.name AS modelname, 
							c.altname AS altmodelname,b.opt as price,b.quantity,b.description,d.name AS brandname,d.altname AS 
							altbrandname,b.av,b.country FROM ".$PREFIX."catalog_models AS c,".$PREFIX."catalog_brands AS d,".$PREFIX."catalog_items AS b
							LEFT JOIN ".$PREFIX."catalog_items2 AS a ON b.name=a.linked_item 
							WHERE b.model_id=c.id AND b.brand_id=d.id AND b.id!={$row['id']} 
							$qs 
							ORDER BY RAND() LIMIT 3"
        );
        while($row2 = mysql_fetch_array($res2)){
            if($row2[3]) { $row2[1]=$row2[3];
            }
            if($row2[6]) { $row2[5]=$row2[6];
            }
            $similar_arr[]=$row2;
        }    
        render_to_template("components/catalog/template.showSimilar.php", $similar_arr);            
    }else { header("Location: ".$GLOBALS['PATH']."/404");
    }
}
?>
