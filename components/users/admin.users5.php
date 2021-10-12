<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 
if(file_exists("inc/mail.templates.php")) {
    include_once "inc/mail.templates.php";
}
if(file_exists("inc/mail.system.templates.php")) {
    include_once "inc/mail.system.templates.php";
}
require_once 'inc/ckeditor/ckeditor.php' ;
require_once 'inc/ckfinder/ckfinder.php' ;
$ckeditor = new CKEditor();
$ckeditor->basePath    = 'inc/ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, 'inc/ckfinder/');
$mcontent="Текст";
$button="Сохранить как шаблон";
$replacearray=array('{:sitetitle:}','{:url:}','{:password:}','{:username:}','{:userid:}','{:usermail:}','{:userpercent:}','{:usermoney:}','{:useramount:}','{:userdata:}','{:actions:}','{:subscribe:}','{:unsubscribe:}');
$descriptionarray=array('Название фирмы','Адрес сайта (http://'.$_SERVER['HTTP_HOST'].')','Смена пароля','ФИО клиента','ID клиента','Email клиента','скидка клиента (%)','Количество денег потраченное на сайте','Количество купленных деталей','Данные клиента(Дополнительная информация)','Акции','Код подписки','Код отписки');
$k=0;
foreach($replacearray as $num=>$val){
    $variables.=$val." - ".$descriptionarray[$k]."<br />";
    $k++;
}
//$variables=implode("<br />",$replacearray);


if ($_POST['send'] && strlen($_POST['frm_name'])>3 && strlen($_POST['frm_text'])>10) {
    $query="";$actions="";
    if($_POST['adress']==2) {
        //$where=" where actype LIKE '0%'";
        $query="select * from ".$PREFIX."users where actype LIKE '0%'";
    } elseif($_POST['adress']==1) {
        //$where=" where actype LIKE '1%'";
        $query="select * from ".$PREFIX."users where actype LIKE '1%'";
    } elseif($_POST['adress']==3) {
        $query="select * from ".$PREFIX."users";
    }
    if($query!="") {
        $row=mysql_query($query);
  
  
        while($res=mysql_fetch_array($row)){
            $pass="";
            $newvalues=array($PAGE_TITLE,$PATH,'{:password:}',$res['name'],$res['id'],$res['email'],$res['percent'],$res['money'],$res['amount'],$res['udata'],'{:actions:}');

            $lettitle=str_replace($replacearray, $newvalues, $_POST['frm_name']);

            if(strpos($lettitle, "{:password:}")!==false) {
                $pass=generate_password(7);
                $lettitle=str_replace("{:password:}", $pass, $lettitle);
                mysql_query("update ".$PREFIX."users set password='".md5($pass)."' where id='".$res['id']."'");
            }
            if(strpos($lettitle, "{:actions:}")!==false ) {
                if($actions=="") {
                    $row3=mysql_query("select a.special, b.id from ".$PREFIX."catalog_items as a, ".$PREFIX."catalog_items2 as b where a.name=b.linked_item and a.special!=''");//distinct
                    while($res3=mysql_fetch_row($row3)){
                        $actions.="<a href=\"".$PATH."/catalog/item-".$res3[1]."\">".$res3[0]."</a><br/>";
                    }
                }
                $lettitle=str_replace("{:actions:}", $actions, $lettitle);
            }

            $letcontent=str_replace($replacearray, $newvalues, $_POST['frm_text']);
            if(strpos($letcontent, "{:password:}")!==false) {
                $pass=($pass=="")?generate_password(7):$pass;
                $letcontent=str_replace("{:password:}", $pass, $letcontent);
                mysql_query("update ".$PREFIX."users set password='".md5($pass)."' where id='".$res['id']."'");
            }
            if(strpos($letcontent, "{:actions:}")!==false ) {
                if($actions=="") {
                    $actions="Новые акции на сайте:<br/>";
                    $row3=mysql_query("select a.description,a.special, b.id from ".$PREFIX."catalog_items as a, ".$PREFIX."catalog_items2 as b where a.name=b.linked_item and a.special!=''");//distinct
                    while($res3=mysql_fetch_row($row3)){
                        $actions.=$res3[0]." <a href=\"".$PATH."/catalog/item-".$res3[2]."\">".$res3[1]."</a><br/>";
                    }
                }
                $letcontent=str_replace("{:actions:}", $actions, $letcontent);
            }

            $umail=$res['email'];
            $from=$ADMIN_EMAIL;
            $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $lettitle))."?=";
            $mess=$letcontent;
            $mess=iconv("UTF-8", "koi8-r", $mess);
            $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
            mail($umail, $ltitle, $mess, $headers);
        }
    }
    if($_POST['adress']==4 || $_POST['adress']==3) {
        $query="select email,name from ".$PREFIX."submission where code='0'";
        $row=mysql_query($query);
        while($res=mysql_fetch_array($row)){
            $pass="";
            $newvalues=array($PAGE_TITLE,$PATH,'',$res['name'],'',$res['email'],'','','','','{:actions:}');

            $lettitle=str_replace($replacearray, $newvalues, $_POST['frm_name']);
            $letcontent=str_replace($replacearray, $newvalues, $_POST['frm_text']);
            if(strpos($letcontent, "{:actions:}")!==false ) {
                if($actions=="") {
                    $actions="Новые акции на сайте:<br/>";
                    $row3=mysql_query("select a.description,a.special, b.id from ".$PREFIX."catalog_items as a, ".$PREFIX."catalog_items2 as b where a.name=b.linked_item and a.special!=''");//distinct
                    while($res3=mysql_fetch_row($row3)){
                        $actions.=$res3[0]." <a href=\"".$PATH."/catalog/item-".$res3[2]."\">".$res3[1]."</a><br/>";
                    }
                }
                $letcontent=str_replace("{:actions:}", $actions, $letcontent);
            }

            $umail=$res['email'];
            $from=$ADMIN_EMAIL;//;
            $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $lettitle))."?=";
            $mess=$letcontent;
            $mess=iconv("UTF-8", "koi8-r", $mess);
            $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
            mail($umail, $ltitle, $mess, $headers);
        }
    }
  
  
}
if($_GET['id'] && $_GET['a']=="del") {
    unset($mailtemplates[$_GET['id']]);
    $mailarr=var_export($mailtemplates, true);
    $mailarr="<?php\r\n\$mailtemplates=".$mailarr.";\r\n?>";
    $fp=fopen("inc/mail.templates.php", "w+");
    fwrite($fp, $mailarr);
    fclose($fp);
}
if($_POST['save'] && strlen($_POST['frm_name'])>3) {
    if($_GET['t']=="s") {
        $mailsystemtemplates[$_POST['frm_id']]=array($_POST['frm_name'],$_POST['frm_text']);
        $mailarr=var_export($mailsystemtemplates, true);
        $mailarr="<?php\r\n\$mailsystemtemplates=".$mailarr.";\r\n?>";
        $fp=fopen("inc/mail.system.templates.php", "w+");
        fwrite($fp, $mailarr);
        fclose($fp);
    } else {
        $mailtemplates[$_POST['frm_id']]=array($_POST['frm_name'],$_POST['frm_text']);
        $mailarr=var_export($mailtemplates, true);
        $mailarr="<?php\r\n\$mailtemplates=".$mailarr.";\r\n?>";
        $fp=fopen("inc/mail.templates.php", "w+");
        fwrite($fp, $mailarr);
        fclose($fp);
    }
}
if($_GET['id']) {
    $mid=$_GET['id'];
    $readonly="READONLY ";
    if($_GET['t']=="s") {
        list($mtitle,$mcontent)=$mailsystemtemplates[$_GET['id']];
    } elseif($_GET['t']=="a") {
        list($mtitle,$mcontent)=$mailtemplates[$_GET['id']];
    }
    $button="Изменить шаблон";
}
?>
<br />
<form method="post">
    <table width="100%">
         <tr>
            <td colspan=2>Переменные:<br /><?php echo $variables?></td>
        </tr>
         <tr>
            <td width="200">Название латиницей:</td><td><input class="textbox" name="frm_id" type="text" style="width: 100%;" value="<?php echo $mid ?>" <?php echo $readonly?>/></td>
        </tr>
        <tr>
            <td width="200">Заголовок:</td><td><input class="textbox" name="frm_name" type="text" style="width: 100%;" value="<?php echo $mtitle ?>"></td>
        </tr>

        <tr>
            <td colspan="2"><textarea name="frm_text" class="ckeditor" id="editor_ck"><?php echo $mcontent ?></textarea></td>
        </tr>
        <tr> 
            <td align="left">Отправить пользователям:</td><td align="right">Всем<input type="radio" name="adress" value="3" checked> Прайс-лист<input type="radio" name="adress" value="1"> Процент<input type="radio" name="adress" value="2"> Подписчикам<input type="radio" name="adress" value="4"></td>
        </tr>
        <tr> 
            <td align="left"><br /><input type="submit" name="save" class="button" value="<?php echo $button?>"></td><td align="right"><br /><input type='hidden' name='editid' value='<?php echo $editid ?>'><input type="submit" name="send" class="button" value="Отправить"></td>
        </tr>
    </table>
    <script type="text/javascript">//<![CDATA[
    window.CKEDITOR_BASEPATH='inc/ckeditor/';
    //]]></script>
    <script type="text/javascript" src="inc/ckeditor/ckeditor.js?t=B1GG4Z6"></script>
    <script type="text/javascript">//<![CDATA[
    CKEDITOR.replace('editor_ck', { "filebrowserBrowseUrl": "\/inc\/ckfinder\/ckfinder.html", "filebrowserImageBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Images", "filebrowserFlashBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Flash", "filebrowserUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files", "filebrowserImageUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images", "filebrowserFlashUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash" });
    //]]></script>
</form>
<?php
echo "<table><tr><td colspan=2>Системные сообщения</td></tr>";
foreach($mailsystemtemplates as $mid=>$mcont){
    list($title,$content)=$mcont;
    echo "<tr><td><a href=\"?component=users&action=5&id=$mid&t=s\">$title</a></td><td></td></tr>";
}
echo "<table><tr><td colspan=2>Ваши шаблоны</td></tr>";
foreach($mailtemplates as $mid=>$mcont){
    list($title,$content)=$mcont;
    echo "<tr><td><a href=\"?component=users&action=5&id=$mid&t=a\">$title</a></td><td><a href=\"?component=users&action=5&id=$mid&a=del\">[ удалить ]</a></td></tr>";
}
echo "<table>";
?>
