<?php
header("Content-Type: text/html; charset=windows-1251");
require_once("page.class.php");
require_once("contdisplay.php");
require_once("autokeyword.class.php");
//require
//target
require_once("news.class.php");
$new=new blocknews();
$target['<!--news-->']=$new->block("news");
if($_POST['action']){
	$url = trim($_POST['url']);
   	if((substr($url, 0, 7)) != "http://") $url="http://$url";
	$fp=fopen($url,"r");
	while (!feof($fp)) $data.=fgets($fp,64000); 
	//print $data;
	fclose($fp);
	if(isset($_POST['enc'])){
		$data=iconv($_POST['enc'],"CP1251",$data);//$_POST['enc']
	}
	$search = array ("'<script[^>]*?>.*?</script>'si",  // Вырезает javaScript
                 "'<[\/\!]*?[^<>]*?>'si",           // Вырезает HTML-теги
                 "'([\r\n])[\s]+'",                 // Вырезает пробельные символы
                 "'&(quot|#34);'i",                 // Заменяет HTML-сущности
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // интерпретировать как php-код

	$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");

	$text = preg_replace($search, $replace, $data);

	$params['content'] = $text; //page content
	$params['min_word_length'] = 5;  //minimum length of single words
	$params['min_word_occur'] = 3;  //minimum occur of single words

	$params['min_2words_length'] = 4;  //minimum length of words for 2 word phrases
	$params['min_2words_phrase_length'] = 10; //minimum length of 2 word phrases
	$params['min_2words_phrase_occur'] = 2; //minimum occur of 2 words phrase

	$params['min_3words_length'] = 4;  //minimum length of words for 3 word phrases
	$params['min_3words_phrase_length'] = 10; //minimum length of 3 word phrases
	$params['min_3words_phrase_occur'] = 2; //minimum occur of 3 words phrase

	$keyword = new autokeyword($params, "windows-1251");

	//echo "<H1>Output - keywords</H1>";

	//echo "<H2>words</H2>";
	//echo $keyword->parse_words();
	//echo "<H2>2 words phrase</H2>";
	//echo $keyword->parse_2words();
	//echo "<H2>2 words phrase</H2>";
	//echo $keyword->parse_3words();

	//echo "<H2>All together</H2>";
	//echo $keyword->get_keywords();
$target['<!--ticpr-->']="<p class=\"warn\">Теги для вашей страницы</p><textarea rows=\"5\" cols=\"50\">&lt;meta name=\"keywords\" content=\"".$keyword->get_keywords()."\"&gt;</textarea>";
}
$page=new page;
$context=new contdisplay;
$target['<!--rblock-->']=$context->display(10);
$target['<!--ban_price-->']=$page->ban_price;
$target['<!--title-->']="Сервис раскрутки сайтов";
$target['-@keywords@-']="";
$target['-@description@-']="";
$target['-@author@-']="Vlad";
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#meta",$target);
print $cont;
?>