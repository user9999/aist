<?php
if($_POST) {
    include "cfg2.php";
    include "ini1.php";
    foreach ($_POST as $key => $value) {
        if (!preg_match('/ik_/', $key)) {
            continue;
        }
        $data[$key] = $value;
    }
    $ik_co_id=$data['ik_co_id'];
    $ik_pm_no=$data['ik_pm_no'];
    $ikSign = $data['ik_sign'];
    $ik_am = $data['ik_am'];
    $ik_cur = $data['ik_cur'];
    $ik_inv_id=intval($data['ik_inv_id']);
    unset($data['ik_sign']);
    if ($data['ik_pw_via'] == 'test_interkassa_test_xts') {
        $key = 'S9GKtauhCNXJ0tl1';
    } else {
        $key = 'je5xckvRmmAfMFKM';
    }
    ksort($data, SORT_STRING);
    array_push($data, $key);
    $signStr = implode(':', $data);
    $sign = base64_encode(md5($signStr, true));

    if($data['ik_inv_st']=="success" && $data['ik_pw_via']!= 'test_interkassa_test_xts') {
        if($ik_co_id=='530201d6bf4efc2b66a4d246') {
            if($ikSign==$sign) {
                $ik_pm_no=str_replace("ID_", "", $ik_pm_no);
                $query    = "SELECT * FROM enter WHERE id = ".intval($ik_pm_no)." LIMIT 1";
                $result    = mysql_query($query);
                $row    = mysql_fetch_array($result);
                if($row['status'] != 2) {
                    if(sprintf("%01.2f", $ik_am)==$row['sum']  && $ik_cur=='USD') {
                        //mail('play-fine@yandex.ru', "Status",'UPDATE users SET pm_balance = pm_balance + '.$row['sum'].' WHERE login = "'.$row['login'].'" LIMIT 1'."\n"."UPDATE enter SET status = 2, purse ='".$ik_inv_id."', paysys = 'interkassa' WHERE id = ".intval($_POST['m_orderid'])." LIMIT 1");
                        mysql_query('UPDATE users SET pm_balance = pm_balance + '.$row['sum'].' WHERE login = "'.$row['login'].'" LIMIT 1');
                        mysql_query("UPDATE enter SET status = 2, purse ='".$ik_inv_id."', paysys = 'interkassa' WHERE id = ".intval($ik_pm_no)." LIMIT 1");
                    
                        //mail('play-fine@yandex.ru', "Status","ok");
                    } else {
                        //mail('play-fine@yandex.ru', "Status","wrong sum or currency:".$ik_am." ".$ik_cur."\npayment_id:".$ik_pm_no);
                    }
                } else {
                    //mail('play-fine@yandex.ru', "Status","no sign in db id:".$ik_pm_no."\npayment_id;".$ik_pm_no);
                }

            } else {
                //mail('play-fine@yandex.ru', "Status","wrong sign:".$sign."\nikSign:".$ikSign."\npayment_id;".$ik_pm_no );
            }
        } else {
            //mail('play-fine@yandex.ru', "Status","another kassa number:".$ik_co_id."\npayment_id:".$ik_pm_no );
        }
    } else {
        //mail('play-fine@yandex.ru', "Status","fail or test payment_id:".$ik_pm_no );
    }
}
?>