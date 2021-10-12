<!DOCTYPE html>
<html lang="ru">
  <head>
    
    <title><?php echo $PAGE_TITLE ?></title>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $META_DESCRIPTION ?>">
    <meta name="keywords" content="<?php echo $META_KEYWORDS ?>">
    <meta name="theme-color" content="#ccc">
    <meta name = "viewport" content = "width=device-width; initial-scale=1.0;">
    
    <!--
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    -->
    <link rel='stylesheet/less' href='<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/less/style.less'>
    <script src='//cdn.jsdelivr.net/npm/less@3.13' ></script>
    <!--kvn_css-->

    <!--kvn_css_user-->
<?php
echo $GLOBALS['CSS']??'';
?>
    
    <script type="text/javascript" src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/js/script.js" defer></script>
    <script type='text/javascript' src='/js/jquery.maskedinput.min.js' defer></script>
    <!--kvn_scripts-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js" defer></script><!--React development--><script crossorigin src="https://unpkg.com/react@17/umd/react.development.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.development.js"></script>
    <!--kvn_script_user-->
    <?php
echo $GLOBALS['SCRIPT']??'';
?>
    <script>
    jQuery(function($){
   $('[name *= "phone"]').mask("+7 (999) 999-9999");
});
</script>




  </head>
  <body>
      <!--kvn_languages-->
    <header class="flex_main flex_aitem-center flex_jcontent-between">
      <div class="top">
          <div class="image"></div>
      <div class="greeting">
          <h1><?php echo $SITE_TITLE ?></h1>
          <p>слоган</p>
        </div>
    </div>
    <div class="top"><div class="data">
        <!--kvn_user-->
        <a class="phone"  href="tel:8(900)3125432"><?php #echo get_settings('phone')?>8 (987) 654 32 10</a>
        <a class="mail"  href="mailto:m@m.ru">mail@mail.ru</a>
    </div>
    <div class="cart">
        <!--kvn_cart-->
        <span id="cartno">0</span>
        <span id="cartsum">0р.</span>
    </div>
    </div>
    </header>
    
        <!--kvn_menu_main-->
        <?php #load_module("menu.top",0);?>
        <ul class="topmenu flex_main flex_acontent-around flex_aitem-center">
        <li><a href="">1 пункт</a>
            <ul id="ul_3" class="child level1 parent_2">
            <li><a href="/">1.1 пункт</a></li>
            <li><a href="/">1.2 пункт</a></li>
            <li><a href="/">1.3 пункт</a></li>
            </ul>
        </li>
        <li><a href="">2 пункт</a></li>
        <li><a href="">3 пункт</a></li>
        <li><a href="">4 пункт</a></li>
        <li><a href="">5 пункт</a></li>
        </ul>
<!--kvn_rotator-->
    <section class="flex_wrap flex_acontent-between">
      <article>
        <!--kvn_search-->
        <h2>Каталог</h2>

        <div class="adminmenu recursive">
            <!--kvn_catalog_menu-->  
            <?php #load_module("menu.catalog",0);?>
            <ul id="ul_1" class="menu recursive">
            <li><a href="/"> Пункт 1 </a> <span class="closed"></span>
            <ul id="ul_2" class="child level1 parent_1">
                <li><a href="/">Пункт  2</a></li>
                <li><a href="/">Пункт  2</a></li>
                <li><a href="/">Пункт  2</a></li>
                <li><a href="/">Пункт  2</a></li>
            </ul>
            </li>
            <li><a href="/"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/"> Пункт 1 </a> <span class="open"></span></li>
            <li><a href="/"> Пункт 1 </a> <span class="open"></span></li>
            </ul>
        </div>
    </article>

        <article><img id='resp_menu' width="80" height="80" src='<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/images/menu.png' class='resp_menu'>
        <h2 class='middle'>Контент</h2>
<?php
echo $PAGE_BODY 
?>
        <!--kvn_scripts_rotator-->
        <?php 
get_moduletext('main'); 
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
<!--kvn_widgets-->
  </body>
</html>
