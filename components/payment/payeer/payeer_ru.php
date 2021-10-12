<?php
defined('ACCESS') or die();
if ($login) {

    if($_GET['pay'] == "no") {
        print '<p class="er">Не удалось пополнить баланс</p>';
    }

    if($_GET['conf']) {

        print '<p class="erok">Ваша заявка отправлена администраторам на проверку</p>';

        $conf        = intval($_GET['conf']);
        $purse        = addslashes(htmlspecialchars($_POST["purse"], ENT_QUOTES, ''));

        mysql_query("UPDATE enter SET status = 1, purse = '".$purse."' WHERE id = ".$conf." LIMIT 1");

    } elseif ($_GET['action'] == 'save') {
        $sum    = sprintf("%01.2f", str_replace(',', '.', $_POST['sum']));
        //$ps        = intval($_POST['ps']);
        $ps='payeer';
        if ($sum <= 0) {
            print '<p class="er">Введите корректную сумму (от $0.10 до $10 000)!</p>';
        } elseif ($sum < 0.10 || $sum > 10000) {
            print '<p class="er">За один раз разрешено вводить от $0.10 до $10 000!</p>';
        } else {

            // Форма пополнения
            //if($ps == 1) {

            // PM

            $sql = 'INSERT INTO enter (sum, date, login, paysys, service) VALUES ('.$sum.', '.time().', "'.$login.'", "'.$ps.'", "bal")';
            mysql_query($sql);
            $lid = mysql_insert_id();

            if(cfgSET('cfgSSL') == "on") {
                $http = "https";
            } else {
                $http = "http";
            }

                    $m_shop=4609244;
                    $m_orderid=$lid;
                    $m_amount=number_format($sum, 2, ".", "");
                    $m_curr='USD';
                    $m_desc=base64_encode('investition from '.$login);
                    $m_key='gHr56#i!jt89LI';
                    $arHash = array(
            $m_shop,
            $m_orderid,
            $m_amount,
            $m_curr,
            $m_desc,
            $m_key
                    );
                    $sign = strtoupper(hash('sha256', implode(":", $arHash)));
                    
                    
                    print '<FIELDSET style="border: solid #666666 1px; padding-top: 15px; margin-bottom: 10px;">
					<LEGEND><b>Подтверждение платежа</b></LEGEND>
					<form method="GET" action="//payeer.com/api/merchant/m.php">
<input type="hidden" name="m_shop" value="'.$m_shop.'">
<input type="hidden" name="m_orderid" value="'.$m_orderid.'">
<input type="hidden" name="m_amount" value="'.$m_amount.'">
<input type="hidden" name="m_curr" value="'.$m_curr.'">
<input type="hidden" name="m_desc" value="'.$m_desc.'">
<input type="hidden" name="m_sign" value="'.$sign.'">

					<center>
					Вы инвестируете <strong>'.$sum.'</strong>   <br /> в проект '.$cfgURL.'<br />

					<p align="center"><input class="subm" type="submit" name="m_process" value="Оплатить" /></p>
</form>
					</center>
					</form>
					</FIELDSET><p>Все средства поступившие на балансы участников после 12:00 по МСК текущего дня, инвестируются в работу с 12:00 по МСК следующего дня. Успевайте пополнять свои балансы до 12:00 по МСК текущего дня</p>';

                    //} else {
                    /*
                    $get_ps    = mysql_query("SELECT * FROM paysystems WHERE id = ".intval($ps)." LIMIT 1");
                    $rowps    = mysql_fetch_array($get_ps);

                    $sum2 = sprintf("%01.2f", $sum * $rowps['percent']);

                    $sql = 'INSERT INTO enter (sum, date, login, paysys, service) VALUES ('.$sum.', '.time().', "'.$login.'", "'.$rowps['name'].'", "bal")';

                        if(mysql_query($sql)) {

                        $m_orderid = mysql_insert_id();

                            print '<FIELDSET style="border: solid #666666 1px; padding-top: 15px; margin-bottom: 10px;">
                            <LEGEND><b>'.iconv ('utf-8','windows-1251','Подтверждение платежа').'</b></LEGEND>
                            <form method="POST" action="?conf='.$m_orderid.'">
                            <center>'.iconv ('utf-8','windows-1251','Вам необходимо перевести').' <b>'.$sum2.'</b> '.$rowps['abr'].' '.iconv ('utf-8','windows-1251','на счет').' <b>'.$rowps['purse'].'</b> '.iconv ('utf-8','windows-1251','в примечании к платежу, укажите ваш логин:').' <b>'.$login.'</b>.  '.iconv ('utf-8','windows-1251','После оплаты, укажите ваш номер счета, с которого вы совершили платеж в форме ниже и нажмите кнопку подтверждения платежа.').'

                            <input type="text" name="purse" size="20" />
                            <br /><br />
                            <p align="center"><input class="subm" type="submit" value="Я совершил платеж" /></p>
                            </center>
                            </form>
                            </FIELDSET>';

                        } else {
                            print '<p class="er">'.iconv ('utf-8','windows-1251','Не удаётся отправить заявку!').'</p>';
                        }
                    */
                
                    //}
        }
    } else {
        ?>
    <table align="center">
    <form action="?action=save" method="post">
    <tr><td><b>Сумма ввода</b>: </td><td align="right"><input style="width: 180px;border:1px solid #aaa" type='text' name='sum' value='' size="30" maxlength="7" /> <span style='font-weight:bold'>USD</span></td></tr>
    
    <tr><td></td><td align="right"><input class="subm" type='submit' name='submit' value='Пополнить баланс' /></td></tr>
    </form>
    </table>


        <?php
    }
} else {
    print "<p class=\"er\">".iconv('utf-8', 'windows-1251', 'Вы должны авторизироваться для доступа к этой странице!')."</p>";
}

?>