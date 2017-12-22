<?php	

	session_start();
	require_once("controllers/home_controller.php");
	$controller = new Controller();
?>
<!DOCTYPE html>
<html>

<head>
	<?php require_once("templates/layouts/head_content.php"); ?>
</head>

<body class="home blog">
		<?php require_once("templates/layouts/header_content.php"); ?>
		<?php require_once("templates/layouts/home_content.php"); ?>
		<?php require_once("templates/layouts/footer_content.php"); ?>
</body>

</html>
<?php
	//test
?>