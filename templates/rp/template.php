<?php 
$p = str_replace($GLOBALS['INCPATH'], "", $_SERVER['REQUEST_URI']);
if (($a = strpos($p, "&")) !== false) {
    $p = substr($p, 0, $a);
}
$p=trim($p, "/");
$p=($p=="")?"index":$p;
$cpg_data=get_text($p);
$META_KEYWORDS=$cpg_data[1]??$META_KEYWORDS;
$META_DESCRIPTION=$cpg_data[2]??$META_DESCRIPTION;
$CPG_TXT=$cpg_data[0]??"";
$PAGE_TITLE=($cpg_data[2]??$PAGE_TITLE);
?>
<!DOCTYPE html>
<html>
  <head>
    
    <title><?php echo $PAGE_TITLE ?></title>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $META_DESCRIPTION ?>">
    <meta name="keywords" content="<?php echo $META_KEYWORDS ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/style.css">
<?php
echo $GLOBALS['CSS']??'';
?>
    	<link rel="stylesheet" href="/widgets/scrollup/scrollup.css" type="text/css" media="screen">
<!--kvn_css-->
    <!--kvn_css_user-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/js/script.js"></script>
    <script>
    jQuery(function($){
   $('[name *= "phone"]').mask("+7 (999) 999-9999");
});
</script>
<?php
echo $GLOBALS['SCRIPT']??'';
?>
<script src="/widgets/scrollup/scrollup.js" type="text/javascript"></script>
<!--kvn_scripts-->
<!--kvn_script_user-->

  </head>
  <body>
      <!--kvn_languages-->
    <header class="flex_main flex_aitem-center flex_jcontent-between">
      <div class="top">
          <div class="image"></div>
      <div class="greeting">
          <h1>Ритуальные принадлежности</h1>
          <p>Добро пожаловать на кладбище!!!</p>
        </div>
    </div>
    <div class="top"><div class="data">
        <!--kvn_user-->
        <a class="phone"  href="tel:8(900)3125432">8 (900) 312 54 32</a>
        <a class="mail"  href="mailto:m@m.ru">mail@mail.ru</a>
    </div>
    <div class="cart">
        <!--kvn_cart-->
        <span id="cartno">2</span>
        <span id="cartsum">1000р.</span>
    </div>
    </div>
    </header>
    
        <!--kvn_menu_main-->
        <ul class="topmenu flex_main flex_acontent-around flex_aitem-center">
            <li>
                <a href="">Каталог</a>
            </li>
        <li><a href="">О компании</a></li>
<li><a href="">Сертификаты</a></li>
<li><a href="">Сертификаты</a></li>
<li><a href="">Сертификаты</a></li>
</ul>
<!--kvn_rotator-->
    <section class="flex_wrap flex_acontent-between">
      <article>
        <!--kvn_search-->
        <h2>Каталог</h2>

        <div class="adminmenu recursive">
            <!--kvn_catalog_menu-->                     
            <ul id="ul_1" class="menu recursive">
            <li><a href="/admin/?component=index"> Пункт 1 </a> <span class="closed"></span>
            <ul id="ul_2" class="child level1 parent_1">
                <li><a href="/admin/?component=index&amp;action=1">Пункт  2</a></li>
                <li><a href="/admin/?component=index&amp;action=3">Пункт  2</a></li>
                <li><a href="/admin/?component=index&amp;action=2">Пункт  2</a></li>
                <li><a href="/admin/?component=index&amp;action=4">Пункт  2</a></li>
            </ul>
            </li>
            <li><a href="/admin/?component=menu"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/admin/?component=static"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/admin/?component=texteditor"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/admin/?component=product"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/admin/?component=parameters"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/admin/?component=settings"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/admin/?component=order"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/admin/?component=product_patameter"> Пункт 1 </a> <span class="open"></span></li>
            </ul>
        </div>
    </article>

        <article><img id='resp_menu' src='<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/images/menu.png' class='resp_menu'>
        <h2 class='middle'>Контент</h2>
<?php
echo $PAGE_BODY 
?>
        <!--kvn_scripts_rotator-->
        <?php 
echo decorate($CPG_TXT); 
?>
        </article>

      <article>
          <h2>Лучшее предложение</h2><div class="clear"></div><br>
          <!--kvn_hits-->
<div class="best">
           <h3>товар 1</h3> 
        </div>
        <div class="best">
            <h3>товар 2</h3> 
         </div>
         <div class="best">
            <h3>товар 3</h3> 
         </div> 
          <div class="best">
            <h3>товар 4</h3> 
         </div> 
      </article>
    </section>
    <footer>
        © 2021 KV design.
    </footer>
<div id="scrollup"><img src="/widgets/scrollup/up.png" class="up" alt="up"></div>
<!--kvn_widgets-->
  </body>
</html>
