<?php 

	try{

		$db = new PDO("mysql:host=localhost;dbname=photo_gallery;","root","");

		$db->query("SET NAMES UTF8");
		
	}

	catch(PDOException $e){
		echo $e->getMessage();
	}

?>