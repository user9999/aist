<?php
if(!defined('INSTALL')) die();
include "../inc/configuration.php";
if($_POST){
	$config="<?php
//basic
DEFINE('DEBUG',false);//false если отладка не нужна - вывод в консоль разработчика
DEFINE('HTMLDEBUG',true);// вывод в комментариях в html
\$MAINPATH = 'http://'.\$_SERVER['HTTP_HOST']; //исходный сайт
\$PATH = 'http://'.\$_SERVER['HTTP_HOST'];//domain
\$IMGPATH = 'http://img.'.\$_SERVER['HTTP_HOST'];//subdomain?
\$STUFFPATH = 'http://stuff.'.\$_SERVER['HTTP_HOST'];//subdomain?
\$INCPATH = '';
\$HOSTPATH=str_replace('/inc','',dirname(__FILE__));//  /home/users1/path/to/root
//template
\$TEMPLATE = 'blank';
\$ADMIN_TEMPLATE = 'admin.blank';
\$PAGE_TITLE = '';
\$PAGE_TITLE_DEL = ' - ';

//default meta
\$META_DESCRIPTION = 'Описание по умолчанию';
\$META_KEYWORDS = 'Ключевые по умолчанию';
\$SITE_TITLE='Интернет-магазин';
\$DEFAULT_TXT='';
//admin configuration
\$ADMIN_LOGIN = '{$_POST['ADMIN_LOGIN']}';
\$ADMIN_PASSWORD = '{$_POST['ADMIN_PASSWORD']}';
\$ADMIN_EMAIL = '';//

\$LANGUAGES = array('ru'=>'default');
\$LDISPLAY = array('ru'=>'1');
\$DLANG = 'ru';
//database
\$PREFIX='".$PREFIX."';
\$DATABASE_HOST = '".$DATABASE_HOST."';
\$DATABASE_NAME = '".$DATABASE_NAME."';
\$DATABASE_LOGIN = '".$DATABASE_LOGIN."';
\$DATABASE_PASSWORD = '".$DATABASE_PASSWORD."';
\$SECRET_KEY='some bullshit';
\$DELIVERY=400;//стоимость доставки
//rotator
\$ROTATOR=0;
//images
\$IMAGE_MAXSIZE = 330;//330
\$IMAGE_HMAXSIZE = 270;
\$IMAGE2_MAXSIZE = 100;
\$IMAGE3_MAXSIZE = 1000;
\$IMAGE3_HMAXSIZE = 800;
\$GAL_WIDTH = 0;
\$GAL_HEIGHT = 0;
\$SGAL_WIDTH = 0;
\$SGAL_HEIGHT = 0;

\$LINKIMG_HEIGHT=169;
\$LINKIMG_WIDTH=237;
\$FRIMG_HEIGHT=300;
\$FRIMG_WIDTH=1000;
\$FRIMG2_HEIGHT=139;
\$FRIMG2_WIDTH=200;

\$FRGB=0xFFFFFF;
\$RGB=0xFFFFFF;
//connect to db
\$link = mysql_connect(\$DATABASE_HOST, \$DATABASE_LOGIN, \$DATABASE_PASSWORD)
    or die('Could not connect');
\$db = mysql_select_db(\$DATABASE_NAME, \$link)
    or die('Could not select db');

mysql_query('SET NAMES utf8');
mysql_query('SET character_set_server=utf8');
?>";
	$fp=fopen("../inc/configuration.php","w+");
	fwrite($fp,$config);
	fclose($fp);
	$sec=file_get_contents("../secpic.php");
	$replacement=str_replace("install/setconfig.php","fonts/",__FILE__);
	$replacement="\$path_fonts = '".$replacement."';";
	$sec=str_replace("//path_fonts",$replacement,$sec);
	$fp=fopen("../secpic.php","w+");
	fwrite($fp,$sec);
	fclose($fp);
	
?>
<script> document.location.href='/admin'</script>
<?php
}
?>
<form method=post style="<?=$style?>">
<label for=admin>Логин Админа:</label><input type=text name='ADMIN_LOGIN' id=admin value='<?=($_POST['admin'])?$_POST['ADMIN_LOGIN']:'admin';?>'>
<label for=password>Пароль Админа:</label><input type=text name='ADMIN_PASSWORD' id=password value='<?=$_POST['ADMIN_PASSWORD']?>'>
<input type="hidden" name=step value="2">
<input type="submit" name=check value="Создать">
</form>