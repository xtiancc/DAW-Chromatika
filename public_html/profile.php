<?php
    
// Conocer el ID del usuario mediante la URL
$user_id = $_GET['id'];

// Comprobar existencia de ese ID
$query_busqueda_id = "SELECT COUNT(ID) AS ID FROM perfil_datos WHERE ID = $user_id";
$res_busqueda_id = $con -> query($query_busqueda_id);
$coincidencia_busqueda_id = $res_busqueda_id -> fetch_array();

// Si existe un usuario con ese id, se mostrará el perfil
if ($coincidencia_busqueda_id['ID'] > 0) {
  
// Recoger todos los datos personales del usuario, incluido el diseño de perfil que desea
$query_personal = "SELECT CONCAT_WS(' ', d.nombre, d.apellidos) AS nombre_completo, d.direccion, d.cod_postal, d.localidad, p.nombre AS nombre_pais, c.id AS p_diseno, c.fuente AS p_fuente, d.img_perfil FROM perfil_datos d INNER JOIN iso_pais p ON p.ID = d.ID_pais INNER JOIN diseno c ON c.ID = d.ID_cv WHERE d.ID = $user_id";
$res_personal = $con -> query($query_personal);
$dato = $res_personal -> fetch_array();

?>

<div class="p-5">
  <div class="w-custom-2 m-auto p-3 bg-<?php echo $dato['p_diseno']?> text-<?php echo $dato['p_fuente']?> rounded">
    <div class="text-center pt-3">
      <img src="/img/users/<?php echo $dato['img_perfil']; ?>" alt="Imagen personal del usuario" class="img-thumbnail image-size">
      <h2 class="font-weight-bold text-uppercase"><?php echo $dato['nombre_completo']; ?></h2>
    </div>
    <div class="px-5 pt-5">
      <p><i class="fas fa-map-marker-alt mr-2"></i> <?php echo $dato['direccion'].", ".$dato['cod_postal']." ".$dato['localidad']." (".$dato['nombre_pais'].")"; ?> </p>
      <p><i class="fas fa-envelope mr-2"></i> <a href="/envio-<?php echo $user_id;?>" class="mp font-weight-bold">Enviar mensaje privado</a></p>
    </div>
  </div>
  <div class="w-custom-2 m-auto p-3 text-right">

<?php 

    // Si el usuario es dueño de su perfil (coincide su sesión id con el id pasado por parámetro en el link)
    if (isset($_SESSION['id']) && $_SESSION['id'] == $user_id) {

?>        
    
    <form name="cvitae" action="/descarga-cv" target="_blank" method="post">
      <input type="submit" name="descargar_cv" class="btn btn-outline-<?php echo $dato['p_diseno']?>" value="Descargar">
    </form>
    

<?php

    }

?>

  </div>

<?php

  // Recoger toda la formación, experiencia e idiomas del id
  $query_exp = "SELECT nombre_esa, localidad, puesto, CONCAT_WS('/', MONTH(a_inicio), YEAR(a_inicio)) AS my_inicio, CONCAT_WS('/', MONTH(a_fin), YEAR(a_fin)) AS my_fin, descr FROM perfil_experiencia WHERE ID_perfil = $user_id ORDER BY a_fin DESC";
  $res_exp = $con -> query($query_exp);
  
  $query_form = "SELECT titulacion, escuela, localidad, CONCAT_WS('/', MONTH(a_inicio), YEAR(a_inicio)) AS my_inicio, CONCAT_WS('/', MONTH(a_fin), YEAR(a_fin)) AS my_fin, descr FROM perfil_formacion WHERE ID_perfil = $user_id ORDER BY a_fin DESC";
  $res_form = $con -> query($query_form);

  $query_lang = "SELECT i.idioma, i.ID_nivel, n.descr FROM perfil_idioma i INNER JOIN nivel_idioma n ON i.ID_nivel = n.ID WHERE ID_perfil = $user_id";
  $res_lang = $con -> query($query_lang);

  // Si tiene algun registro en experiencia mayor a 0, se muestra por pantalla.
  if ($res_exp -> fetch_array() > 0) {

?>

    <div class="w-custom-1 m-auto py-5 text-justify">
      <h3 class="font-weight-bold text-uppercase text-<?php echo $dato['p_diseno']?>">Experiencia</h3>

<?php

      foreach($res_exp as $exp){ 

?>

      <div class="container p-3">
        <div class="row">
          <div class="col-sm text-right">
            <p class="font-weight-bold">
              <?php 
              // Si la fecha es 0/0, se mostrará la palabra actual
              if ($exp['my_fin'] == '0/0') $exp['my_fin'] = 'Actual';
              echo $exp['my_inicio']." - ".$exp['my_fin'];
              ?>
            </p>
          </div>
          <div class="col-9">
            <p class="font-weight-bold"><?php echo $exp['nombre_esa'].", ".$exp['localidad'];?> </p>
            <p><?php echo $exp['puesto']; ?> </p>
            <p class="small"><?php echo $exp['descr']; ?> </p>
          </div>
        </div>
      </div>

<?php

      }

?>

    </div>

<?php

  }

  // Si tiene algun registro en formación mayor a 0, se muestra por pantalla.
  if ($res_form -> fetch_array() > 0) {

?>

    <div class="w-custom-1 m-auto pb-5 text-justify">
      <h3 class="font-weight-bold text-uppercase text-<?php echo $dato['p_diseno']?>">Formación</h3>

<?php

      foreach($res_form as $form){ 

?>

        <div class="container p-3">
          <div class="row">
            <div class="col-sm text-right">
              <p class="font-weight-bold">
                <?php
                // Si la fecha es 0/0, se mostrará la palabra actual
                if ($form['my_fin'] == '0/0') $form['my_fin'] = 'Actual';
                echo $form['my_inicio']." - ".$form['my_fin'];
                ?>
              </p>
            </div>
            <div class="col-9">
              <p class="font-weight-bold"><?php echo $form['titulacion'];?> </p>
              <p><?php echo  $form['escuela'].", ".$form['localidad']; ?> </p>
              <p class="small"><?php echo $form['descr']; ?> </p>
            </div>
          </div>
        </div>

<?php

            }

?>

    </div>

<?php

  }

  // Si tiene algun registro en idiomas mayor a 0, se muestra por pantalla.
  if ($res_lang -> fetch_array() > 0) {

?>

    <div class="w-custom-1 m-auto pb-5 text-justify">
      <h3 class="font-weight-bold text-uppercase text-<?php echo $dato['p_diseno']?>">Idioma/s</h3>

<?php

      foreach($res_lang as $lang){ 

?>

        <div class="container p-3">
          <div class="row">
            <div class="col-sm text-right">
              <p class="font-weight-bold"><?php echo $lang['idioma'];?></p>
            </div>
            <div class="col-9">
              <p><span class="font-weight-bold"><?php echo $lang['ID_nivel'].".";?></span> <?php echo $lang['descr'];?></p>
            </div>
          </div>
        </div>

<?php 

    }

?>
  
  </div>

<?php

  }

?>

</div>

<?php 

}

// Si no existe un usuario con ese id, se mostrará el error 404
else include("error404.php");

?>