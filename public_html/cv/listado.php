<?php

session_start();

require ("../db/funciones_db.php");

if(comprobarUsuario(1)) {

	include('modelo_plantilla.php');
	include('../db/conexion.php');

	// Comprobar familia profesional con el ID del parámetro para título
	$categoria = $_GET['idCat'];

	$query_fam = "SELECT nombre FROM categoria WHERE ID=$categoria";
	$res_fam = $con -> query($query_fam);
	$titulo = $res_fam -> fetch_array();

	// Creamos mediante el constructor páginas horizontal de tamaño folio
	$pdf = new PDF('L', 'mm', 'A4');

	// Agregamos una nueva página
	$pdf -> AddPage();

	// Elemento necesario para contabilizar el número de páginas
	$pdf -> AliasNbPages();

	// Añadimos titulo con el nombre de la familia profesional
	$pdf -> SetTextColor(20,23,25);
	$pdf -> SetFont('Helvetica', 'B', 14);
	$pdf -> Cell(0,10, UTF8(strtoupper($titulo['nombre'])), 0,1, 'C');
	$pdf -> Ln(5);

	//Apartados de la tabla
	$pdf -> SetFont('Helvetica','B', 12);
	$pdf -> SetFillColor(20,23,25);
	$pdf -> SetDrawColor(20,23,25);
	$pdf -> SetTextColor(250,250,250);
	$pdf -> Cell(120, 8, 'Nombre completo', 1, 0, 'C', 1);
	$pdf -> Cell(35, 8, 'Experiencia', 1, 0, 'C', 1);
	$pdf -> Cell(120, 8, UTF8('Titulación'), 1, 1, 'C', 1);

	// Datos personales necesarios para mostrar en la tabla (Nombre completo y cantidad de años de experiencia)
	$query_nombre = "SELECT ID, CONCAT_WS(' ', nombre, apellidos) AS nombre_completo FROM perfil_datos WHERE ID_cat=$categoria";
	$res_nombre = $con->query($query_nombre);

	// Resultado de los datos
	foreach ($res_nombre as $res_pdf) {

		// Buscar los datos de formación y experiencia correspondientes a dicho usuario
		$id = $res_pdf['ID'];
	
		$query_form = "SELECT titulacion FROM perfil_formacion WHERE ID_perfil = $id";
		$res_form= $con -> query($query_form);
	
		$query_experiencia = "SELECT SUM(YEAR(a_fin) - YEAR(a_inicio)) AS exp_total FROM perfil_experiencia WHERE ID_perfil=$id";
		$res_experiencia = $con -> query($query_experiencia);
    	$total_exp = $res_experiencia -> fetch_array();
    
		// Cogemos la altura de las celdas, que varían dependiendo del número de títulos
		if ($res_form -> num_rows) 	$altura = 6 * $res_form -> num_rows;
    	else $altura = 6;

		$pdf -> SetTextColor(20,23,25);
		$pdf -> SetFont('Helvetica','B', 11);
		$pdf -> cell(120, $altura, ' '.UTF8($res_pdf['nombre_completo']), 1, 0, 'L', '', '/perfil-'.$res_pdf['ID']);
		$pdf -> SetFont('Helvetica',null, 11);
		$pdf -> cell(35, $altura, $total_exp['exp_total'], 1, 0, 'C');

		// String por defecto vacio para almacenar los titulos
		$form = "";

		// Almacenamos en el string cada uno de los titulos del usuario
		foreach ($res_form as $res_pdf_2) {

			$form .= ' '.$res_pdf_2['titulacion']."\n";

		}

		$pdf -> MultiCell(120, 6, UTF8($form), 1, 'L');

	}

// Salida del archivo
$pdf -> Output();

}

// Si no es usuario empresa se manda al inicio
else header("location:../index.php");

?>