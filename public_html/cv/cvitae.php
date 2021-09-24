<?php 

session_start();

// Si existe una sesión id (solo usuario individual) se mostrará el contenido
if (isset($_SESSION['id'])) {

include('modelo_plantilla.php');
include('../db/conexion.php');

// Recogemos el ID del usuario para poder obtener los datos
$user_id = $_SESSION['id'];

// Recoger todos los datos personales del usuario, incluido el diseño de perfil que desea
$query_personal = "SELECT CONCAT_WS(' ', d.nombre, d.apellidos) AS nombre_completo, d.direccion, d.cod_postal, d.localidad, p.nombre AS nombre_pais, c.id AS p_diseno, c.fuente AS p_fuente, c.rID, c.gID, c.bID, d.img_perfil FROM perfil_datos d INNER JOIN iso_pais p ON p.ID = d.ID_pais INNER JOIN diseno c ON c.ID = d.ID_cv WHERE d.ID = $user_id";
$res_personal = $con -> query($query_personal);
$dato = $res_personal -> fetch_array();

// Recoger toda la formación, experiencia e idiomas del id
$query_exp = "SELECT nombre_esa, localidad, puesto, CONCAT_WS('/', MONTH(a_inicio), YEAR(a_inicio)) AS my_inicio, CONCAT_WS('/', MONTH(a_fin), YEAR(a_fin)) AS my_fin, descr FROM perfil_experiencia WHERE ID_perfil = $user_id ORDER BY a_fin DESC";
$res_exp = $con -> query($query_exp);

$query_form = "SELECT titulacion, escuela, localidad, CONCAT_WS('/', MONTH(a_inicio), YEAR(a_inicio)) AS my_inicio, CONCAT_WS('/', MONTH(a_fin), YEAR(a_fin)) AS my_fin, descr FROM perfil_formacion WHERE ID_perfil = $user_id ORDER BY a_fin DESC";
$res_form = $con -> query($query_form);

$query_lang = "SELECT i.idioma, i.ID_nivel, n.descr FROM perfil_idioma i INNER JOIN nivel_idioma n ON i.ID_nivel = n.ID WHERE ID_perfil = $user_id";
$res_lang = $con -> query($query_lang);

// Conocemos si el texto debe de ir en blanco o en negro, dependiendo de la fuente de la tabla diseño

$f_red = 0;
$f_green = 0;
$f_blue = 0;

switch($dato['p_fuente']) {

    case "white":
        $f_red = 255;
        $f_green = 255;
        $f_blue = 255;
    break;
    case "dark":
        $f_red = 20;
        $f_green = 23;
        $f_blue = 25;
    break;

 }

// Creamos mediante el constructor una pagina vertical de tamaño folio
$pdf = new PDF('P', 'mm', 'A4');

// Agregamos una nueva página
$pdf -> AddPage();

// Elemento necesario para contabilizar el número de páginas
$pdf -> AliasNbPages();

// Div de datos personales
$pdf -> Ln(2);
$pdf -> SetFillColor($dato['rID'],$dato['gID'],$dato['bID']);
$pdf -> SetFont('Helvetica', 'B', 14);
$pdf -> Cell(0, 50, '', 0, 1, 'C', 1);

// Imagen con borde
$pdf -> SetFillColor(255,255,255);
$pdf -> RoundedRect(83.5, 36.5, 43, 43, 1, '1234', 'F');
$pdf -> Image('../img/users/'.$dato['img_perfil'],85,38,40,0);

// Nombre y dirección
$pdf -> SetFillColor($dato['rID'],$dato['gID'],$dato['bID']);
$pdf -> SetTextColor($f_red,$f_green,$f_blue);
$pdf -> Cell(0, 8, UTF8($dato['nombre_completo']), 0, 1, 'C', 1);
$pdf -> SetFont('Helvetica', '', 12);
$pdf -> Cell(0, 12, UTF8(" ".$dato['direccion'].", ".$dato['cod_postal']." ".$dato['localidad']." (".$dato['nombre_pais'].")"), 0, 1, 'L', 1);
$pdf -> Ln(10);

// Si hay algún registro con experiencia
if ($res_exp -> fetch_array() > 0) {

    // Titulo
    $pdf -> SetFont('Helvetica', 'B', 16);
    $pdf -> SetFillColor(255,255,255);
    $pdf -> SetTextColor($dato['rID'],$dato['gID'],$dato['bID']);
    $pdf -> Cell(0, 15, strtoupper('Experiencia'), 0, 1, 'L', 1);

    $pdf -> SetFont('Helvetica', '', 12);
    $pdf -> SetTextColor(20,23,25);
    foreach($res_exp as $exp){ 

        // Si la fecha es 0/0, se mostrará la palabra actual
        if ($exp['my_fin'] == '0/0') $exp['my_fin'] = 'Actual';
        $pdf -> Cell(40, 9, $exp['my_inicio']." - ".$exp['my_fin'], 0, 0, 'R', 1);

        $multicelda = $exp['nombre_esa'].", ".$exp['localidad']."\n".$exp['puesto']."\n".$exp['descr'];

        $pdf -> MultiCell(140, 9, UTF8($multicelda), 0, 'L');
        $pdf -> Ln(10);
    }

}

// Si hay algún registro con formación
if ($res_form -> fetch_array() > 0) {

    // Titulo
    $pdf -> SetFont('Helvetica', 'B', 16);
    $pdf -> SetFillColor(255,255,255);
    $pdf -> SetTextColor($dato['rID'],$dato['gID'],$dato['bID']);
    $pdf -> Cell(0, 15, UTF8(strtoupper('Formación')), 0, 1, 'L', 1);

    $pdf -> SetFont('Helvetica', '', 12);
    $pdf -> SetTextColor(20,23,25);

    foreach($res_form as $form){ 

        // Si la fecha es 0/0, se mostrará la palabra actual
        if ($form['my_fin'] == '0/0') $form['my_fin'] = 'Actual';
        $pdf -> Cell(40, 9, $form['my_inicio']." - ".$form['my_fin'], 0, 0, 'R', 1);

        $multicelda = $form['titulacion']."\n".$form['escuela'].", ".$form['localidad']."\n".$form['descr'];
        
        $pdf -> MultiCell(140, 9, UTF8($multicelda), 0, 'L');
        $pdf -> Ln(10);
    }

}

// Si hay algún registro con idiomas
if ($res_lang -> fetch_array() > 0) {

    // Titulo
    $pdf -> SetFont('Helvetica', 'B', 16);
    $pdf -> SetFillColor(255,255,255);
    $pdf -> SetTextColor($dato['rID'],$dato['gID'],$dato['bID']);
    $pdf -> Cell(0, 15, UTF8(strtoupper('Idiomas')), 0, 1, 'L', 1);

    $pdf -> SetFont('Helvetica', '', 12);
    $pdf -> SetTextColor(20,23,25);

    foreach($res_lang as $lang){ 

        $pdf -> Cell(40, 9, UTF8($lang['idioma']), 0, 0, 'R', 1);

        $pdf -> Cell(140, 9, UTF8($lang['ID_nivel'].". ".$lang['descr']), 0, 1, 'L', 1);

    }

}

// Salida del archivo
$pdf -> Output();

}

// Si no es usuario individual se manda al inicio
else header("location:../index.php");

?>