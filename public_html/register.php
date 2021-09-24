<?php

// Si aún no hay una sesión activa, se mostrará el contenido
if (!isset($_SESSION["usuario"])) {

    insertarPortada("img/register-1.jpg", "Únete a nosotros");

?>

<div class="w-custom-1 m-auto py-5 text-justify">
    <p class="mx-2">Agradecemos su confianza en <strong>Cromatika</strong> y estamos agradecidos de que desees formar parte de esta <strong>gran familia</strong> . Una vez realizado el registro, podrás iniciar sesión y utilizar las funcionalidades que ofrece el sitio. Por favor, si tienes algún problema no dude en contactar con nosotros  través de nuestro teléfono fijo <strong>950 524 578</strong> o enviando un correo a <strong>info@cromatikacv.com</strong>.</p> 
</div>

<div class="w-custom-1 m-auto pb-5">

<?php

    if(isset($_POST['submit_register'])) {

        // Se recogen la información enviada mediante POST
        $user = $_POST['register_u'];
        $mail = $_POST['register_m'];
        $pass = md5($_POST['register_p']);
        $type = $_POST['register_t'];

        // Se comprueba que no exista el nombre de usuario o email en nuestra base de datos
        $comprobacion = "SELECT COUNT(*) AS total FROM usuario WHERE usuario = '$user' OR email = '$mail'";
        $res_comprobacion = $con -> query($comprobacion);
        $coincidencias = $res_comprobacion -> fetch_array();
    
        // Si no existen coincidencias, se comienza el proceso de registro
        if ($coincidencias['total'] == 0) {

            $registro = "INSERT INTO usuario VALUES('$user','$mail','$pass', $type)";
            $reg_usuario = $con -> query($registro);

            echo " <div class='w-custom-1 m-auto pb-3 text-justify'>
            <div class='alert alert-success mx-3' role='alert'> <i class='far fa-comment-dots'></i> <strong>¡Enhorabuena!</strong> Su registro se ha realizado con éxito. Por favor, proceda a iniciar sesión.</div></div>";
        }
        // Si existe coincidencias, se lanza un mensaje de error
        else {
        echo " <div class='w-custom-1 m-auto pb-3 text-justify'>
        <div class='alert alert-danger mx-3' role='alert'> <i class='far fa-comment-dots'></i> <strong>¡OPS! Algo no ha ido como esperábamos.</strong> Parece ser que el nombre de usuario o correo electrónico ya está siendo utilizado. Por favor, inténtelo de nuevo.</div></div>";
        }
    }

?>

    <form id="register" name="register" action="" method="post" class="mx-5">
        <!-- Nombre de usuario. Campo obligatorio de 8-20 carácteres. Solo letras y números -->
        <div class="form-group">
            <label for="register_u" class="font-weight-bold">Usuario</label>
            <input type="text" class="form-control" id="register_u" name="register_u" placeholder="Nombre de usuario" maxlength="20">
        </div>
        <!-- Correo electronico. Campo obligatorio. Debe incluir un @, un . y el dominio (com, es, etc) -->
        <div class="form-group">
            <label for="register_m" class="font-weight-bold">E-mail</label>
            <input type="text" class="form-control" id="register_m" name="register_m" placeholder="Correo electronico">
        </div>
        <!-- Contraseña. Campo obligatorio de 8-32. Mínimo una letra mayúscula y un número -->
        <div class="form-group">
            <label for="register_p" class="font-weight-bold">Contraseña</label>
            <input type="password" class="form-control" id="register_p" name="register_p" placeholder="Contraseña" maxlength="32">
        </div>
        <!-- Tipo de usuario. Campo obligatorio -->
        <div class="form-group">
            <label for="register_t" class="font-weight-bold">Tipo de usuario</label>
            <i class="fas fa-info-circle" data-container="body" data-toggle="popover" data-placement="right" data-content="Si selecciona usuario individual, contarás con un perfil personal el cuál mostrará toda la información ofrecida a modo de curriculum vitae. Si selecciona usuario empresa, accederás automáticamente a nuestro filtro de usuarios."></i>
            <select class="form-control" id="register_t" name="register_t">
                <option selected hidden disabled value>Seleccione tipo de usuario</option>
                <option value="0">Individual</option>
                <option value="1">Empresa</option>
            </select> 
        </div>
        <!-- Terminos y condiciones del sitio. Campo obligatorio -->
        <div class="form-checkbox text-right">
            <label for="register_tc" class="pr-4">Acepto los <a href="#" class="font-weight-bold">terminos y condiciones del sitio</a> web Cromatika</label>
            <input class="form-check-input" type="checkbox" id="register_tc" name="register_tc">
        </div>
        <div class="d-flex justify-content-end">
            <input type="submit" id="submit_register" name="submit_register" class="btn btn-secondary btn-lg mt-3" value="Registrarse">
        </div>
    </form>
</div>

<?php 

} 

// Si existe una sesión activa se mostrará el error 404
else include("error404.php");

?>