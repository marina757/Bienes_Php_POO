<?php

namespace App;

class Propiedad {
    //BASE DE DATOS
    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion',
     'habitaciones', 'wc', 'estacionamiento', 'creado', 'vendedorId'];

     // ERRORES
     protected static $errores = [];

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

    //DEFINIR LA CONEXION A LA BASE DE DATOS
     public static function setDB($database) {
        self::$db = $database;
    }

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedorId = $args['vendedorId'] ?? 1;
    }

    public function guardar() {

        //SANITIZAR DATOS
        $atributos = $this->sanitizarAtributos();
        
         //INSERTAR EN BASE DE DATOS
         $query = " INSERT INTO propiedades (";
         $query .= join(', ', array_keys($atributos));
         $query .= " ) VALUES ( ' ";
         $query .= join(" ', '", array_values($atributos));
         $query .= " ') ";

        $resultado = self::$db->query($query);
        return $resultado;
    }

    //IDENTIFICAR Y UNIR LOS ATRIBUTOS DE LA BD
    public function atributos() {
        $atributos = [];
        foreach(self::$columnasDB as $columna) {
            if($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }


    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];

        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = self::$db->escape_string($value);
        }

       return $sanitizado;
    }
    //SUBIDA DE ARCHIVOS
    public function setImagen($imagen) {
        //ASIGNAR AL ATRIBUTO DE IMAGEN EL NOMBRE DE LA IMAGEN
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //VALIDACION
    public static function getErrores() {
        return self::$errores;
    }

    public function validar() {

        if (!$this->titulo) {
            self::$errores[] = "Debes poner un titulo";
        }

        if (!$this->precio) {
            self::$errores[] = "El precio es obligatorio";
        }

        if ( strlen( $this->descripcion ) < 50 ) {
            self::$errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }

        if (!$this->habitaciones) {
            self::$errores[] = "El numero de habitaciones es obligatorio";
        }

        if (!$this->wc) {
            self::$errores[] = "El numero de wc es obligatorio";
        }

        if (!$this->estacionamiento) {
            self::$errores[] = "El numero de lugares de estableciemiento es obligatorio";
        }

        if (!$this->vendedorId) {
            self::$errores[] = "Elige un vendedor";
        }

        if (!$this->imagen){
            self:: $errores[] = "la imagen es obligatoria";
        }

        return self::$errores;
    }

    //LISTA TODAS LAS PROPIEDADES
    public static function all() {
        $query = "SELECT * FROM propiedades";

        $resultado = self::consultarSQL($query);
        return $resultado;   
    }

    public static function consultarSQL($query) {
        //CONSULTAR BASE DE DATOS
        $resultado = self::$db->query($query);

        //ITERAR RESULTADOS
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = self::crearObjeto($registro);
        }

        //LIBERAR LA MEMORIA
        $resultado->free();

        //RETORNAR LOS RESULTADOS
        return $array;

    }

    protected static function crearObjeto($registro) {
        $objeto = new self;

        foreach ($registro as $key => $value) {
            if( property_exists( $objeto, $key)) {
                $objeto->$key = $value;
            }
        }

     return $objeto;
    }
}