<?php
function error($message){
    global $HOSTPATH;
    global $TPL;
    render_to_template($HOSTPATH."/templates/".$TPL."/common/error.php", array("message"=>$message));
}
function info($message){
    global $HOSTPATH;
    global $TPL;
    render_to_template($HOSTPATH."/templates/".$TPL."/common/info.php", array("message"=>$message)); 
}
function done($message){
    global $HOSTPATH;
    global $TPL;
    render_to_template($HOSTPATH."/templates/".$TPL."/common/done.php", array("message"=>$message));
}
function dump_html($obj,$name=''){
    $name=($name)?$name:'Дамп';
    $dump=var_export($obj,true);
    $dump=str_replace("\n","<br>",$dump);
    $dump=str_replace("\r","",$dump);
    $dump=str_replace(" ","&nbsp;&nbsp;&nbsp;&nbsp;",$dump);
    echo "<hr>==".$name."==<br>".$dump."<hr><br>";
}
function dump_panel($obj,$name=''){
    global $dump;
    $args=func_get_args();
    $a=var_export(debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT ,1),true);
    foreach($args as $obj){
        $dump[$a][]=var_export($obj,true);
    }
    $out=json_encode($dump);
    echo "<script>var dump=`".$out."`;</script>";
}
function dump_console($obj,$name=''){
    if(DEBUG){
        $dump=var_export($obj,true);
        echo "<script>console.log('{$name} =',`".$dump."`)</script>";
    }
}
function dump_comment($obj,$name=''){
    if(HTMLDEBUG){
        echo "<!--\r\n+++{$name}+++\r\n";
        var_dump($obj);
        echo "\r\n-->";
    }
}
function check_uniq_field($table,$field,$value){
    global $PREFIX;
    $query="SELECT id from ".$PREFIX."$table where `{$field}`='{$value}'";
    $result=mysql_query($query);
    if(mysql_num_rows($result)>0){
        return false;
    }
    return true;
}
/*
 * Вывод настроек из таблицы settings
 */
function get_settings($alias, array $settings=null){
    global $PREFIX;
    //dump_console($alias,'$alias');
    
    $query="SELECT * FROM ".$PREFIX."settings where alias='{$alias}' LIMIT 1";
    $result = mysql_query($query);
    $row = mysql_fetch_array($result);
    if(is_array($settings)){
        if(count($settings)==1){
            //dump_console($row[$settings[0]],'$row'); 
            echo $row[$settings[0]];
        }else{
           foreach($settings as $num=>$val){
                //$return[$val] = $row[$val];
            }
            //return $return;
        }
    }
    dump_console($alias,'$alias');
    echo $row['value1'];
    
}
function userlang()
{
    if($_COOKIE['language']??false) {
        $lang = $_COOKIE['language'];
    } else {
        $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);
    }
    if (!in_array($lang, array_keys($GLOBALS['LDISPLAY']))) {
        $lang = $GLOBALS[DLANG];
    }
    return $lang;
}
function set_title($title,$main=1)
{
    if($main==1) {
        if(!$title){
           $title= $GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']];
        }
        $GLOBALS['PAGE_TITLE'] = $title . $GLOBALS['PAGE_TITLE_DEL'] . ($GLOBALS['PAGE_TITLE'][$GLOBALS['userlanguage']]??'');
    } else {
        $GLOBALS['PAGE_TITLE'] = $title;
    }
    $GLOBALS['PAGE'] = $title;
}

function set_meta($keywords, $description)
{
    $GLOBALS['SITE_TITLE']=(is_array($GLOBALS['SITE_TITLE']))?$GLOBALS['SITE_TITLE'][$GLOBALS['userlanguage']]:$GLOBALS['SITE_TITLE'];
    $GLOBALS['META_KEYWORDS']=($keywords)?$keywords:$GLOBALS['META_KEYWORDS'][$GLOBALS['userlanguage']];
    $GLOBALS['META_DESCRIPTION']=($description)?$description:$GLOBALS['META_DESCRIPTION'][$GLOBALS['userlanguage']];
    $GLOBALS['META_KEYWORDS']=(is_array($GLOBALS['META_KEYWORDS']))?$GLOBALS['META_KEYWORDS'][$GLOBALS['userlanguage']]:$GLOBALS['META_KEYWORDS'];
    $GLOBALS['META_DESCRIPTION']=(is_array($GLOBALS['META_DESCRIPTION']))?$GLOBALS['META_DESCRIPTION'][$GLOBALS['userlanguage']]:$GLOBALS['META_DESCRIPTION'];
}

function set_script($script)
{
    global $PATH;
    //$GLOBALS[SCRIPT] = $script;
    if(func_num_args()==2) {
        $GLOBALS['SCRIPT'] =(func_get_arg(1))?"<script type=\"text/javascript\" src=\"".$PATH."/components/".func_get_arg(0)."\"></script>": func_get_arg(0);
    } else {
        $GLOBALS['SCRIPT'] =func_get_arg(0);
    }
    if($_SESSION['development']){
        $GLOBALS['SCRIPT'].="<script type=\"text/javascript\" src=\"/components/installator/tpl/js/panel.js\"></script>";
    }
}
function set_css()
{
    //$css,$f
    global $PATH;
    if(func_num_args()==2) {
        $GLOBALS['CSS'] .=(func_get_arg(1))?"<link rel=\"stylesheet\" href=\"".$PATH."/components/".func_get_arg(0)."\">": func_get_arg(0);
    } else {
        $GLOBALS['CSS'] .=func_get_arg(0);
    }
    if($_SESSION['development']){
        $GLOBALS['CSS'].="\n<link rel=\"stylesheet\" type=\"text/css\" href=\"/components/installator/tpl/css/panel.css\">\n";
    }
}
//get alt for images
function get_alt($path)
{
    global $PREFIX;
    $alt = "";
    $res = mysql_query("SELECT alt FROM ".$PREFIX."imagealt WHERE path = '$path'");
    if ($row = mysql_fetch_row($res)) {
        $alt = $row[0];
    }
    return $alt;
}
/*
 * Выводит текст в заданную позицию по url; вызов в шаблоне
 */
function get_moduletext($position){
    global $PREFIX;
    $url=($GLOBALS['URL']===NULL)?"index":$GLOBALS['URL'];
    //dump_panel($segments[0]);
    $query="SELECT text FROM ".$PREFIX."module_text WHERE path='{$url}' and position='{$position}' ORDER BY id DESC LIMIT 1";
    $result=mysql_query($query);
    $row=mysql_fetch_assoc($result);
    echo $row['text'];
}
/*
 * get_text Устарела
 */
function get_text($path)
{
    global $PREFIX;
    global $userlanguage;
    $text = "";
    //$res = mysql_query("SELECT `text`,`keywords`,`meta` FROM ".$PREFIX."texts WHERE path = '$path'");
    $res = mysql_query("SELECT a.content,a.keywords,a.description FROM ".$PREFIX."lang_text as a, ".$PREFIX."texts as b WHERE b.path = '$path' and b.id=a.rel_id and a.table_name='texts' and a.language='$userlanguage'");
    //echo "SELECT a.content,a.keywords,a.description FROM ".$PREFIX."lang_text as a, ".$PREFIX."texts as b WHERE b.path = '$path' and b.id=a.rel_id and a.table_name='texts' and a.language='$userlanguage'";
    
    if ($res && mysql_num_rows($res)) {
        $row = mysql_fetch_row($res);
        return $row;
    }
    return $text;
}

function decorate($text)
{
    return "<div style='padding:20px; padding-bottom: 0px;'>$text</div>";
}

//load modules to position
function load_module($position, $type = 0)
{
    global $PREFIX;
    global $recursive_menu;
    $whereclause = " AND admin = 0";
    if ($type==1) { $whereclause = " AND admin = 1";
    }

    $res = mysql_query("SELECT `module` FROM `".$PREFIX."modules` WHERE `position`='$position' $whereclause ORDER BY `ordering`");
    while ($row = mysql_fetch_row($res)) {
        if (file_exists("modules/{$row[0]}.php")) {
            include "modules/{$row[0]}.php";
        } else { echo "Модуль $row[0] не найден.";
        }
    }
}

//template functions
function render_to_template($file, $array)
{
    global $OUTPUT_FORMAT;
    global $HOSTPATH;
    if($OUTPUT_FORMAT=='url' || $OUTPUT_FORMAT==''){
        $TEMPLATE = $array;
        include $file;
    }elseif($OUTPUT_FORMAT=='json'){
        $out=json_encode($array,JSON_UNESCAPED_UNICODE);
        echo $out;
    }elseif($OUTPUT_FORMAT=='xml'){
        require_once $HOSTPATH.'/inc/xml.php';
        $xml=ArrayToXML::toXml($array, $rootNodeName = 'data', $xml=null);
        echo $xml;
    }
}
function get_segments()
{
    global $segments,$csection,$catalog,$last_section;
    if($_SERVER['QUERY_STRING']) {
        //echo $_SERVER['QUERY_STRING'];
        $query=explode("&", $_SERVER['QUERY_STRING']);
        $query=str_replace("view=", "", $query[0]);
        //echo $query;
        $segments=explode("/", $query);
        //var_dump($segments);
        if(strpos($query, 'catalog')!==false) {
            $catalog=str_replace('catalog/', '', $query);
        } else {
            $catalog=false;
        }
        //var_dump($segments);
        $_GET['view']=$segments[0];
        $_GET['id']=$segments[1];
        $csection=$segments[1];
        $last_section=$segments[count($segments)-1];//array_pop($segments);
        //var_dump($segments);
    }
}
function generate_password($number)
{
    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0',
                 '(',')','[',']','!','?',
                 '&','^','%','@','*','$',
                 '<','>','/','|','+','-',
                 '{','}','`','~');
    // Генерируем пароль
    $pass = "";
    for($i = 0; $i < $number; $i++){
        // Вычисляем случайный индекс массива
        $index = rand(0, count($arr) - 1);
        $pass .= $arr[$index];
    }
    return $pass;
}
function translitIt($str)
{
    $tr = array(
        "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
        "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
        "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
        "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
        "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
        "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
        "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
        " "=> "_", "."=> "", "/"=> "_", "!"=> "", "?"=> "", ":"=> "", '"'=> "", "'"=> "", '"'=> "","»"=>"","«"=>"","`"=>"",";"=>"","%"=>"","$"=>"","#"=>"","@"=>"","+"=>"","&"=>"","\\"=>"","*"=>"","^"=>"","~"=>"","="=>""
    );
    return strtr($str, $tr);
}
function multi_attach_mail($to, $files, $sendermail,$filename,$csvsize,$subject,$message)
{
    global $SITE_TITLE;
    global $userlanguage;
    $from = $sendermail;
    $subject="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $subject))."?=";
    $message = iconv("UTF-8", "koi8-r", $message);//date("Y.m.d H:i:s")."\n".count($files)." attachments";
    $headers = "From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE[$userlanguage]))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">";//"From: $from";
 
    // boundary
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
    // headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
    // multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type:  text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\n\n". $message . "\n\n";
    // preparing attachments
    for($i=0;$i<count($files);$i++){
        $message .= "--{$mime_boundary}\n";
        $data =  $files[$i];
        if($csvsize==0) {
            $csvsize=filesize($files[$i]);
        }
        $data = chunk_split(base64_encode($data));
        $message .= "Content-Type: application/octet-stream; name=\"".basename($filename)."\"\n" .
        "Content-Description: ".basename($filename)."\n" .
        "Content-Disposition: attachment;\n" . " filename=\"".basename($filename)."\"; size=".$csvsize.";\n" .
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
        $csvsize=0;
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $sendermail;
    $ok = @mail($to, $subject, $message, $headers, $returnpath);
    
    if($ok) { return $i; 
    } else { return 0; 
    }
}
function mail_html($umail,$lettitle,$mess,$from)
{
    //$umail -кому $from - с какого ящика
    $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $lettitle))."?=";
    $mess=iconv("UTF-8", "koi8-r", $mess);
    $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
    mail($umail, $ltitle, $mess, $headers);
}
/*
 * Выбор массива из базы и попытка отсортировать по полям если есть position ordering
 * 
 */
function select_array($table,$value1,$value2,$where=''){
	global $PREFIX;
	$where=($where)?" ".$where:'';
	$order_by="";
	
	$query="SHOW COLUMNS FROM `".$PREFIX."{$table}` LIKE 'position'";
	//echo $query;
	$res = mysql_query($query);
	$exists = (mysql_num_rows($res))?TRUE:FALSE;
	if($exists){
		$order_by=" ORDER BY position";
	}
	$query="SHOW COLUMNS FROM `".$PREFIX."{$table}` LIKE 'ordering'";
	//echo $query;
	$res = mysql_query($query);
	$exists = (mysql_num_rows($res))?TRUE:FALSE;
	if($exists){
		$order_by=" ORDER BY ordering";
	}
	
	$query="SELECT $value1,$value2 FROM ".$PREFIX."$table{$where}{$order_by}";
	//echo $query;
	$res = mysql_query($query);
	while($row=mysql_fetch_array($res)){
		$result[$row[0]]=$row[1];
	}
	return $result;
}
/*рекурсивный обход таблицы с родительскими полями
 * Вызов $category_arr = getCategory(); формирование массива из таблицы, поля id, name, parent
 * $listfields список полей
 * $resultmenu='';
 * outTree(0, 0);
 * echo $resultmenu;
 */
function prepareRecursive($table,$parent_field,$listfields,$conditions='') {
    global $PREFIX;
    $query = mysql_query("SELECT {$parent_field},{$listfields} FROM ".$PREFIX."{$table} {$conditions}");   //  "SELECT * FROM `category`"
    $result = array();
    while ($row = mysql_fetch_array($query)) {
        $result[$row[$parent_field]][] = $row;
    }
    return $result;
}
/*рекурсивный обход таблицы с родительскими полями
 * Вызов $category_arr = getCategory();
 * $resultmenu='';
 * outTree(0, 0);
 * $performer_cats id активные ссылки(поля) array
 * echo $resultmenu;
 */
function recursiveTree($parent_id, $level,$items,$recursive_array,$replaces,$treeHTML,$performer_cats=array()) {
    //global $recursive_array; //Делаем переменную $category_arr видимой в функции
    global $recursive_menu;
    global $top;

    if (isset($recursive_array[$parent_id])) { //Если категория с таким parent_id существует
        $count= count($recursive_array[$parent_id]);
        foreach ($recursive_array[$parent_id] as $name=>$value) { //Обходим
            /**
             * Выводим категорию 
             *  $level * 25 - отступ, $level - хранит текущий уровень вложености (0,1,2..)
             */
            $active=(in_array($value['id'], $performer_cats))?" checked":"";
            if(!$i){//ok
                if(!$top){
                    //echo "-- ul begin mainblock;<br>\r\n";
                    $main=$items;
                    $top=1;
                    $string=$treeHTML['begin'];//$treeHTML['top'];
                    foreach($replaces as $replace){
                        if($replace=='class'){
                            $string=str_replace("{class}","level{$level}",$string);
                        }else{
                            $string=str_replace("{".$replace."}",$value[$replace],$string);
                        }
                    }
                    $string=str_replace("{class}","level{$level}",$string);
                    $recursive_menu.=$string;

                }else{
                    //echo "ul begin blockchild<br>\r\n";
                    $string=$treeHTML['blockbeginchild'];//$treeHTML['begin'];
                    foreach($replaces as $replace){
                         if($replace=='class'){
                            $string=str_replace("{class}","level{$level}",$string);
                        }else{
                            $string=str_replace("{".$replace."}",$value[$replace],$string);
                        }
                    }
                    $string=str_replace("{class}","level{$level}",$string);
                    $recursive_menu.=$string;
                    
                }
            }
            
            //echo "<div style='margin-left:" . ($level * 25) . "px;'><input type=checkbox name='category[]' value=\"{$value[id]}\"{$active}>" . $value["name"] . "</div>";
            //echo "$level\r\n";
            if($level==0){//родит
                //echo "li beginparent\r\n";
                //echo " element parent\r\n";
                $string=$treeHTML['beginparent'].$treeHTML['elementparent'];//$treeHTML['parent'];
                foreach($replaces as $replace){

                         if($replace=='class'){
                            $string=str_replace("{class}","level{$level}",$string);
                        }else{
                            $string=str_replace("{".$replace."}",$value[$replace],$string);
                        }
                    }
                    $string=str_replace("{class}","level{$level}",$string);
                    $recursive_menu.=$string;
            }else{//child
                //echo "li beginchild\r\n "
                //echo  "element child\r\n";
                $string=$treeHTML['beginchild'].$treeHTML['elementchild'];//$treeHTML['child'];
                foreach($replaces as $replace){
                         if($replace=='class'){
                            $string=str_replace("{class}","level{$level}",$string);
                        }else{
                            $string=str_replace("{".$replace."}",$value[$replace],$string);
                        }
                    }
                    $string=str_replace("{class}","level{$level}",$string);
                    $recursive_menu.=$string;
            }
            //$recursive_menu.= "<div style='margin-left:" . ($level * 25) . "px;'><input type=checkbox name='category[]' value=\"{$value[id]}\"{$active}>" . $value["name"] . "</div>";
            $level = $level + 1; //Увеличиваем уровень вложености
            //Рекурсивно вызываем эту же функцию, но с новым $parent_id и $level

            recursiveTree($value["id"], $level,$items,$recursive_array,$replaces,$treeHTML,$performer_cats);
            $level = $level - 1; //Уменьшаем уровень вложености
            $i++;

            if($level==0){
                //echo "/li parent <br>\r\n";
                $recursive_menu.=$treeHTML['endparent'];
            }else{
                //echo "/li  child <br>\r\n";
                $recursive_menu.=$treeHTML['endchild'];
            }
            
            if($count==$i){//ok
                if($main && $main==$i){
                    $recursive_menu.=$treeHTML['end'];//$treeHTML['totalend']."\r\n";//</table>
                    //echo "mainblock end /ul<br>";
                }else{
                    $recursive_menu.=$treeHTML['blockendchild'];//$treeHTML['end']."\r\n";//$treeHTML['end'];
                    //echo "/ul child\r\n";
                }
            }
        }
    }
}
/**
 * Автоисправление раскладки клавиатуры
 * @param type $text
 * @param type $arrow
 * @return type $text
 */
function switcher($text,$arrow=0){
  $str[0] = array('й' => 'q', 'ц' => 'w', 'у' => 'e', 'к' => 'r', 'е' => 't', 'н' => 'y', 'г' => 'u', 'ш' => 'i', 'щ' => 'o', 'з' => 'p', 'х' => '[', 'ъ' => ']', 'ф' => 'a', 'ы' => 's', 'в' => 'd', 'а' => 'f', 'п' => 'g', 'р' => 'h', 'о' => 'j', 'л' => 'k', 'д' => 'l', 'ж' => ';', 'э' => '\'', 'я' => 'z', 'ч' => 'x', 'с' => 'c', 'м' => 'v', 'и' => 'b', 'т' => 'n', 'ь' => 'm', 'б' => ',', 'ю' => '.','Й' => 'Q', 'Ц' => 'W', 'У' => 'E', 'К' => 'R', 'Е' => 'T', 'Н' => 'Y', 'Г' => 'U', 'Ш' => 'I', 'Щ' => 'O', 'З' => 'P', 'Х' => '[', 'Ъ' => ']', 'Ф' => 'A', 'Ы' => 'S', 'В' => 'D', 'А' => 'F', 'П' => 'G', 'Р' => 'H', 'О' => 'J', 'Л' => 'K', 'Д' => 'L', 'Ж' => ';', 'Э' => '\'', '?' => 'Z', 'ч' => 'X', 'С' => 'C', 'М' => 'V', 'И' => 'B', 'Т' => 'N', 'Ь' => 'M', 'Б' => ',', 'Ю' => '.',);
  $str[1] = array (  'q' => 'й', 'w' => 'ц', 'e' => 'у', 'r' => 'к', 't' => 'е', 'y' => 'н', 'u' => 'г', 'i' => 'ш', 'o' => 'щ', 'p' => 'з', '[' => 'х', ']' => 'ъ', 'a' => 'ф', 's' => 'ы', 'd' => 'в', 'f' => 'а', 'g' => 'п', 'h' => 'р', 'j' => 'о', 'k' => 'л', 'l' => 'д', ';' => 'ж', '\'' => 'э', 'z' => 'я', 'x' => 'ч', 'c' => 'с', 'v' => 'м', 'b' => 'и', 'n' => 'т', 'm' => 'ь', ',' => 'б', '.' => 'ю','Q' => 'Й', 'W' => 'Ц', 'E' => 'У', 'R' => 'К', 'T' => 'Е', 'Y' => 'Н', 'U' => 'Г', 'I' => 'Ш', 'O' => 'Щ', 'P' => 'З', '[' => 'Х', ']' => 'Ъ', 'A' => 'Ф', 'S' => 'Ы', 'D' => 'В', 'F' => 'А', 'G' => 'П', 'H' => 'Р', 'J' => 'О', 'K' => 'Л', 'L' => 'Д', ';' => 'Ж', '\'' => 'Э', 'Z' => '?', 'X' => 'ч', 'C' => 'С', 'V' => 'М', 'B' => 'И', 'N' => 'Т', 'M' => 'Ь', ',' => 'Б', '.' => 'Ю', );
  return strtr($text,isset( $str[$arrow] )? $str[$arrow] :array_merge($str[0],$str[1]));
}

function insertChat($listUsers){
  $_SESSION['listUsers'] = $listUsers;
  include('modules/chat/index.php');
}

function insertUpload($listType,$way,$suff){
  $specCase="$listType#$way#$suff";
  include('modules/upl/uploadForm.php');
}

/*
 * функции шифрования, дешифрования по ключу
 */
function encrypt($decrypted, $key) {
    $methods = openssl_get_cipher_methods();
    $encrypted = openssl_encrypt($decrypted, $methods[3], $key);
    return $encrypted;
}
 
function decrypt($encrypted, $key) {
    $methods = openssl_get_cipher_methods();
    $decrypted = openssl_decrypt($encrypted, $methods[3], $key);
    return $decrypted;
}


/*
 * Проверка прав админов
 */
function check_role($component='',$action=''){
    global $PREFIX;
    global $ADMIN_LOGIN;
    if($_SESSION['admin_name'] == $ADMIN_LOGIN){
        return true;
    }
    
    $query="SELECT roles FROM ".$PREFIX."roles WHERE id={$_SESSION['role']}";
    $result=mysql_query($query);
    $row = mysql_fetch_array($result);
    $components= json_decode($row['roles']);
    if($component==''){
        $from=debug_backtrace();
        $parts=explode('/',$from[0]['file']);
        if(count($parts)==1){
            $parts=explode('\\',$from[0]['file']);
        }
        $action=array_pop($parts);
        $component=array_pop($parts);
        //echo strpos($action ,"admin.action");
        if(strpos($action ,"admin.action")!==false){
            $action = str_replace("admin.action", "", $action);
            $action = str_replace(".php", "", $action);
        }else{
            $action="Default";
        }
    }
    if($_GET['del']){
        $action='Delete';
    }
    if($components->$component){
       if($components->$component->$action==1){
           return true;
       }else{
           return false;
       }

    }
   
    //var_dump($components);
}
/*
 * Создание меню на страницах сайта и админки
 */
function renderActions($id,$arr,$module,$print=true)
{
    if(!$print){
        global $ssubmenu;
    }
    foreach ($arr as $k => $v) {
        if ($k == $id) {
            if($print && check_role($module,$k)){
                echo "<b><a href='{$GLOBALS['PATH']}/admin/?component={$module}&action=$k'>$v</a></b> &nbsp; &nbsp;";
            }elseif(check_role($module,$k)){
                $ssubmenu.="<b><a href='{$GLOBALS['PATH']}/{$module}/$k'>$v</a></b> &nbsp; &nbsp;";
            }
        } else {
            if($print && check_role($module,$k)){
                echo "<a href='{$GLOBALS['PATH']}/admin/?component={$module}&action=$k'>$v</a> &nbsp; &nbsp;";
            }elseif(check_role($module,$k)){
                $ssubmenu.="<a href='{$GLOBALS['PATH']}/{$module}/$k'>$v</a> &nbsp; &nbsp;";
            }
        }
    }
}
function format_message($letter_tpl,$replacement){
    require_once $_SERVER['DOCUMENT_ROOT'].'/inc/mail.system.templates.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/inc/mail.templates.php';
    //$replacement[0]=$GLOBALS['SITE_TITLE']['ru'];
    //$replacement[1]=$GLOBALS['PATH'];
    $default_array=array('{:sitetitle:}'=>$GLOBALS['SITE_TITLE']['ru'], '{:url:}'=>$GLOBALS['PATH']);
    $replace=array_merge($default_array,$replacement);
    //$replacearray=array('{:sitetitle:}','{:url:}','{:password:}','{:username:}','{:userid:}','{:usermail:}','{:userpercent:}','{:usermoney:}','{:useramount:}','{:userdata:}','{:actions:}','{:subscribe:}','{:unsubscribe:}');
    
    
    
    if($mailtemplates[$letter_tpl]){
        $title=$mailtemplates[$letter_tpl][0];
        $message=$mailtemplates[$letter_tpl][1];
    }elseif($mailsystemtemplates[$letter_tpl]){
        $title=$mailsystemtemplates[$letter_tpl][0];
        $message=$mailsystemtemplates[$letter_tpl][1];
    }else{
        return false;
    }
    $out['title']=strtr($title, $replace);
    $out['message']=strtr($message, $replace);
    //$out['title']=str_replace($replacearray,$replacement,$title);
    //$out['message']=str_replace($replacearray,$replacement,$message);
    return $out;
}
/*
 * ЧПУ
 */
function chpu_check($url,$cmsurl=''){
    global $PREFIX;
    if($cmsurl!=''){
        $query="SELECT * FROM ".$PREFIX."url WHERE url='{$url}' and cmsurl!='{$cmsurl}'";
        $result=mysql_query($query);
        if(mysql_num_rows($result)>0){
            $info='exists';
        }else{
            $query="SELECT * FROM ".$PREFIX."url WHERE cmsurl='{$cmsurl}'";
            $result=mysql_query($query);
            if(mysql_num_rows($result)>0){
                $info='update';
            }else{
                $info='add';
            }
            
        }
    }else{
        $query="SELECT * FROM ".$PREFIX."url WHERE url='{$url}'";
        $result=mysql_query($query);
        if(mysql_num_rows($result)>0){
            $info='exists';
        }else{
            $info='add';
        }
    }
    return $info;
}
/*
 * выбор ЧПУ по id
 */
function get_myurl($module,$id){
    global $PREFIX;
    global $MY_URL;
    if($MY_URL==1){
       $query="SELECT * FROM ".$PREFIX."url WHERE cmsurl='".$module."/".$id."' LIMIT 1";
       $result=mysql_query($query);
       if(mysql_num_rows($result>0)){
           $row = mysql_fetch_array($result);
           $url=$row['url'];
       }else{
           $url=$module."/".$id;
       }
       
    }else{
        $url=$module."/".$id;
    }
    return $url;
}

/*
 * Вывод фомы заданной в базе
 */
function displayForm($id,$display=true){
    global $PREFIX;
    $query="SELECT * FROM ".$PREFIX."forms WHERE id=".$id;
    $result=mysql_query($query);
    $row=mysql_fetch_array($result);
    $attributes=($row['attributes'])?" ".$row['attributes']:"";
    $method=($row['method'])?" method=\"{$row['method']}\"":" method=\"post\"";
    $action=($row['action'])?" action=\"{$row['action']}\"":"";
    $enctype=($row['enctype'])?" enctype=\"{$row['enctype']}\"":"";
    $html=$row['html'];
    $out="<form class=\"\" {$attributes}{$method}{$action}{$enctype}>\r\n";
    $query="SELECT * FROM ".$PREFIX."form_inputs WHERE form_id=".$id." ORDER BY POSITION";
    $result=mysql_query($query);
    $string=array();
    $i=0;
    while($row=mysql_fetch_array($result)){
        $begin=substr($row['type'],0,4);
        if($begin=='inpu'){
            if($row['make_function']!="" && !strpos("|",$row['make_function'])){
                $function=$row['make_function'];
                $input=$function($row);
            }else{
                $input=explode(".",$row['type']);
                $placeholder=($row['placeholder'])?" placeholder=\"{$row['placeholder']}\"":"";
                $value=($row['value'])?" value=\"{$row['value']}\"":" value=\"\"";
                $required=($row['required'])?" required":"";
                $list=($input[1]=='datalist')?" list=\"l{$row['name']}\"":"";
                $input="<{$input[0]} id=\"{$row['name']}\" type=\"{$input[1]}\" {$row['attributes']} name=\"{$row['name']}\"{$value}{$required}>\r\n";
                
                if($input[1]=='datalist' && strpos("|",$row['make_function'])){
                    $input.="<datalist id=\"l{$row['name']}\">\r\n";
                    $parts=explode("|",$row['make_function']);
                    foreach($parts as $part){
                       $input.="<option value=\"{$part}\">{$part}</option>\r\n"; 
                    }
                    $input.="</datalist>\r\n";
                }
                
            }
            $string[$i]=$html;
            foreach($row as $n=>$val){
                $string[$i]=str_replace('{'.$n.'}',$val,$string[$i]);
            }
            //$html=str_replace('{name}',$row['name'],$html);
            //$html=str_replace('{text}',$row['text'],$html);
            $string[$i]=str_replace('{input}',$input,$string[$i]);
            $out.=$string[$i]."\r\n";
            
        }elseif($begin=='text'){
            $placeholder=($row['placeholder'])?" placeholder=\"{$row['placeholder']}\"":"";
            $required=($row['required'])?" required":"";
            $input="<{$row['type']} id=\"{$row['name']}\" {$row['attributes']} name=\"{$row['name']}\"{$required}>{$row['value']}</{$row['type']}>\r\n";
            $string[$i]=$html;
            foreach($row as $n=>$val){
                $string[$i]=str_replace('{'.$n.'}',$val,$string[$i]);
            }
            //$html=str_replace('{name}',$row['name'],$html);
            //$html=str_replace('{text}',$row['text'],$html);
            $string[$i]=str_replace('{input}',$input,$string[$i]);
            $out.=$string[$i];
        }elseif($begin=='sele'){
            $required=($row['required'])?" required":"";
            $input="<{$row['type']} id=\"{$row['name']}\" {$row['attributes']} name=\"{$row['name']}\"{$required}>\r\n";
            if(!$required){
                $input.="<option value=\"0\">Выбрать</option>";
            }
            if($row['make_function']!="" && !strpos($row['make_function'],"|")){

                $function=$row['make_function'];
                $input=$function($row);
            }elseif(strpos($row['make_function'],"|")){

                $opt_parts=explode("|",$row['make_function']);
                foreach($opt_parts as $opt_part){
                    $opt=explode("=",$opt_part);
                    $input.="<option value=\"{$opt[0]}\">{$opt[1]}</option>";
                }
            }
            $input.="</{$row['type']}>";
            $string[$i]=$html;
            foreach($row as $n=>$val){
                $string[$i]=str_replace('{'.$n.'}',$val,$string[$i]);
            }
            $string[$i]=str_replace('{input}',$input,$string[$i]);
            $out.=$string[$i];
        }elseif($begin=='butt'){
            $placeholder=($row['placeholder'])?" placeholder=\"{$row['placeholder']}\"":"";
            $input="<{$row['type']} id=\"{$row['name']}\" {$row['attributes']} name=\"{$row['name']}\">{$row['value']}</{$row['type']}>\r\n";
            $string[$i]=$html;
            foreach($row as $n=>$val){
                $string[$i]=str_replace('{'.$n.'}',$val,$string[$i]);
            }
            $string[$i]=str_replace('{input}',$input,$string[$i]);
            $out.=$string[$i]; 
        }
        $i++;
    }
    $out.="</form>\r\n";
    if($display){
        echo $out;
        return true;
    }else{
        return $out;
    }
}
    
function submitForm($id=0){
    global $PREFIX;
    $parts=array();
    $id=intval($id);
    echo "submitForm=====================";
    if($id!=0){
        $query="SELECT `tablename` FROM ".$PREFIX."forms WHERE id={$id}";
        $result=mysql_query($query);
        $row= mysql_fetch_array($result);
    }else{
        
    }
    $query1="SELECT * FROM ".$PREFIX."form_inputs WHERE form_id={$id}";
    $result1=mysql_query($query1);
    while($row1=mysql_fetch_array($result1)){
        if($row1['check_function']){
            $value=$row1['check_function']($_POST[$row1['name']]);
        }else{
            $value=mysql_real_escape_string($_POST[$row1['name']]);
        }
        if($row1['type']!='input.submit'){
            $parts[]=$row1['name']."='".$value."'";
        }
    }
    $inserts=implode(",",$parts);
    $query="INSERT INTO ".$PREFIX."{$row['tablename']} SET {$inserts}";
    mysql_query($query);
}

function sendForm(){
    
}

