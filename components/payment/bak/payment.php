<?php
//$fp=fopen("pay.txt","w+");
//fwrite($fp,var_export($_REQUEST,true)."\r\n");
//fclose($fp);
function till($period)
{
    $new=0;
    if($period==1) {
        $new=time()+60*60*24*31;
    } elseif($period==12) {
        $now=time();
        $a=date("d-m-Y", $now);
        $b=explode("-", $a);
        $y=$b[2]+1;
        $new=$b[0]."-".$b[1]."-".$y;
        $new=strtotime($new);
    }
    return $new;
}
$req = 'cmd=_notify-validate';               // Add 'cmd=_notify-validate' to beginning of the acknowledgement

foreach ($_POST as $key => $value) {         // Loop through the notification NV pairs
    $value = urlencode(stripslashes($value));  // Encode these values
    $req  .= "&$key=$value";                   // Add the NV pairs to the acknowledgement
}
  $id=intval($_POST['invoice']);
  $pp_payer_id=mysql_real_escape_string($_POST['payer_id']);
  $pp_payer_status=mysql_real_escape_string($_POST['payer_status']);
  $pp_payer_email=mysql_real_escape_string($_POST['payer_email']);
  $pp_txn_id=mysql_real_escape_string($_POST['txn_id']);
  $pp_payment_date=mysql_real_escape_string($_POST['payment_date']);
  $pp_payment_status=mysql_real_escape_string($_POST['payment_status']);
  $pp_pending_reason=mysql_real_escape_string($_POST['pending_reason']);
  $payment_gross=mysql_real_escape_string($_POST['payment_gross']);
  $pp_price=mysql_real_escape_string($_POST['mc_gross']);
  //$pp_verified=mysql_real_escape_string($_POST['verified']);
        //$fp1=fopen("stat1.txt","a+");
//fwrite($fp1,$req."\r\n"."insert into payment set pp_payer_id='{$pp_payer_id}',pp_payer_status='{$pp_payer_status}',pp_payer_email='{$pp_payer_email}',pp_txn_id='{$pp_txn_id}',pp_payment_date='{$pp_payment_date}',pp_payment_status='{$pp_payment_status}',pp_pending_reason='{$pp_pending_reason}',pp_verified='VERIFIED',pay_date='".time()."' where id=".$id);
//fclose($fp1);
  $res=mysql_query("select pp_verified from payment where id=".$id);
  $row=mysql_fetch_row($res);
if($row[0]=='VERIFIED') {
    die();
}

//echo "jkljkl";
  $header  = "POST /cgi-bin/webscr HTTP/1.1\r\n";                    // HTTP POST request
  $header .= "Content-Type: application/x-www-form-urlencoded\r\n";
  $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
  $fp = fsockopen('www.paypal.com', 80, $errno, $errstr, 30);
  // Send the HTTP POST request back to PayPal for validation
  fputs($fp, $header . $req);
//$res=stream_get_contents($fp, 1024);
while (!feof($fp)) {                     // While not EOF
    $res = fgets($fp, 1024);               // Get the acknowledgement response
    //$fp1=fopen("stat.txt","a+");
    //fwrite($fp1,$res);
    //fclose($fp1);
    if (strcmp($res, "VERIFIED") == 0) {  // Response contains VERIFIED - process notification
        
        
        mysql_query("update payment set pp_payer_id='{$pp_payer_id}',pp_payer_status='{$pp_payer_status}',pp_payer_email='{$pp_payer_email}',pp_txn_id='{$pp_txn_id}',pp_payment_date='{$pp_payment_date}',pp_payment_status='{$pp_payment_status}',pp_pending_reason='{$pp_pending_reason}',pp_verified='VERIFIED',pay_date='".time()."',payment_gross='{$payment_gross}',mc_gross='{$pp_price}' where id=".$id);
        // Send an email announcing the IPN message is VERIFIED
        // $mail_From    = "IPN@example.com";
        // $mail_To      = "Your-eMail-Address";
        // $mail_Subject = "VERIFIED IPN";
        //$mail_Body    = $req;
        // mail($mail_To, $mail_Subject, $mail_Body, $mail_From);

        // Authentication protocol is complete - OK to process notification contents

        // Possible processing steps for a payment include the following:

        // Check that the payment_status is Completed
        // Check that txn_id has not been previously processed
        // Check that receiver_email is your Primary PayPal email
        // Check that payment_amount/payment_currency are correct
        // Process payment
        //$fp2=fopen("stat.txt","w+");
        //fwrite($fp2,$res."VERIFIED\r\n");
        //fclose($fp2);
    } 
    else if (strcmp($res, "INVALID") == 0) { //Response contains INVALID - reject notification
        mysql_query("update payment set pp_payer_id='{$pp_payer_id}',pp_payer_status='{$pp_payer_status}',pp_payer_email='{$pp_payer_email}',pp_txn_id='{$pp_txn_id}',pp_payment_date='{$pp_payment_date}',pp_payment_status='{$pp_payment_status}',pp_pending_reason='{$pp_pending_reason}',pp_verified='INVALID',pay_date='".time()."',payment_gross='{$payment_gross}',mc_gross='{$pp_price}' where id=".$id);
        $res=mysql_query("select a.userid,a.package_id,a.price,b.period from payment as a, packages as b where a.package_id=b.id and a.id=".$id." limit 1");
        while($row=mysql_fetch_row($res)){
            $userid=$row[0];
            $package_id=$row[1];
            $price=$row[2];
            $period=$row[3];
        }
        if($pp_price!=$price) {
            mysql_query("update payment set `note`='not_equal' where id=".$id);
        }
        $payed_till=till($period);
        mysql_query("update users set package=$package_id,payed_till='{$payed_till}' where id=".$userid);
        // Authentication protocol is complete - begin error handling

        // Send an email announcing the IPN message is INVALID
        // $mail_From    = "IPN@example.com";
        //$mail_To      = "Your-eMail-Address";
        // $mail_Subject = "INVALID IPN";
        // $mail_Body    = $req;

        // mail($mail_To, $mail_Subject, $mail_Body, $mail_From);
        //$fp2=fopen("stat.txt","w+");
        //fwrite($fp2,"INVALID\r\n");
        //fclose($fp2);
    }
}
fclose($fp);

//echo "VERIFIED";
?>