<?php
if($_SESSION['userid']) {
    if($_SESSION['actype'][1]==1) {
        $id = mysql_real_escape_string($_GET['id']);
        if($id) {
            $id=str_replace("id-", "", $id);
            mysql_query("update ".$PREFIX."reserved set add_date=0 where user_id='".$_SESSION['userid']."' and id=".$id);
        }
        include_once "inc/users.configuration.php";
        $active=time()-($RESERVE*60*60);
        if($_SESSION['actype'][0]==1) {
            mysql_query("SET SQL_BIG_SELECTS=1");
            $res=mysql_query("select a.*,b.oem,b.model_id,b.description,b.special,b.country,c.name as brandname,d.name as modelname,e.price,f.id as itemid from ".$PREFIX."reserved as a,".$PREFIX."catalog_items as b,".$PREFIX."catalog_brands as c,".$PREFIX."catalog_models as d, `".$PREFIX."price_".$_SESSION['userid']."` as e,".$PREFIX."catalog_items2 as f where b.brand_id=c.id and b.model_id=d.id and a.gruz_id=b.name and b.name=e.name and b.name=f.linked_item and a.user_id='".$_SESSION['userid']."' and a.add_date>".$active);
        } else {
            mysql_query("SET SQL_BIG_SELECTS=1");
            $res=mysql_query("select a.*,b.oem,b.model_id,b.description,b.price,b.special,b.country,c.name as brandname,d.name as modelname,f.id as itemid from ".$PREFIX."reserved as a,".$PREFIX."catalog_items as b,".$PREFIX."catalog_brands as c,".$PREFIX."catalog_models as d,".$PREFIX."catalog_items2 as f where b.brand_id=c.id and b.model_id=d.id and a.gruz_id=b.name and b.name=f.linked_item and a.user_id='".$_SESSION['userid']."' and a.add_date>".$active);
        }
        if(mysql_num_rows($res)) {
            $arr['reserved']=true;
            render_to_template("components/reserve/template.tableHeader.php", $arr);
            while($row=mysql_fetch_array($res)){
                $arr[]=$row['id'];
                $row['RESERVE']=$RESERVE;
                $row['price']=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?floor($row['price']*(100-$_SESSION['percent'])/100):$row['price'];
                //валюта
                if($_SESSION['actype'][0]==1 && $_SESSION['actype'][6]==1 && $_COOKIE['currency']=='rub') {
                        $res4=mysql_query("select euro,dollar,currency,ratio from ".$PREFIX."currency where id=1");
                        $row4=mysql_fetch_array($res4);
                          $row['price']=floor($row4[$row4['currency']]*$row4['ratio']*$row['price']);
                }
                //валюта
                render_to_template("components/reserve/template.table.php", $row);
            } 
        } else {
            $arr['reserved']=false;
            render_to_template("components/reserve/template.tableHeader.php", $arr);
        }
        render_to_template("components/reserve/template.tableFooter.php", $arr);
    } else {
        echo "Доступ запрещен";
    }
}
?>
