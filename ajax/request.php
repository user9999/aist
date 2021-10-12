<?php
//ini_set('error_reporting', E_ALL & ~E_NOTICE);
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
require_once "../inc/configuration.php";
require_once "../inc/functions.php";
if(strpos($_POST['from_url'],$_SERVER[HTTP_HOST])!==false){
    $name = ($_POST['name'])?mysql_real_escape_string($_POST['name']):'';
    $phone = ($_POST['phone'])?mysql_real_escape_string($_POST['phone']):'';
    $email = ($_POST['email'])?mysql_real_escape_string($_POST['email']):'';
    $theme = ($_POST['theme'])?mysql_real_escape_string($_POST['theme']):'';
    $message = ($_POST['message'])?mysql_real_escape_string($_POST['message']):'';
    $file = ($_POST['file'])?mysql_real_escape_string($_POST['file']):'';
    $type = ($_POST['type'])?mysql_real_escape_string($_POST['type']):'';
    $from_url = ($_POST['from_url'])?mysql_real_escape_string($_POST['from_url']):'';
    $date=time();
    echo $query;
    $query="INSERT INTO ".$GLOBALS[PREFIX]."messages SET name='{$name}',phone='{$phone}',email='{$email}',theme='{$theme}',message='{$message}',file='{$file}',type='{$type}',from_url='{$from_url}',date='{$date}'";
    mysql_query($query);
    echo "Спасибо ".$name.". Ваше сообщение получено.";die();
}else{
    echo "Ошибка отправки сообщения.";
}
?>