<!DOCTYPE html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<HTML>
<HEAD>
<META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<TITLE>PHP Mail Test</TITLE>
<style>
body {
	background-color : #f2f2f2;
	color : #000000;
	font-family : verdana, geneva;
	font-size:11px;
	line-height:15px;
}


TD, P, PRE {
	color : #000000;
	font-family : verdana, geneva;
	font-size:11px;
	line-height:15px;
}

</style>
</HEAD>
<BODY>
<DIV align="center" style="margin-top:60px">
		<table style="background-color:#ffffff; width:500px; border width:1px solid #666666;" cellpadding="8">
			<tr>
				<td style="font-family: arial; font-size: 17px; font-weight: bold; color: #000000;">
					PHP Mail Test
				</td>
			</tr>
		</table>
		<br><br>
		<table style="background-color: #ffffff; width: 500px; border width: 1px solid #666666;" cellpadding="8">
			<tr>
				<td style="line-height:18px">
					This form will attempt to send a mail using php <hr noshade width='90%' size='1px'>
<?
	
	if(isset($_POST['from']) && isset($_POST['to']))
	{
		ini_set("sendmail_from", $_POST['from']);
		if(mail($_POST['to'], "Test Email From " . $_SERVER['SERVER_NAME'], "Test mail from " . $_SERVER['SERVER_NAME'] . " using PHP.", "From: <" . $_POST['from'] . "> -f" . $_POST['from'] ))
		{
			print "Mail has been successfully sent (no errors anyway)";
		}
	}
	else
	{
		print "<form action='?' method='post'><table border='0'>" .
			"<tr><td>Email To</td><td><input type='text' size='30'  name='to' value='test@" . $_SERVER['SERVER_NAME'] . "' style='background-color:#f2f2f2;border-width:1px;border-style:Solid;'></td></tr>" .
			"<tr><td>Email From</td><td><input type='text' size='30' name='from' value='test@" . $_SERVER['SERVER_NAME'] . "' style='background-color:#f2f2f2;border-width:1px;border-style:Solid;'></td></tr>" .
			"<tr><td></td><td align='right'><input type='submit' value='Test Mail' style='background-color:#f2f2f2;border-width:1px;border-style:Solid;'></td></tr>" .
			"</table></form>";
	}

?>
				</td>
			</tr>
		</table>
</div>
</BODY>
</HTML>
