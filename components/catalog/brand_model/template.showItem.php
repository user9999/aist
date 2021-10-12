<?php $t = array("есть", "нет", "ожидается"); 
$pictitle=$TEMPLATE['br']." ".$TEMPLATE['md']." ".$TEMPLATE['description'];
$buydesc=trim(str_replace("(метал)", "", $TEMPLATE['description']));
$mycss="<link rel=\"stylesheet\" href=\"/inc/prettyPhoto.css\" type=\"text/css\" media=\"screen\" title=\"prettyPhoto main stylesheet\" charset=\"utf-8\">
";
set_css($mycss);
$script="<script src=\"/inc/jquery.prettyPhoto.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
set_script($script);
if ($TEMPLATE['model_variants']) {
    $TEMPLATE_models = str_replace(";", ", ", $TEMPLATE['model_variants']);
}
$urls=array_flip($TEMPLATE['urls']);
$catlink=($TEMPLATE['br']=='Mercedes Benz')?'m-b':strtolower($TEMPLATE['br']);
?>
<div itemscope itemtype="http://data-vocabulary.org/Product" class="content_body" id="position">
<?php if(!trim($_GET['t']) || !trim($_GET['b'])) { ?>
<h3><span itemprop="brand"><?php echo ($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'] ?> <?php echo ($TEMPLATE['altmodel']) ? $TEMPLATE['altmodel'] : $TEMPLATE['model'] ?></span> <b><span itemprop="name"><?php echo $TEMPLATE['description'] ?></span></b></h3>
<?php } else { 
    $_GET['t'] = ereg_replace("[^A-Za-zА-Яа-я0-9 -/]", "", $_GET['t']);
    $_GET['b'] = ereg_replace("[^A-Za-zА-Яа-я0-9 -]", "", $_GET['b']);
    ?>
<h3><b><span itemprop="name"><?php echo $TEMPLATE['description'] ?></span></b> <span itemprop="brand"><?php echo $urls[$_GET['b']] ?> <?php echo $_GET['t'] ?></span></h3>
<?php } ?>
<a class=underlined href="<?php echo $GLOBALS['PATH'] ?>/catalog/<?php echo $catlink ?>"><span itemprop="category" content="Запчасти <?php echo $TEMPLATE['br'] ?>">Запчасти <?php echo $TEMPLATE['br'] ?></span></a> &gt;&gt; <a class=underlined href="<?php echo $GLOBALS['PATH'] ?>/catalog/model-<?php echo $TEMPLATE['murls'][$TEMPLATE['md']] ?>">Запчасти <?php echo $urls[$_GET['b']] ?> <?php echo $TEMPLATE['md'] ?></a> &gt;&gt; <b><?php echo $TEMPLATE['description'] ?> <?php echo $TEMPLATE['br'] ?></b>
<table style="width:100%;padding-top:8px">
<tr style="vertical-align:top;">
<td>
<table style="width:100%;margin-top:0px" class=tb>
<tr>
<td class="tbg">OEM:</td>
<td><span itemprop="identifier" content="oem:<?php echo $TEMPLATE['oem'] ?>"><?php echo $TEMPLATE['oem'] ?></span></td>
</tr>
<tr>
<td class=tbg>Марка:</td>
<td>
<?php
 $brand=($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'];
 $brand=($TEMPLATE['br']!=$brand)?$TEMPLATE['br'].", ".$brand:$brand;
 echo $brand;
?>
</td>
</tr>
<tr>
<td class=tbg>Модель:</td>
<td><?php echo ($TEMPLATE['altmodel']) ? $TEMPLATE['altmodel'] : $TEMPLATE['model'] ?>
                            <?php if ($TEMPLATE['model_variants']) { ?>
                                , <?php echo $TEMPLATE_models ?>
                            <?php } ?>
</td>
</tr>
<?php if($TEMPLATE['country']) { ?>
<tr>
<td class=tbg>Производитель:</td>
<td><?php echo $TEMPLATE['country'] ?></td>
</tr>
<?php } ?>
<?php if($TEMPLATE['oem_variants']) { ?>
<tr>
<td class=tbg>OEM /варианты/:</td>
<td><?php echo $TEMPLATE['oem_variants'] ?></td>
</tr>
<?php } ?>
<tr>
<td class=tbg>Наличие:</td>
<td>
<?php
if($TEMPLATE['available']<1) {
    if($TEMPLATE['waitingfor'] && $TEMPLATE['waitingfor']!='архив') {
        $avail=$TEMPLATE['waitingfor'];
    } elseif($TEMPLATE['waitingfor']=='архив') {
        $avail="архив";
    } else {
        $avail="нет";
    }
} elseif($TEMPLATE['available']>3) {
    $avail="<span itemprop=\"availability\" content=\"in_stock\">более 3 шт.</span>";
} else {
    $avail="<span itemprop=\"availability\" content=\"in_stock\">".$TEMPLATE['available']." шт.</span>";
}
echo $avail;
?>
</td>
</tr>
<?php if ($TEMPLATE['price']) { ?>
<tr>
<td class=tbg><meta itemprop="currency" content="RUB" />Цена:</td>
<td><b><span style='color:red;'><span itemprop="price"><?php echo $TEMPLATE['price'] ?></span> руб.</span></b></td>
</tr>
<?php } ?>
<?php if($TEMPLATE['special']) { ?>
<tr>
<td class=tbg>Акции:</td>
<td style="color:red;font-weight:bold">Старая цена <?php echo floor($TEMPLATE['special']) ?> руб.</td>
</tr>
<?php } ?>
<?php if($TEMPLATE['price']) { ?>
<tr>
    <?php
    if($TEMPLATE['waitingfor']!='архив') {
        ?>                    
<td colspan="2"><a class=addtcrt title="купить <?php echo $buydesc.' '.$picbr ?>" style="float:left" onclick="addToCart(<?php echo $TEMPLATE['id'] ?>, <?php echo $TEMPLATE['price'] ?>);" <?php echo ($TEMPLATE['available']<1)?"style='background:#007'":""; ?>><?php echo ($TEMPLATE['available']<1)?"Заказать":"Добавить в корзину"; ?></a> <input style="width:25px;height:25px;margin:16px 0 0 5px;font-size:16px" id="i<?php echo $TEMPLATE['id'] ?>" value="1"> шт.</td>
    <?php } else {
        echo "<td colspan=\"2\" style=\"font-size:16px;color:#700\">Временно не поставляется</td>";
    }
    ?>
</tr>
<?php } ?>
</table>
</td>
<td style="width:340px">
<?php
        $brs=explode(" ", $TEMPLATE['br']);
        $mds=explode(" ", $TEMPLATE['md']);
        $rmdls=explode(" ", $TEMPLATE['rusmodel']); 
                $fl = "";
if (file_exists("uploaded/{$TEMPLATE['aid']}.jpeg")) { $fl = "{$GLOBALS['PATH']}/uploaded/{$TEMPLATE['aid']}.jpeg";
}
if (file_exists("uploaded/{$TEMPLATE['aid']}.png")) { $fl = "{$GLOBALS['PATH']}/uploaded/{$TEMPLATE['aid']}.png";
}
if (file_exists("uploaded/{$TEMPLATE['aid']}.gif")) { $fl = "{$GLOBALS['PATH']}/uploaded/{$TEMPLATE['aid']}.gif";
}
        
if (file_exists("uploaded/big_{$TEMPLATE['aid']}.jpeg")) {
      $ext=".jpeg";
}
if (file_exists("uploaded/big_{$TEMPLATE['aid']}.png")) {
      $ext=".png";
}
if (file_exists("uploaded/big_{$TEMPLATE['aid']}.gif")) {
      $ext=".gif";
}            
if ($fl) {
      $imgs="";
    if(glob("uploaded/big_".$TEMPLATE['aid']."_*".$ext)) {
        foreach(glob("uploaded/big_".$TEMPLATE['aid']."_*".$ext) as $img){
             $imgs.="<li style=\"display:none\"><a href=\"".$GLOBALS['PATH']."/".$img."\" rel=\"prettyPhoto[gallery1]\" title=\"".$pictitle."\">
				<img {$TEMPLATE['alt']} src='$fl' style=\"cursor:pointer\"></a></li>";
        }
    }
        $alt=str_replace("{brand}", $TEMPLATE['br'], $TEMPLATE['alt']);
        $alt=str_replace("{brand1}", $brs[0], $alt);        
        $alt=str_replace("{model}", $TEMPLATE['md'], $alt);    
        $alt=str_replace("{model1}", $mds[0], $alt);
        $alt=str_replace("{model2}", $mds[0]." ".$mds[1], $alt);
        $alt=str_replace("{rusbrand}", mb_strtolower($TEMPLATE['rusbrand'], "UTF-8"), $alt);
        $alt=str_replace("{rusmodel}", mb_strtolower($TEMPLATE['rusmodel'], "UTF-8"), $alt);
        $alt=str_replace("{rusmodel1}", mb_strtolower($rmdls[0], "UTF-8"), $alt);
    if(preg_match_all("!\{[a-z0-9-_]+,[^\{]+\}!is", $alt, $match)) {
        $brk=Array("{","}");
        $mtch=str_replace($brk, "", $match[0][0]);
        $mtch=explode(",", $mtch);
        foreach($mtch as $d1=>$d2){
            if(stristr($_GET['t'], $d2)) {
                $alt=str_replace($match[0], $d2, $alt);
                break;
            }
        }
    }
        echo "<div style='width:".$GLOBALS['IMAGE_MAXSIZE'].";height=".$GLOBALS['IMAGE_HMAXSIZE'].";border:1px solid black;display: table-cell;text-align:center;vertical-align: middle;background:#fff'>
<ul class=\"gallery clearfix\" style=\"list-style-type:none\">
<li><a href=\"/uploaded/big_".$TEMPLATE['aid'].$ext."\" rel=\"prettyPhoto[gallery1]\" title=\"".$pictitle."\">
<img  itemprop=\"image\" $alt src='$fl' style=\"cursor:pointer;border:0\"></a></li>$imgs
</ul>
</div>";
} else {
    echo "<div style='width:".$GLOBALS['IMAGE_MAXSIZE'].";height=".$GLOBALS['IMAGE_HMAXSIZE'].";border:1px solid black;display: table-cell;text-align:center;vertical-align: middle;background:#fff'><img src='/img/nofoto.jpg' alt=''></div>";
}
?>
</td>
</tr>
</table>
<?php if ($TEMPLATE['adescription']) { ?>
<br>
<h3>Описание товара</h3>
<div itemprop="description" class=item_desc style="padding: 5px; padding-top: 0px;">
    <?php
    $rusbrand=explode(" ", $TEMPLATE['rusbrand']);
    $description=str_replace("{brand}", $TEMPLATE['br'], $TEMPLATE['adescription']);
    $description=str_replace("{brand1}", $brs[0], $description);        
    $description=str_replace("{model}", $TEMPLATE['md'], $description);    
    $description=str_replace("{model1}", $mds[0], $description);
    $description=str_replace("{model2}", $mds[0]." ".$mds[1], $description);
    $description=str_replace("{rusbrand}", mb_strtolower($TEMPLATE['rusbrand'], "UTF-8"), $description);
    $description=str_replace("{rusbrand1}", mb_strtolower($rusbrand[0], "UTF-8"), $description);
    $description=str_replace("{rusmodel}", mb_strtolower($TEMPLATE['rusmodel'], "UTF-8"), $description);
    $description=str_replace("{rusmodel1}", mb_strtolower($rmdls[0], "UTF-8"), $description);
    if(preg_match_all("!\{[a-z0-9-_]+,[^\{]+\}!is", $description, $match)) {
        $brk=Array("{","}");
        $mtch=str_replace($brk, "", $match[0][0]);
        $mtch=explode(",", $mtch);
        foreach($mtch as $d1=>$d2){
            if(stristr($_GET['t'], $d2)) {
                $description=str_replace($match[0], $d2, $description);
                break;
            }
        }
    } 
    echo $description;
    ?>
</div>
<?php } ?>
</div>
<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
$(".gallery a[rel^='prettyPhoto']").prettyPhoto({theme:'facebook'});
});
</script>
