<?php 

// Función INSERT INTO
function insertarDatos( $tabla, $array) {

    require "conexion.php";

    // Creamos la query
    $query = "INSERT INTO $tabla (";
    foreach ($array as $key => $value) {
        $query .= $key;
        if ( key(array_slice($array, -1, 1, true)) != $key) $query .= ', ';
    }
    $query .= ") VALUES (";
        foreach ($array as $key => $value) {
            $query .= $value;
            if (key(array_slice($array, -1, 1, true)) != $key) $query .= ', ';
        }
    $query .= ");";
    
    // Para pruebas, desactivar el echo
    //echo $query;

    $resultado = $con -> query($query);
    
    // Si el registro es correcto, se lanza el siguiente mensaje
    if ($resultado) echo " <div class='w-custom-1 m-auto pb-3 text-justify'><div class='alert alert-success mx-3' role='alert'>
    <i class='far fa-comment-dots'></i> <strong>¡Enhorabuena!</strong> La información se ha guardado correctamente y pronto será visible en su perfil.
    </div></div>";
    // Si no es correcto, el mensaje dependerá de la tabla, cuenta con mensaje personalizado
    else { echo " <div class='w-custom-1 m-auto pb-3 text-justify'><div class='alert alert-danger mx-3' role='alert'>
    <i class='far fa-comment-dots'></i> <strong>¡OPS! Algo no ha ido como esperábamos.</strong> Compruebe los datos insertados e inténtelo de nuevo. ";
    if ($tabla == 'perfil_experiencia') echo "<em>Por favor, compruebe que los campos de empresa y puesto no coincidan con registros anteriores</em>. ";
    if ($tabla == 'perfil_formacion') echo "<em>Por favor, compruebe que el campo de titulo no coincida algún registro anterior</em>. ";
    if ($tabla == 'perfil_idioma') echo "<em>Por favor, compruebe que el campo de idioma no coincida algún registro anterior</em>. ";
    echo "Gracias.</div></div>";
    }
       
}

// Función UPDATE
function modificarDatos($tabla, $array, $id) {

    require "conexion.php";

    // Creamos la query
    $query = "UPDATE $tabla SET ";
    $query .= urldecode(http_build_query($array,"",", "));
    $query .= " WHERE ID = $id";
    
    // Para pruebas, desactivar el echo
    //echo $query;

    $resultado = $con -> query($query);
    
    // Si el registro es correcto, se lanza el siguiente mensaje
    if ($resultado) echo " <div class='w-custom-1 m-auto pb-3 text-justify'><div class='alert alert-success mx-3' role='alert'>
    <i class='far fa-comment-dots'></i> <strong>¡Enhorabuena!</strong> Los cambios han sido efectuados y pronto serán visibles en su perfil.
    </div></div>";
    // Si el registro no es correcto, se lanza el siguiente mensaje
    else echo " <div class='w-custom-1 m-auto pb-3 text-justify'><div class='alert alert-danger mx-3' role='alert'>
    <i class='far fa-comment-dots'></i> <strong>¡OPS! Algo no ha ido como esperábamos.</strong> Compruebe los datos insertados e inténtelo de nuevo. Gracias.
    </div></div>";

}

// Función DELETE FROM
function borrarDatos($tabla, $array) {

    require "conexion.php";

    // Creamos la query
    $query = "DELETE FROM $tabla WHERE ";
    $query .= urldecode(http_build_query($array,""," AND "));
    
    // Para pruebas, desactivar el echo
    //echo $query;
    
    $resultado = $con -> query($query);

    // Si el registro es correcto, se lanza el siguiente mensaje
    if ($resultado) echo " <div class='w-custom-1 m-auto pb-3 text-justify'><div class='alert alert-success mx-3' role='alert'>
    <i class='far fa-comment-dots'></i> <strong>¡Gracias!</strong> El registro ha sido borrado correctamente y tan pronto como sea posible dejará de ser visible en su perfil.
    </div></div>";
}


// Funcion para comprobar si el usuario es de tipo 0 (individual) para acceder a diferentes apartados exclusivos
function comprobarUsuario($tipo) {

    require('conexion.php');
    
    if (isset($_SESSION['usuario'])) {

        // Comprobar el tipo de usuario
        $user = $_SESSION['usuario'];
        $query = "SELECT admin FROM usuario WHERE usuario = '$user'";
        $res_ind = $con -> query($query);
        
        $coincidencias = $res_ind -> fetch_array();
    
        // Si es tipo individual, devuelve true y permite mostrar el contenido
        if ($coincidencias['admin'] == $tipo) {
            return true;
        }
    }
}


// Función para obtener el ID de usuario
function obtenerID($usuario){

    require('conexion.php');

    // Se comprueba si el usuario tiene algún id de perfil asociado (en otra tabla)
    $id_user = "SELECT id FROM perfil_datos WHERE usuario='$usuario'";
    $res_id = $con -> query($id_user);
    $res_id_user = $res_id -> fetch_array();

    // Si existe, se añade a la sesión el id
    if ($res_id_user['id'] > 0) {
        
        $id = $res_id_user['id'];
        $_SESSION["id"] = "$id";
    
    }

}