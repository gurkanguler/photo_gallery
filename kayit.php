<!DOCTYPE html>
<html lang="tr">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Kayıt Ol || Fotoğraf Galerisi</title>
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="fonts/css/all.css?v=<?php echo time();?>">
	<link rel="stylesheet" href="bootstrap/dist/css/bootstrap.css?v=<?php echo time();?>">
	<link rel="stylesheet" href="css/style.css?v=<?php echo time();?>">
	<script src="js/jquery-3.6.0.js"></script>
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>

	<?php 
		session_start();
		ob_start();
	?>

	<div class="kayit-ol-page">
		
		<div class="container-fluid justify-content-center">
			
			<div class="card">
				
				<div class="card-header kayit-ol-header">Kayıt Ol - Fotoğraf Galerisi</div>

				<div class="card-body">
					
					<form enctype="multipart/form-data" method="post">

						<div class="form-group">
							<input type="text" name="name" placeholder="Adınız" autocomplete="off" required class="form-control">
						</div>

						<div class="form-group">
							<input type="text" style="margin-top: 20px;" name="surname" placeholder="Soyadınız" autocomplete="off" required class="form-control">
						</div>

						<div class="form-group">
							<input type="email" style="margin-top: 20px;" name="email" placeholder="Email Adresiniz" autocomplete="off" required class="form-control">
						</div>

						<div class="form-group">
							<label for="birthday" style="margin-top: 20px;">Doğum Tarihiniz</label>
							<input type="date" name="birthday" required class="form-control">
						</div>

						<div class="form-group">
							<input type="text" style="margin-top: 20px;" name="username" placeholder="Kullanıcı Adınız" autocomplete="off" required class="form-control">
						</div>

						<div class="form-group">
							<input type="password" style="margin-top: 20px;" name="password" placeholder="Parolanız" autocomplete="off" required class="form-control">
						</div>

						<div class="form-group">
							<label for="photo" style="margin-top: 20px;">Profil Fotoğrafınız :</label>
							<br>
							<input type="file" name="photo" class="form-control-file">
						</div>

						<div class="form-group">
							<button type="submit" name="kayit-btn" style="margin-top: 20px; width: 100%;" class="btn btn-success font-weight-bold">Kayıt Ol&nbsp;<i class="fas fa-plus"></i></button>
						</div>

					</form>

					<?php 
						if(isset($_POST["kayit-btn"])){

							$name = $_POST["name"];

							$surname = $_POST["surname"];

							$email = $_POST["email"];

							$username = $_POST["username"];

							$password = $_POST["password"];

							$birthday = $_POST["birthday"];

							$path = "users/Uploads/";

							$photo = $path.basename($_FILES["photo"]["name"]);

							$photo_type = $_FILES["photo"]["type"];

							include 'db/db.php';
							
							if(strlen($password) < 8 || strlen($password) > 16){

								echo("<script>swal('Hata','Parolanız 8 karakterden uzun, 16 karakterden az olmalıdır.','error')</script>");
							}

							$username_check = $db->query("SELECT username FROM users WHERE username='".$username."'");

							if($username_check_result = $username_check->rowCount()){

								if($username_check_result > 0){
									
									echo("<script>swal('Hata','Kullanıcı Adı Zaten Kullanılıyor.','error')</script>");

									
								}

							}
							$email_check = $db->query("SELECT email FROM users WHERE username='".$username."'");
							if($email_check_result = $email_check->rowCount()){
								if($email_check_result > 0){
									echo("<script>swal('Hata','Email Zaten Kullanılıyor.','error')</script>");
								}
							}

							else{

								if($photo_type == "image/jpg" || $photo_type == "image/jpeg" || $photo_type == "image/png"){

									if(move_uploaded_file($_FILES["photo"]["tmp_name"], $photo)){

										

										$add = $db->query("INSERT INTO users(name,surname,email,username,password,profil_photo,birthday) VALUES('".$name."','".$surname."','".$email."','".$username."','".md5($password)."','".$photo."','".$birthday."')");

										if($add == true){
											echo("<script>swal('Kayıt Tamamlandı.','Lütfen Bekleyiniz','success')</script>");
											header("Refresh:2; url=index.php");
										}
									}
								}

								else{
									echo("<script>swal('Hata','Lütfen Geçerli Uzantılı Fotoğraf Yükleyiniz(JPEG, JPG, PNG).','error')</script>");
								}
							}

						}
					?>

				</div>

			</div>

		</div>

	</div>

</body>
</html>