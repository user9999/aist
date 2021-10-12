<?php
if(!defined('INSTALL')) { die();
}
$php=phpversion();
$phpnum=explode(".", $php);
//echo $phpnum[0];

if($phpnum[0]<4) {
    $error="Допускается версия php не ниже 4.0";
} elseif($phpnum[0]<6) {
    //$error="Допускается версия php От 4.0 до 5.4";
    $param=5;
} else {
    $error="";
    $param=7;
}

if($error=="") {
    ?>
<script> document.location.href='?step=2&param=<?php echo $param ?>'</script>"
    <?php
} else {
    echo $error;
    echo "<br><a href='?step=2'>Попробовать все равно</a>";
}
?>
