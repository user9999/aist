<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 

//default values
$arr[0] = "templates/blank/template.php - основной файл шаблона";
$arr[1] = "templates/blank/style.css - файл стиля шаблона";
foreach (glob("components/*/template.*.php") as $filename) {
    $arr[] = $filename;
}

//editing
if (isset($_POST['frm_text']) && isset($_POST['frm_path'])) {
    $mpath = trim($_POST['frm_path']);
    if ($handle = fopen($mpath, 'w')) {
        fwrite($handle, trim($_POST['frm_text']));
    }
    fclose($handle);
    $_POST['frm_select'] = $mpath;
}

$path = "templates/blank/template.php";
$fcontents = file_get_contents("templates/blank/template.php");

//starting to edit
if (isset($_POST['frm_select'])) {
    $path = trim($_POST['frm_select']);
    $fcontents = file_get_contents($path);
}

require "template.tpleditor.php";
?>
