<script type="text/javascript">
	$(document).ready(function() {
		$('.update_STT').keyup(function(event) {
			var id = $(this).attr('rel');
			var table = 'taikhoan';
			var value = $(this).val();
			$.ajax ({
				type: "POST",
				url: "ajax/update_STT.php",
				data: {id:id,table:table,value:value},
				success: function(result) {
				}
			});
		});
		$('.timkiem button').click(function(event) {
			var keyword = $(this).parent().find('input').val();
			window.location.href="<?=CUR_PATH?>?com=<?= $com ?>&act=man&type=<?=$_GET['type']?>&keyword="+keyword;
		});
	});
	
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

  function select_list()
  {
    var a=document.getElementById("id_list");
    window.location ="<?=CUR_PATH?>?com=<?= $com ?>&act=man&type=<?=$_GET['type']?>&id_list="+a.value;
    return true;
  }

  function select_cat()
  {
    var a=document.getElementById("id_list");
    var b=document.getElementById("id_cat");
    window.location ="<?=CUR_PATH?>?com=<?= $com ?>&act=man&type=<?=$_GET['type']?>&id_list="+a.value+"&id_cat="+b.value;
    return true;
  }
   function select_item()
  {
    var a=document.getElementById("id_list");
    var b=document.getElementById("id_cat");
    var c=document.getElementById("id_item");
    window.location ="<?=CUR_PATH?>?com=<?= $com ?>&act=man&type=<?=$_GET['type']?>&id_list="+a.value+"&id_cat="+b.value+"&id_item="+c.value;
    return true;
  }
  function select_sub()
  {
    var a=document.getElementById("id_list");
    var b=document.getElementById("id_cat");
    var c=document.getElementById("id_item");
    var d=document.getElementById("id_sub");
    window.location ="<?=CUR_PATH?>?com=<?= $com ?>&act=man&type=<?=$_GET['type']?>&id_list="+a.value+"&id_cat="+b.value+"&id_item="+c.value+"&id_sub="+d.value;
    return true;
  }

	$(function(){
		$('#selArticle').on('change', function () {
			var type = $(this).val();
			if (type) {
				window.location = "<?=CUR_PATH?>?com=baiviet&act=man&type=" + type;
			}
			return false;
		});
	});
</script>

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a href="<?=CUR_PATH?>?com=<?= $com ?>&act=man<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>"><span>Quản lý bài viết <?=$title_main ?></span></a></li>
        	<?php if($_GET['keyword']!=''){ ?>
				<li class="current"><a href="#" onclick="return false;">Kết quả tìm kiếm " <?=$_GET['keyword']?> " </a></li>
			<?php }  else { ?>
            	<li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
            <?php } ?>
        </ul>
        <div class="clear"></div>
    </div>
</div>


<form name="f" id="f" method="post">
<div class="control_frm" style="margin-top:0;">
  	<div style="float:left;">
    	<input type="button" class="blueB" value="Thêm" onclick="location.href='<?=CUR_PATH?>?com=<?= $com ?>&act=add<?php if($_REQUEST['type']!='') echo'&type='. $_REQUEST['type'];?>'" />
        <input type="button" class="blueB" value="Xoá Chọn" id="xoahet" onclick="XoaChon();" />
    </div>  
</div>

<div class="widget">
  <div class="title">
	<span class="titleIcon"><input type="checkbox" id="titleCheck" name="titleCheck" /></span>
    <h6>Chọn tất cả</h6>
    <div class="timkiem">
	    <input type="text" value="" placeholder="Nhập từ khóa tìm kiếm ">
	    <button type="button" class="blueB"  value="">Tìm kiếm</button>
    </div>
  </div>
	<table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
    <thead>
      <tr>
        <td></td>   
				<td class="sortCol"><div>Tên tài khoản</div></td>   
				<td class="sortCol"><div>họ tên</div></td>   
        <td class="sortCol"><div>email</div></td>   	
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
					<a  href="<?=CUR_PATH?>?com=<?=$com?>&act=edit&id=<?=$item['id']?>" class="tipS SC_bold"><?=$item['tentaikhoan']?></a>
				</td>
				<td align="center">
					<a  href="<?=CUR_PATH?>?com=<?=$com?>&act=edit&id=<?=$item['id']?>" class="tipS SC_bold"><?=$item['hoten']?></a>
				</td>
	
       
				<td align="center">
					<a href="<?=CUR_PATH?>?com=<?=$com?>&act=edit&id=<?=$item['id']?>" class="tipS SC_bold"><?=$item['email']?></a>
				</td>
			
				<td class="actBtns">
					<a href="<?=CUR_PATH?>?com=<?=$com?>&act=edit&id=<?=$item['id']?>" title="" class="smallButton tipS" original-title="Sửa bài viết"><img src="<?=CUR_PATH?>/images/icons/dark/pencil.png" alt=""></a>
					<a href="<?=CUR_PATH?>?com=<?=$com?>&act=delete&id=<?=$item['id']?>" onClick="if(!confirm('Xác nhận xóa')) return false;" title="" class="smallButton tipS" original-title="Xóa bài viết"><img src="<?=CUR_PATH?>/images/icons/dark/close.png" alt=""></a>
				</td>
			</tr>
        <?php } ?>
	</tbody>
	</table>
</div>
</form>  

<div class="paging"><?=$paging?></div>