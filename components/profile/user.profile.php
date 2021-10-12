<?php if (!defined("SIMPLE_CMS")) die("Access denied"); 
//var_dump($_SESSION);die();
if (isset($_SESSION['email'])){
if($_POST['change']){
$phone=mysql_real_escape_string($_POST['phone']);
$byear=mysql_real_escape_string($_POST['byear']);
$name=mysql_real_escape_string($_POST['name']);

$country=mysql_real_escape_string($_POST['country']);
$firm=mysql_real_escape_string($_POST['firm']);
$address=mysql_real_escape_string($_POST['address']);
$getref=($_POST['getref']==1)?1:0;
//var_dump($_POST['getref']);
//die();
mysql_query("update ".$PREFIX."users set phone='$phone',name='$name',birthdate='$byear',country='$country',firm='$firm',address='$address' where id=".$_SESSION['userid']);
$_SESSION['phone']=$phone;
//echo "update users set phone='$phone',getref=$getref where id=".$_SESSION['userid'];
}


$res=mysql_query("select phone,name,gender,birthdate,country,firm,address from ".$PREFIX."users where id=".$_SESSION['userid']." limit 1");
$row=mysql_fetch_row($res);
$sex=($row[2]=='female')?$GLOBALS['dblang_female'][$GLOBALS['userlanguage']]:$GLOBALS['dblang_male'][$GLOBALS['userlanguage']];
if($row[3]==1){
$checked='checked';
$checked1='';

} else {
$checked='';
$checked1='checked';

}
//echo $row[2];
//die();
?>
<script type="text/javascript">
$(function(){

		$('input:radio').change(function(){
				getref = $('input[name="getref"]:checked').val();
				if(getref==1){
					$('#refstat').text('Партнеры предоставляются');
					$('#yes').css('font-weight','bold');
					$('#no').css('font-weight','normal');
				} else {
					$('#refstat').text('Партнеры не предоставляются');
					$('#yes').css('font-weight','normal');
					$('#no').css('font-weight','bold');
				}
		});          

});
</script>
<form method=post>
<table class=udata><caption><?= $GLOBALS['dblang_yourdata'][$GLOBALS['userlanguage']] ?></caption>
<tr><td><?= $GLOBALS['dblang_nick'][$GLOBALS['userlanguage']] ?></td><td><? echo $_SESSION['nick']; ?></td></tr>
<tr><td><?= $GLOBALS['dblang_family'][$GLOBALS['userlanguage']] ?></td><td><input type=text name=name value='<? echo $row[1]; ?>'></td></tr>
<tr><td><?= $GLOBALS['dblang_gender'][$GLOBALS['userlanguage']] ?></td><td><? echo $sex; ?></td></tr>
<tr><td><?= $GLOBALS['dblang_byear'][$GLOBALS['userlanguage']] ?></td><td><input type=text name=byear value='<? echo $row[3]; ?>'></td></tr>
<tr><td><?= $GLOBALS['dblang_email'][$GLOBALS['userlanguage']] ?></td><td><? echo $_SESSION['email']; ?></td></tr>
<tr><td><?= $GLOBALS['dblang_phone'][$GLOBALS['userlanguage']] ?></td><td><input type=text name=phone value='<? echo $row[0]; ?>'></td></tr>
<tr><td><?= $GLOBALS['dblang_country'][$GLOBALS['userlanguage']] ?></td><td><input type=text name=country value='<? echo $row[4]; ?>'></td></tr>
<tr><td><?= $GLOBALS['dblang_firm'][$GLOBALS['userlanguage']] ?></td><td><input type=text name=firm value='<? echo $row[5]; ?>'></td></tr>
<tr><td><?= $GLOBALS['dblang_address'][$GLOBALS['userlanguage']] ?></td><td><input type=text name=address value='<? echo $row[6]; ?>'></td></tr>

<tr><td></td><td><input type=submit name=change value='<?= $GLOBALS['dblang_change'][$GLOBALS['userlanguage']] ?>'> </td></tr>
</table>
</form>
<?
} else {
	header("Location:/error");
}
?>