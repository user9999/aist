<?php if ($Success):?><div class="success"><?=$Success?></div><?php endif?>
<?php if ($Error):?><div class="error"><?=$Error?></div><?php endif?>
<?php
// регистрационная информация (логин, пароль #1)
// registration info (login, password #1)
$mrh_login = 'test';//$Robokassa['robo_login'];
$mrh_pass1 = 'test';//$Robokassa['robo_password1'];

// номер заказа
// number of order
$inv_id = $TEMPLATE['id_order'];

// описание заказа
/*
$i=0;
foreach($Order['products'] as $key=>$val){
    if($i==0){
        $des_pr = $val['product_name'];
    }else{
        $des_pr = $des_pr.", ".$val['product_name'];
    }
    $i=$i+1;
}
*/
$des_pr=$TEMPLATE['name'];//$TEMPLATE['description'];


//var_dump($Order);
// order description
$inv_desc = "Оплата заказа №".$TEMPLATE['id_order'];

// сумма заказа
// sum of order

//$out_summ = ($Order['user_id'])?$Order['price_itogo_delivery2']+$Order['delivery_price']:$Order['price_itogo_delivery']+$Order['delivery_price'];//
$out_summ =$TEMPLATE['price'];
// тип товара
// code of goods
$shp_item = "2";

// предлагаемая валюта платежа
// default payment e-currency
$in_curr = "";

// язык
// language
$culture = "ru";

// формирование подписи
// generate signature
$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1");

// форма оплаты товара
// payment form
$customerNumber=$_SESSION['userid'];//test scid 532122
print
   "<html>".
"<script>
window.onload = function(){
  //document.forms['member_signup'].submit();
  $(\"#payform\").submit();
}
</script>".
   "<form action='https://money.yandex.ru/eshop.xml' id='payform' method=POST>".
   "<input type=hidden name=shopId value=\"116718\">
	<input type=hidden name=scid value=\"45282\">".
    "<input type=hidden  name=customerNumber value='$customerNumber'>".
    "<input type=hidden name=sum value='$out_summ'>".
    "<input type=hidden name=orderNumber value='{$TEMPLATE['id_order']}'>".
    
   "<br>Способ оплаты:<br><br><table style='border:0'>
<tr><td style='width:35px;border:0'><input name=paymentType value=PC type=radio checked=checked></td><td style='border:0'>Со счета в Яндекс.Деньгах (яндекс кошелек)<br><img src='/design/default/img/yandex-kassa.jpg' alt=''></td></tr>
<tr><td style='width:35px;border:0'><input name=paymentType value=AC type=radio></td><td style='border:0'>С банковской карты<br><img src='/design/default/img/pays1.jpg' alt=''></td></tr></table>".

   "<input style='margin: 10px 0;' type=submit class=button value='Перейти к оплате &#8594;'>".
   "</form></html>";
?>