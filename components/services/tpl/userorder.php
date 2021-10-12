<div class="sections">
<h3><?php echo $TEMPLATE['title'] ?> <?php echo $TEMPLATE['date'] ?></h3>
    
    <p><?php echo $TEMPLATE['content'] ?></p>
</div>
<?php
if(strlen($TEMPLATE['out'])>0) {
    echo $TEMPLATE['out'];
} else {
    ?>
<form method=post>
<table>
<tr><td><?php echo $GLOBALS['dblang_family'][$GLOBALS['userlanguage']] ?></td><td><input type=text name=family value=''></td></tr>
<tr><td><?php echo $GLOBALS['dblang_phone'][$GLOBALS['userlanguage']] ?></td><td><input type=text name=phone value=''></td></tr>
<tr><td><?php echo $GLOBALS['dblang_email'][$GLOBALS['userlanguage']] ?></td><td><input type=text name=email value='<?php echo $_SESSION['email'] ?>'></td></tr>
<tr><td colspan=2><input type=hidden name=date value=<?php echo $TEMPLATE['date'] ?>><input type=hidden name=product_id value=<?php echo $TEMPLATE['id'] ?>><input type=submit name=order value="<?php echo $GLOBALS['dblang_order'][$GLOBALS['userlanguage']] ?>"></td></tr>
</table>
</form>
    <?php
}
?>