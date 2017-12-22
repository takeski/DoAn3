<?php
	session_start();
	require_once(dirname(__FILE__) . "/../libraries/dbhelper.php");
    $db = new DBHelper();
	
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["act"])) {
			if ($_POST["act"] == "clearcart") {
				$_SESSION["cart"] = "[]";
			}
			else if ($_POST["act"] == "updatecart") {
				if (isset($_POST["cart"])) {
					$newCart = json_decode($_POST["cart"], true);
					$oldCart = json_decode($_SESSION["cart"], true);
					if ($newCart != null) {
						$error = false;
						$errorcode = 0;
						
						if (count($oldCart) != count($newCart)) {
							$error = true;
							$errorcode = "Giỏ hàng cũ vã mới không khớp!";
						}
						else {
							foreach ($newCart as $nc) {
								if (!ctype_digit($nc["quantity"])) {
									$error = true;
									$errorcode = "Phải là số!";
									break;
								}
								if ($nc["quantity"] < 1) {
									$error = true;
									$errorcode = "Số lượng phải > 0!";
									break;
								}
								else {
									$db->SetTable("#_khohang");
									$db->SetWhere("idsanpham", "=", $nc["idsanpham"]);
									$db->SetWhere("trangthai", "=", 1);
									$quantity = reset($db->Select("count(idsanpham) as totalquantity"))["totalquantity"];
									$quantity = $quantity == null ? 0 : $quantity;
									
									if ($nc["quantity"] > $quantity) {
										$error = true;
										
										$db->SetTable("#_sanpham");
										$db->SetWhere("id", "=", $nc["idsanpham"]);
										$name = reset($db->Select("ten"))["ten"];
										
										$errorcode = "Số lượng " . $name . " còn lại chỉ còn " . $quantity . " sản phẩm!";
										break;
									}
									else {
										foreach ($oldCart as $k=>$oc) {
											if ($oc["idsanpham"] == $nc["idsanpham"]) {
												$oldCart[$k]["quantity"] = $nc["quantity"];
												break;
											}
										}
									}
								}
							}
						}
						
						if (!$error) {
							$_SESSION["cart"] = json_encode($oldCart);
							echo $errorcode;
						}
						else {
							echo $errorcode;
						}
						exit(0);
					}
				}
			}
			else {
				if (isset($_POST["id"])) {
					$id = $_POST["id"];
					
					$cart = array();
						
					if (isset($_SESSION["cart"])) {
						$cart = json_decode($_SESSION["cart"], true);
						if ($cart == null) {
							$cart = array();
						}
					}
					
					if ($_POST["act"] == "remove") {
						foreach ($cart as $k=>$c) {
							if ($c["idsanpham"] == $id) {
								unset($cart[$k]);
								$cart = array_values($cart);
								$_SESSION["cart"] = json_encode($cart);
								break;
							}
						}
					}
					else {
						$db->SetTable("#_khohang");
						$db->SetWhere("idsanpham", "=", $id);
						$db->SetWhere("trangthai", "=", 1);
						$quantity = reset($db->Select("count(idsanpham) as totalquantity"))["totalquantity"];
						$quantity = $quantity == null ? 0 : $quantity;
						
						if ($quantity < 1) {
							echo false;
							exit(0);
						}
						else {
							$isDuplicated = false;
							foreach ($cart as $c) {
								if ($c["idsanpham"] == $id) {
									$isDuplicated = true;
									break;
								}
							}
							
							if (!$isDuplicated) {
								$data["idsanpham"] = $id;
								$data["quantity"] = 1;
								array_push($cart, $data);
								$_SESSION["cart"] = json_encode($cart);
							}
							
							echo true;
							exit(0);
						}
					}
				}
			}
		}
	}
?>