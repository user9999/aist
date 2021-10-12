<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
set_title($GLOBALS['dblang_services'][$GLOBALS['userlanguage']]);
set_meta("", "");
if($_POST['order']) {
    $fl=0;
    if(preg_match("!^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}$!", $_POST['date'], $match)) {
        $d=explode(".", $_POST['date']);
        if($d[0]<32 && $d[1]<13) {
            $fl=1;
        }
    }
    if($fl==1) {
        $name=mysql_real_escape_string($_POST['family']);
        $phone=mysql_real_escape_string($_POST['phone']);
        $email=mysql_real_escape_string($_POST['email']);
        $user_id=($_SESSION['userid'])?$_SESSION['userid']:0;
        $product_id=intval($_POST['product_id']);
        $res=mysql_query("select id from ".$PREFIX."service_orders where day={$d[0]} and month={$d[1]} and year={$d[2]}");
        if(mysql_num_rows($res)) {
            $out=$GLOBALS['dblang_orderexist'][$GLOBALS['userlanguage']];
        } else {
            mysql_query("insert into ".$PREFIX."service_orders set name='$name',phone='$phone',email='$email',date=".time().",user_id='$user_id',product_id=".$product_id.",day={$d[0]},month={$d[1]},year={$d[2]}");
            $out=$GLOBALS['dblang_orderok'][$GLOBALS['userlanguage']];
        }
    } else {
        $out=$GLOBALS['dblang_wrongdate'][$GLOBALS['userlanguage']];
    }
}
render_to_template("components/services/tpl/title.php", array('title'=>$GLOBALS['dblang_services'][$GLOBALS['userlanguage']],'error'=>$out));
if(preg_match("!^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}$!", $_GET['order'], $match)) {
    $d=explode(".", $_GET['order']);
    if($d[0]<32 && $d[1]<13) {
        $alias=mysql_real_escape_string($last_section);
        $res=mysql_query("select a.id,b.title,b.short,b.content,b.keywords,b.description from ".$PREFIX."services as a, ".$PREFIX."lang_text as b where a.alias='$alias' and b.table_name='services' and language='{$userlanguage}' and a.id=b.rel_id");
        $row=mysql_fetch_assoc($res);
        if (isset($_SESSION['nick'])) {
            $res1 = mysql_query("select name,phone from ".$PREFIX."users where id=".$_SESSION['userid']." limit 1");
            $row1=mysql_fetch_row($res1);
            render_to_template("components/services/tpl/userorder.php", array('title'=>$row['title'],'id'=>$row['id'],'altname'=>$row['title'],'content'=>$row['content'],'alias'=>$alias,'date'=>$_GET['order'],'family'=>$row1[0], 'phone'=>$row1[1],'out'=>$out));
        } else {
            render_to_template("components/services/tpl/order.php", array('title'=>$row['title'],'id'=>$row['id'],'altname'=>$row['title'],'content'=>$row['content'],'alias'=>$alias,'date'=>$_GET['order']));
        }
    } else {
        $out=$GLOBALS['dblang_wrongdate'][$GLOBALS['userlanguage']];
        echo "<div class=error>".$out."</div>";
    }
}
if(!$segments) {
    $res=mysql_query("select a.id,a.alias,b.title,b.short,b.content from ".$PREFIX."services as a, ".$PREFIX."lang_text as b where b.table_name='services' and language='{$userlanguage}' and a.id=b.rel_id order by a.position");
    while($row=mysql_fetch_assoc($res)){
        render_to_template("components/services/tpl/services.php", array('title'=>$row['title'],'id'=>$row['id'],'altname'=>$row['alias'],'content'=>$row['content'],'short'=>$row['short']));
    }
} elseif(count($segments)==1 && !$_GET['order']) {
    $alias=mysql_real_escape_string($last_section);
    $res=mysql_query("select a.id,b.title,b.short,b.content,b.keywords,b.description from ".$PREFIX."services as a, ".$PREFIX."lang_text as b where a.alias='$alias' and b.table_name='services' and language='{$userlanguage}' and a.id=b.rel_id");
    $row=mysql_fetch_assoc($res);
    render_to_template("components/services/tpl/service.php", array('title'=>$row['title'],'id'=>$row['id'],'altname'=>$row['title'],'content'=>$row['content'],'short'=>$row['short'],'alias'=>$alias));
}
?>
