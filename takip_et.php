<?php 
	
	session_start();
	ob_start();

	if(isset($_GET["username"])){


		include 'db/db.php';

		$user_get = $_GET["username"];

		

		$username = $_SESSION["username"];


		$get_my_account_inf = $db->query("SELECT * FROM users WHERE username='".$user_get."'");

		$user_arry = array();

		while($result_my_account = $get_my_account_inf->fetch()){

			array_push($user_arry, $result_my_account["name"],$result_my_account["surname"], $result_my_account["email"], $result_my_account["username"], $result_my_account["password"], $result_my_account["profil_photo"],$result_my_account["birthday"],$result_my_account["photos"],$result_my_account["followers"]);

				$add_follower = $db->query("INSERT INTO users(name,surname,email,username,password,profil_photo,birthday,photos,followers) VALUES('".$result_my_account["name"]."','".$result_my_account["surname"]."','".$result_my_account["email"]."','".$result_my_account["username"]."','".$result_my_account["password"]."','".$result_my_account["profil_photo"]."','".$result_my_account["birthday"]."','".$result_my_account["photos"]."','".$username."')");

			
		}

	




		

	}

?>