<?php
session_start();
define( '_template' , $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/');
define( '_source' , $_SERVER['DOCUMENT_ROOT'] . '/admin/sources/');
define( '_lib' , $_SERVER['DOCUMENT_ROOT'] . '/libraries/');

$page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
if ($page <= 0) $page = 1;
$lang = 'vi';
include_once _lib."../admin/libraries/functions.php";
require_once(_lib . "dbhelper.php");

define("CUR_PATH", WEB_ROOT . "admin");

$com = (isset($_REQUEST['com'])) ? addslashes($_REQUEST['com']) : "";
$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
$d = new DBHelper();

switch($com){
	case 'orders':
		$source = "order";
		break;
	case 'statistic':
		$source = "statistic";
		break;
	case 'client':
		$source = "client";
		break;
	case 'danhmuc':
		$source = "danhmuc";
		break;
	case 'member':
		$source = "member";
		break;
	case 'lienhe':
		$source = "lienhe";
		break;
	case 'phanquyen':
		$source = "phanquyen";
		break;
	case 'com':
		$source = "com";
		break;
	case 'slides':
		$source = "slides";
		break;
	case 'company':
		$source = "company";
		break;

	case 'baiviet':
		$source = "baiviet";
		break;
	case 'info':
		$source = "info";
		break;
	case 'product':
		$source = "product";
		break;
	case 'user':
		$source = "user";
		break;
	case 'mxh':
		$source = "mxh";
		break;
	case 'video':
		$source = "video";
		break;
	case 'setting':
		$source = "setting";
		break;
	case 'bannerqc':
		$source = "bannerqc";
		break;
	default:
		$source = "";
		$template = "index";
		break;
}

if((!isset($_SESSION["user"]) || $_SESSION["user"]==false) && $act!="login"){
 	header("Location: " . CUR_PATH . "?com=user&act=login");
	exit(0);
}

if($source!="") include _source . $source . ".php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Administrator - Hệ thống quản trị nội dung</title>
	<link rel="shortcut icon" type="image/png" href="<?=WEB_ROOT?>images/logo4.png"/>
	<link href="<?=CUR_PATH?>/css/main.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?=CUR_PATH?>/js/external.js"></script>
	<script src="<?=CUR_PATH?>/js/jquery.price_format.2.0.js" type="text/javascript"></script>
	<script src="<?=CUR_PATH?>/ckeditor/ckeditor.js"></script>
	<link href="<?=CUR_PATH?>/js/plugins/multiupload/css/jquery.filer.css" type="text/css" rel="stylesheet" />
	<link href="<?=CUR_PATH?>/js/plugins/multiupload/css/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />
	<!-- MultiUpload -->
	<script type="text/javascript" src="<?=CUR_PATH?>/js/plugins/multiupload/jquery.filer.min.js"></script>
	<script src="<?=CUR_PATH?>/js/jquery.minicolors.js"></script>
	<link rel="stylesheet" href="<?=CUR_PATH?>/css/jquery.minicolors.css">
	<!--tags product-->
	<link href="<?=CUR_PATH?>/js/select-box-searching-jquery/select2.css" rel="stylesheet"/>
	<script src="<?=CUR_PATH?>/js/select-box-searching-jquery/select2.js"></script>

</head>
<?php if(isset($_SESSION["user"])){
	$session_user = json_decode($_SESSION["user"], true); ?>

	<body>
	<!-- Left side content -->
	<script type="text/javascript">
		$(function(){
			var num = $('#menu').children(this).length;
			for (var index=0; index<=num; index++)
			{
				var id = $('#menu').children().eq(index).attr('id');
				$('#'+id+' strong').html($('#'+id+' .sub').children(this).length);
				$('#'+id+' .sub li:last-child').addClass('last');
			}
			$('#menu .activemenu .sub').css('display', 'block');
			$('#menu .activemenu a').removeClass('inactive');
			/*$('.conso').priceFormat({
				limit: 13,
				prefix: '',
				centsLimit: 0
			});*/

			$('.color').each( function() {
				$(this).minicolors({
					control: $(this).attr('data-control') || 'hue',
					defaultValue: $(this).attr('data-defaultValue') || '',
					format: $(this).attr('data-format') || 'hex',
					keywords: $(this).attr('data-keywords') || '',
					inline: $(this).attr('data-inline') === 'true',
					letterCase: $(this).attr('data-letterCase') || 'lowercase',
					opacity: $(this).attr('data-opacity'),
					position: $(this).attr('data-position') || 'bottom left',
					change: function(value, opacity) {
						if( !value ) return;
						if( opacity ) value += ', ' + opacity;
						if( typeof console === 'object' ) {
							console.log(value);
						}
					},
					theme: 'bootstrap'
				});

			});

		})
	</script>
	<style type="text/css">
		<?php if($config['lang']=="vi"){?>
		.chonngonngu
		{
			display:none;
		}
		<?php } ?>
	</style>
	<div id="leftSide">
		<?php include _template."left_tpl.php";?>
	</div>
	<!-- Right side -->
	<div id="rightSide">
		<!-- Top fixed navigation -->
		<div class="topNav">
			<?php include _template."header_tpl.php";?>
		</div>

		<div class="wrapper">
			<?php include _template.$template."_tpl.php";?>
		</div></div>
	<div class="clear"></div>
	</body>
<?php }else{?>
	<body class="nobg loginPage">
	<?php include _template.$template."_tpl.php";?>
	<!-- Footer line -->
	<div id="footer">

	</div></body>
<?php }?>

<script>
	$(document).ready(function($) {
		$('.ck_editor').each(function(index, el) {
			var id = $(this).find('textarea').attr('id');
			CKEDITOR.replace( id, {
				height : 500,
				entities: false,
				uiColor : '#EAEAEA',
				basicEntities: false,
				entities_greek: false,
				entities_latin: false,
				filebrowserBrowseUrl : 'ckfinder/ckfinder.html',
				filebrowserImageBrowseUrl : 'ckfinder/ckfinder.html?type=Images',
				filebrowserFlashBrowseUrl : 'ckfinder/ckfinder.html?type=Flash',
				filebrowserUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				filebrowserImageUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				filebrowserFlashUploadUrl : 'ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
				allowedContent:
				'h1 h2 h3 p blockquote strong em;' +
				'a[!href];' +
				'img(left,right)[!src,alt,width,height];' +
				'table tr th td caption;' +
				'span{!font-family};' +
				'span{!color};' +
				'span(!marker);' +
				'del ins'
			});
		});
	});


</script>

<script type="text/javascript">
	$(document).ready(function() {
		/* ajax hienthi*/
		$("a.diamondToggle").click(function(){
			if($(this).attr("rel")==0){
				$.ajax({
					type: "POST",
					url: "ajax/ajax_hienthi.php",
					data:{
						id: $(this).attr("data-val0"),
						bang: $(this).attr("data-val2"),
						type: $(this).attr("data-val3"),
						value:1
					}
				});
				$(this).addClass("diamondToggleOff");
				$(this).attr("rel",1);

			}else{

				$.ajax({
					type: "POST",
					url: "ajax/ajax_hienthi.php",
					data:{
						id: $(this).attr("data-val0"),
						bang: $(this).attr("data-val2"),
						type: $(this).attr("data-val3"),
						value:0
					}
				});
				$(this).removeClass("diamondToggleOff");
				$(this).attr("rel",0);
			}

		});
		/* ajax hienthi*/
		$("a.status").click(function(){
			on = '<img src="./images/icons/color/tick.png" alt="">';
			off = '<img src="./images/icons/color/hide.png" alt="">';
			if($(this).attr("rel")==0){
				$.ajax({
					type: "POST",
					url: "ajax/ajax_hienthi.php",
					data:{
						id: $(this).attr("data-val0"),
						bang: $(this).attr("data-val2"),
						type: $(this).attr("data-val3"),
						value:1
					}
				});
				$(this).html(on);
				$(this).attr("rel",1);

			}else{

				$.ajax({
					type: "POST",
					url: "ajax/ajax_hienthi.php",
					data:{
						id: $(this).attr("data-val0"),
						bang: $(this).attr("data-val2"),
						type: $(this).attr("data-val3"),
						value:0
					}
				});
				$(this).html(off);
				$(this).attr("rel",0);
			}

		});
		/*end  ajax hienthi*/
		/*select danhmuc*/
		$(".select_danhmuc").change(function() {
			var child = $(this).data("child");
			var levell = $(this).data('level');
			var table = $(this).data('table');
			var type = $(this).data('type');
			$.ajax({
				url: 'ajax/ajax_danhmuc.php',
				type: 'POST',
				data: {level: levell,id:$(this).val(),table:table,type:type},
				success:function(data){
					var op = "<option>Chọn Danh Mục</option>";

					if(levell=='0'){
						$("#id_cat").html(op);
						$("#id_item").html(op);
						$("#id_sub").html(op);
					}else if(levell=='1'){
						$("#id_sub").html(op);
						$("#id_item").html(op);
					}else if(levell=='2'){
						$("#id_sub").html(op);
					}
					$("#"+child).html(data);
				}
			});
		});
	});
</script>


</html>
