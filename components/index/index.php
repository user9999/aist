<?php 
if (!defined("SIMPLE_CMS")) { die("Access denied");
} 
set_title("Главная");
set_meta("", "");
$res=mysql_query("SELECT * FROM ".$PREFIX."frontpage where display=1 order by position");
if(mysql_num_rows($res)==0) {

} else {
    $frontimg="<div id=\"rotator\">
  <ul>";
    $i=0;
    $blink="";$elink="";
    while($row=mysql_fetch_row($res)){
        $class=($i==0)?" class=\"show\"":"";
        if($row[4]!="") {
            $blink="<a href=\"".$row[4]."\">";
            $elink="</a>";
        }
        $frontimg.="<li$class>$blink<img src=\"uploaded/front/".$row[0]."\" alt=\"".$row[1]."\" width=\"$FRIMG_WIDTH\" height=\"$FRIMG_HEIGHT\">$elink</li>";
        $i++;
    }
    $frontimg.="</ul>
</div>";
    //echo $frontimg;
}
?>
