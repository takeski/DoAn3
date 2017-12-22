<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . "/models/query.php");
		
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["id"]) && isset($_POST["delimg"])) {
			$id = $_POST["id"];
			$delimg = $_POST["delimg"];
			if ($id != "") {
				$d = new Query();
				$d->SetTable("#_products");
				$d->SetWhere("id", "=", $id);
				$subimages = json_decode(reset($d->Select("subimages"))["subimages"], true);
				$newsubimages = array();
				foreach ($subimages as $img) {
					if ($delimg != $img) {
						array_push($newsubimages, $img);
					}
					else {
						if (file_exists(SERVER_ROOT . $delimg)) {
							unlink(SERVER_ROOT . $delimg);
						}
					}
				}
				$data["subimages"] = json_encode($newsubimages);
				$d->SetTable("#_products");
				$d->SetWhere("id", "=", $id);
				$d->Update($data);
			}
		}
	}
?>
