<?php if (!defined("ADMIN_SIMPLE_CMS")) { die("Access denied");
} ?>
<?php
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM ".$PREFIX."menu WHERE id='{$_GET['del']}'");
    header("Location: ?component=menu"); 
}

if (isset($_GET['edit'])) {
    $res=mysql_query("SELECT * FROM ".$PREFIX."menu WHERE id='{$_GET['edit']}'");
    if ($row=mysql_fetch_row($res)) {
        $tbl_text=$row[1];
        $tbl_path=$row[2];
        $tbl_order=$row[3];
        $editid=$row[0];
    }
}

if (isset($_POST['frm_name']) && isset($_POST['frm_path'])) {
    $frm_name=$_POST['frm_name'];
    $frm_path=$_POST['frm_path'];
    $frm_order=$_POST['frm_order'];
    $frm_parent=$_POST['frm_parent'];
    
    if($frm_parent==0) {
        $level=1;
    } else {
        $res=mysql_query("select level from ".$PREFIX."menu where id=".$frm_parent." limit 1");
        $row = mysql_fetch_row($res);
        $parent_level=$row[0];
        $level=$parent_level+1;
    }
    if (!$_POST['editid']) {
        mysql_query("INSERT INTO ".$PREFIX."menu SET text='$frm_name', path='$frm_path', ordering='$frm_order',parent=$frm_parent,level=$level");
    } else {
        mysql_query("UPDATE ".$PREFIX."menu SET text='$frm_name', path='$frm_path', ordering='$frm_order',parent=$frm_parent,level=$level WHERE id={$_POST['editid']}");
    }
    header("Location: ?component=menu");
}


$sections=array();
///1
$res = mysql_query("SELECT MAX(level) FROM ".$PREFIX."menu");
$row=mysql_fetch_row($res);
if($row[0]!==null) {//mysql_num_rows($res)>0
    //$row=mysql_fetch_row($res);
    $max=$row[0];
    //echo $max."---";
    $t="";
    for($i=1;$i<=$max;$i++){
        $t.="t$i.level AS level$i,t$i.id AS id$i,t$i.text AS text$i,t$i.path AS path$i,";
        if($i>1) {
            $join.=" LEFT JOIN ".$PREFIX."menu AS t$i ON t$i.parent = t".($i-1).".id";
        }
    }
    $t=substr($t, 0, -1);
    $query="SELECT ".$t." FROM ".$PREFIX."menu as t1".$join." where t1.parent=0";
    $res = mysql_query($query);
    //echo $query."<br>";
    //$cols=4;
    $options='';
    $ar=array();
    while($row=mysql_fetch_row($res)){
        $str="---";$val1='';
        if($row[0]==1) {
            foreach($row as $num=>$val){
        
                if($val==null) {
                    break;
                }

                if($num%4==0) {
                    $otst=str_repeat($str, $val);
                    $level=$val;
                }
                if($num%4==1) {
                    $flag=0;
                    if(!in_array($val, $ar)) {
                         $selected=($val==$tbl_parent)?"selected":"";
                         $options.="<option class=level$level value=$val $selected>";
                         $link="<a href='?component=catalog&action=1&edit=$val'>[редактировать]</a> <a href='?component=catalog&action=1&del=$val'>[удалить]</a>";
                         $ar[]=$val;
                         $flag=1;
                    }
                }
                if($num%4==2) {
                    if($flag==1) {
                        $options.=$otst.$val."</option>\n";
                        $title=mb_substr($val, 0, 40, 'UTF-8')."..";//$val;//
                    }
                }
                if($num%4==3) {
                    $val1.=$val."/";
                    if($flag==1) {

                        $valr=substr($val1, 0, -1);
                        $sections[1].="<div class=clear><div class='sec_title'>".$otst.$title. "</div> <div class='alias'>" .$val. "</div><div class='priceid'>$valr</div><div class=links>".$link."</div></div>";

                    } else {

                    }
                }

            }

        }
    }

}



?>

<h1>Меню</h1>
 
<form method="post">
    <table width="100%">
        <tr>
            <td width="120">Пункт меню:</td><td><input class="textbox" name="frm_name" type="text" size="50" value="<?php echo $tbl_text?>"></td>
        </tr>
        <tr>
            <td width="120">Родитель</td><td>
        <select name=frm_parent>
    <option value=0>корень</option>
    <?php echo $options; ?>
    </select>
    </td>
        </tr>
        <tr>
            <td width="120">Путь:</td><td><input class="textbox" name="frm_path" type="text" size="50" value="<?php echo $tbl_path?>"></td>
        </tr>
        <tr>
            <td width="120">Порядок:</td><td><input class="textbox" name="frm_order" type="text" maxlength="1" size="10" value="<?php echo $tbl_order?>"></td>
        </tr>
        <tr>
            <td></td><td><input type='hidden' name='editid' value='<?php echo $editid?>'><input type="submit" class="button" value="Сохранить"></td>
        </tr>
    </table>
</form>
<br />
<br />
<h1>Существующие пункты меню</h1>
<?php
$res=mysql_query("SELECT * FROM ".$PREFIX."menu ORDER BY ordering, id");
$num=0;
while ($row=mysql_fetch_row($res)) {
    $num++;
    echo $row[1]." <a href='?component=menu&edit={$row[0]}'>[редактировать]</a> <a href='?component=menu&del={$row[0]}'>[удалить]</a><br />";
}
if ($num==0) { echo "Пункты не добавлены";
}
?>
