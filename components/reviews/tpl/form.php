<?php if($TEMPLATE['error']) : ?>
<div class=error><?php echo $TEMPLATE['error']?></div>
<?php endif ?>
<form method=post>
<table class="comment_form">
<tbody><tr><td><?php echo $GLOBALS['dblang_name'][$GLOBALS['userlanguage']] ?> * <br><input type="text" name="uname" value="" maxlength="128"></td>
<td><?php echo $GLOBALS['dblang_email'][$GLOBALS['userlanguage']] ?> <?php echo $GLOBALS['dblang_nopublish'][$GLOBALS['userlanguage']] ?> * <br><input type="text" name="umail" value="" maxlength="128"></td></tr>
<tr>
<td colspan=2><?php echo $GLOBALS['dblang_title'][$GLOBALS['userlanguage']] ?><br> <input class="p100"type="text" name="title" value="" maxlength="128"></td></tr>
<tr><td colspan="2"><?php echo $GLOBALS['dblang_review'][$GLOBALS['userlanguage']] ?><br><textarea name="review"></textarea></td></tr>
<tr><td colspan="2" style="text-align:center"><input type="submit" name="comment" value="<?php echo $GLOBALS['dblang_makeReview'][$GLOBALS['userlanguage']] ?>" class="pressbutton"></td></tr>
</tbody></table>
</form>