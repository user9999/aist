<?php if(!defined("ADMIN_SIMPLE_CMS") or !check_role()) { die('Access denied');
}
$today=strtotime('today');
$vquery='vtime>'.$today;
$inquery='intime>'.$today;
$inquery2='b.intime>'.$today;
$link='';
$menu=($_GET['date'])?'<a href="?component=counter">Сегодня</a> ':'<a href="?component=counter"><b>Сегодня</b></a> ';
for($i=1;$i<=10;$i++){
    $data=$today-$i*86400;
    if($_GET['date']==$i) {
        $menu.='<a href="?component=counter&date='.$i.'"><b>'.date("d.m", $data).'</b></a> ';
    } else {
        $menu.='<a href="?component=counter&date='.$i.'">'.date("d.m", $data).'</a> ';
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
        echo '<br><br>'.$menu.'<br><br><table width="100%"><tr style="font-weight:bold"><td width=130>ID</td><td>браузер</td><td>ip</td><td width=50>время</td></tr>';
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
        unset($res, $res1, $row, $row1, $id);
    } elseif($cmd=='client') {
        echo '<br><br>'.$menu.'<br><br><table width="100%"><tr style="font-weight:bold"><td width=130>ID</td><td>браузер</td><td>ip</td><td width=50>время</td></tr>';
        $res=mysql_query('select id,name,browser,intime from '.$PREFIX.'visitors where '.$inquery.' and name!="" order by id');
        while($row=mysql_fetch_row($res)){
            $res1=mysql_query('select distinct ip from '.$PREFIX.'visits where uid='.$row[0]);
            while($row1=mysql_fetch_row($res1)){
                $ips[]=$row1[0];
            }
            echo '<tr><td width><a href="?component=counter&clid='.$row[0].'&date='.$_GET['date'].'">'.$row[1].'</a></td><td>'.$row[2].'</td><td>'.implode(',', $ips).'</td><td>'.date("Hч.:iмин.", $row[3]).'</td></tr>';
            unset($ips);
        }
        echo '</table>';
        unset($res, $res1, $row, $row1);
    } elseif($cmd=='pg') {
        echo '<br><br>'.$menu.'<br><br><table width="100%"><tr style="font-weight:bold"><td width=440>Страница</td><td>Кол-во визитов</td></tr>';
        $res=mysql_query('select page from '.$PREFIX.'visits where '.$vquery.' order by id');
        while($row=mysql_fetch_row($res)){
            $pages[$row[0]]+=1;
        }
        arsort($pages);
        foreach($pages as $page=>$amt){
            echo '<tr><td><a href="'.$PATH.$page.'" target="_blank">'.$page.'</a></td><td>'.$amt.'</td></tr>';
        }
        echo '</table>';
        unset($res, $row, $pages, $page, $amt);
    } elseif($cmd=='pgnb') {
        echo '<br><br>'.$menu.'<br><br><table width="100%"><tr style="font-weight:bold"><td width=440>Страница</td><td>Кол-во визитов</td></tr>';

        $res=mysql_query('select a.page from '.$PREFIX.'visits as a, '.$PREFIX.'visitors as b where '.$vquery.' and a.uid=b.id and b.browser not like "%bot%" and b.browser not like "%andex%" and b.browser not like "%spider%" and b.browser not like "%Mail.RU%" and b.browser not like "%crawler%"');
        //echo 'select a.page from visits as a, visitors as b where '.$vquery.' and a.uid=b.id and b.browser not like "%bot%" and b.browser not like "%andex%" and b.browser not like "%spider%" and b.browser not like "%Mail.RU%" and b.browser not like "%crawler%" order by id';
        while($row=mysql_fetch_row($res)){
            $pages[$row[0]]+=1;
        }
        arsort($pages);
        foreach($pages as $page=>$amt){
            echo '<tr><td><a href="'.$PATH.$page.'" target="_blank">'.$page.'</a></td><td>'.$amt.'</td></tr>';
        }
        echo '</table>';
        unset($res, $row, $pages, $page, $amt);
    } elseif($cmd=='visnb') {
        echo '<br><br>'.$menu.'<br><br><table width="100%"><tr style="font-weight:bold"><td width=130>ID</td><td>браузер</td><td>ip</td><td width=50>время</td></tr>';
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
        unset($res, $res1, $row, $row1, $id);
    } elseif($cmd=='from') {
        echo '<br><br>'.$menu.'<br><br><table width="100%"><tr style="font-weight:bold"><td width=30>ID</td><td width=50>Время</td><td style="width:300px !important">страница</td><td>откуда</td><td>запрос</td></tr>';
        $res=mysql_query('SELECT uid,page,refer,vtime FROM '.$PREFIX.'visits WHERE refer!="" and refer not like "'.$PATH.'%" and refer not like "http://www.'.$_SERVER['HTTP_HOST'].'%" and '.$vquery);
        while($row=mysql_fetch_row($res)){
            if(strlen($row[2])>60) {
                $from=substr($row[2], 0, 60)."...";
                $title="title='".$row[2]."'";
            } else {
                $from=$row[2];
                $title="";
            }
            $query='';
            if(strstr($row[2], 'google') || strstr($row[2], 'mail.ru/search') || strstr($row[2], 'ask.com/web')) {
                preg_match("!q=([^&]+)!", $row[2], $match);
            } elseif(strstr($row[2], 'rambler.ru/search')) {
                preg_match("!query=([^&]+)!", $row[2], $match);
            } elseif(strstr($row[2], 'yandex.ru/')) {
                preg_match("!text=([^&]+)!", $row[2], $match);
            }
            $a=false;
            if(strpos($match[1], '%')!==false) {
                $a=strpos($match[1], '%');
            }
            $query=urldecode($match[1]);
            if($a!==false && ord($query[$a+1])>191 && ord($query[$a+1])<256) {
                $query=iconv('windows-1251', 'utf-8', $query);
            }     
            echo '<tr><td><a href="?component=counter&clid='.$row[0].'&date='.$_GET['date'].'">'.$row[0].'</a></td><td style="font-style:italic">'.date("H:i:s", $row[3]).'</td><td style="width:300px !important">'.$row[1].'</td><td><a href="'.$row[2].'" target="_blank" '.$title.'>'.$from.'</a></td><td>'.$query.'</td></tr>';
            unset($match);
        }
        echo '</table>';
        unset($res, $row, $from, $title, $query, $a);
    } elseif($cmd='site') {
        echo 'Отследить url<br><form method=get><input name=url><input type=hidden name=component value=counter><input type=hidden name=cmd value=site><input type=submit name=follow value="смотреть"></form><br>';

        if($_GET['url']) {
            echo '<br><br><a href="javascript: void(0)" onclick="window.open(\'/counter.php?cmd=site&url='.urlencode($_GET['url']).'\',\'xls\',\'width=100,height=50,top=0,left=0,resize=0\');return false" style="display: block;width:70px;"><img src="/img/csv.png" alt="" style="display: block;float:left"> XLS</a><br><table width="100%"><tr style="font-weight:bold"><td width=30>ID</td><td width=50>Время</td><td style="width:300px !important">страница</td><td>IP</td><td>браузер</td></tr>';
            $res=mysql_query('select a.id,a.uid,a.page,a.ip,a.refer,a.vtime,b.name,b.browser,b.intime from '.$PREFIX.'visits as a,'.$PREFIX.'visitors as b where refer like "%'.$_GET['url'].'%" and a.uid=b.id');
      
            //select a.id,a.uid,a.page,a.ip,a.refer,a.vtime,b.name,b.browser,b.intime from visits as a visitors as b where a.uid=b.id and a.refer like "%'.$_GET['url'].'%"');
            //echo 'select a.id,a.uid,a.page,a.ip,a.refer,a.vtime,b.name,b.browser,b.intime from visits as a visitors as b where a.uid=b.id and a.refer like "%'.$_GET['url'].'%"';
            while($row=mysql_fetch_row($res)){
                $name=($row[6])?$row[6]:$row[1];
                echo '<tr><td>'.$name.'</td><td>'.date("d/m H:i:s", $row[8]).'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[7].'</td></tr>';
            }
            echo '</table>';
        }
        unset($res, $row, $name);
    }
} elseif($_GET['clid']) {
    echo '<br><br>'.$menu.'<br><br><table width="100%"><tr style="font-weight:bold"><td>время</td><td width=440>Страница</td><td>откуда</td></tr>';
    $res=mysql_query('select page,refer,vtime from '.$PREFIX.'visits where uid='.$_GET['clid'].' and '.$vquery);
    while($row=mysql_fetch_row($res)){
        echo '<tr><td>'.date("H:i:s", $row[2]).'</td><td>'.$row[0].'</td><td>'.$row[1].'</td></tr>';
    }
    echo '</table>';
    unset($res, $row);
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
    $res4=mysql_query('SELECT count(id) FROM '.$PREFIX.'visits WHERE refer!="" and refer not like "'.$PATH.'%" and refer not like "http://www.'.$_SERVER['HTTP_HOST'].'%" and '.$vquery);
    $row4=mysql_fetch_row($res4);
    ?>
<br><br>
    <?php echo $menu ?>
<br><br>
<a href="javascript: void(0)" onclick="window.open('/counter.php?cmd=all','xls','width=100,height=50,top=0,left=0,resize=0');return false" style="display: block;width:70px;"><img src="/img/csv.png" alt="" style="display: block;float:left"> XLS</a>
<br><table width="100%">
<tr>
<td width=130><b>Без ботов</b></td><td></td>
</tr>
<tr>
<td>Посетителей сегодня</td><td><a href='?component=counter&cmd=visnb<?php echo $link ?>'><?php echo $num1 ?></a></td>
</tr>
<tr>
<td>Клиентов сегодня</td><td><a href='?component=counter&cmd=client<?php echo $link ?>'><?php echo $num ?></a></td>
</tr>
<tr>
<td>Просмотрено страниц</td><td><a href='?component=counter&cmd=pgnb<?php echo $link ?>'><?php echo $i ?></a></td>
</tr>
<tr>
<td>Переходы с сайтов</td><td><a href='?component=counter&cmd=from<?php echo $link ?>'><?php echo $row4[0] ?></a></td>
</tr>
<tr>
<td><a href='?component=counter&cmd=site<?php echo $link ?>'>Отслеживание url</a></td><td></td>
</tr>
<tr>
<td height=20></td><td></td>
</tr>
<tr>
<td><b>Включая ботов</b></td><td></td>
</tr>
<tr>
<td>Посетителей сегодня</td><td><a href='?component=counter&cmd=vis<?php echo $link ?>'><?php echo $row[0] ?></a></td>
</tr>
<tr>
<td>Просмотрено страниц</td><td><a href='?component=counter&cmd=pg<?php echo $link ?>'><?php echo $row2[0] ?></a></td>
</tr>
</table>
    <?php
}
unset($res, $res1, $row, $row1, $res2, $res3, $row2, $row3, $res4, $row4, $users, $link, $num, $num1, $i);
?>
