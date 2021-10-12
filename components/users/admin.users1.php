<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
if(isset($_GET['login'])) {
    $res= mysql_query("select id,name,percent,actype,money,maxstorage,updtime,upctime from ".$PREFIX."users where id='".mysql_real_escape_string($_GET['login'])."'");
    if (mysql_num_rows($res)==1) {
        unset($_SESSION['user_name']);
        setcookie("currency", "", time() - 3600, '/');
        //unset($_COOKIE['currency']);
        unset($_SESSION['actype']);
        unset($_SESSION['percent']);
        unset($_SESSION['userid']);
        unset($_SESSION['update']);
        unset($_SESSION['storage']);
        $row=mysql_fetch_row($res);
        $_SESSION['userid'] = $row[0];
        $_SESSION['user_name'] = $row[1];
        $_SESSION['actype'] = $row[3];
        //$_SESSION['reserve'] = $row[3][1];
        $_SESSION['percent'] = $row[2];
        $_SESSION['storage'] = $row[5];
        if($_SESSION['actype'][0]==1) {
            $row[6]=($row[6]<$row[7])?$row[7]:$row[6];
        }
        if($row[6]>1318505860) {
            //echo "here ".date("Hч. iмин. d.m.Y",$row[6]);
            $_SESSION['update']=date("Hч. iмин. d.m.Y", $row[6]);
    
            //var_dump($_SESSION);die();
        } else {
            include_once "inc/update.php";
            $_SESSION['update']=$PRICEUPDATE;
        }
        header("location:$PATH/index");
    } else {
        $add_error="Ошибка создания клиента";
    }

}
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM ".$PREFIX."users WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."reserved WHERE user_id='{$_GET['del']}'");  
    //echo "DELETE FROM reserved WHERE user_id='{$_GET['del']}'";
    $res=mysql_query("select id FROM ".$PREFIX."preorder WHERE user_id='{$_GET['del']}'");
    while($row=mysql_fetch_row($res)){
          mysql_query("DELETE FROM ".$PREFIX."preorder_items where order_id=".$row[0]);
    }
    mysql_query("DELETE FROM ".$PREFIX."preorder WHERE user_id='{$_GET['del']}'");
    @mysql_query("DROP table `".$PREFIX."price_{$_GET['del']}`");
    //header("Location: ?component=users&action=2"); 
}
$notificate="";$max=3;$add_error="";$location=true;
$replacearray=array('{:sitetitle:}','{:url:}','{:password:}','{:username:}','{:userid:}','{:usermail:}','{:userpercent:}','{:usermoney:}','{:useramount:}','{:userdata:}','{:actions:}');
$tp=Array('kk'=>0,'ko'=>0,'ka'=>0,'tk'=>0,'to'=>0,'ta'=>0,'rk'=>0,'ro'=>0,'ra'=>0);
if (isset($_GET['edit'])) {
    $res=mysql_query("SELECT * FROM ".$PREFIX."users WHERE id='{$_GET['edit']}'");
    if ($row=mysql_fetch_row($res)) {
        $notificate="<tr><td>Оповестить по email</td><td><input type=\"checkbox\" name=\"sendemail\" value=\"1\" /></td></tr>";
        $name=$row[2];
        $email=$row[1];
        $company=$row[3];
        //echo $row[5][0]." - ".$row[5][1];
        
        if($row[5][0]==1) {
            $tprice=" checked";
            $tpercent="";
        } else {
            $tprice="";
            $tpercent=" checked";       
        }
        if($row[5][1]==1) {
            $rallow=" checked";
            $rforbid="";
        } else {
            $rallow="";
            $rforbid=" checked";       
        }   
        if($row[5][2]==1) {
            $individ=" checked";
            $cumulative="";
        } else {
            $individ="";
            $cumulative=" checked";       
        }
        if($row[5][3]==1) {
            $stallow=" checked";
            $stforbid="";
        } else {
            $stallow="";
            $stforbid=" checked";       
        }  
        if($row[5][4]==1) {
            $srallow=" checked";
            $srforbid="";
        } else {
            $srallow="";
            $srforbid=" checked";       
        }   
        if($row[5][5]==1) {
            $preallow=" checked";
            $preforbid="";
        } else {
            $preallow="";
            $preforbid=" checked";       
        }  
        if($row[5][6]==1) {
            $curr=" checked";
            $rub="";
        } else {
            $curr="";
            $rub=" checked";       
        }         
        $percent=$row[6];
        $udata=stripslashes($row[7]);
        $money=$row[8];
        $amount=$row[9];     
        $editid=$row[0];
        $oldmail=$row[1];
        $max=$row[10];
        //var_dump($row[13]);
        if($row[13]=="") {
            $tp=Array('kk'=>$percent,'ko'=>$percent,'ka'=>$percent,'tk'=>$percent,'to'=>$percent,'ta'=>$percent,'rk'=>$percent,'ro'=>$percent,'ra'=>$percent);
        } else {
            $tp=unserialize(stripslashes($row[13]));
        }
    }
}

if (isset($_POST['email'])) {

    $id=str_replace(".", "", $_POST['email']);
    $id=str_replace("-", "", $id);
    $id=str_replace("@", "", $id);
    $password=(strlen($_POST['password'])>0)?"password='".md5($_POST['password'])."',":"";
    $udata=mysql_real_escape_string($_POST['udata']);
    $acctype=($_POST['actype']==1)?"1":"0";
    $reserv=($_POST['reserv']==1)?"1":"0";
    $prctype=($_POST['prctype']==1)?"1":"0";
    $currency=($_POST['currency']==1)?"1":"0";
    $stortype=($_POST['storage']==1)?"1":"0";
    $showreserv=($_POST['showreserv']==1)?"1":"0";
        $preorder=($_POST['preorder']==1)?"1":"0";
        $trend_purc=mysql_real_escape_string(serialize($_POST['tp']));
    $actype=$acctype.$reserv.$prctype.$stortype.$showreserv.$preorder.$currency;
    $uperc=($_POST['prctype']==1)?"percent=".$_POST['percent'].",":"";
    $maxstorage=($_POST['stamount']>0 && $_POST['stamount']<1000)?$_POST['stamount']:0;
    if (!$_POST['editid']) {
        //echo "select id,name,company from users where email='".$_POST['email']."' or id='".$id."'";
        //die();
        $res=mysql_query("select id,name,company from ".$PREFIX."users where email='".$_POST['email']."' or id='".$id."'");
        if(mysql_num_rows($res)>0) {
            $row=mysql_fetch_row($res);
            $row[1]=($row[2])?$row[2]:$row[1];
            $add_error="такой клиент уже есть - <a href=\"/admin/?component=users&action=1&edit=$row[0]\">$row[1]</a>";
            $location=false;
        } else {
        
            mysql_query("INSERT INTO ".$PREFIX."users SET id='$id',email='".$_POST['email']."', name='".$_POST['name']."',company='".$_POST['company']."',$password actype='$actype',$uperc udata='$udata', maxstorage=$maxstorage,trend_purc='$trend_purc'");

            if($_POST['actype']==1) {
                $query="CREATE TABLE `".$PREFIX."price_".$id."` (`name` varchar(255) NOT NULL,`price` text NOT NULL, PRIMARY KEY (`name`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";
                mysql_query($query);
            }
      
            include_once "inc/mail.system.templates.php";
            $newvalues=array($PAGE_TITLE,$PATH,$_POST['password'],$_POST['name'],$id,$_POST['email'],$_POST['percent'],'0','0',$udata,'');
            $ltitle=str_replace($replacearray, $newvalues, $mailsystemtemplates['registration'][0]);
            $mess=str_replace($replacearray, $newvalues, $mailsystemtemplates['registration'][1]);
      
      
            $umail=$_POST['email'];
            $from=$ADMIN_EMAIL;
            $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $ltitle))."?=";
            $mess=iconv("UTF-8", "koi8-r", $mess);
            $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
            mail($umail, $ltitle, $mess, $headers);
        }
    } else {
        if($_POST['email']!=$_POST['oldmail']) {
            $res=mysql_query("select id,name,company from ".$PREFIX."users where id!='{$_POST['editid']}' and email='{$_POST['email']}'");
            if(mysql_num_rows($res)>0) {
                $row=mysql_fetch_row($res);
                $row[1]=($row[2])?$row[2]:$row[1];
                $add_error="такой клиент уже есть - <a href=\"/admin/?component=users&action=1&edit=$row[0]\">$row[1]</a>";
                $location=false;
            }
        }
        if($location) {
            mysql_query("UPDATE ".$PREFIX."users SET email='".$_POST['email']."', name='".$_POST['name']."',company='".$_POST['company']."',$password actype='$actype',$uperc udata='$udata', maxstorage=$maxstorage,trend_purc='$trend_purc' WHERE id='{$_POST['editid']}'");
            if($_POST['actype']==1) {
                $res=mysql_query("Show tables from $DATABASE_NAME like '".$PREFIX."price_".$_POST['editid']."'");
                if(mysql_num_rows($res)==0) {
                    $query="CREATE TABLE `".$PREFIX."price_".$_POST['editid']."` (`name` varchar(255) NOT NULL,`price` text NOT NULL, PRIMARY KEY (`name`)) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;";
                    mysql_query($query); 
                }
           
           
            } else {
                $res=mysql_query("Show tables from $DATABASE_NAME like '".$PREFIX."price_".$_POST['editid']."'");
                if(mysql_num_rows($res)!=0) {
                    $query="DROP TABLE `".$PREFIX."price_".$_GET['edit']."`";
                    mysql_query($query); 
                }       
            }
            if($_POST['sendemail']==1) {
                include_once "inc/mail.system.templates.php";
                $newvalues=array($PAGE_TITLE,$PATH,$_POST['password'],$_POST['name'],$_POST['editid'],$_POST['email'],$_POST['percent'],$_POST['money'],$_POST['amount'],$udata,'');

                $ltitle=str_replace($replacearray, $newvalues, $mailsystemtemplates['registration'][0]);
                $mess=str_replace($replacearray, $newvalues, $mailsystemtemplates['registration'][1]);
                $umail=$_POST['email'];
                $from=$ADMIN_EMAIL;
                $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $ltitle))."?=";
                $mess=iconv("UTF-8", "koi8-r", $mess);
                $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
                if(mail($umail, $ltitle, $mess, $headers)) {
                    echo "<br /> Сообщение отправлено на ".$umail;        
                }
            }
        }
    }
    if($location) { header("Location: ?component=users&action=1");
    }
   
}
$script="
<script type=\"text/javascript\">
function mtRand(min, max){
    var range = max - min + 1;
    var n = Math.floor(Math.random() * range) + min;
    return n;
}
function showPass(){
document.getElementById('pass').value=mkPass(mtRand(6, 10));
//prompt('Рекомендуемый пароль:', mkPass(mtRand(10, 14)));
return false;
}
function mkPass(len){
    var len=len?len:14;
    var pass = '';
    var rnd = 0;
    var c = '';
    for (i = 0; i < len; i++) {
       rnd = mtRand(0, 2); // Латиница или цифры
        if (rnd == 0) {
            c = String.fromCharCode(mtRand(48, 57));
        }
        if (rnd == 1) {
            c = String.fromCharCode(mtRand(65, 90));
        }
        if (rnd == 2) {
            c = String.fromCharCode(mtRand(97, 122));
        }
        pass += c;
    }
    return pass;
}
</script>
";
echo $script;
?>
<p style="padding-top:15px;padding-bottom:15px;font-weight:bold"><?php echo $add_error;?></p>
<form method="post">

    <table width="100%">
        <tr>
            <td width="120">ФИО:</td><td><input class="textbox" name="name" type="text" size="50" value="<?php echo $name?>"></td>
        </tr>
        <tr>
            <td width="120">Фирма:</td><td><input class="textbox" name="company" type="text" size="50" value="<?php echo $company?>"></td>
        </tr>
         <tr>
            <td width="120">email:</td><td><input class="textbox" name="email" type="text" size="50" value="<?php echo $email?>"></td>
        </tr>
        
        <tr>
            <td width="120">Пароль:</td><td><input class="textbox" name="password" type="text" size="50" value="" id="pass"> <input type="submit" value="генерировать" onclick="return showPass();" class="button" /></td>
        </tr>
         <tr>
            <td width="120">Тип аккаунта:</td><td>процент <input class="textbox" name="actype" type="radio" size="50" value="0"<?php echo $tpercent?>> прайс-лист<input class="textbox" name="actype" type="radio" size="50" value="1"<?php echo $tprice?>></td>
        </tr>
        <tr>
            <td width="120">Процент скидки:</td><td>Накопительный<input class="textbox" name="prctype" type="radio" size="50" value="0"<?php echo $cumulative?>> Индивидуальный<input class="textbox" name="prctype" type="radio" size="50" value="1"<?php echo $individ?>></td>
        </tr>
        <tr>
            <td width="120">Бронирование:</td><td>разрешить<input class="textbox" name="reserv" type="radio" size="50" value="1"<?php echo $rallow?>> запретить<input class="textbox" name="reserv" type="radio" size="50" value="0"<?php echo $rforbid?>></td>
        </tr>
                <tr>
            <td width="120">Просмотр брони:</td><td>разрешить<input class="textbox" name="showreserv" type="radio" size="50" value="1"<?php echo $srallow?>> запретить<input class="textbox" name="showreserv" type="radio" size="50" value="0"<?php echo $srforbid?>></td>
        </tr>
        <tr>
            <td width="120">Предварительный заказ:</td><td>разрешить<input class="textbox" name="preorder" type="radio" size="50" value="1"<?php echo $preallow?>> запретить<input class="textbox" name="preorder" type="radio" size="50" value="0"<?php echo $preforbid?>></td>
        </tr>
        <tr>
            <td width="120">Доступ к складам:</td><td>разрешить<input class="textbox" name="storage" type="radio" size="50" value="1"<?php echo $stallow?>> запретить<input class="textbox" name="storage" type="radio" size="50" value="0"<?php echo $stforbid?>></td>
        </tr>
        <tr>
            <td width="120">Деньги:</td><td>Валюта<input class="textbox" name="currency" type="radio" size="50" value="1"<?php echo $curr?>> Рубли<input class="textbox" name="currency" type="radio" size="50" value="0"<?php echo $rub?>></td>
        </tr>
        <tr>
            <td width="120">Макс. Кол-во на складе:</td><td><input class="textbox" name="stamount" type="text" size="50" value="<?php echo $max?>">шт</td>
        </tr>
         <tr>
            <td width="120">Скидка (процент):</td><td><input class="textbox" name="percent" type="text" size="50" value="<?php echo $percent?>">%</td>
        </tr>
        
        
                 <tr>
            <td width="120">Скидка по направлениям:</td><td>
            <table><tr><td></td><td>Кузов</td><td>Оптика</td><td>Акс.</td>
            
            </tr>
            <tr><td>Китай</td><td><input type="text" name="tp[kk]" value="<?php echo $tp['kk']?>" size=1>%</td><td><input type="text" name="tp[ko]" value="<?php echo $tp['ko']?>" size=1>%</td><td><input type="text" name="tp[ka]" value="<?php echo $tp['ka']?>" size=1>%</td>
            
            </tr>
            <tr><td>Тайвань</td><td><input type="text" name="tp[tk]" value="<?php echo $tp['tk']?>" size=1>%</td><td><input type="text" name="tp[to]" value="<?php echo $tp['to']?>" size=1>%</td><td><input type="text" name="tp[ta]" value="<?php echo $tp['ta']?>" size=1>%</td>
            
            </tr>
            <tr><td>Россия</td><td><input type="text" name="tp[rk]" value="<?php echo $tp['rk']?>" size=1>%</td><td><input type="text" name="tp[ro]" value="<?php echo $tp['ro']?>" size=1>%</td><td><input type="text" name="tp[ra]" value="<?php echo $tp['ra']?>" size=1>%</td>
            
            </tr>
            </table>
            
            </td>
        </tr>
        
        
        
        
        
        <tr>
            <td width="120">Кол-во покупок:</td><td><input type='hidden' name='amount' value='<?php echo $amount?>'><?php echo $amount?></td>
        </tr>
        <tr>
            <td width="120">Потраченная сумма:</td><td><input type='hidden' name='money' value='<?php echo $money?>'><?php echo $money?></td>
        </tr>
        <tr>

            <td width="120">Дополнительная информация:</td><td><textarea name="udata" style="border: 1px solid #ccc;font-family: Segoe UI, Tahoma, sans-serif;width:326px;height:70px"><?php echo $udata?></textarea></td>
        </tr>
        <?php
        echo $notificate;
        ?>
        <tr>
            <td></td><td><input type='hidden' name='oldmail' value='<?php echo $oldmail?>'><input type='hidden' name='editid' value='<?php echo $editid?>'><input type="submit" name="add" class="button" value="Сохранить"></td>
        </tr>
    </table>
</form>

<br />
<br />
<h1>Существующие пользователи</h1>
<?php
$res=mysql_query("SELECT id,name,company FROM ".$PREFIX."users ORDER BY company,name");
$num=0;
while ($row=mysql_fetch_row($res)) {
    $num++;
    $row[1]=(strlen($row[2])>1)?$row[2]:$row[1];
    echo $row[1]." <a href='?component=users&action=1&edit={$row[0]}'>[редактировать]</a> <a href='?component=users&action=1&del={$row[0]}'>[удалить]</a> <a href='?component=users&action=1&login=$row[0]'>[войти]</a><br />";
}
if ($num==0) { echo "Пункты не добавлены";
}

?>
