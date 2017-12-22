<?php 
	require_once($_SERVER['DOCUMENT_ROOT'] . "/models/query.php");
		
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (isset($_POST["id"])) {
			$id = $_POST["id"];
			if ($id != "") {
				$d = new Query();
				$d->SetTable("#_categories");
				$d->SetWhere("parentid", "=", $id);
				$items = $d->Select();
				echo json_encode($items);
				exit(0);
			}
		}
	}
?>
