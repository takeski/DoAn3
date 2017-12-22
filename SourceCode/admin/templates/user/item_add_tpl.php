<script language="javascript">
function js_submit(){
	if(isEmpty(document.frm.username, "Chưa nhập tên đăng nhập.")){
		document.frm.username.focus();
		return false;
	}
	<?php if($_GET['act']=='add'){?>
	if(isEmpty(document.frm.oldpassword, "Chưa nhập mật khẩu.")){
		document.frm.oldpassword.focus();
		return false;
	}
	
	if(document.frm.oldpassword.value.length<5){
		alert("Mật khẩu phải nhiều hơn 4 ký tự.");
		document.frm.oldpassword.focus();
		return false;
	}
	<?php } ?>
	if(!isEmpty(document.frm.email) && !check_email(document.frm.email.value)){
		alert('Email không hợp lệ.');
		document.frm.email.focus();
		return false;
	}
}
</script>

<?php
	$d->SetTable("#_groups");
	$groups = $d->Select();
?>

<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=user&act=man<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Quản lý thành viên</span></a></li>
            <li class="current"><a href="#" onclick="return false;"><?=isset($_GET["id"]) ? "Sửa thành viên" : "Thêm thành viên"?></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="frm"  class="form"  method="post" action="<?=CUR_PATH?>?com=user&act=save" enctype="multipart/form-data" class="nhaplieu" onSubmit="return js_submit();">
<div class="widget">
	<div class="formRow">
		<label>Tên đăng nhập :</label>
		<div class="formRight">
        	<input type="text" name="username" id="username" value="<?=$item['username']?>" class="input" <?php if($_GET['act']=='edit'){?> readonly="readonly"<?php } ?>  />
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow">
		<label>Mật khẩu :</label>
		<div class="formRight">
        	<input type="password" name="password" id="password" value="" class="input" />
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow">
		<label>Email :</label>
		<div class="formRight">
        	<input type="text" name="email" id="email" value="<?=$item['email']?>" class="input" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="formRow">
		<label>Họ tên :</label>
		<div class="formRight">
        	<input type="text" name="fullname" id="fullname" value="<?=$item['fullname']?>" class="input" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="formRow">
		<label>Điện thoại :</label>
		<div class="formRight">
        	<input type="text" name="phonenumber" value="<?=$item['phonenumber']?>" class="input" />
		</div>
		<div class="clear"></div>
	</div>
	<div class="formRow">
		<label>Địa chỉ :</label>
		<div class="formRight">
        	<input type="text" name="address" id="address" value="<?=$item['address']?>" class="input" />
		</div>
		<div class="clear"></div>
	</div>

	<div class="formRow">
		<label>Quyền Quản trị:</label>
		<div class="formRight">
        	<select id="selGroup" name="selGroup">
				<option value="0">Thành viên</option>
				<?php
					foreach ($groups as $group) { ?>
						<option value="<?=$group["id"]?>" <?php echo $group["id"] == $item["groupid"] ? "selected='selected'" : "";?>><?=$group["name"]?></option>
					<?php }
				?>
			</select>
		</div>
		<div class="clear"></div>
	</div>
	
	<?php 	
		$error = isset($_SESSION["error"]) ? $_SESSION["error"] : ""; 
		unset($_SESSION["error"]);
		if ($error != "") { ?>
			<div class="formRow" <?php ?>>
				<label>&nbsp;</label>
				<div class="formRight">
					<?=$error?>
				</div>
				<div class="clear"></div>
			</div>
		<?php }
	?>

	<div class="formRow">
	<label></label>
	<div class="formRight">
		<input type="hidden" name="id" id="id" value="<?=@$item['id']?>" />
		<input type="submit" value="Lưu"  class="button blueB" />
		<input type="button" value="Thoát" onclick="javascript:window.location='<?=CUR_PATH?>?com=user&act=man'" class="button blueB" />
	</div>
	<div class="clear"></div>
	</div>
</div>
</form>
</div>