<?php
//http://www.robokassa.ru/ru/DemoShop/Demo2.aspx?CodeLang=Php
class YandexKassa extends Sibloma
{
    
    function Runs($mass, $order)
    {
        self::SendYandexKassa();
        self::GetMYandexKassa($mass, $order);
    }
    
    function SendYandexKassa()
    {
        $this->Massive['YandexKassa']['Url'] = $this->ReturnField('settings', 18, 'value');
    }
    
    function GetMYandexKassa($mass, $order)
    {
        $this->Massive['YandexKassa']['YandexKassa'] = $mass; // данные способа оплаты
        $this->Massive['YandexKassa']['Order'] = $order; // данные заказа
        echo $this->Template(SITE_DIR."/payment/YandexKassa/Settings.php", $this->Massive['YandexKassa']);        
    }
}

YandexKassa::Runs($myrow, $order);

?>
