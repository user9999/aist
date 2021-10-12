<?php
class Tabs
{
    function getTabs($content)
    {
        preg_match_all("!{tab ([^}]+)}!is", $content, $matches);
        $begin="<div class=\"nn_tabs oldschool\"><ul class=\"nav nav-tabs\" id=\"set-nn_tabs-1\">";
        foreach ($matches[1] as $num=>$val) {
                $active=($num==0)?" active":"";
                $valurl=preg_replace("!\s!", "-", $val);
                $begin.="<li class=\"nn_tabs-tab{$active}\">
                <a href=\"#{$valurl}\" data-toggle=\"tab\">{$val}</a>
                </li>";
            if ($num==0) {
                $content=str_replace($matches[0][$num], "<div class=\"tab-pane active\" id=\"{$valurl}\">", $content);
            } else {
                $content=str_replace($matches[0][$num], "</div><div class=\"tab-pane\" id=\"{$valurl}\">", $content);
            }
        }
        $count=0;
        $content=str_replace("{/tabs}", "</div></div>", $content, $count);
        if ($count==0) {
            $content.="</div></div>";
        }
        $begin.="</ul>";
        $new="<div class=\"tab-content\">";

                    //$content=preg_replace("!{tab [^}]+}!is","",$content,-1,$count);
                    //$s.=var_export($count,true);
        $content=$begin.$new.$content;
        return $content;
    }
}
?>
