<?php
	session_start();
	@define ( '_template' , $_SERVER['DOCUMENT_ROOT'] . '/admin/templates/');
	@define ( '_source' , $_SERVER['DOCUMENT_ROOT'] . '/admin/sources/');
	@define ( '_lib' , $_SERVER['DOCUMENT_ROOT'] . '/libraries/');
	
	//include_once _lib."config.php";
	//include_once _lib."constant.php";
	//include_once _lib."functions.php";			
	//include_once _lib."functions_giohang.php";
	//include_once _lib."library.php";
	//include_once _lib."class.database.php";		
	//$login_name = 'COMPA';	
	
	require_once(_lib . "dbhelper.php");
	
	//if((!isset($_SESSION[$login_name]) || $_SESSION[$login_name]==false) && $act!="login"){
		//redirect("index.php?com=user&act=login");
	//}
	
	$d = new DBHelper();;
	
	$do = (isset($_REQUEST['do'])) ? addslashes($_REQUEST['do']) : "";
	$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";
	
	//Kiem tra dang nhap admin
	if($do=='admin'){
		if($act=='login'){
			$username = $_POST['email'];
			$password = $_POST['pass'];

			$d->SetTable("#_taikhoan");
			$d->SetWhere("tentaikhoan", "=", $username);
			$d->SetWhere("matkhau", "=", sha1($password));
			$d->SetWhere("idnhom", "!=", 0);
			$lstResults = $d->Select();

			if(count($lstResults) == 1){
				$row = reset($lstResults);
				$data["id"] = $row["id"];
				$data["username"] = $row["tentaikhoan"];
				$_SESSION["user"] = json_encode($data);
					
				echo true;
			}
			else {
				echo false;
			}

			exit(0);
		}				
	}
		
	//Cap nhat so thu tu
	if($do=='number'){
		if($act=='update'){
			$table=addslashes($_POST['table']);
			$id=addslashes($_POST['id']);;
			$num=(int)$_POST['num'];
			$sql="update #_$table set stt='$num' where id='$id' ";
			$d->query($sql);
		}
	}
	
	//Cap nhat trang thai
	if($do=='status'){
		if($act=='update'){						
			$table=addslashes($_POST['table']);
			$id=addslashes($_POST['id']);
			$field=addslashes($_POST['field']);
			$d->reset();						
			$sql="update #_$table set $field =  where id='$id' ";
						
			$cart=array('thanhtien'=>$thanhtien,'tongtien'=>get_tong_tien($id_cart));
			echo json_encode($cart);
		}
	}
	
	//Cap nhat gio hang
	if($do=='cart'){
		if($act=='update'){						
			$id=(int)$_POST['id'];
			$sl=(int)$_POST['sl'];			
			
			$d->reset();						
			$d->query("update #_order_detail set soluong='".$sl."' where id='".$id."'");
			
			$d->reset();
			$sql="select * from #_order_detail where id='".$id."'";
			$d->query($sql);
			$result=$d->fetch_array();			
			$thanhtien=$result['gia']*$result['soluong'];
			$cart=array('thanhtien'=>$thanhtien,'tongtien'=>get_tong_tien($id_cart));
			echo json_encode($cart);
		}
	}
	
	//Xoa gio hang
	if($do=='cart'){
		if($act=='delete'){						
			$id=(int)$_POST['id'];			
			$d->reset();			
			$d->query("delete from #_order_detail where id='".$id."'");
			
			$d->reset();
			$sql="select * from #_order_detail where id='".$id."'";
			$d->query($sql);
			$result=$d->fetch_array();						
			$cart=array('tongtien'=>get_tong_tien($id_cart));
			echo json_encode($cart);
			
		}
	}
	
?>