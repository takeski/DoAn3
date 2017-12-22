<?php if (!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
$level = (isset($_REQUEST['level'])) ? addslashes($_REQUEST['level']) : "";
if ($level == "") {
	header("Location: " . CUR_PATH . "?com=danhmuc&act=man_cat&level=1");
	exit(0);
}

function GetParamsDm() {
	$params = "";
	
	if (isset($_GET["dm1"]) || $_GET["dm1"])
		$params .= "&dm1=" . $_GET["dm1"]; 
	if (isset($_GET["dm2"]) || $_GET["dm2"]) 
		$params .= "&dm2=" . $_GET["dm2"];
	
	return $params;
}

switch ($act) {
    case "man_cat":
        get_cats();
        $template = "danhmuc/cats";
        break;
    case "add_cat":
        $template = "danhmuc/cat_add";
        break;
    case "edit_cat":
        get_cat();
        $template = "danhmuc/cat_add";
        break;
    case "save_cat":
        save_cat();
        break;
    case "delete_cat":
        delete_cat();
        break;
    default:
        $template = "index";
}

function get_cats() {
	global $d, $level, $items, $url_link, $totalRows, $pageSize, $offset;
	

        $id_up = $_REQUEST['anhien'];
		$d->SetTable("#_nhomsp");
		$d->SetWhere("id", "=", $id_up);
        $cats = reset($d->Select());
        $anhien_cat = $cats['anhien'];
        if ($anhien_cat == 0) {
			$d->SetTable("#_nhomsp");
			$d->SetWhere("id", "=", $id_up);
			$data["anhien"] = 1;
			$d->Update($data);
        } else {
            $d->SetTable("#_nhomsp");
			$d->SetWhere("id", "=", $id_up);
			$data["anhien"] = 0;
			$d->Update($data);

		header("Location: " . CUR_PATH . "?com=danhmuc&act=man_cat&level=" . $level . GetParamsDm());
		exit(0);
    }
	
	$url_link = CUR_PATH . "?com=danhmuc&act=man_cat&level=" . $level . GetParamsDm();
	
	$dm1 = isset($_GET["dm1"]) ? $_GET["dm1"] : "";
	if ($dm1 == "") {
		$dm1 = 0;
	}
	$dm2 = isset($_GET["dm2"]) ? $_GET["dm2"] : "";
	if ($dm2 == "") {
		$dm2 = 0;
	}
	
	if ($level == 1) {
		$items = $d->Query("
			select * from #_nhomsp where parentid = 0 
		");
	}
	else if ($level == 2) {
		if ($dm1 == 0) {
			$items = $d->Query("
				select * from #_nhomsp where parentid in (
					select id from #_nhomsp where parentid = 0
				) 
			");
		}
		else {
			$items = $d->Query("
				select * from #_nhomsp where parentid = '" . $dm1 . "' 
			");
		}
	}
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

function get_cat() {
	global $d, $level, $item, $lstTypes;
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if ($id != "") {
		$d->SetTable("#_nhomsp");	
		$d->SetWhere("id", "=", $id);
		$lstResult = $d->Select();
		if (count($lstResult) == 0) {
			header("Location: " . CUR_PATH . "?com=danhmuc&act=man_cat&level=" . $level . GetParamsDm());
			exit(0);
		}
		else {
			$item = reset($lstResult);
		}
	}
	else {
		header("Location: " . CUR_PATH . "?com=danhmuc&act=man_cat&level=" . $level . GetParamsDm());
		exit(0);
	}
}

function save_cat() {
	global $d, $level;
	
	$data["ten"] = $_POST["name"];
	$data["duongdan"] = changeTitle($_POST["name"]);	
	$data["anhien"] = $_POST["active"];
	
	if ($level == 2) {		
		$idCat1 = isset($_POST["selCat1"]) ? $_POST["selCat1"] : "";
		if ($idCat1 == "") {
			header("Location: " . CUR_PATH . "?com=danhmuc&act=man_cat&level=" . $level);
			exit(0);
		}
		
		$data["parentid"] = $idCat1;
	}
	if ($level == 3) {		
		$idCat2 = isset($_POST["selCat2"]) ? $_POST["selCat2"] : "";
		if ($idCat2 == "") {
			$idCat1 = isset($_POST["selCat1"]) ? $_POST["selCat1"] : "";
			if ($idCat1 == "") {
				header("Location: " . CUR_PATH . "?com=danhmuc&act=man_cat&level=" . $level);
				exit(0);
			}
			else {
				$data["parentid"] = $idCat1;
			}
		}
		else {
			$data["parentid"] = $idCat2;
		}
	}
	
	$id = isset($_POST["id"]) ? $_POST["id"] : "";
	if ($id != "") {	

		$d->SetTable("#_nhomsp");
		$d->SetWhere("id", "=", $id);
		$d->Update($data);
	}
	else {
		$d->SetTable("#_nhomsp");
		$d->Insert($data);
	}
	
	header("Location: " . CUR_PATH . "?com=danhmuc&act=man_cat&level=" . $level . GetParamsDm());
	exit(0);
}

function delete_cat() {
	global $d, $level;
	
	if (isset($_GET['listid'])) {
        $ids = explode(',', $_GET['listid']);
        foreach ($ids as $id) {
			$d->SetTable("#_nhomsp");
			$d->SetWhere("id", "=", $id);
			$d->Delete();
        }
        header("Location: " . CUR_PATH . "?com=danhmuc&act=man_cat&level=" . $level . GetParamsDm());
		exit(0);
    }
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if ($id != "") {
		$d->SetTable("#_nhomsp");
		$d->SetWhere("id", "=", $id);
		$d->Delete();
	}
	
	header("Location: " . CUR_PATH . "?com=danhmuc&act=man_cat&level=" . $level . GetParamsDm());
	exit(0);
}

?>


