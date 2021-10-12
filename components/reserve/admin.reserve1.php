<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
require_once "inc/users.configuration.php";
$id = mysql_real_escape_string($_GET['id']);
$active=time()-($RESERVE*60*60);
if($_GET['clear']==1) {
    mysql_query("delete from ".$PREFIX."reserved where add_date<$active");
}
if($id) {
    mysql_query("update ".$PREFIX."reserved set add_date=1 where id=".$id);
    //echo "update reserved set add_date=0 where user_id='".$_SESSION['userid']."' and id=".$id;
}

$res=mysql_query("select a.*,b.oem,b.name,b.description,b.price,b.special,b.country,c.name as brandname,d.name as modelname from ".$PREFIX."reserved as a,".$PREFIX."catalog_items as b,".$PREFIX."catalog_brands as c,".$PREFIX."catalog_models as d where b.brand_id=c.id and b.model_id=d.id and a.gruz_id=b.name and a.add_date>".$active." order by user_id");
if(mysql_num_rows($res)) {
      $arr['reserved']=true;
      $arr['action']=1;
      render_to_template("components/reserve/template.adminHeader.php", $arr);
    while($row=mysql_fetch_array($res)){
        $res2=mysql_query("select name,company,actype,percent from ".$PREFIX."users where id='".$row['user_id']."' limit 1");
        //echo "select name,company,actype,percent from users where id='".$row['user_id']."' limit 1";
        $row2=mysql_fetch_array($res2);
        //echo $row2['name'].$row2['actype'][0]."<br>";
        if($row2['actype'][0]==1) {
             $res3=mysql_query("select price from `".$PREFIX."price_".$row['user_id']."` where name='{$row['gruz_id']}' limit 1");    
             $row3=mysql_fetch_array($res3);
            $row['price']=$row3[0];
        } else {
                $row['price']=($row2['percent']>0)?floor($row['price']*(100-$row2['percent'])/100):$row['price'];
        }


        $row['client']=($row2[1])?$row2[1]:$row2[0];
        $row['RESERVE']=$RESERVE;
        $row['action']=1;
        render_to_template("components/reserve/template.adminTable.php", $row);
    } 
      render_to_template("components/reserve/template.adminFooter.php", $arr);
}
?>

