<?php	if(!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

switch($act){
	case "man_slides":
		get_slides();
		$template = "slides/photos";
		break;
	case "add_slide":
		$template = "slides/photo_add";
		break;
	case "edit_slide":
		get_slide();
		$template = "slides/photo_add";
		break;
	case "delete_slide":
		delete_slide();
		break;
	case "save_slide":
		save_slide();
		break;
	#====================================
	
	default:
		$template = "index";
}

function get_slides(){
	global $d, $items, $url_link, $totalRows, $pageSize, $offset;
	
	if ($_REQUEST['anhien'] != '') {
        $id_up = $_REQUEST['anhien'];
		$d->SetTable("#_sliders");
		$d->SetWhere("id", "=", $id_up);
        $cats = reset($d->Select());
        $anhien_slider = $cats['anhien'];
        if ($anhien_slider == 0) {
			$d->SetTable("#_sliders");
			$d->SetWhere("id", "=", $id_up);
			$data["anhien"] = 1;
			$d->Update($data);
        } else {
            $d->SetTable("#_sliders");
			$d->SetWhere("id", "=", $id_up);
			$data["anhien"] = 0;
			$d->Update($data);
        }
		
		header("Location: " . CUR_PATH . "?com=slides&act=man_slides");
		exit(0);
    }
	
	$d->SetTable("#_sliders");
	$d->SetOrderBy("stt");
	$count = reset($d->Select("count(id) as numrows"));
	
	$url_link = CUR_PATH . "?com=slides&act=man_slides";
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
	
    $d->SetTable("#_sliders");
	$d->SetOrderBy("stt");
	$d->SetLimit("$bg, $pageSize");
	$items = $d->Select();
}

function get_slide(){
	global $d, $item;
   
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if ($id != "") {
		$d->SetTable("#_sliders");
		$d->SetWhere("id", "=", $id);
		$lstResult = $d->Select();
		
		if (count($lstResult) != 0) {
			$item = reset($lstResult);
		}
		else {
			header("Location: " . CUR_PATH . "?com=slides&act=man_slides");
			exit(0);
		}
	}
	else {
		header("Location: " . CUR_PATH . "?com=slides&act=man_slides");
		exit(0);
	}
}

function save_slide() {
	global $d;
	
	$data["ten"] = $_POST["name"];
	$data["duongdan"] = $_POST["link"];
	$data["anhien"] = $_POST["active"];
	$data["stt"] = $_POST["stt"];
	
	$id = isset($_POST["id"]) ? $_POST["id"] : "";
	if($id != ""){		
		if ($_FILES["file"]["tmp_name"] != "") {
			$d->SetTable("#_sliders");
			$d->SetWhere("id", "=", $id);
			$path = reset($d->Select("hinh"))["hinh"];
			if (file_exists(SERVER_ROOT . $path)) {
				unlink(SERVER_ROOT . $path);
			}
			$data["hinh"] = "images/uploads/" . uniqid("slide-") .  ".jpg";
			move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
		}
		
		$d->SetTable("#_sliders");
		$d->SetWhere('id', "=", $id);
		$d->Update($data);
	} 
	else { // them moi
		if ($_FILES["file"]["tmp_name"] != "") {
			$data["hinh"] = "images/uploads/" . uniqid("slide-") .  ".jpg";
			move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
		}
		$d->SetTable("#_sliders");
		$d->Insert($data);
	}
		
	header("Location: " . CUR_PATH . "?com=slides&act=man_slides");
	exit(0);
}

function delete_slide() {
	global $d;
	
	if (isset($_GET['listid'])) {
        $ids = explode(',', $_GET['listid']);
        foreach ($ids as $id) {
			$d->SetTable("#_sliders");
			$d->SetWhere("id", "=", $id);
			$path = reset($d->Select("hinh"))["hinh"];
			if (file_exists(SERVER_ROOT . $path)) {
				unlink(SERVER_ROOT . $path);
			}
			$d->SetTable("#_sliders");
			$d->SetWhere("id", "=", $id);
			$d->Delete();
        }
        header("Location: " . CUR_PATH . "?com=slides&act=man_slides");
		exit(0);
    }
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if($id != ""){
		$d->SetTable("#_sliders");
		$d->SetWhere("id", "=", $id);
		$path = reset($d->Select("hinh"))["hinh"];
		if (file_exists(SERVER_ROOT . $path)) {
			unlink(SERVER_ROOT . $path);
		}
		$d->SetTable("#_sliders");
		$d->SetWhere('id', "=", $id);
		$d->Delete();
	}
	
	header("Location: " . CUR_PATH . "?com=slides&act=man_slides");
	exit(0);
}

?>