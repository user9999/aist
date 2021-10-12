<?php if (!defined("ADMIN_SIMPLE_CMS")) {
    die("Access denied");
} ?>

<?php
$display=($_SESSION['development']==1)?"":"WHERE display=1 ";
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('menu_admin', 'parent_id', 'id,text,path', $display.'ORDER BY ordering');
$menu_recursive=helpFactory::activate('queries/Visitor/FormatRecursive');
$treeHTML['begin']='<ul class="nav side-menu">';
$treeHTML['end']='</ul>';
$treeHTML['beginparent']="<li>";
$treeHTML['elementparent']="<a href='/admin/?component={path}'> {text} </a> <span style='display:none' class='fa fa-chevron-down'></span>";
$treeHTML['endparent']="</li>\r\n";
$treeHTML['blockbeginchild']='<ul class="nav child_menu" style="display: none">';
$treeHTML['beginchild']="<li>";
$treeHTML['elementchild']="<a href='/admin/?component={path}'>{text}</a>";
$treeHTML['endchild']="</li>\r\n";
$treeHTML['blockendchild']="</ul>";
$menu_recursive->treeHTML=$treeHTML;
$menu_recursive->link='/admin/?component=';
$out=$menu_recursive->format($recurse);
echo $out;
/*
$recursive_array=prepareRecursive('menu_admin','parent_id','id,text,path','ORDER BY ordering');

$items=count($recursive_array[array_key_first($recursive_array)]);

    $treeHTML['begin']='<ul class="nav side-menu">';
    $treeHTML['end']='</ul>';
    $treeHTML['beginparent']="<li>";
    $treeHTML['elementparent']="<a href='/admin/?component={path}'> {text} </a> <span style='display:none' class='fa fa-chevron-down'></span>";
    $treeHTML['endparent']="</li>\r\n";

    $treeHTML['blockbeginchild']='<ul class="nav child_menu" style="display: none">';
    $treeHTML['beginchild']="<li>";
    $treeHTML['elementchild']="<a href='/admin/?component={path}'>{text}</a>";
    $treeHTML['endchild']="</li>\r\n";
    $treeHTML['blockendchild']="</ul>";

$replaces=array('class','path','text');
$menu='';
//$recursive_menu='';
$menu=recursiveTree(0, 0,$items,$recursive_array,$replaces,$treeHTML);
echo $menu;
*/
//$a=get_defined_vars();
//print_r($recursive_menu);

//echo $menu;



?>
