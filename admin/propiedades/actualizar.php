<?php

use App\Propiedad;

require '../../includes/app.php';
    
    estaAutenticado();

    //VALIDAR URL POR ID VALIDO
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);
    // var_dump($id);

    if (!$id) {
        header('Location: /admin');
    }

    //OBTENER DATOS DE LA PROPIEDAD
    $propiedad = Propiedad::find($id);


    //CONSULTAR PARA OBTENER LOS VENDEDORES
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);
    
    
    // var_dump($db);

    // echo "<pre>";
    // var_dump($_SERVER); //Contiene info del servidor
    // echo "</pre>";

    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";

    //ARREGLO CON MENSAJES DE ERRORES
    $errores = [];

    $titulo = $propiedad->titulo;
    

    //EJECUTA CODIGO DESPUES DE QUE USUARIO ENVIA FORMULARIO
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        //ASIGNAR LOS ATRIBUTOS
        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);
        debuguear($propiedad);
         
        //ASIGNAR FILES HACIA UNA VARIABLE
        $imagen = $_FILES['imagen'];
        

        if (!$titulo) {
            $errores[] = "Debes poner un titulo";
        }

        if (!$precio) {
            $errores[] = "El precio es obligatorio";
        }

        if ( strlen( $descripcion ) < 50 ) {
            $errores[] = "La descripcion es obligatoria y debe tener al menos 50 caracteres";
        }

        if (!$habitaciones) {
            $errores[] = "El numero de habitaciones es obligatorio";
        }

        if (!$wc) {
            $errores[] = "El numero de wc es obligatorio";
        }

        if (!$estacionamiento) {
            $errores[] = "El numero de lugares de estableciemiento es obligatorio";
        }

        if (!$vendedorId) {
            $errores[] = "Elige un vendedor";
        }


        //VALIDAR POR TAMANO 1mb MAXIMO
        $medida = 1000 * 1000; //lo convierte de bytes a kb

        if ($imagen['size'] > $medida) {
            $errores[] = "La imagen es muy pesada";
        }

        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";
        
        // exit;

        //REVISAR QUE ARRAY DE ERRORES ESTE VACIO
        if (empty($errores)) {

              // //CREAR CARPETA
              $carpetaImagenes = '../../imagenes/';

              if (!is_dir($carpetaImagenes)) { //is_dir nos retorna si carpeta existe o no existe   
                  mkdir($carpetaImagenes);
              }

              $nombreImagen = '';

            ////////SUBIDA DE ARCHIVOS/////
            if ($imagen['name']) {
             //ELIMINAR LA IMAGEN PREVIA
             unlink($carpetaImagenes . $propiedad['imagen']);

              // //GENERAR UN NOMBRE UNICO
            $nombreImagen = md5( uniqid( rand(), true ) ). ".jpg";

              // //SUBIR IMAGEN
             move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
              // // exit;
            } else {
                $nombreImagen = $propiedad['imagen'];
            }

           
            //INSERTAR EN BASE DE DATOS
            $query = " UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = '${nombreImagen}', descripcion = '${descripcion}',
            habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedorId = ${vendedorId} WHERE 
            id = ${id} ";

            // echo $query;
             
            $resultado = mysqli_query($db, $query);

            if ($resultado) {
                //REDIRECCIONAR AL USUARIO

                header('Location: /admin?resultado=2'); //header sirve pare redireccionar a un usuario,
                                            // para enviar datos por enmedio del encabezado 
                                            //de un stio web, de la peticion
            }    
        }
    }

       
    incluirTemplate('header'); 
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>            
        <?php endforeach; ?>

        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php'; ?>    
        
            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">

        </form>
    </main>

<?php
    incluirTemplate('footer');  
?>     