<?php

ob_start();

include('db/conexion.php');
include('db/funciones_db.php');
include('optimizar.php');

if (!isset($_SESSION)) {
	session_start(); 
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>Cromatika - Proyecto DAW</title>
	<link rel=“shortcut icon” type=“image/x-icon” href="favicon.ico">
	<!-- Estilos agregados: Bootstrap, font-awesome, w3css y css personal -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css"/>
	<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
	<link type="text/css" rel="stylesheet" href="css/stylesheet.php"/>
</head>
<body>
<?php

	include ('navbar.php');

?>

<div class="div-cont w-100">

<?php

	// Dependiendo del parámetro de act, se mostrará un archivo u otro
	if(isset($_GET["act"])){

		switch($_GET['act']) {

			case "home":
				include("home.php");
			break;
			case "about":
				include("about.php");
			break;
			case "edit":
				include("editprofile.php");
			break;
			case "edit-exp":
				include("editprofile_e.php");
			break;
			case "edit-form":
				include("editprofile_f.php");
			break;
			case "edit-lang":
				include("editprofile_i.php");
			break;
			case "filter":
				include("filter.php");
			break;
			case "mp":
				include("mensajesp.php");
			break;
			case "send":
				include("enviomp.php");
			break;
			case "login":
				include("login.php");
			break;
			case "register":
				include("register.php");
			break;
			case "profile":
				include("profile.php");
			break;
			case "ERROR404":
				include("error404.php");
			break;
			default:
				include("home.php");
			break;

		}

	} else include("home.php");

?>

</div>


<?php

	include ('footer.php');

?>	

<!-- Scripts necesarios: jQuery, popper, script de bootstrap y scripts personal -->
<script src="https://code.jquery.com/jquery-3.4.1.js" integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.js"></script>
<script type="text/javascript" src="scripts/reloader.js"></script>
<script type="text/javascript" src="scripts/validar.js"></script>
</body>
</html>

<?php 

$con -> close();
ob_end_flush();

?>