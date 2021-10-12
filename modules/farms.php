<?php
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
$res=mysql_query('select * from '.$PREFIX.'farms where display=1 order by position');
$a=1;
while ($row=mysql_fetch_row($res)) {
    //echo $row[0];
    $pictitle=str_replace('"', "'", $row[1]);
    $imgs="";
    $first="";
    $gal="";
    $about=strip_tags(stripslashes($row[2]));
    if (trim($about)!="") {
        $lenstr=strlen($about);//(strlen($about)>99)?99:strlen($about)-2;
        if (strlen($about)>99) {
            $about=substr($about, 0, strpos($about, " ", 99));
        } else {
            $about=$about;//substr($about,0,strpos($about," "));
        }
        //echo "<!--lenstr - ".$lenstr." ; strlen - ".$s."\n";
        //echo strpos($about," ",$lenstr);
        //echo "\n-->";
        //$about=substr($about,0,strpos($about," ",$lenstr));
    } else {
        $about="Подробнее";
    }
    if (glob($GLOBALS['HOSTPATH']."/uploaded/farms/small_".$row[0]."*.*")) {
        foreach (glob($GLOBALS['HOSTPATH']."/uploaded/farms/small_".$row[0]."*.*") as $img) {//$GLOBALS['HOSTPATH']."/uploaded/farms/small_".$row[0].".*"
            $img1=str_replace($GLOBALS['HOSTPATH'], $GLOBALS['PATH'], $img);
            break;
        }
  
  
        //if(glob("uploaded/big_".$TEMPLATE['aid']."_*".$ext)){
        foreach (glob($GLOBALS['HOSTPATH']."/uploaded/farms/big_".$row[0]."*.*") as $img) {
            $img=str_replace($GLOBALS['HOSTPATH'], '', $img);
            if ($first=="") {
                $first="<li><a href=\"".$GLOBALS['PATH'].$img."\" rel=\"prettyPhoto[gallery".$a."]\" title=\"".$pictitle."\">
<img alt=\"".$pictitle."\" src='".$img1."' style=\"cursor:pointer\"></a></li>";
            } else {
                $imgs.="<li style=\"display:none\"><a href=\"".$GLOBALS['PATH'].$img."\" rel=\"prettyPhoto[gallery".$a."]\" title=\"".$pictitle."\">
<img alt=\"".$pictitle."\" src='".$img1."' style=\"cursor:pointer\"></a></li>";
            }
        }
        $gal="<div style='border:1px solid black;display: table-cell;text-align:center;vertical-align: middle;background:#fff'>
<ul class=\"gallery clearfix\" style=\"list-style-type:none\">".$first.$imgs."
</ul>
</div>";
    }
    //}
  
    $out.="<tr><td colspan=\"2\" style=\"background:#fea100;text-align:center;font-weight:bold\"><a class='farms' href='".$GLOBALS['PATH']."/farms/".$row[0]."'>".$row[1]."</a></td></tr>
<tr><td style=\"background:#fea100;padding-left:5px !important;\" valign=\"top\">$gal
</td><td valign=\"top\" style=\"background:#fea100;padding-right:10px;padding-left:5px\">".$about."... <a href='".$GLOBALS['PATH']."/farms/".$row[0]."'>&gt;&gt;&gt;</a>
</td></tr>
<tr><td colspan=\"2\" style=\"background:#fea100;padding-left:5px !important;\">....................................................</td></tr>";
    $a++;
}

echo $out;
