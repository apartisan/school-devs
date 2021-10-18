<?php 
	session_start();
	session_unset($_SESSION['utilizator']);
	session_destroy();
	header('location: index.php');
?>