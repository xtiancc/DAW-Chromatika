<?php

// Si es usuario individual se mostrará el contenido
if(comprobarusuario(0)) {

  insertarPortada("img/edit-1.jpg", "Su perfil Cromatika");

?>

  <div class="w-custom-1 m-auto text-justify">
    <p class="mx-2 py-5">¿Usuario o usuaria nuevo/a? ¡Enhorabuena! Está a un paso de obtener su <em>curriculum vitae</em> online. Este ha sido dividido en <strong>diferentes apartados</strong> y cada uno, cuenta con información útil para que su <em>currículum</em> gane atractivo. Se recomienda leer la <strong>información completa</strong> para informarse de todos nuestros trucos y consejos.</p> 
    <p class="mx-2 pb-5">Si por el contrario, ya ha visitado nuestro sitio en otra ocasión, le recordamos que la edición no será efectuada hasta pulsar el botón de <strong>guardar cambios</strong>.</p> 
  </div>

<?php

  insertarPortada("img/edit-2.jpg", "Datos personales");

?>

  <div class="w-custom-1 m-auto text-justify">
    <p class="mx-2 py-5">En primer lugar, debe de indicar la <strong>familia profesional</strong> a la que pertenece y el <strong>diseño</strong>, así su perfil podrá ser visualizado por empresas del sector y tendrá un estilo diferente al resto de usuarios. ¿No está seguro de cual elegir? ¡No se preocupe! Estos pueden ser modificado con posterioridad.</p> 
    <p class="mx-2 pb-5">Por otro lado, según la <strong>Comisión Europea</strong>, los datos personales se componen de información ligada a una persona física que la identifica. A continuación, se muestra un formulario con los datos <strong>obligatorios</strong> a recoger. Una vez completada toda la información, pulse en <strong>guardar cambios</strong> para activar los siguientes apartados. </p> 
  </div>

  <div class="w-custom-1 m-auto">

<?php 

  // Necesario para conocer el listado de países, categorías y diseño 
  $query_p = "SELECT * FROM iso_pais";
  $res_p = $con->query($query_p);
  $query_c = "SELECT * FROM categoria";
  $res_c = $con->query($query_c);
  $query_s = "SELECT * FROM diseno";
  $res_s = $con->query($query_s);

  //Recogemos datos del formulario cuando se pulse el submit
  if(isset($_POST['submit_personal'])) {

    $user = $_SESSION['usuario'];
    $fam = $_POST['fam_prof'];
    $dis = $_POST['diseño'];
    $nom = $_POST['nombre'];
    $aps = $_POST['apellidos'];
    $dir = $_POST['direccion'];
    $loc = $_POST['localidad'];
    $cpa = $_POST['cod_pais'];
    $cod = $_POST['cod_postal'];
    // Array con todos los datos recogidos
    $array = [ "usuario" => comillado($user), "nombre" => comillado($nom),  "apellidos" => comillado($aps), "direccion" => comillado($dir), "localidad" => comillado($loc), "ID_pais" => comillado($cpa), "cod_postal" => $cod, "ID_cv" => comillado($dis), "ID_cat" => $fam];

    // Datos de la imagen y destino de la carpeta
    $img = $_FILES['archivo_img']['tmp_name'];
    $img_name = $_FILES['archivo_img']['name'];
    $img_type = $_FILES['archivo_img']['type'];
    $img_size = $_FILES['archivo_img']['size'];

    // Si el usuario subió una imagen
    if ($img) {

      // La imagen cambiará el nombre por el del usuario, la extensión será la misma
      $new_name = $user.".".substr($img_type, 6);
    
      // Añadir la imagen al array anterior
      $array = [ "usuario" => comillado($user), "nombre" => comillado($nom),  "apellidos" => comillado($aps), "direccion" => comillado($dir), "localidad" => comillado($loc), "ID_pais" => comillado($cpa), "cod_postal" => $cod, "ID_cv" => comillado($dis), "ID_cat" => $fam, "img_perfil" => comillado($new_name)];

      // Conocer el tamaño de la imagen para evitar imagenes demasiado grandes
      list($img_width, $img_height) = getimagesize($img);

      // Si el archivo no supera el MB o no supera el tamaño 200*200
      if ($img_size < 1000000 || $img_width < 200 || $img_height < 200) {

        // Si el archivo tiene el formato adecuado
        if ($img_type == "image/png" || $img_type == "image/jpg" || $img_type == "image/gif" || $img_type == "image/jpeg") {
          
          // La imagen se guarda en el directorio especificado
          $img_users = $_SERVER['DOCUMENT_ROOT'].'/img/users/';
          move_uploaded_file($img, $img_users.$new_name);

          // Dependiendo de si existe o no un ID, se creará o editará el mismo.
          if (isset($_SESSION['id'])) modificarDatos('perfil_datos', $array, $_SESSION['id']);
          else {

            insertarDatos("perfil_datos", $array);
            obtenerID($user);

          }

        }
        
        // Error si hay un problema con la extensión del archivo
        else {
          echo " <div class='img-error w-custom-1 m-auto pb-3 text-justify'><div class='alert alert-danger mx-3' role='alert'>
          <i class='far fa-comment-dots'></i> <strong>¡OPS! Algo no ha ido como esperábamos.</strong> Al parecer, su archivo es diferente a las extensiones disponibles (png o jpg). Por favor, modifique el archivo e intentelo de nuevo. 
          </div></div>";
        }
      } 
      
      // Error si hay un problema con el peso o tamaño del mismo
      else {
        echo " <div class='img-error w-custom-1 m-auto pb-3 text-justify'><div class='alert alert-danger mx-3' role='alert'>
        <i class='far fa-comment-dots'></i> <strong>¡OPS! Algo no ha ido como esperábamos.</strong> Al parecer, su archivo cuenta con un peso (1MB) o tamaño (200px*200px) superior a lo admitido. Por favor, modifique el archivo e intentelo de nuevo. 
        </div></div>";
      }
    }

    // Si el usuario no aloja una imagen, se almacena el array sin ella
    else {

      // Dependiendo de si existe o no un ID, se creará o editará el mismo.
      if (isset($_SESSION['id'])) modificarDatos('perfil_datos', $array, $_SESSION['id']);
      else {

        insertarDatos("perfil_datos", $array);
        obtenerID($user);
      
      }

    }
    
  }
    
  // Se muestra la información si el usuario tiene datos almacenados para poder editarlos. HACER FUNCION MOSTRAR DATOS.
  if (isset($_SESSION['id'])) {

    $id = $_SESSION['id'];

    // Información de datos personales asociada al usuario
    $query_datos = "SELECT nombre, apellidos, direccion, localidad, cod_postal, ID_pais, ID_cv, ID_cat FROM perfil_datos WHERE id='$id'";
    $res_datos = $con->query($query_datos);
    $dato = $res_datos -> fetch_array();
    
    // Información de experiencia asociada al usuario
    $query_experiencia = "SELECT * FROM perfil_experiencia WHERE ID_perfil=$id ORDER BY a_fin DESC";
    $res_exp = $con -> query($query_experiencia);
    
    // Información de formación asociada al usuario
    $query_formacion = "SELECT * FROM perfil_formacion WHERE ID_perfil=$id ORDER BY a_fin DESC";
    $res_form = $con -> query($query_formacion) or trigger_error($mysqli->error);
    
    // Información de idiomas asociada al usuario
    $query_lang = "SELECT p.idioma, p.ID_nivel, n.descr FROM perfil_idioma p INNER JOIN nivel_idioma n ON p.id_nivel = n.ID WHERE ID_perfil=$id";
    $res_lang = $con -> query($query_lang);
        
  }

?>

  </div>

<?php

  include("editprofile_p.php");

  insertarPortada("img/edit-3.jpg", "Experiencia" , "exp");

?>

  <div class="w-custom-1 m-auto text-justify">
    <p class="mx-2 py-5">¿Aún no has tenido oportunidad de empleo, pero has realizado algún tipo de <strong>trabajo temporal</strong>, <strong>prácticas</strong> o <strong>voluntariado</strong>? ¡Este es el lugar adecuado para indicarlo! Si por el contrario, eres una persona con un gran recorrido en diferentes empresas, únicamente se aconseja indicar las últimas, por lo que nos encargaremos de filtrar las más importantes.</p> 
    <p class="mx-2 pb-5">Es aconsejable poner la experiencia <strong>más reciente en primer lugar</strong>, pero no se preocupe, Cromatika se encargará de organizarlo todo automáticamente para optimizar su <em>currículum</em>. A continuación se muestra un listado de la misma, en la cual podrás <strong>modificar</strong>, <strong>borrar</strong> y <strong>añadir</strong> nueva información, pulsando en los respectivos botones.</p> 
  </div>

  <div class="w-custom-table m-auto px-2 pb-5">
    <table class="table table-striped text-center">
      <thead class="thead thead-dark">
        <tr>
          <th scope="col">Empresa</th>
          <th scope="col">Localidad</th>
          <th scope="col">Puesto</th>
          <th scope="col">Inicio</th>
          <th scope="col">Finalización</th>
          <th scope="col">Herramientas</th>
        </tr>
      </thead>
      <tbody>
        <?php if(isset($_SESSION['id']) && $res_exp->fetch_array() > 0) { 
          foreach ($res_exp as $experiencia) { ?>
            <tr>
              <th scope="row" class="align-middle"><?php echo $experiencia['nombre_esa']?></th>
              <td class="align-middle"><?php echo $experiencia['localidad']?></td>
              <td class="align-middle"><?php echo $experiencia['puesto']?></td>
              <td class="align-middle"><?php echo $experiencia['a_inicio']?></td>
              <td class="align-middle">
                <?php
                  if ($experiencia['a_fin'] == '0000-00-00') $experiencia['a_fin'] = 'Actualidad';
                  echo $experiencia['a_fin'];
                ?>
              </td>
              <td class="align-middle">
                <a href="borrar-experiencia-<?php echo $id ?>-<?php echo $experiencia['nombre_esa'] ?>" class="btn btn-secondary"> <i class="far fa-trash-alt"></i> </a>
              </td>
            </tr>
        <?php } } else { ?>
          <tr>
            <td colspan="100%" class="font-italic small">¡OPS! Al parecer no ha indicado ninguna experiencia.</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <?php if(isset($_SESSION['id'])) { ?>
    
      <!-- Solo si el usuario cuenta con datos personales, se podrá añadir nueva experiencia -->
      <a href="agregar-experiencia" class="btn btn-secondary ml-2"> <i class="fas fa-plus"></i> </a>
  
    <?php } ?>

  </div>

<?php

  insertarPortada("img/edit-4.jpg", "Formación" , "form");

?>

  <div class="w-custom-1 m-auto text-justify">
    <p class="mx-2 py-5">En formación académica debemos de destacar los <strong>títulos</strong> obtenidos y el <strong>centro</strong> dónde lo impartiste. Es importante que esta formación sea complementaria a la familia profesional seleccionada en el apartado de <strong>datos personales</strong> para evitar información redundante</p> 
    <p class="mx-2 pb-5">Es aconsejable poner la formación <strong>más reciente en primer lugar</strong>, pero no se preocupe, Cromatika se encargará de organizarlo todo automáticamente para optimizar su <em>currículum</em>. A continuación se muestra un listado de la misma, en la cual podrás <strong>modificar</strong>, <strong>borrar</strong> y <strong>añadir</strong> nueva información, pulsando en los respectivos botones.</p> 
  </div>

  <div class="w-custom-table m-auto px-2 pb-5">
    <table class="table table-striped text-center">
      <thead class="thead thead-dark">
        <tr>
          <th scope="col">Titulación</th>
          <th scope="col">Centro</th>
          <th scope="col">Localidad</th>
          <th scope="col">Inicio</th>
          <th scope="col">Finalización</th>
          <th scope="col">Herramientas</th>
        </tr>
      </thead>
      <tbody>
        <?php if(isset($_SESSION['id']) && $res_form -> fetch_array() > 0) { 
          foreach ($res_form as $formacion) { ?>
            <tr>
              <th scope="row" class="align-middle"><?php echo $formacion['titulacion']?></th>
              <td class="align-middle"><?php echo $formacion['escuela']?></td>
              <td class="align-middle"><?php echo $formacion['localidad']?></td>
              <td class="align-middle"><?php echo $formacion['a_inicio']?></td>
              <td class="align-middle">
                <?php
                  if ($formacion['a_fin'] == '0000-00-00') $formacion['a_fin'] = 'Actualidad';  
                  echo $formacion['a_fin'];
                ?>
              </td>
              <td class="text-center align-middle">
                <a href="borrar-formacion-<?php echo $id ?>-<?php echo $formacion['titulacion'] ?>" class="btn btn-secondary"> <i class="far fa-trash-alt"></i> </a>
              </td>
            </tr>
        <?php } } else { ?>
          <tr>
            <td colspan="100%" class="font-italic small">¡OPS! Al parecer no ha indicado ninguna formación.</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <?php if(isset($_SESSION['id'])) { ?>
    
      <!-- Solo si el usuario cuenta con datos personales, se podrá añadir nueva formación -->
      <a href="agregar-formacion" class="btn btn-secondary ml-2"> <i class="fas fa-plus"></i> </a>
  
    <?php } ?>

  </div>

<?php

  insertarPortada("img/edit-5.jpg", "Idiomas" , "lang");

?>

  <div class="w-custom-1 m-auto text-justify">
    <p class="mx-2 py-5">En este apartado debemos de destacar los <strong>idiomas</strong> que conocemos a día de hoy. Uno de los lenguajes que se puede indicar sería el <strong>idioma materno</strong>. Si conoces algún otro, puedes indicarlo en este apartado, aunque no cuentes con ninguna <strong>titulación</strong>.</p> 
    <p class="mx-2 pb-5">Es muy importante ser realista a la hora de indicar el <strong>nivel lingüístico</strong> informándose bien de cada uno de los niveles. Este puede ser un factor importante a la hora de la contratación en algunos sectores, por lo que es posible recibir entrevistas en cualquier idioma indicado.</p> 
  </div>

  <div class="w-custom-table m-auto px-2 pb-5">
    <table class="table table-striped">
      <thead class="thead thead-dark">
        <tr class="text-center">
          <th scope="col">Idioma</th>
          <th scope="col">Nivel</th>
          <th scope="col">Descripción</th>
          <th scope="col">Herramientas</th>
        </tr>
      </thead>
      <tbody>
        <?php if(isset($_SESSION['id']) && $res_lang->fetch_array() > 0) { 
          foreach ($res_lang as $idioma) { ?>
            <tr>
              <th scope="row" class="align-middle"><?php echo $idioma['idioma']?></th>
              <td class="align-middle"><?php echo $idioma['ID_nivel']?></td>
              <td class="align-middle"><?php echo $idioma['descr']?></td>
              <td class="text-center align-middle">
                <a href="borrar-idioma-<?php echo $idioma['idioma'] ?>" class="btn btn-secondary"> <i class="far fa-trash-alt"></i> </a>
              </td>
            </tr>
        <?php } } else { ?>
          <tr>
            <td colspan="100%" class="text-center font-italic small ">¡OPS! Al parecer no ha indicado ningún idioma.</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>

    <?php if(isset($_SESSION['id'])) { ?>

      <!-- Solo si el usuario cuenta con datos personales, se podrá añadir nuevos idiomas -->
      <a href="agregar-idioma" class="btn btn-secondary ml-2"> <i class="fas fa-plus"></i> </a>
  
    <?php } ?>

  </div>

<?php

}

// Si no es usuario individual se mostrará el error 404
else include("error404.php");

?>

