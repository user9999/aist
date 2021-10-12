<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 

//make logout
unset($_SESSION['user_name']);
unset($_SESSION['actype']);
unset($_SESSION['percent']);
unset($_SESSION['userid']);
header("Location: ./");
?>
