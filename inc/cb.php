<?php
$content=get_content();
if($content!="none"){
$pattern="#<Valute ID=\"([^\"]+)[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>[^>]+>([^<]+)[^>]+>[^>]+>([^<]+)#i"; 
preg_match_all($pattern,$content,$out,PREG_SET_ORDER);
$dollar="";
$euro="";
foreach($out as $cur){
    if($cur[2] == 840) $dollar=str_replace(",",".",$cur[4]);
    if($cur[2] == 978) $euro=str_replace(",",".",$cur[4]);
}
}
echo "\$ - ".$dollar."<br>";
echo "&euro; - ".$euro."<br>";
function get_content(){ 
$date=date("d/m/Y"); 
$link="http://www.cbr.ru/scripts/XML_daily.asp?date_req=".$date; 
$fd=@fopen($link, "r"); 
$text=""; 
if (!$fd){
 $text="none";//Сервер ЦБ не отвечает"; 
} else { 
 while(!feof ($fd)) $text.=fgets($fd, 4096); 
 fclose($fd); 
} 
return $text; 
} 
?>
