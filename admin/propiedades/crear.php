<?php

    require '../../includes/app.php'; 

    use App\Propiedad;
    use Intervention\Image\ImageManagerStatic as Image;

    estaAutenticado();

    
    $db = conectarDB();
    
    //CONSULTAR PARA OBTENER LOS VENDEDORES
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);
    
    //ARREGLO CON MENSAJES DE ERRORES
    $errores = Propiedad::getErrores();
    // debuguear($errores);

    $titulo = '';
    $precio = '';
    $descripcion = '';
    $habitaciones = '';
    $wc ='';
    $estacionamiento = '';
    $vendedorId = '';
    $creado = date('Y/m/d');

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
            <fieldset>
                <legend>Informacion General</legend>

                <label for="titulo">Titulo:</label>
                <input type="text" id="titulo" name="titulo" placeholder="Titulo Propiedad" value="<?php echo $titulo; ?>">

                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" placeholder="Precio Propiedad" value="<?php echo $precio; ?>">

                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" accept="image/jpeg, image/png" name="imagen">

                <label for="descripcion">Descripcion:</label> 
                <textarea id="descripcion" name="descripcion"><?php echo $descripcion; ?></textarea>
            </fieldset>

            <fieldset>
                <legend>Informacion Propiedad</legend>

                <label for="habitaciones">Habitaciones:</label>
                <input type="number" id="habitaciones" name="habitaciones" placeholder="Ej: 3" min="1" max="9" value="<?php echo $habitaciones; ?>">

                <label for="wc">Banos:</label>
                <input type="number" id="wc" name="wc" placeholder="Ej: 3" min="1" max="9" value="<?php echo $wc; ?>">

                <label for="estacionamiento">Estacionamiento:</label>
                <input type="number" id="estacionamiento" name="estacionamiento" placeholder="Ej: 3" min="1" max="9" value="<?php echo $estacionamiento; ?>">
            </fieldset>

            <fieldset>
                <legend>Vendedor</legend>

                <select name="vendedorId">
                    <option value="">-- Seleccione --</option>
                    <?php while ($vendedor = mysqli_fetch_assoc($resultado) ):  ?>
                        <option <?php echo $vendedorId === $vendedor['id'] ? 'selected' : ''; ?>  value="<?php echo $vendedor['id']; ?>"> <?php echo $vendedor['nombre'] . " " . $vendedor['apellido']; ?></option>
                    <?php endwhile; ?>
                    
                    
                    <!-- EJEMPLO PARA POCOS VENDEDORES
                    <option value="1">Marina</option>
                    <option value="2">Karen</option>
                     -->
                </select>
            </fieldset>

            <input type="submit" value="Crear Propiedad" class="boton boton-verde">

        </form>
    </main>

<?php
    incluirTemplate('footer');  
?>    