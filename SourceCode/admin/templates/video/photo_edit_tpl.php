<?php
   /* $d->reset();
    $sql="select id,ten_vi from table_product_list where anhien_slider =1 order by STT,id desc";
    $d->query($sql);
    $result_list=$d->result_array();*/
?>
<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	            <li><a href="<?=CUR_PATH?>?com=video&act=man_photo"><span>Videos</span></a></li>
                                    <li class="current"><a href="#" onclick="return false;">Sửa hình ảnh</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script type="text/javascript">		
	function TreeFilterChanged2(){		
				$('#validate').submit();		
	}
</script>
<form name="supplier" id="validate" class="form" action="<?=CUR_PATH?>?com=video&act=save_photo<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" method="post" enctype="multipart/form-data">
	<div class="widget">
		<div class="title"><img src="<?=CUR_PATH?>/images/icons/dark/list.png" alt="" class="titleIcon" />
			<h6>Sửa video</h6>
		</div>		
        <?php if($config_list=='true'){ ?>
        <div class="formRow">
            <label>Chọn danh mục 1</label>
            <div class="formRight">
                <select id="id_list" name="id_list" class="main_select">
                    <option>Chọn danh mục</option>
                    <?php for ($i=0; $i < count($result_list) ; $i++) { ?>
                    <option value="<?=$result_list[$i]['id']?>" <?php if($result_list[$i]['id']==$item['id_list']) echo 'selected'; ?>><?=$result_list[$i]['ten']?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="clear"></div>
        </div>
        <?php } ?>
		<div class="formRow">
			<label>Tên</label>
			<div class="formRight">
                <input type="text" name="name" title="Nhập tên hình ảnh" id="name" class="tipS validate[required]" value="<?=@$item['name']?>" />
			</div>
			<div class="clear"></div>
		</div>

        <div class="formRow">
            <label>Liên kết: </label>
            <div class="formRight">
                <input type="text" id="price" name="link" value="<?=@$item['link']?>"  title="Nhập liên kết cho hình ảnh với id của youtube" class="tipS" />
            </div>
            <div class="clear"></div>
        </div>          
		<div class="formRow">
			<label>Tải hình ảnh:</label>
			<div class="formRight">
            					<input type="file" id="file" name="file" />
				<img src="<?=CUR_PATH?>/images/question-button.png" alt="Upload hình" class="icon_question tipS" original-title="Tải hình ảnh (ảnh JPEG, GIF , JPG , PNG)">
                <span class="note">width : <?php echo _width_thumb*$ratio_;?>px  - Height : <?php echo _height_thumb*$ratio_;?>px</span>
			</div>
			<div class="clear"></div>
                                        

		</div>

        <div class="formRow">
            <label>Hình ảnh hiện tại :</label>
            <div class="formRight">
				<?php
					if ($item["image"] != "") { ?>
						<div class="mt10"><img src="<?=WEB_ROOT . $item['image']?>" alt="<?=$item["name"]?>" width="100" /></div>
					<?php }
					else { ?>
						<div class="mt10"><img src="https://img.youtube.com/vi/<?=$item["link"]?>/0.jpg" alt="<?=$item["name"]?>" /></div>
					<?php }
				?>
            </div>
            <div class="clear"></div>
        </div>

        <div class="formRow">
          <label>Tùy chọn: <img src="<?=CUR_PATH?>/images/question-button.png" alt="Chọn loại" class="icon_que tipS" original-title="Check vào những tùy chọn "> </label>
          <div class="formRight">           
            <input type="checkbox" name="active" id="check1" value="1" <?=(!isset($item['showhide']) || $item['showhide']==1)?'checked="checked"':''?> />
            <label for="check1">Hiển thị</label>           
          </div>
          <div class="clear"></div>
        </div>
        <div class="formRow">
            <label>Số thứ tự: </label>
            <div class="formRight">
                <input type="text" class="tipS" value="<?=isset($item['ordernumber'])?$item['ordernumber']:1?>" name="stt" style="width:20px; text-align:center;" onkeypress="return OnlyNumber(event)" original-title="Số thứ tự của hình ảnh, chỉ nhập số">
            </div>
            <div class="clear"></div>
        </div>
			
	<div class="formRow">
			<div class="formRight">
            <input type="hidden" name="type" id="id_this_type" value="<?=$_REQUEST['type']?>" />
                <input type="hidden" name="id" id="id_this_photo" value="<?=@$item['id']?>" />
            	<input type="button" class="blueB" onclick="TreeFilterChanged2(); return false;" value="Hoàn tất" />
			</div>
			<div class="clear"></div>
		</div>     
		
	</div>
   
</form>   