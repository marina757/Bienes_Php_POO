<?php

use App\Propiedad;
use Intervention\Image\ImageManagerStatic as Image;

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
    $errores = Propiedad::getErrores();

    $titulo = $propiedad->titulo;
    

    //EJECUTA CODIGO DESPUES DE QUE USUARIO ENVIA FORMULARIO
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        //ASIGNAR LOS ATRIBUTOS
        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);
       
        //VALIDACION 
        $errores = $propiedad->validar();

        //SUBIDA DE ARCHIVOS
        //GENERAR UN NOMBRE UNICO
        $nombreImagen = md5( uniqid( rand(), true ) ). ".jpg";

        if($_FILES['propiedad']['tmp_name']['imagen']) {
            $image = Image::make($_FILES['propiedad']['tmp_name']['imagen'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }
        
        //REVISAR QUE ARRAY DE ERRORES ESTE VACIO
        if (empty($errores)) {
            //Almacenar imagen
           $image->save(CARPETA_IMAGENES . $nombreImagen);
           $propiedad->guardar();
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