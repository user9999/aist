<!doctype html>
<html lang="ru">
    <head>
        <!-- Meta -->
        <title><?php echo $PAGE_TITLE ?></title>
        <meta charset="utf-8">
        <meta name="description" content="<?php echo $META_DESCRIPTION ?>">
        <meta name="keywords" content="<?php echo $META_KEYWORDS ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/css/bootstrap.css">
        <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/css/style.css">
        <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/fonts/futura/futura.css">
        <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/css/carousel/owl.carousel.min.css">
        <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/css/carousel/owl.theme.default.min.css">
        <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/css/fancybox/jquery.fancybox.min.css">
        <!--css_processor-->
<?php
echo $GLOBALS['CSS']??'';
?>
        <!--kvn_css-->
        <!--kvn_css_user-->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js" defer></script>
        <script type="text/javascript" src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/js/script.js" defer></script>
        <script type='text/javascript' src='/js/jquery.maskedinput.min.js'></script>
        <script>
        jQuery(function($){
            $('[name *= "phone"]').mask("+7 (999) 999-9999");
        });
        </script>
<?php
echo $GLOBALS['SCRIPT']??'';
?>
</head>
<body>
    <!-- header -->

    <!-- menu
    <?php #load_module("menu.top",0);?>
    -->
    
    <!-- content
<?php
echo $PAGE_BODY 
?>
    -->
    
    <!-- footer -->

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/08bf94ce22.js" crossorigin="anonymous"></script>
    <script src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/js/carousel/owl.carousel.min.js"></script>
    <script src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/js/carousel/setting.js"></script>
    <script src="<?php echo $PATH ?>/templates/<?php echo $TEMPLATE ?>/js/fancybox/jquery.fancybox.min.js"></script>
    </body>
</html>