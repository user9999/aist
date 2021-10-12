<?php 
if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 

//make logout
if(!$_SESSION['development']){
   $_SESSION['development']=1; 
   header("Location: ./admin/?component=installator");
}else{
   unset($_SESSION['development']); 
   header("Location: ./admin/?component=index");
}

?>