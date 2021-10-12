<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 

require_once 'inc/ckeditor/ckeditor.php' ;
require_once 'inc/ckfinder/ckfinder.php' ;
$ckeditor = new CKEditor();
$ckeditor->basePath    = 'inc/ckeditor/' ;
CKFinder::SetupCKEditor($ckeditor, 'inc/ckfinder/');

$table=helpFactory::activate('html/Table');
$check=array('title'=>'название','path'=>'alias');
$actions=array("/admin/?component=static&edit="=>"id","/admin/?component=static&del="=>"id");
$table->setType('flex');
//$a=get_defined_vars();
//print_r(array_keys(get_defined_vars()));
//print_r($a);die();
//delete static page
if (isset($_GET['del'])) {
    mysql_query("DELETE FROM ".$PREFIX."static WHERE id='{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."url WHERE cmsurl='static /{$_GET['del']}'");
    mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='static'");
    header("Location: ?component=static"); 
}

//edit static page
if (isset($_GET['edit'])) {
    $res = mysql_query("SELECT * FROM ".$PREFIX."static WHERE id='{$_GET['edit']}'");
    if ($row = mysql_fetch_row($res)) {
        $tbl_path = $row[1];
        $res1 = mysql_query("SELECT * FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['edit']}' and table_name='static'");
        //echo "SELECT * FROM static WHERE rel_id='{$_GET['edit']}' and table_name='static'";
        while($row1=mysql_fetch_assoc($res1)){
            $tbl_name[$row1['language']] = $row1['title'];
            $tbl_text[$row1['language']] = $row1['content'];
            $tbl_keywords[$row1['language']] = $row1['keywords'];
            $tbl_meta_description[$row1['language']] = $row1['description'];
        }

        $editid = $row[0];
    }
    $query="SELECT * FROM ".$PREFIX."url WHERE cmsurl='static/{$_GET['edit']}' LIMIT 1";
    $result = mysql_query($query);
    $row=mysql_fetch_row($result);
    $tbl_url=$row[0];
}

//add new static page
if (isset($_POST['frm_name']) && isset($_POST['frm_path'])) {

    $frm_name = $_POST['frm_name'];
    
    $frm_path = preg_replace("/[^a-z0-9-]/", "", $_POST['frm_path']);
    $frm_text=$_POST['frm_text'];
    
    $frm_keywords = $_POST['frm_keywords'];
    $frm_meta_description = $_POST['frm_meta_description'];
    $frm_url= mysql_real_escape_string($_POST['frm_url']);
    if (strlen($frm_path) >= 3) {
        //$frm_text = mysql_escape_string($_POST['frm_text']);
        if (!$_POST['editid']) {
            if(chpu_check($frm_url)=='add'){
                $query="INSERT INTO ".$PREFIX."static SET  path='$frm_path',title='".mysql_escape_string($frm_name[$DLANG])."',text='".mysql_escape_string($frm_text[$DLANG])."',keywords='".htmlspecialchars($frm_keywords[$DLANG])."',meta_description='".htmlspecialchars($frm_meta_description[$DLANG])."'";
            //echo $query;
                mysql_query($query);
                $static_id=mysql_insert_id();
                $query="INSERT INTO ".$PREFIX."url SET url='{$frm_url}',component='static',cmsurl='static/{$static_id}'";
                mysql_query($query);
                foreach($frm_name as $lang=>$name){
                    mysql_query("INSERT INTO ".$PREFIX."lang_text SET table_name='static', rel_id=$static_id, language='$lang', title='$name' , `content`='".mysql_escape_string($frm_text[$lang])."',`description`='".htmlspecialchars($frm_meta_description[$lang])."',`keywords`='".htmlspecialchars($frm_keywords[$lang])."',pub_date='".time()."'");
                }
            }else{
                $error="Такой url уже есть в базе";
                echo $error;
            }
            
        } else {
            //var_dump(chpu_check($frm_url,'static/'.$_POST['editid']));
            if(chpu_check($frm_url,'static/'.$_POST['editid'])!='exists'){
                if(chpu_check($frm_url,'static/'.$_POST['editid'])=='update'){
                    $query="UPDATE ".$PREFIX."url SET url='{$frm_url}' WHERE cmsurl='static/{$_POST['editid']}'";
                }else{
                    $query="INSERT INTO ".$PREFIX."url SET url='{$frm_url}',component='static',cmsurl='static/{$_POST['editid']}'";
                }
                //$query="UPDATE ".$PREFIX."url SET url='{$frm_url}' WHERE cmsurl='static/{$_POST['editid']}'";
                //echo $query;die();
                mysql_query($query);//die();
                
                $query="UPDATE ".$PREFIX."static SET  path='$frm_path',title='".mysql_escape_string($frm_name[$DLANG])."',text='".mysql_escape_string($frm_text[$DLANG])."',keywords='".htmlspecialchars($frm_keywords[$DLANG])."',meta_description='".htmlspecialchars($frm_meta_description[$DLANG])."' where id={$_POST['editid']}";
                //echo $query;
                mysql_query($query);
                foreach($frm_name as $lang=>$name){
                    $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$_POST['editid']} and table_name='static' and language='{$lang}'");
                    if(mysql_num_rows($res)>0) {
                        mysql_query("UPDATE ".$PREFIX."lang_text SET   title='$name' , `content`='".mysql_escape_string($frm_text[$lang])."',`description`='".htmlspecialchars($frm_meta_description[$lang])."',`keywords`='".htmlspecialchars($frm_keywords[$lang])."',pub_date='".time()."' where rel_id={$_POST['editid']} and table_name='static' and language='$lang'");
                    } else {
                        mysql_query("INSERT INTO ".$PREFIX."lang_text SET table_name='static', rel_id={$_POST['editid']}, language='$lang', title='$name' , `content`='".mysql_escape_string($frm_text[$lang])."',`description`='".htmlspecialchars($frm_meta_description[$lang])."',`keywords`='".htmlspecialchars($frm_keywords[$lang])."',pub_date='".time()."'");
                    }
                }
            }else{
                $error="Такой url уже есть в базе";
                echo $error;
            }
        }
        header("Location: ?component=static");
    } else { echo "<b>Ошибка.</b> Минимальная длина пути - 3 символа";
    }
}
?>

<h1>Статичные страницы</h1>
<form method="post">
    <table width="100%">
    <caption>Для добавления вкладки использовать {tab имя-вкладки} в конце {/tabs}</caption>
<?php
if($MY_URL==1){
?>
        <tr>
            <td>URL:</td><td><input class="textbox translitto" name="frm_url" type="text" style="width: 100%;" value="<?php echo $tbl_url??'' ?>"></td>
        </tr>  
<?php
}
?>
        <tr>
            <td>Путь:</td><td><input class="textbox translitto" name="frm_path" type="text" style="width: 100%;" value="<?php echo $tbl_path??'' ?>"></td>
        </tr>
 <?php
    foreach($LANGUAGES as $lang=>$path){
        ?>
        <tr>
            <td colspan=2 class="lang_row">Язык : <?php echo $lang ?></td>
        </tr>        
        <tr>
            <td width="200">Название:</td><td><input class="textbox" id="name_<?php echo $lang ?>" name="frm_name[<?php echo $lang ?>]" type="text" style="width: 100%;" value="<?php echo $tbl_name[$lang]??'' ?>"></td>
        </tr>

        <tr>
            <td colspan="2"><textarea name="frm_text[<?php echo $lang ?>]" class="ckeditor" id="editor_ck[<?php echo $lang ?>]"><?php echo $tbl_text[$lang]??'' ?></textarea></td>
        </tr>
        <tr>
            <td>Описание (мета):</td><td><input class="textbox" name="frm_meta_description[<?php echo $lang ?>]" type="text" style="width: 100%;" value="<?php echo $tbl_meta_description[$lang]??'' ?>"></td>
        </tr>
        <tr>
            <td width="200">Ключевые слова (мета):</td><td><input class="textbox" name="frm_keywords[<?php echo $lang ?>]" type="text" style="width: 100%;" value="<?php echo $tbl_keywords[$lang]??'' ?>"></td>
        </tr>
        <tr> 
            <td colspan="2" align="right"><br /><input type='hidden' name='editid' value='<?php echo $editid??'' ?>'><input type="submit" class="button" value="Сохранить"></td>
        
    
    <script type="text/javascript">//<![CDATA[
    window.CKEDITOR_BASEPATH='inc/ckeditor/';
    //]]></script>
    <script type="text/javascript" src="inc/ckeditor/ckeditor.js?t=B1GG4Z6"></script>
    <script type="text/javascript">//<![CDATA[
    CKEDITOR.replace('editor_ck[<?php echo $lang ?>]', { "filebrowserBrowseUrl": "\/inc\/ckfinder\/ckfinder.html", "filebrowserImageBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Images", "filebrowserFlashBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Flash", "filebrowserUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files", "filebrowserImageUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images", "filebrowserFlashUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash" });
    //]]></script>
    </tr>

    
        <?php
    }    
    ?>
</table>
</form>
<br />
<br />
<h1>Существующие страницы</h1>
<?php
$res = mysql_query("SELECT * FROM ".$PREFIX."static");
$num = 0;
while ($row = mysql_fetch_row($res)) {
    $res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='static' and rel_id={$row[0]} and (language='en' or language='ru')");
    while($row1=mysql_fetch_row($res1)){
        $tt=$row1[0];
        break;
    }
    $num++;
    //echo ($tt??'null') . " (" . $row[1] . ") <a href='?component=static&edit={$row[0]}'>[редактировать]</a> <a href='?component=static&del={$row[0]}'>[удалить]</a><br />";
}
$result=$table->makeTable('static', $check, "admin static", $actions, true);
if ($num == 0) { echo "Страницы не добавлены";
}
?>
