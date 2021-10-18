<?php 
	session_start();

	// conectare la baza de date
	 $conn = mysqli_connect("localhost", "bogdan", "bogdan", "blog_php");
     if (!$conn) {
		die("Eroare conectare la baza de date: " . mysqli_connect_error());
	}

     
    // definire constante globale
	define ('ROOT_PATH', realpath(dirname(__FILE__)));
	define('BASE_URL', 'http://localhost/blog/');
?>