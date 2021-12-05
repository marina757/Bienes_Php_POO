<?php


define('TEMPLATES_URL', __DIR__ . '/templates'); //__DIR__ es una superglobal para 
                                                 //que nos traiga ubicacion y sepa
                                                 // donde buscar los archivos
define('FUNCIONES_URL', __DIR__ . 'funciones.php');


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