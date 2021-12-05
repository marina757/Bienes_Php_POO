<?php


define('TEMPLATES_URL', __DIR__ . '/templates'); //__DIR__ es una superglobal para 
                                                 //que nos traiga ubicacion y sepa
                                                 // donde buscar los archivos
define('FUNCIONES_URL', __DIR__ . 'funciones.php');


function incluirTemplate( string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/${nombre}.php";     
}

function estaAutenticado() : bool {
    session_start();

    $auth = $_SESSION['login'];
    if ($auth) {
       return true; 
    }

    return false;   
}