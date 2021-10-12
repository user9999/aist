<?php
if(!defined('INSTALL')) { die();
}
require "../inc/configuration.php";
require "../inc/functions.php";
if($_POST) {
    //var_dump($_POST);
    //die();
    $pagetitle=array();
    foreach($_POST['spage'] as $n=>$p){
        //echo $n." ".$_POST['pagetitle'][$n]." ".$path.$_POST['pageurl'][$n];
        $pagetitle['ru']=$_POST['pagetitle'][$n];//mysql_real_escape_string(
        $pagelang=addslashes(serialize($pagetitle));
        //echo " pagetitleru:{$pagetitle['ru']} serialize:".$pagelang;
        $pageurl=mysql_real_escape_string($_POST['pageurl'][$n]);
        //echo " pageurl:".$pageurl."<br>";
        $path=($_POST['pageurl'][$n]=='index')?"":"static/";
        $query="INSERT INTO `".$PREFIX."static` SET path='{$pageurl}', title='{$pagetitle['ru']}'";
        //echo $query."<br>";
        mysql_query($query);
                
        $id=mysql_insert_id();
        $query="INSERT INTO ".$PREFIX."lang_text SET table_name='static',rel_id={$id},language='ru',title='{$pagetitle['ru']}'";
        //echo $query."<br>";
        mysql_query($query);
        $query="INSERT INTO ".$PREFIX."menu SET text='{$pagelang}',path='".$path.$pageurl."',level=1";
        //echo $query."<br>";
        mysql_query($query);
                
    }
    /*
    foreach($_POST['dynamic'] as $n=>$p){
    $dynamictitle=mysql_real_escape_string($_POST['dynamictitle'][$n]);
    $dynamicurl=mysql_real_escape_string($_POST['dynamicurl'][$n]);
    mysql_query("INSERT INTO ".$PREFIX."menu SET text='{$dynamictitle}',path='{$dynamicurl}'");
    $res=mysql_query("SELECT MAX( ordering ) FROM  `".$PREFIX."menu_admin`");
    $row=mysql_fetch_array($res);
    mysql_query("INSERT INTO `".$PREFIX."menu_admin` ( `text`, `path`, `ordering`, `display`) VALUES('{$dynamictitle}', '{$dynamicurl}', ".($row[0]+1).", 1)");
    }
    */
    //echo "INSERT INTO ".$PREFIX."menu SET text='{$pagetitle}',path='".$path.$pageurl."'";
    //die();
    ?>
<script> document.location.href='?step=4'</script>";
    <?php
}
?>
<h3>Создание статичных страниц</h3>
<form method=post style="<?php echo $style?>">
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl" checked><input type=text class="w33 fl" name="pagetitle[]" value="Главная"><input class=w33  type=text name="pageurl[]" value="index"></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl" checked><input type=text class="w33 fl" name="pagetitle[]" value="О компании"><input class=w33  type=text name="pageurl[]" value="about"></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl" checked><input type=text class="w33 fl" name="pagetitle[]" value="Контакты"><input class=w33  type=text name="pageurl[]" value="contacts"></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl" checked><input type=text class="w33 fl" name="pagetitle[]" value="Доставка"><input class=w33  type=text name="pageurl[]" value="delivery"></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>
<div class=line><input type=checkbox name="spage[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="pagetitle[]" value=""><input class=w33  type=text name="pageurl[]" value=""></div>

<!--
<h3>Создание динамичных страниц</h3>
<div class=line><input type=checkbox name="dynamic[]" value=1 class="w33 fl" checked><input type=text class="w33 fl" name="dynamictitle[]" value="Новости"><input class=w33  type=text name="dynamicurl[]" value="news"></div>
<div class=line><input type=checkbox name="dynamic[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="dynamictitle[]" value="Галерея"><input class=w33  type=text name="dynamicurl[]" value="gallery"></div>
<div class=line><input type=checkbox name="dynamic[]" value=1 class="w33 fl"><input type=text class="w33 fl" name="dynamictitle[]" value="Статьи"><input class=w33  type=text name="dynamicurl[]" value="articles"></div>
-->
<div class=line><input type="hidden" name=step value="2">
<div class=line><input type="submit" name=check value="Создать">
</form>
