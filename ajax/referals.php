<?php
require_once "../inc/configuration.php";
require_once "../inc/functions.php";
session_start();
if($_SESSION['userid']) {
    $out="";
    $uid=intval(str_replace("user", "", $_POST['user']));
    $level=str_replace(" row", "", $_POST['level']);
    $level=str_replace("level", "", $level);
    $level=intval($level)+1;
    if($level<5) {
        $res=mysql_query("select * from users where parent_id=".$uid);
        if(mysql_num_rows($res)) {
            $r=1;
            while($row=mysql_fetch_array($res)){
                 $rn=($r%2==0)?2:"";// class=\"level1 row".$rn."\" 
                 $refsum=$row['ref_amount']+$row['ref2_amount']+$row['ref3_amount']+$row['ref4_amount'];
                 $out.= "<div class=\"level".$level." row\" id=user".$row['id']."> <div class=invites>".$row['id']."</div><div class=level>".$level."</div><div class=names>".$row['name']."</div> <div class=phones>".$row['phone']."</div> <div class=births> ".$row['birthdate']." </div> <div class=amountrefs>".$refsum." (".$row['ref_amount'].",".$row['ref2_amount'].",".$row['ref3_amount'].",".$row['ref4_amount'].")</div> <div class=allpoints>".$row['points']."</div><div class=regdate>".date("d.m.Y", $row['regdate'])."</div></div><div class=level".$level." id=refer".$row['id']."  style=\"display:none\"></div>";
                 $r++;
            }
        } else {
            //echo "Рефералов не найдено";
            $out="<div class=\"level".$level."\"><div class=noref>Партнеров $level уровня нет</div></div>";
        }
    } else {
        $out="<div class=\"level".$level."\"><div class=noref>Только 4 уровня партнеров!</div></div>";
    }
    echo $out;
}

?>