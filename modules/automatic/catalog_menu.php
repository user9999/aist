<?php
$menucss="<style type=\"text/css\">";
//we don't use view-controller model here, because this file is very simple
if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}
function make_item($level)
{
    foreach ($level as $url=>$data) {
        $menu.="<li><a href=\"{$GLOBALS['PATH']}/catalog/{$url}\">{$data['leveltitle']}</a>\n";
        $i=0;
        foreach ($data as $url1=>$data1) {
            if ($url1!='leveltitle') {
                if ($i==0) {
                    $menu.="<div style=\"opacity: 0;\"><ul>";
                }
                $menu.="<li><a href=\"{$GLOBALS['PATH']}/catalog/{$url}/{$url1}\">{$data1['leveltitle']}</a>\n";
                $j=0;
                foreach ($data1 as $url2=>$data2) {
                    if ($url2!='leveltitle') {
                        if ($j==0) {
                            $menu.="<ul>";
                        }
                        $menu.="<li><a href=\"{$GLOBALS['PATH']}/catalog/{$url}/{$url1}/{$url2}\">{$data2}</a></li>\n";

                        $j++;
                    }
                }
                if ($j>0) {
                    $menu.="</ul>";
                }
                $i++;
            }
        }
    }
    if ($i>0) {
        $menu.="</ul></div></li>";
    } else {
        $menu.="</li>";
    }
    return $menu;
}
for ($i=1;$i<=3;$i++) {
    $t.="t$i.level AS level$i,t$i.id AS id$i,t$i.name AS name$i,t$i.altname AS alias$i,";
    if ($i>1) {
        $join.=" LEFT JOIN ".$PREFIX."catalog_sections AS t$i ON t$i.parent = t".($i-1).".id";
    }
}
$t=substr($t, 0, -1);
$query="SELECT ".$t." FROM ".$PREFIX."catalog_sections as t1".$join." where t1.parent=0 and t1.showmenu=1 order by t1.position,t1.name";
$res = mysql_query($query);
$options='';$row1='';$row5="";$row9="";$flag5=0;$flag9=0;
$ar=array();$sections=array();
$i=0;
$levels=array();
while ($row=mysql_fetch_row($res)) {
    if ($row[0]==1) {
        if ($row[1]!=$row1 && $i>0) {
            $m.=make_item($levels);
            unset($levels);
        }
        $levels[$row[3]]['leveltitle']=$row[2];
        if ($row[7]!=null) {
            $levels[$row[3]][$row[7]]['leveltitle']=$row[6];
        }
        if ($row[11]!=null) {
            $levels[$row[3]][$row[7]][$row[11]]=$row[10];
        }
        $row1=$row[1];
        $i++;
    }
}
$m.=make_item($levels);
$menu="<ul id=\"nav\" class=\"brands\">\n".$m."</ul>";
echo $menu;
