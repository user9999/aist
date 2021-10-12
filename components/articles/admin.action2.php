<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
} 
function multi_attach_mail($to, $files, $sendermail,$filename,$csvsize,$subject,$message)
{
    $from = $sendermail;
    $subject="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $subject))."?=";
    $message = iconv("UTF-8", "koi8-r", $message);//date("Y.m.d H:i:s")."\n".count($files)." attachments";
    $headers = "From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "Грузовая запчасть"))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">";//"From: $from";
 
    // boundary
    $semi_rand = md5(time());
    $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
 
    // headers for attachment
    $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";
 
    // multipart boundary
    $message = "--{$mime_boundary}\n" . "Content-Type:  text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\n\n". $message . "\n\n";//text/plain; charset=\"iso-8859-1\"\n" .
    //"Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n";
    // preparing attachments
    for($i=0;$i<count($files);$i++){
        $message .= "--{$mime_boundary}\n";
        $data =  $files[$i];
        $data = chunk_split(base64_encode($data));
        $message .= "Content-Type: application/octet-stream; name=\"".basename($filename)."\"\n" .
        "Content-Description: ".basename($filename)."\n" .
        "Content-Disposition: attachment;\n" . " filename=\"".basename($filename)."\"; size=".$csvsize.";\n" .
        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
    }
    $message .= "--{$mime_boundary}--";
    $returnpath = "-f" . $sendermail;
    $ok = @mail($to, $subject, $message, $headers, $returnpath);
    
    if($ok) { return $i; 
    } else { return 0; 
    }
}
function translitIt($str)
{
    $tr = array(
        "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
        "Д"=>"d","Е"=>"e","Ж"=>"j","З"=>"z","И"=>"i",
        "Й"=>"y","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
        "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
        "У"=>"u","Ф"=>"f","Х"=>"h","Ц"=>"ts","Ч"=>"ch",
        "Ш"=>"sh","Щ"=>"sch","Ъ"=>"","Ы"=>"yi","Ь"=>"",
        "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
        "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ж"=>"j",
        "з"=>"z","и"=>"i","й"=>"y","к"=>"k","л"=>"l",
        "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
        "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
        "ц"=>"ts","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"y",
        "ы"=>"yi","ь"=>"","э"=>"e","ю"=>"yu","я"=>"ya", 
        " "=> "_", "."=> "", "/"=> "_", "!"=> "", "?"=> "", ":"=> "", '"'=> "", "'"=> "", '"'=> "","»"=>"","«"=>"","`"=>"",";"=>"","%"=>"","$"=>"","#"=>"","@"=>"","+"=>"","&"=>"","\\"=>"","*"=>"","^"=>"","~"=>"","="=>""
    );
    return strtr($str, $tr);
}
$mess="";
if($_GET['edit']) {
    $id=intval($_GET['edit']);
    $res=mysql_query("select a.period,a.price,a.access,b.language,b.title,b.content from ".$PREFIX."packages as a, ".$PREFIX."lang_text as b where a.id=b.rel_id and b.table_name='packages' and a.id=".$id);
    while($row=mysql_fetch_row($res)){
        $title[$row[3]]=$row[4];
        $content[$row[3]]=$row[5];
        $period=$row[0];
        $price=$row[1];
        $ac=unserialize($row[2]);
    }
}
if($_POST['editid']) {
    $ac=$_POST['access'];
    $id=intval($_POST['editid']);
    $title=$_POST['title'];
    $content=$_POST['content'];
    $period=($_POST['period']=="year")?12:1;
    //var_dump($_POST['access']);
    $access=addslashes(serialize($_POST['access']));
    mysql_query("update ".$PREFIX."packages  SET period='$period', price='".mysql_escape_string($_POST['price'])."',access='$access' where id=$id");
    foreach($_POST['title'] as $lang=>$name){
        mysql_query("update ".$PREFIX."lang_text SET  title='".mysql_escape_string($title[$lang])."' , `content`='".mysql_escape_string($content[$lang])."' WHERE `rel_id`=$id and table_name='packages' and language='$lang'");
    }    
} elseif($_POST['id']) {
    $ac=$_POST['access'];
    $id=intval($_POST['id']);
    $title=$_POST['title'];
    $content=$_POST['content'];
    $period=($_POST['period']=="year")?12:1;
    $access=addslashes(serialize($_POST['access']));
    $res=mysql_query("select price from ".$PREFIX."packages where id=$id");
    if(mysql_num_rows($res)) {
        $mess="такой идентификатор пакета уже есть";
    } else {
        mysql_query("insert into ".$PREFIX."packages  SET id=$id, period='$period', price='".mysql_escape_string($_POST['price'])."',access='$access'");
        foreach($_POST['title'] as $lang=>$name){
            mysql_query("insert into ".$PREFIX."lang_text SET  table_name='packages', rel_id=$id, language='$lang',  title='".mysql_escape_string($title[$lang])."' , `content`='".mysql_escape_string($content[$lang])."'");
        }    
    }
}
$p1=$p12="";
switch ($period){
case 1:
    $p1="selected";
    break;
case 12:
    $p12="selected";
    break;
}
echo $mess;
?>
<h2>Пакеты</h2>

<form method=post>
<table width="100%">
        <tr>
            <td width="120">Идентификатор пакета(цифра):</td><td><input class="textbox" name="id" type="text" size="50" value="<?php echo $id ?>"></td>
        </tr>
<?php
foreach($LANGUAGES as $lang=>$path){
    echo "<tr style='background:#ccc;font-size:130%;text-align:center'><td colspan=2><b>$lang</b></td></tr>";
    ?>
        <tr>
            <td width="120">Название:</td><td><input class="textbox" name="title[<?php echo $lang ?>]" type="text" size="50" value="<?php echo $title[$lang] ?>"></td>
        </tr>
        <tr>
            <td width="120">Описание:</td><td><textarea class="textbox" name="content[<?php echo $lang ?>]"><?php echo $content[$lang] ?></textarea></td>
        </tr>
    <?php
}
?>        
        <tr>
            <td width="120">Период:</td><td>
            <select name=period>
            <option value=year <?php echo $p12 ?>>год</option>
            <option value=month <?php echo $p1 ?>>месяц</option>
            </select>
            </td>
        </tr>
        <tr>
            <td width="120">Доступ к:</td><td>статьи<input type=checkbox name=access[articles] value='checked' <?php echo $ac[articles] ?>>; поддержка<input type=checkbox name=access[support] value='checked' <?php echo $ac[support] ?>></td>
        </tr>
        <tr>
            <td width="120">Цена:</td><td><input class="textbox" name="price" type="text" size="50" value="<?php echo $price ?>">$</td>
        </tr>
        <tr>
            <td></td><td><input type="hidden" name="editid" value="<?php echo $id ?>"><input type="submit" class="button" value="Сохранить"></td>
        </tr>
    </table>
</form>
<h3>Существующие пакеты</h3>
<table><tr><td>id</td><td>название</td><td>описание</td><td>период</td><td>цена</td></tr>
<?php
$res=mysql_query("select a.id,a.period,a.price,b.title,b.content from ".$PREFIX."packages as a, ".$PREFIX."lang_text as b where a.id=b.rel_id and b.table_name='packages' and b.language='ru'");
while($row=mysql_fetch_row($res)){
    echo "<tr><td>{$row[0]}</td><td><a href='?component=users&action=3&edit={$row[0]}'>{$row[3]}</a></td><td>{$row[4]}</td><td>{$row[1]} мес</td><td>{$row[2]}$</td></tr>";
}
?>
