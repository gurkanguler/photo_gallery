<?php 

	session_start();
	ob_start();

	if(isset($_SESSION["username"])){

	$id = $_GET["id"];
?>

<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Mesajlar - Fotoğraf Galerisi</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fonts/css/all.css?v=<?php echo time();?>">
	<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.css?v=<?php echo time();?>">
	<link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">
	<script src="js/jquery-3.6.0.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
	<!-- navbar -->
		<nav class="index-navbar bg-white">
			
			<!-- logo -->
				<div class="logo">
					<?php 
						echo("<a href='profil_index.php?id=".$id."' title='Fotoğraf Galerisi'>Fotoğraf Galerisi</a>");
					?>
				</div>
			<!-- logo -->

			<!-- menus -->
				<nav class="menus">
					<ul>
						<li><?php echo("<a href='profil_index.php?id=".$_GET["id"]."' title='Ana Sayfa'>");?>Ana Sayfa&nbsp;<i class="fas fa-home"></i></a></li>
						<li><?php echo("<a href='about.php?id=".$_GET["id"]."' title='Hakkımızda'>");?>Hakkımızda&nbsp;<i class="fas fa-user"></i></a></li>
						<li><a href="#" class="sekme-link" title="Keşfet">Keşfet&nbsp;<i class="fas fa-compass"></i></a></li>
						<li><a href="contact.php" title="İletişim">İletişim&nbsp;<i class="fas fa-inbox"></i></a></li>
					</ul>
				</nav>
			<!-- menus -->

			<!-- profil-menu -->
				<div class="profil-menu">
					<?php 
						include 'db/db.php';

						$user_id = $_GET["id"];

						$profil_sql = $db->query("SELECT * FROM users WHERE id='".$user_id."' ");

						while($profili_goster = $profil_sql->fetch()){

							echo("
									<a href='#' class='photo-upload-plus' title='Fotoğraf Yükle'><button class='btn btn-sm btn-success'><i class='fas fa-plus'></i></button></a>
									<img src='".$profili_goster["profil_photo"]."'>
									<p>".$profili_goster["username"]."</p>
									<a href='#' id='profil-buton' title='Profil Ayarları'><button><i class='fas fa-wrench'></i></button></a>
								");

						}

					?>
				</div>
			<!-- profil-menu -->

			<!-- photo-upload-content -->
				<div class="photo-upload-content">
					<header><h5>Fotoğraf Yükle</h5><div id="photo-upload-content-close"><i class="fas fa-window-close"></i></div></header>
					<hr>
					<form enctype="multipart/form-data" method="post">
						<div class="form-group">
							<label for="photo">Yüklenecek Fotoğrafı Seçiniz</label>
							<input type="file" name="photo" required class="form-control-file">
						</div>
						<div class="form-group" style="text-align: center; margin-top: 20px;">
							<button type="submit" name="photo-upload-btn" style="font-weight: bold;" class="btn btn-success btn-sm">Yükle&nbsp;<i class="fas fa-upload"></i></button>
						</div>
					</form>

					<?php 

						if(isset($_POST["photo-upload-btn"])){

							$user_id = $_GET["id"];

							include 'db/db.php';

							$path = "users/Uploads/";

							$photo = $path.basename($_FILES["photo"]["name"]);

							$photo_type = $_FILES["photo"]["type"];

							$user_name = $_SESSION["username"];

							date_default_timezone_set("Europe/Istanbul");

							$date = date("Y-m-d H:i:s");

							$check_user = $db->query("SELECT * FROM users WHERE id = '".$user_id."' ");

							if($check_user_result = $check_user->rowCount()){

								if($check_user_result > 0){

									if($photo_type == "image/jpg" || $photo_type == "image/jpeg" || $photo_type == "image/png"){

										if(move_uploaded_file($_FILES["photo"]["tmp_name"], $photo)){

											$add = $db->query("INSERT INTO photos(username,photos,date) VALUES('".$user_name."','".$photo."','".$date."')");

											if($add){
												echo("<script>swal('Fotoğraf Yüklendi','Lütfen Bekleyiniz.','success')</script>");
												header("Refresh:2; url=profil_index.php?id=".$user_id."");
											}
										}
									}

									else{
										echo("<script>swal('Hata','Lütfen Uygun Formatta Fotoğraf Yükleyiniz (JPEG,JPG,PNG).','error')</script>");
									}
								}
							}

						}

					?>

				</div>
			<!-- photo-upload-content -->

			<!-- profil_menu_submenu -->
				<div class="profil-menu-submenu">
					<ul>
						<?php 
							echo("
									<li><a href='users/settings.php?id=".$user_id."'>Profil Ayarları&nbsp;<i class='fas fa-wrench'></i></a></li>
									<li><a href='messages.php?id=".$user_id."'>Mesajlar</a>&nbsp;<i class='fas fa-inbox'></i></li>
									<li><a href='logout.php'>Oturumu Kapat&nbsp;<i class='fas fa-sign-out-alt'></i></a></li>
								");
						?>
					</ul>
				</div>
			<!-- profil_menu_submenu -->

		</nav>
	<!-- navbar -->

	<!-- container -->
		<div class="container-fluid" id="user-content">
			
			<!-- row -->
				<div class="row justify-content-center">
					
					<!-- col -->
						<div class="col-sm-5 text-center">
							
							<!-- card -->
								<div class="card">
									
									<!-- header -->
										<div class="card-header bg-danger text-white" style="font-weight: bold; user-select: none;">Mesajlar</div>
									<!-- header -->

									<!-- body -->
										<div class="card-body">
											
											<!-- form -->
												<form method="post">
													
													<!-- form-group -->
														<div class="form-group">
															<label for="alici">Alıcının Kullanıcı Adı: </label>
															<br>
															<br>
															<input type="text" name="alici_username" autocomplete="off" required class="form-control">
														</div>
													<!-- form-group -->
													<br>
													<br>
													<!-- form-group -->
														<div class="form-group">
															<label for="mesaj">Mesajınız: </label>
															<textarea name="mesaj" id="" cols="30" rows="10" class="form-control"></textarea>
														</div>
													<!-- form-group -->

													<br>

													<!-- form-group -->
														<div class="form-group">
															<button type="submit" name="send_message_btn" class="btn btn-success">Gönder</button>
														</div>
													<!-- form-group -->


												</form>
											<!-- form -->

											<?php 
												if(isset($_POST["send_message_btn"])){

													include 'db/db.php';

													$alici_username = $_POST["alici_username"];

													$mesaj = $_POST["mesaj"];

													$user_name = $_SESSION["username"];

													$check_alici = $db->query("SELECT * FROM messages WHERE alan='".$alici_username."'");

													if($check_alici_result = $check_alici->rowCount()){
														if($check_alici_result > 0){

															date_default_timezone_set("Europe/Istanbul");

															$date = date("Y-m-d H:i:s");

															$send_message = $db->query("INSERT INTO messages(gonderen,mesaj,alan,tarih) VALUES('".$user_name."','".$mesaj."','".$alici_username."','".$date."')");

															if($send_message){
									
																echo("<script>swal('Mesaj Gönderildi','Lütfen Bekleyiniz.','success')</script>");
																header("Refresh:1; url=messages.php?id=".$user_id."");
															}

														}
													}

													else{

														echo("<script>swal('Hata','Kullanıcı Adı Bulunamadı.','error')</script>");
													}
												}
											?>

										</div>
									<!-- body -->

								</div>
							<!-- card -->

						</div>
					<!-- col -->

				</div>
			<!-- row -->

		</div>
	<!-- container -->

	<script src="js/index.js"></script>
	
</body>
</html>
<?php 
	
	}

	else{
		echo "Yetkisiz Giriş";
		header("Refresh:1; url=index.php");
	}

?>
