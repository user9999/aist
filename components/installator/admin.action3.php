<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
include $HOSTPATH."/modules/modules.php";
//var_dump($modules);
if($_POST){
	
	foreach($_POST['module'] as $name=>$val){
		if(!empty($modules[$val]['tpl_replace'])){
			$tpl=file_get_contents($HOSTPATH."/templates/blank/template.php");
			foreach($modules[$val]['tpl_replace'] as $target=>$source){
			
				$source=str_replace("[position]",$_POST['position'][$val],$source);
				$tpl=str_replace($target,$source,$tpl);
				
				
			}
			$fp=fopen($HOSTPATH."/templates/blank/template.php","w+");
			fwrite($fp,$tpl);
			fclose($fp);
		}
		if(!empty($modules[$val]['css_replace'])){
			$tpl=file_get_contents($HOSTPATH."/templates/blank/style.css");
			
			foreach($modules[$val]['css_replace'] as $target=>$source){
				if(strpos($tpl, $target)===false){
					$fp=fopen($HOSTPATH."/templates/blank/style.css","a+");
					fwrite($fp,"\n".$target."\n".$source);
					fclose($fp);
				}
				//$tpl=str_replace($target,$source,$tpl);
			}
			
;
		}
		if(!empty($modules[$val]['index_replace'])){
			$tpl=file_get_contents($HOSTPATH."/index.php");
			foreach($modules[$val]['index_replace'] as $target=>$source){
				$tpl=str_replace($target,$source,$tpl);
			}
			$fp=fopen($HOSTPATH."/index.php","w+");
			fwrite($fp,$tpl);
			fclose($fp);
		}
		if(!empty($modules[$val]['query'])){
			if($_POST['fname'][$name]!=$modules[$val]['file']){
				//echo $HOSTPATH."/modules/".$modules[$val]['file'].".php<br>";
				//echo $HOSTPATH."/modules/".$_POST['fname'][$name].".php<br>";
				copy($HOSTPATH."/modules/".$modules[$val]['file'].".php", $HOSTPATH."/modules/".$_POST['fname'][$name].".php");
			}
			foreach($modules[$val]['query'] as $q){
				$q=str_replace("[module]",$_POST['fname'][$val],$q);
				$q=str_replace("[position]",$_POST['position'][$val],$q);
				//die($q);
				mysql_query($q);
			}
		}

		if(!empty($modules[$val]['lang'])){
			foreach($modules[$val]['lang'] as $var=>$translations){
				$lang_out.="\$".$var."=array(";
				foreach($translations as $lang=>$meaning){
					$lang_out.="\"$lang\"=>\"$meaning\",";
				}
				$lang_out.=");\n";
			}
			$langfile=file_get_contents($HOSTPATH."/inc/lang.php");
			$langfile=str_replace("?>",$lang_out."?>",$langfile);
			$fp=fopen($HOSTPATH."/inc/lang.php","w+");
			fwrite($fp,$langfile);
			fclose($fp);
		}
		

	}
}
foreach($modules as $name=>$val){
		$comp_out='';
		if(!empty($val['components'])){
			foreach($val['components'] as $n=>$component){
				$res=mysql_query("select id from ".$PREFIX."installed where name='{$component}'");
				if(mysql_num_rows($res)){
					$comp_out.="Требуемый компонент ".$component." установлен<br>";
				} else {
					$comp_out.="Требует установки компонента ".$component."<br>";
				}
			}
		}
		$mod_out="";
		if(!empty($val['modules'])){
			//$mod_out="";
			foreach($val['modules'] as $n=>$module){
				$mod_require="";
				$res=mysql_query("select position from ".$PREFIX."modules where name='{$module}'");
				while($row=mysql_fetch_row($res)){
					
					$mod_require.=$row[0]." ";
				}
				$mod_out.=($mod_require=="")?"Требует установки модуля ".$module:"Связанный модуль установлен в позиции".$mod_require;
			}
		}
		$req_out=(strlen($comp_out.$mod_out)>0)?"<div class=required>$comp_out $mod_out</div>":"";
	$q="select module,position from ".$PREFIX."modules where name='{$name}'";
	//echo $q;
	$res=mysql_query($q);
	$installed="";
	while($row=mysql_fetch_row($res)){
		$installed.="<p class=exist>Уже установлен файл {$row[0]} в позицию {$row[1]}</p>";
	}
	//var_dump($val);
	$out=$out??'';
	if($installed==""){
		$descr=($val['description']??false)?"<div class=info>{$val['description']}</div>":"";
		$checked=($installed=="" && $val['install'])?$val['install']:"";
		$out.="<div class=module><h3>{$val['name']}</h3>{$descr}{$installed}
		$req_out
		<label for={$val['file']}>Установить<input id={$val['file']} name=module[] value=$name type=checkbox $checked></label> <label for=f{$val['file']}>файл<input type=text id=f{$val['file']} name=fname[{$val['file']}] value=$name></label> <label for=p{$val['file']}>позиция<input id=p{$val['file']} type=text name=position[{$val['file']}] value=$name></label>
		</div>";
	}
}
?>
<form method=post>
<?=$out?>
<input type=submit class=button name=submit value="Установить">
</form>
