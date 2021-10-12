<?php
$content="<?php if (!defined(\"ADMIN_SIMPLE_CMS\")) die(\"Access denied\"); 
?>";
$defaultcontent="<?php if (!defined(\"SIMPLE_CMS\")) die(\"Access denied\");
?>";
if($_POST['adminnum'] || $_POST["table"]){
	//$menu="";
	for($i=1;$i<=count($_POST['adminmenu']);$i++){
		$menu.=$i." => '".$_POST['adminmenu'][$i]."',";
	}

	$admin="<?php if (!defined(\"ADMIN_SIMPLE_CMS\")) die(\"Access denied\"); 
\$arr = array(".$menu.");
/*menu*/

\$default=(array_key_exists('View', \$arr))?'View':1;
\$action = \$default;
if (isset(\$_GET['action'])) {
    \$action =(\$_GET['action']==\"View\" || \$_GET['action']==\"Edit\" || \$_GET['action']==\"Add\")?\$_GET['action']:intval(\$_GET['action']);
    \$default=(array_key_exists('View', \$arr))?'View':1;
    \$action=(array_key_exists(\$action, \$arr))?ucfirst(\$action):\$default;
}
//render list of actions
renderActions(\$action,\$arr,'{$_POST['alias']}');
include(\$HOSTPATH.\"/components/".$_POST['alias']."/lang/lang.php\");
include(\"admin.action\$action.php\");
?>";
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/admin.".$_POST['alias'].".php","w+");
	fwrite($fp,$admin);
	fclose($fp);
		


	for($i=1;$i<=$_POST['adminnum'];$i++){
		$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/admin.action".$i.".php","w+");
		fwrite($fp,$content);
		fclose($fp);
	}
} else {
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/admin.".$_POST['alias'].".php","w+");
	fwrite($fp,$content);
	fclose($fp);
}

if($_POST['usernum'] || $_POST["table"]){
	//$menu="";
	for($i=1;$i<=count($_POST['usermenu']);$i++){
		$umenu.=$i." => '".$_POST['usermenu'][$i]."',";
		$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/user.action".$i.".php","w+");
		fclose($fp);
	}

	$user="<?php if (!defined(\"SIMPLE_CMS\")) die(\"Access denied\"); 
\$arr = array(".$umenu.");
/*menu_array*/
\$action=(isset(\$csection))?\$csection:'default';
if (isset(\$action)) {
    \$action =(\$action==\"default\" || \$action==\"view\" || \$action==\"edit\" || \$action==\"add\")?\$action:intval(\$action);
    //\$default=(array_key_exists('view', \$arr))?'view':1;
    \$action=(array_key_exists(\$action, \$arr))?\$action:'default';
}
//render list of actions
renderActions(\$action,\$arr,'{$_POST['alias']}',false);
\$action=ucfirst(\$action);
include(\"user.action\$action.php\");
?>";
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/user.".$_POST['alias'].".php","w+");
	fwrite($fp,$user);
	fclose($fp);
		


	for($i=1;$i<=$_POST['usernum'];$i++){
		$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/user.action".$i.".php","w+");
		fwrite($fp,$content);
		fclose($fp);
		$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/user.action".$i.".php","w+");
		fclose($fp);
	}
} else {
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/user.".$_POST['alias'].".php","w+");
	fwrite($fp,$defaultcontent);
	fclose($fp);
}


if($_POST['sitenum'] || $_POST["table"]){
	//$menu="";
    if($_POST['sitemenu']){
	for($i=1;$i<=count($_POST['sitemenu']);$i++){
		$smenu.=$i." => '".$_POST['sitemenu'][$i]."',";
		$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/action".$i.".php","w+");
		fclose($fp);
	}
    }
	$site="<?php if (!defined(\"SIMPLE_CMS\")) die(\"Access denied\"); 
\$arr = array(".$smenu.");
/*menu_array*/
\$action=(isset(\$csection))?\$csection:'default';

if (isset(\$action)) {
    \$action =(\$action==\"default\" || \$action==\"view\" || \$action==\"edit\" || \$action==\"add\")?\$action:intval(\$action);
    //\$default=(array_key_exists('view', \$arr))?'view':1;
    \$action=(array_key_exists(\$action, \$arr))?\$action:'default';
}
//render list of actions
renderActions(\$action,\$arr,'{$_POST['alias']}',false);
\$action=ucfirst(\$action);
include(\"action\$action.php\");
?>";
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/".$_POST['alias'].".php","w+");
	fwrite($fp,$site);
	fclose($fp);
		


	for($i=1;$i<=$_POST['sitenum'];$i++){
		$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/action".$i.".php","w+");
		fwrite($fp,$content);
		fclose($fp);
		$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/action".$i.".php","w+");
		fclose($fp);
	}
} else {
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/".$_POST['alias'].".php","w+");
	fwrite($fp,$defaultcontent);
	fclose($fp);
}
	$queries=implode(",",$iTable);
	$content="<?php
if(!defined(\"INSTALL\") && !defined(\"ADMIN_SIMPLE_CMS\")) die();
\$install".ucfirst($_POST['alias'])."=array(\"name\"=>\"".$_POST['title']."\",
\"description\"=>\"\",
\"install\"=>\"\",
\"tpl_replace\"=>array(),
\"css_replace\"=>array(),
\"index_replace\"=>array(),
\"submenu\"=>array(".$menu."),
\"queries\"=>array(".$queries.$aQuery."),
);
?>";
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/install.php","w+");
	fwrite($fp,$content);
	fclose($fp);

$content="<?php
".$Lang."
?>";	
	$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/lang/lang.php","w+");
	fwrite($fp,$content);
	fclose($fp);	
	
	//$fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/".$_POST['alias'].".php","w+");
	//fclose($fp);
        //дефолтные файлы
        $site_css_content='';$adm_css_content='';
        $site_js_content="\$(document).ready(function(){
});";
        $adm_js_content="\$(document).ready(function(){
});";
        ///запись дефолтных значений
        $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/css/style.css","w+");
	fwrite($fp,$site_css_content);
	fclose($fp);
        $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/css/admin.css","w+");
        fwrite($fp,$adm_css_content);
	fclose($fp);
        $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/js/script.js","w+");
	fwrite($fp,$site_js_content);
	fclose($fp);
        $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/js/admin.js","w+");
        fwrite($fp,$adm_js_content);
        fclose($fp);
        $site_css_content_flag=true;$adm_css_content_flag=true;
        $site_js_content_flag=true;$adm_js_content_flag=true;
        copy($HOSTPATH."/components/installator/icon.png",$HOSTPATH."/components/".$_POST['alias']."/icon.png");
        ///// дальше если другие добавляем к дефолтным
        

        if($imageupload){
            $adm_css_content = file_get_contents($HOSTPATH."/components/installator/parts/css/image-upload.css");
            $adm_js_content = file_get_contents($HOSTPATH."/components/installator/parts/js/image-upload.js");
            $adm_css_content_flag=false;
            $adm_js_content_flag=false;
            
            $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/js/admin.js","w+");
            fwrite($fp,$adm_js_content);
            fclose($fp);
            $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/css/admin.css","w+");
            fwrite($fp,$adm_css_content);
            fclose($fp);
            
            if(!is_dir($HOSTPATH."/ajax")){
                mkdir($HOSTPATH."/ajax");
            }
            if(!file_exists($HOSTPATH."/ajax/image-upload.php")){
                copy($HOSTPATH."/components/installator/parts/ajax/image-upload.php",$HOSTPATH."/ajax/image-upload.php");
            }
            if(!is_dir($HOSTPATH."/components/".$_POST['alias']."/tpl/img")){
                mkdir($HOSTPATH."/components/".$_POST['alias']."/tpl/img");
            }
            copy($HOSTPATH."/components/installator/parts/img/preloader.gif",$HOSTPATH."/components/".$_POST['alias']."/tpl/img/preloader.gif");
            if(!is_dir($HOSTPATH."/img")){
                mkdir($HOSTPATH."/img");
            }
            if(!file_exists($HOSTPATH."/img/default.jpg")){
                copy($HOSTPATH."/components/installator/parts/img/default.jpg",$HOSTPATH."/img/default.jpg");
            }
            
        }
        if($_POST["csv"] || $_POST["json"] || $_POST["xml"] || $_POST["pdf"] || $_POST["xls"]){
            $adm_css_content = file_get_contents($HOSTPATH."/components/installator/parts/css/json_csv_xml_pdf_xls.css");
            $adm_js_content = file_get_contents($HOSTPATH."/components/installator/parts/js/json_csv_xml_pdf_xls.js");
            if($adm_js_content_flag){
                $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/js/admin.js","w+");
            }else{
                $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/js/admin.js","a+");
            }
            fwrite($fp,$adm_js_content);
            fclose($fp);
            if($adm_css_content_flag){
                $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/css/admin.css","w+");
            }else{
                $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/css/admin.css","a+");
            }
            fwrite($fp,$adm_css_content);
            fclose($fp);
            $adm_css_content_flag=false;
            $adm_js_content_flag=false;
        }
        if($parentFlag){
            $adm_js_content = file_get_contents($HOSTPATH."/components/installator/parts/js/recursive.js");
            if(!file_exists($HOSTPATH."/templates/".$ADMIN_TEMPLATE."/script.js")){
                $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/js/admin.js","a+");
                fwrite($fp,$adm_js_content);
                fclose($fp);
                //copy($HOSTPATH."/components/installator/tmp/js/recursive.js",$HOSTPATH."/components/".$_POST['alias']."/tpl/js/admin.js");
            }else{
                if(!strpos($scriptcontent,'.recursive')){
                    $fp=fopen($HOSTPATH."/components/".$_POST['alias']."/tpl/js/admin.js","a+");
                    fwrite($fp,$adm_js_content);
                    fclose($fp);
                    //copy($HOSTPATH."/components/installator/tmp/js/recursive.js",$HOSTPATH."/components/".$_POST['alias']."/tpl/js/admin.js");
                }
            }
            
        }
	
?>