<?php
if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}
//require_once($_SERVER['DOCUMENT_ROOT']."/inc/functions.php");
$script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
set_script($script);
//delete data
if (isset($_GET['del']) && isset($_GET['table'])) {
    mysql_query("DELETE FROM ".$PREFIX."".$_GET['table']." WHERE id='{$_GET['del']}'");mysql_query("DELETE FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['del']}' and table_name='".$_GET['table']."'");header("Location: ?component=static"); 
}
//edit page
if (isset($_GET['edit']) && $_GET['table']=='queries') {
    $res = mysql_query("select * from ".$PREFIX."queries WHERE id=".$_GET['edit']);
    
    if ($row = mysql_fetch_assoc($res)) {
        foreach($row as $name=>$value){
            $n="tbl_".$name;
            ${$n} = $value;
        }
        $editid = $row['id'];
        $res1 = mysql_query("SELECT * FROM ".$PREFIX."lang_text WHERE rel_id='{$_GET['edit']}' and table_name='queries'");

        while($row1=mysql_fetch_assoc($res1)){
            foreach($row1 as $name=>$value){
                $n="tbl_".$name;
                ${$n}[$row1['language']] = $value;
            }
        }
    }
}
if (isset($_POST['submit'])) {
    $rel_id=$id=intval($_POST['editid']);
    $error="";
    //var_dump($_POST);
    /*
    foreach($_POST['category'] as $id){
        $query=
        
    }
     * 
     */
    $where="id=".implode(" or id=",$_POST['category']);
    
    $query="SELECT * FROM ".$PREFIX."product WHERE {$where}";
    //echo $query;
    $result=mysql_query($query);
    while($row= mysql_fetch_array($result)){
        $url="/product/view/".$row['id'];
        $data[$url]=$row['name'];
    }
    $urls=serialize($data);

    $query="UPDATE ".$PREFIX."queries SET url='{$urls}' WHERE id=".$rel_id;
    mysql_query($query);
    //$phrase=(strlen($_POST['phrase'])>3)?mysql_real_escape_string($_POST['phrase']):$error.=$GLOBALS['dblang_ErPhrase1'][$DLANG];
    //$url=(strlen($_POST['url'])>3)?mysql_real_escape_string($_POST['url']):$error.=$GLOBALS['dblang_ErUrl1'][$DLANG];

    if($error=="") {
        
        //mysql_query("UPDATE `".$PREFIX."queries` SET phrase='{$phrase}',url='{$url}' WHERE id=$id");        foreach($_POST['stufflang'] as $num=>$language){
         /*   
            $title=mysql_real_escape_string($_POST['title'][$language]);
            $short=mysql_real_escape_string($_POST['short'][$language]);
            $content=mysql_real_escape_string($_POST['content'][$language]);
            $description=mysql_real_escape_string($_POST['description'][$language]);
            $keywords=mysql_real_escape_string($_POST['keywords'][$language]);
            $pub_date=(strlen($_POST['pub_date'][$language])>6)?strtotime($_POST['pub_date'][$language]):time();
            $res=mysql_query("select id from ".$PREFIX."lang_text where rel_id={$rel_id} and table_name='queries' and language='{$language}'");
            if(mysql_num_rows($res)>0) {
                mysql_query("UPDATE `".$PREFIX."lang_text` SET title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}' WHERE rel_id=$rel_id and table_name='queries' and language='$language'");
            }else{
                mysql_query("INSERT INTO `".$PREFIX."lang_text` SET rel_id={$rel_id} ,table_name='queries',language='{$language}',title='{$title}',short='{$short}',content='{$content}',description='{$description}',keywords='{$keywords}',pub_date='{$pub_date}'");
            }
          * 
          */
        //}
    }else{
        echo $error.$multierror;
    }
}
?>
<h1>Редактирование</h1><form method="post">
    <fieldset>
<label for="phrase"><?php echo $GLOBALS['dblang_phrase'][$DLANG]?>: <b><?php echo $tbl_phrase?></b><!--<input id="phrase" class="query" type=text name="phrase" value="<?php echo $tbl_phrase?>">--></label><br>
    </fieldset>
        <br><h3>Выберите категории</h3><br>
<!--<label for="url"><?php echo $GLOBALS['dblang_url'][$DLANG]?> <input id="url" class="query" type=text name="url" value="<?php echo $tbl_url?>"></label><br>-->
<?php
/*
foreach($LANGUAGES as $lang=>$path){
    ?>
<div class=lang>Язык : <?php echo $lang ?></div>
<input type=hidden name="stufflang[]" value="<?php echo $lang ?>">
        <label for="title[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_title1'][$DLANG]?><input id="title[<?php echo $lang ?>]" type=text name="title[<?php echo $lang ?>]" value="<?php echo $tbl_title[$lang]?>"></label><label for="short[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_short1'][$DLANG]?><textarea id="short[<?php echo $lang ?>]" class="ckeditor" id="editor_ck12[<?php echo $lang ?>]" name="short[<?php echo $lang ?>]"><?php echo $tbl_short[$lang]?></textarea></label><label for="content[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_content1'][$DLANG]?><textarea id="content[<?php echo $lang ?>]" class="ckeditor" id="editor_ck13[<?php echo $lang ?>]" name="content[<?php echo $lang ?>]"><?php echo $tbl_content[$lang]?></textarea></label><label for="description[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_description1'][$DLANG]?><input id="description[<?php echo $lang ?>]" type=text name="description[<?php echo $lang ?>]" value="<?php echo $tbl_description[$lang]?>"></label><label for="keywords[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_keywords1'][$DLANG]?><input id="keywords[<?php echo $lang ?>]" type=text name="keywords[<?php echo $lang ?>]" value="<?php echo $tbl_keywords[$lang]?>"></label><label for="pub_date[<?php echo $lang ?>]"><?php echo $GLOBALS['dblang_pub_date1'][$DLANG]?><input id="pub_date[<?php echo $lang ?>]" type=text name="pub_date[<?php echo $lang ?>]" value="<?php echo date("d-m-Y", ($tbl_pub_date[$lang])?$tbl_pub_date[$lang]:time())?>" onfocus="this.select();lcs(this)" onclick="event.cancelBubble=true;this.select();lcs(this)"></label>
<?php
}    
?><input type=submit name="submit" value="<?php echo $GLOBALS['dblang_button'][$DLANG]?>">
<input type='hidden' name='editid' value='<?php echo $editid ?>'>
</form>
 * 
 */
$category_arr = getCategory();
$resultmenu='';
outTree(0, 0);
echo $resultmenu;
?>
<input type='hidden' name='editid' value='<?php echo intval($_GET['edit'])?>'>

<input type="submit" class='button' name='submit' value='сохранить'>
</form>
