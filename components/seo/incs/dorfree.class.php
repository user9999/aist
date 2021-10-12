<?php
require_once("vars.class.php");
class dorfree extends vars{
	function generate() {
		if($_POST['count']>50){
			$error="<p class=\"warn\">Максимальное количество страниц не должно превышать 50!<p>";
			return $error;
		}
		for($c=0;$c<16;$c++){
     			$random=mt_rand(48,122);
        		$random=md5($random);
        		$dir.= substr($random, 17, 1);
		}
		$dir=$dir."/";
		$p=array();

	if ($_POST['keywords']) {
		$_POST['keywords']=ereg_replace("(\r\n|\r)","\n",$_POST['keywords']);
		$keys=explode("\n",trim($_POST['keywords']));
		for($i=0;$i<intval($_POST['count']);$i++) {
			list($k,$v)=each($keys);
			if (!$v) {
				reset($keys);
				list($k,$v)=each($keys);
			}
			if (in_array(trim($v),$p)) {
				$v=trim($v).'_'.$i;
			}
			$p[]=trim($v);
		}
		$tpl=implode('',file('./tpl/template.html'));
		reset($p);
		while(list($k,$v)=each($p)) {
			//$name=str_replace(' ','_',$v);
			$k++;
			$name=($k==1)?"index":("page".$k);
			$l.='<a href="'.trim($name).'.html">'.trim($v).'</a> ';
		}
		/* generate pages */
		reset($p);
		if(!is_dir('out/'.$dir)){
			mkdir('out/'.$dir);
		}
		require_once("Zip.php");
		$zip=new Archive_Zip("out/".$dir."door.zip");

		while(list($k,$v)=each($p)) {
			$k++;
			//$name=trim(str_replace(' ','_',$v));
			$name=($k==1)?"index":("page".$k);
			$tpl_out=str_replace('{TITLE}',$v,$tpl);
			$tpl_out=str_replace('{COPYRIGHT}',$this->PATH_HTTP,$tpl);
			$tpl_out=str_replace('{KEYWORDS}',ereg_replace("(\r\n|\n|\r)","",implode(', ',$keys)),$tpl_out);
			$tpl_out=str_replace('{DESC}',ereg_replace("(\r\n|\n|\r)","",implode(' ',$keys)),$tpl_out);
			$tpl_out=str_replace('{LINK}',$l,$tpl_out);
			$tpl_out=str_replace('{I}',$k,$tpl_out);
			$tpl_out=str_replace('{ENTER}',trim($_POST['url']),$tpl_out);

			$fp=fopen('./out/'.$dir.$name.'.html','w');
			fwrite($fp,$tpl_out);
			fclose($fp);
			//$files[$k-1]=$this->path."out/".$dir.$name.".html";
			$zip->add("out/".$dir.$name.".html");

			flush();
		}
		//var_dump($files);
		//$zip->create($files);		
		$error= '<a href="./out/'.$dir.'door.zip" onClick="doLoad(\''.substr($dir,0,16).'\')">Загрузить</a>';
		return $error;
	}else {
		$error= 'Необходимо ввести ключевые слова! <br />';
		return $error;
	}
}
}
?>