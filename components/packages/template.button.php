<?php
if (!defined("SIMPLE_CMS")) { die("Access denied");
}
$ps=1;//1 - реальный платеж, 0 - тестовый
$pay_url=($ps==1)?"https://www.paypal.com/cgi-bin/webscr":"https://www.sandbox.paypal.com/cgi-bin/webscr";
?>
<h2></h2>
<!--<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="7H5FBUVWBNJL4">
<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal Ц The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>-->
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
<input type="image" src="https://www.paypalobjects.com/en_US/GB/i/btn/btn_buynowCC_LG.gif" border="0" name="submit" alt="PayPal Ц The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypalobjects.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form>

