<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 

if (isset($_FILES['frm_img']) && $_FILES['frm_img']['error'] == 0) {
    //check extension
    $type = "";
    if ($_FILES['frm_img']['type'] == 'image/jpeg' || $_FILES['frm_img']['type'] == 'image/pjpeg') {
        $type = "jpeg";
    } elseif ($_FILES['frm_img']['type'] == 'image/png') {
        $type = "png";
    } elseif ($_FILES['frm_img']['type'] == 'image/gif') {
        $type = "gif";
    }
    if ($type) {
        //lets rock
        list($width, $height) = getimagesize($_FILES['frm_img']['tmp_name']);
        
        $x_ratio = $width / $FRIMG_WIDTH;
        $y_ratio = $height / $FRIMG_HEIGHT;
        if($x_ratio>$y_ratio) {
            $newheight=floor($height/$x_ratio);
            $newwidth=$FRIMG_WIDTH;
            $xcoord=0;
            $ycoord=floor(($FRIMG_HEIGHT-$newheight)/2);
        } else {
            $newheight=$FRIMG_HEIGHT;
            $newwidth=floor($width/$y_ratio);
            $xcoord=floor(($FRIMG_WIDTH-$newwidth)/2);
            $ycoord=0;        
        }
                
        $func = "imagecreatefrom" . $type;
        $source = $func($_FILES['frm_img']['tmp_name']);
        $dest = imagecreatetruecolor($FRIMG_WIDTH, $FRIMG_HEIGHT);
        imagefill($dest, 0, 0, $FRGB);
        imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
        $imgname=time();
        //echo $imgname;
        $func = "image" . $type;
        $func($dest, "uploaded/front/$imgname.$type");
        //echo "<a href='' onclick='window.open(\"".$GLOBALS['PATH']."/uploaded/front/".$imgname.".".$type."\",\"img\")'>посмотреть</a>";
                
        /////////////////small

        $x_ratio = $width / $FRIMG2_WIDTH;
        $y_ratio = $height / $FRIMG2_HEIGHT;
        if($x_ratio>$y_ratio) {
            $newheight=floor($height/$x_ratio);
            $newwidth=$FRIMG2_WIDTH;
            $xcoord=0;
            $ycoord=floor(($FRIMG2_HEIGHT-$newheight)/2);
        } else {
            $newheight=$FRIMG2_HEIGHT;
            $newwidth=floor($width/$y_ratio);
            $xcoord=floor(($FRIMG2_WIDTH-$newwidth)/2);
            $ycoord=0;        
        }
                
        $func = "imagecreatefrom" . $type;
        //$source = $func($_FILES['frm_img']['tmp_name']);
        $dest = imagecreatetruecolor($FRIMG2_WIDTH, $FRIMG2_HEIGHT);
        imagefill($dest, 0, 0, $FRGB);
        imagecopyresampled($dest, $source, $xcoord, $ycoord, 0, 0, $newwidth, $newheight, $width, $height);
        //$imgname=time();
        //echo $imgname;
        $func = "image" . $type;
        $func($dest, "uploaded/front/small_$imgname.$type");    
        //echo " <a href='' onclick='window.open(\"".$GLOBALS['PATH']."/uploaded/front/small_".$imgname.".".$type."\",\"img\")'>small</a>";
        $title=($_POST['title'])?mysql_real_escape_string($_POST['title']):"";
        mysql_query("INSERT INTO ".$PREFIX."frontpage SET name='$imgname.$type', title='".$title."',url='".$_POST['url']."',type='image'");
    }
}
if($_POST['del']??'') {
    mysql_query("delete from ".$PREFIX."frontpage where name='".$_POST['del']."'");
    unlink("uploaded/front/".$_POST['del']);
    unlink("uploaded/front/small_".$_POST['del']);
}
if($_POST['change']??'') {
    foreach($_POST['position'] as $name=>$value){
        $display=($_POST['display'][$name]==1)?1:0;
        $url=$_POST['url'][$name];
        mysql_query("update ".$PREFIX."frontpage set position=$value, display=$display,url='".$url."' where name='$name'");
    }

}
$res = mysql_query("SELECT name,title,position,display,url from ".$PREFIX."frontpage where type='image' ORDER BY position");
$front="<form method=\"post\"><table class='table table-striped responsive-utilities jambo_table bulk_action'><tr><td>Изображение</td><td>Название</td><td>Порядок</td><td>Отображать</td><td>Удаление</td></tr>";
if($res) {
    if(mysql_num_rows($res)>0) {
        while ($row = mysql_fetch_row($res)) {
            $check=($row[3]==1)?" checked":"";
            $front.="<tr style='vertical-align:top'><td rowspan=\"2\"><img src='".$PATH."/uploaded/front/small_".$row[0]."' alt='' /></td><td><b>".$row[1]."</b></td><td><input type='text' name='position[".$row[0]."]' value='".$row[2]."' size='2' /></td><td><input type='checkbox' name='display[".$row[0]."]' value='1'$check /></td><td><input style='font-size:0;border:0;cursor:pointer;width:20px;height:20px;background:url(".$PATH."/img/del.gif) no-repeat' type='submit' name='del' value='$row[0]' /></td></tr><tr><td colspan=\"4\">URL: <input type='text' name='url[".$row[0]."]' value='".$row[4]."' size='35' /></td></tr>";
        }
    }
}
$front.="<tr><td></td><td></td><td><input class='button' type='submit' name='change' value='Изменить' /></td><td></td><td></td></tr></table></form>";


// testing
//echo "++++++++testing";
$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,alias','ORDER BY id');//
//print_r($array);
//$array=$recurse->makeQuery('menu_admin','parent_id','id,text,path','ORDER BY ordering');

$select=helpFactory::activate('queries/Visitor/FormatRecursive','select');
$select->symbol="---";
//$menu_recursive->link='/admin/?component=';
$select->active_items=array(9,10,80);
$out=$select->format($recurse);
echo $out;



$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,alias,price','ORDER BY id');//
//print_r($array);
//$array=$recurse->makeQuery('menu_admin','parent_id','id,text,path','ORDER BY ordering');

$table=helpFactory::activate('queries/Visitor/FormatRecursive','table');
//$menu_recursive->symbol="---";
//$menu_recursive->link='/admin/?component=';
$out=$table->format($recurse);
echo $out;


$recurse=helpFactory::activate('queries/QueryRecursive');
$array=$recurse->makeQuery('product','pid','id,name,price','ORDER BY id');//
//print_r($array);
//$array=$recurse->makeQuery('menu_admin','parent_id','id,text,path','ORDER BY ordering');

$checkbox=helpFactory::activate('queries/Visitor/FormatRecursive','checkbox');
//$menu_recursive->symbol="---";
//$menu_recursive->link='/admin/?component=';10 81 82
$checkbox->active_items=array(10,81,82);
$out=$checkbox->format($recurse);
echo $out;

/*
function getRecursive(){
$recursive_array=prepareRecursive('product','pid','id,name','ORDER BY id');
$items=count($recursive_array[0]); //- количество элементов первого уровня

    $treeHTML['begin']='<select class="">';
    $treeHTML['end']='</select>';
    $treeHTML['beginparent']="";
    $treeHTML['elementparent']="<option class='{class}' value='{id}'>{name}</option>\r\n";
    $treeHTML['endparent']="";

    $treeHTML['blockbeginchild']='';
    $treeHTML['beginchild']="";
    $treeHTML['elementchild']="<option class='{class}' value='{id}'>{name}</option>\r\n";
    $treeHTML['endchild']="";
    $treeHTML['blockendchild']="";

$replaces=array('id','name'); //что на что заменять (поля базы)
$select='';
$select=recursiveTree(0, 0,$items,$recursive_array,$replaces,$treeHTML);
//echo $select;

print_r($select);
}
*/



//end testing




render_to_template("components/index/tpl/{$ADMIN_TEMPLATE}/banner.php", $array);
?>

<?php
echo $front;
?>
