<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
include $HOSTPATH."/widgets/widgets.php";
//var_dump($modules);
if($_POST){
	
	foreach($_POST['module'] as $name=>$val){
		if(!empty($modules[$val]['tpl_replace'])){
			
                        if(file_exists($HOSTPATH."/templates/{$TEMPLATE}/index.template.php")){
                            $tpl=file_get_contents($HOSTPATH."/templates/{$TEMPLATE}/index.template.php");
                            foreach($modules[$val]['tpl_replace'] as $target=>$source){
                                    $tpl=str_replace($target,$source,$tpl);
                            }
                            $fp=fopen($HOSTPATH."/templates/{$TEMPLATE}/index.template.php","w+");
                            fwrite($fp,$tpl);
                            fclose($fp);
                        }else{
                            $tpl=file_get_contents($HOSTPATH."/templates/{$TEMPLATE}/template.php");
                            foreach($modules[$val]['tpl_replace'] as $target=>$source){
                                    $tpl=str_replace($target,$source,$tpl);
                            }
                            $fp=fopen($HOSTPATH."/templates/{$TEMPLATE}/template.php","w+");
                            fwrite($fp,$tpl);
                            fclose($fp);
                        }
                        
		}
		if(!empty($modules[$val]['css_replace'])){
			$tpl=file_get_contents($HOSTPATH."/templates/{$TEMPLATE}/style.css");
			
			foreach($modules[$val]['css_replace'] as $target=>$source){
				if(strpos($tpl, $target)===false){
					$fp=fopen($HOSTPATH."/templates/{$TEMPLATE}/style.css","a+");
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
		if(!empty($val['components'])){
			foreach($val['components'] as $n=>$component){
				$res=mysql_query("select id from ".$PREFIX."installed where name='{$component}'");
				if(mysql_num_rows($res)){
					$comp_out.="?????????????????? ?????????????????? ".$component." ????????????????????<br>";
				} else {
					$comp_out.="?????????????? ?????????????????? ???????????????????? ".$component."<br>";
				}
			}
		}
		if(!empty($val['modules'])){
			$mod_out="";
			foreach($val['modules'] as $n=>$module){
				$mod_require="";
				$res=mysql_query("select position from ".$PREFIX."modules where name='{$module}'");
				while($row=mysql_fetch_row($res)){
					
					$mod_require.=$row[0]." ";
				}
				$mod_out.=($mod_require=="")?"?????????????? ?????????????????? ???????????? ".$module:"?????????????????? ???????????? ???????????????????? ?? ??????????????".$mod_require;
			}
		}
		$req_out=(strlen($comp_out.$mod_out)>0)?"<div class=required>$comp_out $mod_out</div>":"";
	$q="select module,position from ".$PREFIX."modules where name='{$name}'";
	//echo $q;
	$res=mysql_query($q);
	$installed="";
	while($row=mysql_fetch_row($res)){
		$installed.="<p class=exist>?????? ???????????????????? ???????? {$row[0]} ?? ?????????????? {$row[1]}</p>";
	}
	if($installed==""){
		$checked=($installed=="" && $val['install'])?$val['install']:"";
		$d=($val['description'])?"<div class=info>{$val['description']}</div>":"";
		$out.="<div class=module><h3>{$val['name']}</h3>{$d}{$installed}
		$req_out
		<label for={$val['file']}>????????????????????<input id={$val['file']} name=module[] value=$name type=checkbox $checked></label> <label for=f{$val['file']}>????????<input type=text id=f{$val['file']} name=fname[{$val['file']}] value=$name></label> <label for=p{$val['file']}>??????????????<input id=p{$val['file']} type=text name=position[{$val['file']}] value=$name></label>
		</div>";
	}
}
?>
<form method=post>
<?=$out?>
<input type=submit class=button name=submit value="????????????????????">
</form>
