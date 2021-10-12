<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo $PAGE_TITLE[$DLANG] ?> - система управления</title>    
        <link rel="stylesheet" href="<?php echo $PATH ?>/templates/<?php echo $ADMIN_TEMPLATE ?>/style.css?3">
        <link rel="stylesheet" type="text/css" href="/templates/admin.blank/upload.css">
<?php
echo $GLOBALS['CSS'];
?>
        <script type="text/javascript" src="<?php echo $PATH ?>/inc/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="<?php echo $PATH ?>/inc/ckeditor/lang/_languages.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
        <script>
$( document ).ready(function() {
    $( ".clear" ).mouseover(function() {
        $(this).css('background-color', '#ccc');
    });
    $( ".clear" ).mouseout(function() {
        $(this).css('background-color', '#fff');
    });
});

</script>
<?php
echo $GLOBALS['SCRIPT'];
$link="";
//echo $HOSTPATH."/components/".$_GET['component']."/".$_GET['component'].".php";
if(file_exists($HOSTPATH."/components/".$_GET['component']."/".$_GET['component'].".php")) {
    $link="/".$_GET['component'];
}
?>
    </head>

    <body>
        <div align="center">
            <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td style="padding: 10px; background-color: #FFFCC8" height="80" class="logo">
                        <h1 style="width:45%;float:left"><a href="<?php echo $PATH ?>/admin"><b><?php echo $SITE_TITLE[$DLANG] ?></b> - панель управления</a></h1> <h1 style="width:30%;float:left;">[ <a href="<?php echo $PATH.$link;?>">Сайт</a> ]</h1>
                        <a href="<?php echo $PATH ?>/admin/?component=logout">Выйти из панели управления</a>
                    </td>
                </tr>
                <tr>
                    <td height="10"></td>
                </tr>
                <tr>
                    <td style="padding: 5px;" class="body" valign="top">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td valign="top" width="250">
                                    <?php load_module("menu", 1); ?> 
                                </td>
                                <td valign="top" class="mainbody">
                                    <?php echo $PAGE_BODY ?>
                                    <div class="spacing"></div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div class="spacing"></div>
        </div>
    </body>
</html>
