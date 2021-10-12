<?php
session_start();

$out = fopen('php://output', 'w');
//fputcsv($out, $_SESSION['csv']);
ob_start();
foreach ($_SESSION['csv'] as $fields) {
    fputcsv($out, $fields);
}
fclose($out);
$csv = ob_get_clean();
$csv=mb_convert_encoding($csv, "windows-1251", "utf-8");
if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE")){   
    header("Cache-Control: ");// leave blank to avoid IE errors 
    header("Pragma: ");// leave blank to avoid IE errors 
    header("Cache-control: private");
    header("Connection: Keep-Alive"); 
    //header("Content-type: application/csv; charset=windows-1251");
 		header("Content-Type: application/octet-stream");
 		header('Content-Length: ' . filesize($csv));
   
    header("Content-Disposition: attachment; filename=file.csv");
    header("Content-Transfer-Encoding: binary\n");
    //header("Content-Transfer-Encoding: binary");

} else {
	header("Content-Type: application/CSV");
	header("Content-Disposition: attachment;filename=file.csv");
}
echo $csv;