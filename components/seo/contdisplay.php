<?php
require_once("mysql.class.php");
class contdisplay extends mysql{
	function display($amount=0,$sid=0,$session=false){
		$amount=($amount==0)?'':' limit '.$amount;
		$qid=($sid==0)?'':' and id!='.$sid;
		$this->connect();
		$this->query_str="select id,id_user,url,context,price,click,numshow from context where paid='1'".$qid." and (click>0 or numshow>0) order by price desc".$amount;
		$this->ms_query();
		$html="<div class=\"system\"><a href=\"".$this->PATH_HTTP."context.php?act=ord\">Заказать</a></div>";
		while($links=mysql_fetch_row($this->query_result)){
			if($links[4]>0){
				$href="href=\"".$this->PATH_HTTP."open.php?id=".$links[0]."\"";
			} else {
				$href="href=\"".stripslashes($links[2])."\"";
				$ids.=" id=".$links[0]." or";
			}
			$qstat.="(NULL,".$links[0].",'0','".$_SERVER['REMOTE_ADDR']."','".$_SERVER['HTTP_REFERER']."',now()),";
			$html.="<p class=\"pcontext\"><a ".$href." target=\"_blank\">".stripslashes($links[3])." &gt;&gt;&gt;</a></p>";
		}
		$qids=substr($ids,0,strlen($ids)-3);
		$this->query_str="update context set numshow=numshow-1 where".$qids;
		$this->ms_query();
		$querystat=substr($qstat,0,strlen($qstat)-1);
		$this->query_str="insert into contextstat values".$querystat;
		$this->ms_query();
		if($sid!=0 && $session!=false){
			$this->query_str="update context set numshow=numshow+1 where id=".$sid;
			$this->ms_query();
		}
		if($amount!=''){
			$html.="<div class=\"system\" style=\"padding-bottom:4px\"><a href=\"".$this->PATH_HTTP."context.php?act=links\">Все ссылки</a></div>";
		}
		$this->ms_close();
		return $html;
	}
}

?>