<?php $t = array("есть", "нет", "ожидается");
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
    <a class="underlined" href="javascript:history.go(-1);">Вернуться в каталог для выбора позиций</a><br />
    <br />
    <table width="100%">
        <tr>
            <td>
                <table width="100%" class="tb">
                    <tr>
                        <td class="tbg" width="150">OEM:</td>
                        <td><?php echo $TEMPLATE['oem'] ?></td>
                    </tr>
                    <tr>
                        <td class="tbg">Марка:</td>
                        <td><?php echo ($TEMPLATE['altbrand']) ? $TEMPLATE['altbrand'] : $TEMPLATE['brand'] ?></td>
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
                            <td class="tbg">Страна-производитель:</td>
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
<?php
if($TEMPLATE['available']<1) {
    if($TEMPLATE['waitingfor']) {
                          $avail="ожидается ".$TEMPLATE['waitingfor'];
    } else {
                   $avail="нет";
    }
} elseif($TEMPLATE['available']>5) {
    $avail="более 5шт.";
} else {
    $avail=$TEMPLATE['available']."шт.";
}
                echo $avail;
?>
                            
                            
                            
                            
                        
                            
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
                            <td><?php echo $TEMPLATE['special'] ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($TEMPLATE['adescription']) { ?>
                        <tr>
                            <td class="tbg">Описание:</td>
                            <td><?php echo $TEMPLATE['adescription'] ?></td>
                        </tr>
                    <?php } ?>
                    <!--<tr>
                        <td class="tbg">Наличие:</td>
                        <td><?php echo $t[$TEMPLATE['av']] ?></td>
                    </tr>-->
                    <?php if ($TEMPLATE['price']) { ?>
                    <tr>
                        <td class="tbg">Добавить в корзину:</td>
                        <td>
                            <input style="width: 25px;" id="i<?php echo $TEMPLATE['id'] ?>" value="1" />
                            <a onclick="addToCart(<?php echo $TEMPLATE['id'] ?>, <?php echo $TEMPLATE['price'] ?>);"><img title='Добавление позиции' alt='Добавление позиции' src='<?php echo $GLOBALS['PATH'] ?>/templates/blank/img/dob.jpg' /></a>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </td>
        </tr>
    </table>
</div>
