
<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=slides&act=man_slides<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Slider</span></a></li>
            <li class="current"><a href="#" onclick="return false;"><?= isset($_GET["id"]) ? "Sửa hình ảnh" : "Thêm hình ảnh" ?></a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">		
	function TreeFilterChanged2(){		
				$('#validate').submit();		
	}	
</script>
<form name="supplier" id="validate" class="form" action="<?=CUR_PATH?>?com=slides&act=save_slide<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" method="post" enctype="multipart/form-data">
	<div class="widget">
				
		
        <?php// for($i=0; $i<1; $i++){?>
        <div class="title"><img src="<?=CUR_PATH?>/images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6><?= isset($_GET["id"]) ? "Sửa hình ảnh" : "Thêm hình ảnh" ?></h6>
		</div>
		<div class="formRow">
			<label>Tên:</label>
			<div class="formRight">
                <input type="text" name="name" title="Nhập tên hình ảnh" id="name" class="tipS validate[required]" value="<?=$item["ten"]?>" />
			</div>
			<div class="clear"></div>
		</div>	
		
        <div class="formRow">
			<label>Link:</label>
			<div class="formRight">
                <input type="text" name="link" title="Nhập link hình ảnh" id="link" class="tipS validate[required]" value="<?=$item["duongdan"]?>" />
			</div>
			<div class="clear"></div>
		</div>	
        
		<div class="formRow">
			<label>Tải hình ảnh:</label>
			<div class="formRight">
            					<input type="file" id="file" name="file" />
				<img src="<?=CUR_PATH?>/images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
                <span class="note">width : 1345<?php //echo _width_thumb*$ratio_;?>px  - Height : 490<?php //echo _height_thumb*$ratio_;?>px</span>
			</div>
			<div class="clear"></div>
		</div>
		
		<div class="formRow lang_hidden lang_vi active">
		  <label>Hình hiện tại:</label>
		  <div class="formRight">
		   <div class="mt10"><img  src="/<?=$item['hinh']?>"  alt="NO PHOTO" width="100" /> </div>
			  <input type="text" name="imgHientai" style="display:none;" value="<?= $item['hinh'] ?>" />
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
        <div class="formRow">
            <label>Số thứ tự: </label>
            <div class="formRight">
                <input type="text" class="tipS" value="<?=$item["stt"]?>" name="stt" style="width:20px; text-align:center;" onkeypress="return OnlyNumber(event)" original-title="Số thứ tự của hình ảnh, chỉ nhập số">
            </div>
            <div class="clear"></div>
        </div>
		<?php// } ?>
	<div class="formRow">
			<div class="formRight">
            	<input type="hidden" name="id" id="id_this_type" value="<?=$_REQUEST['id']?>" />
            	<input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
			</div>
			<div class="clear"></div>
		</div>	
	</div>
   
	
</form>   