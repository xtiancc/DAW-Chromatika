<?php 

// Si es usuario individual se mostrará el contenido
if(comprobarusuario(0)) {

  insertarPortada("img/edit-5.jpg", "Idiomas");
  
?>

  <div class="w-custom-1 m-auto py-5 text-justify">
    <p class="mx-2">Cada apartado del <strong>idioma</strong> debe de estar compuesto por su nombre y el nivel de dicha competencia lingüistica, siendo el nivel A1 y A2 los más básicos y C1 y C2 los más avanzados. Cabe destacar que no es necesario contar con un titulo que lo certifique, pero si es <strong>recomendable</strong>. Usted debe de ser <strong>sincero</strong> al añadir una nueva lengua, ya que las empresas podrían acordar con usted entrevistas en cualquiera de los idiomas indicados.</p> 
  </div>

<?php 

  $op = $_GET['op'];
  $activate = true;

  // Necesario para conocer el nivel lingüistico y su descripción en el select
  $query_nivel = "SELECT * FROM nivel_idioma";
  $res_nivel = $con->query($query_nivel);

  // Dependiendo de la variable op que se pase por parámetro, se realizará una acción u otra
  switch($op) {

    case "add";
    if (isset($_POST['submit_lang'])) {
     
        $id = $_SESSION['id'];
        $lang = $_POST['i_name'];
        $lang_id = $_POST['i_autoev'];
        $array = [ "ID_perfil" => $id, "idioma" => comillado($lang), "ID_nivel" => comillado($lang_id)];

        // Se inserta información en nuestra base de datos
        insertarDatos("perfil_idioma", $array);
        $activate = false;
    
    }
    break;
    case "del";
    
      $id = $_SESSION['id'];
      $lang = $_GET['lang'];
      $array = ["ID_perfil" => $id, "idioma" => comillado($lang)];
    
      if (isset($_POST['delete_lang'])) {
        
        // Se borra la información de nuestra base de datos
        borrarDatos("perfil_idioma", $array);
        $activate = false;
    
      }
    break;
    
  }

  // Si la op pasada por parámetro es add, se mostrará el formulario
  if ($_GET['op'] == 'add' && $activate) {
    
?>

    <div class="w-custom-1 m-auto py-4">
      <form id="idioma" name="idioma" action="" method="post" class="mx-5">
        <div class="form-row">
          <!-- Idioma. Campo obligatorio de máximo 20 caracteres, únicamente letras -->
          <div class="form-group col-md-4">
            <label for="i_name" class="font-weight-bold">Idioma</label>
            <input type="text" class="form-control" id="i_name" name="i_name" placeholder="Lengua conocida" maxlength="20">
          </div>
          <!-- Autoevaluación. Campo obligatorio, valores definidos en la bbdd -->
          <div class="form-group col-md-8">
            <label for="i_autoev" class="font-weight-bold">Autoevaluación</label>
            <select class="form-control" id="i_autoev" name="i_autoev">
              <option selected hidden disabled value>Seleccione nivel de competencia lingüistica </option>
                <?php foreach ($res_nivel as $nivel) { ?>
                  <option value="<?php echo $nivel['ID']?>"><?php echo $nivel['ID'].". ".$nivel['descr']; ?></option>
                <?php } ?>
            </select>
          </div>
        </div>
        <div class="container"> 
          <div class="row">
            <div class="col">
              <a href="/editar-perfil" class="btn btn-secondary mb-5">Volver al inicio</a>
            </div>
            <div class="col text-right">
              <input type="submit" id="submit_lang" name="submit_lang" class="btn btn-secondary mb-5" value="Guardar cambios">
            </div>
          </div>
        </div>
      </form>
    </div>


<?php

  } 
  // Si la op pasada por parámetro es del, se mostrará un mensaje informando de que se borrará la información
  else if ($_GET['op'] == 'del' && $activate) { ?>

    <div class='w-custom-1 m-auto pb-3 text-justify'>
      <div class='alert alert-danger mx-3' role='alert'>
        <i class='far fa-comment-dots'></i> <strong>Hemos detectado una solicitud para borrar el registro sobre su nivel de <em><?php echo $lang; ?></em>.</strong>
        Si desea proceder, por favor, pulse en el botón borrar registro, en caso contrario, haga clic en volver al inicio.</div></div>
        <div class='w-custom-1 m-auto text-right pb-5'>
          <form name="delete_lang" action="" method="post">
            <a href='/editar-perfil' class='btn btn-secondary mr-2'>Volver al inicio</a>
            <input type='submit' id='delete_lang' name='delete_lang' class='btn btn-secondary mr-4' value='Borrar registro'>
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

