<?php
require_once("mysql.class.php");
class session extends mysql{
function session(){
	session_start();
}
function session_begin($login,$pass){
    if($_POST["enter"]){
        $this->connect();
	$this->query_str="select id,pass,email from user where login='$login'";

	$this->ms_query();
	$check=mysql_fetch_row($this->query_result);
	//$this->ms_close();
	//var_dump($check);
	//die();
	//if($check[2]!=''){
	    //$block=$this->warn("Ваш аккаунт заболкирован.<br /> Причина:".stripslashes($check[2])."<br />Пожалуста свяжитесь с администрацией.");
	   // return $block;
	//}
	
	if(md5($pass)==$check[1]){
		//var_dump($check);
	    $_SESSION["pass"]=$check[1];
	    $_SESSION["logged"]=$login;
	    $_SESSION["id"]=$check[0];
	    $_SESSION["ip"]=$_SERVER['REMOTE_ADDR'];
	    //$this->connect();
	    //$this->query_str="select last_date from user where id='".$check[0]."'";
	    //$this->ms_query();
	    //$check_date=mysql_fetch_row($this->query_result);
	    //if($check_date[0]!=date("Y-m-d")){
	    //    $this->query_str="update user set last_date=now() where id=".$_SESSION["id"];
	    //    $this->ms_query();
	   // }
	    //$this->ms_close() or $this->sql_err=mysql_error()."<br />";
           // header("Location: user/index.php");
        } else {
	    header("Location: ./");
	}
    }
    //elseif(!$_POST["sub"]){
    //header("Location: index.php");
    //}
	
}
    function session_check(){
        
        if(!isset($_SESSION["logged"]) || !isset($_SESSION["id"]) || $_SESSION["ip"]!=$_SERVER['REMOTE_ADDR']){
            header("Location: ../index.php");
            exit;
            }
        }
    function session_true(){
        
        if(isset($_SESSION["logged"]) && isset($_SESSION["id"]) && $_SESSION["ip"]==$_SERVER['REMOTE_ADDR']){
            return true;
            exit;
            }
        }
    function session_admin($login,$pass){
       
        if($_POST["enter"] && $_SESSION['logged']=="admin" && $login==$this->admin){
            $this->connect();
	    $this->query_str="select pass from home where id=1";
	    $this->ms_query();
	    $admin=mysql_fetch_row($this->query_result);
	    $this->ms_close();
	    if(md5($pass)===$admin[0]){
	        $_SESSION["boss"]=$login;
	        header("Location: /admin/index.php");
	    } else {
	        header("Location: ../index.php");
            }		 
	}
	    
	    	
    }
    function check_admin(){
      
        if(!isset($_SESSION["boss"]) && $_SESSION["ip"]!=$_SERVER['REMOTE_ADDR']){
            header("Location: ../index.php");
            exit;
            }
        }
}
?>
