<?php

if(comprobarUsuario(1)) {
    
insertarPortada("img/mensajeria-1.jpg", "Mensajería privada");

$id = $_GET['id'];
$activate = true;

// Nombre del receptor
$query_receptor = "SELECT usuario, CONCAT_WS(' ', nombre, apellidos) AS nombre_completo FROM perfil_datos WHERE ID = $id";
$res_receptor = $con -> query($query_receptor);
$dato = $res_receptor -> fetch_array();

// Fecha actual
$fecha = new DateTime();
$dia = $fecha->format('Y-m-d').'T'.$fecha->format('H:i');
$f_envio = $fecha->format('Y-m-d');
$h_envio = $fecha->format('H:i');

// Si el usuario pulsa el botón de envio 
if(isset($_POST['submit_m'])) {

    $receptor = $dato['usuario'];
    $mensaje = $_POST['m_contenido'];

    // Enviar el mensaje a la base de datos
    $query_mensaje = "INSERT INTO contactar(nombreE, nombreR, mensaje, fecha, visualizado) VALUES('$user','$receptor','$mensaje', '$dia', 0)";
    $res_mensaje = $con -> query($query_mensaje);

    echo " <div class='w-custom-1 m-auto pb-3 text-justify py-5'>
            <div class='alert alert-success mx-3' role='alert'> <i class='far fa-comment-dots'></i> <strong>¡Enhorabuena!</strong> Su mensaje se ha enviado correctamente y llegará al usuario lo más pronto posible. Gracias. </div></div>";

    $activate = false;

}

// Si no se ha enviado el mensaje
if ($activate) {

?>
<div class="w-custom-1 m-auto py-5">
    <form id="private" name="private" action="" method="post" class="mx-5">
            <!-- Receptor. Campo obligatorio y desactivado, selecciona el nombre dependiendo del ID de usuario -->
            <div class="form-group">
                <label for="m_receptor" class="font-weight-bold">Receptor</label>
                <input type="text" class="form-control" id="usuario_r" name="usuario_r" placeholder="<?php echo $dato['nombre_completo']; ?>" disabled>
            </div>
        <div class="form-row">
            <!-- Hora de envio. Campo obligatorio y desactivado, selecciona la hora de nuestro sistema -->
            <div class="form-group col-md-6">
                <label for="m_fecha" class="font-weight-bold">Fecha de envío</label>
                <input type="date" class="form-control" id="m_fecha" name="m_fecha" value="<?php echo $f_envio; ?>" disabled>
            </div>
            <div class="form-group col-md-6">
                <label for="m_hora" class="font-weight-bold">Hora</label>
                <input type="time" class="form-control" id="m_hora" name="m_hora" value="<?php echo $h_envio; ?>" disabled>
            </div>
        </div>
        <!-- Mensaje. Campo obligatorio, Campo obligatorio de máximo 500 caracteres -->
        <div class="form-group">
            <label for="m_contenido" class="font-weight-bold">Contenido del mensaje</label>
            <i class="fas fa-info-circle"  data-container="body" data-toggle="popover" data-placement="right" data-content="Por favor, recuerde que esta es una herramienta para fijar entrevistas o enviar datos de contacto a los diferentes usuarios. Un uso inadecuado de esta herramienta podría conllevar sanciones en el sitio."></i>
            <textarea class="form-control" id="m_contenido" name="m_contenido" rows="4" placeholder="Escriba su mensaje" maxlength="500"></textarea>
        </div>
        <div class="row">
            <div class="col">
              <a href="/mensajes-privados" class="btn btn-secondary mb-5">Cancelar</a>
            </div>
            <div class="col text-right">
              <input type="submit" id="submit_m" name="submit_m" class="btn btn-secondary mb-5" value="Enviar mensaje">
            </div>
          </div>
    </form>
</div>

<?php
}

// Se desactiva una vez se envie el mensaje
else {

?>

    <div class="w-custom-1 m-auto text-right pb-5">
      <a href="/mensajes-privados" class="btn btn-secondary mr-4">Volver al inicio</a>
    </div>

<?php 

}
}

// Si no es usuario empresa se mostrará el mensaje de error
else include("error404.php"); 
?>