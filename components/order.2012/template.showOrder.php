<div class="content_body">
<?php
if($_SESSION['userid']) {
    ?>
<div style="margin:0;padding:0;height:25px">
<a href="/order/?clearall=1" class="addtcrt" style="display:block;float:right;width:180px;height:19px;float:right;font-size:10px;margin-top:0;padding-top:6px;margin-right:2px">Очистить корзину</a>
<p style="font-size:12px;font-weight:bold;padding-bottom:0px;padding-top:5px">Корзина</p>
</div>
    <?php
} else {
    ?>
<!--<h3>Корзина</h3>-->
<div style="margin:0;padding:0;height:35px">
<a href="/order/?clearall=1" class="addtcrt" style="display:block;float:right;width:180px;height:23px;float:right;font-size:12px;margin-top:0;padding-top:6px;margin-right:2px">Очистить корзину</a>
<p style="font-size:1.5em;color:#888;font-weight:normal;text-transform:uppercase;padding-bottom:15px;">Корзина</p>
</div>
    <?php
}
?>

    <a class="underlined" href="javascript:history.go(-1);">Переход в каталог для добавления позиций</a>
    <br />
    <br />
    <?php if ($TEMPLATE['error']) { ?>
        <div class="error">
            Обратите внимание! Часть выбранных вами ранее позиций ныне отсутствует в нашем каталоге товаров, а значит, не может быть заказана и не отображается в данном списке.
        </div>
    <?php } ?>
    
    <form method="post">
        <table width="100%" <?php echo ($_SESSION['userid'])?"style=\"font-size:10px\"":""; ?>>
            <?php 
            $sum = 0;$i=0;
            foreach ($_COOKIE['cart_item_id'] as $k => $v) {
                $res = mysql_query("SELECT b.*, c.name as brandname, c.altname as brandaltname, d.name as modelname, d.altname as modelaltname FROM catalog_items as b, catalog_brands as c, catalog_models as d WHERE b.id = $v AND b.brand_id = c.id AND b.model_id = d.id");
                if ($row = mysql_fetch_array($res)) {
                    $i++;
                    //$star="";
                    //if($row['available']<1){
                      //$star="* ";
                    //$warning="<br /><span style=\"color:#a00\">* Обращаем ваше внимание, что часть заказанных деталей на данный момент отсутствует в продаже. Срок их поставки согласовывается отдельно.</span><br /><br />";
                    //}
                    //скидка
                    if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
                         $res3 = mysql_query("SELECT price from `price_".$_SESSION['userid']."` where name='".$row['name']."' limit 1");
                         $row3 = mysql_fetch_array($res3);
                         $row['price']=$row3[0];
                    }

                    $row['price']=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1 && $row['special']=='')?floor($row['price']*(100-$_SESSION['percent'])/100):$row['price'];
                    //скидка
                    //валюта
                    if($_SESSION['actype'][0]==1 && $_SESSION['actype'][6]==1 && $_COOKIE['currency']=='rub') {
                                $res4=mysql_query("select euro,dollar,currency,ratio from currency where id=1");
                                $row4=mysql_fetch_array($res4);
                         $row['price']=floor($row4[$row4['currency']]*$row4['ratio']*$row['price']);
                    }
                    $units=explode(" ", $row['provider']);
                    //var_dump($units);
                    $units[0]=str_replace(",", ".", $units[0]);
                    //валюта
                    if ($row['modelaltname']) { $row['modelname'] = $row['modelaltname'];
                    }
                    if ($row['brandaltname']) { $row['brandname'] = $row['brandaltname'];
                    }
                    ?>
                    <tr class="hbg"<?php echo ($row['available']<1)?" style='color:#a00'":""; ?>>
                        <td width="33%"><b><?php echo $row['description'] ?></b> (<?php echo $row['country'] ?>)</td>
                        <td width="20%">Цена, <?php echo $GLOBALS['ZNAK'] ?>: <?php echo $row['price'] ?></td>
                        <td width="35%">Количество: <input type="text" style="width:30px;" name="frm_count[<?php echo $k ?>]" value="<?php echo $_COOKIE['cart_item_count'][$k] ?>" tabindex="<?php echo $i ?>"> <?php echo $units[1] ?></td>
                        <td align="center"><a title="Удаление позиции" alt="Удаление позиции" href="<?php echo $GLOBALS['PATH'] ?>/order/?delete=<?php echo $k ?>"><img src="<?php echo $GLOBALS['PATH'] ?>/templates/blank/img/del.jpg"></a></td>
                    </tr>
                    <?php
                    //var_dump($units);
                    $sum += $_COOKIE['cart_item_count'][$k] * $row['price']/$units[0];
                    
                } else {
                    setcookie("cart_item_id%5B$k%5D", "", time() - 3600, "/");
                    setcookie("cart_item_count%5B$k%5D", "", time() - 3600, "/");
                }
            }
            ?>
        </table>

        Общая сумма: <span style="color:red;"><?php echo $sum." ".$GLOBALS['ZNAK'] ?></span> &nbsp; <input type="submit" value="Пересчитать" class="button">
    </form>
</div>
