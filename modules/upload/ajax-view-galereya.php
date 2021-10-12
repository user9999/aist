<?php
include($_SERVER['DOCUMENT_ROOT']."/inc/configuration.php");
  session_start();
$cuserid=$_SESSION['userid'];
if ($cuserid) {
    $way=trim(strip_tags($_GET['way']));
    $prPrint='';
    $files = scandir($_SERVER['DOCUMENT_ROOT'].'/uploaded/'.$way);

    foreach ($files as $value) {
        $delImg = '<font style="float:left;">x</font>';
        if ($value != '.' && $value != '..') {
            $prPrint.='<img alt="" src="uploaded/'.$way.'/'.$value.'" alt="" title="" style="float:left;width:50px;">'.$delImg;
        }
    }

    $prPrint.='<div style="clear:both;">';
    echo $prPrint;
}
