<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/configuration.php");
//include("func.php");
session_start();
$userid = $_SESSION['userid'];

$arr=explode('#', strtolower($_POST['specCase']));
  $allowed = explode(',', $arr[0]);
$way=$arr[1];
  $way_arr=explode('/', $way);

if (isset($_FILES['upl']) && $_FILES['upl']['error'] == 0) {
    $extension = strtolower(pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowed)) {
        echo '{"status":"error"}';
        exit;
    }
    //////////////////////////////////////////////////////
    if ($extension=='jpeg') {
        $extension='jpg';
    }
    $namef=$_FILES['upl']['name'];

    mysql_query("insert into kvn_files(ext,tbl,pid,name) values('$extension','$way','$userid','$namef');");
    $id=mysql_insert_id();

    $cat = $_SERVER['DOCUMENT_ROOT'].'/uploaded';
    foreach ($way_arr as $value) {
        if (!is_dir($cat.'/'.$value)) {
            mkdir($cat.'/'.$value, 0777, true);
        }
        $cat.='/'.$value;
    }

   
    if (move_uploaded_file($_FILES['upl']['tmp_name'], $cat."/$id.$extension")) {
        //if(in_array($extension, $allowed2)){
        //gen_icon_galery_ALL("$id.$extension",'290','217');
        //}
    
        echo '{"status":"success"}';
        exit;
    }
}

echo '{"status":"error"}';
exit;
