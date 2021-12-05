<?php

function conectarDB() : mysqli {
    $db = new mysqli('localhost', 'root', '', 'bienes_php');


    // if ($db) {
    //     echo "se conecto";
    // } else {
    //     echo "no se conecto";
    // }

    if (!$db) {
        echo "error no se pudo conectar";
        exit;
    }
    
    return $db;
}