<?
if (isset($_POST["m_operation_id"]) && isset($_POST["m_sign"]))
{
include "cfg2.php";
include "ini1.php";
	$m_key = "0p4GxF22zc6NYNNc";//"gHr56#i!jt89LI";
	$arHash = array($_POST['m_operation_id'],
			$_POST['m_operation_ps'],
			$_POST['m_operation_date'],
			$_POST['m_operation_pay_date'],
			$_POST['m_shop'],
			$_POST['m_orderid'],
			$_POST['m_amount'],
			$_POST['m_curr'],
			$_POST['m_desc'],
			$_POST['m_status'],
			$m_key);
	$sign_hash = strtoupper(hash('sha256', implode(":", $arHash)));
	if ($_POST["m_sign"] == $sign_hash && $_POST['m_status'] == "success")
	{
			$query	= "SELECT * FROM enter WHERE id = ".intval($_POST['m_orderid'])." LIMIT 1";
			$result	= mysql_query($query);
			$row	= mysql_fetch_array($result);
			if($row['id'] && $row['status'] != 2) {

				if(sprintf("%01.2f", $_POST['m_amount'])==$row['sum']  && $_POST['m_curr']=='USD'){//&& $_REQUEST['PAYEE_ACCOUNT']==$cfgPerfect

					mysql_query('UPDATE users SET pm_balance = pm_balance + '.$row['sum'].' WHERE login = "'.$row['login'].'" LIMIT 1');
					mysql_query("UPDATE enter SET status = 2, purse ='".$_POST['m_operation_ps']."', paysys = 'payeer' WHERE id = ".intval($_POST['m_orderid'])." LIMIT 1");

				} else {
					//print "ERROR";
					//mail('play-fine@yandex.ru', "Status", "wrong data\n mcurr:".$_POST['m_curr']."\n sum:".sprintf("%01.2f", $_POST['m_amount']));//$adminmail
				}

			} else {
				//print "ERROR";
				//mail('play-fine@yandex.ru', "Status", "No recording in db or secondary made ".$_POST['m_orderid']."\nquery: SELECT * FROM enter WHERE id = ".intval($_POST['m_orderid'])." LIMIT 1\n dbstatus: ".$row['status']."\n rowid: ".$row['id']);
			}
		//mail('play-fine@yandex.ru', "Status", "success");
		echo $_POST['m_orderid']."|success";
		exit;
	}
	//mail('play-fine@yandex.ru', "Status", "Error\n m_sign: ".$_POST["m_sign"]."\n status:".$_POST['m_status']);
	echo $_POST['m_orderid']."|error";
}
?>