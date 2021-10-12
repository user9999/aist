<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) die("Access denied");
$parentFlag=false;
$imageupload=false;
$parentsArray=array('pid','parent_id','parentid','parentId');
$source_table=($_GET['source']??false)?$_GET['source']:'lang_text';
$res=mysql_query("SHOW FIELDS FROM `".$PREFIX.$source_table."`");
//echo "SHOW FIELDS FROM `".$PREFIX.$source_table."`");`";
$sct=($source_table=='lang_text')?'Языковая таблица':'Существующая пересекающаяся таблица '.strtoupper($_GET['source']).' (по умолчанию языковая)';


$langtable="<div class=langtable>$sct</div>";
while($row=mysql_fetch_row($res)){
	if($row[0]=='id' || $row[0]=='table_name' || $row[0]=='rel_id' || $row[0]=='language'){
		$row[1]=str_replace("'",'"',$row[1]);
		$langtable.="<label class=labellang for=\"langtable{$row[0]}'+i+'\"><b>{$row[0]}</b> {$row[1]}<input id=\"langtable{$row[0]}'+i+'\" name=langtable['+i+'][{$row[0]}] type=checkbox checked disabled></label><div class=clear></div>";
	} else {
		$row[1]=str_replace("'",'"',$row[1]);
	$langtable.="<label class=labellang for=\"langtable{$row[0]}'+i+'\"><b>{$row[0]}</b> {$row[1]}<input id=\"langtable{$row[0]}'+i+'\" name=langtable['+i+'][{$row[0]}] type=checkbox checked></label><div class=clear></div>";
	}
}
include "script_css.php";
if(($_POST['alias']??false) && is_dir($HOSTPATH."/components/".$_POST['alias'])){
	echo "такой компонент уже есть!";
} elseif($_POST['alias']??false){
$htmlformfield="<label for=\"url\">URL(ЧПУ):
            <input id=\"url\" class=\"mainform {$_POST['alias']}\" name=\"url\" type=\"text\"  value=\"<?php echo \$url??'' ?>\">
        </label><br> ";
if($_POST["csv"] || $_POST["json"] || $_POST["xml"] || $_POST["pdf"] || $_POST["xls"]){
    $htmlformfield="<label for=\"url\">URL(ЧПУ):
            <input id=\"url_val\" class=\"mainform {$_POST['alias']} hidden\" name=\"url\" type=\"text\"  value=\"<?php echo \$url??'' ?>\"> <input class=\"show_input\" id=\"url\" type=\"checkbox\" name=\"type[url]\"> 
        </label>";
}
if($_POST["csv"]){
    $htmlformfield.="<label for=\"url_csv\">URL(CSV):
            <input id=\"url_csv_val\" class=\"mainform {$_POST['alias']} hidden\" name=\"url_csv\" type=\"text\"  value=\"<?php echo \$url_csv??'' ?>\"> <input class=\"show_input\" id=\"url_csv\" type=\"checkbox\" name=\"type[url_csv]\"> 
        </label>";
}
if($_POST["json"]){
    $htmlformfield.="<label for=\"url_json\">URL(JSON):
            <input id=\"url_json_val\" class=\"mainform {$_POST['alias']} hidden\" name=\"url_json\" type=\"text\"  value=\"<?php echo \$url_json??'' ?>\"> <input class=\"show_input\" id=\"url_json\" type=\"checkbox\" name=\"type[url_json]\"> 
        </label>";
}
if($_POST["xml"]){
    $htmlformfield.="<label for=\"url_xml\">URL(XML):
            <input id=\"url_xml_val\" class=\"mainform {$_POST['alias']} hidden\" name=\"url_xml\" type=\"text\"  value=\"<?php echo \$url_xml??'' ?>\"> <input class=\"show_input\" id=\"url_xml\" type=\"checkbox\" name=\"type[url_xml]\"> 
        </label>";
}
if($_POST["pdf"]){
    $htmlformfield.="<label for=\"url_pdf\">URL(PDF):
            <input id=\"url_pdf_val\" class=\"mainform {$_POST['alias']} hidden\" name=\"url_pdf\" type=\"text\"  value=\"<?php echo \$url_pdf??'' ?>\"> <input class=\"show_input\" id=\"url_pdf\" type=\"checkbox\" name=\"type[url_pdf]\"> 
        </label>";
}
if($_POST["xls"]){
    $htmlformfield.="<label for=\"url_xls\">URL(XLS):
            <input id=\"url_xls_val\" class=\"mainform {$_POST['alias']} hidden\" name=\"url_xls\" type=\"text\"  value=\"<?php echo \$url_xls??'' ?>\"> <input class=\"show_input\" id=\"url_xls\" type=\"checkbox\" name=\"type[url_xls]\"> 
        </label>";
}
//var_dump($_POST);
if($_POST["table"]){
	for($t=1;$t<=$_POST["table"];$t++){
	$qp=($source_table=='lang_text')?",table_name='".$_POST["tablename"][$t]."',language='{\$language}'":'';
	$qp1=($source_table=='lang_text')?" and table_name='".$_POST["tablename"][$t]."'":'';
	$qpL=($source_table=='lang_text')?" and b.table_name='".$_POST["tablename"][$t]."' and b.language='{\$GLOBALS['userlanguage']}'":'';
	$qpnL=($source_table=='lang_text')?" and b.table_name='".$_POST["tablename"][$t]."'":'';
		$iTable[$t-1]="\"CREATE TABLE IF NOT EXISTS `\".\$PREFIX.\"".$_POST["tablename"][$t]."` (";
//var_dump($_POST["multi"]);
		$button=$ubutton="Отправить";
		$SelectQuery[$t-1]="select * from \".\$PREFIX.\"".$_POST["tablename"][$t];
		$SelectQueryS[$t-1]="select * from \".\$PREFIX.\"".$_POST["tablename"][$t];
		$multiquery="b.language as language,";
		$multifields="
<?php
foreach(\$LANGUAGES as \$lang=>\$path){
?>
<div class=lang>Язык : <?= \$lang ?></div>
<input type=hidden name=\"stufflang[]\" value=\"<?= \$lang ?>\">
		";
		$MultiUpdate[$t-1]="UPDATE `\".\$PREFIX.\"".$source_table."` SET ";
		$MultiInsert[$t-1]="INSERT INTO `\".\$PREFIX.\"".$source_table."` SET rel_id={\$rel_id} $qp,";
		$MultiCheck[$t-1]="";
		//$MultiInsertPrepare[$t-1]="mysql_insert_id()";
		
    if($_POST["multi"]){
	$button="<?=\$GLOBALS['dblang_button'][\$DLANG]?>";
	$ubutton="<?=\$GLOBALS['dblang_button'][\$GLOBALS['userlanguage']]?>";
	$Lang="\$dblang_button=array(\"ru\"=>\"Записать\",\"en\"=>\"Send\",);\n";
	//echo "<br>";echo "<br>";
	//var_dump($_POST['langtable'][$t]);
	//echo "<br>";echo "<br>";
	$ck=1;
	foreach($_POST['langtable'][$t] as $name=>$val){
		$multiquery.="b.".$name.",";
		//echo $name;
		$MultiCheck[$t-1].="\$".$name."=(strlen(\$_POST['".$name."'])>3)?mysql_real_escape_string(\$_POST['".$name."']):\$multierror.=\$GLOBALS['dblang_Er".ucfirst($name).$t."'][\$DLANG];\n";
		$uMultiCheck[$t-1].="\$".$name."=(strlen(\$_POST['".$name."'])>3)?mysql_real_escape_string(\$_POST['".$name."']):\$multierror.=\$GLOBALS['dblang_Er".ucfirst($name).$t."'][\$userlanguage];\n";
                if($name!="pub_date"){
                                $CleanDB[$t-1].="\$".$name."=mysql_real_escape_string(\$_POST['".$name."'][\$language]);\n";
                                $uCleanDB[$t-1].="\$".$name."=mysql_real_escape_string(\$_POST['".$name."'][\$language]);\n";
                } else {
                        $uCleanDB[$t-1].="\$pub_date=(strlen(\$_POST['pub_date'][\$language])>6)?strtotime(\$_POST['pub_date'][\$language]):time();";
                        $CleanDB[$t-1].="\$pub_date=(strlen(\$_POST['pub_date'][\$language])>6)?strtotime(\$_POST['pub_date'][\$language]):time();";
                }		
		//$Lang.="\$dblang_Er".ucfirst($name).$t."=array(\"ru\"=>\"$name минимальное количество символов 4<br>\",\"en\"=>\"$name mimimum length 4 symbols\",);\n";
		$MultiUpdate[$t-1].="$name='{\$".$name."}',";
		$MultiInsert[$t-1].="$name='{\$".$name."}',";
		if($name=="short" || $name=="content"){
			$multifields.="<label for=\"".$name."[<?= \$lang ?>]\"><?=\$GLOBALS['dblang_".$name.$t."'][\$DLANG]?><textarea id=\"".$name."[<?= \$lang ?>]\" class=\"ckeditor\" id=\"editor_ck".$t.$ck."[<?= \$lang ?>]\" name=\"".$name."[<?= \$lang ?>]\"><?=\$tbl_".$name."[\$lang]?></textarea></label>";
			$umultifields.="<label for=\"".$name."[<?=\$GLOBALS['userlanguage']?>]\"><?=\$GLOBALS['dblang_".$name.$t."'][\$GLOBALS['userlanguage']]?><textarea id=\"".$name."[<?=\$GLOBALS['userlanguage']?>]\" class=\"ckeditor\" id=\"editor_ck".$t.$ck."[<?=\$GLOBALS['userlanguage']?>]\" name=\"".$name."[<?=\$GLOBALS['userlanguage']?>]\"><?=\$TEMPLATE['".$name."'][\$GLOBALS['userlanguage']]?></textarea></label>";

			$Lang.="\$dblang_".$name.$t."=array(\"ru\"=>\"$name\",\"en\"=>\"$name\",);\n";
		} else {
			$ufieldvalue="<?=\$TEMPLATE['".$name."'][\$lang]?>";
			$fieldvalue="<?=\$tbl_".$name."[\$lang]?>";
			$selectors="";
			if(strpos($name,"date")!==false){
				$script="\$script=\"<script type='text/javascript' src='\".\$PATH.\"/js/Calendar.js'></script>\";
set_script(\$script);";
				$selectors=" onfocus=\"this.select();lcs(this)\" onclick=\"event.cancelBubble=true;this.select();lcs(this)\"";
				$ufieldvalue="<?=date(\"d-m-Y\",(\$TEMPLATE['".$name."'][\$lang]?\$TEMPLATE[".$name."][\$lang]:time()))?>";
				$fieldvalue="<?=date(\"d-m-Y\",(\$tbl_".$name."[\$lang])?\$tbl_".$name."[\$lang]:time())?>";//($tbl_pub_date[$lang])?$tbl_pub_date[$lang]:time()
			}
			$multifields.="<label for=\"".$name."[<?= \$lang ?>]\"><?=\$GLOBALS['dblang_".$name.$t."'][\$DLANG]?><input id=\"".$name."[<?= \$lang ?>]\" type=text name=\"".$name."[<?= \$lang ?>]\" value=\"$fieldvalue\"$selectors></label>";
			$umultifields.="<label for=\"".$name."[<?=\$GLOBALS['userlanguage']?>]\"><?=\$GLOBALS['dblang_".$name.$t."'][\$GLOBALS['userlanguage']]?><input id=\"".$name."[<?= \$lang ?>]\" type=text name=\"".$name."[<?=\$GLOBALS['userlanguage']?>]\" value=\"$ufieldvalue\"$selectors></label>";

			$Lang.="\$dblang_".$name.$t."=array(\"ru\"=>\"$name\",\"en\"=>\"$name\",);\n";
		}
		$ck++;
	}
	$MultiInsert[$t-1]=substr($MultiInsert[$t-1],0,-1);
	$qc=($source_table=='lang_text')?" and table_name='".$_POST["tablename"][$t]."' and language='\$language'":'';
	
	
	$MultiUpdate[$t-1]=substr($MultiUpdate[$t-1],0,-1)." WHERE rel_id=\$rel_id".$qc;// and table_name='".$_POST["tablename"][$t]."' and language='\$language'";
	$multiquery=substr($multiquery,0,-1);
	$SelectQueryLT[$t-1]="SELECT * FROM \".\$PREFIX.\"".$source_table." WHERE rel_id='{\$_GET['edit']}'$qp1";
	$SelectQueryL[$t-1]="SELECT a.*,$multiquery from \".\$PREFIX.\"".$_POST["tablename"][$t]." as a,\".\$PREFIX.\"".$source_table." as b WHERE a.id=b.rel_id".$qpL;
	$SelectQuery[$t-1]="SELECT a.*,$multiquery from \".\$PREFIX.\"".$_POST["tablename"][$t]." as a,\".\$PREFIX.\"".$source_table." as b WHERE a.id=b.rel_id".$qpnL;
//echo "<br>".$MultiInsert[$t-1]."<br>";
	//$multifields="";
}

		$tablefields=$_POST["tablefields"][$t];
		//var_dump($tablefields);
		$Update[$t-1]="UPDATE `\".\$PREFIX.\"".$_POST["tablename"][$t]."` SET ";
		$Insert[$t-1]="INSERT INTO `\".\$PREFIX.\"".$_POST["tablename"][$t]."` SET ";
		$Check[$t-1]="";
		for($f=0;$f<count($tablefields);$f++){
			if(strlen($tablefields[$f])>6){
				$tablefield=trim($tablefields[$f]);
				//echo "<br>!!!!!!!!!!$tablefield!!!!!!!!!!!<br>";
				$field=substr($tablefield,0,strpos($tablefield," "));
				//echo "<br>!!!!!!!!!!$field!!!!!!!!!!!<br>";
				$field=str_replace("`","",$field);
                                if(in_array($field,$parentsArray)){
                                    $parentFlag=true;
                                    $parentField=$field;
                                }
				$Fields[$t][]=$field;
				$iTable[$t-1].=$tablefield.",";
                                //$classFields[$t][]="'".$field."'=>'".$field."'";
				if($field!='id'){
					if(strpos($tablefield,'text') || strpos($tablefield,'blob')){
						$input="<textarea id=\"$field\" class=\"ckeditor\" id=\"editor_ck".$t.$f."m[<?= \$lang ?>]\" name=\"$field\"><?=\$tbl_".$field."?></textarea>";
						$uinput="<textarea id=\"$field\" class=\"ckeditor\" id=\"editor_ck".$t.$f."m[<?= \$lang ?>]\" name=\"$field\"><?=\$TEMPLATE['".$field."']?></textarea>";
					} else {
						$ufieldvalue="<?=\$TEMPLATE['".$field."']?>";
						$fieldvalue="<?=\$tbl_".$field."?>";
						$selectors="";
						if(strpos($field,"date")!==false){
							$script="\$script=\"<script type='text/javascript' src='\".\$PATH.\"/js/Calendar.js'></script>\";
set_script(\$script);";
							$selectors=" onfocus=\"this.select();lcs(this)\" onclick=\"event.cancelBubble=true;this.select();lcs(this)\"";
							$ufieldvalue="<?=date(\"d-m-Y\",(\$TEMPLATE['".$field."'][\$lang]?\$TEMPLATE[".$field."][\$lang]:time()))?>";
							$fieldvalue="<?=date(\"d-m-Y\",(\$tbl_".$field."[\$lang])?\$tbl_".$field."[\$lang]:time())?>";
						}
						$input="<input id=\"$field\" class=\"mainform {$_POST['alias']}\" type=text name=\"$field\" value=\"$fieldvalue\"$selectors>";
						$uinput="<input id=\"$field\" class=\"{$_POST['alias']}\" type=text name=\"$field\" value=\"$ufieldvalue\"$selectors>";
					}
                                        
                                        if(!in_array($field, $parentsArray)){
                                            if(strpos('image',$field)!==false || strpos('photo',$field)!==false){
                                                $imageupload=true;
                                                $Check[$t-1].="\$".$field."=(\$_POST['".$field."'])?json_encode(\$_POST['".$field."'], JSON_UNESCAPED_UNICODE):'';\n";
                                                $uCheck[$t-1].="\$".$field."=(\$_POST['".$field."'])?json_encode(\$_POST['".$field."'], JSON_UNESCAPED_UNICODE):'';\n"; 
                                            }else{
                                                $Check[$t-1].="\$".$field."=(strlen(\$_POST['".$field."'])>3)?mysql_real_escape_string(\$_POST['".$field."']):\$error.=\$GLOBALS['dblang_Er".ucfirst($field).$t."'][\$DLANG];\n";
                                                $uCheck[$t-1].="\$".$field."=(strlen(\$_POST['".$field."'])>3)?mysql_real_escape_string(\$_POST['".$field."']):\$error.=\$GLOBALS['dblang_Er".ucfirst($field).$t."'][\$userlanguage];\n";
                                            }
					}else{
                                            $Check[$t-1].="\$".$field."=mysql_real_escape_string(\$_POST['".$field."'])\r\n";
                                            $uCheck[$t-1].="\$".$field."=mysql_real_escape_string(\$_POST['".$field."'])\r\n";
                                        }
                                        if(!in_array($field,$parentsArray)){
                                            //echo $field." !in_array<br>";
                                            if(strpos('image',$field)!==false || strpos('photo',$field)!==false){
                                                
                                                $Form[$t-1].='<div class="imageupload"><input id="sortpicture" type="file" name="sortpic"><button type="button" data-path="'.$_POST['alias'].'" id="upload">Upload</button></div>'.
                                                        '<div id="process"><img src="/components/'.$_POST['alias'].'/tpl/img/preloader.gif" alt="Loading"></div>'.
                                                        '<div id="photo-content">'.
'<div id="div-default" class="img-item">'.
'    <span id="del-default" class="delete-image">x</span>'.
'    <img src="/img/default.jpg" width="120">'.
'</div></div>';

                                                
                                                $uForm[$t-1].="<label for=\"$field\"><?=\$GLOBALS['dblang_$field'][\$GLOBALS['userlanguage']]?> ".$uinput."</label><br>\r\n";
                                            }else{
                                                $Form[$t-1].="<label for=\"$field\"><?=\$GLOBALS['dblang_$field'][\$DLANG]?> ".$input."</label><br>\r\n";
                                                $uForm[$t-1].="<label for=\"$field\"><?=\$GLOBALS['dblang_$field'][\$GLOBALS['userlanguage']]?> ".$uinput."</label><br>\r\n";
                                            }
                                        }else{
                                            //echo $field." in_array<br>";
                                            $parentPart="
<?php
\$recurse=helpFactory::activate('queries/QueryRecursive');
\$array=\$recurse->makeQuery('{$_POST['alias']}','{$field}','id,name,alias','ORDER BY id');//id,name,alias указать нужные поля
\$select=helpFactory::activate('queries/Visitor/FormatRecursive','select');
\$select->name=\"{$parentField}\";
\$select->class=\"{$_POST['alias']}\";
if(intval(\$_GET['add'])>0){
    \$select->active_items=array(\$_GET['add']);
}
\$select->symbol=\"|--\";
\$out=\$select->format(\$recurse);
echo \$out;
?>
";
                                            $Form[$t-1].="<label for=\"{$field}\"><?=\$GLOBALS['dblang_pid'][\$DLANG]?>".$parentPart."</label><br>\r\n";
                                            $uForm[$t-1].="<label for=\"$field\"><?=\$GLOBALS['dblang_$field'][\$GLOBALS['userlanguage']]?> ".$parentPart."</label><br>\r\n";
                                        }
//end --------------------    
					$Lang.="\$dblang_$field=array(\"ru\"=>\"$field\",\"en\"=>\"$field\",);\n";
					
					$Lang.="\$dblang_Er".ucfirst($field).$t."=array(\"ru\"=>\"$field минимальное количество символов 4<br>\",\"en\"=>\"$field mimimum length 4 symbols\",);\n";
					$Update[$t-1].="$field='{\$".$field."}',";
					$Insert[$t-1].="$field='{\$".$field."}',";
				}
                                
			}
		}
		//die();
	$uCheck[$t-1].="if(\$_SESSION['secpic']!=strtolower(\$_POST['secpic'])){
		\$error.=\$GLOBALS['dblang_badcaptcha'][\$userlanguage].\"<br>\";
	}";
		
		$multifields.="
<?php
}	
?>";
		$umultifields.="<label for='contact-secpic'><?=\$GLOBALS['dblang_captcha'][\$GLOBALS['userlanguage']] ?>: 
			<input type='text' id='contact-secpic' class='contact-secpic' name='secpic' tabindex='1010' /> <img src=\"/secpic.php\" alt=\"защитный код\"></label>
			<br/>";
		$Insert[$t-1]=substr($Insert[$t-1],0,-1);
		$Update[$t-1]=substr($Update[$t-1],0,-1)." WHERE id=\$id";
		$iTable[$t-1]=substr($iTable[$t-1],0,-1).")\"";
		$Form[$t-1]="<form method=\"post\">".$Form[$t-1]."\r\n<?php
if(\$MY_URL==1){
?>
".$htmlformfield."
<?php
}
?>
".$multifields."<input type=submit class=button name=\"submit\" value=\"$button\">";
		$uForm[$t-1]="<form method=\"post\">".$uForm[$t-1].$umultifields."<input type=submit  class=button name=\"submit\" value=\"$ubutton\">";

		//echo $iTable[$t-1]."<br>";
		//echo $Form[$t-1]."<br><br>user<br>";
		//echo $uForm[$t-1];
		//die();
		//echo "<br>".$SelectQuery[$t-1]."<br>";
		//echo "<br>".$Update[$t-1]."<br>";
		//echo "<br>".$MultiUpdate[$t-1]."<br>";
		//echo "<br>".$Insert[$t-1]."<br>";
		//echo "<br>".$MultiInsert[$t-1]."<br>";
	}
}

	mkdir($HOSTPATH."/components/".$_POST['alias']);
	mkdir($HOSTPATH."/components/".$_POST['alias']."/lang");
	mkdir($HOSTPATH."/components/".$_POST['alias']."/tpl");
	mkdir($HOSTPATH."/components/".$_POST['alias']."/tpl/css");
	mkdir($HOSTPATH."/components/".$_POST['alias']."/tpl/js");
	$menu="";$aQuery="";

	include "adminpages.php";
	include "userpages.php";
	include "sitepages.php";
	include "commonfiles.php";
	done("Компонент успешно создан!");
}
?>
<br><br>
<form method=post>

<label for=alias>Алиас</label><input type=text id=alias name=alias required><br>

<label for=title>Название</label><input type=text id=title name=title required><br>

<label for=adminnum>Страниц в админке</label><input type=text id=adminnum name=adminnum><br>
<label for=usernum>Страниц у пользователя</label><input type=text id=usernum name=usernum><br>
<label for=sitenum>Страниц на сайте</label><input type=text id=sitenum name=sitenum><br>
<div class="clear"></div>
    
<fieldset>
   <legend>Экспорт</legend>
   <label for=csv>Csv<input type="checkbox" id=csv name="csv" value="1"></label>
   <label for=csv>Pdf<input type="checkbox" id=pdf name="pdf" value="1"></label>
   <label for=csv>Xls<input type="checkbox" id=xls name="xls" value="1"></label>
   <label for=csv>Xml<input type="checkbox" id=xml name="xml" value="1"></label>
   <label for=csv>Json<input type="checkbox" id=json name="json" value="1"></label>
</fieldset><br><div class="clear"></div>
<label for=table>Таблица(макс 9)</label><input type=text id=table name=table><br>



<div id="sitemenus" class=cmenu style="display:none">

</div>
<div id="adminmenus" class=cmenu style="display:none">

</div>
<div id="usermenus" class=cmenu style="display:none">

</div>
<div class=clear></div>
<div id="tabledata" class=cmenu style="display:none">

</div>

            <br><br>
<input type=submit class="button" name=submit value="Создать">
</form>
