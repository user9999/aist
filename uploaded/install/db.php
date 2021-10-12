<?php
if(!defined('INSTALL')) die();
error_reporting(0);
if($_POST){
	$DATABASE_HOST=$_POST['dbserver'];
	$DATABASE_LOGIN=$_POST['dbuser'];
	$DATABASE_PASSWORD=$_POST['dbpass'];
	$DATABASE_NAME=$_POST['dbname'];
	$PREFIX=$_POST['dbprefix'];
	$error="";
	$link = mysql_connect($DATABASE_HOST, $DATABASE_LOGIN, $DATABASE_PASSWORD)
    or $error='Не соединиться<br>';
	$db = mysql_select_db($DATABASE_NAME, $link)
    or $error.='Неправильное имя базы';
	if($error==""){
		mysql_query('SET NAMES utf8');
		mysql_query('SET character_set_server=utf8');
		mysql_query('CREATE TABLE IF NOT EXISTS `'.$PREFIX.'installed` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL,
  UNIQUE KEY `id` (`id`)
)');
if($_POST['catalog_brands']){
mysql_query('CREATE TABLE IF NOT EXISTS `'.$PREFIX.'catalog_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `altname` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `showmenu` int(11) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)');
}
if($_POST['catalog_models']){
mysql_query('CREATE TABLE IF NOT EXISTS `'.$PREFIX.'catalog_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `altname` text NOT NULL,
  `image` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `showimg` int(11) NOT NULL,
  `position` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
)');
}
if($_POST['catalog_sections']){
mysql_query('CREATE TABLE IF NOT EXISTS `'.$PREFIX.'catalog_sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `altname` varchar(255) NOT NULL,
  `level` tinyint(3) unsigned NOT NULL,
  `parent` int(11) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `info` text NOT NULL,
  `showmenu` int(11) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  `img` varchar(128) NOT NULL,
  `sortby` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `altname` (`altname`),
  KEY `parent` (`parent`),
  KEY `showmenu` (`showmenu`)
)');
}

if($_POST['payment']){
mysql_query('CREATE TABLE IF NOT EXISTS `'.$PREFIX.'payment` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `userid` int(11) unsigned NOT NULL,
  `package_id` int(11) unsigned NOT NULL,
  `order_date` varchar(32) character set utf8 NOT NULL,
  `price` varchar(32) character set utf8 NOT NULL,
  `pp_payer_id` varchar(64) character set utf8 NOT NULL,
  `pp_payer_status` varchar(32) character set utf8 NOT NULL,
  `pp_payer_email` varchar(256) character set utf8 NOT NULL,
  `pp_txn_id` varchar(64) character set utf8 NOT NULL,
  `pp_payment_date` varchar(64) character set utf8 NOT NULL,
  `pp_payment_status` varchar(64) character set utf8 NOT NULL,
  `pp_pending_reason` varchar(128) character set utf8 NOT NULL,
  `pp_verified` varchar(32) character set utf8 NOT NULL,
  `pay_date` varchar(32) character set utf8 NOT NULL,
  `payment_gross` varchar(32) character set utf8 NOT NULL,
  `mc_gross` varchar(32) character set utf8 NOT NULL,
  `note` varchar(16) character set utf8 NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `userid` (`userid`),
  KEY `note` (`note`)
)');
}
mysql_query('CREATE TABLE IF NOT EXISTS `'.$PREFIX.'lang_text` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `table_name` varchar(64) character set utf8 NOT NULL,
  `rel_id` int(10) unsigned NOT NULL,
  `language` varchar(8) character set utf8 NOT NULL,
  `title` text character set utf8 NOT NULL,
  `short` text character set utf8 NOT NULL,
  `content` text character set utf8 NOT NULL,
  `description` varchar(256) character set utf8 NOT NULL,
  `keywords` text character set utf8 NOT NULL,
  `pub_date` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `table` (`table_name`,`rel_id`),
  KEY `pub_date` (`pub_date`),
  KEY `language` (`language`)
)');
if($_POST['static']){
mysql_query("CREATE TABLE IF NOT EXISTS `".$PREFIX."static` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` text NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY (`id`)
)");
}
		mysql_query('CREATE TABLE IF NOT EXISTS `'.$PREFIX.'menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `path` text NOT NULL,
  `ordering` int(11) NOT NULL,
  PRIMARY KEY (`id`)
)');
		mysql_query('CREATE TABLE IF NOT EXISTS `'.$PREFIX.'menu_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `path` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `display` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)');
if($_POST['static']){
		mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Статичные страницы', 'static', 3, 1)");
		mysql_query("INSERT INTO `".$PREFIX."installed` (`name`) VALUES('static')");
	}
		mysql_query('CREATE TABLE IF NOT EXISTS `'.$PREFIX.'modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(64) CHARACTER SET utf8 NOT NULL,
  `position` varchar(64) CHARACTER SET utf8 NOT NULL,
  `ordering` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ');

		mysql_query("INSERT INTO `".$PREFIX."modules` (`id`,`module`, `position`, `ordering`, `admin`,`name`) VALUES(1,'admin.menu', 'menu', 1, 1,'admin.menu')");


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
\$SITE_TITLE='Тайтл по умолчанию';
\$DEFAULT_TXT='';
//admin configuration
\$ADMIN_LOGIN = '';
\$ADMIN_PASSWORD = '';
\$ADMIN_EMAIL = '';//

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
\$FRIMG_WIDTH=905;
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
?>
<script> document.location.href='?step=3'</script>
<?php
	} else {
		echo "<div class=error>".$error."</div>";
	}
}
?>
<form method=post style="<?=$style?>">
<label for=dbserver>Сервер базы данных:</label><input type=text name=dbserver id=dbserver value='<?=($_POST['dbserver'])?$_POST['dbserver']:'localhost';?>'>
<label for=dbname>Имя базы данных:</label><input type=text name=dbname id=dbname value='<?=$_POST['dbname']?>'>
<label for=dbuser>Пользователь базы данных:</label><input type=text name=dbuser id=dbuser value='<?=$_POST['dbuser']?>'>
<label for=dbpass>Пароль базы данных:</label><input type=text name=dbpass id=dbpass value='<?=$_POST['dbpass']?>'>
<label for=dbprefix>Префикс таблиц:</label><input type=text name=dbprefix id=dbprefix value='<?=($_POST['dbprefix'])?$_POST['dbprefix']:'kvn_';?>'>

<h3>Установить таблицы:</h3><label for=catalog_sections>Разделы(catalog_sections):</label><input type=checkbox name=catalog_sections id=catalog_sections value='1' checked>
<label for=catalog_brands>Бренды(catalog_brands):</label><input type=checkbox name=catalog_brands id=catalog_brands value='1' checked>
<label for=catalog_models>Модели(catalog_models):</label><input type=checkbox name=catalog_models id=catalog_models value='1' checked>
<label for=static>Статичные страницы(static):</label><input type=checkbox name=static id=static value='1' checked>
<label for=payment>Оплата онлайн(payment):</label><input type=checkbox name=payment id=payment value='1'>
<input type="hidden" name=step value="2">
<input type="submit" name=check value="Проверить и создать">
</form>