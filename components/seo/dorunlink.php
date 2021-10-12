<?php
set_time_limit(40);
require_once ('JsHttpRequest.class.php');
$JsHttpRequest =& new JsHttpRequest("windows-1251");
if(strlen($_REQUEST['q'])==16){
	function delfiles($fld){
		$hdl=opendir($fld); 
		while ($file = readdir($hdl)) {
			if (($file!=".")&&($file!="..")) {
				if (is_dir($fld."/".$file)==True) {
					delfiles ($fld."/".$file); rmdir ($fld."/".$file); 
				}else {
					unlink ($fld."/".$file); 
				} 
			} 
		}
		closedir($hdl);
	}
	sleep(30);
	delfiles("./out/".$_REQUEST['q']);
	rmdir("./out/".$_REQUEST['q']);
}
?>