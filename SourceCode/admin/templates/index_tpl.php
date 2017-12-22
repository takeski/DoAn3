<style>
    .formRow .formRight{
        width: 83% !important;
    }
    .widget .title{
        height:0 !important;
    }
    .form input[type=text], .form input[type=password], .form textarea{
        width: 87% !important;
        padding: 5px 6px !important;

    }
    .row{
        margin-top:2px !important;
        padding-left:1px !important;
        padding-right:1px !important;
    }
    .huge {
        font-size: 40px;
    }
    .panel-footer{
            border: 1px solid;
    }
    .panel{
        border:none !important;
    }

    .panel-green {
        border-color: #5cb85c;
    }

    .panel-green > .panel-heading {
        border-color: #5cb85c;
        color: #fff;
        background-color: #5cb85c;
    }

    .panel-green > a {
        color: #5cb85c;
    }

    .panel-green > a:hover {
        color: #3d8b3d;
    }

    .panel-red {
        border-color: #d9534f;
    }

    .panel-red > .panel-heading {
        border-color: #d9534f;
        color: #fff;
        background-color: #d9534f;
    }

    .panel-red > a {
        color: #d9534f;
    }

    .panel-red > a:hover {
        color: #b52b27;
    }

    .panel-yellow {
        border-color: #f0ad4e;
    }

    .panel-yellow > .panel-heading {
        border-color: #f0ad4e;
        color: #fff;
        background-color: #f0ad4e;
    }

    .panel-yellow > a {
        color: #f0ad4e;
    }

    .panel-yellow > a:hover {
        color: #df8a13;
    }
    .nav>li>a{
        padding:0 !important;
    }

    .ui-datepicker-calendar {
        display: none;
        }
    .fa-5x{
        font-size:4em !important;
    }
    h4{
        font-size:17px !important;
    }
</style>
<?php
    require_once(dirname(__FILE__) . "/../../libraries/dbhelper.php");

    $db = new DBHelper();	

    $time=strtotime(time('y-m-d'));
	$donhang = $db->Query("SELECT count(id) as soluong FROM tb_donhang WHERE ngaydathang >='".$time."' ");
    $product = $db->Query("SELECT count(id) as soluong FROM tb_sanpham ");
    $member = $db->Query("SELECT count(id) as soluong FROM tb_taikhoan WHERE idnhom = 0 ");
    $orders = json_decode($_SESSION["order"], true);
	foreach ($orders as $order) {
		$total += $order["tonggia"];
	}
    /* Set the default timezone */
   date_default_timezone_set('Asia/Ho_Chi_Minh');

    /* Set the date */
    if($_GET['datepicker']!=''){
        $date = strtotime($_GET['datepicker']);
    } else {
        $date = strtotime(date('y-m-d'));
    } 

    $day = date('d', $date);
    $month = date('m', $date);
    $year = date('Y', $date);
    $firstDay = mktime(0,0,0,$month, 1, $year);
    $title = strftime('%B', $firstDay);
    $dayOfWeek = date('D', $firstDay);
    $daysInMonth = cal_days_in_month(0, $month, $year);
    /* Get the name of the week days */
    $timestamp = strtotime('next Sunday');
    $weekDays = array();
    for ($i = 0; $i < 7; $i++) {
        $weekDays[] = strftime('%a', $timestamp);
        $timestamp = strtotime('+1 day', $timestamp);
    }
    $blank = date('w', strtotime("{$year}-{$month}-01"));
?>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'Thống kê truy cập tháng : <?php echo $month; ?> - <?php echo $year; ?> '
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category',
            labels: {
                rotation: -45,
                style: {
                    fontSize: '13px',
                    fontFamily: 'Arial'
                }
            }
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Số người truy cập'
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: 'Tổng : <b>{point.y:.1f} Lượt truy cập</b>'
        },
        series: [{
            name: 'Population',
            data: [
				<?php 
					for($i = 1; $i <= $daysInMonth; $i++){
						$k = $i+1;
						$begin = strtotime($year.'-'.$month.'-'.$i);
						$end = strtotime($year.'-'.$month.'-'.$k);
						
						$sql = "SELECT COUNT(*) AS todayrecord FROM #_luottruycap WHERE date>='$begin' and date<'$end'";
						$lstResult = $d->Query($sql); 
						$todayrc  = reset($lstResult);
						$today_visitors = $todayrc['todayrecord']; 
				?>
						['<?=$i?>', <?=$today_visitors?>],
				<?php 
					} 
				?>
            ],
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Arial'
                }
            }
        }]
    });
    $( "#datepicker" ).datepicker({
      
      changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'yy-mm',
        onClose: function(dateText, inst) { 
            $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
});
</script>


<div class="wrapper">
<form name="supplier" id="validate" class="form" action="<?=CUR_PATH?>" method="get" enctype="multipart/form-data">

<div class="widget">
    <link rel="stylesheet" href="<?= WEB_ROOT?>admin/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= WEB_ROOT?>admin/css/font-awesome.min.css">
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-yellow">
                <div class="panel-heading">
                    <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-shopping-cart fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= reset($donhang)['soluong']?></div>
                        <div>Đơn hàng tháng <?= $month?></div>
                    </div>
                    </div>
                </div>
                <a href="<?= WEB_ROOT?>admin?com=orders&act=man&p=1&keyword=&ngaybd=01%2F07%2F2017&ngaykt=31%2F07%2F2017">
                    <div class="panel-footer">
                    <span class="pull-left">Xem chi tiết</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= reset($member)['soluong']?></div>
                        <div>Thành viên</div>
                    </div>
                    </div>
                </div>
                <a href="<?= WEB_ROOT?>admin?com=client&act=man">
                    <div class="panel-footer">
                    <span class="pull-left">Xem chi tiết</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?= reset($product)['soluong']?></div>
                        <div>Sản phẩm</div>
                    </div>
                    </div>
                </div>
                <a href="<?= WEB_ROOT?>admin?com=product&act=man">
                    <div class="panel-footer">
                    <span class="pull-left">Xem chi tiết</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-red">
                <div class="panel-heading">
                    <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-support fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div style="text-align: center;">Tổng doanh thu tháng <?= $month?></div>
                        <div>
                            <h4><?php echo number_format($total) . " VNĐ"?></h4>
                        </div>
                    </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                    <span class="pull-left"><br></span>
                    <span class="pull-right">
                    </span>
                    <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

   <div class="title"><h6> HỆ THỐNG QUẢN TRỊ NỘI DUNG WEBSITE </div>
   
   <div class="clear"></div>

   <div class="formRow">
        <label>Thống kê theo tháng</label>
        <div class="formRight">
                <input type="text" id="datepicker" name="datepicker" placeholder="yyyy-mm-dd" value="<?=$_GET['datepicker']?>">
                <input type="submit" class="blueB xemthongke" onclick="TreeFilterChanged2(); return false;" value="Xem thống kê" />
        </div>
        <div class="clear"></div>
   </div>

   <div class="clear"></div>

   <div id="container" style="width: 100%; height: 400px; margin: 0 auto"></div>
   <div class="clear"></div>
   <!-- 2 columns widgets -->
    
</div>
<div class="clear"></div>
<?php echo $today = date("d-m-y H:i a");  ?>
</form></div>

<script src="<?=CUR_PATH?>/js/highcharts/highcharts.js"></script>
<script src="<?=CUR_PATH?>/js/highcharts/modules/exporting.js"></script>

