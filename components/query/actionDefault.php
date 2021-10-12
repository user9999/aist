<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
}
    //if (!isset($_GET['id'])) header("Location: " . $GLOBALS['PATH'] . "/404");
    set_title($GLOBALS['dblang_ctitle'][$GLOBALS['userlanguage']]);
    set_meta("", "");
    $script="<script type='text/javascript' src='".$PATH."/js/Calendar.js'></script>";
    set_script($script);
    render_to_template("components/query/tpl/Header.php", array('title'=>$GLOBALS['dblang_ctitle'][$userlanguage],'menu'=>$GLOBALS['ssubmenu']));
    $table="queries";
    $field='phrase';
if($_GET['frm_searchfield']) {
    $post=mysql_real_escape_string(trim($_GET['frm_searchfield'])); 
    if(strpos($post, " ")!=false) {
        $parts=explode(' ', $post);
        array_unshift($parts, $post);
        foreach($parts as $part){
            $word=switcher($part, 1);
            $queries[]=$word;
            $qparts[]="SELECT * FROM ".$PREFIX."{$table} WHERE ".$field."  LIKE '".$word."%'";
        }
        $where="'".implode("%' or ".$field." LIKE '", $queries)."%'";
        $fullquery=implode(" UNION ", $qparts);
    }else{
        $word=switcher($post, 1);
        $where="'".$word."%'";
        $fullquery="SELECT * FROM ".$PREFIX."{$table} WHERE {$field} LIKE {$where}";
    }

    $result=mysql_query($fullquery);
    if(mysql_num_rows($result)) {
        while($row= mysql_fetch_array($result)){
            render_to_template("components/query/tpl/List.php", $row);
        }
            
    }else{
        $word=switcher($post, 1);
        $query="INSERT INTO ".$PREFIX."{$table} SET {$field}='{$word}'";
        mysql_query($query);
        //echo "inserting";
    }
    
    
    while ($row = mysql_fetch_assoc($res)) {

        //$tt=$row[1];
        $res1=mysql_query("SELECT title FROM ".$PREFIX."lang_text where table_name='queries' and rel_id={$row['id']} and language='{$GLOBALS['userlanguage']}'");
        while($row1=mysql_fetch_row($res1)){
            $tt=$row1[0];
            $row['lang_title']=$row1[0];
            render_to_template("components/query/tpl/List.php", $row);
        }
        $num++;

    }
}
if ($num == 0) { echo $GLOBALS['dblang_norecords'][$GLOBALS['userlanguage']];
}
?>