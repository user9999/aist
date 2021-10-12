<?php
require_once "mysql.class.php";
class dbquery extends mysql{
	function add_user(){
		$this->connect();
		$this->query_str="insert into user values(NULL,'".$_POST['login']."','".$_POST['pass']."','".$_POST['email']."')";
		$this->ms_query();
		$this->ms_close();
	}
	function del_user(){
		$this->connect();
		foreach($_POST['del'] as $id=>$value){
			$this->query_str="delete from user where id=".$id;
			$this->ms_query();
		}
		$this->ms_close();
	}
	function update_user(){
		$this->connect();
		$this->query_str="update user set login='".$_POST['login']."', pass='".$_POST['pass']."', email='".$_POST['email']."' where id=".$_POST['id'];
		$this->ms_query();
		$this->ms_close();
	}
	function select_user($dis="",$id="",$act=""){
		if($id!=""){
			foreach($id as $key=>$val){
				$nid.=$key;
			}
			$id=" where id=".$nid;
		}
		$this->connect();
		$this->query_str="select * from user".$id;
		$this->ms_query();
		$this->ms_close();
		if($act!=""){

				while($data=mysql_fetch_assoc($this->query_result)){
					foreach($data as $key=>$value){
					$target['--'.$key.'--']=$value;
					}
				}

		} else {
			$cl=0;
			while($data=mysql_fetch_assoc($this->query_result)){
				
				$target.=($cl==0)?("<tr class=\"dark\">"):("<tr class=\"light\">");
				$d="";
				foreach($data as $key=>$value){
					//$target['--'.$key.'--']=$value;
					$dis=eregi_replace("<!--".$key."-->",$value,$dis);
				}
				$target.=$d.$dis."\r\n";
				/*
				for($i=1;$i<count($data);$i++){
					$d.="<td>".$data[$i]."</td>\r\n";
				}
				$target.=$d."<td><input type=\"submit\" name=\"del[".$data[0]."]\" value=\"Удалить\" /><input type=\"submit\" name=\"edit[".$data[0]."]\" value=\"Редактировать\" /></td></tr>\r\n";
				*/
				$cl=($cl==0)?1:0;
			}
		}
		return $target;
	}
	function search_user(){
		$search="login like '%".$_POST['line']."%' or pass like '%".$_POST['line']."%' or email like '%".$_POST['line']."%'";
		$this->connect();
		$this->query_str="select * from  user where ".$search;
		$this->ms_query();
		$this->ms_close();
		while($data=mysql_fetch_row($this->query_result)){
			$target.="<tr>";
			for($i=1;$i<count($data);$i++){
				$d.="<td>".$data[$i]."</td>";
			}
			$target.=$d."<td><input type=\"submit\" name=\"del[".$data[0]."]\" value=\"Удалить\" /><input type=\"submit\" name=\"edit[".$data[0]."]\" value=\"Редактировать\" /></td></tr>";
		}
		return $target;
	}
}
?>