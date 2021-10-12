<?php if (!defined("SIMPLE_CMS")) {
    die("Access denied");
}

if (preg_match("!^[a-zA-Z0-9_]{3,5}$!", $_GET['id'], $match)) {
    $gal="";

    $res=mysql_query('select * from '.$PREFIX.'farms where id="'.$_GET['id'].'" limit 1');
    //echo 'select * from farms where id="'.$_GET['id'].'" limit 1';
    $row=mysql_fetch_row($res);
    if ($row) {
        $pictitle=$row[1];
        set_title($row[1]);
        set_meta("", str_replace('"', '', $row[1])." - ".$GLOBALS['SITE_TITLE']);
        foreach (glob($GLOBALS['HOSTPATH']."/uploaded/farms/".$row[0]."*.*") as $img) {//$GLOBALS['HOSTPATH']."/uploaded/farms/small_".$row[0].".*"
            $img1=str_replace($GLOBALS['HOSTPATH'], $GLOBALS['PATH'], $img);
            break;
        }
        $imgs="";
        $first="";
        foreach (glob($GLOBALS['HOSTPATH']."/uploaded/farms/big_".$row[0]."*.*") as $img) {
            $img=str_replace($GLOBALS['HOSTPATH'], '', $img);
            if ($first=="") {
                $first="<li><a href=\"".$GLOBALS['PATH'].$img."\" rel=\"prettyPhoto[gallery]\" title=\"".$pictitle."\">
<img alt='".$pictitle."' src='".$img1."' style=\"cursor:pointer\"></a></li>";
            } else {
                $imgs.="<li style=\"display:none\"><a href=\"".$GLOBALS['PATH'].$img."\" rel=\"prettyPhoto[gallery]\" title=\"".$pictitle."\">
<img alt='".$pictitle."' src='".$img1."' style=\"cursor:pointer\"></a></li>";
            }
        }

  
        $gal.="<div style='width:335px;margin:20px auto;'><div style='border:0;display: table-cell;text-align:center;vertical-align: middle;background:#fff;'>
<ul class=\"gallery clearfix\" style=\"list-style-type:none\">".$first.$imgs."
</ul>
</div></div>";
    }
    //var_dump($gal);
    $farm=$_GET['id'];
}
?>
<div class="content_body">
<h3><?php echo $row[1] ?></h3>
<br><h4 style="text-align:center;padding-bottom:0">(<a href='/catalog/farm-<?php echo $farm ?>'>Вся продукция</a>)</h4><br>
<?php echo $row[2] ?>
<br><br>
<?php echo $gal ?>
</div>
