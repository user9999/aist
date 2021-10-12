<?php
$fp=fopen("pay.txt", "w+");
fwrite($fp, var_export($_REQUEST, true)."\r\n");
fclose($fp);

?>