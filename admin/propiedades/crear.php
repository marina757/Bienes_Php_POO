<?php

    require '../../includes/app.php'; 

    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();

    
    $db = conectarDB();

    $propiedad = new Propiedad;
    
    //CONSULTAR PARA OBTENER LOS VENDEDORES
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);
    
    //ARREGLO CON MENSAJES DE ERRORES
    $errores = Propiedad::getErrores();
    // debuguear($errores);

   
    //EJECUTA CODIGO DESPUES DE QUE USUARIO ENVIA FORMULARIO
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

        //CREA UNA NUEVA INSTANCIA
        $propiedad = new Propiedad($_POST);

        ////SUBIDA DE ARCHIVOS////
        //CREAR CARPETA
        

        //GENERAR UN NOMBRE UNICO
        $nombreImagen = md5( uniqid( rand(), true ) ). ".jpg";

        //SETEAR LA IMAGEN
        //REALIZA UN RESIZE A LA IMAGEN CON INTERVENTION
        if ($_FILES['imagen']['tmp_name']) {
            $image = Image::make($_FILES['imagen']['tmp_name'])->fit(800,600);
            $propiedad->setImagen($nombreImagen);
        }
        

        //VALIDAR
        $errores = $propiedad->validar();
  

        if (empty($errores)) {
           
            //CREAR CARPETA PARA SUBIR IMAGENES
            if(!is_dir(CARPETA_IMAGENES)) {
                mkdir(CARPETA_IMAGENES);
            }
            
            //GUARDA IMAGEN EN SERVIDOR
            $image->save(CARPETA_IMAGENES . $nombreImagen);

            //GUARDA EN LA BASE DE DATOS
            $resultado = $propiedad->guardar();
            
            //MENSAJE DE EXITO
            if ($resultado) {
                //REDIRECCIONAR AL USUARIO

                header('Location: /admin?resultado=1'); //header sirve pare redireccionar a un usuario,
                                            // para enviar datos por enmedio del encabezado 
                                            //de un stio web, de la peticion
            }    
        }
    }

       
    incluirTemplate('header'); 
?>

    <main class="contenedor seccion">
        <h1>Crear</h1>

        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach ($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>            
        <?php endforeach; ?>

        <form class="formulario" method="POST" action="/admin/propiedades/crear.php" enctype="multipart/form-data">
           <?php include '../../includes/templates/formulario_propiedades.php'; ?> 

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">
        </form>
    </main>

<?php
    incluirTemplate('footer');  
?>    