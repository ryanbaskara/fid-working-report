<?php
/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';

include "config.php";
    include "check-login.php";

    $month = @$_GET['month'];
    $year = @$_GET['year'];
    $id = @$_GET['id'];

    $query_da = 'SELECT *, EXTRACT(DAY FROM date) day FROM attendance WHERE date BETWEEN "'.date("Y-m-1",mktime(0,0,0,$month,1,$year)).'" AND "'.date("Y-m-t",mktime(0,0,0,$month,1,$year)).'" AND employee_id = "'.$id.'" ORDER BY date';

    $query_user = "SELECT employee.name as name, employee.id as id_emp, employee.position as posisi, month_attended.customer_name as cus_name, month_attended.project_name as pro_name, month_attended.wo_number as wo_num, SEC_TO_TIME(month_attended.totaltime) as tot_time, SEC_TO_TIME(month_attended.overtime) as ov_time, month_attended.attended FROM month_attended INNER JOIN employee where employee.id= '$id' AND `date` = '".date("Y-m-1",mktime(0,0,0,$month,1,$year))."'";

    $query1 = mysqli_query($conn,$query_user);
    $result1 = mysqli_fetch_array($query1);   

    $name = $result1['name'];
    $id_emp = $result1['id_emp'];
    $position = $result1['posisi'];
    $customer_name = $result1['cus_name'];
    $project_name = $result1['pro_name'];
    $wo_number = $result1['wo_num'];

// Create new PHPExcel object
// $objPHPExcel = new PHPExcel();

// Set document properties
    $objReader = PHPExcel_IOFactory::createReader('Excel5');
    $objPHPExcel = $objReader->load("../dist/file/template-wr.xls");
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E7', $month)
            ->setCellValue('F7', $year)
            ->setCellValue('E3',$name)
            ->setCellValue('E4',$id_emp)
            ->setCellValue('E5',$position)
            ->setCellValue('K3',$customer_name)
            ->setCellValue('K4',$project_name)
            ->setCellValue('K5',$wo_number);
$start = '9';
$query = mysqli_query($conn,$query_da);
$n = date("t",mktime(0,0,0,$month,1,$year));
while ($row = mysqli_fetch_array($query)) {
    $startRow = $start + $row['day'];
        $time_in = substr($row['time_in'], 0, strlen($row['time_in'])-3);
        $time_out = substr($row['time_out'], 0, strlen($row['time_out'])-3);
        $time_break = substr($row['time_break'], 0, strlen($row['time_break'])-3);
        $place = $row['place'];
        $activity = $row['activity'];
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$startRow, $time_in)
            ->setCellValue('F'.$startRow, $time_out)
            ->setCellValue('G'.$startRow, $time_break)
            ->setCellValue('J'.$startRow, $place)
            ->setCellValue('K'.$startRow, $activity);
}


// Redirect output to a client’s web browser (Excel5)
$filename = "Working Report - ".$name.date(" - F",mktime(0,0,0,$month,1,$year)).".xls";
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename='.$filename);
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
