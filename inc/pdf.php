<?php
require_once  '../libs/Mpdf/vendor/autoload.php';//__DIR__ .
session_start();
//echo $_SESSION['pdf'];die();
$mpdf = new \Mpdf\Mpdf();
$mpdf->WriteHTML($_SESSION['pdf']);
$mpdf->Output();