
<script type="text/javascript">		

	$(document).ready(function() {
		$('.chonngonngu li a').click(function(event) {
			var lang = $(this).attr('href');
			$('.chonngonngu li a').removeClass('active');
			$(this).addClass('active');
			$('.lang_hidden').removeClass('active');
			$('.lang_'+lang).addClass('active');
			return false;
		});

		$('.update_stt').keyup(function(event) {
			var id = $(this).attr('rel');
			var table = 'baiviet_photo';
			var value = $(this).val();
			$.ajax ({
				type: "POST",
				url: "ajax/update_stt.php",
				data: {id:id,table:table,value:value},
				success: function(result) {
				}
			});
		});

		$('.delete_images').click(function(){
	      if (confirm('Bạn có muốn xóa hình này ko ? ')) {
	        var id = $(this).attr('title');
			var table = 'baiviet_photo';
			var links = "<?=_upload_baiviet;?>";
	        $.ajax ({
	          type: "POST",
	          url: "ajax/delete_images.php",
	          data: {id:id,table:table,links:links},
	          success: function(result) { 
	          }
	        });
	        $(this).parent().slideUp();
	      }
	      return false;
	    });

	    $('.themmoi').click(function(e) {
			$.ajax ({
				type: "POST",
				url: "ajax/khuyenmai.php",
				success: function(result) { 
					$('.load_sp').append(result);
				}
			});
        });

		$('.delete').click(function(e) {
			$(this).parent().remove();
		});
		

	});
	
</script>

<div class="wrapper">

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=<?= $com ?>&act=man<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>khách hàng</span></a></li>
            <li class="current"><a href="#" onclick="return false;"><?=isset($_GET["id"]) ? "Sửa khách hàng" : ""?></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<form name="supplier" id="validate" class="form" action="<?=CUR_PATH?>?com=<?= $com ?>&act=save&id=<?= $item['id']?>" method="post" enctype="multipart/form-data">
	<div class="widget">
    
		
        <div class="formRow le">
			<label>Tên tài khoản</label>
			<div class="formRight">
                <input type="text" name="tentk" title="Nhập tên danh mục" id="ten_vi" class="tipS validate[required]" value="<?=@$item['tentaikhoan']?>" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow le">
			<label>Password</label>
			<div class="formRight">
                <input type="text" name="pw" title="Nhập tên danh mục" id="ten_vi" placeholder="Bỏ trống nếu không muốn đổi password" value="" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow le">
			<label>Email</label>
			<div class="formRight">
                <input type="text" name="email" title="Nhập tên danh mục" id="ten_vi" class="tipS validate[required]" value="<?=@$item['email']?>" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow le">
			<label>Họ tên</label>
			<div class="formRight">
                <input type="text" name="hoten" title="Nhập tên danh mục" id="ten_vi" class="tipS validate[required]" value="<?=@$item['hoten']?>" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow le">
			<label>Số điện thoại</label>
			<div class="formRight">
                <input type="text" name="sdt" title="Nhập tên danh mục" id="ten_vi" class="tipS validate[required]" value="<?=@$item['sdt']?>" />
			</div>
			<div class="clear"></div>
		</div>


		<div class="formRow le">
			<label>Địa chỉ</label>
			<div class="formRight">
                <input type="text" name="dc" title="Nhập tên danh mục" id="ten_vi" class="tipS validate[required]" value="<?=@$item['diachi']?>" />
			</div>
			<div class="clear"></div>
		</div>

        <div class="formRow">
			<div class="formRight">
                <input type="hidden" name="type" id="id_this_type" value="<?=$_REQUEST['type']?>" />
                <input type="hidden" name="id" id="id_this_post" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
            	<a href="<?=CUR_PATH?>?com=client&act=man<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" onClick="if(!confirm('Bạn có muốn thoát không ? ')) return false;" title="" class="button tipS" original-title="Thoát">Thoát</a>
			</div>
			<div class="clear"></div>
		</div>
	</div>  

</form>        
</div>
