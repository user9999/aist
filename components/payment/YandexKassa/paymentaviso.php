<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/Functions.php'; //Дополнительные функции /* extends Db */

class YandexKassapaymentaviso extends Functions
{
    
    function __construct()
    {
        parent::__construct();
        YandexKassapaymentaviso::ViewYandexKassapaymentaviso();
    }
    
    function ViewYandexKassapaymentaviso()
    {
        $shopPassword='MBhTYIv7m0Nm';
        $test=0;$shopId=116718;
    
        if($_POST) {
            //$a=var_export($_POST, true);
            //$fp=fopen("post.txt","a+");
            //fwrite($fp,$a);
            //fclose($fp);
              $hash = md5($_POST['action'].';'.$_POST['orderSumAmount'].';'.$_POST['orderSumCurrencyPaycash'].';'.$_POST['orderSumBankPaycash'].';'.$shopId.';'.$_POST['invoiceId'].';'.$_POST['customerNumber'].';'.$shopPassword);//$shopPassword;
            if (strtolower($hash) != strtolower($_POST['md5'])) {
                $code=1;
            }else {
                $price=($_POST['customerNumber']=='anonymous')?'price_itogo_delivery':'price_itogo_delivery2';  //|price_itogo_delivery2
                //$id=substr($_POST['orderNumber'],1);
                $id=intval($_POST['orderNumber']);
                $row=mysql_query("select delivery_price,$price from ".PREFIX."order where id=".$id." limit 1");
                $res=mysql_fetch_row($row);
                if($_POST['orderSumAmount']==($res[0]+$res[1])) {
                    $code = 0;
                    mysql_query("update ".PREFIX."order set status=6 where id=".$id);
                }else {
                    $code = 1;
                }
            }
            //$code=($test==1)?1:$code;
            //$fp=fopen("code.txt","a+");
            //fwrite($fp,$code);
            //fclose($fp);
            print '<?xml version="1.0" encoding="UTF-8"?>';
            print '<paymentAvisoResponse performedDatetime="'. $_POST['requestDatetime'] .'" code="'.$code.'"'. ' invoiceId="'. $_POST['invoiceId'] .'" shopId="'. $shopId .'"/>';
        }
    }
    
}

new YandexKassapaymentaviso();

?>
