<!DOCTYPE html>
<html>
<head>
<?php 
$p = str_replace($GLOBALS['INCPATH'], "", $_SERVER['REQUEST_URI']);
if (($a = strpos($p, "&")) !== false) {
    $p = substr($p, 0, $a);
}
$p=trim($p, "/");
$p=($p=="")?"index":$p;
//$cpg_data=get_text($p);
$META_KEYWORDS=($cpg_data[1])?$cpg_data[1]:$META_KEYWORDS;
$META_DESCRIPTION=($cpg_data[2])?$cpg_data[2]:$META_DESCRIPTION;
$CPG_TXT=($cpg_data[0])?$cpg_data[0]:"";
$PAGE_TITLE=($cpg_data[2])?$cpg_data[2]:$PAGE_TITLE;
?>
<title><?php echo $PAGE_TITLE ?></title>
<meta charset="utf-8">
<meta name="description" content="<?php echo $META_DESCRIPTION ?>">
<meta name="keywords" content="<?php echo $META_KEYWORDS ?>">
<link rel="stylesheet" href="style.css?3">
<link rel="stylesheet" href="<?php echo $PATH?>/inc/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8">
<?php
echo $GLOBALS['CSS'];
?>
<script type="text/javascript" src="<?php echo $PATH?>/inc/jquery_min.js"></script>
<script type="text/javascript" src="<?php echo $PATH?>/inc/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo $PATH?>/inc/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo $PATH?>/inc/dropDown.js"></script>
<script src="<?php echo $PATH?>/inc/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<!--kvn_scripts-->
<!--kvn_script_user-->
<?php
echo $GLOBALS['SCRIPT'];
?>
</head>
<body>
<div class=top>
<div class=center>
<img src="/img/logo.png" class=logo>
<!--kvn_search-->
<form method="get" action="/search">
<div class=search>
<input name="frm_searchfield" type=text>
<input type="submit" value="" class="button">
</div>
</form>
<!--kvn_user-->
<div class=topright>
<div class="topline" id="contact-form">
<a href="#" class="login">Войти</a>
<a href="#" class="contact">Регистрация</a>
</div>
<!--kvn_cart-->
<div class="cart" id="cart">
<?php
$sum = 0;$amt=0;
if($_SESSION['userid']) {
    if($_SESSION['actype'][0]==1) {
        $query="SELECT a.amount,a.action,b.price,b.special,c.price as userprice FROM `cart` as a,catalog_items as b,`price_".$_SESSION['userid']."` as c WHERE a.user_id='{$_SESSION['userid']}' and a.gruz_id=b.name and a.gruz_id=c.name";
    } else {
        $query="SELECT a.amount,a.action,b.price,b.special FROM `cart` as a,catalog_items as b WHERE a.user_id='{$_SESSION['userid']}' and a.gruz_id=b.name";
    }
    $res=mysql_query($query);
    while($row=mysql_fetch_row($res)){
        $amt++;//=$row[0];
        if($row[1]==1) {//скидка
            $price=preg_replace('/[^0-9]/', '', $row[2]);
            $sum+=$row[0]*$price;
        } else {//своя цена
            $price=($row[3])?preg_replace('/[^0-9]/', '', $row[3]):$row[2];
            $price=($row[4])?$row[4]:$price;
            $price=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1)?floor($price*(100-$_SESSION['percent'])/100):$price;
            $sum+=$row[0]*$price;
        }
    }
} else {
    if($_COOKIE['cart_item_id']) {
        foreach ($_COOKIE['cart_item_id'] as $k=>$v) {
            $v = (int) $v;
            $k = (int) $k;
            if($_SESSION['userid'] && $_SESSION['actype'][0]==1) {
                $res = mysql_query("SELECT b.price,a.special,b.provider FROM catalog_items AS a, `price_".$_SESSION['userid']."` AS b WHERE a.name=b.name AND a.id = $v");
            } else {
                $res = mysql_query("SELECT price,special,provider FROM catalog_items WHERE id = $v");
            }
            if ($row = mysql_fetch_row($res)) {
                //скидка 
                $row[0]=($_SESSION['percent']>0 && $_SESSION['actype'][0]!=1 && $row[1]=='')?floor($row[0]*(100-$_SESSION['percent'])/100):$row[0];
                //валюта
                if($_SESSION['actype'][0]==1 && $_SESSION['actype'][6]==1 && $_COOKIE['currency']=='rub') {
                    $res4=mysql_query("select euro,dollar,currency,ratio from currency where id=1");
                    $row4=mysql_fetch_array($res4);
                    $row[0]=floor($row4[$row4['currency']]*$row4['ratio']*$row[0]);
                }
                //валюта
                $unit=explode(" ", $row[2]);
                $unit[0]=str_replace(",", ".", $unit[0]);
                $item_count=str_replace(",", ".", $_COOKIE['cart_item_count'][$k]);
                $sum += ($row[0] * $item_count/$unit[0]);
            }
        }
    }
}
?>
<a href="<?php echo $GLOBALS['PATH'] ?>/order"> <span id="cartno"><?php echo $amt ?></span> позиций на сумму <b><span id="cartsum"><?php echo $sum ?></span></b> <?php echo $GLOBALS['ZNAK'] ?></a></div>
</div>
<!-- -->

</div>
</div>
<div class="center container">
<!--kvn_rotator-->
<?php load_module("rotator", 0); ?>
<!--kvn_scripts_rotator-->
<script src="js/plugins.js"></script>
<script src="js/scripts.js"></script>

</div>
<div class=footer>
<div class=center>

</div>
</div>
</body>
</html>
