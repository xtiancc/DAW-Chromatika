<div class='w-75 m-auto py-5 text-justify'>
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading font-weight-bold">  <i class='fas fa-ban'></i> ERROR 404: ¡OPS! Algo no ha ido como esperábamos...</h4>
        <p>

<?php 

            if (isset($_GET['act']) && $_GET['act'] == 'mp') { echo "No está permitido enviar mensajes privados si no se ha registrado previamente, ¿Por que no se anima a formar parte de esta gran familia?"; }
            else echo "Parece ser que has llegado a la página equivocada.";

?>

            Se redirigirá automáticamente a la pagina de inicio, gracias.</p>
    </div>
</div>
