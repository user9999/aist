<!DOCTYPE html>
<html>
<head>
    <title><?php echo $PAGE_TITLE ?></title>
    <meta charset="utf-8">
    <meta name="description" content="<?php echo $META_DESCRIPTION ?>">
    <meta name="keywords" content="<?php echo $META_KEYWORDS ?>">

    <meta name = "viewport" content = "width=device-width; initial-scale=1.0;" />
    <meta content='true' name='HandheldFriendly'/>
    <meta content='width' name='MobileOptimized'/>
    <meta content='yes' name='apple-mobile-web-app-capable'/>
    <link  rel='stylesheet/less'  type="text/css" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/less/m.style.less">
    <script src='//cdn.jsdelivr.net/npm/less@3.13' ></script>
<?php
echo $GLOBALS['CSS']??'';
?>
    <!--kvn_css-->
    <!--kvn_css_user-->
    <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <script src="js/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/js/m.script.js"></script>
    <script type='text/javascript' src='/js/jquery.maskedinput.min.js'></script>
    <script>
    jQuery(function($){
   $('[name *= "phone"]').mask("+7 (999) 999-9999");
});
</script>
<?php
echo $GLOBALS['SCRIPT']??'';
?>
<!--kvn_scripts-->
<!--kvn_script_user-->
</head>
<body>
    <div class="pagewidth">
        <div>
<h1 class="left"><?php echo $SITE_TITLE ?></h1>  <div><a class="phone h1"  href="tel:8(900)3125432"><?php #echo get_settings('phone')?>8 (987) 654 32 10</a></div>   
</div>
        <div class="adminmenu recursive">
            <!--kvn_catalog_menu-->                     
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
        <div class="content">
            <?php
echo $PAGE_BODY;
get_moduletext('mobile');
?>
        </div>
    </div>
</body>
</html>
