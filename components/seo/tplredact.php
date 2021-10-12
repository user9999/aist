<?php
require_once("session.class.php");
$session=new session;
if($session->session_true()){
	if($_POST['save']){
		if(!is_dir("userfiles/".$_SESSION['id'])){
			mkdir("userfiles/".$_SESSION['id']);
		}
		if(!file_exists("userfiles/".$_SESSION['id']."/.htaccess")){
			$fp=fopen("userfiles/".$_SESSION['id']."/.htaccess","w+");
			fwrite($fp,"Deny from all");
			fclose($fp);
		}
		if(preg_match("![a-z\.]!is",$_POST['name']) && !preg_match("!^(\.)(htaccess)!is",$_POST['name'])){
				$fp=fopen("userfiles/".$_SESSION['id']."/".$_POST['name'].".tpl","w+");
				fwrite($fp,html_entity_decode (stripslashes($_POST['cod'])));
				fclose($fp);
				$err_info="<b style=\"color:#009900\">Темплэйт успешно создан!</b><br>имя файла (латинскими буквами без расширения)";
		} else {
			$err="class=\"error\" ";
			$err_info="<b style=\"color:#880000\">Исправьте: Название может состоять только из латинских букв и точки";
		}
		$cont=stripslashes($_POST['cod']);
	} else {
		if($_GET['tpl']=="default"){
			$cont=htmlentities(implode("",file("tpl/templ.tpl")));
			
			$err="";
		} elseif($_GET['tpl']=="defaultphp"){
			$cont=htmlentities(implode("",file("tpl/tpl.php.tpl")));
			
			$err="";

		} elseif(preg_match("![a-z\.]!is",$_GET['tpl']) && !preg_match("!^(\.)(htaccess)!is",$_GET['tpl'])){
			if(file_exists("userfiles/".$_SESSION['id']."/".$_GET['tpl'].".tpl")){
				$cont=htmlentities(implode("",file("userfiles/".$_SESSION['id']."/".$_GET['tpl'].".tpl")));
			
				$err="value=\"".$_GET['tpl']."\" ";
			}
		}
		$err_info="имя файла (латинскими буквами без расширения)";
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
<title>редактирование</title>
<meta http-equiv="Content-Type" content="text/html;charset=windows-1251" />
<meta name="keywords" content="-@keywords@-" />
<meta name="description" content="-@description@-" />
<meta name="author" content="-@author@-" />
<meta name="copyright" content="http://good-job.ws" />
<link rel="icon" href="favicon.ico" type="image/x-icon">
<style type="text/css">
@import url('main.css');
</style>
</head>
<body>
<form method="post" action="" />
<center>
<?=$err_info;?> <input type="text" name="name" size="40" <?=$err;?>/> 
<textarea rows="29" cols="110" name="cod"><?php
echo $cont;
?></textarea><br />
<input type="submit" name="save" value="сохранить" />
</form>
</body>
</html>