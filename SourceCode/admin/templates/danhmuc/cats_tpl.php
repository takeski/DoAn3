<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=danhmuc&act=man_cat&level=<?=$_GET['level'];?>"><span>
			<?php if($_GET['level']== "1"){
			echo "Nhà sản xuất";
			}else{
				echo"Nhóm sản phẩm";
			}	
			?>		
			</span></a></li>
            <li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<script language="javascript">
	function CheckDelete(l){
		if(confirm('Bạn có chắc muốn xóa danh mục này?'))
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
	
	<?php 
		if (!isset($_REQUEST["level"]) || $_REQUEST["level"] == "") {
			$level = isset($_REQUEST["level"]) ? $_REQUEST["level"] : "";
			if ($level == "") $level = "1"; ?>
			window.location = "<?=CUR_PATH?>?com=danhmuc&act=man_cat&level=<?=$level?>";
	<?php }	?>
	
	function GetCat(lv) {
		var selCat = document.getElementById("selCat" + lv);
		var id = selCat.options[selCat.selectedIndex].value;
		
		/*$.ajax({
			url: "<?=CUR_PATH?>/ajax/ajax_danhmuc.php",
			type: "POST",
			data: { "id" : id },
			success: function(result) {
				alert(result);
			}
		});*/
		
		var dm1 = "";
		var dm2 = "";
		
		if (dm1 == "" && "<?php echo isset($_GET["dm1"]) ? $_GET["dm1"] : ""; ?>" != "") {
			dm1 = "&dm1=" + "<?=$_GET["dm1"]?>";
		}
		
		if (lv == 1) {
			if (id != "") {
				dm1 = "&dm1=" + id;
			}
			else {
				dm1 = "";
			}
		}
		if (lv == 2) {
			if (id != "") {
				dm2 = "&dm2=" + id;
			}
			else {
				dm2 = "";
			}
		}
		
		window.location = "<?=CUR_PATH?>?com=danhmuc&act=man_cat&level=<?=$level?>" + dm1 + dm2;
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
			document.location = "<?=CUR_PATH?>?com=<?=$_GET["com"]?>&act=delete_cat&type=<?=$_GET['type']?>&curPage=<?=$_GET['curPage']?>&listid=" + listid;
		}
	}
</script>

<form name="f" id="f" method="post">
<div class="control_frm" style="margin-top:0;">
  	<div style="float:left;">
    	<input type="button" class="blueB" value="Thêm" onclick="location.href='<?=CUR_PATH?>?com=danhmuc&act=add_cat&level=<?=$level?><?php echo GetParamsDM(); ?>'" />
        <input type="button" class="blueB" value="Xoá Chọn" id="xoahet" onclick="XoaChon();" />
    </div>    	  

</div>

<div class="widget">
  <div class="title"><span class="titleIcon">
    <input type="checkbox" id="titleCheck" name="titleCheck" />
    </span>
    <h6>Danh sách các danh mục hiện có</h6>
  </div>
  <div>
  <?php
	if ($level == 2) { 
		$cat1 = $d->Query("
			select * from #_nhomsp where parentid = 0 
		"); ?>
		<h6 style="display: inline-block; line-height: 50px;">&nbsp;Chọn nhà sản xuất :&nbsp;</h6>
		<select style="height: 30px;" id="selCat1" onchange="GetCat('1');">
			<option value="">Chọn nhà sản xuất</option>
			<?php
				foreach ($cat1 as $c) { ?>
					<option value="<?=$c["id"]?>" <?php echo $_GET["dm1"] == $c["id"] ? "selected='selected'" : ""; ?>><?=$c["ten"]?></option>
				<?php }
			?>
		</select>
	<?php } ?>

  </div>
  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>
		<td> <?php if($_GET['level']=="1"){
			echo "Tên nhà sản xuất";
		}else{
			echo "Nhóm sản phẩm";
		}?></td>
        <td class="tb_data_small">Ẩn/Hiện</td>
        <td width="200">Thao tác</td>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="10"><div class="pagination"><?=pagesListLimitadmin($url_link , $totalRows , $pageSize, $offset)?></div></td>
      </tr>
    </tfoot>
    <tbody>
         <?php foreach ($items as $item) {?>
          <tr>
       <td>
            <input type="checkbox" name="chon" value="<?=$item['id']?>" id="check<?=$i?>" />
        </td>        
		<td align="center" class="title_name_data">
			<a href="<?=CUR_PATH?>?com=danhmuc&act=edit_cat&level=<?=$level?><?php echo GetParamsDM(); ?>&id=<?=$item['id']?>" class="tipS SC_bold"><?=$item['ten']?></a>
		</td>		
        <td align="center">
           <?php 
			if(@$item['anhien']==1)
				{
		    ?>
            <a href="<?=CUR_PATH?>?com=danhmuc&act=man_cat&level=<?=$level?><?php echo GetParamsDM(); ?>&anhien=<?=$item['id']?>" title="" class="smallButton tipS" original-title="Click để ẩn"><img src="<?=CUR_PATH?>/images/icons/color/tick.png" alt=""></a>
            <?php } else { ?>
            <a href="<?=CUR_PATH?>?com=danhmuc&act=man_cat&level=<?=$level?><?php echo GetParamsDM(); ?>&anhien=<?=$item['id']?>" title="" class="smallButton tipS" original-title="Click để hiện"><img src="<?=CUR_PATH?>/images/icons/color/hide.png" alt=""></a>
         <?php } ?>
         
        </td>       
        <td class="actBtns">
            <a href="<?=CUR_PATH?>?com=danhmuc&act=edit_cat&level=<?=$level?><?php echo GetParamsDM(); ?>&id=<?=$item['id']?>" title="" class="smallButton tipS" original-title="Sửa hình ảnh"><img src="<?=CUR_PATH?>/images/icons/dark/pencil.png" alt=""></a>

            <a href="" onclick="CheckDelete('<?=CUR_PATH?>?com=danhmuc&act=delete_cat&level=<?=$level?><?php echo GetParamsDM(); ?>&id=<?=$item['id']?>'); return false;" title="" class="smallButton tipS" original-title="Xóa danh mục"><img src="<?=CUR_PATH?>/images/icons/dark/close.png" alt=""></a>        </td>

      </tr>
         <?php } ?>
	</tbody>
  </table>
</div>
</form>      
