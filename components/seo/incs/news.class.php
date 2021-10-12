<?php
require_once('mysql.class.php');
class blocknews extends mysql{
	function block($tbl){
		$this->connect();
		$this->query_str="select * from ".$tbl." order by id DESC limit 20";
		$this->ms_query();
		while($ten=mysql_fetch_row($this->query_result)){
			$news.="<b style=\"margin-left:20px\"><a href=\"".$tbl.".php?nid=".$ten[0]."\">".stripslashes($ten[2])."</a></b><p style=\"text-indent:16px;margin-left:8px\"><b>".$ten[1]."</b><br /> - ".stripslashes($ten[3])."...</p><p style=\"margin-left:20px\"><a href=\"".$tbl.".php?nid=".$ten[0]."\">Читать полностью &gt;&gt;&gt;</a></p>";
		}
		$this->ms_close();
		return $news;
	}
}
?>