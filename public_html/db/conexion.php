<?php 

	// 000Hosting - localhost - id12980188_proyecto - proyecto - id12980188_proyecto
	$server = 'localhost';
	$user = 'id12980188_proyecto';
	$pass = 'proyecto';
	$bd = 'id12980188_proyecto';

	$con = new mysqli($server, $user, $pass, $bd);

	if(mysqli_connect_errno()) {
		echo 'ERROR: No conectado', mysli_connect_error();
		exit();
	}
	
	$con -> set_charset("utf8");
	
 ?>