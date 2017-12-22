<?php
require_once(dirname(__FILE__) . "/../../../libraries/dbhelper.php");
	$db = new DBHelper();	

	function GetStatus($s) {
		if ($s == "danggiaohang") {
			return "Đang giao hàng";
		}
		else 
		if($s == "dangtrahang") {
			return "Đang trả hàng";
		}
		if ($s == "dagiaohang") {
			return "Đã giao hàng";
		}
		else {
			return "Đã hủy";
		}
	}
	
	
	function GetProduct($id) {
		global $d;
		$d->SetTable("#_sanpham");
		$d->SetWhere("id", "=", $id);
		return reset($d->Select());
	}
?>
<script type="text/javascript">

function TreeFilterChanged2(){		
			$('#validate').submit();		
}
// function update(id){
// 	if(id>0){
// 		var sl=$('#product'+id).val();
// 		if(sl>0){
// 			$('#ajaxloader'+id).css('display', 'block');	
// 			jQuery.ajax({
// 				type: 'POST',
// 				url: "ajax.php?do=cart&act=update",
// 				data: {'id':id, 'sl':sl},				
// 				success: function(data) {					
// 					$('#ajaxloader'+id).css('display', 'none');	
// 					var getData = $.parseJSON(data);
// 					$('#id_price'+id).html(addCommas(getData.thanhtien)+'&nbsp;VNĐ');
// 					$('#sum_price').html(addCommas(getData.tongtien)+'&nbsp;VNĐ');
// 				}
// 			});			
// 		}else alert('Số lượng phải lớn hơn 0');
// 	}
// }

// function del(id){
// 	if(id>0){				
// 		jQuery.ajax({
// 			type: 'POST',
// 			url: "ajax.php?do=cart&act=delete",
// 			data: {'id':id},			
// 			success: function(data) {										
// 					var getData = $.parseJSON(data);
// 					$('#productct'+id).css('display', 'none');	
// 					$('#sum_price').html(addCommas(getData.tongtien)+'&nbsp;VNĐ');
// 				}
// 		});
// 	}
// }
</script>  
<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	            <li><a href="<?=CUR_PATH?>?com=order&act=mam"><span>Đơn hàng</span></a></li>
                                    <li class="current"><a href="#" onclick="return false;">Xem và sửa đơn hàng</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action='<?=CUR_PATH?>?com=orders&act=save&id=<?= @$item['id']?>' method="post" enctype="multipart/form-data">
	<div class="widget">
		<div class="title"><img src="<?=CUR_PATH?>/images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6>Thông tin người mua</h6>
		</div>
		<div class="formRow">
			<label>Mã đơn hàng</label>
			<div name="iddonhang" class="formRight">
               <?=@$item['iddonhang']?>
			</div>
			<div class="clear"></div>
		</div>	
        
        <div class="formRow">
			<label>Họ tên</label>
			<div class="formRight">
              <?=@$item['hoten']?>
			</div>
			<div class="clear"></div>
		</div>	
        
         <div class="formRow">
			<label>Điện thoại</label>
			<div class="formRight">
              <?=@$item['sdt']?>
			</div>
			<div class="clear"></div>
		</div>		        
        
         <div class="formRow">
			<label>Email</label>
			<div class="formRight">
             <?=@$item['email']?>
			</div>
			<div class="clear"></div>
		</div>	
        
        <div class="formRow">
			<label>Địa chỉ</label>
			<div class="formRight">
             <?=@$item['diachi']?>
			</div>
			<div class="clear"></div>
		</div>	       
        
        </div>
		<div class="widget">
		<div class="title"><img src="<?=CUR_PATH?>/images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6>Chi tiết đơn hàng</h6>
		</div>
		
		     
	<table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td class="tb_data_small"><a href="#" class="tipS" style="margin: 5px;">STT</a></td>      
		<td><div>Hình sản phẩm<span></span></div></td>
        <td class="sortCol"><div>Tên sản phẩm<span></span></div></td>
        <td width="150">Đơn giá</td>
        <td width="150">Số lượng</td>
        <td width="150">Thành tiền</td>
      </tr>
    </thead> 
    <tbody>
		<tr>
		<?php
			$i = 1;
			$totalNoFee = 0;

			$db->SetTable("#_chitietdonhang");
			$db->SetWhere("idchitietdonhang", "=", @$item['id']);
			$products = $db->Select();
			
			foreach ($products as $product) {
				$p = GetProduct($product["idsanpham"]);
				if ($i != 1) { ?>
					</tr><tr>
				<?php } ?>
				<td><?=$i?></td>
				<td><img src="<?=WEB_ROOT . $p["hinh"]?>" style="width: 150px; height: 100px;" /></td>
				<td><?=$p["ten"]?></td>
				<td><?=number_format($p["gia"],0, ',', '.')?> VNĐ</td>
				<td><?=$product["soluong"]?></td>
				<?php 
					$total = $p['gia'] * $product['soluong']; 
					$totalNoFee += $total;
				?>
				<td><?=number_format($total,0, ',', '.')?> VNĐ</td>
				<?php ++$i;
			}
		?>
		</tr>
     </tbody>
	 <tfoot>
      <tr>
        <td colspan="7"><div class="pagination">Tổng tiền: <?=number_format($totalNoFee ,0, ',', '.')?> VNĐ</div></td>
      </tr>
    </tfoot>   
  </table>
        </div>
		
		<div class="widget">
		<div class="title"><img src="<?=CUR_PATH?>/images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6>Thông tin thêm</h6>
		</div>
        
		<div class="formRow">
			<label>Nội Dung :</label>
			<div class="formRight">
				<?=$item['noidung']?>
			</div>
			<div class="clear"></div>
		</div>	

		<div class="formRow" style="border:none;">
			<label>Tình trạng:</label>
			<?php
				if ($item["trangthai"] == "danggiaohang"||$item["trangthai"]=="dangtrahang") { ?>
				<div class="formRight">
					<div class="selector">
						<select name="selStatus">
							<option value="danggiaohang">Đang giao hàng</option>
							<option value="dagiaohang">Đã giao hàng</option>
							<option value="dangtrahang">Đang trả hàng</option>
							<option value="dahuy">Đã hủy</option>
						</select>
					</div>
				</div>
				<?php }
				else { ?>
					<span style="margin: 73px;"><?=GetStatus($item["trangthai"])?></span>
				<?php }
			?>
		</div>

        
        <div class="formRow">
			<div class="formRight">	     
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB"  value="Hoàn Tất" />
			</div>
			<div class="clear"></div>
		</div>
		
	</div>
</form>  