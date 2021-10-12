<?php if($Success):?><div class="success"><?php echo $Success?></div><? endif?>
<?php if($Error):?><div class="error"><?php echo $Error?></div><? endif?>
<?
// регистрационная информация (логин, пароль #1)
// registration info (login, password #1)
$mrh_login = $Robokassa['robo_login'];
$mrh_pass1 = $Robokassa['robo_password1'];

// номер заказа
// number of order
$inv_id = $Order['id'];

// описание заказа
$i=0;
foreach($Order['products'] as $key=>$val){
    if($i==0){
        $des_pr = $val['product_name'];
    } else {
        $des_pr = $des_pr.", ".$val['product_name'];
    }
    $i=$i+1;
}

//var_dump($Order);
// order description
$inv_desc = "Оплата заказа №".$Order['id'];

// сумма заказа
// sum of order

//$out_summ = ($Order['user_id'])?$Order['price_itogo_delivery2']+$Order['delivery_price']:$Order['price_itogo_delivery']+$Order['delivery_price'];//
$out_summ =($myrow1['kart'] == 1)?$Order['price_itogo_delivery2']+$Order['delivery_price']:$Order['price_itogo_delivery']+$Order['delivery_price'];
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
$customerNumber=($Order['user_id'])?$Order['user_id']:'anonymous';//test scid 532122
print
   "<html>".
   "<form action='https://money.yandex.ru/eshop.xml' method=POST>".
   "<input type=hidden name=shopId value=\"116718\">
    <input type=hidden name=scid value=\"45282\">".
    "<input type=hidden  name=customerNumber value='$customerNumber'>".
    "<input type=hidden name=sum value='$out_summ'>".
    "<input type=hidden name=orderNumber value='{$Order['id']}'>".
    
   "<br>Способ оплаты:<br><br>
<input name=paymentType value=PC type=radio checked=checked>Со счета в Яндекс.Деньгах (яндекс кошелек)<br/>
<input name=paymentType value=AC type=radio>С банковской карты<br/>".

   "<input style='margin: 10px 0;' type=submit class=button value='Перейти к оплате &#8594;'>".
   "</form></html>";
?>
