<?php
 	header("Content-type: text/css");
 ?>

/* Universales */

html, body {
margin:0px;
height:95%;
}


.div-cont {
    background-color: #eee;
    min-height:95%;
}


/* Titulos con imágenes */

.full{
    width: 100%;
}

.h-full { 
    font-size: 60px;
    font-weight: 500;
    text-shadow: 1px 0 0 #ccc, -1px 0 0 #ccc, 0 1px 0 #ccc, 0 -1px 0 #ccc, 2px 2px 0 #ccc;
}

@media (max-width: 850px) {
    .h-full { 
    font-size: 40px;
    }
}

@media (max-width: 600px) {
    .h-full { 
    font-size: 25px;
    }
}


/* Ancho diferentes para contenido */

.w-custom-1 {
    max-width: 750px;
}

.w-custom-2 {
    max-width: 1100px;
}

.w-custom-table {
    max-width: 1000px;
}

/* Botones redes sociales */

.social-media {
    width: 35px;
    height: 35px;
    background:white;
    border-style:none;
    border-radius:50px;
    margin:5px;
}

.social-media a {
    color: #282D32;
}

.social-media:hover {
    opacity: 0.6;
    transition-duration: 0.5s;
}


/* Cambios en popover */

.popover-body {
    font-family: Verdana, sans-serif;
    font-size: 12px;
    text-align:justify;
}

.popover{
    max-width: 40%;
}


/* Modificación de link en el perfil de usuario individual */

.mp:hover {
    color: #fff;
}


/* Imagenes de perfil */

.image-size {
    width: 200px;
    height: 200px;
}


/* Modificación de link en apartado filtrar usuarios */

.link-profile:hover {
    color: #212529;
}


/* Modificación de link en apartado mensajería */

.alert-warning:hover {
    color: #856404;
}


/* Error en input */
.input-error {
    color: #dc3545;
}