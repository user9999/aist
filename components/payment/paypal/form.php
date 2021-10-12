<form method="post" action= "<?php echo $pay_url ?>">
<input type="hidden" name="cmd" value="_xclick">
<input type="hidden" name="business" value="valery-facilitator@biorow.com"><!--valery@biorow.com-->
<input type="hidden" name="item_name" value="<?php echo htmlentities($TEMPLATE['title'], ENT_QUOTES, 'UTF-8')  ?>">
<input type="hidden" name="item_number" value="1">
<input type="hidden" name="return" value="http://www.biorow.com/articles/success">
<input type="hidden" name="cancel_return" value="http://www.biorow.com/articles/fail">
<input type="hidden" name="custom" value="<?php echo $TEMPLATE['userid'] ?>">
<input type="hidden" name="amount" value="<?php echo $TEMPLATE['price'] ?>">
<input type="hidden" name="invoice" value="<?php echo $TEMPLATE['pay_id'] ?>">


<input type="hidden" name="no_shipping" value="1">
<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal – The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>
