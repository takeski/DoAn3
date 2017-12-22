<?php	if(!defined('_source')) die("Error");
    switch($act){
        case "login":
            if(!empty($_POST)) {
				login();
			} 
			$template = "user/login";
			break;
		case "admin_edit":			
			edit();
			$template = "user/admin_add";
			break;
        case "logout":
            logout();
            break;
        #===================================================
        case "man_cat":
			if (!ck_per("pqqt", "r")) {
				echo "<script>
						alert('Bạn không có quyền thực hiện chức năng này!');
						window.location.href = '" . CUR_PATH . "';
					</script>";
				exit(0);
			}
			
            get_cats();
            $template = "user/cats";
            break;
        case "add_cat":
			if (!ck_per("pqqt", "c")) {
				echo "<script>
						alert('Bạn không có quyền thực hiện chức năng này!');
						window.location.href = '" . CUR_PATH . "';
					</script>";
				exit(0);
			}
		
            $template = "user/cat_add";
            break;
        case "edit_cat":
			if (!ck_per("pqqt", "u")) {
				echo "<script>
						alert('Bạn không có quyền thực hiện chức năng này!');
						window.location.href = '" . CUR_PATH . "';
					</script>";
				exit(0);
			}
		
            get_cat();
            $template = "user/cat_add";
            break;
        case "save_cat":
            save_cat();
            break;
        case "delete_cat":
			if (!ck_per("pqqt", "d")) {
				echo "<script>
						alert('Bạn không có quyền thực hiện chức năng này!');
						window.location.href = '" . CUR_PATH . "';
					</script>";
				exit(0);
			}
		
            delete_cat();
            break;
        case "man":
			if (!ck_per("pqqt", "r")) {
				echo "<script>
						alert('Bạn không có quyền thực hiện chức năng này!');
						window.location.href = '" . CUR_PATH . "';
					</script>";
				exit(0);
			}
		
            get_items();
            $template = "user/items";
            break;
        case "add":
			if (!ck_per("pqqt", "c")) {
				echo "<script>
						alert('Bạn không có quyền thực hiện chức năng này!');
						window.location.href = '" . CUR_PATH . "';
					</script>";
				exit(0);
			}
		
            $template = "user/item_add";
            break;
        case "edit":
			if (!ck_per("pqqt", "u")) {
				echo "<script>
						alert('Bạn không có quyền thực hiện chức năng này!');
						window.location.href = '" . CUR_PATH . "';
					</script>";
				exit(0);
			}
			
            get_item();
            $template = "user/item_add";
            break;
        case "save":
            save_item();
            break;
        case "delete":
			if (!ck_per("pqqt", "d")) {
				echo "<script>
						alert('Bạn không có quyền thực hiện chức năng này!');
						window.location.href = '" . CUR_PATH . "';
					</script>";
				exit(0);
			}
		
            delete_item();
            break;
        default:
            $template = "index";
    }

//////////////////
function get_cats(){
    global $d, $items, $url_link, $totalRows, $pageSize, $offset;
	
	$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
	
	$d->SetTable("#_groups");
	if ($keyword != "") {
		$d->SetWhere("name", "like", "%$keyword%");
	}
	$count = reset($d->Select("count(id) as numrows"));
	
	if ($keyword != "") {
		$url_link = CUR_PATH . "?com=user&act=man_cat&keyword=" . $keyword;
	}
	else {
		$url_link = CUR_PATH . "?com=user&act=man_cat";
	}
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
	
	$d->SetTable("#_groups");
	if ($keyword != "") {
		$d->SetWhere("name", "like", "%$keyword%");
	}
	$d->SetLimit("$bg, $pageSize");
	$items = $d->Select();

}

function get_cat(){
    global $d, $items;
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    if($id == "") {
		header("Location: " . CUR_PATH . "?com=user&act=man_cat");
		exit(0);
	}
	
	$items = $d->Query("
		select g.id as groupid, g.name as groupname, a.accessgrant as accessgrant 
		from #_groups g left join #_accesscontrollists a on g.id = a.groupid
		where g.id = '" . $id . "' 
		order by a.moid
	");
}

function save_cat(){
    global $d;
	
	$d->SetTable("#_managementobjects");
	$managementobjects = $d->Select();
	
	$id = isset($_POST["id"]) ? $_POST["id"] : "";
	if ($id == "") { // thêm
		if (!ck_per("pqqt", "c")) {
			echo "<script>
					alert('Bạn không có quyền thực hiện chức năng này!');
					window.location.href = '" . CUR_PATH . "';
				</script>";
			exit(0);
		}
		
		if ($_POST["name"] == "") {
			header("Location: " . CUR_PATH . "?com=user&act=man_cat");
			exit(0);
		}
		
		$add["name"] = $_POST["name"];
		$add["accessgrant"] = "[1,1,1,1]";
		$d->SetTable("#_groups");
		$newgid = $d->Insert($add);
		
		foreach ($managementobjects as $managementobject) {
			$accessgrants = array();
			
			$read = isset($_POST["r" . $managementobject["id"]]) ? 1 : 0;
			$create = isset($_POST["c" . $managementobject["id"]]) ? 1 : 0;
			$update = isset($_POST["u" . $managementobject["id"]]) ? 1 : 0;
			$delete = isset($_POST["d" . $managementobject["id"]]) ? 1 : 0;
			
			array_push($accessgrants, $read);
			array_push($accessgrants, $create);
			array_push($accessgrants, $update);
			array_push($accessgrants, $delete);
			
			$data["moid"] = $managementobject["id"];
			$data["accessgrant"] = json_encode($accessgrants);
			$data["groupid"] = $newgid;
			
			$d->SetTable("#_accesscontrollists");
			$d->Insert($data);
		}
	}
	else {
		if (!ck_per("pqqt", "u")) {
			echo "<script>
					alert('Bạn không có quyền thực hiện chức năng này!');
					window.location.href = '" . CUR_PATH . "';
				</script>";
			exit(0);
		}
		
		$d->SetTable("#_groups");
		$d->SetWhere("id", "=", $id);
		$lstResult = $d->Select();
		
		if (count($lstResult) == 0) {
			header("Location: " . CUR_PATH . "?com=user&act=man_cat");
			exit(0);
		}
		
		$edit["name"] = $_POST["name"];
		$d->SetTable("#_groups");
		$d->SetWhere("id", "=", $id);
		$d->Update($edit);
		
		$d->SetTable("#_accesscontrollists");
		$d->SetWhere("groupid", "=", $id);
		$d->Delete();
		
		foreach ($managementobjects as $managementobject) {
			$accessgrants = array();
			
			$read = isset($_POST["r" . $managementobject["id"]]) ? 1 : 0;
			$create = isset($_POST["c" . $managementobject["id"]]) ? 1 : 0;
			$update = isset($_POST["u" . $managementobject["id"]]) ? 1 : 0;
			$delete = isset($_POST["d" . $managementobject["id"]]) ? 1 : 0;
			
			array_push($accessgrants, $read);
			array_push($accessgrants, $create);
			array_push($accessgrants, $update);
			array_push($accessgrants, $delete);
			
			$data["moid"] = $managementobject["id"];
			$data["accessgrant"] = json_encode($accessgrants);
			$data["groupid"] = $id;
			
			$d->SetTable("#_accesscontrollists");
			$d->Insert($data);
		}
	}
	
	header("Location: " . CUR_PATH . "?com=user&act=man_cat");
	exit(0);
}

function delete_cat(){
    global $d;
	
	if (isset($_GET['listid'])) {
        $ids = explode(',', $_GET['listid']);
        foreach ($ids as $id) {
			$d->SetTable("#_groups");
			$d->SetWhere("id", "=", $id);
			$d->Delete();
			
			$d->SetTable("#_accesscontrollists");
			$d->SetWhere("groupid", "=", $id);
			$d->Delete();
        }
        header("Location: " . CUR_PATH . "?com=user&act=man_cat");
		exit(0);
    }

	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	if ($id != "") {
		$d->SetTable("#_groups");
		$d->SetWhere("id", "=", $id);
		$d->Delete();
		
		$d->SetTable("#_accesscontrollists");
		$d->SetWhere("groupid", "=", $id);
		$d->Delete();
	}	
	
	header("Location: " . CUR_PATH . "?com=user&act=man_cat");
	exit(0);
}

function get_items(){
    global $d, $items, $url_link, $totalRows, $pageSize, $offset;
	
	$keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
	
	$d->SetTable("#_accounts");
	$d->SetWhere("groupid", "!=", 0);
	if ($keyword != "") {
		$d->SetWhere("username", "like", "%$keyword%");
		$d->SetWhereOr("fullname", "like", "%$keyword%");
		$d->SetWhereOr("email", "like", "%$keyword%");
	}
	$count = reset($d->Select("count(id) as numrows"));
	
	if ($keyword != "") {
		$url_link = CUR_PATH . "?com=user&act=man&keyword=" . $keyword;
	}
	else {
		$url_link = CUR_PATH . "?com=user&act=man";
	}
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
	
	$d->SetTable("#_accounts");
	$d->SetWhere("groupid", "!=", 0);
	if ($keyword != "") {
		$d->SetWhere("username", "like", "%$keyword%");
		$d->SetWhereOr("fullname", "like", "%$keyword%");
		$d->SetWhereOr("email", "like", "%$keyword%");
	}
	$d->SetLimit("$bg, $pageSize");
	$items = $d->Select();
}

function get_item(){
    global $d, $item;
	
    $id = isset($_GET['id']) ? $_GET['id'] : "";
    if(!$id) {
		header("Location: " . CUR_PATH . "?com=user&act=man");
		exit(0);
	}
	
	$d->SetTable("#_accounts");
	$d->SetWhere("id", "=", $id);
	$lstResult = $d->Select();
	
    if(count($lstResult) == 0) {
		header("Location: " . CUR_PATH . "?com=user&act=man");
		exit(0);
	}
    $item = reset($lstResult);
}

function save_item(){
    global $d;

    if(empty($_POST)) {
		header("Location: " . CUR_PATH . "?com=user&act=man");
		exit(0);
	}
	
	$data["email"] = $_POST["email"];
	$data["fullname"] = $_POST["fullname"];
	$data["phonenumber"] = $_POST["phonenumber"];
	$data["address"] = $_POST["address"];
	$data["groupid"] = $_POST["selGroup"];
	
    $id = isset($_POST['id']) ? $_POST['id'] : "";
    if($id != ""){ // cap nhat
		if (!ck_per("pqqt", "u")) {
			echo "<script>
					alert('Bạn không có quyền thực hiện chức năng này!');
					window.location.href = '" . CUR_PATH . "';
				</script>";
			exit(0);
		}
	
        $id =  $_POST['id'];

        if($_POST['password']!="") {
			$data['password'] = sha1($_POST['password']);
		}

        $d->SetTable('#_accounts');
        $d->SetWhere('id', "=", $id);
        if($d->Update($data)) {
            header("Location: " . CUR_PATH . "?com=user&act=man");
			exit(0);
		}
        else {
			$_SESSION["error"] = "Dữ liệu cập nhật bị lỗi!";
			header("Location: " . CUR_PATH . "?com=user&act=edit&id=" . $id);
			exit(0);
		}
    }else{ // them moi
		if (!ck_per("pqqt", "c")) {
			echo "<script>
					alert('Bạn không có quyền thực hiện chức năng này!');
					window.location.href = '" . CUR_PATH . "';
				</script>";
			exit(0);
		}
	
        if($_POST['username']=="") {
			$_SESSION["error"] = "Chưa nhập username";
			header("Location: " . CUR_PATH . "?com=user&act=add");
			exit(0);
		}
        if($_POST['password']=="") {
			$_SESSION["error"] = "Chưa nhập password";
			header("Location: " . CUR_PATH . "?com=user&act=add");
			exit(0);
		}

        // kiem tra ten trung
		$d->SetTable("#_accounts");
        $d->SetWhere('username', "=", $_POST['username']);
        $lstResult = $d->Select();
        if(count($lstResult) > 0) {
			$_SESSION["error"] = "Username bị trùng!";
			header("Location: " . CUR_PATH . "?com=user&act=add");
			exit(0);
		}

        $data['username'] = $_POST['username'];
        $data['password'] = sha1($_POST['password']);

        $d->SetTable('#_accounts');
        if($d->Insert($data)) {
			header("Location: " . CUR_PATH . "?com=user&act=man");
			exit(0);
		}
        else {
            $_SESSION["error"] = "Dữ liệu thêm bị lỗi";
			header("Location: " . CUR_PATH . "?com=user&act=add");
			exit(0);
		}
    }
}

function delete_item(){
    global $d;
	
	$id = isset($_GET["id"]) ? $_GET["id"] : "";
	
	if (isset($_GET['listid'])) {
        $ids = explode(',', $_GET['listid']);
        foreach ($ids as $id) {
			$d->SetTable("#_accounts");
			$d->SetWhere("id", "=", $id);
			$path = reset($d->Select("image"))["image"];
			if (file_exists(SERVER_ROOT . $path)) {
				unlink(SERVER_ROOT . $path);
			}
			$d->SetTable("#_accounts");
			$d->SetWhere("id", "=", $id);
			$d->Delete();
        }
        header("Location: " . CUR_PATH . "?com=user&act=man");
		exit(0);
    }
	
	if ($$id != "") {
		$d->SetTable("#_accounts");
		$d->SetWhere("id", "=", $id);
		$item = reset($d->Select());
		
		if (file_exists(SERVER_ROOT . $item["image"])) {
			unlink(SERVER_ROOT . $item["image"]);
		}
		
		$d->SetTable("#_accounts");
		$d->SetWhere("id", "=", $id);
		$d->Delete();
	}	
	
	header("Location: " . CUR_PATH . "?com=user&act=man");
	exit(0);
}


///////////////////////
function edit(){
   	global $d, $item;

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if(isset($_POST)){
			$d->SetTable("#_taikhoan");
			$d->SetWhere("tentaikhoan", "=", json_decode($_SESSION['user'], true)["username"]);
			$lstResults = $d->Select();
			if (count($lstResults) != 0) {
				$account = reset($lstResults);
				
				if($_POST['password']!="") {
					$data['matkhau'] = sha1($_POST['password']);
				}
				
				$data["hoten"] = $_POST["fullname"];
				$data["email"] = $_POST["email"];
				$data["sdt"] = $_POST["phonenumber"];
				$d->SetTable("#_taikhoan");
				$d->SetWhere("tentaikhoan", "=", json_decode($_SESSION['user'], true)["username"]);
				$d->Update($data);
					
				$_SESSION["result"] = "Cập nhật thành công!";
				header("Location: " . CUR_PATH . "?com=user&act=admin_edit");
				exit(0);
			}
		}
	}

	$d->SetTable("#_taikhoan");
	$d->SetWhere("tentaikhoan", "=", json_decode($_SESSION['user'], true)["username"]);
	$lstResults = $d->Select();
	if(count($lstResults) == 1){
		$item = reset($lstResults);
	}
}

function login(){
    global $d;
    $username = $_POST['username'];
    $password = $_POST['password'];

    $d->SetTable("#_accounts");
	$d->SetWhere("username", "=", $username);
	$d->SetWhere("password", "=", sha1($password));
	$d->SetWhere("groupid", "!=", 0);
    $lstResults = $d->Select();

    if(count($lstResults) == 1){
        $row = reset($lstResults);
        $data["id"] = $row["id"];
		$data["username"] = $row["username"];
		$_SESSION["user"] = json_encode($data);
			
		header("Location: " . CUR_PATH);
		exit(0);
    }

	header("Location: " . CUR_PATH . "?com=user&act=login");
	exit(0);
}

function logout(){
    unset($_SESSION["user"]);
	unset($_SESSION["accesstokens"]);
	unset($_SESSION["defaultaccesstoken"]);
	
	header("Location: " . CUR_PATH . "?com=user&act=login");
	exit(0);
}
?>