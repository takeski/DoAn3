<?php 
		function GetStatus($s) {
      if ($s == "danggiaohang") {
        return "Đang giao hàng";
      }
      else 
      if($s == "dangtrahang") {
        return "Đang trả hàng";
      }
      if ($s == "dagiaohang") {
        return "Đã giao hàng";
      }
      else {
        return "Đã hủy";
      }
	}
	

?>

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
			<li><a href="<?=CUR_PATH?>?com=orders&act=man"><span>Đơn hàng</span></a></li>
            <li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>

<script src="<?=CUR_PATH?>/js/jquery.datetimepicker.full.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".datetimepicker").datetimepicker({
      yearOffset:222,
      lang:'ch',
      timepicker:false,
      format:'m/d/Y',
      formatDate:'Y/m/d',
      minDate:'-1970/01/02', // yesterday is minimum date
      maxDate:'+1970/01/02' // and tommorow is maximum date calendar
    });
  });
</script>

<div class="widget">
  <div class="titlee" style="padding-bottom:5px;">

    <div class="timkiem" >
    <form name="search" action="<?=CUR_PATH?>" method="GET" class="form giohang_ser">
      <input name="com" value="orders" type="hidden"  />
      <input name="act" value="man" type="hidden" />
      <input name="p" value="<?=($_GET['p']=='')?'1':$_GET['p']?>" type="hidden" />

      <input class="form_or" name="keyword" placeholder="Nhập mã đơn hàng .." value="<?=$_GET['keyword']?>" type="text" />
      <input class="form_or" name="ngaybd" id="datefm" type="text" value="<?=$_GET['ngaybd']?>" placeholder="Từ ngày.."/>
      <input class="form_or" name="ngaykt" id="dateto" type="text" value="<?=$_GET['ngaykt']?>" placeholder="Đến ngày.." />

      <!--<select name="tinhtrang">
      <option value="">Tình trạng</option>
        <?php  
          $d->SetTable("#_ordersstatus");
		  $ordersstatus = $d->Select();
          foreach ($ordersstatus as $status) { 
        ?>
          <option value="<?=$status["type"]?>" <?php if($status["type"]==$_GET['tinhtrang']) echo "selected='selected'";?> >
            <?=$status["name"]?>
          </option>
        <?php }?>
      </select>-->
      <input type="submit" class="blueB" value="Tìm kiếm" style="width:100px; margin:0px 0px 0px 10px;"  />
    </form>
    </div><!--end tim kiem-->
  </div>
</div>

<script language="javascript">
	function CheckDelete(l){
		if(confirm('Bạn có chắc muốn xoá đơn hàng này?'))
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
		
		listid=listid.substr(1);   
		if (listid=="") { 
			alert("Bạn chưa chọn mục nào!"); return false;
		}
		var hoi = confirm("Bạn có chắc chắn muốn xóa?");
		if (hoi) {
			document.location = "<?=CUR_PATH?>?com=<?=$_GET["com"]?>&act=delete&type=<?=$_GET['type']?>&curPage=<?=$_GET['curPage']?>&listid=" + listid;
		}
	}	
</script>
<form name="f" id="f" method="post">
<div class="control_frm" style="margin-top:0;">
  	<div style="float:left;">
        <input type="button" class="blueB" value="Xoá Chọn" id="xoahet" onclick="XoaChon();" />
    </div>  
</div>

<div class="widget">
  <div class="title"><span class="titleIcon">
    <input type="checkbox" id="titleCheck" name="titleCheck" />
    </span>
    <h6>Danh sách đơn hàng <a href="<?=CUR_PATH?>/custom_export.php" title="" class="smallButton tipS" original-title="xuất file Excel"><img src="<?=CUR_PATH?>/images/icons/excel.png" alt=""></a></h6>
  </div>
  <table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>
       <td class="sortCol" width="120"><div>Mã đơn hàng<span></span></div></td>     
        <td class="sortCol"><div>Họ tên<span></span></div></td>
        <td class="sortCol" width="150"><div>Ngày đặt<span></span></div></td>
        <!--<td class="sortCol"><div>Tổng tiền<span></span></div></td>-->
		<td class="sortCol"><div>Phương thức<span></span></div></td>
		<td class="sortCol"><div>Tình trạng<span></span></div></td>
        <td width="150">Thao tác</td>
      </tr>
    </thead>
    <tfoot>
      <tr>
        <td colspan="10"><div class="pagination">  <?=pagesListLimitadmin($url_link , $totalRows , $pageSize, $offset)?>     </div></td>
      </tr>
    </tfoot>
    <tbody>
         <?php 
         foreach ($items as $item){?>
          <tr>
       <td>
            <input type="checkbox" name="chon" value="<?=$item['id']?>" id="check<?=$i?>" />
        </td>
        <td align="center" <?php if($item['view']==0){ echo "style='font-weight:bold;'";}?>>
            <?=$item['iddonhang']?>
        </td> 
        <td <?php if($item['view']==0){ echo "style='font-weight:bold;'";}?>>
			<?=$item['hoten']?>
		</td>
		<td align="center" <?php if($item['view']==0){ echo "style='font-weight:bold;'";}?>>
             <?=date('d/m/Y - g:i A',$item['ngaydathang']);?>
        </td>

       <td align="center" <?php if($item['view']==0){ echo "style='font-weight:bold;'";}?>>
			<?php

        echo $item['thanhtoan'];
			?>
		</td>	
        <td align="center" <?php if($item['view']==0){ echo "style='font-weight:bold;'";}?>>
           <?php
        echo GetStatus($item['trangthai']);
			?>
        </td>
        
       
        <td class="actBtns">
            <a href="<?=CUR_PATH?>/export.php?&id=<?=$item['id']?>" title="" class="smallButton tipS" original-title="xuất file Excel"><img src="<?=CUR_PATH?>/images/icons/excel.png" alt=""></a>
            <a href="<?=CUR_PATH?>?com=orders&act=edit&id=<?=$item['id']?>" title="" class="smallButton tipS" original-title="Xem và sửa đơn hàng"><img src="<?=CUR_PATH?>/images/icons/dark/preview.png" alt=""></a>
            <a href="" onclick="CheckDelete('<?=CUR_PATH?>?com=orders&act=delete&id=<?=$item['id']?>'); return false;" title="" class="smallButton tipS" original-title="Xóa đơn hàng"><img src="<?=CUR_PATH?>/images/icons/dark/close.png" alt=""></a></td>
      </tr>
         <?php  }  ?>
                </tbody>
  </table>
</div>
</form>               


<script type="text/javascript">
function onSearch(evt) {	
		var datefm = document.getElementById("datefm").value;	
		var dateto = document.getElementById("dateto").value;
		var status = document.getElementById("id_tinhtrang").value;		
		loadPage(document.location);
			
}
$(document).ready(function(){						
	var dates = $( "#datefm, #dateto" ).datepicker({
			defaultDate: "+1w",
			dateFormat: 'dd/mm/yy',
			changeMonth: true,			
			numberOfMonths: 3,
			onSelect: function( selectedDate ) {
				var option = this.id == "datefm" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
        
		});
		
</script>