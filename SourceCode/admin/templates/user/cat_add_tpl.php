<?php
	$d->SetTable("#_managementobjects");
	$managementobjects = $d->Select();

	function ActiveCheckbox($json, $act) {
		$per = json_decode($json, true);
		
		switch ($act) {
			case "r":
				if ($per[0]) echo "checked='checked'";
				break;
			case "c":
				if ($per[1]) echo "checked='checked'";
				break;
			case "u":
				if ($per[2]) echo "checked='checked'";
				break;
			case "d":
				if ($per[3]) echo "checked='checked'";
				break;
			default: break;
		}
	}
?>

<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=user&act=man_cat<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Quản lý nhóm quản trị</span></a></li>
            <li class="current"><a href="#" onclick="return false;"><?=isset($_GET["id"]) ? "Sửa nhóm" : "Thêm nhóm"?></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<style>
	.formRow .formRight {
	    width: 75%;
		margin-right: 20px;
	}
	
	.formRight div {
		display: inline-block;
		width: 20%;
		margin-top: 4px;
	}
	
	.formRight div .checker {
		margin: 0px;
	}
</style>
<form name="frm"  class="form"  method="post" action="<?=CUR_PATH?>?com=user&act=save_cat" enctype="multipart/form-data" class="nhaplieu" onSubmit="return js_submit();">
<div class="widget">
	<div class="formRow">
		<label>Tên nhóm:</label>
		<div class="formRight">
        	<input type="text" name="name" id="name" value="<?=reset($items)['groupname']?>" class="input" />
		</div>
		<div class="clear"></div>
	</div>
	
	<?php
		$i = 0;
		foreach ($managementobjects as $mo) { ?>
			<div class="formRow">
				<label><input type="checkbox" class="chk<?=$mo["id"]?>" onchange="CheckAllInLine('chk<?=$mo["id"]?>');" /> <?=$mo["name"]?>:</label>
				<div class="formRight">
					<div><input type="checkbox" class="chk<?=$mo["id"]?>" name="r<?=$mo["id"]?>" <?php ActiveCheckbox($items[$i]["accessgrant"], "r"); ?> /> Xem</div>
					<div><input type="checkbox" class="chk<?=$mo["id"]?>" name="c<?=$mo["id"]?>" <?php ActiveCheckbox($items[$i]["accessgrant"], "c"); ?> /> Thêm</div>
					<div><input type="checkbox" class="chk<?=$mo["id"]?>" name="u<?=$mo["id"]?>" <?php ActiveCheckbox($items[$i]["accessgrant"], "u"); ?> /> Sửa</div>
					<div><input type="checkbox" class="chk<?=$mo["id"]?>" name="d<?=$mo["id"]?>" <?php ActiveCheckbox($items[$i]["accessgrant"], "d"); ?> /> Xóa</div>
				</div>
				<div class="clear"></div>
			</div>
		<?php 
			++$i;
		}
	?>
	<script>
		function CheckAllInLine(cls) {
			var chks = document.getElementsByClassName(cls);
			
			for (var i = 1; i < chks.length; i++) {
				chks[i].checked = chks[0].checked;
			}
		}
	</script>
	<div class="formRow">
	<label>&nbsp;</label>
	<div class="formRight">
		<?php 
			if (isset($_GET["id"])) { ?>
				<input type="hidden" name="id" id="id" value="<?=reset($items)["groupid"]?>" />
			<?php }
		?>
		<input type="submit" value="Lưu"  class="button blueB" />
		<input type="button" value="Thoát" onclick="javascript:window.location='<?=CUR_PATH?>?com=user&act=man_cat'" class="button blueB" />
	</div>
	<div class="clear"></div>
	</div>
</div>
</form>
</div>