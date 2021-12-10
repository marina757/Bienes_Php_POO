 <?php

//ARCHIVO PRINCIPAL: llama funciones, clases y bd
 require 'funciones.php';
 require 'config/database.php';
 require __DIR__ . '/../vendor/autoload.php';

 //CONECTARNOS A LA BASE DE DATOS
 $db = conectarDB();

 use App\ActiveRecord;

ActiveRecord::setDB($db);
  

