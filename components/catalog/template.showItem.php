<?php $t = array("есть", "нет", "ожидается"); 
$picbr=($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'];
$picmod=($TEMPLATE['altmodel']) ? $TEMPLATE['altmodel'] : $TEMPLATE['model'];
$pictitle=$TEMPLATE['description']." (". $TEMPLATE['country'].")";
$buydesc=trim(str_replace("(метал)", "", $TEMPLATE['description']));
$mycss="<link rel=\"stylesheet\" href=\"/inc/prettyPhoto.css\" type=\"text/css\" media=\"screen\" title=\"prettyPhoto main stylesheet\" charset=\"utf-8\">
";
set_css($mycss);
$script="<script src=\"/inc/jquery.prettyPhoto.js\" type=\"text/javascript\" charset=\"utf-8\"></script>";
set_script($script);
if ($TEMPLATE['model_variants']) {
    $TEMPLATE_models = str_replace(";", ", ", $TEMPLATE['model_variants']);
}
//var_dump($TEMPLATE);
?>

<div class="content_body" id="position">

        <h3><?php echo ($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'] ?> : <b><?php echo $TEMPLATE['description'] ?></b> </h3>

    <a class="underlined" href="<?php echo $GLOBALS['PATH'] ?>/catalog/<?php echo strtolower($TEMPLATE['link']) ?>"> <?php echo ($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'] ?></a> &gt;&gt; <a class="underlined" href="<?php echo $GLOBALS['PATH'] ?>/catalog/product-<?php echo $TEMPLATE['modid'] ?>">  <?php echo ($TEMPLATE['altmodel']) ? $TEMPLATE['altmodel'] : $TEMPLATE['model'] ?></a> &gt;&gt; <b><?php echo $TEMPLATE['description'] ?></b> (<?php echo $TEMPLATE['country'] ?>)
    <table style="width:100%;padding-top:8px">
        <tr style="vertical-align:top;">
            <td>
                <table style="width:100%;margin-top:0px" class="tb">
                    <tr>
                        <td class="tbg">Тип продукта:</td>
                        <td><?php echo ($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'] ?></td>
                    </tr>
                    <tr>
                        <td class="tbg">Название:</td>
                        <td><?php echo ($TEMPLATE['altmodel']) ? $TEMPLATE['altmodel'] : $TEMPLATE['model'] ?>
                            <?php if ($TEMPLATE['model_variants']) { ?>
                                , <?php echo $TEMPLATE_models ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php if ($TEMPLATE['country']) { ?>
                        <tr>
                            <td class="tbg">Производитель:</td>
                            <td><?php echo $TEMPLATE['country'] ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($TEMPLATE['oem_variants']) { ?>
                        <tr>
                            <td class="tbg">OEM /варианты/:</td>
                            <td><?php echo $TEMPLATE['oem_variants'] ?></td>
                        </tr>
                    <?php } ?>



                        <tr>
                            <td class="tbg">Наличие:</td><!--на складе-->
                            <td>
есть
                            </td>
                        </tr>




                    <?php if ($TEMPLATE['price']) { ?>
                        <tr>
                            <td class="tbg">Цена:</td>
                            <td><b><span style='color:red;'><?php echo $TEMPLATE['price'] ?> руб.</span></b></td>
                        </tr>
                    <?php } ?>
                    <?php if ($TEMPLATE['waitingfor']) { ?>
                        <!--<tr>
                            <td class="tbg">Ожидаем товар:</td>
                            <td><?php echo $TEMPLATE['waitingfor'] ?></td>
                        </tr>-->
                    <?php } ?>
                    <?php if ($TEMPLATE['special']) { ?>
                        <tr>
                            <td class="tbg">Акции:</td>
                            <td style="color:red;font-weight:bold">Старая цена <?php echo $TEMPLATE['special'] ?> руб.</td>
                        </tr>
                    <?php } ?>
                    <!--<tr>
                        <td class="tbg">Наличие:</td>
                        <td><?php echo $t[$TEMPLATE['av']] ?></td>
                    </tr>-->
                    <?php if ($TEMPLATE['price']) { ?>
                    <!--<tr>
                        <td class="tbg">Количество:</td>
                        <td>
                            <input style="width: 25px;" id="i<?php echo $TEMPLATE['id'] ?>" value="1">
                            
                        </td>
                    </tr>-->
                    <tr>
                        <?php
                        if($TEMPLATE['waitingfor']!='архив') {
                            $dimension=explode(" ", $TEMPLATE['provider']);
                            $amount=str_replace(",", ".", $dimension[0]);
                            $units=$dimension[1];
                            ?>                    
                    
                        <td colspan="2"><a class="addtcrt" title="купить <?php echo $buydesc.' '.$picbr ?>" style="float:left" onclick="addToCart(<?php echo $TEMPLATE['id'] ?>, <?php echo $TEMPLATE['price'] ?>);" <?php echo ($TEMPLATE['available']<1)?"style='background:#007'":""; ?>><?php echo ($TEMPLATE['available']<1)?"Заказать":"Добавить в корзину"; ?></a> <input style="width:25px;height:25px;margin:16px 0 0 5px;font-size:16px" id="i<?php echo $TEMPLATE['id'] ?>" value="<?php echo $amount ?>"> <?php echo $units ?></td>

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
                            //if($img!="uploaded/big_".$TEMPLATE['aid'].$ext){
                             $imgs.="<li style=\"display:none\"><a href=\"".$GLOBALS['PATH']."/".$img."\" rel=\"prettyPhoto[gallery]\" title=\"".$pictitle."\">
				<img {$TEMPLATE['alt']} src='$fl' style=\"cursor:pointer\"></a></li>";
                            //}
                        }
                    }
                    echo "<div style='width:".$GLOBALS['IMAGE_MAXSIZE'].";height=".$GLOBALS['IMAGE_HMAXSIZE'].";border:1px solid black;display: table-cell;text-align:center;vertical-align: middle;background:#fff'>
				<ul class=\"gallery clearfix\" style=\"list-style-type:none\">
				<li><a href=\"/uploaded/big_".$TEMPLATE['aid'].$ext."\" rel=\"prettyPhoto[gallery]\" title=\"".$pictitle."\">
				<img {$TEMPLATE['alt']} src='$fl' style=\"cursor:pointer;border:0\"></a></li>$imgs
				</ul>
				</div>";
                } else {
                    echo "<div style='width:".$GLOBALS['IMAGE_MAXSIZE'].";height=".$GLOBALS['IMAGE_HMAXSIZE'].";border:1px solid black;display: table-cell;text-align:center;vertical-align: middle;background:#fff'><img src='/img/nofoto.jpg' alt=''></div>";
                }
                ?>
            </td>
        </tr>
    </table>
    <?php if ($TEMPLATE['adescription']) { ?><!---->
        <br>
        <h3>Описание товара</h3>
        <div itemprop="description" class="item_desc" style="padding: 5px; padding-top: 0px;">
        <?php echo $TEMPLATE['adescription'] ?>
        </div>
    <?php } ?>
</div>
