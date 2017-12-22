<?php
	session_start();
	require_once(dirname(__FILE__) . "/../../libraries/dbhelper.php");
	$db = new DBHelper();
				
	$results = $db->Query("SELECT c.ngaydathang, ct.soluong FROM tb_donhang c JOIN tb_chitietdonhang ct ON c.id = ct.idchitietdonhang 
	WHERE ct.idsanpham = '".$_GET["id"]."' AND c.trangthai !='dahuy' ");

	$day = date("d", reset($results)["ngaydathang"]);
	$month = date("m", reset($results)["ngaydathang"]);
	$year = date("Y", reset($results)["ngaydathang"]);
	$firstDay = strtotime($day . "-" . $month . "-" . $year);
	$nextDay = $firstDay + 86400;
	
	$quantityInDay = 0;
	$arrQuantity = array();
	
	foreach ($results as $k=>$result) {
		if ($result["ngaydathang"] >= $firstDay && $result["ngaydathang"] < $nextDay) {
			$quantityInDay += $result["soluong"];
			
			if (($k + 1) == count($results)) {
				array_push($arrQuantity, $result["soluong"]);
			}
		}
		else {
			array_push($arrQuantity, $quantityInDay);
			if (($k + 1) < count($results)) {
				$quantityInDay = $result["soluong"];
				$firstDay = $nextDay;
				$nextDay += 86400;
			}
			else {
				array_push($arrQuantity, $result["soluong"]);
			}
		}
	}
	// var_dump($arrQuantity);exit(0);
	
	if (count($arrQuantity) != 0) {
		// Tính giá trị trung bình x = (x1 + x2 + ... + xn) / n
		$x = 0;
		foreach ($arrQuantity as $quantity) {
			$x += $quantity;
		}
		$x /= count($arrQuantity);
		
		
		// Tính phương sai S = [(x1 - x)2 + (x2 - x)2 + ... + (xn - x)2] / n
		$S = 0;
		foreach ($arrQuantity as $quantity) {
			$S += ($quantity - $x) * ($quantity - $x);
		}
		$S /= count($arrQuantity);
		
		// Xuất ra độ lệch chuẩn căn bậc 2 của phương sai và làm tròn lên
		echo ceil(sqrt($S));
	}
	else {
		echo 0;
	}

?>