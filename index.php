<?php
define("SIMPLE_CMS", 1);
header("Cache-Control: no-cache, must-revalidate");

//include configuration
require_once "inc/configuration.php";
require_once "inc/functions.php";
require_once "classes/HelpFactory.php";
require_once "classes/other/Mobile_Detect.php";
        
//include 'components/counter/count.php';
require_once "inc/lang.php";
//includes_end
$TPL=$TEMPLATE;
$userlanguage=userlang();
session_start();
//partner_replace
//select component
$TBL="";$AUTHUSER="";
$ZNAK=$dblang_znak[$userlanguage];//"руб.";
if (isset($_SESSION['user_name'])) {
    $userpercent="";
    if($_SESSION['actype'][0]==0) {
        $userpercent=($_SESSION['percent'])?$_SESSION['percent']:0;
        $userpercent="<br>Ваша скидка ".$userpercent."%"; 
    } elseif($_SESSION['actype'][0]==1) {
        if($_SESSION['actype'][6]==1) {
            $res=mysql_query("select currency from currency where id=1");
            $row=mysql_fetch_row($res);
            if($row[0]=="euro") {
                if($_COOKIE['currency']=='rub') {
                    $ch_cur='euro';
                    $curstr="рублях";
                    $tcstr="у.е.";
                    $ZNAK="руб.";     
                } else {
                    $ch_cur='rub';
                    $curstr="у.е."; 
                    $tcstr="рублях"; 
                    $ZNAK="у.е.";
                }
                $userpercent="<br>Цены указаны в <a href=\"javascript:setCookie('currency','".$ch_cur."');\" id=\"currency\" title=\"показать в $tcstr\" style=\"text-decoration:underline\">$curstr</a>";

            } elseif($row[0]=="dollar") {
                if($_COOKIE['currency']=='rub') {
                    $ch_cur='dollar';
                    $curstr="рублях";
                    $tcstr="долларах";
                    $ZNAK="руб.";     
                } else {
                    $ch_cur='rub';
                    $curstr="долларах"; 
                    $tcstr="рублях"; 
                    $ZNAK="у.е.";
                }
        
                $userpercent="<br>Цены указаны в <a href=\"javascript:setCookie('currency','".$ch_cur."');\" id=\"currency\" title=\"показать в $tcstr\">$curstr</a>";
                $ZNAK="\$";
            } else {
                $userpercent="<br>Цены указаны в рублях";
            }
        } else {
            $userpercent="";
        }
    }
    $SITE_TITLE="Кабинет пользователя ".$_SESSION['user_name'].$userpercent;
    $TBL="_users";
    $AUTHUSER="user.";
}
$component = 'index';
$OUTPUT_FORMAT="url";
$URL=(preg_match("/^[a-z0-9_\/]+$/", $_GET['view']))?$_GET['view']:NULL;

if($MY_URL==1){
	//var_dump($_SERVER['QUERY_STRING']);
	$url=mysql_real_escape_string($_GET['view']);
	//echo $url;
	$query="SELECT component,cmsurl,type from ".$PREFIX."url where url='{$url}' LIMIT 1";
	//echo "<br>".$query;die();
	$result=mysql_query($query);
	$myrow=mysql_fetch_row($result);
	//var_dump($myrow);//die();
	//$component = ($myrow[0])?$myrow[0]:$component;
        
	if($myrow[0]){
           $component = $myrow[0];
        }else{
            $MY_URL=0;
        }
        
        $OUTPUT_FORMAT=($myrow[2])?$myrow[2]:'url';
        
	$_SERVER['QUERY_STRING']=str_replace($_GET['view'],$myrow[1],$_SERVER['QUERY_STRING']);
	$_GET['view']=($myrow[1])?$myrow[1]:"static/$component";

}

get_segments();

if (isset($_GET['view']) && preg_match("/^[a-z0-9_]+$/", $_GET['view'])) {
    $component = $_GET['view'];
    $AUTHUSER=($component=="static")?"":$AUTHUSER;
    if (!file_exists("components/$component/$AUTHUSER"."$component.php")) {
        header("HTTP/1.0 404 Not Found");
        $component = "404";
    }
} else {
    //choose default component from menu
    $res = @mysql_query("SELECT path FROM ".$PREFIX."menu ORDER BY ordering");
    if ($row = @mysql_fetch_row($res)) {
        $component = $row[0];
    }
}

//include component
switch($OUTPUT_FORMAT){
    case 'url':
        header("Content-Type: text/html; charset=UTF-8");
        break;
    case 'json':
        header("Content-Type: application/json; charset=utf-8");
        break;
    case 'xml':
        header("Content-type: text/xml; charset=utf-8");
        break;
    case 'csv':
        header("Content-Type: application/CSV; charset=utf-8");
        break;
    case 'pdf':
        header("Content-type:application/pdf; charset=utf-8");
        break;
    default :
        header("Content-Type: text/html; charset=UTF-8");
}
//header("Content-Type: text/html; charset=UTF-8");
//header("Content-Type: application/json; charset=utf-8");
//header('Content-type: text/xml; charset=utf-8');
//header("Content-Type: application/CSV; charset=utf-8");
//header("Content-type:application/pdf");

ob_start();
set_css('');
set_script('');
if(file_exists("components/$component/lang/lang.php")) {
    include_once "components/$component/lang/lang.php";

}
require "components/$component/$AUTHUSER"."$component.php";
if(file_exists("components/$component/tpl/css/style.css")) {
    set_css($component."/tpl/css/style.css", 1);
}
if(file_exists("components/$component/tpl/js/script.js")) {
    set_script($component."/tpl/js/script.js", 1);
}

$PAGE_BODY = ob_get_contents();

if(strpos($PAGE_BODY, "{tab")!==false) {
    include_once "inc/Tabs.php";
    $PAGE_BODY=Tabs::getTabs($PAGE_BODY);
}
ob_clean();

if($OUTPUT_FORMAT=='url'){
//include template
    $detect = new Mobile_Detect;
    $MOBILE='';

    if (file_exists("templates/{$TEMPLATE}/m.{$component}.template.php")  && (($detect->isMobile() && !$detect->isTablet()) || ($_SESSION['development']==1 && $_GET['mobile']==1))) {
        $MOBILE="m.";
        include "templates/{$TEMPLATE}/{$MOBILE}{$component}.template.php";
    } elseif(file_exists("templates/{$TEMPLATE}/{$component}.template.php")) {
        include "templates/$TEMPLATE/$component.template.php";
    } else {
        if(file_exists("templates/$TEMPLATE/m.template.php") && (($detect->isMobile() && !$detect->isTablet()) || ($_SESSION['development']==1 && $_GET['mobile']==1))){
            $MOBILE="m.";
        }
        include "templates/{$TEMPLATE}/{$MOBILE}template.php";
    }
}else{
    echo $PAGE_BODY;
}
//include_once "inc/cb.php";
?>
