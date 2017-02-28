<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

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
$startRow = '10';
$query = mysqli_query($conn,$query_da);
$row = mysqli_fetch_array($query);
$n = date("t",mktime(0,0,0,$month,1,$year));
for ($i=1; $i < $n ; $i++) { 
	if ($row['date'] == date("Y-m-d",mktime(0,0,0,$month,$i,$year))) {
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
	else{

	}
	$startRow += 1;
}
/*$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Test result file");

$border_thick = array(
		'borders' => array(
			'right' => array(
				'style' => PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '000'),
				),
			'left' => array(
				'style' => PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '000'),
				),
			'top' => array(
				'style' => PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '000'),
				),
			'bottom' => array(
				'style' => PHPExcel_Style_Border::BORDER_THICK,'color' => array('argb' => '000'),
				)
			)
		);
$border_thin = array(
      'borders' => array(
          'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
          )
      )
  );
$sheet = $objPHPExcel->getActiveSheet();


// Add some data
$objPHPExcel->setActiveSheetIndex(0)
			->mergeCells('B2:J2')
			->setCellValue('B2','Working Report')

			->mergeCells('B3:D3')
            ->setCellValue('B3', 'EmployeeName')
			->mergeCells('B4:D4')
            ->setCellValue('B4', 'ID No.')
			->mergeCells('B5:D5')
            ->setCellValue('B5', 'Position')
			->mergeCells('E3:G3')
			->setCellValue('E3',$name)
			->mergeCells('E4:G4')
			->setCellValue('E4',$id_emp)
			->mergeCells('E5:G5')
			->setCellValue('E5',$position)

            ->setCellValue('J3', 'Customer Name')
			->setCellValue('K3',$customer_name)
            ->setCellValue('J4', 'Project Name')
			->setCellValue('K4',$project_name)
            ->setCellValue('J5', 'WO Number')
			->setCellValue('K5',$wo_number)
            
            ->mergeCells('B7:D7')
            ->setCellValue('B7', 'MONTH/YEAR:')
            ->setCellValue('E7', $month)
            ->setCellValue('F7', $year)
            ->mergeCells('B8:D9')
            ->setCellValue('B8','DATE')
            ->mergeCells('E8:G8')
            ->setCellValue('E8','TIME')
            ->setCellValue('E9','IN')
            ->setCellValue('F9','OUT')
            ->setCellValue('G9','BREAK')
            ->mergeCells('H8:I8')
            ->setCellValue('H8','Working Time')
            ->setCellValue('H9','Total')
            ->setCellValue('I9','OverTime')
            ->mergeCells('J8:J9')
            ->setCellValue('J8','Place')
            ->mergeCells('K8:K9')
            ->setCellValue('K8','Activity');

$startRow = '10';
$query = mysqli_query($conn,$query_da);
$row = mysqli_fetch_array($query);
$n = date("t",mktime(0,0,0,$month,1,$year));
for ($i=1; $i < $n ; $i++) { 
	$day = date("D",mktime(0,0,0,$month,$i,$year));
	$day_in_week = date("N",mktime(0,0,0,$month,$i,$year));
	$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('B'.$startRow, $i)
            ->setCellValue('C'.$startRow, $day_in_week)
            ->setCellValue('D'.$startRow, $day);
	if(date("N",mktime(0,0,0,$month,$i,$year)) == 6 || date("N",mktime(0,0,0,$month,$i,$year)) == 7){
  // $class1 = 'style="background-color:#EB8A71"'; $class2 = 'style="background-color:#EB8A71"';} 
	}
	else {
	// $class1 = 'style="background-color:#FFFCCC"'; $class2 = '';
	}
	if ($row['date'] == date("Y-m-d",mktime(0,0,0,$month,$i,$year))) {
		$time_in = substr($row['time_in'], 0, strlen($row['time_in'])-3);
		$time_out = substr($row['time_out'], 0, strlen($row['time_out'])-3);
		$time_break = substr($row['time_break'], 0, strlen($row['time_break'])-3);
		$totaltime = substr($row['totaltime'], 0, strlen($row['totaltime'])-3);
		$overtime = substr($row['overtime'], 0, strlen($row['overtime'])-3);
		$place = $row['place'];
		$activity = $row['activity'];
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('E'.$startRow, $time_in)
            ->setCellValue('F'.$startRow, $time_out)
            ->setCellValue('G'.$startRow, $time_break)
            ->setCellValue('H'.$startRow, $totaltime)
            ->setCellValue('I'.$startRow, $overtime)
            ->setCellValue('J'.$startRow, $place)
            ->setCellValue('K'.$startRow, $activity);
	}
	else{

	}
	$startRow += 1;
}
$sheet->getStyle("B8:K".($startRow-1))->applyFromArray($border_thin);
$sheet->getStyle("B8:D".($startRow-1))->applyFromArray($border_thick);
$sheet->getStyle("B8:K".($startRow-1))->applyFromArray($border_thick);
$sheet->getStyle("J8:J".($startRow-1))->applyFromArray($border_thick);
$sheet->getStyle("F8:I".$startRow)->applyFromArray($border_thick);

$total = substr($result1['tot_time'], 0, strlen($result1['tot_time'])-3);
$over = substr($result1 ['ov_time'], 0, strlen($result1['ov_time'])-3);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('F'.$startRow.':G'.$startRow)
            ->setCellValue('F'.$startRow, 'TOTAL')
            ->setCellValue('H'.$startRow, $total)
            ->setCellValue('I'.$startRow, $over);

$startRow += 2;
$sheet->getStyle("D".$startRow.":J".($startRow+4))->applyFromArray($border_thin);
$sheet->getStyle("D".$startRow.":J".($startRow+4))->applyFromArray($border_thick);
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('D'.$startRow.':E'.$startRow)
            ->mergeCells('F'.$startRow.':H'.$startRow)
            ->mergeCells('I'.$startRow.':J'.$startRow)
            ->mergeCells('D'.($startRow+1).':E'.($startRow+1))
            ->setCellValue('D'.($startRow+1), 'Issued by')
            ->mergeCells('F'.($startRow+1).':H'.($startRow+1))
            ->mergeCells('I'.($startRow+1).':J'.($startRow+1))

            ->mergeCells('D'.($startRow+2).':E'.($startRow+2))
            ->setCellValue('D'.($startRow+2), 'Date')
            ->mergeCells('F'.($startRow+2).':H'.($startRow+2))
            ->mergeCells('I'.($startRow+2).':J'.($startRow+2))

            ->mergeCells('D'.($startRow+3).':E'.($startRow+3))
            ->setCellValue('D'.($startRow+3), 'Approved by')
            ->mergeCells('F'.($startRow+3).':H'.($startRow+3))
            ->mergeCells('I'.($startRow+3).':J'.($startRow+3))

            ->mergeCells('D'.($startRow+4).':E'.($startRow+4))
            ->setCellValue('D'.($startRow+4), 'Date')
            ->mergeCells('F'.($startRow+4).':H'.($startRow+4))
            ->mergeCells('I'.($startRow+4).':J'.($startRow+4))

            ->setCellValue('F'.$startRow, 'Name')
            ->setCellValue('I'.$startRow, 'Signature');
$startRow += 6;
$objPHPExcel->setActiveSheetIndex(0)
            ->mergeCells('B'.$startRow.':K'.$startRow)
            ->setCellValue('B'.$startRow, 'Note:')
            ->mergeCells('B'.($startRow+1).':K'.($startRow+1))
            ->setCellValue('B'.($startRow+1), 'Bagi karyawan yang tugas luar (khusus untuk standby di satu customer),  prosedur absensi adalah sbb:')
            ->mergeCells('B'.($startRow+2).':K'.($startRow+2))
            ->setCellValue('B'.($startRow+2), '1. Absen wajib dilakukan pada saat datang dan saat pulang kerja dengan mengisi form terlampir.')
            ->mergeCells('B'.($startRow+3).':K'.($startRow+3))
            ->setCellValue('B'.($startRow+3), '2. Setelah akhir bulan, form yang sudah lengkap tsb dikirim beserta lampirannya  seperti: form cuti, keterangan dokter, dll via fax ke manager bersangkutan')
            ->mergeCells('B'.($startRow+4).':K'.($startRow+4))
            ->setCellValue('B'.($startRow+4), '3. Setelah disetujui manager, form ini diserahkan ke HRD.');


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Simple');
for ($col = 'A'; $col != 'P'; $col++) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
}


$sheet->getStyle("B3:G5")->applyFromArray($border_thin);
$sheet->getStyle("B7:F7")->applyFromArray($border_thin);
$sheet->getStyle("J3:K5")->applyFromArray($border_thin);
$sheet->getStyle("B8:K9")->applyFromArray($border_thin);

$sheet->getStyle("B3:G5")->applyFromArray($border_thick);
$sheet->getStyle("B7:F7")->applyFromArray($border_thick);
$sheet->getStyle("J3:K5")->applyFromArray($border_thick);
$sheet->getStyle("B8:K9")->applyFromArray($border_thick);

//$objPHPExcel->getDefaultStyle()->applyFromArray($border_thin);


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);
*/

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
