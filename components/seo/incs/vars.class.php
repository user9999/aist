<?php
class vars{
  public $path="/home/users1/r/redheaddaddy/domains/seo.musicvip.ru/";
	public $path_html="/home/users1/r/redheaddaddy/domains/seo.musicvip.ru/html/html5/";
  //public $path_html="/home/users1/r/redheaddaddy/domains/seo.musicvip.ru/html/xhtml/";
  public $PATH_HTTP="http://seo.musicvip.ru/"; 
	public $path_news="/home/users1/r/redheaddaddy/domains/seo.musicvip.ru/info/";
	public $path_www_news="/home/users1/r/redheaddaddy/domains/seo.musicvip.ru/info/";
	public $db_prefix="seo_";
	public $adminmail="play-fine@yandex.ru";
	public $ban_price=0.15;
	public $default_url="http://seo.musicvip.ru/";
	public $default_banner="http://seo.musicvip.ru/html/html5/img/banner.gif";
	public $mime="text/html";
	//public $mime="application/xhtml+xml";
	public $charset="windows-1251";
	//vars
    	public $name="SEO";
	function warn($s){
		$res="<p class=\"warn\">".$s."</p>";
		return $res;
	}    
    }
?>
