<?php if (!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

function GetParamsDm() {
	$params = "";
	
	if (isset($_GET["dm1"]) || $_GET["dm1"])
		$params .= "&dm1=" . $_GET["dm1"]; 
	if (isset($_GET["dm2"]) || $_GET["dm2"]) 
		$params .= "&dm2=" . $_GET["dm2"];
	if (isset($_GET["dm3"]) || $_GET["dm3"]) 
		$params .= "&dm3=" . $_GET["dm3"];
	
	return $params;
}

switch ($act) {
    case "man":		
        get_items();
        $template = "product/items";
        break;
    case "add":
        $template = "product/item_add";
        break;
    case "edit":
        get_item();
        $template = "product/item_add";
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

function get_items() {
	global $d, $items, $url_link, $totalRows, $pageSize, $offset;
	
	if ($_REQUEST['noibat'] != '') {
        $id_up = $_REQUEST['noibat'];
		$d->SetTable("#_sanpham");
		$d->SetWhere("id", "=", $id_up);
        $product = reset($d->Select());
        $noibat = $product['noibat'];
        if ($noibat == 0) {
			$d->SetTable("#_sanpham");
			$d->SetWhere("id", "=", $id_up);
			$data["noibat"] = 1;
			$d->Update($data);
        } else {
            $d->SetTable("#_sanpham");
			$d->SetWhere("id", "=", $id_up);
			$data["noibat"] = 0;
			$d->Update($data);
        }
		
		header("Location: " . CUR_PATH . "?com=product&act=man" . GetParamsDm());
		exit(0);
    }
	
	if ($_REQUEST['anhien'] != '') {
        $id_up = $_REQUEST['anhien'];
		$d->SetTable("#_sanpham");
		$d->SetWhere("id", "=", $id_up);
        $product = reset($d->Select());
        $anhien = $product['anhien'];
        if ($anhien == 0) {
			$d->SetTable("#_sanpham");
			$d->SetWhere("id", "=", $id_up);
			$data["anhien"] = 1;
			$d->Update($data);
        } else {
            $d->SetTable("#_sanpham");
			$d->SetWhere("id", "=", $id_up);
			$data["anhien"] = 0;
			$d->Update($data);
        }
		
		header("Location: " . CUR_PATH . "?com=product&act=man" . GetParamsDm());
		exit(0);
    }
	
	$items = array();
	
	if (isset($_GET["dm3"])) {
		$id = $_GET["dm3"];
		
		$items = $d ->Query("
			select * from #_sanpham where idnhomsp = '" . $id . "' order by id desc
		");
	}
	else if (isset($_GET["dm2"])) {
		$id = $_GET["dm2"];
		
		$items = $d ->Query("
			select * from #_sanpham where idnhomsp in (
				select id from #_nhomsp where parentid = '" . $id . "'
			) order by id desc
		");
		
		$lstResult = $d ->Query("
			select * from #_sanpham where idnhomsp = '" . $id . "' order by id desc
		");
		foreach ($lstResult as $result) {
			array_push($items, $result);
		}
	}
	else if (isset($_GET["dm1"])) {
		$id = $_GET["dm1"];
		
		$items = $d ->Query("
			select * from #_sanpham where idnhomsp in (
				select id from #_nhomsp where parentid in (
					select id from #_nhomsp where parentid = '" . $id . "'
				)
			) order by id desc
		");
		
		$lstResult = $d ->Query("
			select * from #_sanpham where idnhomsp = '" . $id . "' order by id desc
		");
		foreach ($lstResult as $result) {
			array_push($items, $result);
		}
		
		$lstResult = $d ->Query("
			select * from #_sanpham where idnhomsp in (
				select id from #_nhomsp where parentid = '" . $id . "' order by id desc
			)
		");
		foreach ($lstResult as $result) {
			array_push($items, $result);
		}
	}
	else {
		$items = $d ->Query("
			select * from #_sanpham order by id desc
		");
	}
	
	$url_link = CUR_PATH . "?com=product&act=man" . GetParamsDm();
	$totalRows = count($items);
	
	$pageSize = 10;
	$offset = 5;
	
	$page = isset($_GET['p']) ? $_GET['p'] : "";
	if ($page == "")
		$page = 1;
	else
		$page = $_GET['p'];
	$page--;
	$bg = $pageSize * $page;

	$items = array_slice($items, $bg, $pageSize);
}

function get_item() {
	global $d, $item, $dm1, $dm2, $dm3;
	
	$dm1 = "";
	$dm2 = "";
	$dm3 = "";
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if ($id != "") {
		$d->SetTable("#_sanpham");	
		$d->SetWhere("id", "=", $id);
		$lstResult = $d->Select();
		if (count($lstResult) == 0) {
			header("Location: " . CUR_PATH . "?com=product&act=man" . GetParamsDm());
			exit(0);
		}
		else {
			$item = reset($lstResult);
			
			if (!isset($_GET["customselect"]) || $_GET["customselect"] != "1") {
				$pid1 = reset($d->Query("select parentid from #_nhomsp where id = '" . $item["idnhomsp"] . "'"))["parentid"];
				if ($pid1 == "0") {
					$dm1 = $item["idnhomsp"];
				}
				else {
					$pid2 = reset($d->Query("select parentid from #_nhomsp where id = '" . $pid1 . "'"))["parentid"];
					if ($pid2 == "0") {
						$dm1 = $pid1;
						$dm2 = $item["idnhomsp"];
					}
					else {
						$pid3 = reset($d->Query("select parentid from #_nhomsp where id = '" . $pid2 . "'"))["parentid"];
						if ($pid3 == "0") {
							$dm1 = $pid2;
							$dm2 = $pid1;
							$dm3 = $item["idnhomsp"];
						}
					}
				}
				
				if (isset($_GET["dm1"])) {
					$dm1 = $_GET["dm1"];
				}
				if (isset($_GET["dm2"])) {
					$dm2 = $_GET["dm2"];
				}
				if (isset($_GET["dm3"])) {
					$dm3 = $_GET["dm3"];
				}
			}
		}
	}
	else {
		header("Location: " . CUR_PATH . "?com=product&act=man" . GetParamsDm());
		exit(0);
	}
}

function save_item() {
	global $d;
	$data["idnhasx"] = 1;
	$data["ten"] = $_POST["name"];
	$data["duongdan"] = changeTitle($_POST["name"]);
	$data["gia"] = $_POST["price"];
	$data["ndtomtat"] = $_POST["summary"];
	$data["noidung"] = $_POST["detail"];
	$data["thoigiannhap"] = time();
	$data["noibat"] = $_POST["highlight"];
	$data["anhien"] = $_POST["active"];

	if (isset($_POST["selCat2"]) && $_POST["selCat2"] != "") {
		$data["idnhomsp"] = $_POST["selCat2"];
	}
	else {
		if (isset($_POST["selCat1"]) && $_POST["selCat1"] != "") {
			echo $_POST["selCat1"];
			$data["idnhomsp"] = $_POST["selCat1"];
		}
		else {
			header("Location: " . CUR_PATH . "?com=product&act=man" . GetParamsDm());
			exit(0);
		}
	}

	$id = isset($_POST["id"]) ? $_POST["id"] : "";
	if ($id != "") {	
		$d->SetTable("#_sanpham");
		$d->SetWhere("id", "=", $id);
		$result = reset($d->Select());
			
		if ($_FILES["file"]["tmp_name"] != "") {	
			$path = $result["hinh"];
			if (file_exists(SERVER_ROOT . $path)) {
				unlink(SERVER_ROOT . $path);
			}
			$data["hinh"] = "images/uploads/" . uniqid("product-") . ".jpg";
			move_uploaded_file($_FILES["file"]["tmp_name"],  SERVER_ROOT . $data["hinh"]);
			//SetWatermark($data["image"]);
		}
		
		// $subimages = array();
		// if ($_POST["curImg"] != null) {
		// 	foreach ($_POST["curImg"] as $img) {
		// 		array_push($subimages, $img);
		// 	}
		// }
		
		// if ($_FILES["multifile"]["tmp_name"][0] != "") {
		// 	foreach ($_FILES["multifile"]["tmp_name"] as $file) {
		// 		$subimage = "images/uploads/" . uniqid("subimgproduct-") . ".jpg";
		// 		array_push($subimages, $subimage);
		// 		move_uploaded_file($file,  SERVER_ROOT . $subimage);
		// 		//SetWatermark($subimage);
		// 	};
		// }
		// $data["subimages"] = json_encode($subimages);
		
		$d->SetTable("#_sanpham");
		$d->SetWhere("id", "=", $id);
		if($d->Update($data)) {

			if ($_POST["lstSerials"] != "") {	
				$lstSerials = explode(PHP_EOL, $_POST["lstSerials"]);
				
				$d->SetTable("#_khohang");
				$d->SetWhere("idsanpham", "=", $id);
				$lstCurrentSerials = $d->Select();
				
				$countlstCurrentSerials = count($lstCurrentSerials);
				for ($i = 0; $i < $countlstCurrentSerials; ++$i) {
					for ($j = $i; $j < $countlstCurrentSerials; ++$j) {
						if ($lstCurrentSerials[$i] == preg_replace("/\s+/", "", $lstSerials[$j])) {
							$lstSerials[$j] = -1;
						}
					}
				}
				
				$countlstSerials = count($lstSerials);
				for ($i = 0; $i < $countlstSerials; ++$i) {
					for ($j = $i + 1; $j < $countlstSerials; ++$j) {
						if (preg_replace("/\s+/", "", $lstSerials[$i]) == preg_replace("/\s+/", "", $lstSerials[$j])) {
							$lstSerials[$j] = -1;
						}
					}
				}
				
				$curTime = time();
				foreach ($lstSerials as $serial) {
					if ($serial != -1) {
						$insert["idsanpham"] = $id;
						$insert["trangthai"] = "1";
						$insert["serial"] = preg_replace("/\s+/", "", $serial);
						$insert["ghichu"] = "Mới thêm vào kho";
						$insert["thoigian"] = $curTime;
						$d->SetTable('#_khohang');
						$d->Insert($insert);
					}
				}
			}
			
			header("Location: " . CUR_PATH . "?com=product&act=man" . GetParamsDm());
			exit(0);
		}	
	}
	else {
		if ($_FILES["file"]["tmp_name"] != "") {
			$data["hinh"] = "images/uploads/" . uniqid("product-") . ".jpg";
			move_uploaded_file($_FILES["file"]["tmp_name"],  SERVER_ROOT . $data["hinh"]);
			//SetWatermark($data["image"]);
		}
		
		// $data["subimages"] = "[]";
		// if (($_FILES["multifile"]["tmp_name"] != "") && ($_FILES["multifile"]["tmp_name"][0] != 0)) {
		// 	$subimages = array();
		// 	foreach ($_FILES["multifile"]["tmp_name"] as $file) {
		// 		$subimage = "images/uploads/" . uniqid("subimgproduct-") . ".jpg";
		// 		array_push($subimages, $subimage);
		// 		move_uploaded_file($file,  SERVER_ROOT . $subimage);
		// 		//SetWatermark($subimage);
		// 	};
		// 	$data["subimages"] = json_encode($subimages);
		// }
		
		$d->SetTable("#_sanpham");
		if($id = $d->Insert($data)) {
			if ($_POST["lstSerials"] != "") {	
				$lstSerials = explode(PHP_EOL, $_POST["lstSerials"]);
				
				$countlstSerials = count($lstSerials);
				for ($i = 0; $i < $countlstSerials; ++$i) {
					for ($j = $i + 1; $j < $countlstSerials; ++$j) {
						if (preg_replace("/\s+/", "", $lstSerials[$i]) == preg_replace("/\s+/", "", $lstSerials[$j])) {
							$lstSerials[$j] = -1;
						}
					}
				}
				
				$curTime = time();
				foreach ($lstSerials as $serial) {
					if ($serial != -1) {
						$insert["idsanpham"] = $id;
						$insert["trangthai"] = "1";
						$insert["serial"] = preg_replace("/\s+/", "", $serial);
						$insert["ghichu"] = "Mới thêm vào kho";
						$insert["thoigian"] = $curTime;
						$d->SetTable('#_khohang');
						$d->Insert($insert);
					}
				}
			}
			
			header("Location: " . CUR_PATH . "?com=product&act=man" . GetParamsDm());
			exit(0);
		}
	}
	
	header("Location: " . CUR_PATH . "?com=product&act=man" . GetParamsDm());
	exit(0);
}

function delete_item() {
	global $d;
	
	if (isset($_GET['listid'])) {
        $ids = explode(',', $_GET['listid']);
        foreach ($ids as $id) {
			// $d->SetTable("#_sanpham");
			// $d->SetWhere("id", "=", $id);
			// $result = reset($d->Select());
			// $img = $result["hinh"];
			// $subimgs = json_decode($result["subimages"], true);
			// if (file_exists(SERVER_ROOT . $img)) {
			// 	unlink(SERVER_ROOT . $img);
			// }
			// foreach ($subimgs as $subimg) {
			// 	if (file_exists(SERVER_ROOT . $subimg)) {
			// 		unlink(SERVER_ROOT . $subimg);
			// 	}
			// }

			$d->SetTable("#_khohang");
			$d->SetWhere("idsanpham", "=", $id);
			if($d->Delete()){
				$d->SetTable("#_sanpham");
				$d->SetWhere("id", "=", $id);
				$d->Delete();
			}
	
        }
        header("Location: " . CUR_PATH . "?com=product&act=man" . GetParamsDm());
		exit(0);
    }
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if($id != ""){
		// $d->SetTable("#_sanpham");
		// $d->SetWhere("id", "=", $id);
		// $result = reset($d->Select());
		// $img = $result["image"];
		// $subimgs = json_decode($result["subimages"], true);
		// if (file_exists(SERVER_ROOT . $img)) {
		// 	unlink(SERVER_ROOT . $img);
		// }
		// foreach ($subimgs as $subimg) {
		// 	if (file_exists(SERVER_ROOT . $subimg)) {
		// 		unlink(SERVER_ROOT . $subimg);
		// 	}
		// }

		$d->SetTable("#_khohang");
		$d->SetWhere("idsanpham", "=", $id);
		if($d->Delete()){
			$d->SetTable("#_sanpham");
			$d->SetWhere("id", "=", $id);
			$d->Delete();
		}
	}
	
	header("Location: " . CUR_PATH . "?com=product&act=man" . GetParamsDm());
	exit(0);
}

?>


