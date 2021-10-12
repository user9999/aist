<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}
if($_POST['send']) {
    $res=mysql_query('select email from '.$PREFIX.'partner_users');
    $from=$ADMIN_EMAIL;
    $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $_POST['title']))."?=";
    $mess=$_POST['frm_text'];
    $mess=iconv("UTF-8", "koi8-r", $mess);
    $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
    while($row=mysql_fetch_row($res)){
        $umail=$row[0];
        mail($umail, $ltitle, $mess, $headers);
    }
}
if($_GET['delid']) {
    mysql_query('update '.$PREFIX.'partner_message set status=5 where id='.$_GET['delid']);
}
$res=mysql_query('select a.*,b.name from '.$PREFIX.'partner_message as a,'.$PREFIX.'partner_users as b where a.recipient=0 and a.status<5 and a.sender=b.id order by a.sender,a.id desc');
while($row=mysql_fetch_array($res)){
    $color=($row['status']==0)?"#00f":"#999";
    $fon=($row['status']>1)?"#ddd":"#fff";
    $out.='<div style="overflow:hidden;width:100%;border:1px solid '.$color.';padding: 5px 5px 5px 5px;margin:1px 0 0 0;cursor:pointer;height:auto;background:'.$fon.';"><div style="width:95%;float:left" onclick="window.open(\'/components/partner/action.php?mid='.$row[0].'&amp;un='.$row['name'].'\',\'mess\',\'width=480,height=400,top=0,left=0\')"><span style="width:100%;"><b>'.$row['name'].'</b> <i>'.date("d-m-Y H:i", $row['sendtime']).'</i></span><br><h3 style="font-weight:bold">'.stripslashes($row['title']).'</h3><br>'.stripslashes($row['message']).'</div><div style="width:4%;float:left"><a href="?component=partner&action=5&delid='.$row[0].'" style="display:block;width:20px;height:22px;padding:7px 0 0 15px">x</a></div></div>';
    $res1=mysql_query('select a.*,b.name from partner_message as a,partner_users as b where a.sender=0 and a.status<5 and a.messageid='.$row[0].' and a.recipient=b.id order by a.id desc');
    //echo 'select a.*,b.name from partner_message as a,partner_users as b where a.sender=0 and a.status<5 and a.messageid='.$row[0].' and a.recipient=b.id order by a.id desc<br>';
    while($row1=mysql_fetch_array($res1)){
        $color=($row['status']==0)?"#00f":"#999";
        $out.='<div style="width:95%;border:1px solid '.$color.';padding: 5px 5px 5px 5px;margin:1px 0 0 35px;cursor:pointer"><span style="width:95%;float:left">Ответ для <b>'.$row1['name'].'</b> <i>'.date("d-m-Y H:i", $row1['sendtime']).'</i></span><span style="width:4%;float:left"><a href="?component=partner&action=5&delid='.$row1[0].'" style="display:block;width:20px;height:22px;padding:7px 0 0 15px">x</a></span><br><h3 style="font-weight:bold">'.stripslashes($row1['title']).'</h3><br>'.stripslashes($row1['message']).'</div>';
    }
}
$res=mysql_query('update '.$PREFIX.'partner_message set status=1 where status=0');
?>

<br><br>
<h1>Рассылка</h1>
<?php echo $error?>
<form method=post>
<table>
<tr><td>Заголовок</td><td><input name=title size=70></td></tr>
<tr><td colspan=2><textarea name="frm_text" class="ckeditor" id="editor_ck">Уважаемый партнер сайта <?php echo $SITE_TITLE ?></textarea></td></tr>
<tr><td></td><td><input type=submit name=send value='Отправить'></td></tr>
</table>
</form>
    <script type="text/javascript">//<![CDATA[
    window.CKEDITOR_BASEPATH='inc/ckeditor/';
    //]]></script>
    <script type="text/javascript" src="inc/ckeditor/ckeditor.js?t=B1GG4Z6"></script>
    <script type="text/javascript">//<![CDATA[
    CKEDITOR.replace('editor_ck', { "filebrowserBrowseUrl": "\/inc\/ckfinder\/ckfinder.html", "filebrowserImageBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Images", "filebrowserFlashBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Flash", "filebrowserUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files", "filebrowserImageUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images", "filebrowserFlashUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash" });
    //]]></script>
<h1>Сообщения</h1>
<?php echo $out?>
