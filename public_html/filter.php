<?php

// Si es usuario empresa se mostrará el contenido
if(comprobarUsuario(1)) {

	insertarPortada("img/filter-1.jpg", "Filtrado de usuarios");

	// Necesario para conocer el listado de categorías
	$query_fam = "SELECT * FROM categoria";
	$res_fam = $con->query($query_fam);

?>

<div class="w-custom-1 m-auto text-justify">
	<p class="mx-2 py-5">El <strong>Catálogo Nacional de Cualificaciones Profesionales</strong>, agrupa las distintas áreas profesionales en pequeños segmentos llamados <em>Familias Profesionales</em>. Actualmente, existen un <strong>total de 26 familias</strong>. En Cromatika, creemos que es prioritario ofrecer información adaptada a las necesidades de cualquier empresa. Por este mismo motivo, es posible <strong>filtrar a todos los usuarios</strong> dependiendo de la familia a la que pertenezca.</p>
	<p class="mx-2 pb-5">Esto generará una tabla con los <strong>potenciales trabajadores</strong>, los cuales podrás visualizar su perfil de forma más detallada, o <strong>guardar un archivo</strong> en cualquier dispositivo con todos los posibles candidatos.</p>
</div>

<div class="w-custom-1 m-auto pb-5">
	<form name="filtro" method="post" class="form-inline mx-5">
		<div class="form-group">
			<label for="fam_prof" class="font-weight-bold">Familia profesional: </label>
			
			<select class="custom-select mx-2" name="fam_prof" id="fam_prof">
				<?php foreach ($res_fam as $familia) { ?>
					<option value="<?php echo $familia['ID'] ?>" <?php if (isset($_POST['fam_prof']) && $_POST['fam_prof'] == $familia['ID']) echo "selected"; ?>> <?php echo $familia['nombre']; ?> </option>
				<?php } ?>
			</select>
		</div>
		<input type="submit" name="submit_filtro" class="btn btn-secondary" value="Filtrar">
	</form>
</div>

<?php 

	// Si se pulsa en el botón filtrar 
	if (isset($_POST['submit_filtro'])) { 

		$categoria = $_POST['fam_prof'];

		// Datos personales necesarios para mostrar en la tabla: Nombre completo
		$query_nombre = "SELECT ID, CONCAT_WS(' ', nombre, apellidos) AS nombre_completo FROM perfil_datos WHERE ID_cat=$categoria";
		$res_nombre = $con->query($query_nombre);

?>

<div class="w-custom-table m-auto px-2 pb-5">

	<!-- Pequeño icono de carga temporal para carga de datos -->
	<div class="res_loader text-center">
	<i class="fas fa-spinner fa-pulse fa-4x text-dark"></i>
	</div>
	
	<!-- Tabla a mostrar: Nombre completo, títulos y años de experiencia en el sector -->
	<div class="res_tabla" style="display:none;">
    	<table class="table table-striped">
      		<thead class="thead thead-dark">
        		<tr class="text-center">
          			<th scope="col">Nombre completo</th>
          			<th scope="col">Estudios</th>
          			<th scope="col">Experiencia (años)</th>
        		</tr>
      		</thead>
      		<tbody>

<?php 

			// Si existe algún registro con dichos filtros
			if ($res_nombre -> fetch_array() > 0 ) {

				// Se muestran cada uno de ellos
				foreach ($res_nombre as $nombre) {
				
?>

            	<tr>
              		<th scope="row" class="align-middle"> <a href="perfil-<?php echo $nombre['ID']; ?>" target="_blank" class="link-profile"><?php echo $nombre['nombre_completo']; ?></a></th>
              		<td class="align-middle">
			  
<?php 

					// Buscar los datos de formación correspondientes a dicho usuario
					$id = $nombre['ID'];
					$query_formacion = "SELECT titulacion FROM perfil_formacion WHERE ID_perfil = $id";
					$res_formacion = $con -> query($query_formacion);
	                $total_formacion = $res_formacion -> fetch_array();
	                
	                if ($total_formacion['titulacion']) {
					    // Se muestra cada una de la formación en la tabla, una bajo otra
					    foreach ($res_formacion as $titulo) {
						    echo $titulo['titulacion']."<br>";
					    }
	                }
	                else echo "<em>No aporta</em>";
?>			  

			  		</td>
              		<td class="align-middle text-center">
              		    
<?php 

					// Buscar los datos de experiencia correspondientes a dicho usuario
					$query_experiencia = "SELECT SUM(YEAR(a_fin) - YEAR(a_inicio)) AS exp_total FROM perfil_experiencia WHERE ID_perfil=$id";
					$res_experiencia = $con -> query($query_experiencia);
                    $total_exp = $res_experiencia -> fetch_array();
                
					// Se muestra cada una de la formación en la tabla, una bajo otra, si no existe, se pone 0
					if ($total_exp['exp_total']) echo $total_exp['exp_total'];
					else echo "-";

?>
              		    
              		    
              		</td>
            	</tr>
            
<?php
	
			    }
		
?>		    

            </tbody>
    	</table>

		<div class="d-flex justify-content-end">
		    <a href="/exportar-categoria/<?php echo $categoria; ?>" target="_blank" class="btn btn-secondary ml-2">Descargar</a>
		</div>
		
<?php

			}
		    // Si no existe algún registro con dichos filtros
		    else {
		
?>

          	    <tr>
            	    <td colspan="100%" class="text-center font-italic small ">¡OPS! Al parecer no hay usuarios que se adapten a estos filtros.</td>
          	    </tr>
            </tbody>
    	</table>

<?php 

		}
		
?>
    
    </div>

<?php

	}
}

// Si no es usuario individual se mostrará el error 404
else include("error404.php");

?>