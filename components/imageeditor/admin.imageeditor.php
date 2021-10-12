<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 

//default values
foreach (glob("{img/*/*.jpg,img/*/*.gif,img/*.jpg,templates/*/img/*.jpg,templates/*/img/logo/*.jpg,templates/*/img/logo/*.gif,img/icons/*/*.jpg}", GLOB_BRACE) as $filename) {
    $arr[] = $filename;
}
$path = $arr[0];

//editing
if (isset($_POST['frm_path'])) {
    $path = trim($_POST['frm_path']);

    //adding tags
    if (isset($_POST['frm_tags'])) {
        $tags = trim(mysql_escape_string($_POST['frm_tags']));
        mysql_query("DELETE FROM ".$PREFIX."imagealt WHERE path = '$path'");
        mysql_query("INSERT INTO ".$PREFIX."imagealt SET path = '$path', alt = '$tags'");
    }
    
    //replacing picture
    if ($_FILES['frm_imagereplace']['tmp_name']) {
        unlink($path);
        move_uploaded_file($_FILES['frm_imagereplace']['tmp_name'], $path);
    }
    $_POST['frm_select'] = $path;
}

//starting to edit (selecting)
if (isset($_POST['frm_select'])) {
    $path = trim($_POST['frm_select']);
}

$tags = "";
$res = mysql_query("SELECT alt FROM ".$PREFIX."imagealt WHERE path = '$path'");
if ($row = mysql_fetch_row($res)) {
    $tags = $row[0];
}

require "template.imageeditor.php";
?>
