<?php 
	
	if(isset($_GET["id"])){

		session_start();
		ob_start();

		include 'db/db.php';

		$get_photo_id = $_GET["id"];

		$like_query = $db->query("SELECT * FROM photos WHERE photos='".$get_photo_id."' ");
         
		$like_number = 1;

		while($like_query_result = $like_query->fetch()){

			$get_like_count = $like_query_result["begeni_sayisi"];

			$sum_like = $get_like_count + $like_number;
			
			$like = $db->query("UPDATE photos SET begeni_sayisi='".$sum_like."' WHERE photos='".$get_photo_id."'");

		}

		$my_username = $_SESSION["username"];

		$my_id = $db->query("SELECT * FROM users WHERE username='".$my_username."'");

		while($result_my_id = $my_id->fetch()){
			$get_my_id  = $result_my_id["id"];
		}

		header("Refresh:1; url=profil_index.php?id=".$get_my_id."");
	}

?>