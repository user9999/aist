<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
    <head>
        <title><?php echo $PAGE_TITLE ?></title>
        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta http-equiv="Content-Language" content="ru">
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />
        <meta name="Description" content="<?php echo $META_DESCRIPTION ?>">
        <meta name="Keywords" content="<?php echo $META_KEYWORDS ?>">
        <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/style.css">
        <script type="text/javascript" src="<?php echo $PATH?>/inc/jquery_min.js"></script>
        <script type="text/javascript" src="<?php echo $PATH?>/inc/jquery.cookie.js"></script>
        <script type="text/javascript" src="<?php echo $PATH?>/inc/jquery.tablesorter.min.js"></script>
        <script>
            $(document).ready(function() {
                if ($.cookie("cart_count")) { 
                    var cs = 0;
                    c = parseInt($.cookie("cart_count"));
                    for (var i = 0; i < c; i += 1) {
                        if ($.cookie("cart_item_id[" + i + "]")) cs++;
                    }
                    $("#cart #cartno").html(cs);
                    if (cs != 0) $("#cart").css({"display": "block"});
                }
                
                $("#htable").tablesorter();
                
                //get location
                var loc = document.location + "";
                var a;
                if ((a = strpos(loc, "model-")) != 0) {
                    md = loc.substr(a + 6);
                    $("#model_" + md).parent().show();
                    $("#model_" + md + " a").css({"font-weight": "bold"});
                } else {
                    md = loc.split("/");
                    m = md[md.length - 1];
                    $(".pos_" + m).show();
                }
            });
            
            function incCartCount() {
                if (!$.cookie("cart_count")) {
                    $.cookie("cart_count", 1, {expires: 7, path: '/'});
                    $("#cart").css({"display": "block"});
                    $("#cart #cartno").html("1");
                } else {
                    $.cookie("cart_count", parseInt($.cookie("cart_count")) + 1, {expires: 7, path: '/'});
                    var cs = 0;
                    c = parseInt($.cookie("cart_count"));
                    for (var i = 0; i < c; i += 1) {
                        if ($.cookie("cart_item_id[" + i + "]")) cs++;
                    }
                    $("#cart").css({"display": "block"});
                    $("#cart #cartno").html(cs);
                }
            }
        
            function addToCart(id, sum) {
                if (!$.cookie("cart_count")) c = 0; else c = parseInt($.cookie("cart_count"));
                var aid = parseInt(id);
                for (var i = 0; i < c; i += 1) {
                    if (parseInt($.cookie("cart_item_id[" + i + "]")) == id) {
                        alert("Позиция уже добавлена в корзину");
                        return;
                    }
                }
                
                var counter = parseInt($('#i' + id).val());
                if (!counter) counter = 1;
                
                var s = parseFloat($("#cart #cartsum").html());
                s += (sum * counter);
                $("#cart #cartsum").html(s);
                
                $.cookie("cart_item_id[" + c + "]", id, {expires: 7, path: '/'});
                $.cookie("cart_item_count[" + c + "]", counter, {expires: 7, path: '/'});
                incCartCount();
                
                //animate
                $("#cart").animate({opacity: 0.1 }, "slow", function() {
                    $("#cart").animate({opacity: 0.85 }, "slow");
                });
                $("#cart").toggleClass("cart, cart2");
                
            }
            
            function showItem(id) {
                $('.menus').slideUp('fast');
                $('#show_' + id).slideDown('fast');
            }

            function strpos (haystack, needle, offset) {
                var i = (haystack + '').indexOf(needle, (offset || 0));
                return i === -1 ? false : i;
            }
            
        </script>
    </head>
    
    <body>
        <!--[if lt IE 8]>
        <div style="background-color:red; color:white; padding:5px; font-family:Tahoma,sans-serif; font-size:13px;">
            Для корректной работы данного сайта мы рекомендуем вам <a href='http://windows.microsoft.com/ru-RU/internet-explorer/downloads/ie-9/worldwide-languages'>обновить браузер</a>.
        </div>
        <![endif]-->
        <center>
        <table width="1024" border="0" cellspacing="0" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" >
                 <tr>
                          <td width="200" align="left">


<a href="/"><img border="0" src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/logo.jpg" border="0"></a></td>
  <td width="800" height="150" align="right"><br>

ЗАПЧАСТИ ДЛЯ ЕВРОПЕЙСКИХ ГРУЗОВЫХ АВТОМОБИЛЕЙ<br><br>

<a href="/catalog/renault"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/logo/logos-reno.jpg" border="0"></a>
<a href="/catalog/volvo"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/logo/logos-volvo.jpg" border="0"></a>
<a href="/catalog/scania"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/logo/logos-scania.jpg" border="0"></a>
<a href="/catalog/man"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/logo/logos-man.jpg" border="0"></a>
<a href="/catalog/iveco"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/logo/logos-iveco.jpg" border="0"></a>
<a href="/catalog/m-b"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/logo/logos-mb.jpg" border="0"></a>
<a href="/catalog/daf"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/logo/logos-daf.jpg" border="0"></a>

</td>
                 </tr>
</table>  
<table width="1024" border="0" cellspacing="0" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" >
                 </tr>  
                 <tr>
                          <td colspan="2" background="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/fon-menu.jpg" align="CENTER"  valign="center">
                               <table width="1000" height="35" class="tablemenu">
                                   <tr>
                                         <?php load_module("menu", 0); ?>
                                         <td width="220"><font color="#98a1b9">Каталог товаров</td>
                                   </tr>
                                </table>
                     </td>
              </tr>
            <tr>
        <td width="750"  valign="top" align="left">
            <?php echo $PAGE_BODY ?>
        </td>
        <td width="250" align="right" valign="top" bgcolor="#000000">

                           <table width="100%">
                                    <tr>
                                        <td align="left">
        
                                <?php if ($GLOBALS['component'] != 'index') { ?>
                                    <br />
                                    <div class="cart" id="cart">
                                    <?php
                                    $sum = 0;
                                    //echo $_SESSION['percent']." --------";
                                    foreach ($_COOKIE['cart_item_id'] as $k=>$v) {
                                        $v = (int) $v;
                                        $k = (int) $k;
                                        $res = mysql_query("SELECT price FROM catalog_items WHERE id = $v");
                                        if ($row = mysql_fetch_row($res)) {
                                            //скидка 
                                            $row[0]=($_SESSION['percent']>0)?floor($row[0]*(100-$_SESSION['percent'])/100):$row[0];
                          
                                            $sum += ($row[0] * (int) $_COOKIE['cart_item_count'][$k]);
                                        }
                                    }
                                    ?>
                                        <a href="<?php echo $GLOBALS['PATH'] ?>/order">В корзине</a> всего <span id="cartno">0</span> позиций на сумму <b><span id="cartsum"><?php echo $sum ?></span></b> руб.
                                    </div>
                                <?php } ?>
                                
                                <?php load_module("right", 0); ?>                                   
                                                                                      
        <table border="0" cellspacing="20" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0">
        <tr><td>
         <font color="#aaaaaa" size="1">
        г. Москва <br>


        <font color="#ffffff" size="3">

         +7 (925) 847 93 20 <br><br>

        <font color="#aaaaaa" size="1">

        г. Санкт-Петербург<br>


        <font color="#ffffff" size="3">

        +7 (921) 944 39 33<br>

         +7 (911) 922 07 03<br>

        <br> <font color="#aaaaaa" size="1">
        Skype: gruz_zap <br> 
        Email: <a href="mailto:<?php echo $ADMIN_EMAIL ?>"><font color="#aaaaaa" size="1">
        <?php echo $ADMIN_EMAIL ?></a>

                                           </td>
                                      </tr>
                             </table>


                                           </td>
                                      </tr>
                             </table>
                   </td>
             </tr>
        </table>

        <?php //if ($GLOBALS['component'] == 'index') { ?>
            <table background="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/fon-niz.jpg" width="1024"  bgcolor="#ffffff" border="0" cellspacing="0" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" >
                  <tr>
                       <td valign="top" align="center" ><a href="<?php echo $PATH ?>/catalog/model-48"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/optika.jpg" border="0"></a></td>
                       <td valign="top" align="center" ><a href="<?php echo $PATH ?>/catalog/section-2"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/kuzov.jpg"  border="0"></a></td>
                       <td valign="top" align="center" ><a href="<?php echo $PATH ?>/catalog/section-3"><img src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/img/aks.jpg"  border="0"></a></td>
                 </tr>
            </table>
        <?php //} ?>
        <font color="#aaaaaa" size="1"> &copy;  <?php echo $SITE_TITLE ?></font>
    </body>
</html>
