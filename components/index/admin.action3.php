<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 

if($_POST['set']??'') {
    $langs=explode(";", $_POST['LANGUAGES']);
    $larr="";
    $display="";
    foreach($langs as $num=>$lang){
        //echo $num." ".$lang;
        if($_POST[$lang]) {
            $larr.="'".$lang."'=>'".$_POST[$lang]."',";
            $ld=($_POST[LDISPLAY][$lang]==1)?1:0;
            $display.="'".$lang."'=>'".$ld."',";
        } else {
            $larr.="'".$lang."'=>'default',";
        }
    }
    //die($display);
    if(is_array($_POST[META_DESCRIPTION])) {
        $META_DESCRIPTION="array(";
        $META_KEYWORDS="array(";
        $SITE_TITLE="array(";
        $PAGE_TITLE="array(";
        foreach($_POST[META_DESCRIPTION] as $lang=>$value){
            $META_DESCRIPTION.="\"$lang\"=>\"$value\",";
            $META_KEYWORDS.="\"$lang\"=>\"{$_POST[META_KEYWORDS][$lang]}\",";
            $SITE_TITLE.="\"$lang\"=>\"{$_POST[SITE_TITLE][$lang]}\",";
            $PAGE_TITLE.="\"$lang\"=>\"{$_POST[PAGE_TITLE][$lang]}\",";
        }
        $META_DESCRIPTION.=")";
        $META_KEYWORDS.=")";
        $SITE_TITLE.=")";
        $PAGE_TITLE.=")";
    } else {
        $META_DESCRIPTION="'".$_POST['META_DESCRIPTION']."'";
        $META_KEYWORDS="'".$_POST['META_KEYWORDS']."'";
        $SITE_TITLE="'".$_POST['SITE_TITLE']."'";
        $PAGE_TITLE="'".$_POST['PAGE_TITLE']."'";
    }
    $DEBUG=DEBUG;
    $larr="array(".substr($larr, 0, -1).")";
    $display="array(".substr($display, 0, -1).")";
    $WATERMARK=($_POST['WATERMARK'])?1:0;
    $TEMPLATE=($_POST['TEMPLATE'])?$_POST['TEMPLATE']:'blank';
    $ADMIN_TEMPLATE=($_POST['ADMIN_TEMPLATE'])?$_POST['ADMIN_TEMPLATE']:'blank';
    $MY_URL=($_POST[MY_URL]==1)?$_POST[MY_URL]:0;
    $settings="<?php
//basic
DEFINE('DEBUG',".$DEBUG.");//false если отладка не нужна - вывод в консоль разработчика
DEFINE('HTMLDEBUG',true);// вывод в комментариях в html
\$MAINPATH = 'http://'.\$_SERVER['HTTP_HOST']; //исходный сайт
\$PATH = 'http://'.\$_SERVER['HTTP_HOST'];//domain
\$IMGPATH = 'http://img.'.\$_SERVER['HTTP_HOST'];//subdomain?
\$STUFFPATH = 'http://stuff.'.\$_SERVER['HTTP_HOST'];//subdomain?
\$INCPATH = '';
\$MY_URL=".$MY_URL.";//ЧПУ: 0-выключен 1-включен
\$HOSTPATH=str_replace('/inc','',str_replace('\\\','/',dirname(__FILE__)));//  /home/users1/path/to/root
//template
\$TEMPLATE = '".$TEMPLATE."';
\$ADMIN_TEMPLATE = '".$ADMIN_TEMPLATE."';
\$PAGE_TITLE = ".$PAGE_TITLE.";
\$PAGE_TITLE_DEL = ' - ';

//languges
\$LANGUAGES = ".$larr.";
\$LDISPLAY = ".$display.";
\$DLANG = '".$_POST['DLANG']."';

//default meta
\$META_DESCRIPTION = ".$META_DESCRIPTION.";
\$META_KEYWORDS = ".$META_KEYWORDS.";
\$SITE_TITLE=".$SITE_TITLE.";
\$DEFAULT_TXT='".$_POST['DEFAULT_TXT']."';
//admin configuration
\$ADMIN_LOGIN = '".$ADMIN_LOGIN."';
\$ADMIN_PASSWORD = '".$ADMIN_PASSWORD."';
\$ADMIN_EMAIL = '".$_POST['ADMIN_EMAIL']."';//play-fine@yandex.ru
\$robotmail='".$_POST['robotmail']."';

\$replacearray=array('{:sitetitle:}','{:url:}','{:password:}','{:username:}','{:userid:}','{:usermail:}','{:userdata:}','{:subscribe:}','{:unsubscribe:}','{:balance:}','{:refinvite:}','{:phone:}','{:birthdate:}','{:gender:}');
\$descriptionarray=array('Название сайта','Адрес сайта','Смена пароля','ФИО клиента','ID клиента','Email клиента','Данные клиента(Дополнительная информация)','Код подписки/восстановления пароля','Код отписки','Баланс клиента','инвайт реферала','телефон','дата рождения','пол');

//database
\$PREFIX='".$PREFIX."';
\$DATABASE_HOST = '".$DATABASE_HOST."';
\$DATABASE_NAME = '".$DATABASE_NAME."';
\$DATABASE_LOGIN = '".$DATABASE_LOGIN."';
\$DATABASE_PASSWORD = '".$DATABASE_PASSWORD."';
\$SECRET_KEY='some bullshit';

//rotator
\$ROTATOR=".($_POST['ROTATOR']*1000).";

//images
\$IMAGE_MAXSIZE = ".$_POST['IMAGE_MAXSIZE'].";//330
\$IMAGE_HMAXSIZE = ".$_POST['IMAGE_HMAXSIZE'].";
\$IMAGE2_MAXSIZE = ".$_POST['IMAGE2_MAXSIZE'].";
\$IMAGE3_MAXSIZE = ".$_POST['IMAGE3_MAXSIZE'].";
\$IMAGE3_HMAXSIZE = ".$_POST['IMAGE3_HMAXSIZE'].";

\$LINKIMG_HEIGHT=".$_POST['LINKIMG_HEIGHT'].";
\$LINKIMG_WIDTH=".$_POST['LINKIMG_WIDTH'].";
\$FRIMG_HEIGHT=".$_POST['FRIMG_HEIGHT'].";
\$FRIMG_WIDTH=".$_POST['FRIMG_WIDTH'].";
\$FRIMG2_HEIGHT=".$_POST['FRIMG2_HEIGHT'].";
\$FRIMG2_WIDTH=".$_POST['FRIMG2_WIDTH'].";
\$FRGB=0x".strtoupper($_POST['FRGB']).";
\$RGB=0x".strtoupper($_POST['RGB']).";
\$WATERMARK=".$WATERMARK.";


//connect to db
require_once \$HOSTPATH.\"/classes/db.php\";
";
    //var_dump($settings);
    //die();

    $fp=fopen($HOSTPATH."/inc/configuration.php", "w");
    fwrite($fp, $settings);
    fclose($fp);
    header("Location: ?component=index&action=3");
}
$wchecked=($WATERMARK??false)?"checked":"";
$ts="<select name=\"TEMPLATE\"><option value=0>Выбрать</option>";
$ats="<select name=\"ADMIN_TEMPLATE\"><option value=0>Выбрать</option>";
foreach(glob($HOSTPATH."/templates/*/template.php") as $tpl){
    $tpl=str_replace($HOSTPATH."/templates/", "", $tpl);
    $tpl=str_replace("/template.php", "", $tpl);
    if(strpos($tpl, 'admin.')===false) {
        $selected=($TEMPLATE==$tpl)?' selected':'';
        $ts.="<option value='{$tpl}'{$selected}>{$tpl}</option>";
    }else{
        $selected=($ADMIN_TEMPLATE==$tpl)?' selected':'';
        $ats.="<option value='{$tpl}'{$selected}>{$tpl}</option>";
    }
}
$ts.="</select>";
$ats.="</select>";
if($MY_URL==1){
    $chpu="<input type=checkbox name=\"MY_URL\" value=1 checked> ";
    $chpu_status="включен";
}else{
    $chpu="<input type=checkbox name=\"MY_URL\" value=1> ";
    $chpu_status="выключен";
}
?>
<form method="post">
<table style="width:760px"><caption>Основные настройки</caption>
<tr><td>Отладка в консоль</td><td><?php echo (DEBUG)?"Включена":"Выключена"; ?></td></tr>
<tr><td>Отладка в комментариях</td><td><?php echo (HTMLDEBUG)?"Включена":"Выключена"; ?></td></tr>
<tr><td>Сайт основной(если зеркала)</td><td><?php echo $MAINPATH; ?></td></tr>
<tr><td>Сайт текущий</td><td><?php echo $PATH; ?></td></tr>
<tr><td>Домен картинок</td><td><?php echo $IMGPATH; ?></td></tr>
<tr><td>Домен файлов js,css</td><td><?php echo $STUFFPATH; ?></td></tr>
<tr><td>Путь к инклюдам</td><td><?php echo $INCPATH; ?></td></tr>
<tr><td>Путь к корневому каталогу</td><td><?php echo $HOSTPATH; ?></td></tr>
<tr><td>Шаблон</td><td><?php echo  $ts; ?></td></tr>
<tr><td>Шаблон админа</td><td><?php echo $ats; ?></td></tr>
<tr><td>ЧПУ (<?php echo $chpu_status; ?>)</td><td><?php echo $chpu; ?></td></tr>
<?php
foreach($LDISPLAY as $l=>$d){
    $checkbox[$l]=($d==1)?"checked":"";
}
$LINKIMG_HEIGHT=($LINKIMG_HEIGHT)?$LINKIMG_HEIGHT:200;
$LINKIMG_WIDTH=($LINKIMG_WIDTH)?$LINKIMG_WIDTH:1000;

if($LANGUAGES) {
    $langs="";
    $paths="";
    foreach($LANGUAGES as $lang=>$lpath){
        $langs.=$lang.";";
        $paths.="<tr><td>путь к картинке $lang (default - без картинки)</td><td><input name=\"$lang\" type=\"text\" style=\"width: 80%;\" value=\"$lpath\"></td></tr>";
    }
    echo "<tr><td>Языки через точку с запятой</td><td><input name=\"LANGUAGES\" type=\"text\" style=\"width: 80%;\" value=\"".substr($langs, 0, -1)."\"></td></tr>".$paths;
    echo "<tr><td>Язык по умолчанию</td><td><input name=\"DLANG\" type=\"text\" style=\"width: 80%;\" value=\"".$DLANG."\"></td></tr>";
} else {
    ?>
<tr><td>Языки через точку с запятой</td><td><input name="LANGUAGES" type="text" style="width: 80%;" value=""></td></tr>
    <?php
}
?>

<tr><td>Разделитель для тайтлов</td><td><?php echo $PAGE_TITLE_DEL; ?></td></tr>
<?php
if($LANGUAGES) {
    $meta="";
    foreach($LANGUAGES as $lang=>$lpath){
        $meta.="<tr style='background:#ccc;text-align:center'><td colspan=2>$lang &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;отображать<input type=checkbox name=\"LDISPLAY[$lang]\" value=1 {$checkbox[$lang]}> </td></tr>
		<tr><td>Название страницы</td><td><input name=\"PAGE_TITLE[$lang]\" type=\"text\" style=\"width: 80%;\" value=\"".($PAGE_TITLE[$lang]??'')."\"></td></tr>
		<tr><td>Мета описание по умолчанию $lang</td><td><input name=\"META_DESCRIPTION[$lang]\" type=\"text\" style=\"width: 80%;\" value=\"".($META_DESCRIPTION[$lang]??'')."\"></td></tr>
		<tr><td>Мета ключевые по умолчанию $lang</td><td><input name=\"META_KEYWORDS[$lang]\" type=\"text\" style=\"width: 80%;\" value=\"{$META_KEYWORDS[$lang]}\"></td></tr>
		<tr><td>Название сайта $lang</td><td><input name=\"SITE_TITLE[$lang]\" type=\"text\" style=\"width: 80%;\" value=\"{$SITE_TITLE[$lang]}\"></td></tr>";
    }
    echo $meta;
} else {
    ?>

<tr><td>Название страницы</td><td><input name="PAGE_TITLE" type="text" style="width: 80%;" value="<?php echo $PAGE_TITLE; ?>"></td></tr>
<tr><td>Мета описание по умолчанию</td><td><input name="META_DESCRIPTION" type="text" style="width: 80%;" value="<?php echo $META_DESCRIPTION; ?>"></td></tr>
<tr><td>Мета ключевые по умолчанию</td><td><input name="META_KEYWORDS" type="text" style="width: 80%;" value="<?php echo $META_KEYWORDS; ?>"></td></tr>
<tr><td>Название сата</td><td><input name="SITE_TITLE" type="text" style="width: 80%;" value="<?php echo $SITE_TITLE; ?>"></td></tr>
    <?php
}
?>

<tr><td>Текст по умолчанию</td><td><input name="DEFAULT_TXT" type="text" style="width: 80%;" value="<?php echo $DEFAULT_TXT??''; ?>"></td></tr>
<tr><td>Логин админа</td><td><?php echo $ADMIN_LOGIN; ?></td></tr>
<tr><td>пароль админа</td><td>*****<!--<?php echo $ADMIN_PASSWORD; ?>--></td></tr>
<tr><td>почта админа</td><td><input name="ADMIN_EMAIL" type="text" style="width: 80%;" value="<?php echo $ADMIN_EMAIL??''; ?>"></td></tr>
<tr><td>почтовый робот</td><td><input name="robotmail" type="text" style="width: 80%;" value="<?php echo $robotmail??''; ?>"></td></tr>
<tr><td>DATABASE_HOST</td><td><?php echo $DATABASE_HOST; ?></td></tr>
<tr><td>DATABASE_NAME</td><td><?php echo $DATABASE_NAME; ?></td></tr>
<tr><td>DATABASE_LOGIN</td><td><?php echo $DATABASE_LOGIN; ?></td></tr>
<tr><td>DATABASE_PASSWORD</td><td>*****<!--<?php echo $DATABASE_PASSWORD; ?>--></td></tr>
<tr><td>SECRET_KEY</td><td>*****<!--<?php echo $SECRET_KEY; ?>--></td></tr>
<tr><td>Время ротации на главной странице(в секундах)</td><td><input name="ROTATOR" type="text" style="width: 80%;" value="<?php echo $ROTATOR/1000; ?>"></td></tr>
<tr><td>Макс ширина картинки в каталоге и карточке</td><td><input name="IMAGE_MAXSIZE" type="text" style="width: 80%;" value="<?php echo $IMAGE_MAXSIZE; ?>">px</td></tr>
<tr><td>Макс высота картинки в каталоге и карточке</td><td><input name="IMAGE_HMAXSIZE" type="text" style="width: 80%;" value="<?php echo $IMAGE_HMAXSIZE; ?>">px</td></tr>
<tr><td>Макс ширина картинки маленькой(превью)</td><td><input name="IMAGE2_MAXSIZE" type="text" style="width: 80%;" value="<?php echo $IMAGE2_MAXSIZE; ?>">px</td></tr>
<tr><td>Макс ширина картинки в модальном окне</td><td><input name="IMAGE3_MAXSIZE" type="text" style="width: 80%;" value="<?php echo $IMAGE3_MAXSIZE; ?>">px</td></tr>
<tr><td>Макс высота картинки в модальном окне</td><td><input name="IMAGE3_HMAXSIZE" type="text" style="width: 80%;" value="<?php echo $IMAGE3_HMAXSIZE; ?>">px</td></tr>
<tr><td>Высота ротатора</td><td><input name="FRIMG_HEIGHT" type="text" style="width: 80%;" value="<?php echo $FRIMG_HEIGHT; ?>">px</td></tr>
<tr><td>Ширина картинки ротатора</td><td><input name="FRIMG_WIDTH" type="text" style="width: 80%;" value="<?php echo $FRIMG_WIDTH; ?>">px</td></tr>
<tr><td>Высота картинки вывод на главную</td><td><input name="LINKIMG_HEIGHT" type="text" style="width: 80%;" value="<?php echo $LINKIMG_HEIGHT; ?>">px</td></tr>
<tr><td>Ширина картинки вывод на главную</td><td><input name="LINKIMG_WIDTH" type="text" style="width: 80%;" value="<?php echo $LINKIMG_WIDTH; ?>">px</td></tr>
<tr><td>Высота превью картинки ротатора</td><td><input name="FRIMG2_HEIGHT" type="text" style="width: 80%;" value="<?php echo $FRIMG2_HEIGHT; ?>">px</td></tr>
<tr><td>Ширина превью картинки ротатора</td><td><input name="FRIMG2_WIDTH" type="text" style="width: 80%;" value="<?php echo $FRIMG2_WIDTH; ?>">px</td></tr>
<tr><td>Цвет фона ротатора</td><td>#<input name="FRGB" type="text" style="width: 80%;" value="<?php echo strtoupper(str_pad(dechex($FRGB), 6, "0", STR_PAD_LEFT));  ?>"></td></tr>
<tr><td>Цвет фона картинок</td><td>#<input name="RGB" type="text" style="width: 80%;" value="<?php echo strtoupper(str_pad(dechex($RGB), 6, "0", STR_PAD_LEFT)); ?>"></td></tr>
<tr><td>Водяной знак</td><td><input name="WATERMARK" type=checkbox value="1"<?php echo $wchecked?>></td></tr>
<!--
<tr><td>Ширина картинки картинки галереи</td><td><input name="GAL_WIDTH" type="text" style="width: 80%;" value="<?php echo $GAL_WIDTH??''; ?>">px</td></tr>
<tr><td>Высота картинки картинки галереи</td><td><input name="GAL_HEIGHT" type="text" style="width: 80%;" value="<?php echo $GAL_HEIGHT??''; ?>">px</td></tr>
<tr><td>Ширина превью картинки галереи</td><td><input name="SGAL_WIDTH" type="text" style="width: 80%;" value="<?php echo $SGAL_WIDTH??''; ?>">px</td></tr>
<tr><td>Высота превью картинки галереи</td><td><input name="SGAL_HEIGHT" type="text" style="width: 80%;" value="<?php echo $SGAL_HEIGHT??''; ?>">px</td></tr>-->

<tr><td></td><td><input class="button" type="submit" name="set" value="Отправить"></td></tr>

</table>
</form>
