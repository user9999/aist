<?php
$script="<script type=\"text/javascript\">
\$(document).ready(function() {
 	\$(\"#sendToAdmin\").click(function(e){
     		e.preventDefault();
     		\$.post(\"/reserve.php\", {action: 'sendorder'},
   function(data) {
   \$(\"#Result\").html(data);
   });

 	});
   		
});
function cart(nid,det_id,pr,apr){
    amt=$(\"#i\"+nid).val();
   \$.post(\"/cart.php\", {action:'detail',id:det_id,price:pr,amount:amt,act:apr},
   function(data) {
   if(/\s/.test(data)){
       alert(data);
   } else {
    arr=data.split('|');
    \$(\"#cart #cartno\").html(arr[0]);
    \$(\"#cart #cartsum\").html(arr[1]);
    \$(\"#cart\").animate({opacity: 0.1 }, \"slow\", function() {
    \$(\"#cart\").animate({opacity: 0.85 }, \"slow\");
    });
    \$(\"#cart\").toggleClass(\"cart, cart2\");
    \$(\"#tr_\"+nid).addClass(\"ordered\");
   }
   });

}
function allCart(){
   \$.post(\"/cart.php\", {action:'all'},
   function(data) {
   if(/\s/.test(data)){
       alert(data);
   } else {
    arr=data.split('|');
    \$(\"#cart #cartno\").html(arr[0]);
    \$(\"#cart #cartsum\").html(arr[1]);
    \$(\"#cart\").animate({opacity: 0.1 }, \"slow\", function() {
    \$(\"#cart\").animate({opacity: 0.85 }, \"slow\");
    });
    \$(\"#cart\").toggleClass(\"cart, cart2\");
    \$(\"#allbut\").removeClass(\"addtcrt\").addClass(\"ordbut\");
    //\$(\"#tr_\"+id).addClass(\"ordered\");

   }
   });
}
function updCart(gid,val){
     		\$.post(\"/reserve.php\", {action: 'update',id:gid,amount:val},
   function(data) {
      \$(\"#Result\").html(data);
   });

}
</script>";
set_script($script);
//$act_param=($TEMPLATE['special'])?"1":"0";
?>
<tr id="tr_<?php echo $TEMPLATE['det_id'] ?>" class='reserved'>
<td><a href="catalog/item-<?php echo $TEMPLATE['itemid'] ?>&b=<?php echo $TEMPLATE['brandname'] ?>&t=<?php echo $TEMPLATE['modelname'] ?>"><?php echo $TEMPLATE['oem'] ?></a></td>
<td><?php echo $TEMPLATE['brandname'] ?> <br /><a href="/catalog/model-<?php echo $TEMPLATE['model_id'] ?>"><?php echo $TEMPLATE['modelname'] ?></a></td>
<td><a href="catalog/item-<?php echo $TEMPLATE['itemid'] ?>&b=<?php echo $TEMPLATE['brandname'] ?>&t=<?php echo $TEMPLATE['modelname'] ?>"><?php echo $TEMPLATE['description']." (".$TEMPLATE['country'].")"; ?></a></td>
<td><?php echo $TEMPLATE['price']." ".$GLOBALS['ZNAK'] ?></td>
<td><input type="text" name="zap[<?php echo $TEMPLATE['id'] ?>]" style="width: 25px;" id="i<?php echo $TEMPLATE['det_id'] ?>" value="<?php echo $TEMPLATE['amount'] ?>" tabindex=<?php echo $TEMPLATE['tabindex'] ?> onkeyup='updCart("<?php echo $TEMPLATE['gruz_id'] ?>",this.value)' /></td>
<td style="text-align:center">
<?php
//echo ($TEMPLATE['available']>$TEMPLATE['amount'])?"есть":$TEMPLATE['available']."шт.";
echo ($TEMPLATE['available']>$_SESSION['storage'])?"Более ".$_SESSION['storage']:$TEMPLATE['available'];
?>
</td>

<td class="action">
<?php
If($TEMPLATE['storage']>0 && $TEMPLATE['available']>0) {
    ?>
<a href='javascript:cart(<?php echo $TEMPLATE['det_id'] ?>,"<?php echo $TEMPLATE['gruz_id'] ?>", <?php echo $TEMPLATE['price'] ?>,"0")'><img src="/templates/blank/img/cartadd.png" title="в корзину" alt="" /></a> 
    <?php
}
?>
<a href="/preorder/id-<?php echo $TEMPLATE['id'] ?>"><img src="/img/del.gif" title="Отменить предварительный заказ" alt="" /></a></td>
</tr>
