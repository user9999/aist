<?php
require "cfg2.php";
require "ini1.php";
//$ALTERNATE_PHRASE_HASH=cfgSET('ALTERNATE_PHRASE_HASH');
//05epZ95W9pbWIUvJVeetcWKPK
//echo $ALTERNATE_PHRASE_HASH;
$ALTERNATE_PHRASE_HASH="05epZ95W9pbWIUvJVeetcWKPK";
$althash=strtoupper(md5($ALTERNATE_PHRASE_HASH));
$string = $_REQUEST['PAYMENT_ID'].':'.$_REQUEST['PAYEE_ACCOUNT'].':'.$_REQUEST['PAYMENT_AMOUNT'].':'.$_REQUEST['PAYMENT_UNITS'].':'.$_REQUEST['PAYMENT_BATCH_NUM'].':'.$_REQUEST['PAYER_ACCOUNT'].':'.$althash.':'.$_REQUEST['TIMESTAMPGMT'];
$hash = strtoupper(md5($string));

if($hash==$_REQUEST['V2_HASH'] && $_SERVER['REMOTE_ADDR']=='78.41.203.75') {

    $query    = "SELECT * FROM enter WHERE id = ".intval($_REQUEST['PAYMENT_ID'])." LIMIT 1";
    $result    = mysql_query($query);
    $row    = mysql_fetch_array($result);
    if($row['id'] && $row['status'] != 2) {

        if(sprintf("%01.2f", $_REQUEST['PAYMENT_AMOUNT'])==$row['sum'] && $_REQUEST['PAYEE_ACCOUNT']==$cfgPerfect && $_REQUEST['PAYMENT_UNITS']=='USD') {

            mysql_query('UPDATE users SET pm_balance = pm_balance + '.$row['sum'].' WHERE login = "'.$row['login'].'" LIMIT 1');
            mysql_query("UPDATE enter SET status = 2, purse = '".htmlspecialchars($_REQUEST['PAYER_ACCOUNT'], ENT_QUOTES, '')."', paysys = 'PM' WHERE id = ".intval($_REQUEST['PAYMENT_ID'])." LIMIT 1");
            //mail('play-fine@yandex.ru', "Status", "success ".'UPDATE users SET pm_balance = pm_balance + '.$row['sum'].' WHERE login = "'.$row['login'].'" LIMIT 1\n'."UPDATE enter SET status = 2, purse = '".htmlspecialchars($_REQUEST['PAYER_ACCOUNT'], ENT_QUOTES, '')."', paysys = 'PM' WHERE id = ".intval($_REQUEST['PAYMENT_ID'])." LIMIT 1");
            // Отправляем деньги админу если нужно
            if(cfgSET('cfgOutAdminPercent') != 0 && cfgSET('AdminPMpurse')) {
                $sum    = sprintf("%01.2f", $row['sum'] / 100 * cfgSET('cfgOutAdminPercent'));
                fopen('https://perfectmoney.com/acct/confirm.asp?AccountID='.$cfgPMID.'&PassPhrase='.$cfgPMpass.'&Payer_Account='.$cfgPerfect.'&Payee_Account='.cfgSET('AdminPMpurse').'&Amount='.$sum.'&PAY_IN=1&PAYMENT_ID='.rand(100000, 999999).'&Memo='.$cfgURL, 'rb');
            }

        } else {
            print "ERROR";
            $err="PAYMENT_AMOUNT: ".sprintf("%01.2f", $_REQUEST['PAYMENT_AMOUNT'])." == row[sum]:".$row['sum']."\n";
            $err.="PAYEE_ACCOUNT: ".$_REQUEST['PAYEE_ACCOUNT']." == cfgPerfect:".$cfgPerfect."\n";
            $err.="PAYMENT_UNITS: ".$_REQUEST['PAYMENT_UNITS']." == 'USD'";
            
            //mail('play-fine@yandex.ru', "Status", "wrong data\n".$err);//$adminmail
        }

    } else {
        print "ERROR";
        //mail('play-fine@yandex.ru', "Status", "No recording in db or secondary made ".$_REQUEST['PAYMENT_ID']);
    }

} else {
    print "ERROR";
    //mail('play-fine@yandex.ru', "Status", "not valid hash\n request:".$_REQUEST['V2_HASH']."\n string:".$string."\n hash:".$hash);
}
?>
