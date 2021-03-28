<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Ana Sayfa || Fotoğraf Galerisi</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fonts/css/all.css?v=<?php echo time();?>">
	<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.css?v=<?php echo time();?>">
	<link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">
	<script src="js/jquery-3.6.0.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body style="background:#ededed;">

	<?php 
		session_start();
		ob_start();
	?>


	<!-- login-form -->
		<div class="login-form">
			
			<!-- row -->
				<div class="login-background">
					<div class="login-shadow"></div>
					<img src="images/login-background.jpg" alt="">
				</div>
			<!-- row -->

			<!-- login-form-container -->
				<div class="login-form-container">
					
					<div class="col">
						
						<div class="card login-card">
							<header class="card-header login-form-header">Giriş Yap</header>

							<div class="card-body">

								<form method="post">

									<div class="form-group">
										<input type="text" name="username" placeholder="Kullanıcı Adınız" autocomplete="off" required class="form-control form-control-sm">
									</div>

									<div class="form-group">
										<input type="password" style="margin-top: 20px;" name="password" placeholder="Parolanız" autocomplete="off" required class="form-control form-control-sm">
									</div>


									<div class="form-group">
										<button type="submit" name="login-btn" style="margin-top: 30px; width: 100%;" class="btn btn-outline-success">Giriş Yap&nbsp;<i class="fas fa-sign-in-alt"></i></button>
									</div>

								</form>

								<?php 

									if(isset($_POST["login-btn"])){

										include 'db/db.php';

										$username = $_POST["username"];

										$password = md5($_POST["password"]);

										$login_query = $db->query("SELECT * FROM users WHERE username = '".$username."' AND password = '".$password."' ");

										if($login_result = $login_query->rowCount()){

											if($login_result > 0){

												$_SESSION["login"] = "true";

												$_SESSION["username"] = $username;

												echo("<script>swal('Giriş Başarılı','Lütfen Bekleyiniz','success')</script>");

												while($profil_bilgisi_gonder = $login_query->fetch()){
													header("Refresh:2; url=profil_index.php?id=".$profil_bilgisi_gonder["id"]."");
												}
											}

										}

										else{
											echo("<script>swal('Giriş Başarısız','Kullanıcı Adı Ya da Parola Hatalı','error')</script>");
										}

									}

								?>


								<div class="login-links" style="margin-top: 20px;">
									
									<a href="kayit.php" style="float: left;" title="Kayıt Ol">Kayıt Ol</a>

									<a href="sifre_sifirlama.php" style="float: right;" title="Şifremi Unuttum">Şifremi Unuttum</a>

								</div>

							</div>

						</div>
						
					</div>

				</div>
			<!-- login-form-container -->

		</div>
	<!-- login-form -->

</body>
</html>