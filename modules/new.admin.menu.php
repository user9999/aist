<?php if (!defined("ADMIN_SIMPLE_CMS")) {
    die("Access denied");
} ?>

<?php
$display=($_SESSION['development']==1)?"":"WHERE display=1 ";
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('menu_admin','parent_id','id,text as name,path as alias',$display.'ORDER BY ordering');
$list=helpFactory::activate('queries/Visitor/FormatRecursive','list');
$list->link='/admin/?component=';
$out=$list->format($recurse);
echo $out;


?>
