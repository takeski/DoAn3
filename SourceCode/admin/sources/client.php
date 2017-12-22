<?php if (!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

switch ($act) {
    #===================================================
    case "man":
        get_mans();
        $template = "client/items";
        break;
    case "add":
        $template = "client/item_add";
        break;
    case "edit":
        get_man();
        $template = "client/item_add";
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
	
	$d->SetTable("#_taikhoan");
	$d->SetWhere("idnhom", "=", 0);

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

    $id = isset($_GET['id']) ? $_GET['id'] : "";
    if (!$id) {
		header("Location: " . CUR_PATH . "?com=client&act=man&type=" . $type);
		exit(0);
	}
	$d->SetTable("#_taikhoan");
	$d->SetWhere("id", "=", $id);
    $lstResult = $d->Select();
	if (count($lstResult) == 0) {
		header("Location: " . CUR_PATH . "?com=client&act=man&type=" . $type);
		exit(0);
	}
	$item = reset($lstResult);
}

function save_man() {
	global $d;
	$data["tentaikhoan"] = $_POST["tentk"];
	$data["matkhau"] = sha1($_POST["pw"]);
	$data["email"] = $_POST["email"];
	$data["hoten"] = $_POST['hoten'];
    $data["sdt"] = $_POST['sdt'];
    $data["diachi"] = $_POST['dc'];
	
	$id = isset($_POST["id"]) ? $_POST["id"] : "";
	if($id != ""){		
		$d->SetTable("#_taikhoan");
		$d->SetWhere('id', "=", $id);
		$d->Update($data);
        // var_dump($d->Update($data));exit(0);
	} 
	else { // them moi	

		$d->SetTable("#_taikhoan");
		$d->Insert($data);
	}
	header("Location: " . CUR_PATH . "?com=client&act=man" );
	exit(0);
}

function delete_man()
{
    global $d;
	
	if (isset($_GET['listid'])) {
        $ids = explode(',', $_GET['listid']);
        foreach ($ids as $id) {
			$d->SetTable("#_taikhoan");
			$d->SetWhere("id", "=", $id);
			$item = reset($d->Select());
			
			if (file_exists(SERVER_ROOT . $item["hinh"])) {
				unlink(SERVER_ROOT . $item["hinh"]);
			}
			
			$d->SetTable("#baiviet");
			$d->SetWhere("id", "=", $id);
			$d->Delete();
        }
        header("Location: " . CUR_PATH . "?com=client&act=man" );
		exit(0);
    }
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if($id != "") {
		$d->SetTable("#_taikhoan");
		$d->SetWhere("id", "=", $id);
		$d->Delete();
	}
	
	header("Location: " . CUR_PATH . "?com=client&act=man");
	exit(0);
}
?>