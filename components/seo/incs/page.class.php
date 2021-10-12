<?php
require_once("vars.class.php");
class page extends vars{
    	function read_content($path,$target){
        	if(file_exists($this->path_html.$path)){
	    		$cont=file($this->path_html.$path);
	    		$content.=implode("",$cont);
	    		//var_dump(debug_backtrace()); die();
		}
		trim($content);
		if($target!=""){
	    		foreach($target as $targ=>$sub){
	        		$content=str_replace($targ,$sub,$content);
	    		}
		}
		return $content;
    	}
	function replace_file($path,$target,$data=""){
        	if(file_exists($this->path_html.$path)){
	    		$cont=file($this->path_html.$path);
	    		$content.=implode("",$cont);
		}
		$files=explode(",",$target);
		foreach($files as $f){
			if(strstr($f,"content")===false){//if(!eregi("content",$f)){
	  			if(file_exists($this->path_html.$f.".tpl")){
	    				$repl=file($this->path_html.$f.".tpl");
	    				$replace=implode("",$repl);
	    				trim($replace);
	    				trim($content);
	    				$content=str_replace("<!--".$f."-->",$replace,$content);
				}
			} else {
				preg_match_all("!(#)([a-z0-9_/]+)$!i",$f,$html);
				if(file_exists($this->path_html.$html[2][0].".tpl")){
	    				$repl=file($this->path_html.$html[2][0].".tpl");
	    				$replace=implode("",$repl);
	    				trim($replace);
	    				trim($content);
	    				$content=str_replace("<!--content-->",$replace,$content);
				}
			}
		}
		if($data!=""){
	    		foreach($data as $targ=>$sub){
	        		$content=str_replace($targ,$sub,$content);
	    		}
			$content=preg_replace("#<!--([a-z0-9_/])+-->#i","",$content);
			$content=preg_replace("#--([a-z0-9_/])+--#i","",$content);
		}
		trim($content);
		//var_dump(debug_backtrace()); die();
		return $content;

    	}
    			
}
?>
