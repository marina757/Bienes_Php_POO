<?php

namespace App;

class Propiedad {
    //BASE DE DATOS
    protected static $db;

     //FORMA ANTERIOR A PHP8   
    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedorId;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? 'imagen.jpg';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? '';
    }

    public function guardar() {
         //INSERTAR EN BASE DE DATOS
         $query = " INSERT INTO propiedades (titulo, precio, imagen, descripcion,
         habitaciones, wc, estacionamiento, creado, vendedorId ) VALUES ( '$this->titulo',
         '$this->precio', '$this->imagen','$this->descripcion','$this->habitaciones','$this->wc','$this->estacionamiento', '$this->creado',
         '$this->vendedorId' ) ";

        $resultado = self::$db->query($query);
        debuguear($resultado);
    }

    //DEFINIR LA CONEXION A LA BASE DE DATOS
    public static function setDB($database) {
        self::$db = $database;
    }

}