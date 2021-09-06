<?php
require 'PHPExcel.php';

$file = $_FILES['fileupload']['tmp_name'];

$objReader = PHPExcel_IOFactory::createReaderForFile($file) ;

$listSheet = $objReader->listWorksheetNames($file); //Lấy danh sách tên sheet trong file

$objReader->setLoadSheetOnly('sheetname'); //Xác định sheet sẽ lấy dữ liệu

$objExcel = $objReader->load($file); //Load file

$sheetData = $objExcel->getActiveSheet()->toArray(null, true, true, true); //đọc dữ liệu trong sheet vào array

$lastRow = $objExcel->setActiveSheetIndex()->getHighestRow(); //Lấy dòng cuối cùng có dữ liệu

/*Export ra excel*/
?>