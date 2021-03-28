<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Çıkış Yapılıyor</title>
	<link rel="stylesheet" href="fonts/css/all.css?v=<?php echo time();?>">
	<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.css?v=<?php echo time();?>">
	<link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">
	<script src="js/jquery-3.6.0.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

	<div id="center-spinner" style="text-align:center; user-select: none; position: absolute; top: 50%; left: 50%;transform: translate(-50%,-50%)">
		<div class="spinner-border" role="status">
	   		<span class="sr-only">Loading...</span>
		</div>
		<br>
		<br>
		<p><?php session_start(); ob_start(); 
		echo "<b>";
		echo $_SESSION["username"];echo "</b>"?> Adlı Hesaptan Çıkış Yapılıyor...</p>
		<?php 
			session_destroy();
			header("Refresh:2; url=index.php");
		?>
	</div>
</body>
</html>