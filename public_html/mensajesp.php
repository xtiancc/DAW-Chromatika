<?php

// Si aún no hay una sesión activa, se mostrará el contenido
if (isset($_SESSION["usuario"])) {

    $user = $_SESSION['usuario'];
    insertarPortada("img/mensajeria-1.jpg", "Mensajería privada");

    // Si es usuario individual tiene dos opciones
    if(comprobarUsuario(0)) {
    
?>

<div class="w-custom-1 m-auto py-5 text-justify">
    <p class="mx-2">Tal y como le prometimos, en este apartado encontrarás los <strong>mensajes privados</strong> de las empresas interesadas en usted. Recuerda visitar este apartado de <strong>forma periódica</strong>, ya que podrá recibir algo en cualquier momento.</p>  
    <p class="mx-2 mt-5">Le recordamos, que por el momento, estos mensajes son <strong>unidireccionales</strong>, pero dentro de ellos encontrarás toda la información referente a: Datos de contacto, datos de entrevista, etc.</p>  
</div>

<?php
        //tiene id, podrá recibir mensajes.
        if (isset($_SESSION['id'])) {

            // Obtener todos los mensajes privados pertenecientes al ID
            $query_mp_ind = "SELECT nombreE, mensaje, fecha, visualizado FROM contactar WHERE nombreR = '$user' ORDER BY fecha DESC";
            $res_mp_ind = $con -> query($query_mp_ind);

?>

<div class="w-custom-table m-auto px-2 pb-5" style="border-collapse:collapse;">
    <table class="table table-striped">
        <thead class="thead thead-dark">
            <tr class="text-center">
                <th scope="col">Usuario emisor</th>
                <th scope="col">Fecha envío</th>
                <th scope="col">Hora envío</th>
                <th scope="col">Estado</th>
            </tr>
        </thead>
        <tbody>

<?php

            if($res_mp_ind -> fetch_array() > 0) { 
        
                $num_ind = 1;

                foreach ($res_mp_ind AS $mp) {
                        
?>
            
            <tr data-toggle="collapse" data-target="#ind<?php echo $num_ind ?>" class="accordion-toggle">
                <td class="px-3 <?php if ($mp['visualizado'] == 0) echo 'font-weight-bold'; ?>"> <?php echo $mp['nombreE']; ?></td>
                <td class="text-center <?php if ($mp['visualizado'] == 0) echo 'font-weight-bold' ?> "> <?php echo date("d/m/Y", strtotime($mp['fecha'])); ?></td>
                <td class="text-center <?php if ($mp['visualizado'] == 0) echo 'font-weight-bold' ?> "> <?php echo date("H:i", strtotime($mp['fecha'])); ?></td>
                <td class="text-center">
                
<?php

                // Si no ha sido visualizado (0), se muestra el sobre cerrado
                if ( $mp['visualizado'] == 0 ) {
                    echo "<i class='fas fa-envelope'></i>";
                }
                // Si ha sido visualizado (1), se muestra el sobre abierto
                else {
                    echo "<i class='far fa-envelope-open'></i>";
                }
?>
              
                </td>
            </tr>

            <tr>
                <td colspan="4" class="hiddenRow p-0">
                    <div class="accordian-body collapse" id="ind<?php echo $num_ind; ?>"> 
                        <p class="p-3"> <strong>Mensaje: </strong>  <?php echo $mp['mensaje']; ?></p>
                    
                    </div>
                </td>
            </tr>
<?php

                $num_ind++;
                
            }

        // Una vez ha sido mostrada la info al usuario, se actualiza el visualizado a 1 (lo han visualizado y no aparecerá nuevamente el icono de nuevo)
        $query_actualizar = "UPDATE contactar SET visualizado = 1 WHERE nombreR = '$user' AND visualizado = 0 ";
        $res_actualizar = $con -> query($query_actualizar);
        
        } else {
            
?>

            <tr>
              <td colspan="100%" class="text-center font-italic small ">¡OPS! Al parecer no recibido ningún mensaje por el momento.</td>
            </tr>

<?php 

        }
   
?>
        </tbody>
    </table>
</div>

<?php 

        }
        
        //No tiene ID y no podrá recibir mensajes. Animar a completar el perfil
        else {

?>

            <div class='w-75 m-auto pb-5 text-justify'>
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading font-weight-bold"> <i class='fas fa-ban'></i> ERROR 404: ¡OPS! Algo no ha ido como esperábamos...</h4> 
                    <p>Parece ser que no ha completado su perfil. Si no incluye sus datos personales, no podrá recibir ningún tipo de mensaje. ¿No sabe como crear su perfil? Por favor, navege a <a href="/editar-perfil" class="alert-warning font-weight-bold">Modificar perfil</a> </p>
                </div>
            </div>

<?php

        }
    
    }
    
    // No es usuario tipo 0, por defecto es tipo 1, empresa.
    else {

?>

        <div class="w-custom-1 m-auto py-5 text-justify">
    <p class="mx-2"> <?php if (!isset($_GET['id'])) { echo "A continuación se muestra un listado de los <strong>mensajes envíados</strong> en los últimos meses."; } ?> Le recordamos que para <strong>proceder al envío</strong>, debes de visitar previamente el perfil del usuario. ¿No sabes cómo? Accede al apartado <em>Filtrar usuarios</em>, selecciona una familia profesional y pulsa sobre su nombre. Si ya cuenta con el link del perfil, únicamente visítelo y pulse sobre <em>Enviar mensaje privado</em>.</p>  
            <p class="mx-2 mt-5">Le recordamos, que por el momento, estos mensajes son <strong>unidireccionales</strong>, por lo que el usuario no podrá responderte. Por este motivo, es importante incluir datos sobre: Datos de contacto, datos de entrevista, etc.</p>  
        </div>

<?php 

            // Obtener todos los mensajes privados pertenecientes al ID
            $query_mp_emp = "SELECT nombreR, mensaje, fecha FROM contactar WHERE nombreE = '$user' ORDER BY fecha DESC";
            $res_mp_emp = $con -> query($query_mp_emp);

?>

            <div class="w-custom-table m-auto px-2 pb-5" style="border-collapse:collapse;">
                <table class="table table-striped">
                    <thead class="thead thead-dark">
                        <tr class="text-center">
                            <th scope="col">Usuario emisor</th>
                            <th scope="col">Fecha envío</th>
                            <th scope="col">Hora envío</th>
                        </tr>
                    </thead>
                <tbody>

<?php

            if($res_mp_emp -> fetch_array() > 0) { 
        
                $num_emp = 1;
                foreach ($res_mp_emp AS $mp) {
                        
?>
            
                    <tr data-toggle="collapse" data-target="#emp<?php echo $num_emp ?>" class="accordion-toggle">
                        <td class="px-3"> <?php echo $mp['nombreR']; ?></td>
                        <td class="text-center"> <?php echo date("d/m/Y", strtotime($mp['fecha'])); ?></td>
                        <td class="text-center"> <?php echo date("H:i", strtotime($mp['fecha'])); ?></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="hiddenRow p-0">
                            <div class="accordian-body collapse" id="emp<?php echo $num_emp; ?>"> 
                                <p class="p-3"> <strong>Mensaje: </strong> <?php echo $mp['mensaje']; ?></p>
                            </div>
                        </td>
                    </tr>
<?php
    
                $num_emp++;

                }
            } else {
            
?>

                <tr>
                    <td colspan="100%" class="text-center font-italic small ">¡OPS! Al parecer no ha enviado ningún mensaje por el momento.</td>
                </tr>

<?php 

            }
            
?>

            </tbody>
        </table>
    </div>

<?php

        
    }
}

// Si existe una sesión activa se mostrará el error 404
else include("error404.php");

?>