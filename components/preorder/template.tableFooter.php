<?php
if($TEMPLATE['reserved']) {
    ?>
<tr><th></th><th></th><th  style="color:blue">СУММА</th><th><a name="sum<?php echo ($TEMPLATE['order'])?"on":"off"; ?>"><?php echo $TEMPLATE['sum']." ".$GLOBALS['ZNAK'] ?></a></th><th></th><th></th><th></th></tr>
        </tbody>
    <?php
    if($TEMPLATE['order']) {
        ?>
        <tr><th></th><th></th><th></th><th></th><th></th><th colspan="2"><a class="addtcrt" href="javascript:allCart();" id="allbut" style="height:19px">Отправить все в корзину</a></th></tr>
        <?php
    }
    ?>    
    </table>
    <?php
    if(!$TEMPLATE['order']) {
        ?>
</form>
        <?php
    }
    ?>
    </div>
    <?php
}
?>

