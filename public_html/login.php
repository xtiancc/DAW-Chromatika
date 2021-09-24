<?php

// Si aún no hay una sesión activa, se mostrará el contenido
if (!isset($_SESSION["usuario"])) {

    insertarPortada("img/login-1.jpg", "Inicia sesión");

?>

<div class="w-custom-1 m-auto py-5 text-justify">
    <p class="mx-2">Para iniciar sesión en nuestro sitio web, primeramente se debe de haber cumplimentado el <strong>formulario de registro</strong>. Únicamente será necesario indicar su <strong>nombre de usuario y contraseña</strong> para poder acceder a las diferentes funcionalidades del sitio. Esperamos que disfrutes del sitio.</p> 
</div>

<?php

if(isset($_POST['submit_login'])) {
    
    $user = $_POST['login_u'];
    $pass = md5($_POST['login_p']);

    // Se comprueba que existe algún registro con las credenciales aportadas.
    $sesion = "SELECT COUNT(*) AS total FROM usuario WHERE usuario = '$user' AND contrasena = '$pass'";
    $res_sesion = $con -> query($sesion);
    $coincidencias = $res_sesion -> fetch_array();

    // Si existe alguno se crea la sesión
    if ($coincidencias['total'] > 0) {
        
        $sesion_usuario = strtolower($user);
        $_SESSION["usuario"] = "$sesion_usuario";
        
        // Obtener ID de usuario para mostrar URL al perfil
        obtenerID($user);

        // Se envia a la página principal
        header("location:/inicio");
        
    }

    // Si no existe ningún registro con dichas credenciales se muestra error
    else {

		echo " <div class='w-custom-1 m-auto pb-3 text-justify'>
         <div class='alert alert-danger mx-3' role='alert'> <i class='far fa-comment-dots'></i> <strong>¡OPS! Algo no ha ido como esperábamos.</strong> Parece que la información introducida no coincide con los datos de nuestro servidor. Por favor, inténtelo de nuevo.</div></div>";
    
    }
       
}

?>

<div class="w-custom-1 m-auto pb-5">
    <form id="login" name="login" action="" method="post" class="mx-5">
        <!-- Nombre de usuario. Campo obligatorio de 8-20 carácteres. Solo letras y números -->
        <div class="form-group">
            <label for="login_u" class="font-weight-bold">Usuario</label>
            <input type="text" class="form-control" id="login_u" name="login_u" placeholder="Nombre de usuario" maxlength="20">
        </div>
        <!-- Contraseña. Campo obligatorio de 8-32. Mínimo una letra mayúscula y un número -->
        <div class="form-group">
            <label for="login_p" class="font-weight-bold">Contraseña</label>
            <input type="password" class="form-control" id="login_p" name="login_p" placeholder="Contraseña" maxlength="32">
        </div>
        <div class="d-flex justify-content-end">
            <input type="submit" id="submit_login" name="submit_login" class="btn btn-secondary btn-lg mt-3" value="Iniciar sesión">
        </div>
    </form>
</div>

<?php

} 

// Si existe una sesión activa se mostrará el error 404
else include("error404.php");

?>
