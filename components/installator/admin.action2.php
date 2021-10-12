<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
$out="";

foreach(glob($HOSTPATH."/components/*/install.php") as $file){
	include $file;
	$varname=str_replace($HOSTPATH."/components/","",$file);
	$varname=str_replace("/install.php","",$varname);
	$var="install".ucfirst($varname);
	//echo $$var['install']."<br>";
	$install[$var]=$$var;
	$checked=($install[$var]['install'])?$install[$var]['install']:"";
	$checked=str_replace("-"," ",$checked);
	$sub="";
	if(!empty($install[$var]["submenu"])){//=>array(1=>'Добавление статьи',2=>'Настройки оплаты')
		$sub.="Подменю: ";
		foreach($install[$var]["submenu"] as $n=>$val){
			$sub.="<label for=".$var.$n.">$val<input id=".$var.$n." name=".$var."[] value=$n type=checkbox $checked></label>";
		}
	}
	
	
	
	$installed="";
	$res=mysql_query("select id from ".$PREFIX."installed where name='".$varname."'");
	$flag=0;
	if(mysql_num_rows($res)){
		$flag=1;
		$installed="<p class=exist>Компонент уже установлен!</p>";
	}
	if($flag==1){
	$checked=($flag!=1 && $install[$var]['install'])?$install[$var]['install']:"";
	$checked=str_replace("-"," ",$checked);
	$out.="<div class=module><h3>".$install[$var]['name']."</h3>{$installed}
	<p>".$install[$var]['description']."</p><div class='mod_block'>
	<label for={$var}>Установить<input id={$var} name=module[] value=$var type=checkbox $checked></label> 
	".$sub."</div>
	<!--<label for=f{$var}>файл</label><input type=text id=f{$var} name=fname[] value=$var> 
	<label for=p{$var}>позиция</label><input id=p{$var} type=text name=position[] value=$var>-->
	</div>";
	}
	//var_dump($install[$var]['install']);
}
if($_POST){
	foreach($_POST['module'] as $name=>$val){
	
		$newarr="";
		if(!empty($_POST[$val])){
			$newarr="\$arr = array(";
			foreach($_POST[$val] as $n=>$v){
				$newarr.="$v => '".$install[$val]['submenu'][$v]."',"; 
			}
			$newarr.=");\n/*menu_array*/";
			//die($newarr);
			$f=str_replace("install","",$val);
			$component=strtolower($f);
			$f=$HOSTPATH."/components/$component/admin.$component.php";
			if(file_exists($f)){
				$tpl=file_get_contents($f);
				$tpl=str_replace("/*menu_array*/",$newarr,$tpl);
				$fp=fopen($f,"w+");
				fwrite($fp,$tpl);
				fclose($fp);
			}
		}
		//echo $newarr."<br>";
	
		if(!empty($install[$val]['tpl_replace'])){
			$tpl=file_get_contents($HOSTPATH."/templates/blank/template.php");
			foreach($install[$val]['tpl_replace'] as $target=>$source){
				$tpl=str_replace($target,$source,$tpl);
			}
			$fp=fopen($HOSTPATH."/templates/blank/template.php","w+");
			fwrite($fp,$tpl);
			fclose($fp);
		}
		if(!empty($install[$val]['css_replace'])){
			$tpl=file_get_contents($HOSTPATH."/templates/blank/style.css");
			foreach($install[$val]['css_replace'] as $target=>$source){
				$tpl=str_replace($target,$source,$tpl);
			}
			$fp=fopen($HOSTPATH."/templates/blank/style.css","w+");
			fwrite($fp,$tpl);
			fclose($fp);
		}
		if(!empty($install[$val]['index_replace'])){
			$tpl=file_get_contents($HOSTPATH."/index.php");
			foreach($install[$val]['index_replace'] as $target=>$source){
				$tpl=str_replace($target,$source,$tpl);
			}
			$fp=fopen($HOSTPATH."/index.php","w+");
			fwrite($fp,$tpl);
			fclose($fp);
		}
	}
	header("Location: ?component=installator&action=1");
}
?>
<form method=post>
<?=$out?>
<input type=submit name=submit value="Установить">
</form>
