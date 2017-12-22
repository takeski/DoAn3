<?php
	$cat1 = $d->Query("
		select * from #_nhomsp where parentid = 0 
	");
	
	function GetSelectedCat1($id) {
		global $d, $level;
		
		if (isset($_GET["dm1"])) {
			echo $_GET["dm1"] == $id ? "selected='selected'" : "";
		}
		else {			
			if ($_GET["act"] == "edit_cat") {
				if ($level == 2) {
					$qid = reset($d->Query("
						select id from #_nhomsp where id = (
							select parentid from #_nhomsp where id = '" . $_GET["id"] . "'
						)
					"))["id"];
					echo $qid == $id ? "selected='selected'" : "";
				}
				else if ($level == 3) {
					$qid = reset($d->Query("
						select id from #_nhomsp where id = (
							select parentid from #_nhomsp where id = (
								select parentid from #_nhomsp where id = '" . $_GET["id"] . "'
							)
						)
					"))["id"];
					echo $qid == $id ? "selected='selected'" : "";
				}
			}
		}
	}
	
	function GetSelectedCat2() {
		global $d, $level;
		
		if (isset($_GET["dm2"])) {
			echo $_GET["dm2"];
		}
		else {
			if ($_GET["act"] == "edit_cat") {
				if ($level == 3) {
					$id = reset($d->Query("
						select id from #_nhomsp where id = (
							select parentid from #_nhomsp where id = '" . $_GET["id"] . "'
						)
					"))["id"];
					echo $id;
				}
			}
		}
	}
?>
<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=danhmuc&act=man_cat&level=<?=$_GET['level'];?>"><span>Quản lý danh mục</span></a></li>
			<li class="current"><a href="#" onclick="return false;"><?= ($_GET["act"] == "edit_cat") ? "Sửa danh mục" : "Thêm danh mục" ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">		
	function TreeFilterChanged2(){		
				$('#validate').submit();		
	}	
	
	function GetCats(){
		var selCat1 = document.getElementById("selCat1");
		var selCat2 = document.getElementById("selCat2");
		var id = selCat1.options[selCat1.selectedIndex].value;
		
		$.ajax({
			url: "<?=CUR_PATH?>/ajax/ajax_danhmuc.php",
			type: "POST",
			data: { "id" : id },
			success: function(result) {
				selCat2.options.length = 0;
				
				option = document.createElement('option');
				option.value = "";
				option.text = "Chọn danh mục cấp 2";
				selCat2.add(option);
				
				var cats = JSON.parse(result);
				for (var i = 0; i < cats.length; i++) {								
					option = document.createElement('option');
					option.value = cats[i]["id"];
					option.text = cats[i]["name"];
					if (cats[i]["id"] == "<?php GetSelectedCat2(); ?>") {
						option.selected = true;
					}
					selCat2.add(option);
				}
			}
		});
	}
</script>
<form name="supplier" id="validate" class="form" action="<?=CUR_PATH?>?com=danhmuc&act=save_cat" method="post" enctype="multipart/form-data">
	<div class="widget">
		<div class="title"><img src="<?=CUR_PATH?>/images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6><?= ($_GET["act"] == "edit_cat") ? "Sửa danh mục" : "Thêm danh mục" ?></h6>
		</div>
		<?php if ($level == 2 || $level == 3) { ?>
			<div class="formRow">
				<label>Chọn danh mục cấp 1:</label>
				<div class="formRight">
					<select id="selCat1" name="selCat1" style="height: 100%; min-width: 150px;" onchange="GetCats();">
						<?php 
							foreach ($cat1 as $c) { ?>
								<option value="<?=$c["id"]?>" <?php GetSelectedCat1($c["id"]); ?>><?=$c["ten"]?></option>
							<?php }
						?>
					</select>
				</div>
				<div class="clear"></div>
			</div>
		<?php } ?>		
	
		<script>
			if ("<?php echo $level; ?>" == 3) {
				GetCats();
			}
		</script>
		<div class="formRow">
			<label>Tên:</label>
			<div class="formRight">
                <input type="text" name="name" title="Nhập text" id="name"  value="<?=@$item['ten']?>" />
			</div>
			<div class="clear"></div>
		</div>
        <div class="formRow">
          <label>Tùy chọn: <img src="<?=CUR_PATH?>/images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Check vào những tùy chọn "> </label>
          <div class="formRight">           
            <input type="checkbox" name="active" id="check1" value="1" <?=(!isset($item['anhien']) || $item['anhien']==1)?'checked="checked"':''?> />
            <label for="check1">Hiển thị</label>           
          </div>
          <div class="clear"></div>
        </div>

		<div class="formRow">
			<div class="formRight">
				<input type="hidden" name="level" value="<?=$_GET["level"]?>" />
                <input type="hidden" name="id" id="id_this_photo" value="<?=@$item['id']?>" />
            	<input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
            	<a href="<?=CUR_PATH?>?com=danhmuc&act=man_cat&level=<?=$_GET['level'];?>" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>
		
	</div>

</form>   
