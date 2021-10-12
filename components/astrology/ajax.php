<?php
error_reporting(0);

header("Content-type: text/plain; charset=utf-8");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Connection: close");

if (!count($_POST)) die('0|Неверный запрос');
$data = array();
foreach ($_POST as $k => $v) $data[] = $k.'='.$v;
echo implode('&', $data)."\nПривет с домена ".$_SERVER['SERVER_NAME'].'!';
exit;
?>