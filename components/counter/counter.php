<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
if(isset($_SESSION['partnerid']) && !$_SESSION['blok']) {
    //var_dump($_GET);
    //echo "<br>";
    $pid=addslashes($_SESSION['partnerid']);
    //var_dump($_SESSION['partnerid']);
    //echo "<br>";
    //var_dump($pid);
    $stattitle=($_GET['cmd']=='orders')?"заказов":"переходов";
    ?>
<div class="content_body">
<h3>Статистика <?php echo $stattitle ?></h3>
<div style="width:50%;float:left"><a href="/counter" style="text-decoration:underline">Статистика переходов</a></div><div style="width:50%;float:left"><a href="/counter?cmd=orders" style="text-decoration:underline">Статистика заказов</a></div>
    <?php
    $today=strtotime('today');
    $vquery='vtime>'.$today;
    $v2query='a.vtime>'.$today;
    $inquery='intime>'.$today;
    $inquery2='b.intime>'.$today;
    $link='';
    $menu=($_GET['date'])?'<a href="?component=counter">Сегодня</a> ':'<a href="?component=counter"><b>Сегодня</b></a> ';
    for($i=1;$i<=10;$i++){
        $data=$today-$i*86400;
        if($_GET['date']==$i) {
            $menu.='<a href="?date='.$i.'"><b>'.date("d.m", $data).'</b></a> ';
        } else {
            $menu.='<a href="?date='.$i.'">'.date("d.m", $data).'</a> ';
        }
    }
    if(preg_match("!^[0-9]{1,2}$!", $_GET['date'], $match)) {
        $date=$_GET['date'];
    } else {
        $date="";
    }
    if($date) {
        $dfrom=$date*86400;
        $now=time()+10;
        $dtill=($date>0)?($date-1)*86400:0;
        $from=$today-$dfrom;
        $till=($date>0)?$today-$dtill:$now;
        $vquery='vtime>'.$from.' and vtime<'.$till;
        $v2query='a.vtime>'.$from.' and a.vtime<'.$till;
        $inquery='intime>'.$from.' and intime<'.$till;
        $inquery2='b.intime>'.$from.' and b.intime<'.$till;
        $link='&date='.$date;
    }
    if($_GET['cmd']) {
        $cmd=$_GET['cmd'];
  
        if($cmd=='pgnb') {
            echo '<br><br>'.$menu.'<br><br><br><table width="100%" class="tb tablesorter" id="htable"><tr class="hd"><td width=440>Страница</td><td>Кол-во визитов</td></tr>';

            $res=mysql_query('select a.page from '.$PREFIX.'visits as a, visitors as b where b.partnerid='.$pid.' and '.$v2query.' and a.uid=b.id and b.browser not like "%bot%" and b.browser not like "%andex%" and b.browser not like "%spider%" and b.browser not like "%Mail.RU%" and b.browser not like "%crawler%"');
            while($row=mysql_fetch_row($res)){
                $pages[$row[0]]+=1;
            }
            arsort($pages);
            foreach($pages as $page=>$amt){
                echo '<tr><td><a href="'.$PATH.$page.'" target="_blank">'.$page.'</a></td><td>'.$amt.'</td></tr>';
            }
            echo '</table>';

        } elseif($cmd=='visnb') {
            echo '<br><br>'.$menu.'<br><br><br><table width="100%" class="tb tablesorter" id="htable"><tr class="hd"><td width=70>ID</td><td>браузер</td><td style="width:200px !important">рефер</td><td>ip</td><td width=50>время</td></tr>';
            $res=mysql_query('select id,browser,intime from '.$PREFIX.'visitors where partnerid='.$pid.' and '.$inquery.' and browser!="" and browser not like "%bot%" and browser not like "%andex%" and browser not like "%spider%" and browser not like "%Mail.RU%" and browser not like "%crawler%" order by id');
            while($row=mysql_fetch_row($res)){
                $res1=mysql_query('select distinct ip from '.$PREFIX.'visits where uid='.$row[0]);
                $ref='';
                while($row1=mysql_fetch_row($res1)){
                    $res2=mysql_query('select refer from '.$PREFIX.'visits where ip="'.$row1[0].'" and refer!="" and refer not like "'.$PATH.'%" and refer not like "http://www.'.$_SERVER['HTTP_HOST'].'%" and uid='.$row[0].' limit 1');
                    if(mysql_num_rows($res2)>0) {
                          $row2=mysql_fetch_row($res2);
                          $ref.=$row2[0]."<br>";
                    }       
                    $ips[]=$row1[0];
                }
                $id=$row[0];
                echo '<tr><td><a href="/counter?&clid='.$id.'&date='.$date.'">'.$id.'</a></td><td>'.substr($row[1], 0, strpos($row[1], " ")).'</td><td>'.chunk_split($ref, 55).'</td><td>'.implode(',', $ips).'</td><td>'.date("Hч.:iмин.", $row[2]).'</td></tr>';
                unset($ips);
            }
            echo '</table>';
        } elseif($cmd=='from') {
            echo '<br><br>'.$menu.'<br><br><br><table width="100%" class="tb tablesorter" id="htable"><tr class="hd"><td width=30>ID</td><td width=50>Время</td><td style="width:300px !important">страница входа</td><td>откуда</td><td>запрос</td></tr>';
            $res=mysql_query('SELECT a.uid,a.page,a.refer,a.vtime FROM '.$PREFIX.'visits as a, visitors as b WHERE b.partnerid='.$pid.' and a.uid=b.id and refer!="" and refer not like "'.$PATH.'%" and refer not like "http://www.'.$_SERVER['HTTP_HOST'].'%" and '.$vquery);
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
                echo '<tr><td><a href="/counter?&clid='.$row[0].'&date='.$date.'">'.$row[0].'</a></td><td style="font-style:italic">'.date("H:i:s", $row[3]).'</td><td style="width:300px !important">'.$row[1].'</td><td><a href="'.$row[2].'" target="_blank" '.$title.'>'.$from.'</a></td><td>'.$query.'</td></tr>';
                unset($match);
            }
            echo '</table>';
        } elseif($cmd=='orders') {
            echo '<br><br><br><table style="width:100%" class="tb tablesorter" id="htable"><caption style="font-weight:bold">В обработке</caption><tr class="hd"><td width=30>ID</td><td width=80>Время</td><td style="width:240px !important">Позиции</td><td>Всего</td><td>Процент</td><td>% с заказа</td></tr>';
            $res1=mysql_query('select percent1,percent2 from '.$PREFIX.'partner_rules where id=1');
            $row1=mysql_fetch_row($res1);
    
            $res=mysql_query('select a.id,a.price,a.quantity,a.action,b.id,b.date,c.description from '.$PREFIX.'orders_items as a, '.$PREFIX.'orders as b,catalog_items as c where b.partnerid='.$pid.' and a.name=c.name and state!=2 and a.orders_id=b.id order by b.id');
            $bid=0;$out='';$end='';$prepos="";$preprice="";$preperc="";
            $btd="";$etd="";$allsum=0;
    
    
    
    
            while($row=mysql_fetch_row($res)){
                $perc=($row[3])?$row1[1]:$row1[0];
                $dsum=$row[1]*$row[2];
                $psum=$dsum*$perc/100;
                //echo $dsum."*".$perc."/100=".$psum."<br>";
                $name=$row[6];
                //echo $allsum." ";
                if($bid==$row[4]) {
                    $allsum+=$psum;
                    $prepos.='<br>'.$name.' ('.$row[2].'шт. по '.$row[1].'руб.)';
                    $preprice.="<br>".$dsum."руб.";
                    $preperc.="<br>".$perc."%";
                } else {
                    if($bid!=0) {
                        $out.=$btd.$prepos.$etd.$btd.$preprice.$etd.$btd.$preperc.$etd.'<td>'.$allsum.'руб.</td>';
                    }
                    $prepos='<br>'.$name.' ('.$row[2].'шт. по '.$row[1].'руб.)';
                    $preprice=$dsum."руб.";
                    $preperc=$perc."%";       
                    $btd="<td>";$etd="</td>";
                    $out.='<tr><td>'.$row[4].'</td><td>'.date("d/m/Y", $row[5]).'</td>';//<td>'.$name.' ('.$row[2].'шт. по '.$row[1].'руб.)';
                    $allsum=$psum;
                    //$end='<td>'.$allsum.'руб.</td>';
                }
                $bid=$row[4];
            }
            $out.=$btd.$prepos.$etd.$btd.$preprice.$etd.$btd.$preperc.$etd.'<td>'.$allsum.'руб.</td>';
            echo $out;
            echo '</table>';
            echo '<br><br><br><table style="width:100%" class="tb tablesorter" id="htable"><caption style="font-weight:bold">Обработанные</caption><tr class="hd"><td width=30>ID</td><td width=50>Время</td><td style="width:300px !important">Позиции</td><td>Всего</td><td>Процент</td><td>% с заказа</td></tr>';




            //обработанные
            $res=mysql_query('select a.id,a.price,a.quantity,a.action,a.payed,b.id,b.date,c.description from '.$PREFIX.'orders_items as a, '.$PREFIX.'orders as b,catalog_items as c where b.partnerid='.$pid.' and a.name=c.name and state=2 and a.orders_id=b.id order by b.id');
            $bid=0;$out='';$end='';$prepos="";$preprice="";$preperc="";
            $btd="";$etd="";$allsum=0;


            while($row=mysql_fetch_row($res)){
                $perc=($row[3])?$row1[1]:$row1[0];
                $dsum=$row[1]*$row[2];
                $psum=$dsum*$perc/100;
                //echo $dsum."*".$perc."/100=".$psum."<br>";
                $name=$row[6];

                if($bid==$row[5]) {
      
                    if($row[4]==2) {
                        $b='<del>';$e='</del>';
                    } else {
                        $allsum+=$psum;
                        $e='';$b='';
                    }
        
                    $prepos.='<br>'.$b.$row[7].' ('.$row[2].'шт. по '.$row[1].'руб.)'.$e;
                    $preprice.="<br>".$b.$dsum.$e."руб.";
                    $preperc.="<br>".$perc."%";  
     

                } else {
                    if($bid!=0) {
                          $out.=$btd.$prepos.$etd.$btd.$preprice.$etd.$btd.$preperc.$etd.'<td>'.$allsum.'руб.</td>';
                    }
                    $btd="<td>";$etd="</td>";
                    //$out.=$btd.$prepos.$etd.$btd.$preprice.$etd.$btd.$preperc.$etd.'<td>'.$allsum.'руб.</td>';
                    $prepos='<br>'.$row[7].' ('.$row[2].'шт. по '.$row[1].'руб.)';
                    $preprice=$dsum."руб.";
                    $preperc=$perc."%";    
                    if($row[4]==2) {
                        $allsum=0;
                        $b='<del>';$e='</del>';
                    } else {
                        $allsum=$psum;
                        $e='';$b='';
                    }
                    $out.='<tr><td>'.$row[5].'</td><td>'.date("d/m/Y", $row[6]).'</td>';//<td>'.$b.$row[0].' ('.$row[2].'шт. по '.$row[1].'руб.)'.$e;
                    //$end='<td>'.$allsum.'руб.</td>';
                    //$end='</td><td>Сумма</td><td>Процент</td><td>Сумма</td>';
                    $allsum=$psum;
                }
      
      
                $bid=$row[5];
            }
            $out.=$btd.$prepos.$etd.$btd.$preprice.$etd.$btd.$preperc.$etd.'<td>'.$allsum.'руб.</td>';
            //$out.=$end;
            echo $out;
            echo '</table><br> <p>* <i>перечеркнутым обозначен тот товар, который клиент по какой-либо причине не приобрел. В расчет вашего вознаграждения он не включается.</i></p>';
        }
    } elseif(preg_match("!^[0-9]+$!", $_GET['clid'], $match)) {


        ///проверки
        echo '<br><br>'.$menu.'<br><br><br><table width="100%" class="tb tablesorter" id="htable"><caption style="font-weight:bold">Посетитель ID: '.$_GET['clid'].'</caption><tr class="hd"><td>время</td><td width=440>Страница</td><td>откуда</td></tr>';
        $res=mysql_query('select page,refer,vtime from '.$PREFIX.'visits,'.$PREFIX.'visitors where '.$PREFIX.'visits.uid='.$PREFIX.'visitors.id and partnerid='.$pid.' and uid='.mysql_escape_string($_GET['clid']).' and '.$vquery);
        //echo 'select page,refer,vtime from visits,visitors where visits.uid=visitors.id and partnerid='.$pid.' and uid='.mysql_escape_string($_GET['clid']).' and '.$vquery;

        while($row=mysql_fetch_row($res)){
            echo '<tr><td>'.date("H:i:s", $row[2]).'</td><td>'.$row[0].'</td><td>'.$row[1].'</td></tr>';
        }
        echo '</table>';
    } else {

        $res=mysql_query('select count(id) from '.$PREFIX.'visitors where partnerid='.$pid.' and '.$inquery);
        $row=mysql_fetch_row($res);
        $res2=mysql_query('select count(id) from '.$PREFIX.'visits as a, '.$PREFIX.'visitors as b where b.partnerid='.$pid.' '.$v2query);
        $row2=mysql_fetch_row($res2);
        $res3=mysql_query('select a.page,b.id,b.browser from '.$PREFIX.'visits as a, '.$PREFIX.'visitors as b where b.id=a.uid and b.partnerid='.$pid.' and '.$inquery2.' and browser!="" and b.browser not like "%bot%" and b.browser not like "%andex%" and b.browser not like "%Mail.RU%" and b.browser not like "%spider%" and b.browser not like "%crawler%"');
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
        $res4=mysql_query('SELECT count(a.id) FROM '.$PREFIX.'visits as a, '.$PREFIX.'visitors as b WHERE b.partnerid='.$pid.' and a.uid=b.id and refer!="" and refer not like "'.$PATH.'%" and refer not like "http://www.'.$_SERVER['HTTP_HOST'].'%" and '.$vquery);
        $row4=mysql_fetch_row($res4);
        ?>
<br><br>
        <?php echo $menu ?>
<br><br><br>
<table width="100%" class="tb tablesorter" id="htable">
<tr class="hd">
<td colspan=2 width=130><b>Статистика по вашей реф. ссылке</b></td>
</tr>
<tr>
<td>Посетителей сегодня</td><td><a href='/counter?cmd=visnb<?php echo $link ?>'><?php echo $num1 ?></a></td>
</tr>
<tr>
<td>Просмотрено страниц</td><td><a href='/counter?cmd=pgnb<?php echo $link ?>'><?php echo $i ?></a></td>
</tr>
<tr>
<td>Переходы с сайтов</td><td><a href='/counter?cmd=from<?php echo $link ?>'><?php echo $row4[0] ?></a></td>
</tr>
<tr>
<td height=20></td><td></td>
</tr>
</table>
        <?php
    }
}
?>
</div>
