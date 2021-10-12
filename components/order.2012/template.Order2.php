<div class="content_body">
    <h3>Оформление заказа</h3>
    <?php if ($TEMPLATE['error']) { ?>
        <div class="error"><?php echo $TEMPLATE['error'] ?></div>
    <?php } ?>
    
    <form method="post">
    <table width="100%" class="tb2">
<?php
if(!$_SESSION['userid']) {
    ?>
        
            <tr>
                <td width="180">ФИО заказчика <span style="color:red;">(*)</span>:</td>
                <td><input type="text" name="frm_name" style="width: 100%;" value="<?php echo $TEMPLATE["items"]["name"] ?>"></td>
            </tr>
            <tr>
                <td>Телефон <span style="color:red;">(*)</span>:</td>
                <td><input type="text" name="frm_phone" style="width: 300px;" value="<?php echo $TEMPLATE["items"]["phone"] ?>"></td>
            </tr>
            <tr>
                <td>Адрес:</td>
                <td><input type="text" name="frm_address" style="width: 100%;" value="<?php echo $TEMPLATE["items"]["address"] ?>"></td>
            </tr>
            <tr>
                <td>E-mail <span style="color:red;">(*)</span>:</td>
                <td><input type="text" name="frm_email" style="width: 300px;" value="<?php echo $TEMPLATE["items"]["email"] ?>"></td>
            </tr>
    <?php 
} else {
     $res2 = mysql_query("SELECT email,name,company,udata from users where id='".$_SESSION['userid']."' limit 1");
     $row2 = mysql_fetch_array($res2);
     $row2[1]=($row2[2])?$row2[2]:$row2[1];
     $tabout="<tr>
				<td><input type='hidden' name='frm_name' value='{$row2[1]}'><input type='hidden' name='frm_email' value='{$row2[0]}'></td>
				<td></td>
			</tr>";
    echo $tabout;
}
                $sum = 0;
                $res=mysql_query("select a.amount,b.id from cart as a,catalog_items as b where a.gruz_id=b.name and a.user_id='{$_SESSION['userid']}'");
while($row=mysql_fetch_row($res)){
      echo "<input type='hidden' name='frm_item_id[]' value='{$row[1]}'>";
      echo "<input type='hidden' name='frm_item_count[]' value='".$row[0]."'>";
      //$sum+=$row[0]* $row['price'];
}
    //////////////    
    /*        
                foreach ($_COOKIE['cart_item_id'] as $k => $v) {
                    $res = mysql_query("SELECT b.* FROM catalog_items as b WHERE b.id = $v");
                    if (($row = mysql_fetch_array($res)) && $_COOKIE['cart_item_count'][$k] > 0) {
                        echo "<input type='hidden' name='frm_item_id[]' value='{$row['id']}'>";
                        echo "<input type='hidden' name='frm_item_count[]' value='" . (int) $_COOKIE['cart_item_count'][$k] . "'>";
                        $sum += $_COOKIE['cart_item_count'][$k] * $row['price'];
                    }
                }    
        */        
            /////////////    
                
?>
            <tr>
                <td></td>
                <td><input type="submit" value="" class="button-ok"></td>
            </tr>
            <?php
            if(!$_SESSION['userid']) {
                ?>
            <tr>
                <td></td>
                <td>Поля, отмеченные <span style="color:red;">(*)</span> обязательны для заполнения.</td>
            </tr>
            <?php } ?>
        </table>
        
    </form>
</div>
