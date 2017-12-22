<style>
	.dudoan{
		border:none;
	}

	@-webkit-keyframes hvr-ripple-out {
	100% {
		top: -12px;
		right: -12px;
		bottom: -12px;
		left: -12px;
		opacity: 0;
	}
	}
	.hvr-ripple-out {
	display: inline-block;
	vertical-align: middle;
	-webkit-transform: perspective(1px) translateZ(0);
	transform: perspective(1px) translateZ(0);
	box-shadow: 0 0 1px transparent;
	position: relative;
	}
	.hvr-ripple-out:before {
	content: '';
	position: absolute;
	border: #e1e1e1 solid 0px;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	-webkit-animation-duration: 1s;
	animation-duration: 1s;
	}
	.hvr-ripple-out:hover:before, .hvr-ripple-out:focus:before, .hvr-ripple-out:active:before, .hvr-ripple-out.active-hover:before {
	-webkit-animation-name: hvr-ripple-out;
	animation-name: hvr-ripple-out;
	-webkit-animation-timing-function: ease-in-out;
	animation-timing-function: ease-in-out;
	-webkit-animation-iteration-count: infinite;
	animation-iteration-count: infinite;
	border: #e1e1e1 solid 3px;
	}

</style>
<?php 
	require_once(dirname(__FILE__) . "/../../../libraries/dbhelper.php");
	$db = new DBHelper();	
	function GetQuantity($id) {
		global $db;
		
		$db->SetTable("#_khohang");
		$db->SetWhere("idsanpham", "=", $id);	
		$db->SetWhere("trangthai", "=", 1);
		return reset($db->Select("count(idsanpham) as soluong"))["soluong"];
	}
?>

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=product&act=man<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Danh sách sản phẩm</span></a></li>
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
			document.location = "<?=CUR_PATH?>?com=<?=$_GET["com"]?>&act=delete&type=<?=$_GET['type']?>&curPage=<?=$_GET['curPage']?>&listid=" + listid;
		}
	}
	
	function GetCat(lv) {
		var selCat = document.getElementById("selCat" + lv);
		var id = selCat.options[selCat.selectedIndex].value;
		
		var dm1 = "";
		var dm2 = "";
		var dm3 = "";
		
		if (dm1 == "" && "<?php echo isset($_GET["dm1"]) ? $_GET["dm1"] : ""; ?>" != "") {
			dm1 = "&dm1=" + "<?=$_GET["dm1"]?>";
		}
		
		if (dm2 == "" && "<?php echo isset($_GET["dm2"]) ? $_GET["dm2"] : ""; ?>" != "") {
			dm2 = "&dm2=" + "<?=$_GET["dm2"]?>";
		}
		
		if (lv == 1) {
			if (id != "") {
				dm1 = "&dm1=" + id;
			}
			else {
				dm1 = "";
			}
			dm2 = "";
			dm3 = "";
		}
		if (lv == 2) {
			if (id != "") {
				dm2 = "&dm2=" + id;
			}
			else {
				dm2 = "";
			}
			dm3 = "";
		}
		if (lv == 3) {
			if (id != "") {
				dm3 = "&dm3=" + id;
			}
			else {
				dm3 = "";
			}
		}
		
		window.location = "<?=CUR_PATH?>?com=product&act=man" + dm1 + dm2 + dm3;
	}

	function dudoan(id) {
		$.ajax({
			url: "<?=WEB_ROOT?>admin/functions/ai_quantity.php",
			method: "POST",
			data: { "id" : id ,"act":"dudoan"},
			success: function(result) {
				// alert(result);return;
				document.getElementById("dudoan" + id).innerHTML = result;
			}
		});
	}
</script>

<form name="f" id="f" method="post">
<div class="control_frm" style="margin-top:0;">
  	<div style="float:left;">
    	<input type="button" class="blueB" value="Thêm" onclick="location.href='<?=CUR_PATH?>?com=product&act=add<?php echo (GetParamsDm() == "") ? "&dm1=1" : GetParamsDm(); ?>'" />
        <input type="button" class="blueB" value="Xoá Chọn" id="xoahet" onclick="XoaChon();" />
    </div>     	  
</div>

<div class="widget">
  <div class="title"><span class="titleIcon">
    <input type="checkbox" id="titleCheck" name="titleCheck" />
    </span>
    <h6>Danh sách các sản phẩm hiện có</h6>
  </div>
  <div>
	<h6 style="display: inline-block; line-height: 50px;">&nbsp;Chọn danh mục:&nbsp;</h6>
	<?php
		$cat1 = $d->Query("
			select * from #_nhomsp where parentid = 0 
		");
	?>
	<select style="height: 30px;" id="selCat1" onchange="GetCat('1');">
		<option value="">Chọn nhà sản xuất</option>
		<?php
			foreach ($cat1 as $c) { ?>
				<option value="<?=$c["id"]?>" <?php echo $_GET["dm1"] == $c["id"] ? "selected='selected'" : ""; ?>><?=$c["ten"]?></option>
			<?php }
		?>
	</select>
	<?php if (isset($_GET["dm1"]) && $_GET["dm1"] != "") {
		$cat2 = $d->Query("
			select * from #_nhomsp where parentid = '" . $_GET["dm1"] . "' 
		"); ?>
		
		<select style="height: 30px;" id="selCat2" onchange="GetCat('2');">
			<option value="">Chọn nhóm sản phẩm</option>
		<?php foreach ($cat2 as $c) { ?>
			<option value="<?=$c["id"]?>" <?php echo $_GET["dm2"] == $c["id"] ? "selected='selected'" : ""; ?>><?=$c["ten"]?></option>
		<?php } ?>
		</select>
	<?php } ?>

	
  </div>
  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>
        <td width="150">Hình ảnh</td>        
        <td class="sortCol"><div>Tên</div></td>   
		<td class="tb_data_small">số lượng trong kho</td>
		<td class="tb_data_small">dự đoán sl nhập</td>
		<td class="tb_data_small">Nổi bật</td>
        <td class="tb_data_small">Ẩn/Hiện</td>
        <td width="200">Thao tác</td>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="10"><div class="pagination">  <?=pagesListLimitadmin($url_link , $totalRows , $pageSize, $offset)?>     </div></td>
      </tr>
    </tfoot>
    <tbody>
         <?php foreach ($items as $item){?>
          <tr>
       <td>
            <input type="checkbox" name="chon" value="<?=$item['id']?>" id="check<?=$i?>" />
        </td>        

        <td align="center">
                <img src="<?=WEB_ROOT . $item['hinh']?>" width="100" border="0" />
		</td>
      
        <td align="center" class="title_name_data">
            <a href="<?=CUR_PATH?>?com=product&act=edit<?php echo GetParamsDm(); ?>&id=<?=$item['id']?>" class="tipS SC_bold"><?=$item['ten']?></a>
        </td>

		<td align="center">
               <a href="" class="tipS SC_bold"><?= number_format(GetQuantity($item["id"]))?></a>
		</td>

		<td id="dudoan<?=$item["id"]?>" align="center">
			<button type="button" class="dudoan action-try hvr-ripple-out active-hover" onclick="dudoan(<?=$item["id"]?>);">Dự đoán</button>
		</td>
		
		<td align="center">
           <?php 
			if(@$item['noibat']==1)
				{
		    ?>
            <a href="<?=CUR_PATH?>?com=product&act=man<?php echo GetParamsDm(); ?>&noibat=<?=$item['id']?>" title="" class="smallButton tipS" original-title="Click để ẩn"><img src="<?=CUR_PATH?>/images/icons/color/tick.png" alt=""></a>
            <?php } else { ?>
            <a href="<?=CUR_PATH?>?com=product&act=man<?php echo GetParamsDm(); ?>&noibat=<?=$item['id']?>" title="" class="smallButton tipS" original-title="Click để hiện"><img src="<?=CUR_PATH?>/images/icons/color/hide.png" alt=""></a>
         <?php } ?>
         
        </td> 
       
        <td align="center">
           <?php 
			if(@$item['anhien']==1)
				{
		    ?>
            <a href="<?=CUR_PATH?>?com=product&act=man<?php echo GetParamsDm(); ?>&anhien=<?=$item['id']?>" title="" class="smallButton tipS" original-title="Click để ẩn"><img src="<?=CUR_PATH?>/images/icons/color/tick.png" alt=""></a>
            <?php } else { ?>
            <a href="<?=CUR_PATH?>?com=product&act=man<?php echo GetParamsDm(); ?>&anhien=<?=$item['id']?>" title="" class="smallButton tipS" original-title="Click để hiện"><img src="<?=CUR_PATH?>/images/icons/color/hide.png" alt=""></a>
         <?php } ?>
         
        </td>       
        <td class="actBtns">
            <a href="<?=CUR_PATH?>?com=product&act=edit<?php echo GetParamsDm(); ?>&id=<?=$item['id']?>" title="" class="smallButton tipS" original-title="Sửa hình ảnh"><img src="<?=CUR_PATH?>/images/icons/dark/pencil.png" alt=""></a>
            <a href="" onclick="CheckDelete('<?=CUR_PATH?>?com=product&act=delete<?php echo GetParamsDm(); ?>&id=<?=$item['id']?>'); return false;" title="" class="smallButton tipS" original-title="Xóa hình ảnh"><img src="<?=CUR_PATH?>/images/icons/dark/close.png" alt=""></a>        
			</td>
      </tr>
         <?php } ?>
                </tbody>
  </table>
</div>
</form>      