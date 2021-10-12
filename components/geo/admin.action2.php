<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied"); 
if(file_exists($HOSTPATH."/inc/cities.php")){
	include $HOSTPATH."/inc/cities.php";
}
?>
<form method=post>
<?php
if($_POST['del']){
	unset($acities[$_POST['del']]);
	$ncities="<?php\n\$acities=";
	$ncities.=var_export($acities,TRUE);
	$ncities.=";";
	$fp=fopen($HOSTPATH."/inc/cities.php","w+");
	fwrite($fp,$ncities);
	fclose($fp);
}
if($_POST['change']){
	$city_out="<?php\n\$acities=array(\n";
	foreach($_POST['city'] as $n=>$v){
		$city_out.="\"$n\"=>array(\n";
		foreach($v as $var=>$val){
			$city_out.="\"$var\"=>\"$val\",\n";
		}
		$city_out.="),";
	}
	if($_POST['newcity']){
		$city_out.="\"{$_POST['newcity']}\"=>array(\"phone\"=>\"{$_POST['newphone']}\",\"fio\"=>\"{$_POST['newfio']}\",\"mail\"=>\"{$_POST['newmail']}\",\"address\"=>\"{$_POST['newaddress']}\",\"img\"=>\"{$_POST['newimg']}\",)";
	}
	$city_out.=");";
	$fp=fopen($HOSTPATH."/inc/cities.php","w+");
	fwrite($fp,$city_out);
	fclose($fp);
	header("Location:  ?component=geo&action=2");
}
if(!empty($acities)){
	//var_dump($acities);
	$cities="";
	foreach($acities as $key => $value){
		$cities.="<div class=city><div class=floatL>$key</div>";
		foreach($value as $name=>$val){
			$cities.="<label for=$name>$name <input id=$name type=text name=\"city[$key][$name]\" value=\"$val\"></label>";
		}
		$cities.="<input type=submit class=del name=del value=$key></div>";
	}
	echo $cities;
}

?>
<div class=city>
<label for=newcity>Город <input id=newcity type=text name=newcity></label>
<label for=newphone>Телефон <input id=newphone type=text name=newphone></label>
<label for=newfio>ФИО <input id=newfio type=text name=newfio></label>
<label for=newmail>Почта <input id=newmail type=text name=newmail></label>
<label for=newaddress>Адрес <input id=newaddress type=text name=newaddress></label>
<label for=newimg>Путь к изображению <input id=newimg type=text name=newimg></label>
</div>
<input type=submit name=change value=изменить>
</form>