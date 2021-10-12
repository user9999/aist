<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
$_GET['c']=($_GET['c']??false)?$_GET['c']:"kvn_general";
if(is_dir($HOSTPATH."/components/".$_GET['c']."/")) {
    if(file_exists($HOSTPATH."/components/".$_GET['c']."/lang/lang.php")) {
        include_once $HOSTPATH."/components/".$_GET['c']."/lang/lang.php";
    } else {
        if(!is_dir($HOSTPATH."/components/".$_GET['c']."/lang/")) {
            mkdir($HOSTPATH."/components/".$_GET['c']."/lang/");
        }
        if(!file_exists($HOSTPATH."/components/".$_GET['c']."/lang/lang.php")) {
            $fp=fopen($HOSTPATH."/components/".$_GET['c']."/lang/lang.php", "w+");
            fclose($fp);
        }
        include_once $HOSTPATH."/components/".$_GET['c']."/lang/lang.php";
    }
} else {
    include_once $HOSTPATH."/inc/lang.php";
}
if($_POST['submit']??false) {
    foreach($_POST['var'] as $n=>$v){
        if($v!="") {
            foreach($_POST['lang'] as $lang=>$value){
                $strings[$v].="\"$lang\"=>\"{$value[$v]}\",";
            }
        }
    }
    $string="<?php\n";
    foreach($strings as $var=>$str){
        $string.="\$".$var."=array(".$str.");\n";
    }
    $string.="\n?>";
    //var_dump( $string);
    if($_GET['c']=="kvn_general") {
        $fp=fopen($HOSTPATH."/inc/lang.php", "w");
        fwrite($fp, $string);
        fclose($fp);
    } elseif(file_exists($HOSTPATH."/components/".$_GET['c']."/lang/lang.php")) {
        $fp=fopen($HOSTPATH."/components/".$_GET['c']."/lang/lang.php", "w");
        fwrite($fp, $string);
        fclose($fp);
    }
    header("Location: ?component=index&action=4&c=".$_GET['c']);
}
//$vars=file($HOSTPATH."/inc/lang.php");


?>
<br>
<b>Должны начинаться с dblang_</b><br>
<div class=submenu>
<?php
echo "<b><a href=\"?component=index&action=4&c=kvn_general\">Общие</a></b> ";
$not=array("tpleditor","texteditor","imageeditor","counter","currency","menu","payment","price","static");
foreach(glob($HOSTPATH."/components/*/install.php") as $comp){
    $link=str_replace("/install.php", "", $comp);
    if(file_exists($link."/lang/lang.php")) {
        $class=" class=exists";
    } else {
        $class="";
    }
    $link=str_replace($HOSTPATH."/components/", "", $link);
    
    if($link==$_GET['c']) {
        $b="<b>";$be="</b>";
    } else {
        $b=$be="";
    }
    if(!in_array($link, $not)) {
        $res=mysql_query("select id from ".$PREFIX."installed where name='{$link}'");
        if(mysql_num_rows($res)) {
            echo "$b<a href=\"?component=index&action=4&c=$link\"$class>$link</a>$be ";
        }
    }
}

?>
</div>
<form method=post>
<table>
<?php
foreach($GLOBALS as $var_name => $value) {

    if (strpos($var_name, "dblang_")!==false) {
        echo "<tr><td>\$<input type=text name='var[{$var_name}]' value='{$var_name}'></td>";
        foreach($LANGUAGES as $lang=>$path){
            echo "<td>".$lang."<input type=text name='lang[".$lang."][{$var_name}]' value='{$value[$lang]}'></td>";
        }
        echo "</tr>";
    }
}
echo "<tr><td>\$<input type=text name='var[new]'></td>";
$i=0;
foreach($LANGUAGES as $lang=>$path){
    echo "<td>".$lang."<input type=text name='lang[".$lang."][new]'></td>";
    $i++;
}
?>
<tr><td colspan="<?php echo $i; ?>"><input type=submit class=button name=submit value="Записать"></td></tr>
</tr></table>
</form>