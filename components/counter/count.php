<?php
mysql_query('delete from '.$PREFIX.'visitors where intime<'.(strtotime('today')-864000));
mysql_query('delete from '.$PREFIX.'visits where vtime<'.(strtotime('today')-864000));
if(!$_COOKIE['count']) {
    $parid=($_GET['partner'])?$_GET['partner']:$_COOKIE['partner'];
    $qpartnerid=(preg_match("!^[0-9]+$!", $parid, $match))?",partnerid=".$parid:"";
    mysql_query('insert into '.$PREFIX.'visitors set browser="'.$_SERVER["HTTP_USER_AGENT"].'",intime='.time().$qpartnerid);
    $uid=mysql_insert_id();
    mysql_query('insert into '.$PREFIX.'visits set uid='.$uid.',page="'.$_SERVER["REQUEST_URI"].'",ip="'.$_SERVER['REMOTE_ADDR'].'",refer="'.$_SERVER['HTTP_REFERER'].'",vtime='.time());
    setcookie('count', $uid, time()+1800, "/", $_SERVER['HTTP_HOST']);
} else {
    setcookie('count', $_COOKIE['count'], time()+1800, "/", $_SERVER['HTTP_HOST']);
    mysql_query('insert into '.$PREFIX.'visits set uid='.$_COOKIE['count'].',page="'.$_SERVER["REQUEST_URI"].'",ip="'.$_SERVER['REMOTE_ADDR'].'",refer="'.$_SERVER['HTTP_REFERER'].'",vtime='.time());
}
?>
