<style>
  p{
    font-weight:700;
  }
</style>
<?php

  require_once("libraries/dbhelper.php");
  $db = new DBHelper();
	$payment = "tienmat";
	$fullname = "";
	$phonenumber = "";
	$email = "";
	$address = "";
	$content = "";
	$error = "";
  $account = json_decode($_SESSION['account'],true); 
  $infoaccount = $db->Query("SELECT * FROM tb_taikhoan WHERE id='". $account['id']."'");

// 	if (isset($_SESSION["cartinfo"])) {
// 		$data = json_decode($_SESSION["cartinfo"], true);		
// 		$payment = $data["payment"];
// 		$fullname = $data["fullname"];
// 		$phonenumber = $data["phonenumber"];
// 		$email = $data["email"];
// 		$address = $data["address"];
// 		$content = $data["content"];
// 		$error = $data["error"];
// 		unset($_SESSION["cartinfo"]);
// 	}
// ?>

	<h2 style="text-align: center; text-transform: uppercase; font-weight: bold; color: red;">Giỏ hàng</h2>
	<p style="text-align: center; font-weight: bold; color: red;">Lưu ý: Trường có (*) là trường bắt buộc</p>
			
	<div class="col-sm-2"></div>
	<div class="col-sm-8 table-responsive">
		<?php
			if (count($cart) == 0) { ?>
				<div style="text-align: center;">
					<p>Hiện chưa có sản phẩm nào trong giỏ hàng ...</p>
					<a href="<?=WEB_ROOT?>" style="text-decoration: none;"><i class="fa fa-hand-o-right" aria-hidden="true"></i>Tiếp tục mua hàng</a>
				</div>
			<?php }
			else { ?>
				<form method="POST" action="<?=WEB_ROOT?>functions/done.php">
					<div class="row">
						<h3 style="text-align: center; text-transform: uppercase; font-weight: bold;">Thông tin người nhận</h3>
					</div>
					<div class="row info">
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-12">
									<p>Chọn hình thức thanh toán :</p>
									<select name="selPayment" class="form-control">
										<option value="tienmat" <?=$payment == "tienmat" ? "selected='selected'" : ""?>>Thanh toán tại nhà</option>
										<option value="baokim" <?=$payment == "baokim" ? "selected='selected'" : ""?>>Thanh toán qua Bảo Kim</option>
									</select>
								</div>
							</div>
              				<br />
							<div class="row">
								<div class="col-sm-6">
									<p>Họ tên người nhận: </p><input class="form-control" type="text" name="fullname" placeholder="Nhập họ tên người nhận" value="<?= reset($infoaccount)['hoten']?>" />
								</div>
								<div class="col-sm-6">
									<p>Số điện thoại: <b style="color:red">(*)</b></p><input class="form-control" type="text" name="phonenumber" placeholder="Nhập số điện thoại" value="<?= reset($infoaccount)['sdt']?>" required="required" />
								</div>
							</div>
              				<br />
							<div class="row">
								<div class="col-sm-6">
									<p>Địa chỉ: <b style="color:red">(*)</b></p><input class="form-control" type="text" name="address" placeholder="Nhập địa chỉ người nhận" value="<?= reset($infoaccount)['diachi']?>" required="required" />
								</div>
								<div class="col-sm-6">
									<p>Email: </p><input class="form-control" type="email" name="email" placeholder="Nhập email" value="<?= reset($infoaccount)['email']?>"  />
								</div>
							</div>
              				<br />
							<div class="row">
								<div class="col-sm-12">
								<p>Nội dung nhắn gửi:</p>
								<textarea name="content" class="form-control" rows="7" placeholder="Nhập lời nhắn của bạn cho đơn hàng này tại đây!"><?=$content?></textarea>
								</div>
							</div>

						</div>		
					</div>
          			<br />
					<table class="table table-hover table-bordered">
						<thead>
							<tr>
								<th>Sản phẩm</th>
								<th>Tên sản phẩm</th>
								<th>Số lượng</th>
								<th>Hiện có</th>
								<th>Đơn giá</th>
								<th>Giá tiền</th>
								<th>Xóa</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$totalMoney = 0;
								foreach ($lstProductsInCart as $product) { 
									$quantity = $controller->GetCartQuantity($product["id"]);
									$curProductMoney = $product["gia"] * $quantity; ?>
									<tr>
										<td class="col-sm-2"><input type="hidden" class="pid" value="<?=$product["id"]?>" /><img class="img-responsive" src="<?=WEB_ROOT . $product["hinh"]?>" /></td>
										<td class="col-sm-3"><a href="<?=WEB_ROOT?>chi-tiet-san-pham/<?=$product["duongdan"]?>" style="text-decoration: none;"><?=$product["ten"]?></a></td>
										<td class="col-sm-1"><input class="form-control quantity" type="text" value="<?=$quantity?>" style="text-align: center;" /></td>
										<td class="col-sm-1"><?=$controller->GetCurrentProductQuantity($product["id"])?></td>
										<td class="col-sm-2"><b style="color: red;"><?=number_format($product["gia"])?> VNĐ</b></td>
										<td class="col-sm-2"><b style="color: red;"><?=number_format($curProductMoney)?> VNĐ</b></td>
										<td class="col-sm-1"><button class="btn btn-danger" onclick="RemoveFromCart(<?=$product["id"]?>);"> <i class="fa fa-trash-o" aria-hidden="true"></i></button></td>
									</tr>
								<?php }
							?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="7" style="text-align: center;">Tổng tiền: <span style="color: red;"><?=number_format($total)?> VNĐ</span></td>
							</tr>
							<tr>
								<td colspan="7">
									<div class="row">
										<div class="col-sm-12">
											<p style="text-align: center; font-weight: bold; color: red; font-size: 14px;">Lưu ý: Nếu có thay đổi số lượng thì phải cập nhật giỏ hàng trước khi nhấn đặt hàng!</p>
										</div>
									</div>
									<div class="row">
										<div class="col-sm-4" align="center"><button type="button" class="btn btn-danger" onclick="ClearCart();" style="min-width: 150px;">Xóa giỏ hàng</button></div>
										<div class="col-sm-4" align="center"><button type="button" class="btn btn-warning" onclick="UpdateCart();" style="min-width: 150px;">Cập nhật giỏ hàng</button></div>
										<div class="col-sm-4" align="center"><button type="submit" class="btn btn-primary" style="min-width: 150px;">Đặt hàng</button></div>
									</div>
								</td>
							</tr>
						</tfoot>
					</table>

				</form>
			<?php } ?>
	</div>
	<div class="col-sm-2"></div>

<script>
	function ClearCart() {
		$.ajax({
			url: "<?=WEB_ROOT?>functions/cart.php",
			method: "POST",
			data: { "act" : "clearcart" },
			success: function(result) {
				location.reload();
			}
		});
	}
	
	function UpdateCart() {
		var pids = document.getElementsByClassName("pid");
		var pquantities = document.getElementsByClassName("quantity");
		
		if (pids.length != pquantities.length) {
			location.reload();
		}
		else {
			var cart = [];
			for (var i = 0; i < pids.length; i++) {
				var data = {};
				data["idsanpham"] = pids[i].value;
				if (pquantities[i].value <= 0) {
					alert("Số lượng sản phẩm không được nhỏ hơn 1");
					return;
				}
				data["quantity"] = pquantities[i].value;
				cart.push(data);
			}
			
			$.ajax({
				url: "<?=WEB_ROOT?>functions/cart.php",
				method: "POST",
				data: { "act" : "updatecart", "cart" : JSON.stringify(cart) },
				success: function(result) {
					if (result == 0) {
							location.reload();
					}
					else {
						alert(result);
					}
				}
			});
		}
	}

	function RemoveFromCart(id) {
		$.ajax({
			url: "<?=WEB_ROOT?>functions/cart.php",
			method: "POST",
			data: { "id" : id, "act" : "remove" },
			success: function(result) {
				location.reload();
			}
		});
	}
</script>