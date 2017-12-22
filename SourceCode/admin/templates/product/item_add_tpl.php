<?php 
	require_once(dirname(__FILE__) . "/../../../libraries/dbhelper.php");
	$db = new DBHelper();	
	function GetQuantity($id) {
		global $db;
		
		$db->SetTable("#_khohang");
		$db->SetWhere("idsanpham", "=", $id);	
		$db->SetWhere("trangthai", "=", 1);
		return reset($db->Select("count(idsanpham) as soluong"))["soluong"];
	}
?>

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=product&act=man<?php echo GetParamsDm(); ?>"><span>Danh sách sản phẩm</span></a></li>
            <li class="current"><a href="#" onclick="return false;"><?= isset($_GET["id"]) ? "Sửa sản phẩm" : "Thêm sản phẩm" ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">		
	function TreeFilterChanged2(){		
				$('#validate').submit();		
	}
		
	function GetCat(lv) {
		var selCat = document.getElementById("selCat" + lv);
		var id = selCat.options[selCat.selectedIndex].value;
		
		var dm1 = "";
		var dm2 = "";
		var dm3 = "";
		
		dm1 = <?php echo (isset($dm1) && $dm1 != "") ? "'&dm1=" . $dm1 . "'" : "''" ?>;
		dm2 = <?php echo (isset($dm2) && $dm2 != "") ? "'&dm2=" . $dm2 . "'" : "''" ?>;
		dm3 = <?php echo (isset($dm3) && $dm3 != "") ? "'&dm3=" . $dm3 . "'" : "''" ?>;
		
		if (dm1 == "" && "<?php echo isset($_GET["dm1"]) ? $_GET["dm1"] : ""; ?>" != "") {
			dm1 = "&dm1=" + "<?=$_GET["dm1"]?>";
		}
		
		if (dm2 == "" && "<?php echo isset($_GET["dm2"]) ? $_GET["dm2"] : ""; ?>" != "") {
			dm2 = "&dm2=" + "<?=$_GET["dm2"]?>";
		}
		
		if (lv == 1) {
			if (id != "") {
				dm1 = "&dm1=" + id;
			}
			else {
				dm1 = "";
			}
			dm2 = "";
			dm3 = "";
		}
		if (lv == 2) {
			if (id != "") {
				dm2 = "&dm2=" + id;
			}
			else {
				dm2 = "";
			}
			dm3 = "";
		}
		if (lv == 3) {
			if (id != "") {
				dm3 = "&dm3=" + id;
			}
			else {
				dm3 = "";
			}
		}
		
		window.location = "<?=CUR_PATH?>?com=<?=$_GET["com"]?>&act=<?=$_GET["act"]?>&customselect=1" + dm1 + dm2 + dm3 + "<?= isset($_GET["id"]) && ($_GET["id"] != "") ? "&id=" . $_GET["id"] : "" ?>";
	}
	
	function DelImage(id, img) {
		$.ajax({
			url: "<?=CUR_PATH?>/ajax/delete_images.php",
			type: "POST",
			data: { "id" : id, "delimg" : img },
			success: function(result) {
				return;
			}
		});
	}
</script>
<form name="supplier" id="validate" class="form" action="<?=CUR_PATH?>?com=product&act=save<?php echo GetParamsDm(); ?>" method="post" enctype="multipart/form-data">
	<div class="widget">	
        <?php// for($i=0; $i<1; $i++){?>
        <div class="title"><img src="<?=CUR_PATH?>/images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6><?= isset($_GET["id"]) ? "Sửa sản phẩm" : "Thêm sản phẩm" ?></h6>
		</div>
		<div class="formRow">
			<label>Chọn nhà sản xuất:</label>
			<div class="formRight">
                <?php
					$cat1 = $d->Query("
						select * from #_nhomsp where parentid = 0 
					");
				?>
				<select style="height: 30px;" id="selCat1" name="selCat1" onchange="GetCat('1');">
					<?php
						foreach ($cat1 as $c) { ?>
							<option value="<?=$c["id"]?>" <?php echo ($_GET["dm1"] == $c["id"]) || ($dm1 == $c["id"]) ? "selected='selected'" : ""; ?>><?=$c["ten"]?></option>
						<?php }
					?>
				</select>
			</div>
			<div class="clear"></div>
		</div>	
		<div class="formRow">
			<label>Chọn nhóm sản phẩm:</label>
			<div class="formRight">
                <?php
					$cat2 = array();
					if (isset($_GET["dm1"]) || $dm1 != "") {
						$dm1 = isset($_GET["dm1"]) ? $_GET["dm1"] : $dm1;
										
						$cat2 = $d->Query("
							select * from #_nhomsp where parentid = '" . $dm1 . "' 
						"); 
					}
				?>				
				<select style="height: 30px;" id="selCat2" name="selCat2" onchange="GetCat('2');">
					<option value="">Chọn nhóm sản phẩm</option>
				<?php foreach ($cat2 as $c) { ?>
					<option value="<?=$c["id"]?>" <?php echo ($_GET["dm2"] == $c["id"]) || ($dm2 == $c["id"]) ? "selected='selected'" : ""; ?>><?=$c["ten"]?></option>
				<?php } ?>
				</select>
			</div>
			<div class="clear"></div>
		</div>	
	
		<div class="formRow">
			<label>Tên:</label>
			<div class="formRight">
                <input type="text" name="name" title="Nhập tên" id="name" class="tipS validate[required]" value="<?=$item["ten"]?>" />
			</div>
			<div class="clear"></div>
		</div>	
		<div class="formRow">
			<label>Giá:</label>
			<div class="formRight">
                <input type="text" name="price" title="Nhập giá" id="name" value="<?=$item["gia"]?>" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Số sp còn trong kho: </label>
			<div class="formRight">
                <span class="note" style="font-size: 15px;"><?= number_format(GetQuantity($item["id"]))?></span>
			</div>
			<div class="clear"></div>
		</div>	

		<div class="formRow ">
			<label>Thêm sản phẩm: </label>
			<div class="formRight">
				<textarea rows="4" class="tipS" name="lstSerials" placeholder="Nhập serial của sản phẩm (mỗi serial 1 dòng )"></textarea>
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Tải hình ảnh:</label>
			<div class="formRight">
            	<input type="file" id="file" name="file" />
				<img src="<?=CUR_PATH?>/images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
                <span class="note">Width : 600px  - Height : 700px</span>
			</div>
			<div class="clear"></div>
		</div>
		
		<?php if($_GET['act']=="edit"){?>
			<div class="formRow lang_hidden lang_vi active">
			<label>Hình hiện tại:</label>
			<div class="formRight">
			<div class="mt10"><img  src="<?= WEB_ROOT . $item['hinh']?>"  alt="NO PHOTO" width="100" /> </div>
				<input type="text" name="imgHientai" style="display:none;" value="<?= $item['hinh'] ?>" />
			</div>
			<div class="clear"></div>
			</div>
		<?php }?>
		
		<!--<div class="formRow">
			<label>Tải hình ảnh liên quan:</label>
			<div class="formRight">
				<input type="file" id="multifile" name="multifile[]" accept="image/*"multiple="multiple" />
				<img src="<?=CUR_PATH?>/images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
                <span class="note">Width : 400<?php //echo _width_thumb*$ratio_;?>px  - Height : 400<?php //echo _height_thumb*$ratio_;?>px</span>
			</div>
			<div class="clear"></div>
		</div>

        <div class="formRow">
			<label>Những hình hiện tại:</label>
			<div class="formRight">
				<?php
					$d->SetTable("#_sanpham");
					$d->SetWhere("id", "=", $item["id"]);
					$subimages = json_decode(reset($d->Select())["subimages"], true);
					
					if (count($subimages) != 0) {
						$i = 1;
						foreach ($subimages as $img) { 
				?>
						<div id="r<?=$i?>" style="float: left; width: 25%; margin: 5px 0px;">
							<div style="text-align: center; vertical-align: middle;">
								<img style="margin: 5px 0px; width: 150px; height: 150px;" src="<?=WEB_ROOT . $img?>" />
								<input type="text" name="curImg[]" style="display: none" value="<?=$img?>">
							</div>
							<div style="text-align: center;">
								<input type="button" class="redB" onclick="DelImage('<?=$item["id"]?>', '<?=$img?>'); document.getElementById('r<?=$i?>').innerHTML = '';" value="Xóa" />
							</div>
						</div>
							
				<?php 
							++$i; 
						} 
					}
				?>
			</div>
			<div class="clear"></div>
		</div>-->
		
		<div class="formRow">
          <label>Tùy chọn: <img src="<?=CUR_PATH?>/images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Check vào những tùy chọn "> </label>
          <div class="formRight">           
            <input type="checkbox" name="highlight" value="1" id="check1" <?php echo $item["noibat"] == 1 ? "checked='checked'" : ""; ?> />
            <label for="check1">Nổi bật</label>           
          </div>
          <div class="clear"></div>
        </div>
        <div class="formRow">
          <label>Tùy chọn: <img src="<?=CUR_PATH?>/images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Check vào những tùy chọn "> </label>
          <div class="formRight">           
            <input type="checkbox" name="active" value="1" id="check1" <?php echo $item["anhien"] == 1 ? "checked='checked'" : ""; ?> />
            <label for="check1">Hiển thị</label>           
          </div>
          <div class="clear"></div>
        </div>
		
		<div class="formRow ">
			<label>Nội dung tóm tắt</label>
			<div class="formRight">
                <textarea rows="4" cols="" class="tipS" name="summary" original-title="Nhập mô tả . "><?= $item['ndtomtat']?></textarea>
			</div>
			<div class="clear"></div>
		</div>


		<div class="formRow">
			<label>Chi tiết:</label>
			<div class="ck_editor">
                <textarea id="noidung_vi" name="detail"><?=$item["noidung"]?></textarea>
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<div class="formRight">
				<input type="hidden" name="level" value="<?=$_GET["level"]?>" />
                <input type="hidden" name="id" id="id_this_photo" value="<?=@$item['id']?>" />
            	<input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
            	<a href="<?=CUR_PATH?>?com=product&act=man" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>

		<?php// } ?>
	</div>
   
	
</form>   
