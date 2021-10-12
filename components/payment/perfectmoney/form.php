<FIELDSET style="border: solid #666666 1px; padding-top: 15px; margin-bottom: 10px;">
					<LEGEND><b>Confirmation of payment</b></LEGEND>
					<form action="https://perfectmoney.com/api/step1.asp" method="POST">
					<input type="hidden" name="PAYEE_ACCOUNT" value="'.$cfgPerfect.'">
					<input type="hidden" name="PAYEE_NAME" value="'.$cfgPAYEE_NAME.'">
					<input type="hidden" name="PAYMENT_ID" value="'.$lid.'">
					<input type="hidden" name="PAYMENT_AMOUNT" value="'.$sum.'">
					<input type="hidden" name="PAYMENT_UNITS" value="USD">
					<input type="hidden" name="STATUS_URL" value="'.$http.'://'.$cfgURL.'/pmresult.php">
					<input type="hidden" name="PAYMENT_URL" value="'.$http.'://'.$cfgURL.'/deposit/?pay=yes">
					<input type="hidden" name="PAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="NOPAYMENT_URL" value="'.$http.'://'.$cfgURL.'/enter/?pay=no">
					<input type="hidden" name="NOPAYMENT_URL_METHOD" value="POST">
					<input type="hidden" name="BAGGAGE_FIELDS" value="">
					<input type="hidden" name="SUGGESTED_MEMO" value="'.$cfgURL.'">
					<center>
					You transfer the <strong> '.$sum.' </strong> USD to account <strong>'.$cfgPerfect.'</strong> PerfectMoney<br />Recharge in the project '.$cfgURL.'<br />
					<p align="center"><input class="subm" name="PAYMENT_METHOD" type="submit" value=" Payment confirm " /></p>
					</center>
					</form>
					</FIELDSET>'