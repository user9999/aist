<?php
require_once("session.class.php");
$session=new session;
if($session->session_true()){
	if(preg_match("![a-z\.]!is",$_GET['file']) && !preg_match("!^(\.)(htaccess)!is",$_GET['file'])){
		if(file_exists("userfiles/".$_SESSION['id']."/".$_GET['file'].".tpl")){
			if($_GET['act']=="del"){
				if(unlink("userfiles/".$_SESSION['id']."/".$_GET['file'].".tpl")){
					$info="удален";
				} else {
					$info="ошибка";
				}
			} else {
				$info="есть";
			}
		} else {
			$info="удален";
		}
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
<style type="text/css">
html,body{padding:0 0 0 0;margin:0 0 0 0;border:0;font-size:12px
}
</style>
</head>
<body>
<?php
echo $info;
?>
</body>
</html>