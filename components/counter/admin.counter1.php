<?php if(!defined("ADMIN_SIMPLE_CMS")) { die('Access denied');
}
$today=strtotime('today');
$vquery='vtime>'.$today;
$inquery='intime>'.$today;
$inquery2='b.intime>'.$today;
$link='';
for($i=1;$i<=10;$i++){
    $data=$today-$i*86400;
    if($_GET['date']==$i) {
        $menu.='<a href="?component=counter&action=1&date='.$i.'"><b>'.date("d.m", $data).'</b></a> ';
    } else {
        $menu.='<a href="?component=counter&action=1&date='.$i.'">'.date("d.m", $data).'</a> ';
    }
}
if($_GET['date']) {
    $dfrom=$_GET['date']*86400;
    $now=time()+10;
    $dtill=($_GET['date']>0)?($_GET['date']-1)*86400:0;
    $from=$today-$dfrom;
    $till=($_GET['date']>0)?$today-$dtill:$now;
    $vquery='vtime>'.$from.' and vtime<'.$till;
    $inquery='intime>'.$from.' and intime<'.$till;
    $inquery2='b.intime>'.$from.' and b.intime<'.$till;
    $link='&date='.$_GET['date'];
}
if($_GET['cmd']) {
    $cmd=$_GET['cmd'];
    if($cmd=='vis') {
        echo '<br><br>'.$menu.'<br><br><table width="100%"><td width=130>ID</td><td>браузер</td><td>ip</td><td width=50>время</td></tr>';
        $res=mysql_query('select id,name,browser,intime from '.$PREFIX.'visitors where '.$inquery.' order by id');
        while($row=mysql_fetch_row($res)){
            $res1=mysql_query('select distinct ip from '.$PREFIX.'visits where uid='.$row[0]);
            while($row1=mysql_fetch_row($res1)){
                $ips[]=$row1[0];
            }
            $id=($row[1])?$row[1]:$row[0];
      
            echo '<tr><td>'.$id.'</td><td>'.$row[2].'</td><td>'.implode(',', $ips).'</td><td>'.date("Hч.:iмин.", $row[3]).'</td></tr>';
            unset($ips);
        }
        echo '</table>';
    } elseif($cmd=='client') {
        echo '<br><br>'.$menu.'<br><br><table width="100%"><td width=130>ID</td><td>браузер</td><td>ip</td><td width=50>время</td></tr>';
        $res=mysql_query('select id,name,browser,intime from '.$PREFIX.'visitors where '.$inquery.' and name!="" order by id');
        while($row=mysql_fetch_row($res)){
            $res1=mysql_query('select distinct ip from '.$PREFIX.'visits where uid='.$row[0]);
            while($row1=mysql_fetch_row($res1)){
                $ips[]=$row1[0];
            }
            echo '<tr><td width><a href="?component=counter&action=1&clid='.$row[0].'&date='.$_GET['date'].'">'.$row[1].'</a></td><td>'.$row[2].'</td><td>'.implode(',', $ips).'</td><td>'.date("Hч.:iмин.", $row[3]).'</td></tr>';
            unset($ips);
        }
        echo '</table>'; 
    } elseif($cmd=='pg') {
        echo '<br><br>'.$menu.'<br><br><table width="100%"><td width=440>Страница</td><td>Кол-во визитов</td></tr>';
        $res=mysql_query('select page from '.$PREFIX.'visits where '.$vquery.' order by id');
        while($row=mysql_fetch_row($res)){
            $pages[$row[0]]+=1;
        }
        arsort($pages);
        foreach($pages as $page=>$amt){
            echo '<tr><td><a href="'.$PATH.$page.'" target="_blank">'.$page.'</a></td><td>'.$amt.'</td></tr>';
        }
        echo '</table>';
    } elseif($cmd=='pgnb') {
        echo '<br><br>'.$menu.'<br><br><table width="100%"><td width=440>Страница</td><td>Кол-во визитов</td></tr>';

        echo '</table>';
    } elseif($cmd=='visnb') {
        echo '<br><br>'.$menu.'<br><br><table width="100%"><td width=130>ID</td><td>браузер</td><td>ip</td><td width=50>время</td></tr>';
        $res=mysql_query('select id,name,browser,intime from '.$PREFIX.'visitors where '.$inquery.' and browser!="" and browser not like "%bot%" and browser not like "%andex%" and browser not like "%spider%" and browser not like "%Mail.RU%" and browser not like "%crawler%" order by id');
        while($row=mysql_fetch_row($res)){
            $res1=mysql_query('select distinct ip from '.$PREFIX.'visits where uid='.$row[0]);
            while($row1=mysql_fetch_row($res1)){
                $ips[]=$row1[0];
            }
            $id=($row[1])?$row[1]:$row[0];
      
            echo '<tr><td>'.$id.'</td><td>'.$row[2].'</td><td>'.implode(',', $ips).'</td><td>'.date("Hч.:iмин.", $row[3]).'</td></tr>';
            unset($ips);
        }
        echo '</table>';
    }
} elseif($_GET['clid']) {
    echo '<br><br>'.$menu.'<br><br><table width="100%"><td>время</td><td width=440>Страница</td><td>откуда</td></tr>';
    $res=mysql_query('select page,refer,vtime from '.$PREFIX.'visits where uid='.$_GET['clid'].' and '.$vquery);
    while($row=mysql_fetch_row($res)){
        echo '<tr><td>'.date("H:i:s", $row[2]).'</td><td>'.$row[0].'</td><td>'.$row[1].'</td></tr>';
    }
    echo '</table>';
} else {
    $res=mysql_query('select count(id) from '.$PREFIX.'visitors where '.$inquery);
    $row=mysql_fetch_row($res);
    $res1=mysql_query('select distinct name from '.$PREFIX.'visitors where '.$inquery);
    $num=mysql_num_rows($res1);
    $num=($num>0)?$num-1:$num;
    $res2=mysql_query('select count(id) from '.$PREFIX.'visits where '.$vquery);
    $row2=mysql_fetch_row($res2);
    $res3=mysql_query('select a.page,b.id,b.browser from '.$PREFIX.'visits as a, '.$PREFIX.'visitors as b where b.id=a.uid and '.$inquery2.' and browser!="" and b.browser not like "%bot%" and b.browser not like "%andex%" and b.browser not like "%Mail.RU%" and b.browser not like "%spider%" and b.browser not like "%crawler%"');
    $i=0;
    $users=Array();
    while($row3=mysql_fetch_row($res3)){
        if(!in_array($row3[1], $users)) {
            $users[]=$row3[1];
        }
        $i++;
    }
    $users=array_unique($users);
    $num1=count($users);

    ?>
<br><br>
    <?php echo $menu ?>
<br><br>
<table width="100%">
<tr>
<td width=130><b>Без ботов</b></td><td></td>
</tr>
<tr>
<td>Посетителей сегодня</td><td><a href='?component=counter&action=1&cmd=visnb<?php echo $link ?>'><?php echo $num1 ?></a></td>
</tr>
<tr>
<td>Клиентов сегодня</td><td><a href='?component=counter&action=1&cmd=client<?php echo $link ?>'><?php echo $num ?></a></td>
</tr>
<tr>
<td>Просмотрено страниц</td><td><a href='?component=counter&action=1&cmd=pgnb<?php echo $link ?>'><?php echo $i ?></a></td>
</tr>
<tr>
<td>Переходы с сайтов</td><td></td>
</tr>
<tr>
<td height=20></td><td></td>
</tr>
<tr>
<td><b>Включая ботов</b></td><td></td>
</tr>
<tr>
<td>Посетителей сегодня</td><td><a href='?component=counter&action=1&cmd=vis<?php echo $link ?>'><?php echo $row[0] ?></a></td>
</tr>
<tr>
<td>Просмотрено страниц</td><td><a href='?component=counter&action=1&cmd=pg<?php echo $link ?>'><?php echo $row2[0] ?></a></td>
</tr>
</table>
    <?php
}
?>
