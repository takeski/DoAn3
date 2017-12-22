
<style>
.wrapper{
	width:1000px !important;
}
.control_frm{
	margin-left:50px;
}
.bc{
	 width: 948px;
}
.widget{
	margin-left:50px;
	border:none;
}
.fa{
	color:white;
}
.row{
	    border: 10px solid;
	    border-radius: 10px;
}
@media (min-width: 768px){
	.col-sm-12{
		width:100%;
		margin-top:10px;
	}
}

</style>

<div class="control_frm" style="margin-top:25px;">
    <div class="bc">
        <ul id="breadcrumbs" class="breadcrumbs">
        	<li><a><span>Danh sách thống kê</span></a></li>
            <li class="current"><a href="#" onclick="return false;">Tất cả</a></li>
        </ul>
        <div class="clear"></div>
    </div>
</div>
<link rel="stylesheet" href="../admin/css/font-awesome.min.css">
<form name="f" id="f" method="post">
	<div class="widget">
		<table cellpadding="0" cellspacing="0" width="100%" class="sTable withCheck mTable" id="checkAll">
			<div class="row" style="margin: 10px auto;">

				<div class="col-sm-12 statistics">
					<div class="row" style="border: 1px solid #337ab7; background-color: #337ab7;">
						<div class="col-sm-3">
							<i class="fa fa-comments fa-5x"></i>
						</div>
						<div class="col-sm-9">
							<div class="text-right">Thành viên đăng ký</div>
							<div class="text-right" style="font-size: 30px;">4</div>
						</div>
					</div>
				</div>


				<div class="col-sm-12 statistics">
					<div class="row" style="border: 1px solid #f0ad4e; background-color: #f0ad4e;">
						<div class="col-sm-3">
							<i class="fa fa-shopping-cart fa-5x"></i>
						</div>
						<div class="col-sm-9">
							<div class="text-right">Số lượng đơn hàng tháng 7</div>
							<div class="text-right" style="font-size: 30px;">22</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12 statistics">
					<div class="row" style="border: 1px solid #d9534f; background-color: #d9534f;">
						<div class="col-sm-3">
							<i class="fa fa-support fa-5x"></i>
						</div>
						<div class="col-sm-9">
							<div class="text-right">Doanh thu tháng 7</div>
							<div class="text-right" style="font-size: 30px;"> VNĐ</div>
						</div>
					</div>
				</div>
			</div>
		</table>
	</div>
</form>      