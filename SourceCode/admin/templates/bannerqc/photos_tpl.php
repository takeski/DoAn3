<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=bannerqc&act=dsbannerqc<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Quảng cáo</span></a></li>
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
			document.location = "<?=CUR_PATH?>?com=<?=$_GET["com"]?>&act=delete_bannerqc&type=<?=$_GET['type']?>&curPage=<?=$_GET['curPage']?>&listid=" + listid;
		}
	}
	
</script>
<form name="f" id="f" method="post">
<div class="control_frm" style="margin-top:0;">
  	<div style="float:left;">
    	<input type="button" class="blueB" value="Thêm" onclick="location.href='<?=CUR_PATH?>?com=bannerqc&act=thembannerqc<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>'" />
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
        <td width="150">Hình ảnh</td>        
        <td class="sortCol"><div>Tên</div></td>        
        <td class="tb_data_small">Ẩn/Hiện</td>
        <td width="200">Thao tác</td>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="5"><div class="pagination">  <?=pagesListLimitadmin($url_link , $totalRows , $pageSize, $offset)?>     </div></td>
      </tr>
    </tfoot>
    <tbody>
         <?php for($i=0, $count=count($items); $i<$count; $i++){?>
          <tr>
       <td>
            <input type="checkbox" name="chon" value="<?=$items[$i]['id']?>" id="check<?=$i?>" />
        </td>        
        <td align="center">
                <img src="<?=WEB_ROOT . $items[$i]['hinh']?>" width="100" border="0" />
                </td>
      
        <td class="title_name_data">
            <a href="<?=CUR_PATH?>?com=bannerqc&act=capnhatbannerqc&id=<?=$items[$i]['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" class="tipS SC_bold"><?=$items[$i]['ten']?></a>
        </td>
       
        <td align="center">
           <?php 
			if(@$items[$i]['anhien']==1)
				{
		    ?>
            <a href="<?=CUR_PATH?>?com=bannerqc&act=dsbannerqc&anhien=<?=$items[$i]['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" title="" class="smallButton tipS" original-title="Click để ẩn"><img src="<?=CUR_PATH?>/images/icons/color/tick.png" alt=""></a>
            <?php } else { ?>
            <a href="<?=CUR_PATH?>?com=bannerqc&act=dsbannerqc&anhien=<?=$items[$i]['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" title="" class="smallButton tipS" original-title="Click để hiện"><img src="<?=CUR_PATH?>/images/icons/color/hide.png" alt=""></a>
         <?php } ?>
         
        </td>       
        <td class="actBtns">
            <a href="<?=CUR_PATH?>?com=bannerqc&act=capnhatbannerqc&id=<?=$items[$i]['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>" title="" class="smallButton tipS" original-title="Sửa hình ảnh"><img src="<?=CUR_PATH?>/images/icons/dark/pencil.png" alt=""></a>
            <a href="" onclick="CheckDelete('<?=CUR_PATH?>?com=bannerqc&act=delete_bannerqc&id=<?=$items[$i]['id']?><?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>'); return false;" title="" class="smallButton tipS" original-title="Xóa hình ảnh"><img src="<?=CUR_PATH?>/images/icons/dark/close.png" alt=""></a>        </td>
      </tr>
         <?php } ?>
                </tbody>
  </table>
</div>
</form>      