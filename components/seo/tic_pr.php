<?php
set_time_limit(0);
require_once("page.class.php");
require_once("contdisplay.php");
//require
//target

if(isset($_POST['action'])){
   	$url = trim($_POST['url']);
   	if((substr($url, 0, 7)) != "http://") $url="http://$url";
   	function tcy_yandex($url) {
            	$str=file('http://bar-navig.yandex.ru/u?ver=2&show=32&url='.$url);
            	if ($str==false){
                  	$ans=false;
            	} else {
                     	$is_find=preg_match("/value=\"(.\d*)\"/", join("",$str), $tic);
                        if ($is_find<1){
                                   $ans=0;
                        } else {
                                   $ans=$tic[1];
                        }
            	}
             	return $ans;
   	} 
   	define('GOOGLE_MAGIC', 0xE6359A60);
	function zeroFill($a, $b){
     		$z = hexdec(80000000);
     		if($z & $a){
       			$a = ($a>>1);
       			$a &= (~$z);
       			$a |= 0x40000000;
       			$a = ($a>>($b-1));
     		}else {
			 $a = ($a>>$b); 
		}
     		return $a;
   	}
   	function mix($a,$b,$c) {
     		$a -= $b; $a -= $c; $a ^= (zeroFill($c,13));
     		$b -= $c; $b -= $a; $b ^= ($a<<8);
     		$c -= $a; $c -= $b; $c ^= (zeroFill($b,13));
     		$a -= $b; $a -= $c; $a ^= (zeroFill($c,12));
     		$b -= $c; $b -= $a; $b ^= ($a<<16);
     		$c -= $a; $c -= $b; $c ^= (zeroFill($b,5));
     		$a -= $b; $a -= $c; $a ^= (zeroFill($c,3));
     		$b -= $c; $b -= $a; $b ^= ($a<<10);
     		$c -= $a; $c -= $b; $c ^= (zeroFill($b,15));
     		return array($a,$b,$c);
   	}
	function GoogleCH($urlpage, $length=null, $init=GOOGLE_MAGIC) {
     		if(is_null($length)) { $length = sizeof($urlpage); }
     		$a = $b = 0x9E3779B9;
     		$c = $init;
     		$k = 0;
     		$len = $length;
     		while($len >= 12) {
       			$a += ($urlpage[$k+0] + ($urlpage[$k+1]<<8) + ($urlpage[$k+2]<<16) + ($urlpage[$k+3]<<24));
       			$b += ($urlpage[$k+4] + ($urlpage[$k+5]<<8) + ($urlpage[$k+6]<<16) + ($urlpage[$k+7]<<24));
       			$c += ($urlpage[$k+8] + ($urlpage[$k+9]<<8) + ($urlpage[$k+10]<<16)+ ($urlpage[$k+11]<<24));
       			$mix = mix($a,$b,$c);
       			$a = $mix[0]; $b = $mix[1]; $c = $mix[2];
       			$k += 12;
       			$len -= 12;
     		}
     		$c += $length;
     		switch($len){
       			case 11: $c+=($urlpage[$k+10]<<24);
       			case 10: $c+=($urlpage[$k+9]<<16);
       			case 9 : $c+=($urlpage[$k+8]<<8);
       			case 8 : $b+=($urlpage[$k+7]<<24);
       			case 7 : $b+=($urlpage[$k+6]<<16);
       			case 6 : $b+=($urlpage[$k+5]<<8);
       			case 5 : $b+=($urlpage[$k+4]);
       			case 4 : $a+=($urlpage[$k+3]<<24);
       			case 3 : $a+=($urlpage[$k+2]<<16);
       			case 2 : $a+=($urlpage[$k+1]<<8);
       			case 1 : $a+=($urlpage[$k+0]);
     		}
     		$mix = mix($a,$b,$c);
     		return $mix[2];
   	}
	function strord($string) {
     		for($i=0;$i<strlen($string);$i++) {
        		$result[$i] = ord($string{$i});
     		}
    		 return $result;
   	}
// Функция для определения PR Google
	function pr_google($url) {
     		$urlpage = 'info:'.$url;
     		$ch = GoogleCH(strord($urlpage));
     		$ch = "6$ch";
     		$page = @file("http://www.google.com/search?client=navclient-auto&ch=$ch&features=Rank&q=info:".urlencode($url));
     		$page = @implode("", $page);
     		if(preg_match("/Rank_1:(.):(.+?)\n/is", $page, $res)) { return "$res[2]"; }
     		else return "0";
   	}

   $target['<!--ticpr-->'] = "Page Rank Google: ".pr_google($url)." ;&nbsp;&nbsp;&nbsp; тИЦ Яндекс: ".tcy_yandex($url);
  // $cy = tcy_yandex($url);
}

require_once("news.class.php");
$new=new blocknews();
$target['<!--news-->']=$new->block("news");
$page=new page;
$context=new contdisplay;
$target['<!--rblock-->']=$context->display(10);
$target['<!--ban_price-->']=$page->ban_price;
$target['<!--title-->']="Сервис раскрутки сайтов";
$target['-@keywords@-']="";
$target['-@description@-']="";
$target['-@author@-']="Vlad";
$cont=$page->replace_file("index.tpl","menu,menu1,menu2,footer,content#tic_pr",$target);
print $cont;
?>