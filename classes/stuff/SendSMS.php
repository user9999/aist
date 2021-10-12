<?php
class SendSMS
{
    public function __construct()
    {
        
    }
    public function sms($phone,$mess)
    {
        //echo "sending";
        include_once $_SERVER['DOCUMENT_ROOT'].'/inc/1000sms_ru.php';
        $amail="svetodel@gmail.com";
        $apassword="X4uvUAzy";
        $Sender="BIRZHA";
        $smsSign="\r\nСтроительная биржа";
        smsapi_push_msg_nologin($amail, $apassword, $phone, $mess.$smsSign, array("sender_name"=>$Sender));
    }
}
