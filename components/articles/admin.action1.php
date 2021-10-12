<?php if (!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die("Access denied");
}
$this_script = "?component=articles";
 //количество номеров на странице
 $num_page_on_str = 10;
 //Количество новостей на странице
 $col_mes_on_page=10;
 //количество подрубрик выделенных под каждую рубрику
 $col_podrubr=6;
 $str = "";
 $res = "<h1>Статьи</h1>";
if(isset($_REQUEST['cmd'])) { $cmd=$_REQUEST['cmd']; 
} else { $cmd="start";
}
if(isset($_REQUEST['date'])) { $date = mysql_escape_string($_REQUEST['date']); 
} else { $date = date("Y-m-d");
}
 
if(isset($_REQUEST['title'])) { $title = $_REQUEST['title']; 
} else { $title = array();
}
if(isset($_REQUEST['short_text'])) { $short_text = $_REQUEST['short_text']; 
} else { $short_text = array();
}
if(isset($_REQUEST['full_text'])) { $full_text = $_REQUEST['full_text']; 
} else { $full_text = array();
}
if(isset($_REQUEST['keywords'])) { $keywords = $_REQUEST['keywords']; 
} else { $keywords = array();
}
if(isset($_REQUEST['description'])) { $description = $_REQUEST['description']; 
} else { $description = array();
}
 $options="";
         $resb=mysql_query("select id,parent,level,ordering from ".$PREFIX."articles order by ordering");
while($row=mysql_fetch_row($resb)){
    $r=mysql_query("select title from ".$PREFIX."lang_text where rel_id={$row[0]} and language='en' and table_name='articles' limit 1");
    $rw=mysql_fetch_row($r);
    $dash=str_repeat("-", $row[2]);
    $p3=substr($row[3], -3)/100;
    $p2=substr($row[3], -5, 2)/10;
    $p1=substr($row[3], 0, -5)/10;
    //echo $row[3]." 1- ".$p1." ;2- ".$p2."; ".$p3;
    //$p1=str_replace($p2.$p3,"",$row[3]);//substr($row[3],-2);
            
    //$p2=(intval($p2))?".".intval($p2):"";
    //$p3=(intval($p3))?".".intval($p3):"";
                //$par=str_replace($row[3])
                $p2=($p2)?".".$p2:"";
                $p3=($p3)?".".$p3:"";
                $par=$p1.$p2.$p3;
    $options.="<option value={$row[0]}>$dash ".$par." {$rw[0]} </option>";
            
}
if($cmd=="edit") {

    if(isset($_REQUEST['news_id'])) {
            
        $news_id = intval($_REQUEST['news_id']);
            
        if(isset($_REQUEST['news_cmd_del']) and $_REQUEST['news_cmd_del'] == "Delete" ) {
            $res .= "<p><a href=\"$this_script&cmd=start\">Вернуться к списку статей</a></p>
					<form action=\"$this_script&cmd=del\" method=\"post\">
		         	<p><b>Вы уверены, что хотите удалить эту статью!!!</b></p>
		         	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
					<tr><td>Дата</td><td>Заголовок</td><td>Краткая информация</td><td>Ключевые слова</td></tr>";
            $sql = "SELECT * FROM `".$PREFIX."articles` WHERE `id`='".$news_id."'";
            $query = mysql_query($sql)or die("Ошибка при запросе: " . mysql_error());
            $news_res = mysql_fetch_array($query);
            $res1=mysql_query("select `title`,`short` from ".$PREFIX."lang_text where rel_id={$news_res['id']} and table_name='articles'");
            while($row1=mysql_fetch_array($res1)){
                $news_res['title']=$row1[0];
                $news_res['short_text']=$row1[1];
                break;
            }
                
                
            $res .= "<tr><td>".$news_res['date']."</td><td>".$news_res['title']."</td><td>".$news_res['short_text']."</td><td>".$news_res['keywords']."</td></tr></table>
		         	<input type=\"hidden\" name=\"news_id\" value=\"".$news_id."\">
		         	<input type=\"submit\" class='button' name=\"del\" value=\"yes\">&nbsp;&nbsp;
					<input type=\"submit\" class='button' name=\"del\" value=\"no\"></form>";
                $res .= "<p><a href=\"$this_script&cmd=start\">Вернуться к списку статей</a></p>";
        }
        if(isset($_REQUEST['news_cmd_edit']) and $_REQUEST['news_cmd_edit'] == "Edit" ) {                
                $sql = "SELECT * FROM `".$PREFIX."articles` WHERE `id`='".$news_id."' limit 1";
                $query = mysql_query($sql)or die("Ошибка при запросе: " . mysql_error());
                $news_res = mysql_fetch_array($query);
                
            $date = $news_res['date'];
            $position=$news_res['position'];
            $query = mysql_query("select * from ".$PREFIX."lang_text where rel_id={$news_res['id']} and table_name='articles'");
            while($resb=mysql_fetch_assoc($query)){
                  $title[$resb['language']] = $resb['title'];
                  $short_text[$resb['language']] = $resb['short'];
                  $full_text[$resb['language']] = stripslashes($resb['content']);
                  $keywords[$resb['language']]= $resb['keywords'];
                  $description[$resb['language']]= $resb['description'];
            }
            $edit_news = $news_id;
            $cmd="add_news";
        }
    } else {
        $res .= "Вы не выбрали статью!<br>";
        $cmd="start";
    }

}
if($cmd=="del") { //Удаление новости из базы данных
    if(isset($_REQUEST['news_id'])) {
        if($_REQUEST['del'] == "yes") {
             $Query = "DELETE FROM `".$PREFIX."articles` WHERE id='".intval($_REQUEST['news_id'])."'";
            $dbResult = mysql_query($Query) or die("Ошибка при запросе: " . mysql_error());
            mysql_query("DELETE FROM `".$PREFIX."lang_text` WHERE rel_id='".intval($_REQUEST['news_id'])."' and `table_name`='articles'");
            $res .= "статья успешно удалена!<br>";
        }
            $cmd="start";
    }
}
    //Стартовая страница
if($cmd=="start") {
      $res .= "<p><a href=\"$this_script&cmd=add_news\">Добавить статью</a></p>";
       //Определение временных рамок новостей
    $sql = "SELECT `date` FROM `".$PREFIX."articles` ORDER BY `date` ASC LIMIT 0,1";
    if($query = mysql_query($sql)) {    $fetch = mysql_fetch_array($query);
    }
    $min_date = $fetch['date'];

    $sql = "SELECT `date` FROM `".$PREFIX."articles` ORDER BY `date` DESC LIMIT 0,1";
    if($query = mysql_query($sql)) { $fetch = mysql_fetch_array($query);
    }
    $max_date = $fetch['date'];

    if((!isset($_REQUEST['start_date'])) and (!isset($_REQUEST['end_date']))) {
        $start_array=explode("-", $min_date);
        $end_array=explode("-", $max_date);
        //$start_date = $min_date;
        //$end_date = $max_date;
        $start_date = $start_array[2]."-".$start_array[1]."-".$start_array[0];
        $end_date = $end_array[2]."-".$end_array[1]."-".$end_array[0];
    } else {
        $start_date = $_REQUEST['start_date'];
        $end_date = $_REQUEST['end_date'];
            
        $start_array=explode("-", $_REQUEST['start_date']);
        $end_array=explode("-", $_REQUEST['end_date']);
        $min_date = $start_array[2]."-".$start_array[1]."-".$start_array[0];
        $max_date = $end_array[2]."-".$end_array[1]."-".$end_array[0];
            
    }
        
    $res .= "<form method='POST'><table><tr><td>Вывести статьи на период с</td><td><input name=\"start_date\" id=\"date_start\" type=\"text\" size=\"10\" value=\"".$start_date."\" onfocus=\"this.select();lcs(this)\" onclick=\"event.cancelBubble=true;this.select();lcs(this);\"></td><td>по</td><td><input name=\"end_date\" id=\"date_end\" type=\"text\" size=\"10\" value=\"".$end_date."\" onfocus=\"this.select();lcs(this)\" onclick=\"event.cancelBubble=true;this.select();lcs(this);\"></td></tr></table>
			<p><input type=\"submit\" class='button' value=\"Получить список статей\"></p></form>";
        
    $sql_final = "SELECT * FROM `".$PREFIX."articles`";
    //Запрос по дате

    if($min_date == $max_date) {
        $sql_final .= " WHERE `date` = '".$max_date."'";
    }
    else{
        $sql_final .= " WHERE `date` >= '".$min_date."' and `date` <= '".$max_date."'";
    }
    $sql_final .= " ORDER BY `date` DESC";

    $query = mysql_query($sql_final) or die("Ошибка при запросе: " . mysql_error());
    $max= mysql_num_rows($query);
    if($max==0) {
        $res .= "<p><b>По данному запросу нет информации, попробуйте ещё!</b></p>";
    } else {
        //Постраничный вывод новостей
        if(isset($_REQUEST['page'])) {
            $page = intval($_REQUEST['page']);
            if ($page <= 0) {
                $page=1;
            }
        } else {
            $page=1;
        }

        if($max > $col_mes_on_page) {
            $end = $max/$col_mes_on_page;
            if(($max%$col_mes_on_page) > 0) {
                $end++;
            }
            if($page > $end) {
                $page = (int)$end;
            }
            if($page > $num_page_on_str) {
                $start_page = $page - ($page%$num_page_on_str) + 1;
                if(($page%$num_page_on_str)==0) {
                    $start_page = $start_page - $num_page_on_str;
                }
            } else {
                $start_page = 1;
            }
              $end_page = $start_page + $num_page_on_str - 1;
            if ($end_page > $end) {
                $end_page = $end;
            }
            if($start_page >= $num_page_on_str) {
                $last_page = $start_page - 1;
                $str .= "<a href=\"articles/start_date=".$start_date."&end_date=".$end_date."&page=".$last_page."\">&lt;&lt;</a>&nbsp;";
            }
            for($i = $start_page; $i <= $end_page; $i++){
                if($i == $page) {
                        $str .= "<b>";
                }
                $str .= "<a href=\"articles/start_date=".$start_date."&end_date=".$end_date."&page=".$i."\">".$i."</a>&nbsp;";
                if($i==$page) {
                    $str .= "</b>";
                }
            }
            if($end_page < (int)$end) {
                $next_page = $start_page + $num_page_on_str;
                $str .= "<a href=\"articles/start_date=".$start_date."&end_date=".$end_date."&page=".$next_page."\">&gt;&gt;</a>&nbsp;";
            }
              $str .= "<br><br>";
        }
        else{
            $page=1;
        }
        $page_mes=$page*$col_mes_on_page-$col_mes_on_page;

        $page_sql = $sql_final." LIMIT ".$page_mes.", ".$col_mes_on_page;
        $query = mysql_query($page_sql) or die("Ошибка при запросе: " . mysql_error());
        $res .= $str;
        $res .= "<br /><br /><form action=\"$this_script&cmd=edit\" method=\"post\">
				<input type=\"submit\" class='button' name=\"news_cmd_edit\" value=\"Edit\">&nbsp;&nbsp;
				<input type=\"submit\" class='button' name=\"news_cmd_del\" value=\"Delete\"><br>
				<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"4\">
				<tr class='hd'><td></td><td>ID</td><td>Дата</td><td>Заголовок</td><td>Краткая информация</td><td>Ключевые слова</td></tr>";
        while($news_res=mysql_fetch_array($query)){
            $res1=mysql_query("select `title`,`short` from ".$PREFIX."lang_text where rel_id={$news_res['id']} and table_name='articles'");
            while($row1=mysql_fetch_array($res1)){
                $news_res['title']=$row1[0];
                $news_res['short_text']=$row1[1];
                break;
            }
            $res .= "<tr><td><input type=\"radio\" name=\"news_id\" value=\"".$news_res['id']."\"></td><td>".$news_res['id']."</td><td>".$news_res['date']."</td><td>".$news_res['title']."</td><td>".$news_res['short_text']."</td><td>".$news_res['keywords']."</td></tr>";
        }
        $res .= "</table></form>";
        $res .= $str;
    }
}
    //Добавление новой новости в базу данных или обновление старой
if($cmd=="add") {
    if($title and $short_text and $full_text) {
        //echo "here!!";
        $parent = intval($_REQUEST['parent']);
        $position = intval($_REQUEST['position']);
        if(isset($_REQUEST['upd_id'])) { //Обновление существующей новости
            $upd_id = intval($_REQUEST['upd_id']);
                
            if($parent==0) {
                $level=1;
            } else {
                $resb=mysql_query("select level,ordering from `".$PREFIX."articles` where id=$parent limit 1");
                $row=mysql_fetch_row($resb);
                $level=$row[0]+1;
            }
            switch($level){
            case 1:
                $k=1000000;
                break;
            case 2:
                $k=10000;
                break;
            case 3:
                $k=100;
                break;
            case 4:
                $k=1;
                break;
            }
            $ordering=$row[1]+$position*$k;
            mysql_query("UPDATE `".$PREFIX."articles` SET `date`='$date',parent=$parent,level=$level,position=$position,ordering=$ordering WHERE `id`='$upd_id'");
                
            foreach($title as $lang=>$name){
                mysql_query("update ".$PREFIX."lang_text SET  title='".$title[$lang]."' , `short`='".mysql_escape_string($short_text[$lang])."', `content`='".mysql_escape_string($full_text[$lang])."',`description`='".htmlspecialchars($description[$lang])."',`keywords`='".htmlspecialchars($keywords[$lang])."',pub_date='".time()."'  WHERE `rel_id`=$upd_id and table_name='articles' and language='$lang'");
            }    
            
                //if( $query = mysql_query($sql) ) $res .= "<p><b>Редактирование статьи прошло успешно!</b></p>";
                //else $res .= "Ошибка при запросе: " . mysql_error();
                //Содержит индекс изменяемой новости
                $edit_news = $upd_id;
        }
        else{ //Добавление новости

            if($parent==0) {
                  $level=1;
            } else {
                $resb=mysql_query("select level from `".$PREFIX."articles` where id=$parent limit 1");
                $row=mysql_fetch_row($resb);
                $level=$row[0]+1;
            }
            switch($level){
            case 1:
                $k=1000000;
                break;
            case 2:
                $k=10000;
                break;
            case 3:
                $k=100;
                break;
            case 4:
                $k=1;
                break;
            }
            $ordering=$row[1]+$position*$k;
            mysql_query("INSERT INTO `".$PREFIX."articles` (`date`,`parent`,`level`,`position`,`ordering`) VALUES ('$date',$parent,$level,$position,$ordering)");
            $static_id=mysql_insert_id();
            foreach($title as $lang=>$name){
                mysql_query("INSERT INTO ".$PREFIX."lang_text SET table_name='articles', rel_id=$static_id, language='$lang', title='".$title[$lang]."' , `short`='".mysql_escape_string($short_text[$lang])."', `content`='".mysql_escape_string($full_text[$lang])."',`description`='".htmlspecialchars($frm_meta_description[$lang])."',`keywords`='".htmlspecialchars($frm_keywords[$lang])."',pub_date='".time()."'");
            }        
            //if( $query = mysql_query($sql) ) $res .= "<p><b>Добавление статьи в базу прошло успешно!</b></p>";
            //else $res .= "Ошибка при запросе: " . mysql_error();
        }
    } else {
        $res .= "<p><b>Вы заполнили не все поля!</b></p>";
    }
    $cmd="add_news";
    if($_POST['send']=='mail') {
        /////////begin nova        
        if(file_exists("cache/news/nova.php")) {//filemtime
            $x=time()-filemtime("cache/news/nova.php");
            if($x>(60*60*24*7)) {
                unlink("cache/news/nova.php");
                $flag="write";
            } else {
                $flag="add";
            }
        }
        $resn = mysql_query("SELECT b.id,b.name AS position_name,b.price,b.description,b.country,c.name AS modelname,c.altname AS altmodelname,a.name as brandname,a.altname as altbrandname FROM catalog_brands as a, ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c WHERE b.model_id = c.id AND a.id=b.brand_id AND b.special='' AND b.nova='new' ORDER BY a.name,c.name,b.description");
        $s = 0;$nova="";
        if(mysql_num_rows($resn)>0) {
            while ($rown = mysql_fetch_row($resn)) {
                $s++;
                if ($rown[6]) { $rown[5] = $rown[6];
                }
                if ($rown[8]) { $rown[7] = $rown[8];
                }        
                $sid = 0;
                $resn1 = mysql_query("SELECT id FROM ".$PREFIX."catalog_items2 WHERE linked_item = '{$rown[1]}'");
                if ($rn = mysql_fetch_row($resn1)) {
                    $sid = $rn[0];
                }
                $nova.="<li><div class=\"thumbnail\">{$rown[7]} {$rown[5]}<br><a href=\"http://gruz-zap.ru/catalog/item-$sid&amp;b=".urlencode($rown[7])."&amp;t=".urlencode($rown[5])."\" onclick=\"window.open('http://gruz-zap.ru/catalog/item-$sid&amp;b=".urlencode($rown[7])."&amp;t=".urlencode($rown[5])."','_blank'); return false\">{$rown[3]}</a></div><div class=\"info\">{$rown[2]} р.</div><div class=\"clear\"></div></li>\n";
            }
            if($flag=="write") {
                $fp=fopen("cache/news/nova.php", "w+");//filemtime
            } else {
                $fp=fopen("cache/news/nova.php", "a+");//filemtime
            }
            fwrite($fp, $nova);
            fclose($fp);
  
        }
        ///////////end
        mysql_query("update ".$PREFIX."catalog_items set nova='' where nova='new'");
        include_once "inc/mail.system.templates.php";
                //mail
        $letfoot="<br>".$mailsystemtemplates['action'][1];
        $mails="";
        $rnews=mysql_query("select email,name,subdate from ".$PREFIX."submission where code='0' and length(unsub)=32 order by subdate DESC");
        while($row=mysql_fetch_row($rnews)){
            $mails.=$row[0].",";
        }
        $mails=substr($mails, 0, -1);
        $mar=explode(",", $mails);
        foreach($mar as $num=>$umail){
            $from=$ADMIN_EMAIL;
            $ltitle="=?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $title))."?=";
            $mess=stripslashes($full_text.$letfoot);
            $mess=iconv("UTF-8", "koi8-r", $mess);
            $headers="From: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", $SITE_TITLE))."?= <".trim($from).">\r\nReply-to: =?koi8-r?B?".base64_encode(iconv("UTF-8", "koi8-r", "От кого"))."?= <".trim($from).">\r\nContent-type: text/html; charset=koi8-r\r\nContent-Transfer-Encoding: 8bit\r\n";
            mail($umail, $ltitle, $mess, $headers);

        }
    }
}
    //автоматическое добавление новости в базу данных и рассылка
if($cmd=="send") {
    include_once "inc/news.templates.php";
    $res3 = mysql_query("SELECT b.id,b.name AS position_name,b.price,b.description,b.country,c.name AS modelname,c.altname AS altmodelname,a.name as brandname,a.altname as altbrandname FROM ".$PREFIX."catalog_brands as a, ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c WHERE b.model_id = c.id AND a.id=b.brand_id AND b.nova='new' AND b.special='' ORDER BY a.name,c.name,b.description");
    $detail="";
    if(mysql_num_rows($res3)>0) {
        $title=$newsnew[array_rand($newsnew)];
        $short_text=$newstitle[array_rand($newstitle)];
        $detail="<h3>".$newsnova[array_rand($newsnova)]."</h3>";
        $s = 0;$detail.="<ul>";
        while ($row3 = mysql_fetch_row($res3)) {
            $s++;
            if ($row3[6]) { $row3[5] = $row3[6];
            }
            if ($row3[8]) { $row3[7] = $row3[8];
            }        
            $sid = 0;
            $res4 = mysql_query("SELECT id FROM ".$PREFIX."catalog_items2 WHERE linked_item = '{$row3[1]}'");
            if ($r4 = mysql_fetch_row($res4)) {
                $sid = $r4[0];
            }
            $bg=($s%2!=0)?"background:#ddd":"";
            $detail.="<li style='list-style:none;display:block;height:42px;padding-bottom:1px;margin-bottom:5px;$bg'><div style='float:left;width:70%;overflow:auto'>{$row3[7]} {$row3[5]}<br><a href=\"http://gruz-zap.ru/catalog/item-$sid&amp;b=".urlencode($row3[7])."&amp;t=".urlencode($row3[5])."\">{$row3[3]}</a></div><div style='float:right;width:25%;'>{$row3[2]} р.</div><div style=\"clear:both;\"></div></li>";
        }
        $detail.="</ul>";
    } else {
        $title=$newstitle[array_rand($newstitle)];
        $short_text=$newsnew[array_rand($newsnew)];
    }
    $res2 = mysql_query("SELECT b.id,b.name AS position_name,b.price,b.special,b.description,b.country,c.name AS modelname,c.altname AS altmodelname,a.name as brandname,a.altname as altbrandname FROM ".$PREFIX."catalog_brands as a, ".$PREFIX."catalog_items AS b, ".$PREFIX."catalog_models AS c WHERE b.model_id = c.id AND a.id=b.brand_id AND b.special!='' AND b.nova='new' ORDER BY a.name,c.name,b.description");
    $s = 0;$snip="<ul>";
    while ($row2 = mysql_fetch_row($res2)) {
        $s++;
        if ($row2[7]) { $row2[6] = $row2[7];
        }
        if ($row2[9]) { $row2[8] = $row2[9];
        }        
        $sid = 0;
        $res3 = mysql_query("SELECT id FROM ".$PREFIX."catalog_items2 WHERE linked_item = '{$row2[1]}'");
        if ($r3 = mysql_fetch_row($res3)) {
            $sid = $r3[0];
        }
        $bg=($s%2!=0)?"background:#ddd":"";
        $snip.="<li style='list-style:none;display:block;height:42px;padding-bottom:1px;margin-bottom:5px;$bg'><div style='float:left;width:70%;overflow:auto'>{$row2[8]} {$row2[6]}<br><a href=\"http://gruz-zap.ru/catalog/item-$sid&amp;b=".urlencode($row2[8])."&amp;t=".urlencode($row2[6])."\">{$row2[4]}</a></div><div style='float:right;width:25%;'><s>{$row2[3]}</s>  {$row2[2]} р.</div><div style=\"clear:both;\"></div></li>";
    }
    $snip.="</ul>";

    //echo $snip;
    $act=$newsaction[array_rand($newsaction)];
    $autonews=$detail."<h3>".$act."</h3>".$snip;
    $keywords=$newskeywords[array_rand($newskeywords)];
    $res = "<h1>Статьи</h1><p><a href=\"$this_script&cmd=start\">Перейти к списку статей</a></p>
			<form action=\"$this_script&cmd=add\" method=\"post\">
 			<p>Отредактируйте информацию в соответствующих полях:</p>
            <table width='100%'><tr><td width='120'>Дата</td><td><input name=\"date\" type=\"text\" size=\"10\" value=\"$date\"></td></tr>
            <tr><td>Заголовок</td><td><textarea name=\"title\" rows=\"1\" style='width: 100%;'>$title</textarea></td></tr>
            <tr><td>Краткий текст</td><td><textarea name=\"short_text\" rows=\"2\" style='width: 100%;'>$short_text</textarea></td></tr>
			<tr><td>Текст статьи</td>
				<td>
					<textarea id=\"editor_ck\" class='ckeditor' name=\"full_text\" style=\"width:100%;height:320px;\">$autonews</textarea><br><br>
	        	</td>
			</tr>
			<tr><td>Ключевые слова</td><td><textarea name=\"keywords\" rows=\"2\" style='width: 100%;'>$keywords</textarea></td></tr>
		</table>";
    $res .= "<input type=\"hidden\" name=\"send\" value=\"mail\"><input type=\"submit\" class='button' value=\"Отправить\" />";
}
    //Бланк редактирования, добавления новости
if($cmd=="add_news") {        
    $res = "<h1>Статьи</h1><p><a href=\"$this_script&cmd=start\">Перейти к списку статей</a></p>
			<form action=\"$this_script&cmd=add\" method=\"post\">
 			<p>Введите информацию в соответствующие поля:</p>
            <table width='100%'>
			<tr><td width='120'>Порядковый номер(параграф)</td><td><input name=\"position\" type=\"text\" size=\"10\" value=\"$position\"></td></tr>
			<tr><td>Родитель</td><td>
			<select name=parent>
			<option value=0>Корень</option>
			$options
			</select>
			</td></tr>
			<tr><td width='120'>Дата</td><td><input name=\"date\" type=\"text\" size=\"10\" value=\"$date\"></td></tr>";

    foreach($LANGUAGES as $lang=>$path){
            
            $res.="<tr><td colspan=2 style=\"font-size:150%;background:#ccc\">Язык :  $lang</td></tr>
			<tr><td>Заголовок</td><td><textarea name=\"title[$lang]\" rows=\"1\" style='width: 100%;'>$title[$lang]</textarea></td></tr>
            <tr><td>Краткий текст</td><td><textarea name=\"short_text[$lang]\" rows=\"2\" style='width: 100%;'>$short_text[$lang]</textarea></td></tr>
			<tr><td>Текст статьи</td>
				<td>
					<textarea id=\"editor_ck[$lang]\" class='ckeditor' name=\"full_text[$lang]\" style=\"width:100%;height:320px;\">$full_text[$lang]</textarea><br><br>
	        	</td>
			</tr>
			<tr><td>Мета описание(description)</td><td><textarea name=\"description[$lang]\" rows=\"2\" style='width: 100%;'>$description[$lang]</textarea></td></tr>
			<tr><td>Ключевые слова</td><td><textarea name=\"keywords[$lang]\" rows=\"2\" style='width: 100%;'>$keywords[$lang]</textarea></td></tr>";
            
    }            
            
    $res.="</table>";
    if(!isset($edit_news) or $edit_news == "") {
           $res .= "<input type=\"submit\" class='button' value=\"Добавить в базу данных\" />&nbsp;<input class='button' type=\"reset\" />";
    } else {
        $res .= "<input type=\"hidden\" name=\"upd_id\" value=\"".$edit_news."\">
            	<input type=\"submit\" class='button' value=\"Внести изменения в базу данных\">";
    }
       $res .= "</form><p><a href=\"$this_script&cmd=start\">Перейти к списку статей</a></p>";
}
   echo $res;
if($cmd=="add_news") {
    ?>
<script type="text/javascript">//<![CDATA[
window.CKEDITOR_BASEPATH='inc/ckeditor/';
//]]></script>
<script type="text/javascript" src="inc/ckeditor/ckeditor.js?t=B1GG4Z6"></script>
    <?php

    foreach($LANGUAGES as $lang=>$path){

        ?>
<script type="text/javascript">//<![CDATA[
CKEDITOR.replace('editor_ck[<?php echo $lang ?>]', { "filebrowserBrowseUrl": "\/inc\/ckfinder\/ckfinder.html", "filebrowserImageBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Images", "filebrowserFlashBrowseUrl": "\/inc\/ckfinder\/ckfinder.html?type=Flash", "filebrowserUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Files", "filebrowserImageUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Images", "filebrowserFlashUploadUrl": "\/inc\/ckfinder\/core\/connector\/php\/connector.php?command=QuickUpload&type=Flash" });
//]]></script>
        <?php
    }
}
?>