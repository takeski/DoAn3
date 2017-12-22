<?php	if(!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

switch($act){
	case "dsbannerqc":
		get_banners();
		$template = "bannerqc/photos";
		break;
	case "thembannerqc":
		$template = "bannerqc/photo_add";
		break;
	case "capnhatbannerqc":
		get_banner();
		$template = "bannerqc/photo_add";
		break;
	case "delete_bannerqc":
		delete_bannerqc();
		break;
	case "capnhatlogo":
		get_logo();
		$template = "bannerqc/logo_add";
		break;
	case "save_bannerqc":	
		save_bannerqc();
		break;
	case "savebanner":
		save_banner();
		break;
	case "savelogo":
		save_logo();
		break;
	#====================================
	
	default:
		$template = "index";
}


function get_logo(){
	global $d, $item;
	
    if ($_GET['type'] == "logo") {
		$d->SetTable("#_hinhanh");
		$d->SetWhere("loai", "=", "logo");
		$item = reset($d->Select());
	}
	else if ($_GET['type'] == "favicon") {
		$d->SetTable("#_hinhanh");
		$d->SetWhere("loai", "=", "favicon");
		$item = reset($d->Select());
	}
}

function save_logo(){
	global $d;
	if ($_REQUEST["type"] == "logo") {
		$d->SetTable("#_hinhanh");
		$d->SetWhere("loai", "=", "logo");
		$item = reset($d->Select());
		$id = $item['id'];
		
		if($id != ""){
			if ($_FILES["file"]["tmp_name"] != "") {
				if (file_exists(SERVER_ROOT . $item["hinh"])) {
					unlink(SERVER_ROOT . $item["hinh"]);
				}
				$data["hinh"] = "images/logo/" . uniqid("logo") . ".png";
				move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
				
				$d->SetTable("#_hinhanh");
				$d->SetWhere('loai', "=", "logo");
				$d->Update($data);
			}
		} 
		else { // them moi
			if ($_FILES["file"]["tmp_name"] != "") {
				$data["hinh"] = "images/logo/" . uniqid("logo") . ".png";
				if (file_exists(SERVER_ROOT . $data["hinh"])) {
					unlink(SERVER_ROOT . $data["hinh"]);
				}
				move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
				
				$d->SetTable("#_hinhanh");
				$data["loai"] = "logo";
				$d->Insert($data);
			}
		}
		
		header("Location: " . CUR_PATH . "?com=bannerqc&act=capnhatlogo&type=".$_GET['type']);
		exit(0);
	}
	else if ($_REQUEST["type"] == "favicon") {
		$d->SetTable("#_hinhanh");
		$d->SetWhere("loai", "=", "favicon");
		$item = reset($d->Select());
		$id = $item['id'];
		
		if($id != ""){
			if ($_FILES["file"]["tmp_name"] != "") {
				if (file_exists(SERVER_ROOT . $item["hinh"])) {
					unlink(SERVER_ROOT . $item["hinh"]);
				}
				$data["hinh"] = "images/logo/" . uniqid("favicon") . ".png";
				move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
				
				$d->SetTable("#_hinhanh");
				$d->SetWhere('loai', "=", "favicon");
				$d->Update($data);
			}
		} 
		else { // them moi
			if ($_FILES["file"]["tmp_name"] != "") {
				$data["hinh"] = "images/logo/" . uniqid("favicon") . ".png";
				if (file_exists(SERVER_ROOT . $data["hinh"])) {
					unlink(SERVER_ROOT . $data["hinh"]);
				}
				move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
				
				$d->SetTable("#_hinhanh");
				$data["loai"] = "favicon";
				$d->Insert($data);
			}
		}
		
		header("Location: " . CUR_PATH . "?com=bannerqc&act=capnhatlogo&type=".$_GET['type']);
		exit(0);
	}
}

function get_banners(){
	global $d, $items, $url_link, $totalRows, $pageSize, $offset;
	
	if ($_REQUEST['anhien'] != '') {
        $id_up = $_REQUEST['anhien'];
		$d->SetTable("#_quangcao");
		$d->SetWhere("id", "=", $id_up);
        $cats = reset($d->Select());
        $anhien_slider = $cats['anhien'];
        if ($anhien_slider == 0) {
			$d->SetTable("#_quangcao");
			$d->SetWhere("id", "=", $id_up);
			$data["anhien"] = 1;
			$d->Update($data);
        } else {
            $d->SetTable("#_quangcao");
			$d->SetWhere("id", "=", $id_up);
			$data["anhien"] = 0;
			$d->Update($data);
        }
		
		header("Location: " . CUR_PATH . "?com=bannerqc&act=dsbannerqc");
		exit(0);
    }
	
	$d->SetTable("#_quangcao");
	$count = reset($d->Select("count(id) as numrows"));
	
	$url_link = CUR_PATH . "?com=bannerqc&act=dsbannerqc";
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
	
    $d->SetTable("#_quangcao");
	$d->SetLimit("$bg, $pageSize");
	$items = $d->Select();
}

function get_banner(){
	global $d, $item;
   
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if ($id && $id != "") {
		$d->SetTable("#_quangcao");
		$d->SetWhere("id", "=", $id);
		$lstResult = $d->Select();
		
		if (count($lstResult) != 0) {
			$item = reset($lstResult);
		}
		else {
			header("Location: " . CUR_PATH . "?com=bannerqc&act=dsbannerqc");
			exit(0);
		}
	}
	else {
		header("Location: " . CUR_PATH . "?com=bannerqc&act=dsbannerqc");
		exit(0);
	}
}

function save_bannerqc() {
	global $d;
	
	$data["ten"] = $_POST["name"];
	$data["duongdan"] = $_POST["link"];
	$data["loai"] = $_POST["bannerlocation"];
	$data["anhien"] = $_POST["active"];
	
	$id = isset($_POST["id"]) ? $_POST["id"] : "";
	if($id != ""){		
		if ($_FILES["file"]["tmp_name"] != "") {
			$d->SetTable("#_quangcao");
			$d->SetWhere("id", "=", $id);
			$path = reset($d->Select("hinh"))["hinh"];
			if (file_exists(SERVER_ROOT . $path)) {
				unlink(SERVER_ROOT . $path);
			}
			$data["hinh"] = "images/uploads/" . uniqid("ads" . $data["loai"] . "-") .  ".jpg";
			move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
		}
		
		$d->SetTable("#_quangcao");
		$d->SetWhere('id', "=", $id);
		$d->Update($data);
	} 
	else { // them moi	
		if ($_FILES["file"]["tmp_name"] != "") {
			$data["hinh"] = "images/uploads/" . uniqid("ads" . $data["loai"] . "-") .  ".jpg";
			move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["hinh"]);
		}
		$d->SetTable("#_quangcao");
		$d->Insert($data);
	}
		
	header("Location: " . CUR_PATH . "?com=bannerqc&act=dsbannerqc");
	exit(0);
}

function delete_bannerqc() {
	global $d;
	
	if (isset($_GET['listid'])) {
        $ids = explode(',', $_GET['listid']);
        foreach ($ids as $id) {
			$d->SetTable("#_quangcao");
			$d->SetWhere("id", "=", $id);
			$path = reset($d->Select("hinh"))["hinh"];
			if (file_exists(SERVER_ROOT . $path)) {
				unlink(SERVER_ROOT . $path);
			}
			$d->SetTable("#_quangcao");
			$d->SetWhere("id", "=", $id);
			$d->Delete();
        }
        header("Location: " . CUR_PATH . "?com=bannerqc&act=dsbannerqc");
		exit(0);
    }
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if($id && $id != ""){
		$d->SetTable("#_quangcao");
		$d->SetWhere("id", "=", $id);
		$path = reset($d->Select("hinh"))["hinh"];
		if (file_exists(SERVER_ROOT . $path)) {
			unlink(SERVER_ROOT . $path);
		}
		$d->SetTable("#_quangcao");
		$d->SetWhere('id', "=", $id);
		$d->Delete();
	}
	
	header("Location: " . CUR_PATH . "?com=bannerqc&act=dsbannerqc");
	exit(0);
}

function save_banner(){
	global $d;
	$file_name=images_name($_FILES['file']['name']);
    // define('_upload_hinhanh','../users/images/');
    $tb = $_GET['type'];
    $sql = "select * from tbl_banner";
	$d->query($sql);
	$item = $d->fetch_array();
	$id=$item['id'];
	$data['hinh']=$_POST['imgHientai'];
    $data['anhien'] = isset($_POST['anhien']) ? 1 : 0;
    if($id){
        if($photo = upload_image("file", 'jpg|png|gif|JPG|jpeg|JPEG', '../','public/images/background/',$file_name)){
            $data['hinh'] = $photo;
		}

		$d->setTable($tb);
		$d->setWhere('id', "=", $id);
		if($d->update($data))
			redirect("index.php?com=bannerqc&act=capnhatbanner&type=".$_GET['type']."");
		else
			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=bannerqc&act=capnhatbanner&type=".$_GET['type']."");
	}else{ // them moi

		if($photo = upload_image("file", 'Jpg|jpg|png|gif|JPG|jpeg|JPEG','../public/images/background/',$file_name)){
			$data['hinh'] = $photo;
        }
		$d->setTable($tb);
		if($d->insert($data))
		redirect("index.php?com=bannerqc&act=capnhatbanner&type=".$_GET['type']."");
		else
			transfer("Lưu dữ liệu bị lỗi", "index.php?com=bannerqc&act=capnhatbanner&type=".$_GET['type']."");

    }
}

?>