<?php if(!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

switch($act){
	case "capnhat":
		get_gioithieu();
		$template = "setting/item_add";
		break;
	case "save":
		save_gioithieu();
		break;
		
	default:
		$template = "index";
}

function get_gioithieu(){
	global $d, $item;
	$d->SetTable("#_thongtin");
	$d->SetLimit("1");
	$item = reset($d->Select());
}

function save_gioithieu(){
	global $d;

	$data['ten'] = $_POST['websiteowner'];
	$data['emailcty'] = $_POST['email'];
	$data['emailgui'] = $_POST['email'];
	$data['matkhauemail'] = $_POST['emailpassword'];
	$data['diachi'] = $_POST['address'];	
	$data['slogan'] = $_POST['slogan'];
	$data['sdt'] = $_POST['phonenumber'];
	$data['hotline'] = $_POST['hotline'];
	$data['location'] = $_POST['location'];
	$data['linkweb'] = $_POST['linkwebsite'];
	// $data['title'] = $_POST['title'];
	// $data['keywords'] = $_POST['keywords'];
	// $data['description'] = $_POST['description'];
	// $data['analytics'] = $_POST['analytics'];
	// $data['vchat'] = $_POST['vchat'];
	// $data['meta'] = $_POST['meta'];
	// $data['scripttop'] = $_POST['scripttop'];
	// $data['scriptbottom'] = $_POST['scriptbottom'];
	
	$d->SetTable("#_thongtin");
	$item = reset($d->Select());
	$id = $item['id'];
	
	if($id){		
		if ($_FILES["file"]["tmp_name"] != "") {
			$d->SetTable("#_thongtin");
			$d->SetWhere("id", "=", $id);
			$path = reset($d->Select("stamp"))["stamp"];
			if (file_exists(SERVER_ROOT . $path)) {
				unlink(SERVER_ROOT . $path);
			}
			$data["stamp"] = "images/uploads/" . uniqid("stamp-") .  ".png";
			move_uploaded_file($_FILES["file"]["tmp_name"], SERVER_ROOT . $data["stamp"]);
		}
		
		$d->SetTable('#_thongtin');
		$d->SetWhere('id', "=", $id);
		if($d->Update($data)) {
            header("Location: " . CUR_PATH . "?com=setting&act=capnhat");
			exit(0);
		}
        else {
			//$_SESSION["error"] = "Dữ liệu cập nhật bị lỗi!";
			header("Location: " . CUR_PATH . "?com=setting&act=capnhat");
			exit(0);
		}
	}
}

?>