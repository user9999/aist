<?php
if(!defined('INSTALL')) { die();
}

error_reporting(0);
if($_POST) {
    $DATABASE_HOST=$_POST['dbserver'];
    $DATABASE_LOGIN=$_POST['dbuser'];
    $DATABASE_PASSWORD=$_POST['dbpass'];
    $DATABASE_NAME=$_POST['dbname'];
    $PREFIX=$_POST['dbprefix'];
    $error="";
    class Database
    {
        private $_connection;
        private static $_instance; //The single instance
        private $_host = "";
        private $_username = "";
        private $_password = "";//
        private $_database = "";

        /*
        Get an instance of the Database
        @return Instance
        */
        public static function getInstance()
        {
            if(!self::$_instance) { // If no instance then make one
                self::$_instance = new self();
            }
            return self::$_instance;
        }

        // Constructor
        private function __construct()
        {
            echo "begin";
            $this->_host = $_POST['dbserver'];
            $this->_username = $_POST['dbuser'];
            $this->_password = $_POST['dbpass'];
            $this->_database = $_POST['dbname'];
            $this->_connection = new mysqli(
                $this->_host, $this->_username, 
                $this->_password, $this->_database, '3308'
            );//3306 3308
            if ($mysqli->connect_errno) {
                echo "Не удалось подключиться к MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
            }
    
            // Error handling
            /*
            if(mysqli_connect_error()) {
                trigger_error(
                    "Failed to conencto to MySQL: " . mysqli_connect_error(),
                    E_USER_ERROR
                );
            }
            */
            echo "connection";
        }

        // Magic method clone is empty to prevent duplication of connection
        private function __clone()
        { 
        }

        // Get mysqli connection
        public function getConnection()
        {
            return $this->_connection;
        }
    }
    $db = Database::getInstance();
    echo "done";
    $mysqli = $db->getConnection(); 
    $sql_query = "SET NAMES 'utf8' ";
    $result = $mysqli->query($sql_query);
    function mysql_query($query)
    {
        global $mysqli;
        $result = $mysqli->query($query);
        return $result;
    }

    if($error=="") {
        mysql_query('SET NAMES utf8');
        mysql_query('SET character_set_server=utf8');
        mysql_query(
            'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'installed` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL,
  UNIQUE KEY `id` (`id`)
)'
        );
        if($_POST['catalog_brands']) {
            mysql_query(
                'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'catalog_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `altname` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `showmenu` int(11) NOT NULL,
  `position` tinyint(3) unsigned NOT NULL,
  `section_id` int(11) unsigned  NOT NULL,
  PRIMARY KEY (`id`)
  KEY `section_id` (`section_id`),
  KEY `name` (`name`)
)'
            );
        }
        if($_POST['catalog_models']) {
            mysql_query(
                'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'catalog_models` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `altname` text NOT NULL,
  `image` text NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `showimg` int(11) NOT NULL,
  `position` smallint(6) NOT NULL,
  PRIMARY KEY (`id`)
)'
            );
        }
        if($_POST['catalog_sections']) {
            mysql_query(
                'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'catalog_sections` (
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
)'
            );
        }

        if($_POST['payment']) {
            mysql_query(
                'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'payment` (
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
)'
            );
        }
        mysql_query(
            'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'lang_text` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `table_name` varchar(64) character set utf8 NOT NULL,
  `rel_id` int(10) unsigned NOT NULL,
  `language` varchar(8) character set utf8 NOT NULL,
  `title` varchar(256) character set utf8 NOT NULL,
  `short` text character set utf8 NOT NULL,
  `content` text character set utf8 NOT NULL,
  `description` text character set utf8 NOT NULL,
  `keywords` text character set utf8 NOT NULL,
  `pub_date` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `table` (`table_name`,`rel_id`),
  KEY `pub_date` (`pub_date`),
  KEY `language` (`language`)
)'
        );
        if($_POST['static']) {
            mysql_query(
                "CREATE TABLE IF NOT EXISTS `".$PREFIX."static` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` text NOT NULL,
  `title` text NOT NULL,
  `text` text NOT NULL,
  `keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY (`id`)
)"
            );
        }
        mysql_query(
            'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text NOT NULL,
  `path` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `parent` int(11) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)'
        );
        mysql_query(
            'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'menu_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `path` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `display` tinyint(2) unsigned NOT NULL,
  PRIMARY KEY (`id`)
)'
        );
        mysql_query(
                'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'url` (
  `url` varchar(255) PRIMARY KEY NOT NULL,
  `component` varchar(64) NOT NULL,
  `cmsurl` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL)'
);
        mysql_query("CREATE TABLE IF NOT EXISTS `".$PREFIX."settings` (
   `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
   alias varchar(64) NOT NULL,value1 varchar(255) NOT NULL,
   value2 varchar(255) NOT NULL,value3 varchar(255) NOT NULL)"
);
        mysql_query("CREATE TABLE IF NOT EXISTS `".$PREFIX."module_text` (
  `id` int(11) NOT NULL auto_increment,
  `path` text NOT NULL,
  `text` text NOT NULL,
  `position` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`)
)");
        
        
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Главная', 'index', 1, 1)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Слайдер', '1', 'index&action=1', 1, 1)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Настройки', '1', 'index&action=3', 2, 1)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Ссылки', '1', 'index&action=2', 3, 1)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Языки', '1', 'index&action=4', 3, 1)");
        
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Разработка', '0', 'installator', 60, 0)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Компоненты', '6', 'installator&action=1', 3, 0)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Модули', '6', 'installator&action=3', 2, 0)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Виджеты', '6', 'installator&action=5', 3, 0)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Создать компонент', '6', 'installator&action=8', 4, 0)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Классы', '6', 'installator&action=9', 6, 0)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`,`parent_id`, `path`, `ordering`, `display`) VALUES('Шаблоны', '6', 'installator&action=10', 5, 0)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Данные компании', 'settings', 22, 1)");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Тексты модулей', 'module_text', 15, 1)");
        
        if($_POST['static']) {
            mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Статичные страницы', 'static', 3, 1)");
            mysql_query("INSERT INTO `".$PREFIX."installed` (`name`) VALUES('static')");
        }
        mysql_query("CREATE TABLE IF NOT EXISTS `".$PREFIX."frontpage` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `position` smallint(4) NOT NULL,
  `display` tinyint(1) unsigned NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text NOT NULL,
  `type` varchar(12) NOT NULL,
  `section` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `section` (`section`),
  KEY `position` (`position`)
)");
        mysql_query("INSERT INTO `".$PREFIX."frontpage` (`name`, `title`, `position`, `display`, `url`, `description`, `type`) VALUES
('1457819005.png', '', 3, 1, '', '', 'image')");
        mysql_query("INSERT INTO `".$PREFIX."installed` (`name`) VALUES('index')");
        mysql_query("INSERT INTO `".$PREFIX."installed` (`name`) VALUES('settings')");
        mysql_query("INSERT INTO `".$PREFIX."installed` (`name`) VALUES('module_text')");


        mysql_query("CREATE TABLE IF NOT EXISTS `".$PREFIX."menu` (
  `id` int(11) NOT NULL auto_increment,
  `text` text NOT NULL,
  `path` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `parent` int(11) unsigned NOT NULL,
  `level` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`id`))");
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Меню сайта', 'menu', 2, 1)");
        mysql_query("INSERT INTO `".$PREFIX."installed` (`name`) VALUES('menu')");
        mysql_query(
            'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(64) CHARACTER SET utf8 NOT NULL,
  `position` varchar(64) CHARACTER SET utf8 NOT NULL,
  `ordering` int(11) NOT NULL,
  `admin` int(11) NOT NULL,
  `name` varchar(64) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`)
) ');

        mysql_query("INSERT INTO `".$PREFIX."modules` (`id`,`module`, `position`, `ordering`, `admin`,`name`) VALUES(1,'new.admin.menu', 'new_menu', 1, 1,'new.admin.menu')");
        mysql_query("INSERT INTO `".$PREFIX."modules` (`module`, `position`, `ordering`, `admin`,`name`) VALUES('gentellela.admin.menu', 'gentellela', 1, 1,'gentellela.admin.menu')");
        mysql_query("INSERT INTO `kvn_modules` (`module`, `position`, `ordering`, `admin`, `name`) VALUES('menu_main', 'menu_main', 0, 0, 'menu main')");
        
        mysql_query(
            'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'forms` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `table` varchar(128) NOT NULL,
  `alias` varchar(128) NOT NULL,
  `enctype` varchar(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `method` varchar(128) NOT NULL,
  `action` varchar(32) NOT NULL,
  `attributes` varchar(255) NOT NULL,
  `html` text CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`)
)');
        mysql_query(
            'CREATE TABLE IF NOT EXISTS `'.$PREFIX.'form_inputs` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `form_id` int(11) UNSIGNED NOT NULL,
  `text` varchar(255) NOT NULL,
  `type` varchar(32) NOT NULL,
  `name` varchar(64) NOT NULL,
  `attributes` varchar(255) NOT NULL,
  `placeholder` varchar(255) NOT NULL,
  `value` varchar(64) NOT NULL,
  `required` varchar(32) NOT NULL,
  `check_function` varchar(64) NOT NULL,
  `make_function` varchar(64) NOT NULL,
  `position` smallint(5) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `form_id` (`form_id`)
)');
        mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`, `parent_id`, `path`, `ordering`, `display`) VALUES('Формы', '6', 'forms', 50, 0)");
        //mysql_query("INSERT INTO `".$PREFIX."menu_admin` (`text`, `path`, `ordering`, `display`) VALUES('Разработка', 'installator', 100, 0)");
        
        mysql_query("INSERT INTO `".$PREFIX."installed` (`name`) VALUES('forms')");
        $config="<?php
//basic
DEFINE('DEBUG',false);//false если отладка не нужна - вывод в консоль разработчика
DEFINE('HTMLDEBUG',true);// вывод в комментариях в html
\$MAINPATH = 'http://'.\$_SERVER['HTTP_HOST']; //исходный сайт
\$PATH = 'http://'.\$_SERVER['HTTP_HOST'];//domain
\$IMGPATH = 'http://img.'.\$_SERVER['HTTP_HOST'];//subdomain?
\$STUFFPATH = 'http://stuff.'.\$_SERVER['HTTP_HOST'];//subdomain?
\$INCPATH = '';
\$MY_URL=0;//ЧПУ: 0-выключен 1-включен
\$HOSTPATH=str_replace('/inc','',str_replace('\\\','/',dirname(__FILE__)));//  /home/users1/path/to/root
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

require_once \$HOSTPATH.\"/classes/db.php\";
";
        $fp=fopen("../inc/configuration.php", "w+");
        fwrite($fp, $config);
        fclose($fp);
        $phpversion=intval($_GET['param']);
        copy("../classes/tmp/db{$phpversion}.php", "../classes/db.php");
        copy("../inc/tmp/functions{$phpversion}.php", "../inc/functions.php");
        //rename("../classes/db{$phpversion}.php", "../classes/db.php");
        //rename("../inc/functions{$phpversion}.php", "../inc/functions.php");
    } else {
        echo "<div class=error>".$error."</div>";
    }
}

if(file_exists("../classes/db.php")) {

    ?>
<script> document.location.href='?step=3'</script>
    <?php
}
?>
<form method=post style="<?php echo $style?>">
<label for=dbserver>Сервер базы данных:</label><input type=text name=dbserver id=dbserver value='<?php echo ($_POST['dbserver'])?$_POST['dbserver']:'localhost';?>'>
<label for=dbname>Имя базы данных:</label><input type=text name=dbname id=dbname value='<?php echo $_POST['dbname']?>'>
<label for=dbuser>Пользователь базы данных:</label><input type=text name=dbuser id=dbuser value='<?php echo $_POST['dbuser']?>'>
<label for=dbpass>Пароль базы данных:</label><input type=text name=dbpass id=dbpass value='<?php echo $_POST['dbpass']?>'>
<label for=dbprefix>Префикс таблиц:</label><input type=text name=dbprefix id=dbprefix value='<?php echo ($_POST['dbprefix'])?$_POST['dbprefix']:'kvn_';?>'>

<h3>Установить таблицы:</h3><label for=catalog_sections>Разделы(catalog_sections):</label><input type=checkbox name=catalog_sections id=catalog_sections value='1' checked>
<label for=catalog_brands>Бренды(catalog_brands):</label><input type=checkbox name=catalog_brands id=catalog_brands value='1' checked>
<label for=catalog_models>Модели(catalog_models):</label><input type=checkbox name=catalog_models id=catalog_models value='1' checked>
<label for=static>Статичные страницы(static):</label><input type=checkbox name=static id=static value='1' checked>
<label for=payment>Оплата онлайн(payment):</label><input type=checkbox name=payment id=payment value='1'>
<input type="hidden" name=step value="2">
<input type="submit" name=check value="Проверить и создать">
</form>
