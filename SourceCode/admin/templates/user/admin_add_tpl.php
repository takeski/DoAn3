<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	            <li><a href="<?=CUR_PATH?>?com=setting&act=capnhat"><span>Thông tin tài khoản</span></a></li>
                                    <li class="current"><a href="#" onclick="return false;">Cập nhật thông tin</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">		
	function TreeFilterChanged2(){		
				$('#validate').submit();		
	}
</script>
<form name="supplier" id="validate" class="form" action="<?=CUR_PATH?>?com=user&act=admin_edit" method="post" enctype="multipart/form-data">	        
    <div class="widget">
		<div class="title"><img src="<?=CUR_PATH?>/images/icons/dark/pencil.png" alt="" class="titleIcon" />
			<h6>Thông tin tài khoản</h6>
		</div>			
		<div class="formRow">
			<label>Tên đăng nhập:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['tentaikhoan']?>" name="username" title="Tên đăng nhập quản trị" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
        <div class="formRow">
			<label>Mật khẩu:</label>
			<div class="formRight">
				<input type="password" value="" name="password" title="Nhập mật khẩu" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<label>Họ tên:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['hoten']?>" name="fullname" title="Nhập họ tên của bạn" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
        
        <div class="formRow">
			<label>Email:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['email']?>" name="email" title="Nhập email của bạn" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
        
        <div class="formRow">
			<label>Điện thoại</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['sdt']?>" name="phonenumber" title="Nhập điện thoại của bạn" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<label>&nbsp;</label>
			<div class="formRight">
				<?php if (isset($_SESSION["result"])) echo $_SESSION["result"]; unset($_SESSION["result"]); ?>
			</div>
			<div class="clear"></div>
		</div>
		
		
        <div class="formRow">
			<div class="formRight">
               <input type="hidden" name="id" id="id" value="<?=@$item['id']?>" />
            	<input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
			</div>
			<div class="clear"></div>
		</div> 			
	</div>
    
      
</form>   