<?php
set_time_limit(0);
session_start();
require_once("vars.class.php");
class dorgen extends vars{
	private $groups;
	private $dir="out";
	private $tpldir="tpl/";
	private $subdir;
	private $author="http://good-job.ws";
	private $lang;
	private $ext="html";
	private $pic_url;
	private $count;
	private $amount_pgs;
	private $img_height=10;
	private $img_width=10;
	public $num_pics;
	private $url;
	private $loaded=1;
	private $head;
	private $dorurl;
	private $menu=Array();
	private $texturl=Array();
	private $js;
	private $num_page=1;
	private $remote_content="";
	private $text="";
	private $uselink=0;
	private $linksin="";
	private $textlinks="";
	private $tpl;
	private $comments=0;
	private $pg_amt;
	private $rss;
	private $amt_rss=20;			//кол-во rss items
	private $rss_title;
	private $rss_item;
	private $rss_content;
	private $rss_links;
	private $rss_count=0;
	private $rss_cur=0;			//текущий номер rss
	private $prc;				//процент статей на rss
	private $gall_rows=5;
	private $gall_cols=5;
	private $gall_amt=40;
	private $google=0;			//генерация google sitemap
	private $priority=0.5;			//генерация google sitemap
	private $freq="monthly";		//генерация google sitemap
	private $hide_text=0;			//прятать текст
	private $gall_link=Array();
	private $name_pics=Array();
	private $gall_furl=Array();	
	private $about_ru=Array("Сайт о ","Здесь вы найдете информацию о","Новости сайта ","Информация ","Раздел сайта ","Подробности о ","Все что вы хотели знать о ","У нас есть все на тему ","Мы знаем все о ");
	private $about_en=Array("About ","Here You'll find information about ","News - ","Information about ","Site ","In details ","All you need to know about ","Here You'll find anything on ","We know everything about ");
	private $sentences=Array();
	function __construct(){
		$this->comments=$_POST['comments'];
		$this->rss=$_POST['rss'];
		$this->hide_text=$_POST['hide_text'];
		$this->google=$_POST['google'];
		$this->gall_link=explode("\n",$_POST['redirect_url']);
		$this->gall_furl=explode("\n",$_POST['false_url']);
		$this->gall_rows=$_POST['rows'];
		$this->gall_cols=$_POST['cols'];
		$this->gall_amt=$_POST['amt_pics'];
		$this->linksin=$_POST['links'];
		$this->textlinks=$_POST['textlinks'];
		$this->count=$_POST['count'];
		$this->uselink=$_POST['uselink'];
		$this->text=$_POST['text'];
		$this->js=$_POST['js'];
		$this->head=$_POST['head'];
		$this->texturl=$_POST['texturl'];
		$this->num_pics=$_POST['picture'];
		$this->pic_url=($_POST['dorurl']=="")?$_POST['upurl']:$_POST['dorurl'];
		$this->lang=$_POST['lang'];
		$this->ext=$_POST['ext'];
		$this->url=$_POST['upurl'];
		$this->dorurl=(strrpos($_POST['dorurl'],"/")==strlen($_POST['dorurl'])-1)?$_POST['dorurl']:$_POST['dorurl']."/";//$_POST['dorurl'];
		$this->use_pics=$_POST['picture'];
		if($_POST['tpl']=="default"){
			$this->tpl="tpl/templ.tpl";
		} elseif($_POST['tpl']=="defaultphp"){
			$this->tpl="tpl/tpl.php.tpl";
		} else {
			if(preg_match("![a-z\.]!is",$_POST['tpl']) && file_exists("userfiles/".$_SESSION['id']."/".$_POST['tpl'].".tpl")){
				$this->tpl="userfiles/".$_SESSION['id']."/".$_POST['tpl'].".tpl";
			} else {
				$this->tpl="tpl/templ.tpl";
			}
		}
		if(!is_dir($this->dir)){
			mkdir($this->dir);
		}
		$this->subdir=$this->dir."/".md5(time());
		if(!is_dir($this->subdir)){
			mkdir($this->subdir);
		}
		if(!is_dir($this->subdir."/img")){
			mkdir($this->subdir."/img");
		}
		if($this->num_pics==3 || $this->hide_text==1){
			$str="<script language=\"javascript\">function hide(){document.getElementById('content').className='change';}hide();</script>";
			for($i=0;$i<strlen($str);$i++){
				$a.=sprintf("\\x%02x",ord($str[$i]));
			}
			$this->hide_css="<script language=\"javascript\">document.write(\"".$a."\");</script>";
		}
	}
///GENERATE
	function generate($state) {
		$this->loaded=$state;
		//var_dump($this->texturl);
		foreach($this->texturl as $urltext){
			$story="";
			if($urltext!=""){
				if($fd = @fopen ($urltext, "r")){
				while (!feof ($fd)){
   					$buffer = fgets($fd, 4096);
   					$lines.= $buffer;
				}
				fclose($fd);
/////<--LAST ADD
				if(eregi("charset=utf-8",substr($lines,0,800))){
					$lines=iconv("utf-8","cp1251",$lines);
				}
///LAST ADD END--x
				$lines=preg_replace("'<style[^>]*?>.*?</style>'si","",$lines);
				$lines=preg_replace("'<script[^>]*?>.*?</script>'si","",$lines);
				$f_t=preg_match_all("#(<)([^>]+)(>)([^<]+)#is",$lines,$res);//"#(<td)([^>]*)(>)(.)+(</td>)#is",$lines,$res
				foreach($res[4] as $string){
					$string=preg_replace("!(www\.)(\S+)!is","",$string);
					$string=preg_replace("! +!is"," ",$string);
					$string=preg_replace("!(\r\n)+!is","\r\n",$string);
					$string=preg_replace("!(&[^;]+;)|(\t)!is","",$string);
					$string=preg_replace("!(http://)([\S]*)!is","",$string);
					if(strlen($string)>30 && !eregi("copyright",$string)){
						$story.=$string;
					}
				}
				$sentense=preg_replace("!(\.\s+)!is",".\r\n",$story);
				$sentense=preg_replace("!(\?\s+)!is","?\r\n",$sentense);
				$sentense=preg_replace("#(\!\s+)#is","!\r\n",$sentense);
				$fp=fopen($this->subdir."/text.txt","a+");
				fwrite($fp,$sentense);
				fclose($fp);
				$this->remote_content.=$sentense;
				}
			}
		}
		$content=Array();$remote=Array();
		if($this->text!=""){
			$text=preg_replace("!(\.\s+)!is",".\r\n",$this->text);
			$text=preg_replace("!(\?\s+)!is","?\r\n",$text);
			$text=preg_replace("#(\!\s+)#is","!\r\n",$text);
			$content=explode("\r\n",$text);
		}
		if($this->remote_content!=""){
			$remote=explode("\r\n",$this->remote_content);
		}
		$this->sentences=array_merge($content,$remote);
		$a=0;
		$arr=explode("\n",$_POST['keywords']);
		foreach($arr as $group){
			if(trim($group)==''){
				$a++;
				$s="";
			}
			$rawgroups[$a].=$s.trim($group);
			$s=",";
		}
		foreach($rawgroups as $correct){
			if(substr($correct,0,1)==","){
				$this->groups[]=substr($correct,(strpos(",",$correct)+1));
			} else {
				$this->groups[]=$correct;
			}
		}
		$amount_gr=count($groups);
		if($amount_gr>=$this->count){
			$amount_pgs=$amount_gr;
		} else {
			$keywords=Array();
			$amount_pgs=$amount_gr=$this->count;
			foreach($this->groups as $keys){
				$key_arr=explode(",",$keys);
				$this->groups=array_merge($this->groups,$key_arr);
				unset($key_arr);
			}
			$this->groups=array_unique($this->groups);
			$i=0;
			while(count($this->groups)<$this->count){
				$a=0;
				$this->groups[]=$this->groups[count($this->groups)-$i-$a-2].",".$this->groups[count($this->groups)-$a-1];
				$i+=2;
				$this->groups=array_unique($this->groups);
				if(count($this->groups)-$i-$a<=1 && $a+2<count(count($this->groups))){
					$a++;
					$i=0;
				} else {
					$this->add();
					break;
				}
			}
		}
		$temp_count=count($this->groups);
		$amount_pgs=($amount_pgs>$temp_count)?$temp_count:$amount_pgs;
		$this->pg_amt=$amount_pgs;
		$prc=ceil($this->amt_rss*100/$this->pg_amt);
		$this->prc=($prc>100)?100:$prc;
		for($i=0;$i<$amount_pgs;$i++){
			$path=$this->translit($this->groups[$i]);
			$path=substr($path,0,60);
			$j=0;$a="";
			while(array_key_exists($path.$a,$this->menu)){
				$j++;
				$a="_".$j;
			}
			$path=($i==0)?"index":$path.$a;
			$this->menu[$path]=$this->groups[$i];
		}

		foreach($this->menu as $gpath=>$key){
			if(strlen($key)>1){
				$this->gen_page($key,$gpath);
				$links_bbc.="[url=".$this->dorurl.$gpath.".".$this->ext."]".$key."[/url]\r\n";
				$links_html.="<a href=\"".$this->dorurl.$gpath.".".$this->ext."\">".$key."</a>\r\n";
				$links.=$this->dorurl.$gpath.".".$this->ext." - ".$key."\r\n";
			}
		}
		if($this->rss==1){
			$this->gen_rss();
		}
		if($this->js!=1){
			$this->gen_script();
		}
		$fp=fopen($this->subdir."/links.txt","w+");
		fwrite($fp,$links);
		fclose($fp);
		$fp=fopen($this->subdir."/links_bbc.txt","w+");
		fwrite($fp,$links_bbc);
		fclose($fp);
		$fp=fopen($this->subdir."/links_html.txt","w+");
		fwrite($fp,$links_html);
		fclose($fp);
		$css_str=".content{color:black;font-size:14px}\r\n.change{display:none}\r\n.gallery{}";
		$css_done=fopen($this->subdir."/main.css","w+");
		fwrite($css_done,$css_str);
		fclose($css_done);
		if($this->google==1){
			require_once "google_sitemap.class.php";
			$sitemap=new google_sitemap;
			$sitemap->generate($this->dorurl,$this->subdir,$this->freq,$this->priority);
		}
		require_once("Zip.php");
		$zip=new Archive_Zip($this->path.$this->subdir."/door.zip");
/*
		$zip->create(glob($this->path.$this->subdir."/*.html"));

		foreach(glob($this->subdir."/img/") as $file){
			$zip->add($file);
		}
*/
		foreach(glob($this->subdir."/*") as $file){
			//$file=str_replace($this->subdir,"",$file);
			$zip->add($file);
		}


		//$str=$this->path.$this->subdir."/door.zip";
		$str='<a href="'.$this->subdir.'/door.zip">Загрузить</a>';
		return $str;
	}

///ADD
	function add(){
		$temp=$this->groups;
		if($this->lang=="ru"){
			foreach($temp as $keys){
				$this->groups[]=$this->translit($keys,true);
			}
			foreach($temp as $keys){
				$this->groups[]=$this->type_error($keys);
			}
		} else {
			foreach($temp as $keys){
				$this->groups[]=$this->type_error($keys);
			}
		}
	}

///GEN_SCRIPT
	function gen_script(){
		$a=0;$i=0;
		$x=Array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z','a1','b1','c1','d1','e1','f1','g1','h1','i1','j1','k1','l1','m1','n1','o1','p1','q1','r1','s1','t1','u1','v1','w1','x1','y1','z1','a2','b2','c2');
		$parts=rand(1,4);
		$line='a3="wi";b3="ndo";c3="w.";d3="l";e3="oca";f3="tio";g3="n=\"";';
		$eval="a3+b3+c3+d3+e3+f3+g3+";
		while(substr($this->url,$a,$parts)){
			$parts=rand(1,4);
			$vars=substr($this->url,$a,$parts);
			$line.=$x[$i]."=\"".$vars."\";";
			$eval.=$x[$i]."+";
			$a+=$parts;$i++;
		}
		$line.='h3="\"";';
		$eval.="h3";
		$line.="document.write(eval(".$eval."));";
		$fp=fopen($this->subdir."/script.js","w+");
		fwrite($fp,$line);
		fclose($fp);

	}

///GEN_INLINKS
	function gen_inlinks($keys){
		if($this->textlinks!="" && $this->linksin!=""){
			$text=explode("\r",$this->textlinks);
			$links=explode("\r",$this->linksin);
			$i=0;
			foreach($links as $link){
				$code[]="<a href=\"".$link."\">".$text[$i]."</a>";
				$i++;
			}
		} elseif($this->textlinks=="" && $this->linksin!=""){
			$links=explode("\r",$this->linksin);
			$i=0;
			$k=explode(",",$keys);
			foreach($links as $link){
				$i=(isset($k[$i]))?$i:0;
				$code[]="<a href=\"".$link."\">".$k[$i]."</a>";
				$i++;
			}
		} elseif($this->textlinks!="" && $this->linksin==""){
			$text=explode("\r",$this->textlinks);
			foreach($text as $t){	
				$code[]="<a href=\"".$this->url."\">".$t."</a>";
			}		
		} else {
			$k=explode(",",$keys);
			foreach($k as $key){
				$code[]="<a href=\"".$this->dorurl."\">".$key."</a>";
			}			
		}
		return $code;
	}
///CONTENT
	function gen_content($keys,$path){
		if($this->uselink==1){
			$inlinks=$this->gen_inlinks($keys);
			shuffle($inlinks);
		}
		$tag=Array("<i>","<em>","<b>","","<dfn>","<ins>","<strong>");$endtag=Array("</i>","</em>","</b>","","</dfn>","</ins>","</strong>");
		$k=explode(",",$keys);
		$c_art=count($k);
		$art_len=round(250/sqrt($c_art));

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$--DELETED--$$$$$$$$$$$$$$$$$$$$$$$$$

		foreach($k as $key){
			$cur_length=0;
			$cur_article="<h2>".$key."</h2><p>";
			while($cur_length<$art_len){
				$article="";
				shuffle($this->sentences);
/////////////////////////////////////////
				//$sentence=array_pop($this->sentences);//BAK
				$s=array_pop($this->sentences);//$sentence=array_pop($this->sentences);//Change
				if(preg_match("!^[\w\s\?\!,\.;:\"'`——»«-]+$!is",$s,$match)){	//Del
					$sentence=$s;				//if not
				}
				if(strlen($sentence)<40){
					$flag=1;
					$article.=$sentence;
					$cur_length++;
				} else {
					$flag=0;
					$words=explode(" ",$sentence);
					$cur_length+=count($words);
					foreach($words as $word){
						if(isset($word) && strlen($word)>=3 && strlen($key)>3){
						$i=rand(0,6);
						if(eregi(substr($key,0,strlen($key)-2),$word) && !eregi("!",$word)){
							$article.=" ".$tag[$i].$word.$endtag[$i];
							$flag++;
						} else {
							$article.=" ".$word;
						}
						}
					}
				}
				$br=Array("","","","","","<br>");
				$br_rand=array_rand($br);
				$cur_article.=$article.$br[$br_rand];
			}
			if($this->uselink==1){
				$l=array_pop($inlinks);
				$words=explode(" ",$cur_article);
				$p=rand(0,1);
				$c=count($words);
				$offset=rand(4,$c-2);
				array_splice($words,$offset,$p,$l);
				$cur_article=implode(" ",$words);
			}

//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$--RSS--$$$$$$$$$$$
			if($this->rss==1){
				$this->gen_rss_item($cur_article,$key,$path);
			}
//$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$$--RSS--$$$$$$$$$$$

			$fullarticle.=$cur_article." </p>\r\n";

		}
		return $fullarticle;
	}

///GEN_PAGE
	function gen_page($keys,$path){
		$page=implode("",file($this->tpl));
		$intro=($this->lang=="ru")?$this->about_ru[array_rand($this->about_ru)]:$this->about_en[array_rand($this->about_en)];
		$t=explode(",",$keys);
		$zc=(count($t)<7)?count($t):6;
		for($z=0;$z<$zc;$z++){
			$tkey.=$t[$z].", ";
		}
		$tkey=substr($tkey,0,-2);
		$description="<meta name=\"description\" content=\"".$intro." ".$keys."\" />";
		$keywords="<meta name=\"keywords\" content=\"".$keys."\" />";
		$page=str_replace("<!--upurl-->",$this->url,$page);
		$page=str_replace("<!--title-->",$intro.$tkey,$page);
		$page=str_replace("<!--description-->",$description,$page);
		$page=str_replace("<!--keywords-->",$keywords,$page);
		$css="<link rel=\"stylesheet\" href=\"main.css\" />\r\n";
		if($this->js!=1){


			
			$script="<script language=javascript>document.write(unescape('%3C%73%63%72%69%70%74%20%6C%61%6E%67%75%61%67%65%3D%22%6A%61%76%61%73%63%72%69%70%74%22%3E%66%75%6E%63%74%69%6F%6E%20%64%46%28%73%29%7B%76%61%72%20%73%31%3D%75%6E%65%73%63%61%70%65%28%73%2E%73%75%62%73%74%72%28%30%2C%73%2E%6C%65%6E%67%74%68%2D%31%29%29%3B%20%76%61%72%20%74%3D%27%27%3B%66%6F%72%28%69%3D%30%3B%69%3C%73%31%2E%6C%65%6E%67%74%68%3B%69%2B%2B%29%74%2B%3D%53%74%72%69%6E%67%2E%66%72%6F%6D%43%68%61%72%43%6F%64%65%28%73%31%2E%63%68%61%72%43%6F%64%65%41%74%28%69%29%2D%73%2E%73%75%62%73%74%72%28%73%2E%6C%65%6E%67%74%68%2D%31%2C%31%29%29%3B%64%6F%63%75%6D%65%6E%74%2E%77%72%69%74%65%28%75%6E%65%73%63%61%70%65%28%74%29%29%3B%7D%3C%2F%73%63%72%69%70%74%3E'));dF('%264DTDSJQU%2631MBOHVBHF%264E%2633kbwbtdsjqu%2633%2631TSD%264E%2633tdsjqu/kt%2633%264F%261B%264D0TDSJQU%264F%261B1')</script>\r\n";
			$script.=$css;
			$page=str_replace("<!--script-->",$script,$page);
		} else {
			$page=str_replace("<!--script-->",$css,$page);
		}
		if(eregi("index",$path)){
			$h1keys=explode(",",$keys);
			if(count($h1keys)>11){
				$mainkey=array_shift($h1keys);
				$rand_keys=array_rand($h1keys,9);
				$h1k=Array($mainkey,$h1keys[$rand_keys[0]],$h1keys[$rand_keys[1]],$h1keys[$rand_keys[2]],$h1keys[$rand_keys[3]],$h1keys[$rand_keys[4]],$h1keys[$rand_keys[5]],$h1keys[$rand_keys[6]],$h1keys[$rand_keys[7]],$h1keys[$rand_keys[8]]);
				$hkey=implode(", ",$h1k);
			} else {
				$hkey=implode(", ",$h1keys);
			}
		} else {
			$hkey=str_replace(",",", ",$keys);
		}


		$h1="<h1 style=\"text-align:center\">".$hkey."</h1>\r\n";
		$page=str_replace("<!--h1-->",$h1,$page);
		$links1="";
		if($this->head=='key'){
			$k1=explode(",",$keys);
			foreach($k1 as $k){
				$links1.="<a href=\"".$this->url."\">".$k."</a>\r\n";
			}
		} elseif($this->head==1){
			$links1="<a href=\"".$this->url."\">".$keys."</a>\r\n";
		} elseif($this->head=="all"){
			$k1=explode(",",$keys);
			foreach($k1 as $k){
				$k_tr=$this->translit($k);
				$tr_link=(in_array($k_tr,$k1))?"\r\n":"<a href=\"".$this->url."\">".$k_tr."</a>\r\n";
				$links1.="<a href=\"".$this->url."\">".$k."</a> ".$tr_link;
			}

		} else {
			$links1="";//$page=str_replace("<!--links1-->","",$page);
		}
		$page=str_replace("<!--links1-->",$links1,$page);
		$content=$this->gen_content($keys,$path);
		if($this->num_pics==2 || $this->num_pics==1){
			$pictures=$this->gen_picture($keys);
			foreach($pictures as $pckey=>$pic_path){
				$image.="<img src=\"".$pic_path."\"  alt=\"".$pckey."\" style=\"float:left\" />";//width=\"".$this->img_width."\" height=\"".$this->img_height."\"
			}
			
		} elseif($this->num_pics==3){
			$content="<span class=\"content\" id=\"content\">".$content."</span>";
			$gallery="<br /><table class=\"gallery\">";
			$amt=1;
			$pkey=explode(",",$keys);
			$this->name_pics=$preserv=range(1,$this->gall_amt);
			for($i=0;$i<$this->gall_rows;$i++){
				$gallery.="<tr>";
				for($j=0;$j<$this->gall_cols;$j++){
					if(empty($this->name_pics)){$this->name_pics=$preserv;}
					shuffle($this->name_pics);
					$amt=array_pop($this->name_pics);
					$outlink=(count($this->gall_link)>1)?$this->gall_link[array_rand($this->gall_link)]:$this->gall_link[0];
					$gallery.="<td><a rel=\"nofollow\" href=\"".trim($outlink)."\" class=\"gallery\" onmouseover=\"window.status='".trim($this->gall_furl[array_rand($this->gall_furl)])."'; return true;\" onmouseout=\"window.status=''; return true;\"><img src=\"/img/".$amt.".jpg\" alt=\"".trim($pkey[array_rand($pkey)])."\" /></a></td>\r\n";
					//$amt=($amt>=$this->gall_amt-1)?0:$amt+1;
				}
				$gallery.="</tr>";
			}
			$gallery.="</table><br />";
			$image="";
		} else {
			$image="";

		}
		if($this->num_pics!=3 && $this->hide_text==1){
			$content="<span class=\"content\" id=\"content\">".$content."</span>";
		}
		$content.=$this->hide_css.$gallery;
		$page=str_replace("<!--content-->",$content,$page);


		$page=str_replace("<!--image-->",$image,$page);
		$count_menu=0;
		foreach($this->menu as $page_path=>$key){
			$key=eregi_replace(",",", ",$key);
			$link_text=($count_menu==0)?(($this->lang=="ru")?"Главная":"Home"):$key;
			$comments=($this->comments==1)?"<!--".$key."-->\r\n":"";
			$menu.="<p class=\"menu\"><b><a href=\"".$page_path.".".$this->ext."\" title=\"".$key."\">".$link_text."</a></b></p>\r\n".$comments;

			if(strlen($this->dorurl)>10){
				$links.=" <a href=\"".$this->dorurl."\" title=\"".$key."\">".$key."</a> |";
			} else {
				$links.=" <a href=\"index.".$this->ext."\" title=\"".$key."\">".$key."</a> |";
			}
			$count_menu++;
		}
		if($this->rss==1){
			$menu.="<br /><br /><a href=\"rss.xml\">RSS</a>";
		}
		if($this->google==1){
			$menu.="<br /><a href=\"sitemap.xml\">sitemap</a>";
		}
		if(strlen($keys)>40){
			$c_keys=explode(",",$keys);$x=0;
			while(strlen($cpk)<30){
				$cpk.=$c_keys[$x].", ";
				$x++;
			}
			$cpk=substr($cpk,0,-2);
		} else {
			$cpk=$keys;
		}
		$copy=date("Y",time())." ".$cpk;
		$page=str_replace("<!--links-->",$links,$page);
		$page=str_replace("<!--copy-->",$copy,$page);
		$page=str_replace("<!--menu-->",$menu,$page);
		$html_done=fopen($this->subdir."/".$path.".".$this->ext,"w+");
		fwrite($html_done,$page);
		fclose($html_done);
	}
///GEN_PICTURE
	function gen_picture($keys){

		$new_ps_file_info_array = Array();
		$word=$this->translit($keys);
		$word=substr($word,0,60);
		$i=0;$a="";
		while(is_file($this->subdir."/img/".$word.$a.".jpg")){
			$i++;
			$a="_".$i;
		}
		$pic_path=$this->subdir."/img/".$word.$a.".jpg";
		$your_path="./img/".$word.$a.".jpg";
		$filename=($this->loaded==2)?"userfiles/".$_SESSION['id']."/tpl.jpg":$this->tpldir."tplru.jpg";
		switch($this->num_pics){
			case 1:
				$utfkeys=iconv("windows-1251", "utf-8", $keys);
				$new_ps_file_info_array = array(
		      			"outputfilename"=>$pic_path,
		      			"filename"=>$filename,
                      			"title" => $utfkeys,
                      			"author" => iconv("windows-1251", "utf-8","http://good-job.ws"),
                      			"authorsposition" => "",
                      			"caption" => $utfkeys,
                      			"captionwriter" => "",
                      			"jobname" => "",
                      			"copyrightstatus" => "",
                      			"copyrightnotice" => "",
                      			"ownerurl" => iconv("windows-1251", "utf-8",$this->url),
                      			"keywords" => $utfkeys,
                      			"category" => $utfkeys,
                      			"supplementalcategories" => $utfkeys,
                      			"date" =>date("Y-m-d",time()),
                      			"city" => "",
                      			"state" => "",
                      			"country" => iconv("windows-1251", "utf-8","Russia"),
                      			"credit" => "",
                      			"source" => "",
                      			"headline" => "",
                      			"instructions" => "",
                      			"transmissionreference" => "",
                      			"urgency" => "" );
				include ("Write_File_Info.php");

/*
				$fd = fopen ($this->tpldir."tplru.jpg", "r");
				while (!feof ($fd)){
   					$buffer = fgets($fd, 4096);
   					$lines.= $buffer;
				}
				fclose ($fd);
				$picture=str_replace("ключевые",$keys,$lines);
				$picture=str_replace("адрес",$this->pic_url,$picture);
				$picture=str_replace("автор",$this->author,$picture);
				$picture=str_replace("название",$keys,$picture);
				$picture=str_replace("заметки",$keys,$picture);
				$picture=str_replace("описание",$keys,$picture);
				$p_done=fopen($pic_path,"w+");
				fwrite($p_done,$picture);
				fclose($p_done);
*/
				$pic_data[$keys]=$your_path;

				break;
			case 2:
				unset($pic_data);
/*
				$fd = fopen ($this->tpldir."tplru.jpg", "r");
				while (!feof ($fd)){
   					$buffer = fgets($fd, 4096);
   					$lines.= $buffer;
				}
				fclose ($fd);
*/
				if(!is_dir($this->subdir."/img/".$this->num_page)){
					mkdir($this->subdir."/img/".$this->num_page);
				}
				$k=explode(",",$keys);
				foreach($k as $key){
					$utfkey=iconv("windows-1251", "utf-8", $key);
					$word=$this->translit($key);
					$i=0;$a="";
					while(is_file($this->subdir."/img/".$this->num_page."/".$word.$a.".jpg")){
						$i++;
						$a="_".$i;
					}
					$pic_path=$this->subdir."/img/".$this->num_page."/".$word.$a.".jpg";
					$your_path="./img/".$this->num_page."/".$word.$a.".jpg";
					$new_ps_file_info_array = array(
		      				"outputfilename"=>$pic_path,
		      				"filename"=>$filename,
                      				"title" => $utfkey,
                      				"author" => iconv("windows-1251", "utf-8","http://good-job.ws"),
                      				"authorsposition" => "",
                      				"caption" => $utfkey,
                      				"captionwriter" => "",
                      				"jobname" => "",
                      				"copyrightstatus" => "",
                      				"copyrightnotice" => "",
                      				"ownerurl" => iconv("windows-1251", "utf-8",$this->url),
                      				"keywords" => $utfkey,
                      				"category" => $utfkey,
                      				"supplementalcategories" => $utfkey,
                      				"date" =>date("Y-m-d",time()),
                      				"city" => "",
                      				"state" => "",
                      				"country" => iconv("windows-1251", "utf-8","Russia"),
                      				"credit" => "",
                      				"source" => "",
                      				"headline" => "",
                      				"instructions" => "",
                      				"transmissionreference" => "",
                      				"urgency" => "" );
					include_once ("Write_File_Info.php");


/*
					$picture=str_replace("ключевые",$key,$lines);
					$picture=str_replace("адрес",$this->pic_url,$picture);
					$picture=str_replace("автор",$this->author,$picture);
					$picture=str_replace("название",$key,$picture);
					$picture=str_replace("заметки",$key,$picture);
					$picture=str_replace("описание",$key,$picture);
					$p_done=fopen($pic_path,"w+");
					fwrite($p_done,$picture);
					fclose($p_done);
*/
					$pic_data[$key]=$your_path;
				}
				$this->num_page++;
				break;
			default:

				break;

		}
		return $pic_data;
	}
///RSS
	function gen_rss_item($article,$key,$path){
		$flag=0;
		if($this->rss_count==0){
			$this->rss_title=$key;
			$flag=1;
		}
		if(eregi("index",$path)){
			$flag=1;
		}
		$it=rand(1,100);
		if($it<$this->prc && $this->rss_cur<$this->amt_rss && $flag!=1){
			$article=strip_tags($article,"<a>");
			$begin=substr($article,0,80);
			$new=str_replace($key,"",$begin);
			$article=str_replace($begin,$new,$article);
			if(strlen($article)>320){
				$length=strpos($article," ",315);
				$article=substr($article,0,$length)."...";
			}
			$len=rand(30,strlen($article)-60);
			$article=substr_replace($article," ".$key." ",strpos($article," ",$len),1);
			$this->rss_item[]=$key;
			$this->rss_content[]=$article;
			$this->rss_links[]=$this->dorurl.$path.".".$this->ext;
			$this->rss_cur++;
		}
		$this->rss_count++;

	}
	function gen_rss(){
		$intro=($this->lang=="ru")?$this->about_ru[array_rand($this->about_ru)]:$this->about_en[array_rand($this->about_en)];
		$dom = new DOMDocument("1.0","utf-8");
		$root1 = $dom->createElement("rss");
		$dom->appendChild($root1);
		$pr = $dom->createAttribute("version");
		$root1->appendChild($pr);
		$prValue = $dom->createTextNode("2.0");
		$pr->appendChild($prValue);
		$root = $dom->createElement("channel");
		$root1->appendChild($root);
		$item = $dom->createElement("title");
		$root->appendChild($item);
		$text = $dom->createTextNode($this->rss_title);//iconv("CP1251","UTF-8",
		$item->appendChild($text);
		$item = $dom->createElement("link");
		$root->appendChild($item);
		$text = $dom->createTextNode($this->dorurl);
		$item->appendChild($text);
		$item = $dom->createElement("description");
		$root->appendChild($item);
		$text = $dom->createTextNode($intro." ".$this->rss_title);//iconv("CP1251","UTF-8",
		$item->appendChild($text);
		$item = $dom->createElement("lastBuildDate");
		$root->appendChild($item);
		$text = $dom->createTextNode(date("r",time()));
		$item->appendChild($text);
		$item = $dom->createElement("pubDate");
		$root->appendChild($item);
		$text = $dom->createTextNode(date("r",time()));
		$item->appendChild($text);

		$item = $dom->createElement("guid");
		$root->appendChild($item);
		$attr = $dom->createAttribute("isPermaLink");
		$item->appendChild($attr);
		$text = $dom->createTextNode("true");
		$attr->appendChild($text);
		$text = $dom->createTextNode($this->dorurl);
		$item->appendChild($text);
		$r=0;
		foreach($this->rss_item as $rss_it){
			$item = $dom->createElement("item");
			$root->appendChild($item);
			$title=$dom->createElement("title");
			$item->appendChild($title);
			$text = $dom->createTextNode($this->rss_item[$r]);//iconv("CP1251","UTF-8",
			$title->appendChild($text);
			$title=$dom->createElement("link");
			$item->appendChild($title);
			$text = $dom->createTextNode($this->rss_links[$r]);
			$title->appendChild($text);

			$title=$dom->createElement("description");
			$item->appendChild($title);
			$text = $dom->createTextNode(strip_tags($this->rss_content[$r],"<a>"));//iconv("CP1251","UTF-8",
			$title->appendChild($text);

			$title=$dom->createElement("pubDate");
			$item->appendChild($title);
			$text = $dom->createTextNode(date("r",time()));
			$title->appendChild($text);

			$title=$dom->createElement("guid");
			$item->appendChild($title);

			$attr = $dom->createAttribute("isPermaLink");
			$title->appendChild($attr);
			$text = $dom->createTextNode("true");
			$attr->appendChild($text);
			$text = $dom->createTextNode($this->rss_links[$r]);
			$title->appendChild($text);
			$r++;
		}
		$dom->save($this->subdir."/rss.xml");

		//include_once "dor_rss.php";
	}
////////////////////
	function type_error($word){
		$word=trim(strip_tags($word));
		$ru=Array('а','б','в','г','д','е','ё','ж',
			'з','и','й','к','л','м','н','о','п',
			'р','с','т','у','ф','х','ц','ч','ш',
			'щ','ы','ь','ъ','э','ю','я');
		$en=Array('f',',','d','u','l','t','`',';',
			'p','b','q','r','k','v','y','j','g',
			'h','c','n','e','a','[','w','x','i',
			'o','s','m',']','\'','.','z');
		if($this->lang=='ru'){
			$result=str_ireplace($ru,$en,$word);
		} else {
			$result=str_ireplace($en,$ru,$word);
		}
		return $result;
	}




////////////////////
	function translit($word,$text=false){
		$word=trim(strip_tags($word));
		$s_ru=($text==false)?' ':'';
		$s_en=($text==false)?'_':'';
		$c_ru=($text==false)?',':'';
		$c_en=($text==false)?'_':'';
		$o_ru=($text==false)?'!':'';
		$o_en=($text==false)?'_':'';
		$trans=Array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'jo','ж'=>'zh',
			'з'=>'z','и'=>'i','й'=>'j','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p',
			'р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'tc','ч'=>'ch','ш'=>'sh',
			'щ'=>'sh','ы'=>'i','ь'=>'','ъ'=>'','э'=>'e','ю'=>'ju','я'=>'ja',$s_ru=>$s_en,$c_ru=>$c_en,$o_ru=>$o_en);
		$ru=Array('а','б','в','г','д','е','ё','ж',
			'з','и','й','к','л','м','н','о','п',
			'р','с','т','у','ф','х','ц','ч','ш',
			'щ','ы','ь','ъ','э','ю','я',$s_ru,$c_ru,$o_ru);
		$en=Array('a','b','v','g','d','e','jo','zh',
			'z','i','j','k','l','m','n','o','p',
			'r','s','t','u','f','h','ts','ch','sh',
			'sh','i','','','e','ju','ja',$s_en,$c_en,$o_en);
		$result=str_ireplace($ru,$en,$word);
		return $result;
	}
}
?>