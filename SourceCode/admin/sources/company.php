<?php	if(!defined('_source')) die("Error");
$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
switch($act){
	// case "capnhat":
	// 	get_company();
	// 	$template = "company/item_add";
	// 	break;
	// case "save":
	// 	save_company();
	// 	break;		
	case "capnhat_lh":
		get_lh();
		$template = "company/lienhe";
		break;
	case "save_lh":
		save_lh();
		break;
	default:
		$template = "index";
}
	if($_GET['type']=='lienhe'){
		$title_main = 'liên Hệ';
	}elseif($_GET['type']=='footer'){
		$title_main = 'footer';
	}


// function get_company(){
// 	global $d, $item;
// 	$type = $_GET['type'];
// 	$sql = "select * from #_ttcongty limit 0,1";
// 	$d->query($sql);
// 	$item = $d->fetch_array();
	
// }

// function save_company(){
// 	global $d, $com;
// 	$d->reset();
//     $com = $_GET['com'];
//     $type = $_GET['type'];
//     if($type == 'footer'){
//         $tb = 'ttcongty';
//     }
//     else{
//         $tb = 'ttcongty';
//     }

// 	$type = $_GET['type'];

//     $data['ten'] = $_POST['ten'];
//     $data['diachi'] = $_POST['diachi'];
//     $data['sdt'] = $_POST['sdt'];

//     $data['hotline'] = $_POST['hotline'];
//     $data['email'] = $_POST['email'];
//     $data['facebook'] = $_POST['facebook'];
//     $data['noidung'] = $_POST['noidung_vi'];

//     $data['keyt'] = $_POST['keyt'];
//     $data['keyw'] = $_POST['keyw'];
//     $data['keyd'] = $_POST['keyd'];

//     $d->setTable($tb);
//     $d->setWhere('id',1);
//     if($d->update($data))
//         redirect("index.php?com=".$com."&act=capnhat&type=".$type);
//     else
//         transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=".$com."&act=capnhat&type=".$type);
// 	/*if(count($row_item )>0){

		
// 		if($photo = upload_image("img", 'jpg|png|gif|JPG|jpeg|JPEG', _upload_company,$file_name)){
// 			$data['photo'] = $photo;	
// 			$data['thumb'] = create_thumb($data['photo'], 295, 195, _upload_company,$file_name,1);		
// 			$d->setTable('baiviet');
// 			$d->setWhere('id', $id);
// 			$d->select();
// 			if($d->num_rows()>0){
// 				$row = $d->fetch_array();
// 				delete_file(_upload_company.$row['photo']);	
// 				delete_file(_upload_company.$row['thumb']);				
// 			}
// 		}


// 		$d->setTable($tb);
// 		if($d->update($data))
// 			redirect("index.php?com=company&act=capnhat&curPage=".$_REQUEST['curPage']."&type=".$_GET['type']);
// 		else
// 			transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=company&act=capnhat&type=".$_GET['type']);
// 	}
// 	else{
// 		if($photo = upload_image("img", 'jpg|png|gif|JPG|jpeg|JPEG', _upload_company,$file_name)){
// 			$data['photo'] = $photo;		
// 			$data['thumb'] = create_thumb($data['photo'], 295, 195, _upload_company,$file_name,1);		
// 		}		

// 		$data['ten_vi'] = $_POST['ten_vi'];
// 		$data['tenkhongdau'] = changeTitle($_POST['ten_vi']);
// 		$data['mota_vi'] = $_POST['mota_vi'];
// 		$data['noidung_vi'] = magic_quote($_POST['noidung_vi']);	

// 		$data['ten_en'] = $_POST['ten_en'];
// 		$data['mota_en'] = $_POST['mota_en'];
// 		$data['noidung_en'] = magic_quote($_POST['noidung_en']);
// 		$data['type'] = $_GET['type'];

// 		$data['title'] = $_POST['title'];
// 		$data['keywords'] = $_POST['keywords'];
// 		$data['description'] = $_POST['description'];
				
// 		$data['hienthi'] = isset($_POST['hienthi']) ? 1 : 0;

// 		$data['ngaytao'] = time();
// 		$d->setTable('ttcongty');
// 		if($d->insert($data))
// 		{			
// 			redirect("index.php?com=company&act=capnhat&type=".$_GET['type']);
// 		}
// 		else
// 			transfer("Lưu dữ liệu bị lỗi", "index.php?com=company&act=capnhat&type=".$_GET['type']);
// 	}*/
// }
function get_lh(){
	global $d, $item;
	$sql = "select * from tbl_ttcongty limit 0,1";
	$d->query($sql);
	$item = $d->fetch_array();

}

function save_lh(){
	global $d, $com;
	$d->reset();

    $data['diachi'] = $_POST['diachi'];
	$data['hotline1'] = $_POST['hotline1'];
	$data['hotline2'] = $_POST['hotline2'];

    $d->setTable('ttcongty');
    $d->setWhere('id',1);
    if($d->update($data))
        redirect("index.php?com=company&act=capnhat_lh");
    else
        transfer("Cập nhật dữ liệu bị lỗi", "index.php?com=company&act=capnhat_lh");
}

?>