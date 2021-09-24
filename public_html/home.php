<?php

insertarPortada("img/home-1.jpg", "Cromatika");

?>

<div class="w-custom-1 m-auto py-5 text-justify">
    <p class="mx-2">Le damos la bienvenida a <strong>Cromatika</strong>, la primera red social en la que podrás crear, en diferentes estilos, tu propio CV y almacenarlo en la nube. Utilízalo como medio para obtener empleo y serás contactado por numerosas empresas de tu sector. ¿Quieres unirte a nosotros?</p>
</div>

<div class="d-flex justify-content-center">
    <a href="/iniciar-sesion" class="btn btn-outline-secondary btn-lg mr-3">Iniciar sesión</a>
    <a href="/registro" class="btn btn-secondary btn-lg">Únete a nosotros</a>
</div>

<div class="w-custom-1 m-auto pt-5 text-justify">
    <p class="mx-2">Conoce algunas de nuestras plantillas de <em>curriculum vitae</em>:</p>
</div>

<div class="d-flex justify-content-center p-4">
    <img src="img/cv-1.png" alt="Ejemplo de Curriculum 1" class="img-thumbnail image-size">
    <img src="img/cv-2.png" alt="Ejemplo de Curriculum 2" class="img-thumbnail mx-4 image-size">
    <img src="img/cv-3.png" alt="Ejemplo de Curriculum 3" class="img-thumbnail image-size">
</div>

<?php

insertarPortada("img/home-2.jpg", "¿Buscas un nuevo empleo?");

?>

<div class="w-custom-1 m-auto pt-5 text-center">
    <i class="fa-rb fas fa-search fa-5x"></i>
</div>

<div class="w-custom-1 m-auto py-5 text-justify">
    <p class="mx-2">¿Estás preparado para <strong>aprender</strong> a realizar un buen curriculum vitae? Durante el proceso aprenderás <strong>trucos y consejos</strong> para que tu perfil sea más atractivo. Automáticamente obtendrás un <strong>perfil</strong> con tus datos y además podrás descargarlo en tu ordenador para imprimir.</p>
</div>

<?php

insertarPortada("img/home-3.jpg", "Si eres una empresa...");

?>

<div class="w-custom-1 m-auto pt-5 text-center">
    <i class="fa-rb fas fa-print fa-5x"></i>
</div>

<div class="w-custom-1 m-auto py-5 text-justify">
    <p class="mx-2">Si eres un negocio, estás en el lugar indicado. Utiliza nuestro <strong>filtro</strong> y descarga un <strong>listado completo</strong> de usuarios dependiendo de tus necesidades. Con tan solo un clic, podrás contactar con cualquier usuario del sitio, convirtiendo Cromatika en una herramienta indispensable para cualquier departamento de recursos humanos.</p>
</div>

<?php

insertarPortada("img/home-4.jpg", "Nuestros datos");

// Información necesaria para mostrar: Total individuales, total empresa, total mensajes privados
$query_reg = "SELECT COUNT(usuario) AS total FROM usuario GROUP BY admin;";
$res_reg = $con->query($query_reg);
$query_msg = "SELECT COUNT(id) AS total FROM contactar";
$res_msg = $con->query($query_msg);

$cont = 0;
while ($fila = $res_reg -> fetch_array()) {
    $resT[$cont] = $fila[0];
    $cont++;
}

$msgTotal = $res_msg -> fetch_array();

?>

<div class="container py-5">
    <div class="row text-center">
        <div class="col-sm">
            <i class="fa-rb fas fa-users fa-5x m-3"></i>
            <p><?php echo $resT[0];?> perfil/es creados en la actualidad</p>
        </div>
        <div class="col-sm">
            <i class="fa-rb fas fa-store-alt fa-5x m-3"></i>
            <p><?php echo $resT[1]?> empresa/s ya han confiado en nosotros</p>
        </div>
        <div class="col-sm">
            <i class="fa-rb far fa-check-circle fa-5x m-3"></i>
            <p><?php echo $msgTotal[0]?> entrevista/s concertadas a través de nuestro sitio</p>
        </div>
    </div>
</div>