<?php
require "../inc/configuration.php";
require_once "../inc/functions.php";
session_start();
if($_SESSION['admin_name']) {
    if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }
    else {
        $path=preg_replace('/[^A-Za-z0-9\-_]/', '', $_POST['path']);//;
        if(!is_dir($HOSTPATH.'/uploaded/'.$path.'/')){
            mkdir($HOSTPATH.'/uploaded/'.$path.'/');
        }
        $currentdir=date("y-m-d",time());
        if(!is_dir($HOSTPATH.'/uploaded/'.$path.'/'.$currentdir)){
            mkdir($HOSTPATH.'/uploaded/'.$path.'/'.$currentdir);
        }
        if(!move_uploaded_file($_FILES['file']['tmp_name'], $HOSTPATH.'/uploaded/'.$path.'/'.$currentdir.'/' . $_FILES['file']['name'])){
            throw new Exception('При загрузке изображения произошла ошибка на сервере!');
        }
        $data = ['file' => $currentdir.'/' . $_FILES['file']['name']];
        echo json_encode($data);
    }
}
?>