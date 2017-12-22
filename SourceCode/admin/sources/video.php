<?php if (!defined('_source')) die("Error");

$act = (isset($_REQUEST['act'])) ? addslashes($_REQUEST['act']) : "";

switch ($act) {
    case "man_photo":
        get_photos();
        $template = "video/photos";
        break;
    case "add_photo":
        $template = "video/photo_add";
        break;
    case "edit_photo":
        get_photo();
        $template = "video/photo_edit";
        break;
    case "save_photo":
        save_photo();
        break;
    case "delete_photo":
        delete_photo();
        break;
    default:
        $template = "index";
}

function get_photos()
{
    global $d, $items, $url_link, $totalRows, $pageSize, $offset;
    define('_upload_hinhanh', '../users/');
    if (!empty($_POST)) {
        $multi = $_REQUEST['multi'];
        $id_array = $_POST['iddel'];
        $count = count($id_array);
        if ($multi == 'show') {
            for ($i = 0; $i < $count; $i++) {
                $sql = "UPDATE tbl_videos SET anhien =1 WHERE  id = " . $id_array[$i] . "";
                mysql_query($sql) or die("Not query sqlUPDATE_ORDER");
            }
            redirect("index.php?com=video&act=man_photo&type=" . $_REQUEST['type']);
        }

        if ($multi == 'hide') {
            for ($i = 0; $i < $count; $i++) {
                $sql = "UPDATE tbl_videos SET anhien =0 WHERE id = " . $id_array[$i] . "";
                mysql_query($sql) or die("Not query sqlUPDATE_ORDER");
            }
            redirect("index.php?com=video&act=man_photo&type=" . $_REQUEST['type']);
        }

        if ($multi == 'del') {
            for ($i = 0; $i < $count; $i++) {

                $sql = "select * from #_videos where id= " . $id_array[$i] . "";
                $d->query($sql);
                if ($d->num_rows() > 0) {
                    while ($row = $d->fetch_array()) {
                        delete_file(_upload_hinhanh . $row['images']);
                    }
                }
                $sql = "delete from tbl_videos where id = " . $id_array[$i] . "";
                mysql_query($sql) or die("Not query sqlUPDATE_ORDER");

            }
            redirect("index.php?com=video&act=man_photo&type=" . $_REQUEST['type']);
        }
    }
	
	if ($_REQUEST['anhien'] != '') {
        $id_up = $_REQUEST['anhien'];
		$d->SetTable("#_videos");
		$d->SetWhere("id", "=", $id_up);
        $cats = reset($d->Select());
        $anhien_slider = $cats['showhide'];
        if ($anhien_slider == 0) {
			$d->SetTable("#_videos");
			$d->SetWhere("id", "=", $id_up);
			$data["showhide"] = 1;
			$d->Update($data);
        } else {
            $d->SetTable("#_videos");
			$d->SetWhere("id", "=", $id_up);
			$data["showhide"] = 0;
			$d->Update($data);
        }
		
		header("Location: " . CUR_PATH . "?com=video&act=man_photo");
		exit(0);
    }
	
	
	$d->SetTable("#_videos");
	$dem = reset($d->Select("count(id) AS numrows"));
    $totalRows = $dem['numrows'];
    $page = $_GET['p'];

    $pageSize = 10;
    $offset = 5;

    if ($page == "")
        $page = 1;
    else
        $page = $_GET['p'];
    $page--;
    $bg = $pageSize * $page;

	$d->SetTable("#_videos");
	$d->SetOrderBy("ordernumber, id desc");
	$d->SetLimit($bg . ", " . $pageSize);
	$items = $d->Select();
	
    //$url_link = "index.php?com=video&act=man_photo&type=" . $_REQUEST['type'];
}

function get_photo()
{
    global $d, $item, $list_cat;
    $id = isset($_GET['id']) ? themdau($_GET['id']) : "";
    if (!$id) {
		header("Location: " . CUR_PATH . "?com=video&act=man_photo&type=" . $_REQUEST['type']);
		exit(0);
	}
    $d->SetTable('#_videos');
    $d->SetWhere('id', "=", $id);
    $lstResults = $d->Select();
    if (count($lstResults) == 0) {
		header("Location: " . CUR_PATH . "?com=video&act=man_photo&type=" . $_REQUEST['type']);
		exit(0);
	}
    $item = reset($lstResults);
}

function save_photo()
{
	global $d;
	$data["name"] = $_POST["name"];
	$data["link"] = $_POST["link"];
	$data["showhide"] = $_POST["active"];
	$data["ordernumber"] = $_POST["stt"];
	if (isset($_POST["id"])) {
		$id = $_POST["id"];
		
		if ($_FILES["file"]["tmp_name"] != "") {
			$d->SetTable("#_videos");
			$d->SetWhere("id", "=", $id);
			$path = reset($d->Select())["image"];
			if (file_exists($path)) {
				unlink($path);
			}
			$data["image"] = "images/uploads/" . uniqid("videos-") . ".jpg";
			move_uploaded_file($_FILES["file"]["tmp_name"], $data["image"]);
		}
		
		$d->SetTable("#_videos");
		$d->SetWhere("id", "=", $id);
		$d->Update($data);
	}
	else {
		if ($_FILES["file"]["tmp_name"] != "") {
			$data["image"] = "images/uploads/" . uniqid("videos-") . ".jpg";
			move_uploaded_file($_FILES["file"]["tmp_name"], $data["image"]);
		}
		
		$d->SetTable("#_videos");
		$d->Insert($data);
	}
	
	header("Location: " . CUR_PATH . "?com=video&act=man_photo");
}

function delete_photo()
{
    global $d;
    if (isset($_GET['id'])) {
		$id = $_GET['id'];
		
		$d->SetTable("#_videos");
		$d->SetWhere("id", "=", $id);
		$path = reset($d->Select())["image"];
		if (file_exists($path)) {
			unlink($path);
		}
		
        $d->SetTable('#_videos');
        $d->SetWhere('id', "=", $id);
        $d->Delete();
	}
	
	header("Location: " . CUR_PATH . "?com=video&act=man_photo");
}

?>