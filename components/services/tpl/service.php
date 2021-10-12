<a href='/services' class=return><?php echo $GLOBALS['dblang_returnServices'][$GLOBALS['userlanguage']]?></a>
<div class="sections">
<h3><?php echo $TEMPLATE['title'] ?></h3>
    
    <p><?php echo $TEMPLATE['content'] ?></p>
</div>
<?php

// �������������� �������
$self = $_SERVER['PHP_SELF'];

// ���������, ���� � ���������� month ���� ����������� � URL-������,
//���� ���������� PHP ������� date(), ����� ���������� ������� �����.
if(isset($_GET['month'])) { 
    $month = $_GET['month'];
} elseif(isset($_GET['viewmonth'])) { 
    $month = $_GET['viewmonth'];
} else { 
    $month = date('m');
}

// ������ �� ��������, ���� ���������� ���� ��������������� � URL,
//���� ������������ PHP ������� date(),
//����� ���������� ������� ���, ���� ������� ��� �� ���������� � URL-������.
if(isset($_GET['year'])) { 
    $year = $_GET['year'];
} elseif(isset($_GET['viewyear'])) { 
    $year = $_GET['viewyear'];
} else { 
    $year = date('Y');
}

if($month == '12') { 
    $next_year = $year + 1;
} else { 
    $next_year = $year;
}
    
    
$Month_r = array(
"1" => $GLOBALS['dblang_January'][$GLOBALS['userlanguage']],
"2" => $GLOBALS['dblang_February'][$GLOBALS['userlanguage']],
"3" => $GLOBALS['dblang_March'][$GLOBALS['userlanguage']],
"4" => $GLOBALS['dblang_April'][$GLOBALS['userlanguage']],
"5" => $GLOBALS['dblang_May'][$GLOBALS['userlanguage']],
"6" => $GLOBALS['dblang_June'][$GLOBALS['userlanguage']],
"7" => $GLOBALS['dblang_July'][$GLOBALS['userlanguage']],
"8" => $GLOBALS['dblang_August'][$GLOBALS['userlanguage']],
"9" => $GLOBALS['dblang_September'][$GLOBALS['userlanguage']],
"10" => $GLOBALS['dblang_October'][$GLOBALS['userlanguage']],
"11" => $GLOBALS['dblang_November'][$GLOBALS['userlanguage']],
"12" => $GLOBALS['dblang_December'][$GLOBALS['userlanguage']]); 

$first_of_month = mktime(0, 0, 0, $month, 1, $year);

// ������ ���� ���� ���� � ������
$day_headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');

$maxdays = date('t', $first_of_month);
$date_info = getdate($first_of_month);
$month = $date_info['mon'];
$year = $date_info['year'];

// ���� ������� ����� ��� ������,
//� �� ������������ ��������� ����� ������� �����,
//������������ ���, ������ ����������� �� ����. 
if($month == '1') { 
    $last_year = $year-1;
} else { 
    $last_year = $year;
}

// �������� ���� ���� � ������� ��� ������,
//����� �������� � ����� �������� ������
$timestamp_last_month = $first_of_month - (24*60*60);
$last_month = date("m", $timestamp_last_month);

// ���������, ��� ���� ����� �������,
//�� ��������� ����� ����� 1, � �� 13
if($month == '12') { 
    $next_month = '1';
} else { 
    $next_month = $month+1;
}
    
$calendar = "
<div class=\"block-on-center\">
<table class='cal'>
    <tr class=tblhead>
        <td colspan='7' class='navi'>
            <a id=right href='?month=".$last_month."&year=".$last_year."'>&lt;&lt;</a>
           ".$Month_r[$month]." ".$year."
            <a id=left href='?month=".$next_month."&year=".$next_year."'>&gt;&gt;</a>
        </td>
    </tr>
    <tr>
        <td class='datehead'>".$GLOBALS['dblang_monday'][$GLOBALS['userlanguage']]."</td>
        <td class='datehead'>".$GLOBALS['dblang_tuesday'][$GLOBALS['userlanguage']]."</td>
        <td class='datehead'>".$GLOBALS['dblang_wednesday'][$GLOBALS['userlanguage']]."</td>
        <td class='datehead'>".$GLOBALS['dblang_thursday'][$GLOBALS['userlanguage']]."</td>
        <td class='datehead'>".$GLOBALS['dblang_friday'][$GLOBALS['userlanguage']]."</td>
        <td class='datehead'>".$GLOBALS['dblang_saturday'][$GLOBALS['userlanguage']]."</td>
		<td class='datehead'>".$GLOBALS['dblang_sunday'][$GLOBALS['userlanguage']]."</td>
    </tr>
    <tr>"; 

// ������� ��� ������ css
$class = "";

$weekday = $date_info['wday'];

// �������� � ����� � ������� 1 - �����������, ..., 6 - �������
$weekday = $weekday-1; 
if($weekday == -1) { $weekday=6;
}

// ������������ ������� ���� ��� ������� 1
$day = 1;

// ������� ������ ���������
if($weekday > 0) { 
    $calendar .= "<td colspan='$weekday'> </td>";
}
    
while($day <= $maxdays)
{
    // ���� �������, �������� ����� �������.
    if($weekday == 7) {
        $calendar .= "</tr><tr>";
        $weekday = 0;
    }
    
    $linkDate = mktime(0, 0, 0, $month, $day, $year);

    
    // ���������, ���� ������������� ���� �������� ����������� �����.
    //���� ���, ���������� ������ ����� css, ����� �������� � 
    if((($day < 10 and "0$day" == date('d')) or ($day >= 10 and "$day" == date('d'))) and (($month < 10 and "0$month" == date('m')) or ($month >= 10 and "$month" == date('m'))) and $year == date('Y')) {
         $class = "caltoday";
    }
         
    //� ��������� ������, �������� ������ ������ �� �������
    else {
        $d = date('m/d/Y', $linkDate);

        $class = "cal";
    }
    
    //�������� �������� ��� �������
    if($weekday == 5 || $weekday == 6) { $red='style="color: red" ';
    } else { $red='';
    }      
    $r=mysql_query("select id from ".$GLOBALS[PREFIX]."service_orders where day=$day and month=$month and year=$year");
    if(mysql_num_rows($r)) {
        $class = "busy";
        $red='';
        $calendar .= "
        <td class='{$class}' title='".$GLOBALS['dblang_orderexist'][$GLOBALS['userlanguage']]."'><span ".$red.">{$day}</span>
        </td>";
    } else {
        $calendar .= "
        <td class='{$class}'><a href='?order=$day.$month.$year'><span ".$red.">{$day}</a></span>
        </td>";
    }

    $day++;
    $weekday++;    
}

if($weekday != 7) { 
    $calendar .= "<td colspan='" . (7 - $weekday) . "'> </td>";
}

// ������� ��� ���������
echo $calendar . "</tr></table>"; 


$months = array($GLOBALS['dblang_January'][$GLOBALS['userlanguage']], $GLOBALS['dblang_February'][$GLOBALS['userlanguage']], $GLOBALS['dblang_March'][$GLOBALS['userlanguage']], $GLOBALS['dblang_April'][$GLOBALS['userlanguage']], $GLOBALS['dblang_May'][$GLOBALS['userlanguage']], $GLOBALS['dblang_June'][$GLOBALS['userlanguage']], $GLOBALS['dblang_July'][$GLOBALS['userlanguage']], $GLOBALS['dblang_August'][$GLOBALS['userlanguage']], $GLOBALS['dblang_September'][$GLOBALS['userlanguage']], $GLOBALS['dblang_October'][$GLOBALS['userlanguage']], $GLOBALS['dblang_November'][$GLOBALS['userlanguage']], $GLOBALS['dblang_December'][$GLOBALS['userlanguage']]);

echo "<form style='' method='get'><select name='month'>";
    
for($i=0; $i<=11; $i++) {
    echo "<option value='".($i+1)."'";
    if($month == $i+1) { 
        echo "selected = 'selected'";
    }
    echo ">".$months[$i]."</option>";
}
        
echo "</select>";
echo "<select name='year'>";

for($i=date('Y'); $i<=(date('Y')+20); $i++)
{
    $selected = ($year == $i ? "selected = 'selected'" : '');
    
    echo "<option value=\"".($i)."\"$selected>".$i."</option>";
}

echo "</select><input type='submit' value='".$GLOBALS['dblang_look'][$GLOBALS['userlanguage']]."' /></form>";

if($month != date('m') || $year != date('Y')) {
    echo "<a style='float: left; margin-left: 10px; font-size: 12px; padding-top: 5px;' href='?month=".date('m')."&year=".date('Y')."'>&lt;&lt; ".$GLOBALS['dblang_returndate'][$GLOBALS['userlanguage']]."</a>";
}
echo "</div>"; 

?>
