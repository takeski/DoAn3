<?php	if(!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

switch($act){
	case "man":
		get_items();
		$template = "mxh/items";
		break;
	case "add":
		$template = "mxh/item_add";
		break;
	case "edit":
		get_item();
		$template = "mxh/item_add";
		break;
	case "delete":
		delete_item();
		break;
	case "save":
		save_item();
		break;
	#====================================
	
	default:
		$template = "index";
}

function get_items(){
	global $d, $items, $url_link, $totalRows, $pageSize, $offset;
	
	if ($_REQUEST['anhien'] != '') {
        $id_up = $_REQUEST['anhien'];
		$d->SetTable("#_mangxahoi");
		$d->SetWhere("id", "=", $id_up);
        $cats = reset($d->Select());
        $anhien_mxh = $cats['anhien'];
        if ($anhien_mxh == 0) {
			$d->SetTable("#_mangxahoi");
			$d->SetWhere("id", "=", $id_up);
			$data["anhien"] = 1;
			$d->Update($data);
        } else {
            $d->SetTable("#_mangxahoi");
			$d->SetWhere("id", "=", $id_up);
			$data["anhien"] = 0;
			$d->Update($data);
        }
		
		header("Location: " . CUR_PATH . "?com=mxh&act=man");
		exit(0);
    }
	
	$d->SetTable("#_mangxahoi");
	$count = reset($d->Select("count(id) as numrows"));
	
	$url_link = CUR_PATH . "?com=mxh&act=man";
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
	
    $d->SetTable("#_mangxahoi");
	$d->SetLimit("$bg, $pageSize");
	$items = $d->Select();
}

function get_item(){
	global $d, $item;
   
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if ($id && $id != "") {
		$d->SetTable("#_mangxahoi");
		$d->SetWhere("id", "=", $id);
		$lstResult = $d->Select();
		
		if (count($lstResult) != 0) {
			$item = reset($lstResult);
		}
		else {
			header("Location: " . CUR_PATH . "?com=mxh&act=man");
			exit(0);
		}
	}
	else {
		header("Location: " . CUR_PATH . "?com=mxh&act=man");
		exit(0);
	}
}

function save_item() {
	global $d;
	
	$data["ten"] = $_POST["name"];
	$data["duongdan"] = $_POST["link"];
	$data["anhien"] = $_POST["active"];
	
	$id = isset($_POST["id"]) ? $_POST["id"] : "";
	if($id != ""){
		if ($_FILES["file"]["tmp_name"] != "") {
			$d->SetTable("#_mangxahoi");
			$d->SetWhere("id", "=", $id);
			$path = reset($d->Select("hinh"))["hinh"];
			if (file_exists(SERVER_ROOT . $path)) {
				unlink(SERVER_ROOT . $path);
			}
			$data["hinh"] = "images/uploads/" . uniqid("mxh-") .  ".jpg";
			move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
		}
		
		$d->SetTable("#_mangxahoi");
		$d->SetWhere('id', "=", $id);
		$d->Update($data);
	} 
	else { // them moi
		if ($_FILES["file"]["tmp_name"] != "") {
			$data["hinh"] = "images/uploads/" . uniqid("mxh-") .  ".jpg";
			move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
		}
		$d->SetTable("#_mangxahoi");
		$d->Insert($data);
	}
		
	header("Location: " . CUR_PATH . "?com=mxh&act=man");
	exit(0);
}

function delete_item() {
	global $d;
	
	if (isset($_GET['listid'])) {
        $ids = explode(',', $_GET['listid']);
        foreach ($ids as $id) {
			$d->SetTable("#_mangxahoi");
			$d->SetWhere("id", "=", $id);
			$path = reset($d->Select("hinh"))["hinh"];
			if (file_exists(SERVER_ROOT . $path)) {
				unlink(SERVER_ROOT . $path);
			}
			$d->SetTable("#_mangxahoi");
			$d->SetWhere("id", "=", $id);
			$d->Delete();
        }
        header("Location: " . CUR_PATH . "?com=mxh&act=man");
		exit(0);
    }
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if($id != ""){
		$d->SetTable("#_mangxahoi");
		$d->SetWhere("id", "=", $id);
		$path = reset($d->Select("hinh"))["hinh"];
		if (file_exists(SERVER_ROOT . $path)) {
			unlink(SERVER_ROOT . $path);
		}
		$d->SetTable("#_mangxahoi");
		$d->SetWhere('id', "=", $id);
		$d->Delete();
	}
	
	header("Location: " . CUR_PATH . "?com=mxh&act=man");
	exit(0);
}

?>