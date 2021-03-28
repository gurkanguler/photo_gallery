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
	<title>Profil Ayarları - Fotoğraf Galerisi</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Varela+Round&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@300&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="../fonts/css/all.css?v=<?php echo time();?>">
	<link rel="stylesheet" href="../bootstrap/dist/css/bootstrap.css?v=<?php echo time();?>">
	<link rel="stylesheet" href="../css/style.css?v=<?php echo time();?>">
	<script src="../js/jquery-3.6.0.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
	<!-- navbar -->
		<nav class="index-navbar bg-white">
			
			<!-- logo -->
				<div class="logo">
					<a href="../profil_index.php" title="Fotoğraf Galerisi">Fotoğraf Galerisi</a>
				</div>
			<!-- logo -->

			<!-- menus -->
				<nav class="menus">
					<ul>
						<li><?php echo("<a href='../profil_index.php?id=".$_GET["id"]."' title='Ana Sayfa' >");?>Ana Sayfa&nbsp;<i class="fas fa-home"></i></a></li>
						<li><?php echo("<a href='about.php?id=".$_GET["id"]."' title='Hakkımızda'>");?>Hakkımızda&nbsp;<i class="fas fa-user"></i></a></li>
						<li><a href="#" class="sekme-link" title="Keşfet">Keşfet&nbsp;<i class="fas fa-compass"></i></a></li>
						<li><a href="contact.php" title="İletişim">İletişim&nbsp;<i class="fas fa-inbox"></i></a></li>
					</ul>
				</nav>
			<!-- menus -->

			<!-- profil-menu -->
				<div class="profil-menu">
					<?php 
						include '../db/db.php';

						$user_id = $_GET["id"];

						$profil_sql = $db->query("SELECT * FROM users WHERE id='".$user_id."' ");

						while($profili_goster = $profil_sql->fetch()){

							echo("
									<a href='#' class='photo-upload-plus' title='Fotoğraf Yükle'><button class='btn btn-sm btn-success'><i class='fas fa-plus'></i></button></a>
									<img src='../".$profili_goster["profil_photo"]."'>
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

							include '../db/db.php';

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
									<li><a href='settings.php?id=".$user_id."'>Profil Ayarları</a></li>
									<li><a href='../logout.php'>Oturumu Kapat</a></li>
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
						<div class="col-sm-3 float-left text-center" style="user-select: none;">
							<div class="card">
								<header class="card-header bg-dark text-white font-weight-bold">Ayarlar</header>
								<div class="card-body">
									<ul class="list-group">
										<?php 
										   include '../db/db.php';

										   $get_username = $_SESSION["username"];

										   $get_profil_photo_settings = $db->query("SELECT * FROM users WHERE username = '".$get_username."' ");

										   while($get_profil_photo_settings_result = $get_profil_photo_settings->fetch()){
										   	echo("<img src='../".$get_profil_photo_settings_result["profil_photo"]."' class='rounded'> ");
										   }

										?>
										<li class="list-group-item"><button onclick="profil_ayarlari_page(event,'hesap_ayarlari')" class="settings_menu_btns">Hesap Ayarları</button></li>
										<li class="list-group-item"><button onclick="profil_ayarlari_page(event,'takipciler')" class="settings_menu_btns">Takipçiler</button></li>
										<li class="list-group-item"><button class="settings_menu_btns">Takip Ettiklerim</button></li>
										<li class="list-group-item"><button class="settings_menu_btns">Hesabımı Sil</button></li>
									</ul>
								</div>
							</div>
						</div>
					<!-- col -->

					<!-- col -->
						<div class="col-sm-9 float-right text-center">
							
							<!-- profil-ayarlari-content -->
								<div>
									<!-- hesap_ayarlari -->
										<div id="hesap_ayarlari" class="profil-ayarlari-content">
											<?php 
												include '../db/db.php';
												$session_username = $_SESSION["username"];
												$get_my_account_sql = $db->query("SELECT * FROM users WHERE username = '".$session_username."' ");
												while($show_my_account = $get_my_account_sql->fetch()){

													echo("
															<div class='card' style='user-select:none;'>
																<header class='card-header bg-dark text-white'>Hesap Ayarları</header>
																<div class='card-body'>
																	<form enctype='multipart/form-data' method='post'>
																		<div class='form-group'>
																			<label for='email'>Mevcut Email Adresiniz: ".$show_my_account["email"]."</label>
																			<br>
																			<br>
																			<input type='email' placeholder='Yeni Email Adresinizi Yazınız' name='email' class='form-control'>
																		</div>
																		<br>
																		<div class='form-group'>
																			<label for='username'>Mevcut Kullanıcı Adınız: ".$show_my_account["username"]."</label>
																			<br>
																			<br>
																			<input type='text' name='username' class='form-control' placeholder='Yeni Kullanıcı Adınızı Yazınız'>
																		</div>
																		<br>
																		<div class='form-group'>
																			<label for='password'>Eğer parolanızı güncellemek istiyorsanız, lütfen mevcut parolanızı aşağıya yazınız</label>
																			<br>
																			<br>
																			<input type='password' name='password' class='form-control'>
																		</div>

																		<br>
																		<div class='form-group'>
																
																			<br>
																			<input type='password' name='new_password' placeholder='Yeni Parolanız' class='form-control'>
																		</div>

																		<br>
																		<div class='form-group'>
																
																			<br>
																			<input type='password' name='new_password_rep' placeholder='Yeni Parolanızı Tekrar Giriniz' class='form-control'>
																		</div>

																		<br>
																		<div class='form-group'>
																			<label for='photo'>Eğer profil fotoğrafını güncellemek istiyorsanız, lütfen fotoğraf yükleyiniz</label>
																			<br>
																			<br>
																			<input type='file' name='photo'class='form-control-file'>
																		</div>
																		<br>
																		<br>
																		<button class='btn btn-outline-success' name='update-btn'>Güncelle</button>
																		

																	</form>
																</div>
															</div>
														");

												}
											?>
										</div>
									<!-- hesap_ayarlari -->

									<!-- takipciler -->
										<div id="takipciler" class="profil-ayarlari-content">takipçidsler</div>
									<!-- takipciler -->
								</div>
							<!-- profil-ayarlari-content -->

						</div>
					<!-- col -->

				</div>
			<!-- row -->

		</div>
	<!-- container -->
	<script src="../js/index.js"></script>

	<script>
		
		let profil_ayar_link = document.querySelectorAll('.settings_menu_btns');

		let profil_ayarlari_page = (evt, page_name) => {


			let sayfalar = document.querySelectorAll('.profil-ayarlari-content');

			for(let i = 0; i < sayfalar.length; i++){
				sayfalar[i].style.display = 'none';
			}

			for(let i = 0; i < profil_ayar_link.length; i++){
				profil_ayar_link[i].className = profil_ayar_link[i].className.replace(' settings_menu_btns_active', "");
			}

			document.getElementById(page_name).style.display = 'block';

			evt.currentTarget.className += ' settings_menu_btns_active';
		}

	</script>

</body>
</html>
<?php 
	}

	else{
		echo "Yetkisiz Giriş";
		header("Refresh:1; url=../index.php");
	}
?>