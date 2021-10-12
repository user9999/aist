<?php
require 'libs/vendor/autoload.php';
session_start();
use PhpOffice\PhpSpreadsheet\Spreadsheet;
//use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
//call iofactory instead of xlsx writer
use PhpOffice\PhpSpreadsheet\Aligment;
use PhpOffice\PhpSpreadsheet\Fill;
use PhpOffice\PhpSpreadsheet\IOFactory;


//$reader = IOFactory::createReader('Xlsx');
//$spreadsheet = $reader->load($_SERVER['DOCUMENT_ROOT']. '/src/ExcelVorlagen/polbezirk_template.xlsx');

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$spreadsheet->setActiveSheetIndex(0);

    $filename = 'hello world';
//var_dump();die();
    $row = count($_SESSION['csv']);
$currentContenRow=1;
$spreadsheet->getActiveSheet()->insertNewRowBefore($currentContenRow + 1, $row);
$columns="ABCDEFGHIJKLMNOPQRSTUVWXYZ";
foreach($_SESSION['csv'] as $items){
    //fill the cell with Data
    $spreadsheet->getActiveSheet();
    $pointer=0;
    foreach($items as $item){
        //echo $columns[$pointer];
        $sheet->setCellValue($columns[$pointer].$currentContenRow, $item);
        $pointer++;
    }
    //increment the current row number
    $currentContenRow++;                 
}
    //die();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
header('Cache-Control: max-age=0');

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    //$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
