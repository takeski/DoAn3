<?php
	// var_dump($_GET);exit(0);
	//https://thanhthaimobile.site/functions/baokim.php?created_on=1500141603&customer_email=takeski22%40gmail.com&customer_name=dsaas&customer_phone=84962104688&fee_amount=0&merchant_email=doanquocthai22%40gmail.com&merchant_id=29404&merchant_name=Th%C3%A1i+%C4%90o%C3%A0n&merchant_phone=84962104699&net_amount=1000&order_id=UW5B874K85&payment_type=2&total_amount=1000.00&transaction_id=81E40C98FC0FCD6&transaction_status=13&checksum=576D4410E2668E392475A7B39F4BF6C9
	//array(16) { ["created_on"]=> string(10) "1500141603" ["customer_email"]=> string(19) "takeski22@gmail.com" ["customer_name"]=> string(5) "dsaas" ["customer_phone"]=> string(11) "84962104688" ["fee_amount"]=> string(1) "0" ["merchant_email"]=> string(24) "doanquocthai22@gmail.com" ["merchant_id"]=> string(5) "29404" ["merchant_name"]=> string(12) "Thái Đoàn" ["merchant_phone"]=> string(11) "84962104699" ["net_amount"]=> string(4) "1000" ["order_id"]=> string(10) "UW5B874K85" ["payment_type"]=> string(1) "2" ["total_amount"]=> string(7) "1000.00" ["transaction_id"]=> string(15) "81E40C98FC0FCD6" ["transaction_status"]=> string(2) "13" ["checksum"]=> string(32) "576D4410E2668E392475A7B39F4BF6C9" }

	session_start();
	require_once(dirname(__FILE__) . "/../libraries/dbhelper.php");
	require_once(dirname(__FILE__) . "/../libraries/BaoKimPayment.php");
	require_once(dirname(__FILE__) . "/../libraries/PHPMailer/PHPMailerAutoload.php");	
	
	$db = new DBHelper();
	$bkpayment = new BaoKimPayment();
	$mail = new PHPMailer();
	
	if ($bkpayment->verifyResponseUrl($_GET)) {	
		$data["trangthai"] = "danggiaohang";
		$db->SetTable("#_donhang");
		$db->SetWhere("iddonhang", "=", $_SESSION["orderid"]);
		$db->Update($data);
		
		$db->SetTable("#_thongtin");
		$settings = reset($db->Select());
		
		$db->SetTable("#_donhang");
		$db->SetWhere("iddonhang", "=", $_SESSION["orderid"]);
		$data = reset($db->Select());
		$detailsid = $data["id"];
		
		//Enable SMTP debugging. 
		//$mail->SMTPDebug = 2;                               
		//Set PHPMailer to use SMTP.
		$mail->isSMTP();            
		//Set SMTP host name                          
		$mail->Host = "smtp.gmail.com";
		//Set Charset for email
		$mail->CharSet="UTF-8";
		//Set this to true if SMTP host requires authentication to send email
		$mail->SMTPAuth = true;                          
		//Provide username and password     
		$mail->Username = $settings["emailgui"];                 
		$mail->Password = $settings["matkhauemail"];                      
		//If SMTP requires TLS encryption then set it
		$mail->SMTPSecure = "ssl";                           
		//Set TCP port to connect to 
		$mail->Port = 465;                                   

		$mail->From = $settings["emailgui"];
		$mail->FromName = $settings["ten"];
		
		$mail->addReplyTo($settings["emailcty"], 'Information');
		
		$mail->isHTML(true);

		$mail->Subject = $settings["ten"] . " - " . $settings["slogan"];
		
		$mail->addAddress($data["email"], $data["hoten"]);

		$mail->Body = "<i>Mail body in HTML</i>";
		//$mail->AltBody = "This is the plain text version of the email content";
		// ob_start();
		// require_once(SERVER_ROOT . "templates/fragments/email.php");
		// $body = ob_get_contents();
		// ob_end_clean();

		// $mail->Body = $body;
		$mail->AltBody = "Cảm ơn bạn đã mua hàng tại " . $settings["ten"] . "! Mã đơn hàng của bạn là: " . $data["iddonhang"] . ". Chi tiết đơn hàng bạn có thể xem tại: " . WEB_ROOT . "tra-cuu-don-hang";
								
		$mail->send();
	
		unset($_SESSION["cart"]);
		$re["payment"] = "";
		$re["fullname"] = "";
		$re["phonenumber"] = "";
		$re["email"] = "";
		$re["address"] = "";
		$re["content"] = "";
		$re["error"] = "Thanh toán thành công!";
		$_SESSION["cartinfo"] = json_encode($re);
		unset($_SESSION["orderid"]);
		header("Location: " . WEB_ROOT . "gio-hang");
		exit(0);
	}
	else {
		$db->SetTable("#_donhang");
		$db->SetWhere("iddonhang", "=", $_SESSION["orderid"]);
		$order = $db->Select();
		
		if (count($order) != 1) {
			$re["payment"] = "";
			$re["fullname"] = "";
			$re["phonenumber"] = "";
			$re["email"] = "";
			$re["address"] = "";
			$re["content"] = "";
			$re["error"] = "Lỗi không xác định!";
			$_SESSION["cartinfo"] = json_encode($re);
			unset($_SESSION["orderid"]);
			header("Location: " . WEB_ROOT . "gio-hang");
			exit(0);
		}
		else {
			$order = reset($order);
		}
		
		$db->SetTable("#_chitietdonhang");
		$db->SetWhere("idchitietdonhang", "=", $order["id"]);
		$details = $db->Select();
		
		$curTime = time();
		foreach ($details as $detail) {
			$lstSerials = json_decode($detail["idserialnumber"], true);
			
			foreach ($lstSerials as $serial) {
				$update["trangthai"] = 1;
				$update["ghichu"] = "Hủy đơn hàng " . $order["iddonhang"];
				$update["thoigian"] = $curTime;
				$db->SetTable("#_khohang");
				$db->SetWhere("idsanpham", "=", $detail["idsanpham"]);
				$db->SetWhere("serial", "=", $serial);
				$db->Update($update);
			}
		}
		
		$data["trangthai"] = "dahuy";
		$db->SetTable("#_donhang");
		$db->SetWhere("id", "=", $order["id"]);
		$db->Update($data);
		
		unset($_SESSION["cart"]);
		$re["payment"] = "";
		$re["fullname"] = "";
		$re["phonenumber"] = "";
		$re["email"] = "";
		$re["address"] = "";
		$re["content"] = "";
		$re["error"] = "Thanh toán bị hủy bỏ!";
		$_SESSION["cartinfo"] = json_encode($re);
		unset($_SESSION["orderid"]);
		header("Location: " . WEB_ROOT . "gio-hang");
		exit(0);
	}
?>