<?php


define('TEMPLATES_URL', __DIR__ . '/templates'); //__DIR__ es una superglobal para 
                                                 //que nos traiga ubicacion y sepa
                                                 // donde buscar los archivos
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');


function incluirTemplate( string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/${nombre}.php";     
}

function estaAutenticado() {
    session_start();

    if (!$_SESSION['login']) {
       header('Location: /');
    }  
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";  
    exit;
}

//ESCAPA/SANITIZAR EL HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;

}

//VALIDAR TIPO DE CONTENIDO
function validarTipoContenido($tipo) {
    $tipos = ['vendedor', 'propiedad'];

    return in_array($tipo, $tipos); 
}