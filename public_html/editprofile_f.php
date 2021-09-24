<?php 

// Si es usuario individual se mostrará el contenido
if(comprobarusuario(0)) {

  insertarPortada("img/edit-4.jpg", "Formación");
  
?>

  <div class="w-custom-1 m-auto py-5 text-justify">
    <p class="mx-2">La <strong>formación</strong> debe de contar con siguientes elementos fundamentales: Título, colegio donde cursaste, localidad, periodo de estudios y una breve descripción, en la que podrá indicar cuales fueron sus conocimientos adquiridos. Y recuerda, usted puede añadir cualquier tipo de formación útil, como los <strong>cursos</strong>, pero teniendo en cuenta que deben de contar con un certificado de profesionalidad.</p> 
  </div>

<?php

  $op = $_GET['op'];
  $activate = true;

  // Dependiendo de la variable op que se pase por parámetro, se realizará una acción u otra
  switch($op) {

    case "add";
    if (isset($_POST['submit_form'])) {
 
      $id = $_SESSION['id'];
      $tit = $_POST['f_nombre'];
      $esc = $_POST['f_escuela'];
      $loc = $_POST['f_localidad'];
      $f_in = $_POST['f_comienzo'];
      $f_fin = $_POST['f_final'];
      $desc = $_POST['f_desc'];
      $array = [ "ID_perfil" => $id, "a_inicio" => comillado($f_in), "a_fin" => comillado($f_fin),  "titulacion" => comillado($tit), "escuela" => comillado($esc), "localidad" => comillado($loc), "descr" => comillado($desc)];

      
        // Si fecha fin es nulo, se envía al servidor
        if ($f_fin == null) {
            
            // Borramos el apartado de a_fin e insertamos la información en la base de datos
            array_splice( $array, 2, 1 );
            //insertarDatos("perfil_formacion", $array);
            //$activate = false;
            
        }
        
        // Si fecha fin no es nulo
        else {
        
            // Se comprueba si fecha de inicio es mayor a fecha de final
            if ($f_in <= $f_fin) {
                
                // Se inserta información en nuestra base de datos
                insertarDatos("perfil_formacion", $array);
                $activate = false;
                
            }
            else {
                
                echo " <div class='w-custom-1 m-auto pb-3 text-justify'><div class='alert alert-danger mx-3' role='alert'>
                <i class='far fa-comment-dots'></i> <strong>¡OPS! Algo no ha ido como esperábamos.</strong> La fecha de inicio no puede ser superior a la fecha de finalización.
                </div></div>";
            
            }
            
        }

    }
    break;
    case "del";
    $id = $_GET['id'];
    $tit = $_GET['tit'];
    $array = ["ID_perfil" => $id, "titulacion" => comillado($tit)];

    if (isset($_POST['delete_form'])) {

      // Se borra la información de nuestra base de datos
      borrarDatos("perfil_formacion", $array);
      $activate = false;

    }
    break;

  }

  // Si la op pasada por parámetro es add, se mostrará el formulario
  if ($_GET['op'] == 'add' && $activate) {
    
?>

    <div class="w-custom-1 m-auto py-4">
      <form id="formacion" name="formacion" action="" method="post" class="mx-5">
        <div class="form-row">
          <!-- Titulo. Campo obligatorio de máximo 90 caracteres, únicamente letras -->
          <div class="form-group col-md-7">
            <label for="f_nombre" class="font-weight-bold">Titulación</label>
            <input type="text" class="form-control" id="f_nombre" name="f_nombre" placeholder="Título obtenido con tus estudios" maxlenght="90">
          </div>
          <!-- Centro. Campo obligatorio de máximo 120 caracteres -->
          <div class="form-group col-md-5">
            <label for="f_escuela" class="font-weight-bold">Organización de formación</label>
            <input type="text" class="form-control" id="f_escuela" name="f_escuela" placeholder="Lugar donde estudió (Escuela, universidad, empresa...)" maxlenght="120">
          </div>
        </div>
        <div class="form-row">
          <!-- Localidad. Campo obligatorio de máximo 30 caracteres, únicamente letras -->
          <div class="form-group col-md-5">
            <label for="f_localidad" class="font-weight-bold">Localidad</label>
            <input type="text" class="form-control" id="f_localidad" name="f_localidad" placeholder="Localidad" maxlenght="30">
          </div>
          <!-- Comienzo del periodo. Campo obligatorio de tipo date, no puede ser fecha superior a la fecha actual. La fecha minima se ha fijado en 100 años atrás -->
          <div class="form-group col-md-4">
            <label for="f_comienzo" class="font-weight-bold">Fecha de inicio</label>
            <input type="date" class="form-control" id="f_comienzo" name="f_comienzo"  min="<?php echo Date('Y-m-d', strtotime(date("Y-m-d")."- 100 year")); ?>" max="<?php echo Date('Y-m-d'); ?>">
          </div>
          <!-- Fin del periodo. Campo NO obligatorio de tipo date (Puede ser null, lo que trataré como "en la actualidad"). La fecha minima se ha fijado en 100 años atrás -->
          <div class="form-group col-md-3">
            <label for="f_final" class="font-weight-bold">Fecha de fin</label>
            <i class="fas fa-info-circle" data-container="body" data-toggle="popover" data-placement="left" data-content='En el caso de estar cursando la formación mencionada, puede dejar este campo vacío y será reflejado en su curriculum como "actualmente"'></i>
            <input type="date" class="form-control" id="f_final" name="f_final">
          </div>
        </div>
        <div class="form-group">
          <!-- Descripción. Campo obligatorio de máximo 250 caracteres -->
          <label for="f_desc" class="font-weight-bold">Descripción</label>
          <i class="fas fa-info-circle" data-container="body" data-toggle="popover" data-placement="right" data-content="Escriba una breve descripción de las principales asignaturas y conceptos aprendidos. ¿Crees que has adquirido nuevas aptitudes y actitudes? ¡Coméntelas!"></i>
          <textarea class="form-control" id="f_desc" name="f_desc" rows="4" placeholder="Principales asignaturas y/o conocimientos adquiridos"></textarea>
        </div>
        <div class="container"> 
          <div class="row">
            <div class="col">
              <a href="/editar-perfil" class="btn btn-secondary mb-5">Volver al inicio</a>
            </div>
            <div class="col text-right">
              <input type="submit" id="submit_form" name="submit_form" class="btn btn-secondary mb-5" value="Guardar cambios">
            </div>
          </div>
        </div>
      </form>
    </div>

<?php

  } 
  // Si la op pasada por parámetro es del, se mostrará un mensaje informando de que se borrará la información
  else if ($_GET['op'] == 'del' && $activate) {
    
?>

    <div class='w-custom-1 m-auto pb-3 text-justify'>
      <div class='alert alert-danger mx-3' role='alert'>
        <i class='far fa-comment-dots'></i> <strong>Hemos detectado una solicitud para borrar el registro sobre su título <em><?php echo $tit; ?></em>.</strong>
        Si desea proceder, por favor, pulse en el botón borrar registro, en caso contrario, haga clic en volver al inicio.</div></div>
        <div class='w-custom-1 m-auto text-right pb-5'>
          <form name="delete_experiencia" action="" method="post">
            <a href='/editar-perfil' class='btn btn-secondary mr-2'>Volver al inicio</a>
            <input type='submit' id='delete_form' name='delete_form' class='btn btn-secondary mr-4' value='Borrar registro'>
          </form>
        </div>
      </div>
    </div>

<?php

  } else { 

?>

    <div class="w-custom-1 m-auto text-right pb-5">
      <a href="/editar-perfil" class="btn btn-secondary mr-4">Volver al inicio</a>
    </div>

<?php 

  }

}

// Si no es usuario individual se mostrará el error 404
else include("error404.php");

?>
