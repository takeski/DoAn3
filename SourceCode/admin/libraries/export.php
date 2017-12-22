<?php
	session_start();;
	
	require_once(dirname(__FILE__) . "/../libraries/dbhelper.php");
	define("ADMIN_PATH", WEB_ROOT . "admin");
	
	$com = (isset($_REQUEST['com'])) ? addslashes($_REQUEST['com']) : "";
	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	
	if((!isset($_SESSION["user"]) || $_SESSION["user"]==false) && $act!="login"){
		header("Location: " . WEB_ROOT . "admin?com=user&act=login");
		exit(0);
	}
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if ($id == "") {
		exit(0);
	}
	$db = new DBHelper();	
	$db->SetTable("#_donhang");
	$db->SetWhere("id", "=", $id);
	$order = reset($db->Select());
	
	$db->SetTable("#_chitietdonhang");
	$db->SetWhere("idchitietdonhang", "=", $id);
	$details = $db->Select();
	
	function GetProduct($id){
		global $db;
		
		$db->SetTable("#_sanhpam");
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
	echo "aaa";exit(0);
	
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
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells( 'A2:C2' );
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells( 'D2:F2' );
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells( 'A3:C3' );
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells( 'D3:F3' );
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells( 'A4:C4' );
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells( 'D4:F4' );


	$objPHPExcel->getActiveSheet()->getRowDimension( '1' )->setRowHeight( 15 );
	$objPHPExcel->getActiveSheet()->getStyle( 'A1' )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ),'name' => 'Tahoma', 'bold' => true, 'italic' => false, 'size' => 10 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
	$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(15);
		  
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A1','THÔNG TIN ĐƠN HÀNG' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A3','Họ tên: ' . $order['fullname'] );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A4','Điện thoại: ' . $order['phonenumber'] );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A5','Địa chỉ: ' . $order['address'] );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D3','Ngày đặt: ' . date('d-m-Y H:i', $order['orderdate']) );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D4','Tình trạng: ' . GetStatus($order["status"]) );	

	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A7','STT' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'B7','Mã đơn hàng' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'C7','Tên sản phẩm' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'D7','Số lượng' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'E7','Đơn giá' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F7','Thành tiên' );

	$objPHPExcel->getActiveSheet()->getStyle('A7:F7')->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
	$objPHPExcel->getActiveSheet()->getStyle( 'A7:F7' )->applyFromArray( array( 'font' => array( 'color' => array( 'rgb' => '000000' ), 'name' => 'Tahoma', 'bold' => true, 'italic' => false, 'size' => 10 ), 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true )));

	$vitri = 8;
	$count = 1;
	
	foreach ($details as $detail) {		
		$p = GetProduct($detail["productid"]);
		
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.$vitri, $count )->setCellValue( 'B'.$vitri, $order['orderid'] )->setCellValue( 'C'.$vitri, $p["name"])->setCellValue( 'D'.$vitri, number_format($detail["quantity"]) )->setCellValue( 'E'.$vitri, number_format($p["price"]) . " VNĐ" )->setCellValue( 'F'.$vitri, number_format($detail["quantity"] * $p["price"]) . " VNĐ" );
		$objPHPExcel->getActiveSheet()->getStyle( 'A'.$vitri.':F'.$vitri )->applyFromArray( array( 'alignment' => array( 'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, 'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER, 'wrap' => true ) ) );
		$objPHPExcel->getActiveSheet()->getStyle('A'.$vitri.':F'.$vitri)->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

		++$vitri;
		++$count;
	}
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells( 'A'.$vitri.':E'.$vitri );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'A'.$vitri,'Tổng tiền' );
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue( 'F'.$vitri, number_format($order["totalprice"]) . " VNĐ" );
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
	header( 'Content-Disposition: attachment;filename="don-hang-'. $order['orderid'] . '-' . time() . '.xls"' );
	header( 'Cache-Control: max-age=0' );

	$objWriter = new PHPExcel_Writer_Excel5($objPHPExcel);
	$objWriter->save('php://output');
?>
