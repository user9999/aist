<?php $t = array("есть", "нет", "ожидается");
//$picbr=($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'];
//$picmod=($TEMPLATE['altmodel']) ? $TEMPLATE['altmodel'] : $TEMPLATE['model'];
//$pictitle=$picbr." ".$picmod." ".$TEMPLATE['description'];
$pictitle=$TEMPLATE['br']." ".$TEMPLATE['md']." ".$TEMPLATE['description'];
$mycss="<link rel=\"stylesheet\" href=\"/inc/prettyPhoto.css\" type=\"text/css\" media=\"screen\" title=\"prettyPhoto main stylesheet\" charset=\"utf-8\" />
";
set_css($mycss);
$script="<script src=\"/inc/jquery.prettyPhoto.js\" type=\"text/javascript\" charset=\"utf-8\"></script>
<script type=\"text/javascript\">
\$(document).ready(function() {
 	\$(\"#addToRes\").click(function(e){
     		e.preventDefault();
     		\$.post(\"/reserve.php\", {id: '".$TEMPLATE['id']."',amount: \$(\"#r".$TEMPLATE['id']."\").val(),action: 'reserve'},
   function(data) {
   \$(\"#addRes\").html(\"<td colspan='2'><a href='/reserve'>\"+data+\"</a> на ".$TEMPLATE['RESERVE']." ч.</td>\");
   });

 	});
 	
 	 	\$(\"#preorder\").click(function(e){
     		e.preventDefault();
     		\$.post(\"/reserve.php\", {id: '".$TEMPLATE['id']."',amount: \$(\"#p".$TEMPLATE['id']."\").val(),action: 'preorder'},
   function(data) {
   \$(\"#pre_order\").html(\"<td colspan='2'><a href='/preorder'>\"+data+\"</a></td>\");
   });

 	});    		
});
function priceshow(){
  if(document.getElementById('pricecheck').checked==true){
    document.getElementById('iprice').style.display=''
  }
  if(document.getElementById('pricecheck').checked==false){
    document.getElementById('iprice').style.display='none'
  }
}
function cart(nid,det_id,pr,apr){
    amt=$(\"#i\"+nid).val();
   \$.post(\"/cart.php\", {action:'detail',id:det_id,price:pr,amount:amt,act:apr},
   function(data) {
   if(/\s/.test(data)){
       alert(data);
   } else {
    arr=data.split('|');
    \$(\"#cart #cartno\").html(arr[0]);
    \$(\"#cart #cartsum\").html(arr[1]);
    \$(\"#cart\").animate({opacity: 0.1 }, \"slow\", function() {
    \$(\"#cart\").animate({opacity: 0.85 }, \"slow\");
    });
    \$(\"#cart\").toggleClass(\"cart, cart2\");
    \$(\"#tr_\"+id).addClass(\"ordered\");
   }
   });

}
</script>";
set_script($script);
//echo $_SESSION['actype'][1];
if ($TEMPLATE['model_variants']) {
    $TEMPLATE_models = str_replace(";", ", ", $TEMPLATE['model_variants']);
}
?>

<div class="content_body" id="position">
    <?php if (!trim($_GET['t']) || !trim($_GET['b'])) { ?>
        <h3><?php echo ($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'] ?> <?php echo ($TEMPLATE['altmodel']) ? $TEMPLATE['altmodel'] : $TEMPLATE['model'] ?> <b><?php echo $TEMPLATE['description'] ?></b></h3>
    <?php } else { 
        $_GET['t'] = ereg_replace("[^A-Za-zА-Яа-я0-9 -]", "", $_GET['t']);
        $_GET['b'] = ereg_replace("[^A-Za-zА-Яа-я0-9 -]", "", $_GET['b']);
        ?>
        <h3><?php echo $_GET['b'] ?> <?php echo $_GET['t'] ?> <b><?php echo $TEMPLATE['description'] ?></b></h3>
    <?php } ?>
    <a class="underlined" href="javascript:history.go(-1);">Вернуться в каталог для выбора позиций</a>
    
    <table width="100%" style="padding-top:8px">
        <tr style="vertical-align:top;">
            <td>
                <table width="100%" class="tb" style="margin-top:0px">
                    <tr>
                        <td class="tbg">OEM:</td>
                        <td><?php echo $TEMPLATE['oem'] ?></td>
                    </tr>
                    <tr>
                        <td class="tbg">Марка:</td>
                        <td>
<?php
 $brand=($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'];
 $brand=($TEMPLATE['br']!=$brand)?$TEMPLATE['br'].", ".$brand:$brand;
 echo $brand;
?>
                        </td>
                    </tr>
                    <tr>
                        <td class="tbg">Модель:</td>
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
                        <tr>
                    <?php } 

                    if(!$TEMPLATE['city']) {
                        ?>
                            <td class="tbg">Наличие:</td>
                            <td>
                        <?php
                        if($TEMPLATE['available']<1) {
                            if($TEMPLATE['waitingfor']) {
                                 $avail=$TEMPLATE['waitingfor'];
                            } else {
                                   $avail="нет";
                            }
                        } elseif($TEMPLATE['available']>$_SESSION['storage']) {
                            $avail="более ".$_SESSION['storage']." шт.";
                        } else {
                            $avail=$TEMPLATE['available']." шт.";
                        }
                        echo $avail;
                        ?>
                            </td>
                        <?php
                    } else {
                        ?>
<td class="tbg">Наличие (СПб):</td>
                            <td>
                        <?php echo $TEMPLATE['spb'] ?> 
                            </td>
                            </tr>
                            <tr>
<td class="tbg">Наличие (Москва):</td>
                            <td>
                        <?php echo $TEMPLATE['msk'] ?> 
                            </td>
                            </td>
                        <?php
                    }
                    ?>
                        
                        </tr>
<?php
if($TEMPLATE['resamount']!=0) {
    ?>
<tr>
<td class="tbg">Забронировано:</td><td><?php echo $TEMPLATE['resamount'] ?></td>
</tr>
    <?php
}
//echo $TEMPLATE['special_price']."--";
if($TEMPLATE['special_price']) {
    $prtype="1";
    $act_str="Цена по акции:";
    $strprice=$price=$TEMPLATE['special_price'];
    $button="Купить по акции (".$price."р)";
    $prebutton="Предв. заказ (".$TEMPLATE['price']." ".$GLOBALS['ZNAK'].")";
} else {
    $prtype="0";
    $act_str="Акции:";
    $price=$TEMPLATE['price'];
    $strprice="Старая цена ".$TEMPLATE['price'];
    $button="Добавить в корзину";
    $prebutton="Предварительный заказ";
}
?>

                    <?php if ($TEMPLATE['price']) { ?>
                        <tr id="iprice">
                            <td class="tbg">Цена:</td>
                            <td><b><span style='color:red;'><?php echo $TEMPLATE['price']." ".$GLOBALS['ZNAK'] ?></span></b></td>
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
                            <td class="tbg"><?php echo $act_str ?></td>
                            <td style="color:red;font-weight:bold"><?php echo $strprice ?> руб.</td>
                        </tr>
                        <?php 
                    }
                    if ($TEMPLATE['price']) { 
                        if ($TEMPLATE['waitingfor']!='архив') { 
                            if($TEMPLATE['available']>0 || ($_SESSION['actype'][5]!=1 && $TEMPLATE['available']==0)) {
                                ?>
                    <tr>
                        <td colspan="2"><a class="addtcrt" style="float:left" onclick="cart(<?php echo $TEMPLATE['id'] ?>,'<?php echo $TEMPLATE['name'] ?>', <?php echo $price ?>,'<?php echo $prtype ?>');"><?php echo $button ?></a>&nbsp;&nbsp;&nbsp;
                            <input style="width: 25px;height:25px;margin-top:15px" id="i<?php echo $TEMPLATE['id'] ?>" value="1" />
</td>
</tr>
                                                <?php 
                            }
                            if($_SESSION['actype'][5]==1) {
                                ?>
                    <tr id="pre_order">
                        <td  colspan="2"><a class="addtcrt" id="preorder" style="background:#007;float:left"><?php echo $prebutton ?></a>&nbsp;&nbsp;&nbsp;
                            <input style="width: 25px;height:25px;margin-top:15px" id="p<?php echo $TEMPLATE['id'] ?>" value="1" />
</td>
                    </tr>
                                            <?php 
                            }
                            if($_SESSION['actype'][1]) {
                                if(!$TEMPLATE['amount'] ) {
                                    if($TEMPLATE['available']>0) {
                                        ?>
                    <tr id="addRes">
                        <td  colspan="2"><a class="addtcrt" id="addToRes" style="background:#007;float:left">Бронировать</a>&nbsp;&nbsp;&nbsp;
                            <input style="width: 25px;height:25px;margin-top:15px" id="r<?php echo $TEMPLATE['id'] ?>" value="1" />
</td>
                    </tr>
                                        <?php
                                    }
                                } else {
                                    ?>
                     <tr id="addRes">
                        <td colspan='2'><a href="/reserve">Вами забронировано <?php echo $TEMPLATE['amount'] ?> шт.</a></td>

                    </tr> 
                                    <?php
                                }
                            }
                            ?>        
                            <?php
                        } else {
                            ?>
<tr id="addRes">
<td colspan='2' style="font-size:16px;color:#700">Временно не поставляется</td>
</tr> 
                            <?php
                        }
                    } ?>
                </table>
            </td>
            <td width=340>
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
                    $bigfl = " style=\"cursor:pointer\" onclick=\"window.open('".$GLOBALS['PATH']."/uploaded/big_".$TEMPLATE['aid'].".jpeg','".$TEMPLATE['aid']."','width=".$GLOBALS['IMAGE3_MAXSIZE'].",height=".$GLOBALS['IMAGE3_HMAXSIZE']."')\"";
                }
                if (file_exists("uploaded/big_{$TEMPLATE['aid']}.png")) {
                    $ext=".png";
                    $bigfl = " style=\"cursor:pointer\" onclick=\"window.open('".$GLOBALS['PATH']."/uploaded/big_".$TEMPLATE['aid'].".png','".$TEMPLATE['aid']."','width=".$GLOBALS['IMAGE3_MAXSIZE'].",height=".$GLOBALS['IMAGE3_HMAXSIZE']."')\"";
                }
                if (file_exists("uploaded/big_{$TEMPLATE['aid']}.gif")) {
                    $ext=".gif";
                    $bigfl = " style=\"cursor:pointer\" onclick=\"window.open('".$GLOBALS['PATH']."/uploaded/big_".$TEMPLATE['aid'].".gif','".$TEMPLATE['aid']."','width=".$GLOBALS['IMAGE3_MAXSIZE'].",height=".$GLOBALS['IMAGE3_HMAXSIZE']."')\"";
                }
                if ($fl) {
                    $imgs="";
                    if(glob("uploaded/big_".$TEMPLATE['aid']."_*".$ext)) {
                        foreach(glob("uploaded/big_".$TEMPLATE['aid']."_*".$ext) as $img){
                            //if($img!="uploaded/big_".$TEMPLATE['aid'].$ext){
                             $imgs.="<li style=\"display:none\"><a href=\"".$GLOBALS['PATH']."/".$img."\" rel=\"prettyPhoto[gallery1]\" title=\"".$pictitle."\">
				<img {$TEMPLATE['alt']} src='$fl' style=\"cursor:pointer\"  /></a></li>";
                            //}
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
				<img $alt src='$fl' style=\"cursor:pointer;border:0\"  /></a></li>$imgs
				</ul>
				</div>";
                } else {
                    echo "<div style='width:".$GLOBALS['IMAGE_MAXSIZE'].";height=".$GLOBALS['IMAGE_HMAXSIZE'].";border:1px solid black;display: table-cell;text-align:center;vertical-align: middle;background:#fff'><img src='/img/nofoto.jpg' alt='' /></div>";
                }
                ?>
            </td>
        </tr>
    </table>
    <?php if ($TEMPLATE['adescription']) { ?><!---->
        <br />
        <h3>Описание товара</h3>
        <div style="padding: 5px; padding-top: 0px;">
        <?php

        $description=str_replace("{brand}", $TEMPLATE['br'], $TEMPLATE['adescription']);
        $description=str_replace("{brand1}", $brs[0], $description);        
        $description=str_replace("{model}", $TEMPLATE['md'], $description);    
        $description=str_replace("{model1}", $mds[0], $description);
        $description=str_replace("{model2}", $mds[0]." ".$mds[1], $description);
        $description=str_replace("{rusbrand}", mb_strtolower($TEMPLATE['rusbrand'], "UTF-8"), $description);
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
        //$TEMPLATE['adescription'];
        // {fh;mx;fm}; 
        echo $description;
        ?>
        </div>

        <div style="padding: 5px; padding-top: 20px;">
        Показать цену <input type="checkbox" onclick="priceshow()" id="pricecheck" CHECKED />

        </div>
    <?php } ?>
</div>
        <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
            $(".gallery a[rel^='prettyPhoto']").prettyPhoto({theme:'facebook'});
        });
        </script>