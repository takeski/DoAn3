<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=slides&act=man_slides<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Slider</span></a></li>
            <li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script language="javascript">
	function CheckDelete(l){
		if(confirm('Bạn có chắc muốn xóa hình ảnh này?'))
		{
			location.href = l;	
		}
	}	
	function ChangeAction(str){
		if(confirm("Bạn có chắc chắn?"))
		{
			document.f.action = str;
			document.f.submit();
		}
	}	
	function XoaChon() {
		var listid="";
		$("input[name='chon']").each(function(){
			if (this.checked) listid = listid + "," + this.value;
		});
		
		listid=listid.substr(1);   //alert(listid);
		if (listid=="") { 
			alert("Bạn chưa chọn mục nào!"); return false;
		}
		var hoi = confirm("Bạn có chắc chắn muốn xóa?");
		if (hoi) {
			document.location = "<?=CUR_PATH?>?com=<?=$_GET["com"]?>&act=delete_slide&type=<?=$_GET['type']?>&curPage=<?=$_GET['curPage']?>&listid=" + listid;
		}
	}
		
</script>
<form name="f" id="f" method="post">
<div class="control_frm" style="margin-top:0;">
  	<div style="float:left;">
    	<input type="button" class="blueB" value="Thêm" onclick="location.href='<?=CUR_PATH?>?com=slides&act=add_slide<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>'" />
        <input type="button" class="blueB" value="Xoá Chọn" id="xoahet" onclick="XoaChon();" />
    </div>  
    <div style="float:right;">
        <div class="selector">
			
        </div>  
    </div>      	  
</div>

<div class="widget">
  <div class="title"><span class="titleIcon">
    <input type="checkbox" id="titleCheck" name="titleCheck" />
    </span>
    <h6>Danh sách các hình ảnh hiện có</h6>
  </div>
  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>
        <td class="tb_data_small"><a href="#" class="tipS" style="margin: 5px;">Thứ tự</a></td>  
        <td width="150">Hình ảnh</td>        
        <td class="sortCol"><div>Tên</div></td>        
        <td class="tb_data_small">Ẩn/Hiện</td>
        <td width="200">Thao tác</td>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="6"><div class="pagination">  <?=pagesListLimitadmin($url_link , $totalRows , $pageSize, $offset)?> </div></td>
      </tr>
    </tfoot>
    <tbody>
         <?php foreach ($items as $item){?>
          <tr>
       <td>
            <input type="checkbox" name="chon" value="<?=$item['id']?>" id="check<?=$i?>" />
        </td>        
        <td align="center">
            <input type="text" value="<?=$item['stt']?>" name="stt" onkeypress="return OnlyNumber(event)" class="tipS smallText" original-title="Nhập số thứ tự hình ảnh" id="number<?=$item['id']?>" onchange="return updateNumber('photo', '<?=$item['id']?>')" />
            <div id="ajaxloader"><img class="numloader" id="ajaxloader<?=$item['id']?>" src="<?=CUR_PATH?>/images/loader.gif" alt="loader" /></div>
        </td> 
        <td align="center">
                <img src="<?=WEB_ROOT . $item['hinh']?>" width="100" border="0" />
                </td>
      
        <td class="title_name_data">
            <a href="<?=CUR_PATH?>?com=slides&act=edit_slide&id=<?=$item['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" class="tipS SC_bold"><?=$item['ten']?></a>
        </td>
       
        <td align="center">
           <?php 
			if(@$item['anhien']==1)
				{
		    ?>
            <a href="<?=CUR_PATH?>?com=slides&act=man_slides&anhien=<?=$item['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" title="" class="smallButton tipS" original-title="Click để ẩn"><img src="<?=CUR_PATH?>/images/icons/color/tick.png" alt=""></a>
            <?php } else { ?>
            <a href="<?=CUR_PATH?>?com=slides&act=man_slides&anhien=<?=$item['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" title="" class="smallButton tipS" original-title="Click để hiện"><img src="<?=CUR_PATH?>/images/icons/color/hide.png" alt=""></a>
         <?php } ?>
         
        </td>       
        <td class="actBtns">
            <a href="<?=CUR_PATH?>?com=slides&act=edit_slide&id=<?=$item['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" title="" class="smallButton tipS" original-title="Sửa hình ảnh"><img src="<?=CUR_PATH?>/images/icons/dark/pencil.png" alt=""></a>
            <a href="" onclick="CheckDelete('<?=CUR_PATH?>?com=slides&act=delete_slide&id=<?=$item['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>'); return false;" title="" class="smallButton tipS" original-title="Xóa hình ảnh"><img src="<?=CUR_PATH?>/images/icons/dark/close.png" alt=""></a>        </td>
      </tr>
         <?php } ?>
                </tbody>
  </table>
</div>
</form>      