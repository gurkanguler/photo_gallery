<?php 

	session_start();
	ob_start();

	if(isset($_SESSION["username"])){
?>

<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ana Sayfa - Fotoğraf Galerisi</title>
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
					<a href="profil_index.php" title="Fotoğraf Galerisi">Fotoğraf Galerisi</a>
				</div>
			<!-- logo -->

			<!-- menus -->
				<nav class="menus">
					<ul>
						<li><?php echo("<a href='profil_index.php?id=".$_GET["id"]."' title='Ana Sayfa' class='active-menu'>");?>Ana Sayfa&nbsp;<i class="fas fa-home"></i></a></li>
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
									<li><a href='users/settings.php?id=".$user_id."'>Profil Ayarları</a></li>
									<li><a href='logout.php'>Oturumu Kapat</a></li>
								");
						?>
					</ul>
				</div>
			<!-- profil_menu_submenu -->

		</nav>
	<!-- navbar -->

	<!-- container-fluid -->
		<div class="container-fluid" id="user-content">
			
			<!-- row -->
				<div class="row">
					
					<!-- col -->
						<div class="col-sm-3">
							
							<!-- en-cok-takipcili -->
								<div class="en-cok-takipcili">
									
									<!-- card -->
										<div class="card">
											
											<!-- header -->
												<header class="card-header bg-dark text-white text-center" style="user-select: none;">En Çok Takipçisi Olanlar</header>
											<!-- header -->

											<!-- body -->
												<div class="card-body">
													<ol>
												
													</ol>
												</div>
											<!-- body -->

										</div>
									<!-- card -->

								</div>
							<!-- en-cok-takipcili -->

						</div>
					<!-- col -->
					
					<!-- col -->
						<div class="col-sm-6" id="posts">

							<div class="card">
								<?php 
									include 'db/db.php';
									$get_posts = $db->query("SELECT DISTINCT id,username, photos,date ,begeni_sayisi FROM photos");
									while($post_result = $get_posts->fetch()){
										echo("
												<div class='card-body'>
													<p><b>".$post_result["username"]." </b>tarafından <b>".$post_result["date"]." tarihinde</b> yüklendi.</p>
													<img src='".$post_result["photos"]."'>
													<br>
													<br>
													<a href='photo_like.php?id=".$post_result["id"]."' class='like-btn'><i class='fas fa-heart'></i></a>&nbsp;".$post_result["begeni_sayisi"]."
												</div>
												<hr>
											");
									}
								?>
							</div>

						</div>
					<!-- col -->
					
					<!-- col -->
						<div class="col-sm-3">
							
							<!-- taniyor-olabilecegin -->
								<div class="taniyor-olabilecegin">
									
									<!-- card -->
										<div class="card">
											
											<!-- header -->
												<div class="card-header bg-dark text-white font-weight-bold text-center">Tanıyor Olabileceğin</div>
											<!-- header -->

											<!-- body -->
												<div class="card-body" style="user-select: none;">
													<ul>
													<?php 
														$user_name2 = $_SESSION["username"];
														$get_users = $db->query("SELECT DISTINCT username, profil_photo FROM users WHERE username!='".$user_name2."'");

														while($get_users_results = $get_users->fetch()){
															echo("
																	<li>
																	<img src='".$get_users_results["profil_photo"]."'>
																	<br>
																	<br>
																	<p>
																	".$get_users_results["username"]."</p>

																	<a href='takip_et.php?username=".$get_users_results["username"]."'>Takip Et</a><br>
																	<br>
																	</li>
																");
														}


													?>

													</ul>
												</div>
											<!-- body -->

										</div>
									<!-- card -->

								</div>
							<!-- taniyor-olabilecegin -->

						</div>
					<!-- col -->

				</div>
			<!-- row -->

		</div>
	<!-- container-fluid -->

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
