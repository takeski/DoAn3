<?php if (!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

switch ($act) {
    #===================================================
    case "man":
        get_mans();
        $template = "baiviet/man/items";
        break;
    case "add":
	
        $template = "baiviet/man/item_add";
        break;
    case "edit":
        get_man();
        $template = "baiviet/man/item_add";
        break;
    case "save":
        save_man();
        break;
    case "delete":
        delete_man();
        break;
    #============================================================
    default:
        $template = "index";
}

#====================================

function get_mans()
{
    global $d, $items, $url_link, $totalRows, $pageSize, $offset;
	$type = $_GET['type'];
	
	$d->SetTable("#_baiviet");
	$d->SetWhere("loai", "=", $type);

	$pageSize = 10;
	$offset = 5;
	
	$page = isset($_GET['p']) ? $_GET['p'] : "";
	if ($page == "")
        $page = 1;
    else
        $page = $_GET['p'];
    $page--;
    $bg = $pageSize * $page;
	
	$d->SetLimit("$bg, $pageSize");

	$d->SetOrderBy("id desc");
	$items = $d->Select();
}


function get_man()
{
    global $d, $item ;
	$type = $_GET['type'];
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    if (!$id) {
		header("Location: " . CUR_PATH . "?com=baiviet&act=man&type=" . $type);
		exit(0);
	}
	$d->SetTable("#_baiviet");
	$d->SetWhere("loai", "=", $type);
	$d->SetWhere("id", "=", $id);
    $lstResult = $d->Select();
	if (count($lstResult) == 0) {
		header("Location: " . CUR_PATH . "?com=baiviet&act=man&type=" . $type);
		exit(0);
	}
	$item = reset($lstResult);
}

function save_man() {
	global $d;
	$type = $_GET['type'];
	$data["ten"] = $_POST["name"];
	$data["stt"] = $_POST["stt"];
	$data["duongdan"] = changeTitle($_POST["name"]);	
	$data["ndtomtat"] = $_POST["summary"];
	$data["noidung"] = $_POST["content"];
	$data["loai"] = $_GET['type'];
	$data["thoigiandang"] = time();
	
	$id = isset($_POST["id"]) ? $_POST["id"] : "";

	if($id != ""){		

		$d->SetTable("#_baiviet");
		$d->SetWhere("id", "=", $id);
		$path = reset($d->Select("hinh"))["hinh"];
		if (file_exists(SERVER_ROOT . $path)) {
			unlink(SERVER_ROOT . $path);
		}
		$data["hinh"] = "images/uploads/" . uniqid("ads" . $data["loai"] . "-") .  ".jpg";
		move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
		
		$d->SetTable("#_baiviet");
		$d->SetWhere('id', "=", $id);
		$d->Update($data);
	} 
	else { // them moi	
		$data["hinh"] = "images/uploads/" . uniqid("ads" . $data["loai"] . "-") .  ".jpg";
		move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
		$d->SetTable("#_baiviet");
		$d->Insert($data);
	}
	header("Location: " . CUR_PATH . "?com=baiviet&act=man&type=" . $type);
	exit(0);
}

function delete_man()
{
    global $d;
	$type = $_GET['type'];
	
	if (isset($_GET['listid'])) {
        $ids = explode(',', $_GET['listid']);
        foreach ($ids as $id) {
			$d->SetTable("#_baiviet");
			$d->SetWhere("id", "=", $id);
			$item = reset($d->Select());
			
			if (file_exists(SERVER_ROOT . $item["hinh"])) {
				unlink(SERVER_ROOT . $item["hinh"]);
			}
			
			$d->SetTable("#baiviet");
			$d->SetWhere("id", "=", $id);
			$d->Delete();
        }
        header("Location: " . CUR_PATH . "?com=baiviet&act=man&type=" . $type);
		exit(0);
    }
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if($id != "") {
		$d->SetTable("#_baiviet");
		$d->SetWhere("id", "=", $id);
		$d->Delete();
	}
	
	header("Location: " . CUR_PATH . "?com=baiviet&act=man&type=" . $type);
	exit(0);
}
?>