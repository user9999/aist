<?php
require_once("vars.class.php");
class mysql extends vars{
    var $host = "localhost"; 
    var $user = "redheaddaddy";
    var $pass = "2011orange";
    var $db = "redheaddaddy_tests";
    var $id;
    var $query_result;
    var $query_str;
    var $sql_err;
    function connect(){
        $this->id=mysql_connect($this->host,$this->user,$this->pass);
	mysql_select_db($this->db);
    }
    function ms_query(){
        $this->query_result=mysql_query($this->query_str);
    }
    function ms_close(){
        mysql_close($this->id);
    }
}
?>
