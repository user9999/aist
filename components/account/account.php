<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
if(isset($_SESSION['partnerid']) && !$_SESSION['blok']) {
    $res=mysql_query('select cashsum from '.$PREFIX.'partner_money where partnerid='.$_SESSION['partnerid'].' order by id desc limit 1');
    $row=mysql_fetch_row($res);
    if(!$_GET['id']) {
        $title='Аккаунт партнера '.$_SESSION['pname'];
        $content='Ваш ID: '.$_SESSION['partnerid'];
        $content.="<p>Можно ставить ссылку с параметром partner=".$_SESSION['partnerid']." на любую страницу. Например:</p>
  $PATH/?partner=".$_SESSION['partnerid']."<br>
  $PATH/catalog/catalog?partner=".$_SESSION['partnerid']."<br>
  $PATH/catalog/renault?partner=".$_SESSION['partnerid']."<br>
  $PATH/catalog/model-67?partner=".$_SESSION['partnerid']."<br>
  $PATH/action?partner=".$_SESSION['partnerid']."<br><br>
  Пример текстовой ссылки:<br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/?partner='.$_SESSION['partnerid'].'" target=_blank>Рекламный текст</a>')."</textarea><br><br>
  Ссылка на страницу Бампера:<br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/catalog/bamper?partner='.$_SESSION['partnerid'].'" target=_blank>Рекламный текст</a>')."</textarea><br><br>
  Ссылка на страницу Капоты:<br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/catalog/cowl?partner='.$_SESSION['partnerid'].'" target=_blank>Рекламный текст</a>')."</textarea><br><br>
  Ссылка на страницу Крылья:<br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/catalog/wings?partner='.$_SESSION['partnerid'].'" target=_blank>Рекламный текст</a>')."</textarea><br><br>

  <p> <b>Также вы можете использовать наши баннеры. Например:</b></p><br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/?partner='.$_SESSION['partnerid'].'" target=_blank><img src="'.$PATH.'/img/468x60.gif" alt=""></a>')."</textarea><br>
  <img src='".$PATH."/img/468x60.gif' alt=''><br><br>
  
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/?partner='.$_SESSION['partnerid'].'" target=_blank><img src="'.$PATH.'/img/88x31.gif" alt=""></a>')."</textarea><br>
  <img src='".$PATH."/img/88x31.gif' alt=''><br><br>";
        $content.="<textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/?partner='.$_SESSION['partnerid'].'" target=_blank><img src="'.$PATH.'/img/120x240.gif" alt=""></a>')."</textarea><br>
  <img src='".$PATH."/img/120x240.gif' alt=''><br><br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/?partner='.$_SESSION['partnerid'].'" target=_blank><img src="'.$PATH.'/img/125x125.gif" alt=""></a>')."</textarea><br>
  <img src='".$PATH."/img/125x125.gif' alt=''><br><br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/?partner='.$_SESSION['partnerid'].'" target=_blank><img src="'.$PATH.'/img/160x400.gif" alt=""></a>')."</textarea><br>
  <img src='".$PATH."/img/160x400.gif' alt=''><br><br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/?partner='.$_SESSION['partnerid'].'" target=_blank><img src="'.$PATH.'/img/240x400.gif" alt=""></a>')."</textarea><br>
  <img src='".$PATH."/img/240x400.gif' alt=''><br><br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/?partner='.$_SESSION['partnerid'].'" target=_blank><img src="'.$PATH.'/img/250x250.gif" alt=""></a>')."</textarea><br>
  <img src='".$PATH."/img/250x250.gif' alt=''><br><br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/?partner='.$_SESSION['partnerid'].'" target=_blank><img src="'.$PATH.'/img/250x250-2.gif" alt=""></a>')."</textarea><br>
  <img src='".$PATH."/img/250x250-2.gif' alt=''><br><br>
  <textarea rows=2 cols=60>".htmlspecialchars('<a href="'.$PATH.'/?partner='.$_SESSION['partnerid'].'" target=_blank><img src="'.$PATH.'/img/250x250-3.gif" alt=""></a>')."</textarea><br>
  <img src='".$PATH."/img/250x250-3.gif' alt=''><br><br>
  ";  
  
        $script='<script src="'.$PATH.'/inc/jcarousellite_1.0.1c4.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){$(".gruzzap-jcarousellite").jCarouselLite({vertical:true,hoverPause:true,visible:5,auto:500,speed:2500});
$(".newsticker-jcarousellite1").jCarouselLite({vertical:true,hoverPause:true,visible:5,auto:500,speed:3500});});
</script>';
        set_script($script);
        $css='
* { margin:0; padding:0;}
#newsticker-gruzzap{width:200px;border:1px solid black;padding:2px 0 0 3px;font-family:Arial,Verdana,Sans-Serif;font-size:13px;margin:auto;background:#eee;}
#newsticker-gruzzap a{text-decoration:none;}
#newsticker-gruzzap img{border: 2px solid #FFFFFF;}
#newsticker-gruzzap .title{text-align:center;font-size:14px;font-weight:bold;padding:5px;}
.gruzzap-jcarousellite{width:98%;height:320px;}
.gruzzap-jcarousellite ul li{list-style:none; display:block; padding-bottom:1px; margin-bottom:5px;}
.gruzzap-jcarousellite .thumbnail{float:left; width:70%;}
.gruzzap-jcarousellite .info{float:right; width:25%;}
.gruzzap-jcarousellite .info span.cat{display: block; font-size:10px; color:#808080;}
.clear{clear: both;}
#newsticker-gruzzap li{border-bottom:1px solid black}';
        $css1='
#newsticker-demo1{width:200px;border:1px solid black;padding:2px 0 0 3px;font-family:Arial,Verdana,Sans-Serif;font-size:13px;margin:auto;background:#eee;}
#newsticker-demo1 a{text-decoration:none;}
#newsticker-demo1 img{border: 2px solid #FFFFFF;}
#newsticker-demo1 .title{text-align:center;font-size:14px;font-weight:bold;padding:5px;}
.newsticker-jcarousellite1{width:98%;height:200px !important;}
.newsticker-jcarousellite1 ul li{list-style:none; display:block; padding-bottom:1px; margin-bottom:5px;}
.newsticker-jcarousellite1 .thumbnail{float:left; width:70%;}
.newsticker-jcarousellite1 .info{float:right; width:25%;}
.newsticker-jcarousellite1 .info span.cat{display: block; font-size:10px; color:#808080;}
#newsticker-demo1 li{border-bottom:1px solid black}';
        $css2='
* { margin:0; padding:0;}
#newsticker1-gruzzap{width:200px;border:1px solid black;padding:2px 0 0 3px;font-family:Arial,Verdana,Sans-Serif;font-size:13px;margin:auto;background:#eee;}
#newsticker1-gruzzap a{text-decoration:none;}
#newsticker1-gruzzap img{border: 2px solid #FFFFFF;}
#newsticker1-gruzzap .title{text-align:center;font-size:14px;font-weight:bold;padding:5px;}
.gruzzap-jcarousellite1{width:98%;height:200px !important;}
.gruzzap-jcarousellite1 ul li{list-style:none; display:block; padding-bottom:1px; margin-bottom:5px;}
.gruzzap-jcarousellite1 .thumbnail{float:left; width:70%;}
.gruzzap-jcarousellite1 .info{float:right; width:25%;}
.gruzzap-jcarousellite1 .info span.cat{display: block; font-size:10px; color:#808080;}
.clear{clear: both;}
#newsticker1-gruzzap li{border-bottom:1px solid black}';
        $gcss='<style type="text/css">
'.$css.$css1.'
</style>';
        set_css($gcss);
        $content.="<br><br><h3>Модуль скидок</h3><p>Добавьте следующий скрипт в заголовок (между тегами head)</p><textarea rows=3 cols=80>".htmlspecialchars('<script type="text/javascript" src="http://partner.'.$_SERVER['HTTP_HOST'].'/script/jquery_min.js"></script>')."</textarea>
  <p>Добавьте в свою таблицу стилей и отредактируйте следующий CSS:</p><textarea rows=7 cols=80>".htmlspecialchars($css)."</textarea><br><br>
  <p>В том месте где должен отображаться блок, добавьте скрипт</p><textarea rows=2 cols=80>".htmlspecialchars('<script type="text/javascript" src="http://partner.'.$_SERVER['HTTP_HOST'].'/carousel/script.php?partner='.$_SESSION['partnerid'].'">')."</textarea><br><br>
";
        $content1="  <h3>Модуль новых поступлений</h3><p>Добавьте следующий скрипт в заголовок (между тегами head)</p><textarea rows=3 cols=80>".htmlspecialchars('<script type="text/javascript" src="http://partner.'.$_SERVER['HTTP_HOST'].'/script/jquery_min.js"></script>')."</textarea>
  <p>Добавьте в свою таблицу стилей и отредактируйте следующий CSS:</p><textarea rows=7 cols=80>".htmlspecialchars($css2)."</textarea><br><br>
  <p>В том месте где должен отображаться блок, добавьте скрипт</p><textarea rows=2 cols=80>".htmlspecialchars('<script type="text/javascript" src="http://partner.'.$_SERVER['HTTP_HOST'].'/carousel/script1.php?partner='.$_SESSION['partnerid'].'">')."</textarea><br>";
        $content2="<br><h3>Скрипт партнерского магазина</h3>
  <p>Разархивируйте в корневую директорию сайта и перейдите по адресу http://ваш_Домен.ru/install.php</p>
<a href=\"javascript:void(0)\" onclick=\"window.open('/shop.php','shop','width=200,height=180,top=0,left=0,resize=0')\">Скачать</a>";
 
  
  
        render_to_template("components/account/template.account.php", array('title'=>$title,'content'=>$content,'content1'=>$content1,'content2'=>$content2,'cash'=>$row[0]));
    } elseif($_GET['id']=='settings') {
  
        $title="Настройки";
        $content="";
        if($_POST['password']) {
            $err='';
            if($_POST['oldpass']!=$_POST['oldpass1']) { $err='Не совпадают пароли<br>';
            }
            if($err=='') {
                $row=mysql_query('select id from '.$PREFIX.'partner_users where id='.$_SESSION['partnerid'].' AND password="'.md5($_POST['oldpass']).'"');
            }
            if(mysql_num_rows($row)!=1) { $err.='Не правильный пароль';
            }
            if($err=='') {
                mysql_query('update '.$PREFIX.'partner_users set password="'.md5($_POST['pass']).'" where id='.$_SESSION['partnerid']);
                $content='Пароль успешно изменен!';
            } else {
                $content=$err;
            }
        }
        render_to_template("components/account/template.settings.php", array('title'=>$title,'content'=>$content,'cash'=>$row[0]));
    } elseif($_GET['id']=='withdraw') {
        $sres=mysql_query('select '.$PREFIX.'withdraw from partner_rules where id=1');
        $srow=mysql_fetch_row($sres);
        $s=explode(",", $srow[0]);
        $systems="";
        foreach($s as $num=>$val){
            $val=trim($val);
            if(strlen($val)>1) {
                $systems.='<option value="'.$val.'">'.$val.'</option>';
            }   
        }
        $res2=mysql_query('select id from '.$PREFIX.'partner_withdraw where partnerid='.$_SESSION['partnerid'].' and confirm!=""');
        $confirm=(mysql_num_rows($res2))?1:0;
        if($_POST['submit']) {
            $err='';
            $cash=str_replace(",", ".", $_POST['withdraw']);
            if(!preg_match("![0-9\.]+!", $cash)) {
                $err='Неверно введена сумма';
            } elseif($cash>$row[0]) {
                $err='Вы столько не заработали';
            }
            if($err=='') {
                $code=time().$_SESSION['partnerid'];
                $code=md5($code);
                mysql_query('insert into '.$PREFIX.'partner_withdraw set partnerid='.$_SESSION['partnerid'].',cash='.$cash.',paysys="'.addslashes($_POST['where']).'",number="'.addslashes($_POST['account']).'",confirm="'.$code.'",ordertime='.time());
                //echo 'insert into partner_withdraw set patnerid='.$_SESSION['partnerid'].',cash='.$cash.',paysys="'.addslashes($_POST['where']).'",number="'.addslashes($_POST['account']).'",confirm="'.md5($code).'"';
        
                mysql_query('update '.$PREFIX.'partner_money set cashsum=cashsum-'.$cash.' where partnerid='.$_SESSION['partnerid']);
                mysql_query('update '.$PREFIX.'partner_money set cashsum=0 where cashsum<0');
                $mess='Вы заказали выплату '.$cash.' руб. Проверьте данные выплаты и скопируйте код для подтверждения и введите его в аккаунте в разделе заказ выплат.

        Способ оплаты:'.$_POST['where'].'
        Ваш счет:'.$_POST['account'].'
        
        код для подтверждения заказа: '.$code;
        
                mail($_SESSION['email'], $_SERVER['HTTP_HOST'].' - Заказ выплат', $mess);
                $confirm=1;
                $err="Запрос на выплату получен. Вам отправлено письмо для подтверждения выплаты.";
            }
        }
        if($_POST['code']) {
            $resm=mysql_query('select email from '.$PREFIX.'partner_rules where id=1');
            $rowm=mysql_fetch_row($resm);
            mysql_query('update '.$PREFIX.'partner_withdraw set confirm="",confirmtime='.time().' where partnerid='.$_SESSION['partnerid'].' and confirm="'.addslashes(trim($_POST['confirm'])).'"');
            $err="Заказ подтвержден.";
            $mess='Партнер '.$_SESSION['pname']. 
            $PATH.'/admin/?component=partner&action=3';
            mail($rowm[0], $_SERVER['HTTP_HOST'].' - Заказана выплата', $mess);
            $confirm=0;
        }
        if($_POST['letter']) {
            $res3=mysql_query('select cash,paysys,number,confirm from '.$PREFIX.'partner_withdraw where partnerid='.$_SESSION['partnerid'].' order by id desc limit 1');
            //echo 'select cash,paysys,number,confirm from partner_withdraw where partnerid='.$_SESSION['partnerid'].' order by id desc limit 1';
            $row3=mysql_fetch_row($res3);
            $mess='Вы заказали выплату '.$row3[0].' руб. Проверьте данные выплаты и скопируйте код для подтверждения и введите его в аккаунте в разделе заказ выплат.

        Способ оплаты:'.stripslashes($row3[1]).'
        Ваш счет:'.stripslashes($row3[2]).'
        
        код для подтверждения заказа: '.$row3[3];
        
            mail($_SESSION['email'], $_SERVER['HTTP_HOST'].' - Заказ выплат', $mess);
            $err="Письмо отправлено";
        }
        $title="Заказ выплат";
        $res1=mysql_query('select minimum from '.$PREFIX.'partner_rules where id=1');
        $row1=mysql_fetch_row($res1);
    
        $content="";
        render_to_template("components/account/template.withdraw.php", array('title'=>$title,'content'=>$content,'cash'=>$row[0],'min'=>$row1[0],'confirm'=>$confirm,'error'=>$err, 'systems'=>$systems));
    } elseif($_GET['id']=='message') {
        if(preg_match("!^[0-9]+$!", $_GET['delid'])) {
            $del=$_GET['delid'];
            $res=mysql_query('select sender,recipient from '.$PREFIX.'partner_message where id='.$del);
            $row=mysql_fetch_row($res);
            if($row[0]==$_SESSION['partnerid'] || $row[1]==$_SESSION['partnerid']) {
                mysql_query('update '.$PREFIX.'partner_message set status=4 where id='.$del);
            }
        }
        if($_POST['send']) {
            $error='';
            $error=(strlen($_POST['title'])>3)?"":"Слишком короткий заголовок<br>";
            $error.=(strlen($_POST['message'])>10)?"":"Слишком короткое сообщение<br>";
    
            if($error=='') {
                $res=mysql_query('select id from '.$PREFIX.'partner_message where title="'.addslashes($_POST['title']).'" and message="'.addslashes($_POST['message']).'" and sender='.$_SESSION['partnerid']);
                if(mysql_num_rows($res)>0) {
                    $error="Это сообщение уже в базе!";
                } else {
                    mysql_query('insert into '.$PREFIX.'partner_message set sender='.$_SESSION['partnerid'].',title="'.addslashes($_POST['title']).'",message="'.addslashes($_POST['message']).'",recipient=0,sendtime='.time());
                    $error="Сообщение отправлено.";
                }
            }
        }
        //'select * from partner_message where sender='.$_SESSION['partnerid'].' or recipient='.$_SESSION['partnerid'].' order by sendtime,message_id desc';
        $message="";$title="Сообщение админу";
        render_to_template("components/account/template.message.php", array('title'=>$title,'content'=>$content,'cash'=>$row[0],'message'=>$message,'error'=>$error));
  
    } elseif($_GET['id']=='material') {
        $title='Материалы';
        $script='<script src="'.$PATH.'/inc/jcarousellite_1.0.1c4.js" type="text/javascript"></script>
<script type="text/javascript">
$(function(){$(".gruzzap-jcarousellite").jCarouselLite({vertical:true,hoverPause:true,visible:5,auto:500,speed:2500});
$(".newsticker-jcarousellite1").jCarouselLite({vertical:true,hoverPause:true,visible:5,auto:500,speed:3500});});
</script>';
        set_script($script);
    
        $css='
* { margin:0; padding:0;}
#newsticker-gruzzap{width:200px;border:1px solid black;padding:2px 0 0 3px;font-family:Arial,Verdana,Sans-Serif;font-size:13px;margin:auto;background:#eee;}
#newsticker-gruzzap a{text-decoration:none;}
#newsticker-gruzzap img{border: 2px solid #FFFFFF;}
#newsticker-gruzzap .title{text-align:center;font-size:14px;font-weight:bold;padding:5px;}
.gruzzap-jcarousellite{width:98%;height:320px;}
.gruzzap-jcarousellite ul li{list-style:none; display:block; padding-bottom:1px; margin-bottom:5px;}
.gruzzap-jcarousellite .thumbnail{float:left; width:70%;}
.gruzzap-jcarousellite .info{float:right; width:25%;}
.gruzzap-jcarousellite .info span.cat{display: block; font-size:10px; color:#808080;}
.clear{clear: both;}
#newsticker-gruzzap li{border-bottom:1px solid black}';
        $css1='
#newsticker-demo1{width:200px;border:1px solid black;padding:2px 0 0 3px;font-family:Arial,Verdana,Sans-Serif;font-size:13px;margin:auto;background:#eee;}
#newsticker-demo1 a{text-decoration:none;}
#newsticker-demo1 img{border: 2px solid #FFFFFF;}
#newsticker-demo1 .title{text-align:center;font-size:14px;font-weight:bold;padding:5px;}
.newsticker-jcarousellite1{width:98%;height:200px !important;}
.newsticker-jcarousellite1 ul li{list-style:none; display:block; padding-bottom:1px; margin-bottom:5px;}
.newsticker-jcarousellite1 .thumbnail{float:left; width:70%;}
.newsticker-jcarousellite1 .info{float:right; width:25%;}
.newsticker-jcarousellite1 .info span.cat{display: block; font-size:10px; color:#808080;}
#newsticker-demo1 li{border-bottom:1px solid black}';
        $css2='
* { margin:0; padding:0;}
#newsticker1-gruzzap{width:200px;border:1px solid black;padding:2px 0 0 3px;font-family:Arial,Verdana,Sans-Serif;font-size:13px;margin:auto;background:#eee;}
#newsticker1-gruzzap a{text-decoration:none;}
#newsticker1-gruzzap img{border: 2px solid #FFFFFF;}
#newsticker1-gruzzap .title{text-align:center;font-size:14px;font-weight:bold;padding:5px;}
.gruzzap-jcarousellite1{width:98%;height:200px !important;}
.gruzzap-jcarousellite1 ul li{list-style:none; display:block; padding-bottom:1px; margin-bottom:5px;}
.gruzzap-jcarousellite1 .thumbnail{float:left; width:70%;}
.gruzzap-jcarousellite1 .info{float:right; width:25%;}
.gruzzap-jcarousellite1 .info span.cat{display: block; font-size:10px; color:#808080;}
.clear{clear: both;}
#newsticker1-gruzzap li{border-bottom:1px solid black}';
        $gcss='<style type="text/css">
'.$css.$css1.'
</style>';
        set_css($gcss);
        $content="<h3>Модуль скидок</h3><p>Добавьте следующий скрипт в заголовок (между тегами head)</p><textarea rows=3 cols=80>".htmlspecialchars('<script type="text/javascript" src="http://partner.'.$_SERVER['HTTP_HOST'].'/script/jquery_min.js"></script>')."</textarea>
  <p>Добавьте в свою таблицу стилей и отредактируйте следующий CSS:</p><textarea rows=7 cols=80>".htmlspecialchars($css)."</textarea><br><br>
  <p>В том месте где должен отображаться блок, добавьте скрипт</p><textarea rows=2 cols=80>".htmlspecialchars('<script type="text/javascript" src="http://partner.'.$_SERVER['HTTP_HOST'].'/carousel/script.php?partner='.$_SESSION['partnerid'].'">')."</textarea><br><br>
";
        $content1="  <h3>Модуль новых поступлений</h3><p>Добавьте следующий скрипт в заголовок (между тегами head)</p><textarea rows=3 cols=80>".htmlspecialchars('<script type="text/javascript" src="http://partner.'.$_SERVER['HTTP_HOST'].'/script/jquery_min.js"></script>')."</textarea>
  <p>Добавьте в свою таблицу стилей и отредактируйте следующий CSS:</p><textarea rows=7 cols=80>".htmlspecialchars($css2)."</textarea><br><br>
  <p>В том месте где должен отображаться блок, добавьте скрипт</p><textarea rows=2 cols=80>".htmlspecialchars('<script type="text/javascript" src="http://partner.'.$_SERVER['HTTP_HOST'].'/carousel/script1.php?partner='.$_SESSION['partnerid'].'">')."</textarea><br>";
        render_to_template("components/account/template.material.php", array('title'=>$title,'content'=>$content,'content1'=>$content1,'cash'=>$row[0],'message'=>$message,'error'=>$error));

    } elseif($_GET['id']=='logout') {
        unset($_SESSION['partnerid']);
        unset($_SESSION['pname']);
        header("Location: $PATH/partner");
    }













}else { header("Location: ".$GLOBALS['PATH']."/partner/login");
}
?>
