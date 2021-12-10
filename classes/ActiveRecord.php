<?php

namespace App;

class ActiveRecord {
    //BASE DE DATOS
    protected static $db;
    protected static $columnasDB = [];
    protected static $tabla = '';

     // ERRORES
     protected static $errores = [];

    
    //DEFINIR LA CONEXION A LA BASE DE DATOS
     public static function setDB($database) {
        self::$db = $database;
    }

    
    public function guardar() {
        if (!is_null($this->id)) {
            //actualizar
            $this->actualizar();
        }else{
            //creando nuevo registro
            $this->crear();
        }

    }

    public function crear() {

        //SANITIZAR DATOS
        $atributos = $this->sanitizarAtributos();
        
         //INSERTAR EN BASE DE DATOS
         $query = " INSERT INTO " . static::$tabla . " ( ";
         $query .= join(', ', array_keys($atributos));
         $query .= " ) VALUES ( ' ";
         $query .= join(" ', '", array_values($atributos));
         $query .= " ') ";

        $resultado = self::$db->query($query);
        //MENSAJE DE EXITO
        if ($resultado) {
            //REDIRECCIONAR AL USUARIO
            header('Location: /admin?resultado=1'); 
        }  
    }

    public function actualizar() {
         //SANITIZAR DATOS
         $atributos = $this->sanitizarAtributos();

         $valores = [];
         foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
         }

         $query = " UPDATE " . static::$tabla .  " SET ";
         $query .= join(', ', $valores );
         $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
         $query .= "LIMIT 1 ";

        //  debuguear($query);

        $resultado = self::$db->query($query);
         if($resultado) {
            //REDIRECCIONAR AL USUARIO
            header('Location: /admin?resultado=2'); 
        } 
    }

     //Eliminar un registro
     public function eliminar() {
            $query = "DELETE FROM " . static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1";
            $resultado = self::$db->query($query);

            if($resultado) {
                $this->borrarImagen();
                header('location: /admin?resultado=3');    
              }
    }

    //IDENTIFICAR Y UNIR LOS ATRIBUTOS DE LA BD
    public function atributos() {
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
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
        //ELIMINA LA IMAGEN PREVIA
        if(!is_null($this->id)) {
            $this->borrarImagen();
        }


        //ASIGNAR AL ATRIBUTO DE IMAGEN EL NOMBRE DE LA IMAGEN
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Elimina archivo
    public function borrarImagen() {
        //COMPROBAR SI EXISTE ARCHIVO
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if ($existeArchivo) {
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
        //debuguear($existeArchivo);
    }

    //VALIDACION
    public static function getErrores() {
        return static::$errores;
    }

    public function validar() {
        static::$errores = [];
        return static::$errores;
    }

    //LISTA TODOS LOS REGISTROS
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;

        $resultado = self::consultarSQL($query);
        return $resultado;   
    }


    //BUSCA UN REGISTRO POR SU ID
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = ${id}";

        $resultado = self::consultarSQL($query);

        return array_shift( $resultado);
    }
         

    public static function consultarSQL($query) {
        //CONSULTAR BASE DE DATOS
        $resultado = self::$db->query($query);

        //ITERAR RESULTADOS
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        //LIBERAR LA MEMORIA
        $resultado->free();

        //RETORNAR LOS RESULTADOS
        return $array;

    }

    protected static function crearObjeto($registro) {
        $objeto = new static();

        foreach ($registro as $key => $value) {
            if( property_exists( $objeto, $key)) {
                $objeto->$key = $value;
            }
        }

     return $objeto;
    }

    //SINCRONIZA EL OBJETO EN MEMORIA CON CAMBIOS REALIZADOS POR USUARIO
    public function sincronizar( $args = [] ) {
        foreach ($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
}