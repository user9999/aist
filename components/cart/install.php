<?php
if(!defined("INSTALL") && !defined("ADMIN_SIMPLE_CMS")) { die();
}
$installCart=array("name"=>"Корзина для магазина",
"description"=>"Корзина для магазина",
"install"=>"",
"tpl_replace"=>array("<!--kvn_cart-->"=>"<div class=\"cart\" id=\"cart\">
<?php
\$sum = 0;\$amt=0;
if(\$_SESSION['userid']){
  if(\$_SESSION['actype'][0]==1){
    \$query=\"SELECT a.amount,a.action,b.price,b.special,c.price as userprice FROM `\".\$PREFIX.\"cart` as a,\".\$PREFIX.\"catalog_items as b,`\".\$PREFIX.\"price_\".\$_SESSION['userid'].\"` as c WHERE a.user_id='{\$_SESSION['userid']}' and a.gruz_id=b.name and a.gruz_id=c.name\";
  } else {
    \$query=\"SELECT a.amount,a.action,b.price,b.special FROM `\".\$PREFIX.\"cart` as a,catalog_items as b WHERE a.user_id='{\$_SESSION['userid']}' and a.gruz_id=b.name\";
  }
  \$res=mysql_query(\$query);
  while(\$row=mysql_fetch_row(\$res)){
    \$amt++;//=\$row[0];
    if(\$row[1]==1){//скидка
      \$price=preg_replace('/[^0-9]/', '', \$row[2]);
      \$sum+=\$row[0]*\$price;
    } else {//своя цена
      \$price=(\$row[3])?preg_replace('/[^0-9]/', '', \$row[3]):\$row[2];
      \$price=(\$row[4])?\$row[4]:\$price;
      \$price=(\$_SESSION['percent']>0 && \$_SESSION['actype'][0]!=1)?floor(\$price*(100-\$_SESSION['percent'])/100):\$price;
      \$sum+=\$row[0]*\$price;
    }
  }
} else {
if(\$_COOKIE['cart_item_id']){
foreach (\$_COOKIE['cart_item_id'] as \$k=>\$v) {
	\$v = (int) \$v;
	\$k = (int) \$k;
  if(\$_SESSION['userid'] && \$_SESSION['actype'][0]==1){
    \$res = mysql_query(\"SELECT b.price,a.special,b.provider FROM \".\$PREFIX.\"catalog_items AS a, `price_\".\$_SESSION['userid'].\"` AS b WHERE a.name=b.name AND a.id = \$v\");
  } else {
    \$res = mysql_query(\"SELECT price,special,provider FROM \".\$PREFIX.\"catalog_items WHERE id = \$v\");
	}
	if (\$row = mysql_fetch_row(\$res)) {
//скидка 
    \$row[0]=(\$_SESSION['percent']>0 && \$_SESSION['actype'][0]!=1 && \$row[1]=='')?floor(\$row[0]*(100-\$_SESSION['percent'])/100):\$row[0];
//валюта
    if(\$_SESSION['actype'][0]==1 && \$_SESSION['actype'][6]==1 && \$_COOKIE['currency']=='rub'){
      \$res4=mysql_query(\"select euro,dollar,currency,ratio from \".\$PREFIX.\"currency where id=1\");
      \$row4=mysql_fetch_array(\$res4);
      \$row[0]=floor(\$row4[\$row4['currency']]*\$row4['ratio']*\$row[0]);
    }
//валюта
\$unit=explode(\" \",\$row[2]);
\$unit[0]=str_replace(\",\",\".\",\$unit[0]);
\$item_count=str_replace(\",\",\".\",\$_COOKIE['cart_item_count'][\$k]);
		\$sum += (\$row[0] * \$item_count/\$unit[0]);
	}
}
}
}
?>
<a href=\"<?= \$GLOBALS['PATH'] ?>/order\"> <span id=\"cartno\"><?= \$amt ?></span><?=\$GLOBALS['dblang_positions'][\$GLOBALS['userlanguage']]?> <?=\$GLOBALS['dblang_total'][\$GLOBALS['userlanguage']]?> <b><span id=\"cartsum\"><?= \$sum ?></span></b> <?= \$GLOBALS['ZNAK'] ?></a></div>
</div>"),
"queries"=>array("")
);
?>