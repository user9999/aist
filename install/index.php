<?php
define('INSTALL', 1);
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<title>Установка магазина. Шаг <?php echo ($_GET['step'])?intval($_GET['step']):1;?></title>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css?1">
</head>
<body>
<div class=content>
<?php
$_GET['step']=($_GET['step'])?$_GET['step']:0;
switch($_GET['step']){
case 1:
    include "server.php";
    break;
case 2:
    include "db.php";
    break;
case 3:
    include "pages.php";
    break;
case 4:
    include "setconfig.php";
    break;
default:
    include "server.php";
}
?>
</div>
</body>
</html>
