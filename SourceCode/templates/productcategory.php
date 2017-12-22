<?php	


	session_start();
	require_once("controllers/productcategory_controller.php");
	$controller = new Controller();
?>

<!DOCTYPE html>
<html>

<head>
	<?php require_once("templates/layouts/head_content.php"); ?>
</head>

<body>
	<div id="wrapper">
		<?php require_once("templates/layouts/header_content.php"); ?>
		<?php require_once("templates/layouts/productcategory_content.php"); ?>
		<?php require_once("templates/layouts/footer_content.php"); ?>
	</div>
</body>

</html>