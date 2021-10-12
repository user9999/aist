<div class=content_body>
<h3><?php echo $TEMPLATE['title']?></h3>
<br>
<div style='float:right;font-weight:bold'>Вы заработали: <a href='<?php echo $PATH?>/account/witdraw'><?php echo $TEMPLATE['cash']?> руб.</a></div><br>
<p><?php echo $TEMPLATE['error']?></p>
<?php echo $TEMPLATE['content']?>
<form method=post>
<table>
<caption>Ваше сообщение</caption>
<tr><td>Заголовок</td><td><input name=title value="<?php echo $TEMPLATE['mtitle']?>" size=70></td></tr>

<tr><td colspan=2><textarea rows=7 cols=70 name=message><?php echo $TEMPLATE['message']?></textarea></td></tr>
<tr><td colspan=2 style="text-align:center"><input type=submit name=send value="Отправить" class=button style="cursor:pointer"></td></tr>
</table>
</form>
<?
    $out="";
    $res1=mysql_query('select * from partner_message where status<4 and sender='.$_SESSION['partnerid'].' or recipient='.$_SESSION['partnerid'].' order by sendtime desc');
    while($row1=mysql_fetch_array($res1)){
      $out.='<div style="width:100%;border:1px solid #444;padding: 5px 5px 5px 5px;margin:2px 0 0 0;"><span style="width:95%;float:left"> <i>'.date("d-m-Y H:i",$row1['sendtime']).'</i></span><span style="width:4%;float:left"><a href="message&delid='.$row1[0].'">x</a></span><br><h3 style="font-weight:bold">'.stripslashes($row1['title']).'</h3><br>'.stripslashes($row1['message']).'</div>'."\n";
    }
    echo $out;
?>

</div>
