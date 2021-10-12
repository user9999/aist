<?php if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
if(file_exists($HOSTPATH."/inc/gallery.config.php")) {
    include_once $HOSTPATH."/inc/gallery.config.php";
}
set_title($GLOBALS['dblang_gallery'][$GLOBALS['userlanguage']]);
render_to_template("components/gallery/tpl/controls.php", array());
$res=mysql_query('select * from '.$PREFIX.'gallery where display=1 order by date,position');
while($row=mysql_fetch_assoc($res)){
    render_to_template("components/gallery/tpl/images.php", $row);
}
render_to_template("components/gallery/tpl/script.php", array());
?>
