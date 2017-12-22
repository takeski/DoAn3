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
	});

</script>

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	            <li><a href="<?=CUR_PATH?>?com=setting&act=capnhat"><span>Thiết lập hệ thống</span></a></li>
                                    <li class="current"><a href="#" onclick="return false;">Cấu hình website</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">		
	function TreeFilterChanged2(){		
				$('#validate').submit();		
	}
</script>
<form name="supplier" id="validate" class="form" action="<?=CUR_PATH?>?com=setting&act=save" method="post" enctype="multipart/form-data">
	<div class="widget">
		<div class="formRow">
			<label>Tên công ty:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['ten']?>" name="websiteowner" title="Nhập tên công ty" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>	
		
		<div class="formRow">
			<label>Slogan:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['slogan']?>" name="slogan" title="Nhập slogan" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>	
		
		<div class="formRow">
			<label>Email công ty:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['emailcty']?>" name="email" title="Nhập địa chỉ email công ty" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<label>Email gửi:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['emailgui']?>" name="emailgui" title="Nhập địa chỉ email gửi" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<label>Mật khẩu email gửi:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['matkhauemail']?>" name="emailpassword" title="Nhập password địa chỉ email" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>

		<div class="formRow">
			<label>Số điện thoại:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['sdt']?>" name="phonenumber" title="Nhập số điện thoại" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
        
        <div class="formRow">
			<label>Hotline:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['hotline']?>" name="hotline" title="Nhập số điện thoại" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>

        <div class="formRow lang_hidden lang_vi active">
			<label>Địa chỉ:</label>
			<div class="formRight">
                <input type="text" name="address" title="Nhập địa chỉ công ty" id="address" class="tipS validate[required]" value="<?=@$item['diachi']?>" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Tọa độ bản đồ:</label>
			<div class="formRight">
				<input type="text" value="<?=@$item['location']?>" name="location" title="Nhập tọa độ vị trí công ty" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Website:</label>
			<div class="formRight">
                <input type="text" name="linkwebsite" title="Nhập website công ty" id="linkwebsite" class="tipS validate[required]" value="<?=@$item['linkweb']?>" />
			</div>
			<div class="clear"></div>
		</div>
		  <div class="formRow">
			<div class="formRight">
                <input type="hidden" name="id" id="id_this_setting" value="<?=@$item['id']?>" />
            	<input type="submit" class="blueB"  value="Hoàn tất" />
			</div>
			<div class="clear"></div>
		</div>
	</div>
    
    <!--<div class="widget">
		<div class="title"><img src="<?=CUR_PATH?>/images/icons/dark/record.png" alt="" class="titleIcon" />
			<h6>Nội dung seo</h6>
		</div>			
		
        <div class="formRow">
			<label>Title</label>
			<div class="formRight">
				<input style="height: 30px;width: 888px;padding-left: 10px;" type="text" value="<?=@$item['title']?>" name="title" title="Nội dung thẻ meta Title dùng để SEO" class="tipS" />
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<label>Từ khóa</label>
			<div class="formRight">
				<input type="text" name="keywords" value="<?=@$item['keywords']?>" class="tipS" original-title="Từ khóa chính cho website" style="height: 30px;width: 888px;padding-left: 10px;">
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow">
			<label>Description:</label>
			<div class="formRight">
				<textarea style="height: 100px;width: 888px;padding: 5px 0 0 10px;" rows="8" cols="" title="Nội dung thẻ meta Description dùng để SEO" class="tipS" name="description"><?=@$item['description']?></textarea>
			</div>
			<div class="clear"></div>
		</div>	
		<div class="formRow">
			<label>Analytics: </label>
			<div class="formRight">
				<textarea style="height: 100px;width: 888px;padding: 5px 0 0 10px;" rows="8" cols="" title="Analytics" class="tipS" name="analytics"><?=@$item['analytics']?></textarea>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>V chat:</label>
			<div class="formRight">
				<textarea style="height: 100px;width: 888px;padding: 5px 0 0 10px;" rows="8" cols="" title="V chat" class="tipS" name="vchat"><?=@$item['vchat']?></textarea>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Meta:</label>
			<div class="formRight">
				<textarea style="height: 100px;width: 888px;padding: 5px 0 0 10px;" rows="8" cols="" title="Meta" class="tipS" name="meta"><?=@$item['meta']?></textarea>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Script top:</label>
			<div class="formRight">
				<textarea style="height: 100px;width: 888px;padding: 5px 0 0 10px;" rows="8" cols="" title="Script top" class="tipS" name="scripttop"><?=@$item['scripttop']?></textarea>
			</div>
			<div class="clear"></div>
		</div>
		<div class="formRow">
			<label>Script bottom:</label>
			<div class="formRight">
				<textarea style="height: 100px;width: 888px;padding: 5px 0 0 10px;" rows="8" cols="" title="Script bottom" class="tipS" name="scriptbottom"><?=@$item['scriptbottom']?></textarea>
			</div>
			<div class="clear"></div>
		</div>
       			
	</div>-->
</form>   