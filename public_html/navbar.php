<nav id="top" class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/inicio">CROMATIKA</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarText">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="/sobre-nosotros">Sobre nosotros</a>
      </li>

<?php
      
      // Si existe sesión de usuario
      if (isset($_SESSION["usuario"])) {

        $user = $_SESSION['usuario'];
        
        // Se revisa qué tipo de usuario es (Individual - 0, Empresa - 1)
        $user_type = "SELECT admin FROM usuario WHERE usuario='".$user."'";
        $res_type = $con -> query($user_type);
        $type = $res_type -> fetch_array();

        // Si es individual, se mostrará el botón para modificar perfil
        if ($type['admin'] == '0') {

?>

          <li class="nav-item">
            <a class="nav-link" href="/editar-perfil">Modificar perfil</a>
          </li>

<?php
        }

        // Si es empresa, se mostrará el botón para filtrar usuarios
        else if ($type['admin'] == '1') {

?>

          <li class="nav-item">
          <a class="nav-link" href="/filtrado">Filtrar usuarios</a>
          </li>

<?php

        }

?>
        <li class="nav-item">
          <a class="nav-link" href="/mensajes-privados">
            Mensajería
          
<?php 

            // Comprobar si tiene algún mensaje sin leer
            if (isset($_SESSION['id'])) {

              $query_unread = "SELECT COUNT(*) AS total FROM `contactar` WHERE nombreR = '$user' AND visualizado = 0";
              $res_unread = $con -> query($query_unread);
              $comprobar_unread = $res_unread -> fetch_array();

              if ( $comprobar_unread['total'] > 0 ) {
                echo "<small>(".$comprobar_unread['total'].")</small>";
              }

            }

?>
        
          </a>
        </li>

<?php

      }

?>

    </ul>
    <span class="navbar-text">
    
<?php

      // Si no existe una sesión activa se mostrarán los botones de iniciar sesión y registrarse
      if (!isset($_SESSION["usuario"])) {
      
?>
      
        <a href="/iniciar-sesion" class="btn btn-outline-secondary">Iniciar sesión</a>
        <a href="/registro" class="btn btn-secondary">Registrarse</a>
      
<?php

      }

      // Si existe dicha conexión, se mostrará el saludo, su nombre de usuario y el botón para cerrar sesión
      else {

?>

      <span class="mr-3"> Saludos, 

<?php 

      // Si el usuario tiene ID (obligatoriamente debe de ser individual se muestra link a su perfil)
      if (isset($_SESSION["id"])) {
        
?>

        <a href="/perfil-<?php echo $_SESSION["id"]; ?>" class="font-weight-bold"><?php echo $_SESSION["usuario"]; ?></a>.

<?php
      
      } 

      // Si no cuenta ID (obligatoriamente debe de ser empresa) se muestra su nombre en negrita
      else {
        
?>

        <span class="font-weight-bold"><?php echo $_SESSION["usuario"];?></span>.

<?php 
    
    } 
    
?>

      </span>
      <a href="/desconectar" class="btn btn-secondary">Cerrar sesión</a>
      
<?php
        
      // Si se pulsa el botón desconectar anterior, se rompe la sesión y se redirige nuevamente al login
      if (isset($_GET['desconectar'])) {
          
        session_unset();
        session_destroy();
          
        header('location:index.php');
      }

    }
      
?>
      
    </span>
  </div>
</nav>

