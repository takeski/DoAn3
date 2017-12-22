<?php	if(!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

switch($act){
	case "man":
		get_items();
		$template = "order/items";
		break;
	case "add":		
	
		$template = "order/item_add";
		break;
	case "edit":		
		
		get_item();
		$template = "order/item_add";
		break;
	case "save":
		save_item();
		break;
	case "delete":
		
		delete_item();
		break;	
	default:
		$template = "index";
}

#====================================

function get_items(){		
	global $d, $items, $url_link, $totalRows, $pageSize, $offset;
	
	$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
	$ngaybd = isset($_GET["ngaybd"]) ? $_GET["ngaybd"] : "";
	$ngaykt = isset($_GET["ngaykt"]) ? $_GET["ngaykt"] : "";
	// $tinhtrang = isset($_GET["tinhtrang"]) ? $_GET["tinhtrang"] : "";
	
	$url_link = CUR_PATH . "?com=orders&act=man";
	
	$where = "where true ";
	if ($keyword != "") {
		$url_link .= "&keyword=" . $keyword;
		$where .= "and iddonhang like '%$keyword%' ";
	}
	if($ngaybd != "" && $ngaykt != "") {
		$url_link .= "&ngaybd=" . $ngaybd;
		$Ngay_arr = explode("/",$ngaybd); // array(17,11,2010)
		if (count($Ngay_arr) == 3) {
			$ngay = $Ngay_arr[0]; //17
			$thang = $Ngay_arr[1]; //11
			$nam = $Ngay_arr[2]; //2010
			if (checkdate($thang,$ngay,$nam) != false){ 
				$ngaybd = $nam . "-" . $thang . "-" . $ngay;
			}
		}		
		$where .= " and ngaydathang >= " . strtotime($ngaybd) . " ";
		
		$url_link .= "&ngaykt=" . $ngaykt;
		$Ngay_arr = explode("/",$ngaykt); // array(17,11,2010)
		if (count($Ngay_arr) == 3) {
			$ngay = $Ngay_arr[0]; //17
			$thang = $Ngay_arr[1]; //11
			$nam = $Ngay_arr[2]; //2010
			if (checkdate($thang,$ngay,$nam) != false){ 
				$ngaykt = $nam . "-" . $thang . "-" . $ngay;
			}
		}		
		$where .= "and ngaydathang <= " . strtotime($ngaykt) . " ";
	}


	// if ($tinhtrang != "") {
	// 	$url_link .= "&tinhtrang=" . $tinhtrang;
	// 	$where .= "and status = '" . $tinhtrang . "' ";
	// }
	
	// if ($where == "where true ") {
	// 	$where = "";
	// }		
		
	$count = reset($d->Query("select count(id) as numrows 
							from #_donhang
							$where"));	
	$totalRows = $count["numrows"];
	
	$pageSize = 10;
	$offset = 5;
	
	$page = isset($_GET['p']) ? $_GET['p'] : "";
	if ($page == "")
        $page = 1;
    else
        $page = $_GET['p'];
    $page--;
    $bg = $pageSize * $page;
	
	
	$items = $d->Query("
		select * 
		from #_donhang 
		$where 
		 order by ngaydathang desc 
		limit $bg, $pageSize
	");
	
	
	$orders = $d->Query("
		select * 
		from #_donhang 
		$where 
		 order by ngaydathang desc 
	");
	
	$_SESSION["order"] = json_encode($orders);
}

function get_item(){
	global $d, $item;
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if ($id == "") {
		header("Location: " . CUR_PATH . "?com=orders&act=man");
		exit(0);
	}
	
	$d->SetTable("#_donhang");

	$d->SetWhere("id", "=", $id);
	$item = reset($d->Select());
}

function save_item(){
	global $d; 
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if (isset($_POST["selStatus"]) && $_POST["selStatus"] != "") {
		$data["trangthai"] = $_POST["selStatus"];
		$d->SetTable("#_donhang");
		$d->SetWhere("id", "=", $id);
		$d->Update($data);
	}
	
	header("Location: " . CUR_PATH . "?com=orders&act=man");
	exit(0);
}

function delete_item(){
	global $d;
	
	if (isset($_GET['listid'])) {
        $ids = explode(',', $_GET['listid']);
        foreach ($ids as $id) {

			$d->SetTable("#_chitietdonhang");
			$d->SetWhere('idchitietdonhang', "=", $id);
			$d->Delete();

			$d->SetTable("#_donhang");
			$d->SetWhere("id", "=", $id);
			$d->Delete();
        }
        header("Location: " . CUR_PATH . "?com=orders&act=man");
		exit(0);
    }
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if($id != ""){
		$d->SetTable("#_chitietdonhang");
		$d->SetWhere('idchitietdonhang', "=", $id);
		$d->Delete();

		$d->SetTable("#_donhang");
		$d->SetWhere('id', "=", $id);
		$d->Delete();
	}
	
	header("Location: " . CUR_PATH . "?com=orders&act=man");
	exit(0);
}
?>