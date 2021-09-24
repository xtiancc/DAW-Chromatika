<?php

// Funcion para agregar una portada en diferentes partes de la web
function insertarPortada($img, $titulo, $id = false) { ?>
    
    <!-- Crea un titulo, agregando su respectiva imagen de fondo --> 
    <div class="w3-display-container">
    <img <?php if($id) echo "id='".$id."'"; ?> class="img-fluid full" src="<?php echo $img?>" alt="Fondo <?php echo $titulo?>">
        <div class="w3-display-middle w3-large">
            <h2 class="h-full"><?php echo $titulo?></h2>
        </div>
    </div>

<?php } 

// Función comillado (Necesario para enviar los arrays clave-valor a las funciones anteriores)
function comillado($valor) {

    return '\''.$valor.'\'';

}

?>
