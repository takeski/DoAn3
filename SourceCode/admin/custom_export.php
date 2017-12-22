<?php
	session_start();
	// var_dump($_SESSION);exit(0);
	
	require_once(dirname(__FILE__) . "/../libraries/dbhelper.php");
	
	$com = (isset($_REQUEST['com'])) ? addslashes($_REQUEST['com']) : "";
	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	
	if((!isset($_SESSION["user"]) || $_SESSION["user"]==false) && $act!="login"){
		header("Location: " . WEB_ROOT . "admin?com=user&act=login");
		exit(0);
	}
	
	if (!isset($_SESSION["order"])) {
		exit(0);
	}
	
	$orders = json_decode($_SESSION["order"], true);
	if ($orders == null) {
		exit(0);
	}
	
	$db = new DBHelper();	
	function GetProduct($id){
		global $db;
		
		$db->SetTable("#_sanpham");
		$db->SetWhere("id", "=", $id);
		return reset($db->Select());
	}
	
	function GetStatus($s) {
		if ($s == "danggiaohang") {
			return "Đang giao hàng";
		}
		else if ($s == "dagiaohang") {
			return "Đã giao hàng";
		}
		else {
			return "Đã hủy";
		}
	}
	
	require_once(dirname(__FILE__) . "/libraries/PHPExcel.php");
	require_once(dirname(__FILE__) . "/libraries/PHPExcel/Writer/Excel5.php");
	
	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Set properties
	$objPHPExcel->getProperties()->setCreator("Admin");
	$objPHPExcel->getProperties()->setLastModifiedBy("Admin");
	$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
	$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.");

	// Add some data
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells( 'A1:F1' );

	$objPHPExcel->getActiveSheet()->getRowDimension( '1' )->setRowHeight( 15 );
	$objPHPExcel->getActiveSheet()->getStyle( 'A1' )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ),'name' => 'Tahoma', 'bold' => true, 'italic' => false, 'size' => 10 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
	$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);
		  
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A1','THÔNG TIN CÁC ĐƠN HÀNG' );

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A3','STT' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B3','Mã đơn hàng' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C3','Tên sản phẩm' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D3','Số lượng' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E3','Đơn giá' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F3','Thành tiên' );

	$objPHPExcel->getActiveSheet()->getStyle('A3:F3')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->getActiveSheet()->getStyle( 'A3:F3' )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Tahoma', 'bold' => true, 'italic' => false, 'size' => 10 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true )));

	$vitri = 4;
	$count = 1;
	$total = 0;
	
	foreach ($orders as $order) {
		$total += $order["tonggia"];
		$db->SetTable("#_chitietdonhang");
		$db->SetWhere("idchitietdonhang", "=", $order["id"]);
		$details = $db->Select();
		foreach ($details as $detail) {		
			$p = GetProduct($detail["idsanpham"]);

			$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.$vitri, $count )->setCellValue( 'B'.$vitri, $order['iddonhang'] )->setCellValue( 'C'.$vitri, $p["ten"])->setCellValue( 'D'.$vitri, number_format($detail["soluong"]) )->setCellValue( 'E'.$vitri, number_format($p["gia"]) . " VNĐ" )->setCellValue( 'F'.$vitri, number_format($detail["soluong"] * $p["gia"]) . " VNĐ" );
			$objPHPExcel->getActiveSheet()->getStyle( 'A'.$vitri.':F'.$vitri )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
			$objPHPExcel->getActiveSheet()->getStyle('A'.$vitri.':F'.$vitri)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

			++$vitri;
			++$count;
		}
	}
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells( 'A'.$vitri.':E'.$vitri );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.$vitri,'Tổng tiền' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F'.$vitri, number_format($total) . " VND" );
	$objPHPExcel->getActiveSheet()->getStyle( 'A'.$vitri.':F'.$vitri )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Tahoma', 'bold' => true, 'italic' => false, 'size' => 10 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true )));

	// Rename sheet
	$objPHPExcel->getActiveSheet()->setTitle('Thông tin đơn hàng');
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("20");
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("50");
			
	header( 'Content-Type: application/vnd.ms-excel' );
	header( 'Content-Disposition: attachment;filename="tong-don-hang' . '-' . time() . '.xls"' );
	header( 'Cache-Control: max-age=0' );

	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	$objWriter->save('php://output');
?>
