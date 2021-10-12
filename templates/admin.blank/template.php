<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title><?php echo ($PAGE_TITLE[$DLANG])?$PAGE_TITLE[$DLANG]:'' ?> - система управления</title>    
<script src="https://kit.fontawesome.com/7be204c2d4.js" crossorigin="anonymous"></script>
        
        <link rel="stylesheet/less" href="<?php echo $PATH ?>/templates/<?php echo $ADMIN_TEMPLATE ?>/less/style.less">
        <script src="//cdn.jsdelivr.net/npm/less@3.13" ></script>
        <link rel="stylesheet" type="text/css" href="/templates/admin.blank/upload.css">
        <link rel="stylesheet" type="text/css" href="/templates/admin.blank/menu.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<?php
echo ($GLOBALS['CSS'])?$GLOBALS['CSS']:'';
?>
        <script type="text/javascript" src="<?php echo $PATH ?>/inc/ckeditor/ckeditor.js"></script>
        <script type="text/javascript" src="<?php echo $PATH ?>/inc/ckeditor/lang/_languages.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="/templates/<?php echo $ADMIN_TEMPLATE ?>/script.js"></script>
<script type="text/javascript" src="/js/admin/script.php"></script>
        <script type="text/javascript" src="<?php echo $PATH ?>/js/lcs.js"></script>
        <script type="text/javascript" src="<?php echo $PATH ?>/js/jquery.inputmask.js"></script>
        <script type="text/javascript" src="<?php echo $PATH ?>/js/jquery.maskedinput.min.js"></script>
        <script type="text/javascript" src="<?php echo $PATH ?>/js/jquery.inputmask.date.extensions.js"></script>
        <script>
$( document ).ready(function() {
//$("#deliver_date").inputmask("d-m-y");
$('[id^="date_"]').inputmask("d-m-y");//d-m-y
$('[id^="time_"]').inputmask("с h.s до h.s");
    $( ".clear" ).mouseover(function() {
        $(this).css('background-color', '#ccc');
    });
    $( ".clear" ).mouseout(function() {
        $(this).css('background-color', '#fff');
    });
});

</script>
<?php
echo ($GLOBALS['SCRIPT'])?$GLOBALS['SCRIPT']:'';
$link="";
$_GET['component']=($_GET['component'])?$_GET['component']:'index';
//echo $HOSTPATH."/components/".$_GET['component']."/".$_GET['component'].".php";
if(file_exists($HOSTPATH."/components/".$_GET['component']."/".$_GET['component'].".php")) {
    $link="/".$_GET['component'];
}
$development=($_SESSION['development'])?"Выйти из режима разработки":"Режим разработки";
?>
    </head>

    <body>
        <div id="main" align="center">
            <table cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="admin_top logo" height="80">
                        <h1 style="width:45%;float:left"><a href="<?php echo $PATH ?>/admin"><b><?php echo $SITE_TITLE[$DLANG] ?></b> - панель управления</a></h1> <h1 style="width:30%;float:left;">[ <a href="<?php echo $PATH.$link;?>">Сайт</a> ]</h1>
                        <span> Здравствуй, <?=$_SESSION['admin_name']?></span><br>
                        <a href="<?php echo $PATH ?>/admin/?component=logout">Выйти из панели управления</a><br>
                        <?php
                        if($_SESSION['admin_name']==$ADMIN_LOGIN){
                        ?>
                        <a href="<?php echo $PATH ?>/admin/?component=development"><?php echo $development?></a>
                        <?php
                        }
                        ?>
                            
                    </td>
                </tr>
                <tr>
                    <td height="20"></td>
                </tr>
                <tr>
                    <td style="padding: 5px;" class="body" valign="top">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td valign="top" width="250">
                                    <?php //load_module("menu", 1); ?> 
                                    <div class="adminmenu recursive">
                                    <?php load_module("new_menu",1);?>
                                    </div>
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
