<?php 
if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} 

//make logout
unset($_SESSION['admin_name']);
unset($_SESSION['role']);
header("Location: ./");
?>
