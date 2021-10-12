<?php
if($_SESSION['userid']) {
    if($_SESSION['actype'][5]==1) {

        if($_POST['change']) {
            foreach($_POST['zap'] as $key=>$val){
                mysql_query("update ".$PREFIX."preorder set amount=$val where id=$key and user_id='{$_SESSION['userid']}'");
            }
        }
        $id = mysql_real_escape_string($_GET['id']);
        if(substr($id, 0, 3)=="id-") {
            $id=str_replace("id-", "", $id);
            $andq=($id=="all")?"":" and id=".$id;
            mysql_query("delete from ".$PREFIX."preorder where user_id='".$_SESSION['userid']."'".$andq);
    
        } elseif(substr($id, 0, 8)=="orderall") {
            //полный заказ
            $usrid=($_SESSION['userid'])?",user_id='".$_SESSION['userid']."'":"";
            if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
                $utype=" utype=2";
            } elseif($_SESSION['userid'] && $_SESSION['actype'][0]!=1) {
                $utype=" utype=1";
            } else {
                $utype=" utype=0"; 
            }
            $resu=mysql_query("select email,name,company from ".$PREFIX."users where id='{$_SESSION['userid']}' limit 1");
            $rowu=mysql_fetch_array($resu);
            $rowu['name']=($rowu['company'])?$rowu['company']:$rowu['name'];
            mysql_query("INSERT INTO ".$PREFIX."orders SET name = '{$rowu['name']}', phone = '', address = '', email = '{$rowu['email']}', date = '" . date('U') . "', state = 0,".$utype.$usrid);
            $ordid = mysql_insert_id();
            $res=mysql_query("select id from ".$PREFIX."preorder where user_id='{$_SESSION['userid']}' and order_date=0 and storage!=0");
    
            $ordtime=time();
            while($row=mysql_fetch_row($res)){
    
                if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
                    $query="SELECT b.*, e.price as userprice, b.quantity,a.amount FROM ".$PREFIX."catalog_items AS b,".$PREFIX."price_".$_SESSION['userid']." AS e,".$PREFIX."preorder as a WHERE b.name=e.name AND a.gruz_id=b.name and a.id = {$row[0]}";
                } elseif($_SESSION['userid'] && $_SESSION['actype'][0]!=1) {
                    $query="SELECT b.*, b.price as userprice, b.quantity,a.amount FROM ".$PREFIX."catalog_items AS b,".$PREFIX."preorder as a WHERE a.gruz_id=b.name and a.id = {$row[0]}";
                } else {
                    $query="SELECT b.*, b.price as userprice, b.quantity,a.amount FROM ".$PREFIX."catalog_items AS b,".$PREFIX."preorder as a WHERE a.gruz_id=b.name and a.id = {$row[0]}";
                }
                $res1 = mysql_query($query);
                if ($row1 = mysql_fetch_array($res1)) {
                    $row1[9]=($row1[9]!=$row1['userprice'])?$row1['userprice']:$row1[9];
                    $row1[9]=($_SESSION['userid'] && $_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?floor($row1[9]*(100-$_SESSION['percent'])/100):$row1[9];
                    $row1[9] = (float) $row1[9];
          
          
          
          
                    /////check {$row1[9]}
                    mysql_query("INSERT INTO ".$PREFIX."orders_items SET orders_id = $ordid, name = '{$row1[2]}', price = '{$row1[9]}', quantity = '{$row1['amount']}', item_id = '{$row1[0]}'");//.$usrid
                    mysql_query("update ".$PREFIX."preorder set order_date=".$ordtime." where id={$row[0]}");
                    //echo "update preorder set order_date=".$ordtime." where id={$row[0]}";
                }
            }
            $arr['error']="<i style=\"color:#0d0\">Ваш заказ отправлен администратору магазина.</i>";
            //echo " Ваш заказ отправлен администратору магазина.";    
        }
        //на складе
        mysql_query("SET SQL_BIG_SELECTS=1");
        if($_SESSION['actype'][0]==1) {
            $res=mysql_query("select a.*,b.id as det_id,b.oem,b.model_id,b.description,b.available,b.special,b.country,c.name as brandname,d.name as modelname,e.price,f.id as itemid from ".$PREFIX."preorder as a,".$PREFIX."catalog_items as b,".$PREFIX."catalog_brands as c,".$PREFIX."catalog_models as d, `".$PREFIX."price_".$_SESSION['userid']."` as e,".$PREFIX."catalog_items2 as f where b.brand_id=c.id and b.model_id=d.id and a.gruz_id=b.name and b.name=e.name and b.name=f.linked_item and a.user_id='".$_SESSION['userid']."' and b.available>0 order by a.preorder_date");//a.storage
        } elseif($_SESSION['actype'][0]==0) {
            $res=mysql_query("select a.*,b.id as det_id,b.oem,b.model_id,b.description,b.available,b.price,b.special,b.country,c.name as brandname,d.name as modelname,f.id as itemid from ".$PREFIX."preorder as a,".$PREFIX."catalog_items as b,".$PREFIX."catalog_brands as c,".$PREFIX."catalog_models as d,".$PREFIX."catalog_items2 as f where b.brand_id=c.id and b.model_id=d.id and a.gruz_id=b.name and b.name=f.linked_item and a.user_id='".$_SESSION['userid']."' and b.available>0 order by a.preorder_date");
        }
        $i=0;
        $arr['reserved']=false;
        $arr['order']=true;$userorders=0;
        if(mysql_num_rows($res)>0) {
            $arr['maxamt']=mysql_num_rows($res);
            $userorders=1;
            $arr['title']="На данный момент есть на складе";
            $arr['user']=$_SESSION['userid'];
            $flag=0;$arr['top']=1;$ids="";$prices="";$sum=0;
            while($row=mysql_fetch_array($res)){
                $i++;
                $arr['reserved']=true;
                if($flag==0) {
                    render_to_template("components/preorder/template.tableHeader.php", $arr);
                    $flag=1;
                }
                $ids.=$row['det_id'].",";
                //$arr[]=$row['id'];
                $row['RESERVE']=$RESERVE;
          
                $row['price']=($row['special'])?preg_replace('/[^0-9]/', '', $row['special']):$row['price'];
                $row['price']=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?floor($row['price']*(100-$_SESSION['percent'])/100):$row['price'];
                //$row['price']=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1 && $row['special']=='')?floor($row['price']*(100-$_SESSION['percent'])/100):$row['price'];
                //валюта
                if($_SESSION['actype'][0]==1 && $_SESSION['actype'][6]==1 && $_COOKIE['currency']=='rub') {
                    $res4=mysql_query("select euro,dollar,currency,ratio from ".$PREFIX."currency where id=1");
                    $row4=mysql_fetch_array($res4);
                    $row['price']=floor($row4[$row4['currency']]*$row4['ratio']*$row['price']);
                }
                //валюта
                $sum+=$row['price']*$row['amount'];
                $prices.=$row['price'].",";
                $row['tabindex']=$i;
                render_to_template("components/preorder/template.table.php", $row);
            } 
        } else {
            $arr['reserved']=false;
            render_to_template("components/preorder/template.tableHeader.php", $arr);
        }

        $arr['ids']="[".substr($ids, 0, -1)."]";
        $arr['prices']="[".substr($prices, 0, -1)."]";
        $arr['sum']=$sum;
        render_to_template("components/preorder/template.tableFooter.php", $arr);
    
        ///нет на складе
        $arr['reserved']=false;
        $arr['order']=false;$sum=0;
        mysql_query("SET SQL_BIG_SELECTS=1");
        if($_SESSION['actype'][0]==1) {
            $res=mysql_query("select a.*,b.id as det_id,b.oem,b.model_id,b.description,b.available,b.special,b.country,c.name as brandname,d.name as modelname,e.price,f.id as itemid from ".$PREFIX."preorder as a,".$PREFIX."catalog_items as b,".$PREFIX."catalog_brands as c,".$PREFIX."catalog_models as d, `".$PREFIX."price_".$_SESSION['userid']."` as e,".$PREFIX."catalog_items2 as f where b.brand_id=c.id and b.model_id=d.id and a.gruz_id=b.name and b.name=e.name and b.name=f.linked_item and a.user_id='".$_SESSION['userid']."' and b.available=0 order by a.preorder_date");//a.storage=0
        } elseif($_SESSION['actype'][0]==0) {
            $res=mysql_query("select a.*,b.id as det_id,b.oem,b.model_id,b.description,b.available,b.price,b.special,b.country,c.name as brandname,d.name as modelname,f.id as itemid from ".$PREFIX."preorder as a,".$PREFIX."catalog_items as b,".$PREFIX."catalog_brands as c,".$PREFIX."catalog_models as d,".$PREFIX."catalog_items2 as f where b.brand_id=c.id and b.model_id=d.id and a.gruz_id=b.name and b.name=f.linked_item and a.user_id='".$_SESSION['userid']."' and b.available=0 order by a.preorder_date");
        }

        if(mysql_num_rows($res)) {
            $userorders=1;
            //$arr['reserved']=true;
            $arr['user']=$_SESSION['userid'];
            $arr['title']="Пока нет на складе";
            $flag=0;$arr['top']=false;
            while($row=mysql_fetch_array($res)){
                $i++;
                $arr['reserved']=true;
                if($flag==0) {
                     render_to_template("components/preorder/template.tableHeader.php", $arr);
                     $flag=1;
                }
                $arr[]=$row['id'];
                $row['RESERVE']=$RESERVE;
                $row['price']=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1 && $row['special']=='')?floor($row['price']*(100-$_SESSION['percent'])/100):$row['price'];
          
                //валюта
                if($_SESSION['actype'][0]==1 && $_SESSION['actype'][6]==1 && $_COOKIE['currency']=='rub') {
                    $res4=mysql_query("select euro,dollar,currency,ratio from ".$PREFIX."currency where id=1");
                    $row4=mysql_fetch_array($res4);
                    $row['price']=floor($row4[$row4['currency']]*$row4['ratio']*$row['price']);
                }
                //валюта
                $sum+=$row['price']*$row['amount'];
                $row['tabindex']=$i;
                render_to_template("components/preorder/template.table.php", $row);
            } 
        } else {
            $arr['reserved']=false;
            render_to_template("components/preorder/template.tableHeader.php", $arr);
        }
        if($userorders==0) {
            render_to_template("components/preorder/template.tableEmpty.php", "");
        } else {
            $arr['sum']=$sum;
            render_to_template("components/preorder/template.tableFooter.php", $arr);
        }
    
    
    } else {
        echo "Доступ запрещен";
    }
}
?>
