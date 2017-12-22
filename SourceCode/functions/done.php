<?php
	session_start();
	
	require_once(dirname(__FILE__) . "/../libraries/dbhelper.php");
	require_once(dirname(__FILE__) . "/../libraries/BaoKimPayment.php");
    $db = new DBHelper();
	
	function generateRandomString($length = 8) {
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST)) {

            $payment = str_replace(" ", "", $_POST["selPayment"]);
			$payment = $payment == "baokim" ? $payment : "tienmat";
            $fullname = $_POST["fullname"];
            $phonenumber = str_replace(" ", "", $_POST["phonenumber"]);
            $email = str_replace(" ", "", $_POST["email"]);
            $address = $_POST["address"];
            $content = $_POST["content"];
			
            
			if (isset($payment) && isset($fullname) && isset($phonenumber) && isset($email) && isset($address) && isset($content) && isset($_SESSION["cart"])) {
				$cart = json_decode($_SESSION["cart"], true);			
				
				if (count($cart) > 0 && $cart != null) {
					$error = false;
					$totalprice = 0;		
								
					foreach ($cart as $c) {
						$db->SetTable("#_khohang");
						$db->SetWhere("idsanpham", "=", $c["idsanpham"]);
						$db->SetWhere("trangthai", "=", 1);
						$quantity = reset($db->Select("count(idsanpham) as totalquantity"))["totalquantity"];
						$quantity = $quantity == null ? 0 : $quantity;
						
						$db->SetTable("#_sanpham");
						$db->SetWhere("id", "=", $c["idsanpham"]);
						$product = reset($db->Select());
						
						if ($c["quantity"] > $quantity) {
							$error = true;		
							$re["error"] = "Số lượng sản phẩm " . $product["ten"] . " còn lại chỉ còn " . $quantity . "!";
							$re["payment"] = $payment;
							$re["fullname"] = $fullname;
							$re["phonenumber"] = $phonenumber;
							$re["email"] = $email;
							$re["address"] = $address;
							$re["content"] = $content;
							$_SESSION["cartinfo"] = json_encode($re);
							break;
						}
						else {
							$totalprice += $product["gia"] * $c["quantity"];
						}
					}
					
					if ($error) {
						header("Location: " . WEB_ROOT . "gio-hang");
						exit(0);
					}
					else {
						if ($payment != "" && $fullname != "" && $phonenumber != "" && $email != "" && $address != "") {
							$db->SetTable("#_thongtin");
							$settings = reset($db->Select());
							$paymentlimit = $settings["gioihantien"];
									
							if ($totalprice > $paymentlimit && $payment == "tienmat") {
								$re["error"] = "Hóa đơn giao hàng tại nhà không lớn hơn " . number_format($paymentlimit) . " VNĐ, mời bạn chuyển sang thanh toán bằng bảo kim để được thanh toán an toàn hơn!";
								$re["payment"] = $payment;
								$re["fullname"] = $fullname;
								$re["phonenumber"] = $phonenumber;
								$re["email"] = $email;
								$re["address"] = $address;
								$re["content"] = $content;
								$_SESSION["cartinfo"] = json_encode($re);
								header("Location: " . WEB_ROOT . "gio-hang");
								exit(0);
							}
						
							$id = reset($db->Query(" SELECT `AUTO_INCREMENT` as 'aid' FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '#_donhang'; "))["aid"];
						
							$data["iddonhang"] = generateRandomString() . $id;
							$data["hoten"] = $fullname;
							$data["sdt"] = $phonenumber;
							$data["email"] = $email;
							$data["diachi"] = $address;
							$data["ngaydathang"] = time();
							$data["noidung"] = $content;
							$data["thanhtoan"] = $payment;
							$data["trangthai"] = "danggiaohang";
							if ($payment == "baokim") {
								$data["trangthai"] = "dangxuly";
							}
							$data["tonggia"] = $totalprice;
							
							$detailsid = 0;
							$db->SetTable("#_donhang");
							if ($detailsid = $db->Insert($data)) {
								$curTime = time();
								foreach ($cart as $c) {
                                    
									$db->SetTable("#_khohang");
									$db->SetWhere("idsanpham", "=", $c["idsanpham"]);
									$db->SetWhere("trangthai", "=", 1);
									$db->SetLimit($c["quantity"]);
									$lstProductSerials = $db->Select("serial");
									
									$lstSerials = array();
									foreach ($lstProductSerials as $s) {
										array_push($lstSerials, $s["serial"]);
										$update["trangthai"] = 0;
										$update["ghichu"] = "Trong đơn hàng " . $data["iddonhang"];
										$update["thoigian"] = $curTime;
										$db->SetTable("#_khohang");
										$db->SetWhere("idsanpham", "=", $c["idsanpham"]);
										$db->SetWhere("serial", "=", $s["serial"]);
										$db->Update($update);
									}
									
									$details["idchitietdonhang"] = $detailsid;
									$details["idsanpham"] = $c["idsanpham"];
									$details["soluong"] = $c["quantity"];
									$details["idserialnumber"] = json_encode($lstSerials);
									$db->SetTable("#_chitietdonhang");
									$db->Insert($details);
								}
							}
   
							if ($payment =="tienmat") {	
								require_once(dirname(__FILE__) . "/../libraries/PHPMailer/PHPMailerAutoload.php");
								
								$mail = new PHPMailer();
								
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

								// $mail->Body = "test";
								$mail->AltBody = "Cảm ơn bạn đã mua hàng tại " . $settings["ten"] . "! Mã đơn hàng của bạn là: " . $data["iddonhang"] . ". Chi tiết đơn hàng bạn có thể xem tại: " . WEB_ROOT . "tra-cuu-don-hang";
								$mail->send();
								
								unset($_SESSION["cart"]);
								$re["payment"] = "";
								$re["fullname"] = "";
								$re["phonenumber"] = "";
								$re["email"] = "";
								$re["address"] = "";
								$re["content"] = "";
								$re["error"] = "Đặt hàng thành công!";
								$_SESSION["cartinfo"] = json_encode($re);
								header("Location: " . WEB_ROOT . "gio-hang");
								exit(0);
							}
							else if ($payment == "baokim") {
								$_SESSION["orderid"] = $data["iddonhang"];

								$bkpayment = new BaoKimPayment();
								$bkpaymenturl = $bkpayment->createRequestUrl(
									$data["iddonhang"],
									$settings["emailcty"],
									$data["tonggia"],
									0,
									0,
									$data["noidung"],
									WEB_ROOT . "functions/baokim.php",
									WEB_ROOT . "functions/baokim.php",
									WEB_ROOT
								);
								
								header("Location: " . $bkpaymenturl);
								exit(0);
							}
							else {
								$re["payment"] = "";
								$re["fullname"] = "";
								$re["phonenumber"] = "";
								$re["email"] = "";
								$re["address"] = "";
								$re["content"] = "";
								$re["error"] = "Lỗi không xác định!";
								$_SESSION["cartinfo"] = json_encode($re);
								header("Location: " . WEB_ROOT . "gio-hang");
								exit(0);
							}
						}
					}
				}
			}
            
        }
    }
?>