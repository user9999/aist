<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
$css="<style>
#calendar3 {
  width: 100%;
  font: monospace;
  line-height: 1.2em;
  font-size: 15px;
  text-align: center;
}
#calendar3 thead tr:last-child {
  font-size: small;
  color: rgb(85, 85, 85);
}
#calendar3 tbody td {
  color: rgb(44, 86, 122);
}
#calendar3 tbody td:nth-child(n+6), #calendar3 .holiday {
  color: rgb(231, 140, 92);
}
#calendar3 tbody td.today {
  outline: 3px solid red;
}
</style>";
set_css($css);

//var_dump($catalog);echo "<br>\n";
//var_dump($segments);echo "<br>\n";
//var_dump($last_section);echo "<br>\n";
//var_dump($GLOBALS);
if(!$segments) {
    $res=mysql_query("select a.id,a.alias,b.title,b.content from ".$PREFIX."services as a, ".$PREFIX."lang_text as b where b.table_name='services' and language='{$userlanguage}' and a.id=b.rel_id order by a.position");
    while($row=mysql_fetch_row($res)){
        render_to_template("components/services/template.services.php", array('title'=>$row[2],'id'=>$row[0],'altname'=>$row[1],'content'=>$row[3]));
    }
}
?>

<table id="calendar3">
  <thead>
    <tr><td colspan="4"><select>
<option value="0"><?php echo $GLOBALS['dblang_January'][$GLOBALS['userlanguage']] ?></option>
<option value="1"><?php echo $GLOBALS['dblang_February'][$GLOBALS['userlanguage']] ?></option>
<option value="2"><?php echo $GLOBALS['dblang_March'][$GLOBALS['userlanguage']] ?></option>
<option value="3"><?php echo $GLOBALS['dblang_April'][$GLOBALS['userlanguage']] ?></option>
<option value="4"><?php echo $GLOBALS['dblang_May'][$GLOBALS['userlanguage']] ?></option>
<option value="5"><?php echo $GLOBALS['dblang_June'][$GLOBALS['userlanguage']] ?></option>
<option value="6"><?php echo $GLOBALS['dblang_July'][$GLOBALS['userlanguage']] ?></option>
<option value="7"><?php echo $GLOBALS['dblang_August'][$GLOBALS['userlanguage']] ?></option>
<option value="8"><?php echo $GLOBALS['dblang_September'][$GLOBALS['userlanguage']] ?></option>
<option value="9"><?php echo $GLOBALS['dblang_October'][$GLOBALS['userlanguage']] ?></option>
<option value="10"><?php echo $GLOBALS['dblang_November'][$GLOBALS['userlanguage']] ?></option>
<option value="11"><?php echo $GLOBALS['dblang_December'][$GLOBALS['userlanguage']] ?></option>
</select><td colspan="3"><input type="number" value="<?php echo date("Y", time()) ?>" min="0" max="9999" size="4"></td></tr>
    <tr><td><?php echo $GLOBALS['dblang_monday'][$GLOBALS['userlanguage']] ?><td><?php echo $GLOBALS['dblang_tuesday'][$GLOBALS['userlanguage']] ?><td><?php echo $GLOBALS['dblang_wednesday'][$GLOBALS['userlanguage']] ?><td><?php echo $GLOBALS['dblang_thursday'][$GLOBALS['userlanguage']] ?><td><?php echo $GLOBALS['dblang_friday'][$GLOBALS['userlanguage']] ?><td><?php echo $GLOBALS['dblang_saturday'][$GLOBALS['userlanguage']] ?><td><?php echo $GLOBALS['dblang_sunday'][$GLOBALS['userlanguage']] ?></td></tr></thead>
  <tbody></tbody>
</table>

<script>
function Calendar3(id, year, month) {
var Dlast = new Date(year,month+1,0).getDate(),
    D = new Date(year,month,Dlast),
    DNlast = D.getDay(),
    DNfirst = new Date(D.getFullYear(),D.getMonth(),1).getDay(),
    calendar = '<tr>',
    m = document.querySelector('#'+id+' option[value="' + D.getMonth() + '"]'),
    g = document.querySelector('#'+id+' input');
if (DNfirst != 0) {
  for(var  i = 1; i < DNfirst; i++) calendar += '<td>';
} else {
  for(var  i = 0; i < 6; i++) calendar += '<td>';
}
for(var  i = 1; i <= Dlast; i++) {
  if (i == new Date().getDate() && D.getFullYear() == new Date().getFullYear() && D.getMonth() == new Date().getMonth()) {
    calendar += '<td class="today">' + i;
  } else {
    if (  // список официальных праздников
        (i == 1 && D.getMonth() == 0 && ((D.getFullYear() > 1897 && D.getFullYear() < 1930) || D.getFullYear() > 1947)) || // Новый год
        (i == 2 && D.getMonth() == 0 && D.getFullYear() > 1992) || // Новый год
        ((i == 3 || i == 4 || i == 5 || i == 6 || i == 8) && D.getMonth() == 0 && D.getFullYear() > 2004) || // Новый год
        (i == 7 && D.getMonth() == 0 && D.getFullYear() > 1990) || // Рождество Христово
        (i == 23 && D.getMonth() == 1 && D.getFullYear() > 2001) || // День защитника Отечества
        (i == 8 && D.getMonth() == 2 && D.getFullYear() > 1965) || // Международный женский день
        (i == 1 && D.getMonth() == 4 && D.getFullYear() > 1917) || // Праздник Весны и Труда
        (i == 9 && D.getMonth() == 4 && D.getFullYear() > 1964) || // День Победы
        (i == 12 && D.getMonth() == 5 && D.getFullYear() > 1990) || // День России (декларации о государственном суверенитете Российской Федерации ознаменовала окончательный Распад СССР)
        (i == 7 && D.getMonth() == 10 && (D.getFullYear() > 1926 && D.getFullYear() < 2005)) || // Октябрьская революция 1917 года
        (i == 8 && D.getMonth() == 10 && (D.getFullYear() > 1926 && D.getFullYear() < 1992)) || // Октябрьская революция 1917 года
        (i == 4 && D.getMonth() == 10 && D.getFullYear() > 2004) // День народного единства, который заменил Октябрьскую революцию 1917 года
       ) {
      calendar += '<td class=\"holiday\"><a href=/services/?d=' + i+ '&m='+D.getMonth()+'&y='+D.getFullYear()+'>'+i+'</a>';
    } else {
      calendar += '<td><a href=/services/?d=' + i+ '&m='+D.getMonth()+'&y='+D.getFullYear()+'>' + i+'</a>';
    }
  }
  if (new Date(D.getFullYear(),D.getMonth(),i).getDay() == 0) {
    calendar += '<tr>';
  }
}
for(var  i = DNlast; i < 7; i++) calendar += '<td>&nbsp;';
document.querySelector('#'+id+' tbody').innerHTML = calendar;
g.value = D.getFullYear();
m.selected = true;
if (document.querySelectorAll('#'+id+' tbody tr').length < 6) {
    document.querySelector('#'+id+' tbody').innerHTML += '<tr><td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;<td>&nbsp;';
}
document.querySelector('#'+id+' option[value="' + new Date().getMonth() + '"]').style.color = 'rgb(220, 0, 0)'; // в выпадающем списке выделен текущий месяц
}
Calendar3("calendar3",new Date().getFullYear(),new Date().getMonth());
document.querySelector('#calendar3').onchange = function Kalendar3() {
  Calendar3("calendar3",document.querySelector('#calendar3 input').value,parseFloat(document.querySelector('#calendar3 select').options[document.querySelector('#calendar3 select').selectedIndex].value));
}
</script>
